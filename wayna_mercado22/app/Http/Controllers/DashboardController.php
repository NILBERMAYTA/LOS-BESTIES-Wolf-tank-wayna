<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Donacion;
use App\Models\Emprendedor;
use App\Models\PaymentMethod;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            return $this->admin(request());
        }

        if ($user->isEmprendedor()) {
            return $this->emprendedor();
        }

        return $this->cliente();
    }

    public function admin(Request $request)
    {
        $this->authorizeAdmin();

        $metrics = $this->buildAdminMetrics($request);

        return view('dashboard.admin', array_merge($metrics, [
            'startDateString' => $metrics['startDate']->format('Y-m-d'),
            'endDateString' => $metrics['endDate']->format('Y-m-d'),
        ]));
    }

    public function exportMetrics(Request $request, $format = 'csv')
    {
        $this->authorizeAdmin();

        $metrics = $this->buildAdminMetrics($request);
        $startDate = $metrics['startDate'];
        $endDate = $metrics['endDate'];

        $format = strtolower($format) === 'xls' ? 'xls' : 'csv';
        $extension = $format === 'xls' ? 'xls' : 'csv';
        $contentType = $format === 'xls'
            ? 'application/vnd.ms-excel'
            : 'text/csv';
        $filename = "metricas_ventas_donaciones_{$startDate->format('Ymd')}_{$endDate->format('Ymd')}.$extension";

        $handle = fopen('php://memory', 'r+');

        fputcsv($handle, ['Reporte Wayna - Ventas y Donaciones']);
        fputcsv($handle, ['Periodo', $startDate->format('d/m/Y'), 'a', $endDate->format('d/m/Y')]);
        fputcsv($handle, []);
        fputcsv($handle, ['Métricas generales']);
        fputcsv($handle, ['Total pedidos', $metrics['totalPedidos']]);
        fputcsv($handle, ['Total donaciones', $metrics['totalDonaciones']]);
        fputcsv($handle, ['Total ventas', number_format($metrics['totalVentas'], 2)]);
        fputcsv($handle, ['Total donaciones Bs.', number_format($metrics['totalMontoDonaciones'], 2)]);
        fputcsv($handle, ['Ingreso Wayna', number_format($metrics['ingresosWayna'], 2)]);
        fputcsv($handle, []);
        fputcsv($handle, ['Top emprendedores por ventas']);
        fputcsv($handle, ['Posición', 'Emprendimiento', 'Ventas totales', 'Unidades vendidas']);
        foreach ($metrics['topEmprendedoresVentas'] as $index => $emprendedor) {
            fputcsv($handle, [
                $index + 1,
                $emprendedor->nombre_emprendimiento,
                number_format($emprendedor->ventas_totales, 2),
                $emprendedor->unidades_vendidas,
            ]);
        }
        fputcsv($handle, []);
        fputcsv($handle, ['Top emprendedores por donaciones']);
        fputcsv($handle, ['Posición', 'Emprendimiento', 'Total donado', 'Cantidad de donaciones']);
        foreach ($metrics['topEmprendedoresDonaciones'] as $index => $emprendedor) {
            fputcsv($handle, [
                $index + 1,
                $emprendedor->nombre_emprendimiento,
                number_format($emprendedor->monto_total, 2),
                $emprendedor->donaciones_count,
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => $contentType,
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    private function buildAdminMetrics(Request $request): array
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();

        $pedidoQuery = Pedido::whereBetween('fecha_pedido', [$startDate, $endDate]);
        $donacionQuery = Donacion::whereBetween('fecha_donacion', [$startDate, $endDate]);

        $totalPedidos = (clone $pedidoQuery)->count();
        $totalVentas = (clone $pedidoQuery)->sum('total');
        $ingresosWayna = (clone $pedidoQuery)->sum('comision_plataforma');
        $totalDonaciones = (clone $donacionQuery)->count();
        $totalMontoDonaciones = (clone $donacionQuery)->sum('monto');

        $topEmprendedoresVentas = Emprendedor::select([
                'emprendedores.id_emprendedor',
                'emprendedores.nombre_emprendimiento',
            ])
            ->join('productos', 'productos.id_emprendedor', '=', 'emprendedores.id_emprendedor')
            ->join('detalle_pedido', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->join('pedidos', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->whereBetween('pedidos.fecha_pedido', [$startDate, $endDate])
            ->selectRaw('SUM(detalle_pedido.subtotal) as ventas_totales, SUM(detalle_pedido.cantidad) as unidades_vendidas')
            ->groupBy('emprendedores.id_emprendedor', 'emprendedores.nombre_emprendimiento')
            ->orderByDesc('ventas_totales')
            ->limit(5)
            ->get();

        $topEmprendedoresDonaciones = Emprendedor::select([
                'emprendedores.id_emprendedor',
                'emprendedores.nombre_emprendimiento',
            ])
            ->join('donaciones', 'donaciones.id_emprendedor', '=', 'emprendedores.id_emprendedor')
            ->whereBetween('donaciones.fecha_donacion', [$startDate, $endDate])
            ->selectRaw('SUM(donaciones.monto) as monto_total, COUNT(donaciones.id_donacion) as donaciones_count')
            ->groupBy('emprendedores.id_emprendedor', 'emprendedores.nombre_emprendimiento')
            ->orderByDesc('monto_total')
            ->limit(5)
            ->get();

        return [
            'totalUsuarios' => User::count(),
            'totalEmprendedores' => Emprendedor::count(),
            'totalProductos' => Producto::count(),
            'totalPedidos' => $totalPedidos,
            'totalDonaciones' => $totalDonaciones,
            'totalMetodos' => PaymentMethod::count(),
            'totalVentas' => $totalVentas,
            'totalMontoDonaciones' => $totalMontoDonaciones,
            'ingresosWayna' => $ingresosWayna,
            'topEmprendedoresVentas' => $topEmprendedoresVentas,
            'topEmprendedoresDonaciones' => $topEmprendedoresDonaciones,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    }

    public function emprendedor()
    {
        $user = Auth::user();
        $emprendedor = $user->emprendedor;
        $productoIds = $emprendedor ? $emprendedor->productos->pluck('id_producto')->toArray() : [];

        $totalProductos = count($productoIds);
        $totalVentas = $productoIds ? DetallePedido::whereIn('id_producto', $productoIds)->sum('subtotal') : 0;
        $totalUnidadesVendidas = $productoIds ? DetallePedido::whereIn('id_producto', $productoIds)->sum('cantidad') : 0;
        $totalDonaciones = $emprendedor ? Donacion::where('id_emprendedor', $emprendedor->id_emprendedor)->sum('monto') : 0;
        $productosActivos = $emprendedor ? $emprendedor->productosActivos()->count() : 0;

        return view('emprendedor.dashboard', compact(
            'emprendedor',
            'totalProductos',
            'productosActivos',
            'totalVentas',
            'totalUnidadesVendidas',
            'totalDonaciones'
        ));
    }

    public function cliente()
    {
        return view('dashboard.cliente');
    }

    public function adminPedidos()
    {
        $this->authorizeAdmin();

        $pedidos = Pedido::with(['cliente', 'detalles.producto'])
            ->orderBy('fecha_pedido', 'desc')
            ->paginate(20);

        $totalVentas = Pedido::sum('total');
        $totalComision = Pedido::sum('comision_plataforma');

        return view('dashboard.admin-pedidos', compact('pedidos', 'totalVentas', 'totalComision'));
    }

    public function adminDonaciones()
    {
        $this->authorizeAdmin();

        $donaciones = Donacion::with(['cliente', 'emprendedor'])
            ->orderBy('fecha_donacion', 'desc')
            ->paginate(20);

        $totalDonaciones = Donacion::sum('monto');

        return view('dashboard.admin-donaciones', compact('donaciones', 'totalDonaciones'));
    }

    public function showPedido($id)
    {
        $this->authorizeAdmin();

        $pedido = Pedido::with(['cliente', 'detalles.producto'])->findOrFail($id);
        return view('dashboard.admin-pedido-detail', compact('pedido'));
    }

    public function showDonacion($id)
    {
        $this->authorizeAdmin();

        $donacion = Donacion::with(['cliente', 'emprendedor'])->findOrFail($id);
        return view('dashboard.admin-donacion-detail', compact('donacion'));
    }

    private function authorizeAdmin(): void
    {
        /** @var User|null $user */
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403, 'Acceso restringido.');
    }
}
