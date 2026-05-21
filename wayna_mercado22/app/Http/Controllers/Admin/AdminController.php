<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected function authorizeAdmin(): void
    {
        /** @var User|null $user */
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403, 'Acceso restringido.');
    }
}
