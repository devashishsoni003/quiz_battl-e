<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quiz Battle - The Ultimate Trivia Arena')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a051b;
            --bg-secondary: #130c2e;
            --accent-primary: #ff2a74;
            --accent-secondary: #00f0ff;
            --text-main: #f3f0ff;
            --text-muted: #a59fc4;
            --card-border: rgba(255, 42, 116, 0.25);
            --card-border-hover: rgba(0, 240, 255, 0.6);
            --glass-bg: rgba(19, 12, 46, 0.6);
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-main);
            overflow-x: hidden;
            min-height: 100vh;
        }

        h1, h2, h3, .brand-logo {
            font-family: 'Outfit', sans-serif;
        }

        /* Background glows */
        .glow-sphere {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(150px);
            z-index: 0;
            opacity: 0.3;
            pointer-events: none;
        }

        .glow-left {
            top: -100px;
            left: -100px;
            background: var(--accent-primary);
        }

        .glow-right {
            bottom: -100px;
            right: -100px;
            background: var(--accent-secondary);
        }

        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 8%;
            background: rgba(10, 5, 27, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 1000;
        }

        .brand-logo {
            font-size: 1.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(0, 240, 255, 0.2);
            cursor: pointer;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 600;
            transition: var(--transition-smooth);
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--text-main);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .btn-cta {
            background: linear-gradient(135deg, var(--accent-primary), #d9165c);
            color: #fff !important;
            padding: 0.8rem 1.8rem;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(255, 42, 116, 0.4);
            transition: var(--transition-smooth);
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 42, 116, 0.6), 0 0 15px rgba(0, 240, 255, 0.2);
        }

        /* Main structure */
        main {
            z-index: 1;
            position: relative;
        }

        /* Footer */
        footer {
            padding: 50px 8%;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-muted);
            font-size: 0.9rem;
            z-index: 1;
            position: relative;
        }

        @media (max-width: 768px) {
            nav {
                padding: 0 4%;
            }
            .nav-links {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="glow-sphere glow-left"></div>
    <div class="glow-sphere glow-right"></div>

    @include('frontend.common.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.common.footer')

    @stack('scripts')
</body>
</html>
