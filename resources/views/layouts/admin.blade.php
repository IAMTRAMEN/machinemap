<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - MK Gilze Africa')</title>
    <link rel="icon" type="image/x-icon" href="/storage/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #64748b;
            --success: #059669;
            --danger: #dc2626;
            --warning: #d97706;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --border: #e2e8f0;
            --sidebar-width: 280px;
            --sidebar-width-lg: 320px;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            margin: 0;
            padding-top: 70px;
            overflow-x: hidden;
        }

        /* Corporate Top Navbar - Mobile/Tablet Optimized */
        .top-navbar {
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.125rem;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.025em;
            flex-shrink: 0;
        }

        .navbar-brand img {
            height: 32px;
            width: auto;
        }

        /* Mobile/Tablet Menu Toggle */
        .mobile-toggle {
            padding: 0.5rem;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            background: white;
            color: var(--gray-700);
            transition: all 0.15s ease;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-toggle:hover {
            background: var(--gray-50);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* User Panel - Responsive */
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            background: var(--gray-100);
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            white-space: nowrap;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            font-size: 0.8rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--gray-900);
            line-height: 1.1;
        }

        .user-role {
            font-size: 0.7rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .logout-btn {
            background: transparent;
            color: var(--gray-700);
            border: 1px solid var(--gray-200);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.15);
        }

        /* ✅ FIXED Sidebar - Proper Scrolling */
        .sidebar {
            width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid var(--border);
            position: fixed;
            top: 70px;
            left: 0;
            bottom: 0;
            z-index: 1020;
            overflow: hidden; /* Container doesn't scroll */
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.08);
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        /* Desktop: Always visible */
        @media (min-width: 1200px) {
            .sidebar {
                transform: translateX(0) !important;
            }
            .main-content {
                margin-left: var(--sidebar-width) !important;
            }
        }

        /* Tablet (992px - 1199px): Toggle visible */
        @media (min-width: 992px) and (max-width: 1199px) {
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content.sidebar-visible {
                margin-left: var(--sidebar-width);
            }
        }

        /* Mobile (below 992px): Always toggle */
        @media (max-width: 991px) {
            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* ✅ Sidebar Structure - Fixed Heights */
        .sidebar-header {
            padding: 1.5rem 1.25rem;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0; /* Fixed height */
        }

        .sidebar-header img {
            height: 38px;
            width: auto;
            margin-bottom: 0.75rem;
        }

        .sidebar-title {
            font-size: 0.8rem;
            font-weight: 600;
            opacity: 0.95;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ✅ SCROLLABLE Content Area */
        .sidebar-body {
            flex: 1; /* Takes remaining space */
            overflow-y: auto; /* ✅ ONLY this scrolls */
            overflow-x: hidden;
            padding: 0;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
            background: var(--gray-50);
            flex-shrink: 0; /* Fixed height */
        }

        /* Navigation Styles */
        .nav-item {
            margin: 0;
        }

        .nav-link {
            color: var(--gray-700);
            padding: 1rem 1.25rem;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.15s ease;
            border: 0;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            text-decoration: none;
            position: relative;
            border-left: 3px solid transparent;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: var(--gray-50);
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .nav-link.active {
            background: var(--gray-50);
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .nav-link i {
            width: 18px;
            font-size: 1.1em;
            opacity: 0.8;
            flex-shrink: 0;
        }

        .nav-link:hover i,
        .nav-link.active i {
            opacity: 1;
        }

        /* ✅ Collapsible Menu - Fixed */
        .nav-link[data-bs-toggle="collapse"] {
            cursor: pointer;
        }

        .nav-link[data-bs-toggle="collapse"]::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-left: auto;
            transition: transform 0.2s ease;
            font-size: 0.8em;
        }

        .nav-link.collapsed[data-bs-toggle="collapse"]::after {
            transform: rotate(-90deg);
        }

        .nav-collapse {
            background: var(--gray-50);
        }

        .nav-collapse .nav-link {
            padding-left: 3.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            border-left: none;
        }

        .footer-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.75rem;
            border-radius: 6px;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .footer-link:hover {
            background: white;
            color: var(--primary);
        }

        /* Main Content - Responsive */
        .main-content {
            min-height: calc(100vh - 70px);
            padding: 1rem;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 0;
        }

        @media (min-width: 992px) and (max-width: 1199px) {
            .main-content {
                padding: 1.5rem 2rem;
            }
        }

        @media (min-width: 1200px) {
            .main-content {
                padding: 2.5rem 3rem;
                margin-left: var(--sidebar-width) !important;
            }
        }

        .page-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border);
            margin-top: 0.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
            letter-spacing: -0.025em;
        }

        @media (min-width: 768px) {
            .page-title {
                font-size: 1.75rem;
            }
        }

        .content-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid var(--gray-200);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 768px) {
            .content-card {
                padding: 2rem;
            }
        }

        /* Alerts */
        .alert {
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            position: relative;
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }

        .alert-success {
            color: #065f46;
            background-color: #f0fdf4;
            border-color: #10b981;
        }

        .alert-danger {
            color: #991b1b;
            background-color: #fef2f2;
            border-color: #ef4444;
        }

        .alert-icon {
            margin-right: 0.75rem;
            width: 18px;
            flex-shrink: 0;
        }

        /* Overlay - Mobile Only */
        .sidebar-overlay {
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            height: calc(100vh - 70px);
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(4px);
            z-index: 1015;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: none;
        }

        @media (max-width: 991px) {
            .sidebar-overlay.show {
                display: block;
                opacity: 1;
                visibility: visible;
            }
        }

        /* ✅ Custom Scrollbar - Only sidebar-body */
        .sidebar-body::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-body::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 2px;
        }

        .sidebar-body::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        body.sidebar-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
        }

        /* Print Styles */
        @media print {
            .sidebar, .top-navbar, .sidebar-overlay {
                display: none !important;
            }
            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Corporate Top Navbar -->
    <nav class="navbar navbar-expand-lg top-navbar">
        <div class="container-fluid px-2 px-md-4">
            <!-- Toggle Button - Mobile + Tablet -->
            <button class="mobile-toggle d-lg-none me-2" type="button" id="sidebarToggle">
                <i class="fas fa-bars fs-5"></i>
            </button>
            
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('storage/mk-logo.png') }}" alt="MK Gilze Africa" class="d-none d-md-block me-2">
                <span class="d-md-none">Admin</span>
                <span class="d-none d-md-block">Admin Panel</span>
            </a>
            
            <!-- Spacer -->
            <div class="flex-grow-1"></div>
            
            <!-- Desktop User Panel -->
            <div class="d-none d-lg-flex align-items-center">
                <div class="user-info me-3">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ Str::limit(Auth::user()->name, 15) }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                    </button>
                </form>
            </div>
            
            <!-- Mobile/Tablet User Menu -->
            <div class="d-lg-none dropdown">
                <button class="btn p-2 dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                    <div class="user-avatar me-2"></div>
                    <div>
                        <div class="user-name small fw-semibold">{{ Str::limit(Auth::user()->name, 12) }}</div>
                        <div class="user-role xsmall text-muted">Admin</div>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                    <li>
                        <div class="dropdown-item-text px-3 py-3 text-center">
                            <div class="user-avatar mx-auto mb-2" style="width: 48px; height: 48px; font-size: 1rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <strong>{{ Auth::user()->name }}</strong><br>
                            <small class="text-muted">Administrator</small>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item fw-medium">
                                <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="d-flex">
        <!-- ✅ FIXED Sidebar Structure -->
        <aside class="sidebar" id="sidebar">
            <!-- Header - Fixed -->
            <div class="sidebar-header">
                <img src="{{ asset('storage/android-chrome-512x512.png') }}" alt="MK Gilze Africa" class="img-fluid mb-2 top-50 start-100 ">
                <div class="sidebar-title">Management System</div>
            </div>

            <!-- ✅ SCROLLABLE Body -->
            <nav class="sidebar-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.machines.*') ? 'active' : '' }}" 
                           href="{{ route('admin.machines.index') }}">
                            <i class="fas fa-cogs"></i>
                            <span>Machines</span>
                        </a>
                    </li>
                    
                    <!-- Components Collapsible -->
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ (request()->routeIs('admin.components.*') || request()->routeIs('admin.categories.*')) ? 'active' : '' }} {{ (request()->routeIs('admin.components.*') || request()->routeIs('admin.categories.*')) ? '' : 'collapsed' }}" 
                           href="#" data-bs-toggle="collapse" data-bs-target="#componentsCollapse" 
                           aria-expanded="{{ request()->routeIs('admin.components.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }}"
                           aria-controls="componentsCollapse">
                            <i class="fas fa-puzzle-piece"></i>
                            <span>Components</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.components.*') || request()->routeIs('admin.categories.*') ? 'show' : '' }}" id="componentsCollapse">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="mx-auto nav-link {{ request()->routeIs('admin.components.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.components.index') }}">
                                        <i class="fas fa-list ms-4"></i>
                                        <span>All Components</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.categories.index') }}">
                                        <i class="fas fa-folder ms-4"></i>
                                        <span>Categories</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.rules.*') ? 'active' : '' }}" 
                           href="{{ route('admin.rules.index') }}">
                            <i class="fas fa-random"></i>
                            <span>Rules</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}" 
                           href="{{ route('admin.quotes.index') }}">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Quotes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.configurations.*') ? 'active' : '' }}" 
                           href="{{ route('admin.configurations.index') }}">
                            <i class="fas fa-save"></i>
                            <span>Configurations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.relationships.*') ? 'active' : '' }}" 
                           href="{{ route('admin.relationships.index') }}">
                            <i class="fas fa-address-book"></i>
                            <span>Contacts</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Footer - Fixed -->
            <div class="sidebar-footer">
                <a class="footer-link" href="{{ route('configurator.index') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Live Configurator</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-grow-1" id="mainContent">
            <div class="page-header">
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="content-card">
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="fas fa-check-circle alert-icon"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle alert-icon"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-exclamation-triangle alert-icon"></i>
                            <strong>Validation Error</strong>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Logic
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const body = document.body;

        function toggleSidebar() {
            const isTablet = window.innerWidth >= 992 && window.innerWidth < 1200;
            const isMobile = window.innerWidth < 992;

            sidebar.classList.toggle('show');
            
            if (isMobile) {
                sidebarOverlay.classList.toggle('show');
                body.classList.toggle('sidebar-open');
            }

            if (isTablet) {
                mainContent.classList.toggle('sidebar-visible');
            }
        }

        sidebarToggle?.addEventListener('click', toggleSidebar);
        
        sidebarOverlay?.addEventListener('click', () => {
            if (window.innerWidth < 992) {
                closeSidebar();
            }
        });

        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            mainContent.classList.remove('sidebar-visible');
            body.classList.remove('sidebar-open');
        }

        // Auto-close on navigation
        document.querySelectorAll('.nav-link:not([data-bs-toggle="collapse"]), .footer-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1200) {
                    closeSidebar();
                }
            });
        });

        // Resize handler
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const width = window.innerWidth;
                
                if (width >= 1200) {
                    sidebar.classList.add('show');
                    sidebarOverlay.classList.remove('show');
                    mainContent.classList.add('sidebar-visible');
                    body.classList.remove('sidebar-open');
                } else {
                    closeSidebar();
                }
            }, 150);
        });

        // Keyboard support
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });

        // Initialize
        window.addEventListener('load', () => {
            if (window.innerWidth >= 1200) {
                sidebar.classList.add('show');
                mainContent.classList.add('sidebar-visible');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>