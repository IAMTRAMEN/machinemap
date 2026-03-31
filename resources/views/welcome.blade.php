<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MK Gilze Africa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.05);
        }

        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
            transition: all 0.3s ease;
            position: fixed;
            width: 100%;
            z-index: 1000;
        }

        .navbar.scrolled {
            background: white;
            box-shadow: var(--shadow-md);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }

        .navbar-brand i {
            color: var(--secondary);
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--primary-light);
        }

        .navbar-brand:hover i {
            transform: rotate(15deg);
        }

        .nav-link {
            color: var(--gray-700) !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 100px 0;
        }

        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            opacity: 0.7;
            filter: brightness(0.8);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.5), rgba(118, 75, 162, 0.5));
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: white;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            animation: slideUp 1s ease-out;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-content p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            animation: slideUp 1.2s ease-out;
        }

        .btn-hero {
            background: white;
            color: var(--primary);
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-hero:hover {
            background: var(--primary-light);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Stats Section */
        .stats-section {
            padding: 3rem 0;
            background: var(--gray-100);
            text-align: center;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 0 1rem;
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: scale(1.05);
        }

        /* Features Section */
        .features-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--gray-50), #ffffff);
        }

        .feature-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-md);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: rotate(15deg) scale(1.1);
        }

        .feature-card h4 {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--gray-700);
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--gray-900), #111827);
            color: white;
            padding: 2.5rem 0;
            border-top: 3px solid var(--primary);
            box-shadow: var(--shadow-md);
        }

        .footer-content {
            text-align: center;
        }

        .footer-content p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Animations */
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            .hero-content p {
                font-size: 1rem;
            }
            .feature-card {
                margin-bottom: 2rem;
            }
            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-elegant" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('storage/mk-logo.png') }}" alt="MK Gilze Africa" class="me-2" style="width: 3.5rem;">
                
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <video class="hero-video" autoplay muted loop>
            <source src="storage/multivac.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1>Welcome to Machine Configurator</h1>
            <p class="lead">Unlock the power of custom machine design and instant quoting</p>
            
        </div>
    </section>

    <!-- Stats Section -->
    

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-cogs"></i></div>
                        <h4>Machine Configuration</h4>
                        <p>Build custom machines with compatible components effortlessly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                        <h4>Instant Quotes</h4>
                        <p>Generate professional quotes with PDF export in seconds.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-balance-scale"></i></div>
                        <h4>Comparison Tools</h4>
                        <p>Compare configurations side by side for the best choice.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container footer-content">
            <p>&copy; {{ date('Y') }} MK Gilze Africa. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for login button
        document.querySelector('.btn-hero').addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('#navbar .nav-link').click();
        });
    </script>
</body>
</html>