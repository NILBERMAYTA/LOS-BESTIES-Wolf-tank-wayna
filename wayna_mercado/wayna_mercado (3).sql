-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2026 a las 05:51:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wayna_mercado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compras`
--

CREATE TABLE `carrito_compras` (
  `id_carrito` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL CHECK (`cantidad` > 0),
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen_categoria` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `slug`, `descripcion`, `imagen_categoria`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Gastronomía', 'gastronomia', 'Productos alimenticios tradicionales', NULL, 1, '2026-05-16 03:51:26', '2026-05-16 03:51:26'),
(2, 'Cosmética Natural', 'cosmetica-natural', 'Productos de belleza artesanales', NULL, 1, '2026-05-16 03:51:26', '2026-05-16 03:51:26'),
(3, 'Artesanía', 'artesania', 'Arte y manualidades tradicionales', NULL, 1, '2026-05-16 03:51:26', '2026-05-16 03:51:26'),
(4, 'Textiles', 'textiles', 'Ropa y tejidos andinos', NULL, 1, '2026-05-16 03:51:26', '2026-05-16 03:51:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `nacionalidad` varchar(80) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `prefiere_idioma` enum('es','en') NOT NULL DEFAULT 'es',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` bigint(20) UNSIGNED NOT NULL,
  `id_pedido` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL CHECK (`cantidad` > 0),
  `precio_unitario` decimal(12,2) NOT NULL CHECK (`precio_unitario` >= 0),
  `subtotal` decimal(12,2) NOT NULL CHECK (`subtotal` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE `donaciones` (
  `id_donacion` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_emprendedor` bigint(20) UNSIGNED NOT NULL,
  `monto` decimal(10,2) NOT NULL CHECK (`monto` > 0),
  `mensaje_apoyo` text DEFAULT NULL,
  `estado` enum('pendiente','confirmada','rechazada') NOT NULL DEFAULT 'pendiente',
  `fecha_donacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emprendedores`
--

CREATE TABLE `emprendedores` (
  `id_emprendedor` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `nombre_emprendimiento` varchar(150) NOT NULL,
  `slug_emprendimiento` varchar(160) NOT NULL,
  `descripcion_emprendimiento` text DEFAULT NULL,
  `biografia` text DEFAULT NULL COMMENT 'Historia de vida del emprendedor (storytelling)',
  `frase_impacto` varchar(255) DEFAULT NULL COMMENT 'Frase que refleja el sentimiento del emprendedor',
  `video_url` varchar(255) DEFAULT NULL COMMENT 'URL del video de presentación (YouTube)',
  `foto_perfil` varchar(255) DEFAULT NULL,
  `foto_portada` varchar(255) DEFAULT NULL,
  `categoria` enum('gastronomia','cosmetica','artesania','textiles','otros') NOT NULL DEFAULT 'otros',
  `ubicacion` varchar(150) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `estado_validacion` enum('pendiente','aprobado','rechazado') NOT NULL DEFAULT 'pendiente',
  `fecha_solicitud` timestamp NULL DEFAULT current_timestamp(),
  `fecha_validacion` timestamp NULL DEFAULT NULL,
  `id_admin_validador` bigint(20) UNSIGNED DEFAULT NULL,
  `comentario_rechazo` varchar(255) DEFAULT NULL COMMENT 'Motivo si fue rechazado',
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `emprendedores`
--
DELIMITER $$
CREATE TRIGGER `notificar_admin_nuevo_emprendedor` AFTER INSERT ON `emprendedores` FOR EACH ROW BEGIN
    INSERT INTO notificaciones_admin (id_admin, id_emprendedor, tipo, mensaje)
    SELECT id_usuario, NEW.id_emprendedor, 'nuevo_registro', 
           CONCAT('Nuevo emprendedor registrado: ', NEW.nombre_emprendimiento, ' - Espera validación')
    FROM usuarios 
    WHERE id_rol = 1 AND estado = 'activo';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id_favorito` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_stock`
--

CREATE TABLE `historial_stock` (
  `id_historial` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `cantidad_anterior` int(11) NOT NULL,
  `cantidad_nueva` int(11) NOT NULL,
  `tipo_cambio` enum('venta','ajuste','devolucion','compra') NOT NULL,
  `referencia_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'ID del pedido o ajuste relacionado',
  `observaciones` varchar(255) DEFAULT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id_metodo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL COMMENT 'Ej: Yape, Plin, Transferencia',
  `codigo` varchar(50) NOT NULL COMMENT 'Código único: YAPE, PLIN, TRANSFERENCIA',
  `descripcion` text DEFAULT NULL,
  `instrucciones` text DEFAULT NULL COMMENT 'Instrucciones para el cliente',
  `qr_code` varchar(255) DEFAULT NULL COMMENT 'URL del código QR',
  `numero_cuenta` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id_metodo`, `nombre`, `codigo`, `descripcion`, `instrucciones`, `qr_code`, `numero_cuenta`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Yape', 'YAPE', 'Pago a través de Yape (BCP)', NULL, NULL, NULL, 1, '2026-05-16 03:51:27', '2026-05-16 03:51:27'),
(2, 'Plin', 'PLIN', 'Pago a través de Plin (Interbank)', NULL, NULL, NULL, 1, '2026-05-16 03:51:27', '2026-05-16 03:51:27'),
(3, 'Transferencia Bancaria', 'TRANSFERENCIA', 'Transferencia a cuenta bancaria', NULL, NULL, NULL, 1, '2026-05-16 03:51:27', '2026-05-16 03:51:27'),
(4, 'Efectivo', 'EFECTIVO', 'Pago en efectivo', NULL, NULL, NULL, 1, '2026-05-16 03:51:27', '2026-05-16 03:51:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('pedido','producto','donacion','sistema','reseña') NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `link` varchar(255) DEFAULT NULL COMMENT 'URL a la que lleva la notificación',
  `leida` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones_admin`
--

CREATE TABLE `notificaciones_admin` (
  `id_notificacion` bigint(20) UNSIGNED NOT NULL,
  `id_admin` bigint(20) UNSIGNED NOT NULL,
  `id_emprendedor` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('nuevo_registro','actualizacion','consulta') NOT NULL DEFAULT 'nuevo_registro',
  `mensaje` varchar(255) NOT NULL,
  `leida` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado_pedido` enum('pendiente','confirmado','pagado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `tipo` enum('compra','donacion') NOT NULL DEFAULT 'compra',
  `subtotal` decimal(12,2) NOT NULL CHECK (`subtotal` >= 0),
  `total` decimal(12,2) NOT NULL CHECK (`total` >= 0),
  `metodo_pago` varchar(50) NOT NULL DEFAULT 'QR',
  `id_metodo_pago` int(11) DEFAULT NULL,
  `comprobante_pago` varchar(255) DEFAULT NULL COMMENT 'URL del comprobante subido por el cliente',
  `comision_plataforma` decimal(12,2) DEFAULT 0.00,
  `total_emprendedor` decimal(12,2) DEFAULT 0.00,
  `notas` text DEFAULT NULL,
  `fecha_pago` timestamp NULL DEFAULT NULL,
  `fecha_confirmacion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `pedidos`
--
DELIMITER $$
CREATE TRIGGER `actualizar_stock_pedido` AFTER UPDATE ON `pedidos` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_id_producto BIGINT UNSIGNED;
    DECLARE v_cantidad INT;
    DECLARE cur CURSOR FOR 
        SELECT id_producto, cantidad 
        FROM detalle_pedido 
        WHERE id_pedido = NEW.id_pedido;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    IF NEW.estado_pedido = 'confirmado' AND OLD.estado_pedido != 'confirmado' THEN
        OPEN cur;
        read_loop: LOOP
            FETCH cur INTO v_id_producto, v_cantidad;
            IF done THEN
                LEAVE read_loop;
            END IF;
            
            UPDATE productos 
            SET stock = stock - v_cantidad,
                estado = CASE 
                    WHEN (stock - v_cantidad) <= 0 THEN 'agotado'
                    ELSE estado
                END
            WHERE id_producto = v_id_producto;
            
            INSERT INTO historial_stock (id_producto, cantidad_anterior, cantidad_nueva, tipo_cambio, referencia_id)
            SELECT v_id_producto, stock + v_cantidad, stock, 'venta', NEW.id_pedido
            FROM productos 
            WHERE id_producto = v_id_producto;
        END LOOP;
        CLOSE cur;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `verificar_stock_antes_confirmar` BEFORE UPDATE ON `pedidos` FOR EACH ROW BEGIN
    DECLARE v_stock_insuficiente BOOLEAN DEFAULT FALSE;
    DECLARE v_id_producto BIGINT UNSIGNED;
    DECLARE v_cantidad INT;
    DECLARE v_stock_actual INT;
    DECLARE done INT DEFAULT FALSE;
    DECLARE cur CURSOR FOR 
        SELECT id_producto, cantidad 
        FROM detalle_pedido 
        WHERE id_pedido = NEW.id_pedido;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    IF NEW.estado_pedido = 'confirmado' AND OLD.estado_pedido != 'confirmado' THEN
        OPEN cur;
        read_loop: LOOP
            FETCH cur INTO v_id_producto, v_cantidad;
            IF done THEN
                LEAVE read_loop;
            END IF;
            
            SELECT stock INTO v_stock_actual 
            FROM productos 
            WHERE id_producto = v_id_producto;
            
            IF v_cantidad > v_stock_actual THEN
                SET v_stock_insuficiente = TRUE;
            END IF;
        END LOOP;
        CLOSE cur;
        
        IF v_stock_insuficiente THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'No hay suficiente stock para confirmar el pedido';
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_productos`
--

CREATE TABLE `preguntas_productos` (
  `id_pregunta` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_emprendedor_responde` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Quién responde (emprendedor)',
  `pregunta` text NOT NULL,
  `respuesta` text DEFAULT NULL,
  `fecha_pregunta` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_respuesta` timestamp NULL DEFAULT NULL,
  `publico` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Visible para todos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `preguntas_productos`
--
DELIMITER $$
CREATE TRIGGER `notificar_nueva_pregunta` AFTER INSERT ON `preguntas_productos` FOR EACH ROW BEGIN
    DECLARE v_id_emprendedor BIGINT UNSIGNED;
    DECLARE v_id_usuario_emprendedor BIGINT UNSIGNED;
    
    SELECT p.id_emprendedor INTO v_id_emprendedor
    FROM productos p
    WHERE p.id_producto = NEW.id_producto;
    
    SELECT id_usuario INTO v_id_usuario_emprendedor
    FROM emprendedores
    WHERE id_emprendedor = v_id_emprendedor;
    
    INSERT INTO notificaciones (id_usuario, tipo, titulo, mensaje, link)
    VALUES (
        v_id_usuario_emprendedor, 
        'producto', 
        'Nueva pregunta en tu producto', 
        CONCAT('Un cliente ha hecho una pregunta sobre tu producto.'),
        CONCAT('/emprendedor/preguntas/', NEW.id_pregunta)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `id_emprendedor` bigint(20) UNSIGNED NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `descripcion_corta` varchar(255) DEFAULT NULL,
  `descripcion_larga` text DEFAULT NULL,
  `precio` decimal(12,2) NOT NULL CHECK (`precio` >= 0),
  `stock` int(11) NOT NULL DEFAULT 0 CHECK (`stock` >= 0),
  `stock_minimo` int(11) NOT NULL DEFAULT 3 CHECK (`stock_minimo` >= 0),
  `imagen_principal` varchar(255) DEFAULT NULL,
  `estado` enum('activo','agotado','oculto') NOT NULL DEFAULT 'activo',
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `calificacion_promedio` decimal(2,1) DEFAULT 0.0,
  `total_reseñas` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `id_imagen` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `url_imagen` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `principal` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `id_reseña` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `calificacion` tinyint(1) NOT NULL CHECK (`calificacion` between 1 and 5),
  `titulo` varchar(150) DEFAULT NULL,
  `comentario` text NOT NULL,
  `fotos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Almacena URLs de fotos como JSON' CHECK (json_valid(`fotos`)),
  `aprobado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Admin debe aprobar reseñas',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_aprobacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `reseñas`
--
DELIMITER $$
CREATE TRIGGER `actualizar_calificacion_producto` AFTER INSERT ON `reseñas` FOR EACH ROW BEGIN
    IF NEW.aprobado = 1 THEN
        UPDATE productos p
        SET 
            p.calificacion_promedio = (
                SELECT ROUND(AVG(r.calificacion), 1)
                FROM reseñas r
                WHERE r.id_producto = NEW.id_producto AND r.aprobado = 1
            ),
            p.total_reseñas = (
                SELECT COUNT(*)
                FROM reseñas r
                WHERE r.id_producto = NEW.id_producto AND r.aprobado = 1
            )
        WHERE p.id_producto = NEW.id_producto;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion`) VALUES
(1, 'Admin', 'Administrador del sistema - valida emprendedores y gestiona todo'),
(2, 'Emprendedor', 'Joven emprendedor que registra su negocio y espera validación'),
(3, 'Cliente', 'Usuario normal que ve productos, compra y dona');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `estado` enum('activo','inactivo','suspendido') NOT NULL DEFAULT 'activo',
  `ultimo_acceso` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas_productos`
--

CREATE TABLE `visitas_productos` (
  `id_visita` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'NULL si es visitante no logueado',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `fecha_visita` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_emprendedores_pendientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_emprendedores_pendientes` (
`id_emprendedor` bigint(20) unsigned
,`id_usuario` bigint(20) unsigned
,`nombre_emprendimiento` varchar(150)
,`slug_emprendimiento` varchar(160)
,`descripcion_emprendimiento` text
,`biografia` text
,`frase_impacto` varchar(255)
,`video_url` varchar(255)
,`foto_perfil` varchar(255)
,`foto_portada` varchar(255)
,`categoria` enum('gastronomia','cosmetica','artesania','textiles','otros')
,`ubicacion` varchar(150)
,`latitud` decimal(10,8)
,`longitud` decimal(11,8)
,`estado_validacion` enum('pendiente','aprobado','rechazado')
,`fecha_solicitud` timestamp
,`fecha_validacion` timestamp
,`comentario_rechazo` varchar(255)
,`verificado` tinyint(1)
,`created_at` timestamp
,`updated_at` timestamp
,`nombre` varchar(100)
,`apellido` varchar(100)
,`email` varchar(150)
,`telefono` varchar(30)
,`dias_espera` int(7)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_estadisticas_emprendedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_estadisticas_emprendedor` (
`id_emprendedor` bigint(20) unsigned
,`nombre_emprendimiento` varchar(150)
,`frase_impacto` varchar(255)
,`foto_perfil` varchar(255)
,`total_productos` bigint(21)
,`total_ventas` bigint(21)
,`ingresos_totales` decimal(34,2)
,`total_reseñas` bigint(21)
,`calificacion_promedio` decimal(7,4)
,`total_donaciones` bigint(21)
,`monto_donaciones` decimal(32,2)
,`preguntas_recibidas` bigint(21)
,`preguntas_respondidas` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_productos_aprobados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_productos_aprobados` (
`id_producto` bigint(20) unsigned
,`id_emprendedor` bigint(20) unsigned
,`id_categoria` int(11)
,`nombre_producto` varchar(150)
,`slug` varchar(200)
,`descripcion_corta` varchar(255)
,`descripcion_larga` text
,`precio` decimal(12,2)
,`stock` int(11)
,`stock_minimo` int(11)
,`imagen_principal` varchar(255)
,`estado` enum('activo','agotado','oculto')
,`destacado` tinyint(1)
,`calificacion_promedio` decimal(2,1)
,`total_reseñas` int(11)
,`created_at` timestamp
,`updated_at` timestamp
,`nombre_emprendimiento` varchar(150)
,`slug_emprendimiento` varchar(160)
,`biografia` text
,`frase_impacto` varchar(255)
,`video_url` varchar(255)
,`foto_perfil` varchar(255)
,`nombre_categoria` varchar(100)
,`alerta_stock` varchar(12)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_productos_mas_vistos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_productos_mas_vistos` (
`id_producto` bigint(20) unsigned
,`nombre_producto` varchar(150)
,`precio` decimal(12,2)
,`imagen_principal` varchar(255)
,`nombre_emprendimiento` varchar(150)
,`total_visitas` bigint(21)
,`calificacion_promedio` decimal(2,1)
,`total_reseñas` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_top_emprendedores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_top_emprendedores` (
`id_emprendedor` bigint(20) unsigned
,`nombre_emprendimiento` varchar(150)
,`frase_impacto` varchar(255)
,`foto_perfil` varchar(255)
,`total_ventas` bigint(21)
,`monto_ventas` decimal(34,2)
,`total_donaciones` bigint(21)
,`monto_donaciones` decimal(32,2)
,`ingreso_total` decimal(35,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_ultimas_reseñas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_ultimas_reseñas` (
`id_reseña` bigint(20) unsigned
,`calificacion` tinyint(1)
,`titulo` varchar(150)
,`comentario` text
,`fecha_creacion` timestamp
,`nombre_producto` varchar(150)
,`id_producto` bigint(20) unsigned
,`nombre_emprendimiento` varchar(150)
,`nombre_cliente` varchar(201)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_emprendedores_pendientes`
--
DROP TABLE IF EXISTS `vista_emprendedores_pendientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_emprendedores_pendientes`  AS SELECT `e`.`id_emprendedor` AS `id_emprendedor`, `e`.`id_usuario` AS `id_usuario`, `e`.`nombre_emprendimiento` AS `nombre_emprendimiento`, `e`.`slug_emprendimiento` AS `slug_emprendimiento`, `e`.`descripcion_emprendimiento` AS `descripcion_emprendimiento`, `e`.`biografia` AS `biografia`, `e`.`frase_impacto` AS `frase_impacto`, `e`.`video_url` AS `video_url`, `e`.`foto_perfil` AS `foto_perfil`, `e`.`foto_portada` AS `foto_portada`, `e`.`categoria` AS `categoria`, `e`.`ubicacion` AS `ubicacion`, `e`.`latitud` AS `latitud`, `e`.`longitud` AS `longitud`, `e`.`estado_validacion` AS `estado_validacion`, `e`.`fecha_solicitud` AS `fecha_solicitud`, `e`.`fecha_validacion` AS `fecha_validacion`, `e`.`comentario_rechazo` AS `comentario_rechazo`, `e`.`verificado` AS `verificado`, `e`.`created_at` AS `created_at`, `e`.`updated_at` AS `updated_at`, `u`.`nombre` AS `nombre`, `u`.`apellido` AS `apellido`, `u`.`email` AS `email`, `u`.`telefono` AS `telefono`, to_days(current_timestamp()) - to_days(`e`.`fecha_solicitud`) AS `dias_espera` FROM (`emprendedores` `e` join `usuarios` `u` on(`e`.`id_usuario` = `u`.`id_usuario`)) WHERE `e`.`estado_validacion` = 'pendiente' ORDER BY `e`.`fecha_solicitud` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_estadisticas_emprendedor`
--
DROP TABLE IF EXISTS `vista_estadisticas_emprendedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_estadisticas_emprendedor`  AS SELECT `e`.`id_emprendedor` AS `id_emprendedor`, `e`.`nombre_emprendimiento` AS `nombre_emprendimiento`, `e`.`frase_impacto` AS `frase_impacto`, `e`.`foto_perfil` AS `foto_perfil`, count(distinct `p`.`id_producto`) AS `total_productos`, count(distinct `dp`.`id_pedido`) AS `total_ventas`, coalesce(sum(`dp`.`subtotal`),0) AS `ingresos_totales`, count(distinct `r`.`id_reseña`) AS `total_reseñas`, coalesce(avg(`r`.`calificacion`),0) AS `calificacion_promedio`, count(distinct `d`.`id_donacion`) AS `total_donaciones`, coalesce(sum(`d`.`monto`),0) AS `monto_donaciones`, count(distinct `q`.`id_pregunta`) AS `preguntas_recibidas`, count(distinct case when `q`.`respuesta` is not null then `q`.`id_pregunta` end) AS `preguntas_respondidas` FROM ((((((`emprendedores` `e` left join `productos` `p` on(`e`.`id_emprendedor` = `p`.`id_emprendedor`)) left join `detalle_pedido` `dp` on(`p`.`id_producto` = `dp`.`id_producto`)) left join `pedidos` `ped` on(`dp`.`id_pedido` = `ped`.`id_pedido` and `ped`.`estado_pedido` in ('confirmado','pagado','entregado'))) left join `reseñas` `r` on(`p`.`id_producto` = `r`.`id_producto` and `r`.`aprobado` = 1)) left join `donaciones` `d` on(`e`.`id_emprendedor` = `d`.`id_emprendedor` and `d`.`estado` = 'confirmada')) left join `preguntas_productos` `q` on(`p`.`id_producto` = `q`.`id_producto`)) WHERE `e`.`estado_validacion` = 'aprobado' GROUP BY `e`.`id_emprendedor`, `e`.`nombre_emprendimiento`, `e`.`frase_impacto`, `e`.`foto_perfil` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_productos_aprobados`
--
DROP TABLE IF EXISTS `vista_productos_aprobados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_productos_aprobados`  AS SELECT `p`.`id_producto` AS `id_producto`, `p`.`id_emprendedor` AS `id_emprendedor`, `p`.`id_categoria` AS `id_categoria`, `p`.`nombre_producto` AS `nombre_producto`, `p`.`slug` AS `slug`, `p`.`descripcion_corta` AS `descripcion_corta`, `p`.`descripcion_larga` AS `descripcion_larga`, `p`.`precio` AS `precio`, `p`.`stock` AS `stock`, `p`.`stock_minimo` AS `stock_minimo`, `p`.`imagen_principal` AS `imagen_principal`, `p`.`estado` AS `estado`, `p`.`destacado` AS `destacado`, `p`.`calificacion_promedio` AS `calificacion_promedio`, `p`.`total_reseñas` AS `total_reseñas`, `p`.`created_at` AS `created_at`, `p`.`updated_at` AS `updated_at`, `e`.`nombre_emprendimiento` AS `nombre_emprendimiento`, `e`.`slug_emprendimiento` AS `slug_emprendimiento`, `e`.`biografia` AS `biografia`, `e`.`frase_impacto` AS `frase_impacto`, `e`.`video_url` AS `video_url`, `e`.`foto_perfil` AS `foto_perfil`, `c`.`nombre_categoria` AS `nombre_categoria`, CASE WHEN `p`.`stock` <= `p`.`stock_minimo` THEN 'stock_bajo' WHEN `p`.`stock` = 0 THEN 'sin_stock' ELSE 'stock_normal' END AS `alerta_stock` FROM ((`productos` `p` join `emprendedores` `e` on(`p`.`id_emprendedor` = `e`.`id_emprendedor`)) join `categorias` `c` on(`p`.`id_categoria` = `c`.`id_categoria`)) WHERE `e`.`estado_validacion` = 'aprobado' AND `p`.`estado` in ('activo','agotado') AND `e`.`verificado` = 1 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_productos_mas_vistos`
--
DROP TABLE IF EXISTS `vista_productos_mas_vistos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_productos_mas_vistos`  AS SELECT `p`.`id_producto` AS `id_producto`, `p`.`nombre_producto` AS `nombre_producto`, `p`.`precio` AS `precio`, `p`.`imagen_principal` AS `imagen_principal`, `e`.`nombre_emprendimiento` AS `nombre_emprendimiento`, count(`v`.`id_visita`) AS `total_visitas`, `p`.`calificacion_promedio` AS `calificacion_promedio`, `p`.`total_reseñas` AS `total_reseñas` FROM ((`productos` `p` join `emprendedores` `e` on(`p`.`id_emprendedor` = `e`.`id_emprendedor`)) left join `visitas_productos` `v` on(`p`.`id_producto` = `v`.`id_producto`)) WHERE `e`.`estado_validacion` = 'aprobado' AND `p`.`estado` = 'activo' GROUP BY `p`.`id_producto`, `p`.`nombre_producto`, `p`.`precio`, `p`.`imagen_principal`, `e`.`nombre_emprendimiento`, `p`.`calificacion_promedio`, `p`.`total_reseñas` ORDER BY count(`v`.`id_visita`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_top_emprendedores`
--
DROP TABLE IF EXISTS `vista_top_emprendedores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_top_emprendedores`  AS SELECT `e`.`id_emprendedor` AS `id_emprendedor`, `e`.`nombre_emprendimiento` AS `nombre_emprendimiento`, `e`.`frase_impacto` AS `frase_impacto`, `e`.`foto_perfil` AS `foto_perfil`, count(distinct `dp`.`id_pedido`) AS `total_ventas`, sum(`dp`.`subtotal`) AS `monto_ventas`, count(distinct `d`.`id_donacion`) AS `total_donaciones`, coalesce(sum(`d`.`monto`),0) AS `monto_donaciones`, coalesce(sum(`dp`.`subtotal`),0) + coalesce(sum(`d`.`monto`),0) AS `ingreso_total` FROM ((((`emprendedores` `e` left join `productos` `p` on(`e`.`id_emprendedor` = `p`.`id_emprendedor`)) left join `detalle_pedido` `dp` on(`p`.`id_producto` = `dp`.`id_producto`)) left join `pedidos` `ped` on(`dp`.`id_pedido` = `ped`.`id_pedido` and `ped`.`estado_pedido` in ('confirmado','pagado','entregado'))) left join `donaciones` `d` on(`e`.`id_emprendedor` = `d`.`id_emprendedor` and `d`.`estado` = 'confirmada')) WHERE `e`.`estado_validacion` = 'aprobado' AND `e`.`verificado` = 1 GROUP BY `e`.`id_emprendedor`, `e`.`nombre_emprendimiento`, `e`.`frase_impacto`, `e`.`foto_perfil` ORDER BY coalesce(sum(`dp`.`subtotal`),0) + coalesce(sum(`d`.`monto`),0) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_ultimas_reseñas`
--
DROP TABLE IF EXISTS `vista_ultimas_reseñas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_ultimas_reseñas`  AS SELECT `r`.`id_reseña` AS `id_reseña`, `r`.`calificacion` AS `calificacion`, `r`.`titulo` AS `titulo`, `r`.`comentario` AS `comentario`, `r`.`fecha_creacion` AS `fecha_creacion`, `p`.`nombre_producto` AS `nombre_producto`, `p`.`id_producto` AS `id_producto`, `e`.`nombre_emprendimiento` AS `nombre_emprendimiento`, concat(`u`.`nombre`,' ',`u`.`apellido`) AS `nombre_cliente` FROM ((((`reseñas` `r` join `productos` `p` on(`r`.`id_producto` = `p`.`id_producto`)) join `emprendedores` `e` on(`p`.`id_emprendedor` = `e`.`id_emprendedor`)) join `clientes` `c` on(`r`.`id_cliente` = `c`.`id_cliente`)) join `usuarios` `u` on(`c`.`id_usuario` = `u`.`id_usuario`)) WHERE `r`.`aprobado` = 1 ORDER BY `r`.`fecha_creacion` DESC LIMIT 0, 10 ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD PRIMARY KEY (`id_carrito`),
  ADD UNIQUE KEY `uk_carrito_cliente_producto` (`id_cliente`,`id_producto`),
  ADD KEY `idx_carrito_cliente` (`id_cliente`),
  ADD KEY `idx_carrito_producto` (`id_producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `uk_categorias_slug` (`slug`),
  ADD KEY `idx_categorias_activo` (`activo`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `uk_clientes_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `idx_detalle_pedido` (`id_pedido`),
  ADD KEY `idx_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD PRIMARY KEY (`id_donacion`),
  ADD KEY `idx_donaciones_cliente` (`id_cliente`),
  ADD KEY `idx_donaciones_emprendedor` (`id_emprendedor`),
  ADD KEY `idx_donaciones_estado` (`estado`);

--
-- Indices de la tabla `emprendedores`
--
ALTER TABLE `emprendedores`
  ADD PRIMARY KEY (`id_emprendedor`),
  ADD UNIQUE KEY `uk_emprendedores_usuario` (`id_usuario`),
  ADD UNIQUE KEY `uk_emprendedores_slug` (`slug_emprendimiento`),
  ADD KEY `idx_emprendedores_estado` (`estado_validacion`),
  ADD KEY `idx_emprendedores_categoria` (`categoria`),
  ADD KEY `idx_emprendedores_verificado` (`verificado`),
  ADD KEY `idx_emprendedores_fecha_solicitud` (`fecha_solicitud`),
  ADD KEY `emprendedores_ibfk_2` (`id_admin_validador`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id_favorito`),
  ADD UNIQUE KEY `uk_favoritos_cliente_producto` (`id_cliente`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `historial_stock`
--
ALTER TABLE `historial_stock`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `idx_historial_producto` (`id_producto`),
  ADD KEY `idx_historial_fecha` (`fecha_cambio`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id_metodo`),
  ADD UNIQUE KEY `uk_metodos_codigo` (`codigo`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `idx_notificaciones_usuario` (`id_usuario`),
  ADD KEY `idx_notificaciones_leida` (`leida`),
  ADD KEY `idx_notificaciones_tipo` (`tipo`);

--
-- Indices de la tabla `notificaciones_admin`
--
ALTER TABLE `notificaciones_admin`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `idx_notificaciones_admin` (`id_admin`),
  ADD KEY `idx_notificaciones_emprendedor` (`id_emprendedor`),
  ADD KEY `idx_notificaciones_leida` (`leida`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `idx_pedidos_cliente` (`id_cliente`),
  ADD KEY `idx_pedidos_estado` (`estado_pedido`),
  ADD KEY `idx_pedidos_fecha` (`fecha_pedido`),
  ADD KEY `idx_pedidos_tipo` (`tipo`),
  ADD KEY `pedidos_ibfk_metodo_pago` (`id_metodo_pago`);

--
-- Indices de la tabla `preguntas_productos`
--
ALTER TABLE `preguntas_productos`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `idx_preguntas_producto` (`id_producto`),
  ADD KEY `idx_preguntas_cliente` (`id_cliente`),
  ADD KEY `idx_preguntas_respondidas` (`respuesta`(100)),
  ADD KEY `preguntas_productos_ibfk_3` (`id_emprendedor_responde`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `uk_productos_slug` (`slug`),
  ADD KEY `idx_productos_emprendedor` (`id_emprendedor`),
  ADD KEY `idx_productos_categoria` (`id_categoria`),
  ADD KEY `idx_productos_estado` (`estado`),
  ADD KEY `idx_productos_destacado` (`destacado`),
  ADD KEY `idx_productos_precio` (`precio`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `idx_imagenes_producto` (`id_producto`),
  ADD KEY `idx_imagenes_orden` (`orden`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id_reseña`),
  ADD KEY `idx_reseñas_producto` (`id_producto`),
  ADD KEY `idx_reseñas_cliente` (`id_cliente`),
  ADD KEY `idx_reseñas_calificacion` (`calificacion`),
  ADD KEY `idx_reseñas_aprobado` (`aprobado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `uk_roles_nombre` (`nombre_rol`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uk_usuarios_email` (`email`),
  ADD KEY `idx_usuarios_rol` (`id_rol`),
  ADD KEY `idx_usuarios_estado` (`estado`);

--
-- Indices de la tabla `visitas_productos`
--
ALTER TABLE `visitas_productos`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `idx_visitas_producto` (`id_producto`),
  ADD KEY `idx_visitas_cliente` (`id_cliente`),
  ADD KEY `idx_visitas_fecha` (`fecha_visita`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  MODIFY `id_carrito` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id_donacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `emprendedores`
--
ALTER TABLE `emprendedores`
  MODIFY `id_emprendedor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id_favorito` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_stock`
--
ALTER TABLE `historial_stock`
  MODIFY `id_historial` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones_admin`
--
ALTER TABLE `notificaciones_admin`
  MODIFY `id_notificacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas_productos`
--
ALTER TABLE `preguntas_productos`
  MODIFY `id_pregunta` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `id_imagen` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id_reseña` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visitas_productos`
--
ALTER TABLE `visitas_productos`
  MODIFY `id_visita` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD CONSTRAINT `carrito_compras_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_compras_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD CONSTRAINT `donaciones_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `donaciones_ibfk_2` FOREIGN KEY (`id_emprendedor`) REFERENCES `emprendedores` (`id_emprendedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `emprendedores`
--
ALTER TABLE `emprendedores`
  ADD CONSTRAINT `emprendedores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `emprendedores_ibfk_2` FOREIGN KEY (`id_admin_validador`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL;

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_stock`
--
ALTER TABLE `historial_stock`
  ADD CONSTRAINT `historial_stock_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones_admin`
--
ALTER TABLE `notificaciones_admin`
  ADD CONSTRAINT `notificaciones_admin_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificaciones_admin_ibfk_2` FOREIGN KEY (`id_emprendedor`) REFERENCES `emprendedores` (`id_emprendedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `pedidos_ibfk_metodo_pago` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodos_pago` (`id_metodo`);

--
-- Filtros para la tabla `preguntas_productos`
--
ALTER TABLE `preguntas_productos`
  ADD CONSTRAINT `preguntas_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `preguntas_productos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `preguntas_productos_ibfk_3` FOREIGN KEY (`id_emprendedor_responde`) REFERENCES `emprendedores` (`id_emprendedor`) ON DELETE SET NULL;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_emprendedor`) REFERENCES `emprendedores` (`id_emprendedor`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `producto_imagenes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `reseñas_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `visitas_productos`
--
ALTER TABLE `visitas_productos`
  ADD CONSTRAINT `visitas_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `visitas_productos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
