@extends('frontend.layouts.index')

@section('title', 'Quiz Battle - The Ultimate Trivia Arena')

@stack('styles')
<style>
    /* Hero Section */
    .hero {
        position: relative;
        padding: 180px 8% 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .badge {
        background: rgba(255, 42, 116, 0.1);
        border: 1px solid var(--accent-primary);
        color: var(--accent-primary);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 2rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.9; }
        50% { transform: scale(1.05); opacity: 1; box-shadow: 0 0 15px rgba(255, 42, 116, 0.2); }
        100% { transform: scale(1); opacity: 0.9; }
    }

    .hero h1 {
        font-size: 4.5rem;
        font-weight: 800;
        line-height: 1.1;
        max-width: 900px;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
    }

    .hero h1 span.accent {
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero p {
        font-size: 1.25rem;
        color: var(--text-muted);
        max-width: 650px;
        line-height: 1.6;
        margin-bottom: 3rem;
    }

    .hero-buttons {
        display: flex;
        gap: 1.5rem;
    }

    .btn-secondary {
        background: transparent;
        border: 1px solid var(--text-muted);
        color: var(--text-main);
        padding: 0.8rem 1.8rem;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        transition: var(--transition-smooth);
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .btn-secondary:hover {
        border-color: var(--accent-secondary);
        color: var(--accent-secondary);
        box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
        transform: translateY(-2px);
    }

    /* Features section */
    .features {
        padding: 80px 8%;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
    }

    .card {
        background: var(--glass-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 2.5rem;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 42, 116, 0.05), rgba(0, 240, 255, 0.05));
        opacity: 0;
        transition: var(--transition-smooth);
    }

    .card:hover {
        transform: translateY(-8px);
        border-color: var(--card-border-hover);
        box-shadow: 0 10px 30px rgba(0, 240, 255, 0.15);
    }

    .card:hover::before {
        opacity: 1;
    }

    .card-icon {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        display: block;
    }

    .card h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: #fff;
    }

    .card p {
        color: var(--text-muted);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.8rem;
        }
        .hero p {
            font-size: 1.1rem;
        }
    }
</style>

@section('content')
<section class="hero">
    <span class="badge">Next Gen Trivia</span>
    <h1>Unleash Your Intellect In <span class="accent">Real-Time Quiz Battles</span></h1>
    <p>Challenge players worldwide, climb the leaderboard, and claim ultimate trivia supremacy. Your brain is your battlefield.</p>
    <div class="hero-buttons">
        <button class="btn-cta">Quick Match</button>
        <a href="/admin" class="btn-secondary">Go to Admin Dashboard &nbsp; →</a>
    </div>
</section>

<section class="features" id="features">
    <div class="features-grid">
        <div class="card">
            <span class="card-icon">⚡</span>
            <h3>Real-Time Matches</h3>
            <p>Experience ultra-fast, live multiplayer quiz face-offs with lightning quick response systems.</p>
        </div>
        <div class="card">
            <span class="card-icon">🏆</span>
            <h3>Leaderboard & Ranks</h3>
            <p>Rise through the competitive ranks, build your match history, and achieve grandmaster status.</p>
        </div>
        <div class="card">
            <span class="card-icon">🛠️</span>
            <h3>Custom Quiz Builder</h3>
            <p>Create your custom quizzes using our powerful admin panel and challenge your friends privately.</p>
        </div>
    </div>
</section>
@endsection
