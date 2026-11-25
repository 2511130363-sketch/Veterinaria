<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Veterinaria') - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --vet-primary: #1b7a6b;
            --vet-secondary: #f4a261;
            --vet-dark: #1f2937;
            --vet-light: #f1f5f9;
        }
        body { background: var(--vet-light); font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 260px; min-height: 100vh; background: linear-gradient(180deg, var(--vet-primary), #135e53);
            color: #fff; position: fixed; top: 0; left: 0; z-index: 1000;
            transition: transform .3s;
        }
        .sidebar .brand { padding: 1.25rem; font-size: 1.25rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,.15); }
        .sidebar .nav-link { color: rgba(255,255,255,.85); padding: .6rem 1.25rem; border-radius: .5rem; margin: .15rem .75rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,.18); color: #fff; }
        .sidebar .nav-link i { margin-right: .6rem; }
        .content-wrapper { margin-left: 260px; }
        .topbar { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.05); padding: .75rem 1.5rem; }
        .card-stat { border: none; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,.06); }
        .card-stat .icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .content-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="brand"><i class="bi bi-heart-pulse-fill"></i> VetCare</div>
        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('recepcionista'))
                <div class="px-3 mt-3 small text-uppercase opacity-75">Gestión</div>
                <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}"><i class="bi bi-people"></i> Clientes</a>
                <a class="nav-link {{ request()->routeIs('mascotas.*') ? 'active' : '' }}" href="{{ route('mascotas.index') }}"><i class="bi bi-emoji-smile"></i> Mascotas</a>
                <a class="nav-link {{ request()->routeIs('citas.*') ? 'active' : '' }}" href="{{ route('citas.index') }}"><i class="bi bi-calendar-event"></i> Citas</a>
                <a class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}" href="{{ route('ventas.index') }}"><i class="bi bi-cash-coin"></i> Ventas</a>
            @endif

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('veterinario') || auth()->user()->hasRole('recepcionista'))
                <div class="px-3 mt-3 small text-uppercase opacity-75">Clínico</div>
                <a class="nav-link {{ request()->routeIs('consultas.*') ? 'active' : '' }}" href="{{ route('consultas.index') }}"><i class="bi bi-file-medical"></i> Consultas</a>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <div class="px-3 mt-3 small text-uppercase opacity-75">Administración</div>
                <a class="nav-link {{ request()->routeIs('veterinarios.*') ? 'active' : '' }}" href="{{ route('veterinarios.index') }}"><i class="bi bi-person-badge"></i> Veterinarios</a>
                <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ route('servicios.index') }}"><i class="bi bi-clipboard2-pulse"></i> Servicios</a>
                <a class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}"><i class="bi bi-tags"></i> Categorías</a>
                <a class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}" href="{{ route('productos.index') }}"><i class="bi bi-box-seam"></i> Productos</a>
                <a class="nav-link {{ request()->routeIs('inventario.*') ? 'active' : '' }}" href="{{ route('inventario.index') }}"><i class="bi bi-arrow-left-right"></i> Inventario</a>
                <a class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}" href="{{ route('reportes.index') }}"><i class="bi bi-graph-up"></i> Reportes</a>
            @endif
        </nav>
    </aside>

    <div class="content-wrapper">
        <header class="topbar d-flex justify-content-between align-items-center">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
            <div class="fw-semibold">@yield('title', 'Dashboard')</div>
            <div class="dropdown">
                <a class="btn btn-light dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->role?->nombre }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <main class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
