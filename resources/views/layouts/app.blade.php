<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MK Gilze Africa - Machine Configurator')</title>
    <link rel="icon" type="image/x-icon" href="/storage/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --primary-light: #3b82f6;
            --secondary: #9333ea;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --border: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.05);
        }

        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            transition: all 0.3s ease;
        }

        /* Enhanced Navbar */
        .navbar-elegant {
            background: white;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 0;
            transition: background-color 0.3s ease;
        }

        .navbar-elegant.scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-md);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.25rem 0;
            transition: color 0.3s ease;
        }

        .navbar-brand img {
            height: 32px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--primary-light);
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        /* Enhanced User Panel */
        .user-panel-elegant {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            cursor: pointer;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
        }

        .user-panel-elegant:hover {
            background-color: var(--gray-100);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .user-avatar-elegant {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        .user-panel-elegant:hover .user-avatar-elegant {
            transform: scale(1.1);
        }

        .user-name-elegant {
            font-weight: 600;
            color: var(--gray-800);
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
            transition: color 0.3s ease;
        }

        .user-panel-elegant:hover .user-name-elegant {
            color: var(--primary);
        }

        /* Enhanced Admin Link */
        .admin-link-elegant {
            color: var(--secondary);
            font-weight: 600;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border: 2px solid var(--secondary);
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            margin-right: 0.75rem;
            line-height: 1.2;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: white;
        }

        .admin-link-elegant:hover {
            background: var(--secondary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .admin-link-elegant i {
            font-size: 1rem;
        }

        /* FIXED MOBILE COLLAPSE MENU */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                margin: 0.75rem -1.25rem 0;
                padding: 1.25rem;
                background: white;
                border-radius: 12px;
                box-shadow: var(--shadow-md);
                border: 1px solid var(--border);
            }

            .navbar-collapse .navbar-nav {
                padding: 0;
                flex-direction: column !important;
            }

            .navbar-collapse .nav-item {
                margin-bottom: 0.375rem;
                width: 100%;
            }

            /* ADMIN BUTTON - VISIBLE & PROMINENT */
            .navbar-collapse .admin-link-elegant {
                display: block !important;
                width: 100% !important;
                margin: 0 0 0.75rem 0 !important;
                justify-content: flex-start !important;
                border-radius: 12px !important;
                padding: 1.25rem !important;
                font-size: 1.1rem !important;
                text-align: left !important;
                border: 2px solid var(--secondary) !important;
                background: var(--gray-50) !important;
                font-weight: 700 !important;
                transition: all 0.3s ease;
            }

            .navbar-collapse .admin-link-elegant:hover {
                background: var(--secondary) !important;
                color: white !important;
                transform: translateY(-2px);
                box-shadow: var(--shadow-sm);
            }

            /* USER PANEL - MATCHES ADMIN LAYOUT */
            .navbar-collapse .user-panel-elegant {
                width: 100% !important;
                margin: 0 0 0.375rem 0 !important;
                justify-content: flex-start !important;
                padding: 1.25rem !important;
                border-radius: 12px !important;
                border: 2px solid var(--border) !important;
                background: var(--gray-50) !important;
                cursor: pointer;
                display: flex !important;
                align-items: center !important;
                gap: 1rem !important;
                transition: all 0.3s ease;
            }

            .navbar-collapse .user-panel-elegant:hover {
                background: var(--gray-100) !important;
                transform: translateY(-2px);
                box-shadow: var(--shadow-sm);
            }

            /* ✅ MOBILE DROPDOWN - MATCHES ADMIN */
            .dropdown-menu {
                position: absolute !important;
                top: 100% !important;
                right: 0 !important;
                width: auto !important;
                min-width: 220px !important;
                margin: 0.375rem 0 0 !important;
                border: 1px solid var(--border) !important;
                box-shadow: var(--shadow-md) !important;
                border-radius: 12px !important;
                background: white !important;
                padding: 0 !important;
                z-index: 1000 !important;
                animation: fadeIn 0.2s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .dropdown-menu .dropdown-item {
                padding: 1rem 1.5rem !important;
                font-size: 1rem !important;
                color: var(--gray-800) !important;
                transition: all 0.3s ease !important;
                font-weight: 500 !important;
            }

            .dropdown-menu .dropdown-item:hover {
                background: var(--gray-100) !important;
                color: var(--primary) !important;
            }

            /* ✅ LOGOUT BUTTON - MATCHES ADMIN STYLE */
            .logout-form .logout-btn-elegant {
                width: 100% !important;
                padding: 1rem 1.5rem !important;
                font-size: 1rem !important;
                font-weight: 600 !important;
                border-radius: 0 !important;
                margin: 0 !important;
                border: none !important;
                background: transparent !important;
                color: var(--gray-700) !important;
                text-align: left !important;
                transition: all 0.3s ease !important;
            }

            .logout-form .logout-btn-elegant:hover {
                background: #fee2e2 !important;
                color: #dc2626 !important;
                transform: translateX(5px);
            }

            .dropdown-menu .dropdown-item-text {
                padding: 1.25rem 1.5rem !important;
                background: var(--gray-50) !important;
                border-radius: 12px 12px 0 0 !important;
                margin: 0 !important;
                color: var(--gray-900) !important;
                font-weight: 600 !important;
                border-bottom: 1px solid var(--border);
            }

            .dropdown-menu .dropdown-divider {
                margin: 0 !important;
                border-color: var(--border);
            }
        }

        /* TABLET - LARGER TOUCH TARGETS */
        @media (max-width: 991.98px) and (min-width: 768px) {
            .navbar-collapse .admin-link-elegant {
                padding: 1.375rem 1.75rem !important;
                font-size: 1.2rem !important;
            }

            .navbar-collapse .user-panel-elegant {
                padding: 1.375rem 1.75rem !important;
            }
        }

        /* Main Content */
        main {
            padding: 2rem 0;
            min-height: calc(100vh - 140px);
            background: linear-gradient(135deg, var(--gray-50), #ffffff);
        }

        @media (max-width: 768px) {
            main {
                padding: 1.25rem 1.25rem;
            }
        }

        /* Clean Cards */
        .card-elegant {
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow);
            background: white;
            transition: all 0.3s ease;
        }

        .card-elegant:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }

        .component-card-elegant {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 1.75rem;
            transition: all 0.3s ease;
        }

        .component-card-elegant:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .component-card-elegant.selected {
            border-color: var(--primary);
            background: var(--gray-50);
        }

        /* Price Breakdown */
        .price-breakdown-elegant {
            position: sticky;
            top: 20px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 1.75rem;
            transition: all 0.3s ease;
        }

        .price-breakdown-elegant:hover {
            box-shadow: var(--shadow-md);
        }

        /* Clean Alerts */
        .alert-elegant {
            border: none;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.75rem;
            border-left: 5px solid;
            box-shadow: var(--shadow-sm);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert-success-elegant {
            background: #ecfdf5;
            border-left-color: #10b981;
            color: #065f46;
        }

        .alert-danger-elegant {
            background: #fef2f2;
            border-left-color: #ef4444;
            color: #991b1b;
        }

        /* Clean Footer */
        footer {
            background: linear-gradient(135deg, var(--gray-900), #111827);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 3px solid var(--primary);
            box-shadow: var(--shadow-md);
        }

        .footer-content-elegant {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .footer-logo-elegant {
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: color 0.3s ease;
        }

        .footer-logo-elegant img {
            height: 28px;
            transition: transform 0.3s ease;
        }

        .footer-logo-elegant:hover {
            color: var(--primary-light);
        }

        .footer-logo-elegant:hover img {
            transform: scale(1.05);
        }

        .footer-links-elegant {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .footer-link-elegant {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .footer-link-elegant:hover {
            color: var(--primary-light);
            transform: translateY(-2px);
        }

        .footer-bottom {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            text-align: center;
        }

        @media (max-width: 991.98px) {
            .footer-content-elegant {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .footer-links-elegant {
                gap: 1.5rem;
            }
        }

        /* Print */
        @media print {

            .navbar-elegant,
            footer {
                display: none;
            }

            main {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-elegant" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('storage/mk-logo.png') }}" alt="MK Gilze Africa">
                <span class="d-none d-lg-inline text-dark">MK Gilze Africa</span>
            </a>



            @auth
                <div class="ms-auto align-items-center">

                    <!-- ✅ FIXED USER DROPDOWN - USERNAME VISIBLE ON MOBILE -->
                    <div class="dropdown">
                        <a class="nav-link p-0" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="user-panel-elegant">
                                <div class="user-avatar-elegant">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <span class="user-name-elegant">{{ Str::limit(Auth::user()->name, 15) }}</span>
                                <i class="fas fa-chevron-down d-md-none ms-1"></i>
                            </div>
                        </a>
                        <!-- ✅ DROPDOWN WITH LOGOUT -->
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="dropdown-item-text">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    @if (Auth::user()->isAdmin())
                                        <br><small class="text-primary">Administrator</small>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @if (Auth::user()->isAdmin())
                                <!-- 👑 ADMIN BUTTON - VISIBLE EVERYWHERE -->
                                <a class="dropdown-item logout-btn-elegant w-100 text-start"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-crown d-md-none me-2"></i>
                                    <i class="fas fa-cog  d-none d-md-inline me-2"></i>
                                    <span>Admin Panel</span>
                                </a>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-btn-elegant w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="navbar-nav ms-auto">
                    <a class="nav-link btn btn-outline-primary btn-sm px-3 py-1" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                </div>
            @endauth


        </div>
    </nav>

    <main>
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success-elegant alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger-elegant alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger-elegant alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content-elegant ">
                <div class="footer-logo-elegant">
                    <img src="{{ asset('storage/android-chrome-512x512.png') }}" alt="MK Gilze Africa"
                        class="d-none d-md-block me-2">
                    <span>MK Gilze Africa</span>
                </div>
                <div class="footer-links-elegant">
                    <p class="mb-0">&copy; {{ date('Y') }} MK Gilze Africa. All rights reserved.</p>
                </div>
            </div>

        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-close alerts
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // ✅ Smart mobile menu closing
            function closeMobileMenu() {
                if (window.innerWidth <= 991.98) {
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            toggle: false
                        });
                        bsCollapse.hide();
                    }
                }
            }

            // Close menu on admin link or logout click
            document.addEventListener('click', function(e) {
                const target = e.target;
                if (target.closest('.admin-link-elegant') || target.closest('.logout-btn-elegant')) {
                    closeMobileMenu();
                }
            });

            // Ensure dropdown works with mobile menu
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse) {
                navbarCollapse.addEventListener('show.bs.collapse', function() {
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        menu.classList.remove('show');
                    });
                });
            }

            // Add scroll effect to navbar
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
