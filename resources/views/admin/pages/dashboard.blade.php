@extends('admin.layouts.index')

@section('title', 'Quiz Battle - Admin Console Dashboard')

@section('content')
<div class="dashboard-header-title" style="margin-bottom: 2rem;">
    <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 800; color: #ffffff;">Dashboard</h1>
</div>

<!-- Row 1 Stats Grid (4 Columns) -->
<section class="stats-grid-4">
    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">👥</span>
            <span>Total Users</span>
        </div>
        <span class="stat-card-value">46</span>
        <div class="stat-card-sub sub-blue">
            <span>+0 today</span>
            <span>↗</span>
        </div>
    </div>
    
    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">👤</span>
            <span>Creators</span>
        </div>
        <span class="stat-card-value">7</span>
        <div class="stat-card-sub sub-amber">
            <span>20 quizzes published</span>
            <span>📝</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">🎓</span>
            <span>Published Quizzes</span>
        </div>
        <span class="stat-card-value">20</span>
        <div class="stat-card-sub sub-green">
            <span>20 total (incl. drafts)</span>
            <span>📄</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">📝</span>
            <span>Total Attempts</span>
        </div>
        <span class="stat-card-value">249</span>
        <div class="stat-card-sub sub-blue">
            <span>+0 today</span>
            <span>↗</span>
        </div>
    </div>
</section>

<!-- Row 2 Stats Grid (4 Columns) -->
<section class="stats-grid-4">
    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">📈</span>
            <span>Today's Revenue</span>
        </div>
        <span class="stat-card-value">$0.00</span>
        <div class="stat-card-sub sub-green">
            <span>+0% vs yesterday</span>
            <span>↗</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">📅</span>
            <span>Revenue (7 days)</span>
        </div>
        <span class="stat-card-value">$0.00</span>
        <div class="stat-card-sub sub-blue">
            <span>+0% vs prev week</span>
            <span>↗</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">📊</span>
            <span>Revenue (30 days)</span>
        </div>
        <span class="stat-card-value">$0.00</span>
        <div class="stat-card-sub sub-blue">
            <span>Platform commission earned</span>
            <span>💵</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">💳</span>
            <span>All-time Revenue</span>
        </div>
        <span class="stat-card-value">$1,135.20</span>
        <div class="stat-card-sub sub-amber">
            <span>36 paid orders total</span>
            <span>🛒</span>
        </div>
    </div>
</section>

<!-- Row 3 Stats Grid (3 Columns) -->
<section class="stats-grid-3">
    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">✨</span>
            <span>AI Generations Today</span>
        </div>
        <span class="stat-card-value">0</span>
        <div class="stat-card-sub sub-green">
            <span>0 succeeded · 0 failed</span>
            <span>✓</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">🎛️</span>
            <span>Total Generations</span>
        </div>
        <span class="stat-card-value">57</span>
        <div class="stat-card-sub sub-blue">
            <span>32,740 tokens used</span>
            <span>🎛️</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-header">
            <span class="header-icon">👥</span>
            <span>Top Generator</span>
        </div>
        <span class="stat-card-value" style="font-size: 1.8rem; height: 2.2rem; display: flex; align-items: center;">Priya Sharma</span>
        <div class="stat-card-sub sub-blue">
            <span>34 total generations</span>
            <span>★</span>
        </div>
    </div>
</section>

<!-- Top Creators Section Panel -->
<section class="data-panel" style="margin-bottom: 2.5rem;">
    <div class="panel-header" style="margin-bottom: 1.5rem; align-items: flex-start;">
        <div>
            <h2 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 700; color: #ffffff;">Top Creators</h2>
            <p class="panel-subtitle">Ranked by total earnings from quiz sales</p>
        </div>
        <div class="search-container">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Search">
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th>Creator</th>
                    <th>Email</th>
                    <th>Published</th>
                    <th>Total Quizzes</th>
                    <th style="width: 10%;">Earnings</th>
                    <th>Wallet</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Carlos Mendoza</strong></td>
                    <td style="color: #9ca3af;">carlos.mendoza@quizora.demo</td>
                    <td><span class="count-bubble">3</span></td>
                    <td>3</td>
                    <td></td>
                    <td style="color: #ffffff; font-weight: 600;">$0.00</td>
                    <td style="color: #9ca3af;">19 Jun 2026</td>
                </tr>
                <tr>
                    <td><strong>Rahul Mehta</strong></td>
                    <td style="color: #9ca3af;">rahul@demo.quiz</td>
                    <td><span class="count-bubble">4</span></td>
                    <td>4</td>
                    <td></td>
                    <td style="color: #ffffff; font-weight: 600;">$800.00</td>
                    <td style="color: #9ca3af;">22 Jun 2026</td>
                </tr>
                <tr>
                    <td><strong>Emma Wilson</strong></td>
                    <td style="color: #9ca3af;">emma.wilson@quizora.demo</td>
                    <td><span class="count-bubble">3</span></td>
                    <td>3</td>
                    <td></td>
                    <td style="color: #ffffff; font-weight: 600;">$0.00</td>
                    <td style="color: #9ca3af;">19 Jun 2026</td>
                </tr>
                <tr>
                    <td><strong>Sofia Rodriguez</strong></td>
                    <td style="color: #9ca3af;">sofia@demo.quiz</td>
                    <td><span class="count-bubble">3</span></td>
                    <td>3</td>
                    <td></td>
                    <td style="color: #ffffff; font-weight: 600;">$450.00</td>
                    <td style="color: #9ca3af;">22 Jun 2026</td>
                </tr>
                <tr>
                    <td><strong>Rida</strong></td>
                    <td style="color: #9ca3af;">3nizou@gmail.com</td>
                    <td><span class="count-bubble">0</span></td>
                    <td>0</td>
                    <td></td>
                    <td style="color: #ffffff; font-weight: 600;">$0.00</td>
                    <td style="color: #9ca3af;">28 Jun 2026</td>
                </tr>
                <tr>
                    <td><strong>xandi ily</strong></td>
                    <td style="color: #9ca3af;">ilyxandi@gmail.com</td>
                    <td><span class="count-bubble">0</span></td>
                    <td>0</td>
                    <td></td>
                    <td style="color: #ffffff; font-weight: 600;">$0.00</td>
                    <td style="color: #9ca3af;">29 Jul 2026</td>
                </tr>
                <tr>
                    <td><strong>Priya Sharma</strong></td>
                    <td style="color: #9ca3af;">priya@demo.quiz</td>
                    <td><span class="count-bubble">7</span></td>
                    <td>7</td>
                    <td></td>
                    <td style="color: #ffffff; font-weight: 600;">$1,200.00</td>
                    <td style="color: #9ca3af;">22 Jun 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<!-- Recent Orders Section Panel -->
<section class="data-panel" style="margin-bottom: 2.5rem;">
    <div class="panel-header" style="margin-bottom: 1.5rem; align-items: flex-start;">
        <div>
            <h2 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 700; color: #ffffff;">Recent Orders</h2>
            <p class="panel-subtitle">Latest paid transactions on the platform</p>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Quiz</th>
                    <th>Amount</th>
                    <th>Commission</th>
                    <th>Gateway</th>
                    <th>Paid At</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Aisha Johnson</strong></td>
                    <td style="color: #9ca3af;">Logical Reasoning — Patterns & Deduction</td>
                    <td style="color: #ffffff; font-weight: 600;">$0.00</td>
                    <td style="color: #34d399; font-weight: 600;">$0.00</td>
                    <td><span class="gateway-badge gateway-wallet">wallet</span></td>
                    <td style="color: #9ca3af;">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td><strong>Sofia Andersson</strong></td>
                    <td style="color: #9ca3af;">GMAT Critical Reasoning & Data Sufficien...</td>
                    <td style="color: #ffffff; font-weight: 600;">$12.99</td>
                    <td style="color: #34d399; font-weight: 600;">$2.60</td>
                    <td><span class="gateway-badge gateway-razorpay">razorpay</span></td>
                    <td style="color: #9ca3af;">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td><strong>Aisha Johnson</strong></td>
                    <td style="color: #9ca3af;">GRE Verbal Reasoning Practice</td>
                    <td style="color: #ffffff; font-weight: 600;">$9.99</td>
                    <td style="color: #34d399; font-weight: 600;">$2.00</td>
                    <td><span class="gateway-badge gateway-stripe">stripe</span></td>
                    <td style="color: #9ca3af;">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td><strong>Marcus Brown</strong></td>
                    <td style="color: #9ca3af;">IELTS Academic — Reading & Grammar</td>
                    <td style="color: #ffffff; font-weight: 600;">$7.99</td>
                    <td style="color: #34d399; font-weight: 600;">$1.60</td>
                    <td><span class="gateway-badge gateway-paypal">paypal</span></td>
                    <td style="color: #9ca3af;">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td><strong>Aisha Johnson</strong></td>
                    <td style="color: #9ca3af;">GRE Verbal Reasoning Practice</td>
                    <td style="color: #ffffff; font-weight: 600;">$9.99</td>
                    <td style="color: #34d399; font-weight: 600;">$2.00</td>
                    <td><span class="gateway-badge gateway-razorpay">razorpay</span></td>
                    <td style="color: #9ca3af;">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td><strong>Marcus Brown</strong></td>
                    <td style="color: #9ca3af;">IELTS Academic — Reading & Grammar</td>
                    <td style="color: #ffffff; font-weight: 600;">$7.99</td>
                    <td style="color: #34d399; font-weight: 600;">$1.60</td>
                    <td><span class="gateway-badge gateway-wallet">wallet</span></td>
                    <td style="color: #9ca3af;">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td><strong>Sofia Andersson</strong></td>
                    <td style="color: #9ca3af;">Quantitative Aptitude — Speed, Work & Pr...</td>
                    <td style="color: #ffffff; font-weight: 600;">$5.99</td>
                    <td style="color: #34d399; font-weight: 600;">$1.20</td>
                    <td><span class="gateway-badge gateway-stripe">stripe</span></td>
                    <td style="color: #9ca3af;">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td><strong>Student 7</strong></td>
                    <td style="color: #9ca3af;">Data Structures & Algorithms</td>
                    <td style="color: #ffffff; font-weight: 600;">$299.00</td>
                    <td style="color: #34d399; font-weight: 600;">$59.80</td>
                    <td><span class="gateway-badge gateway-stripe">stripe</span></td>
                    <td style="color: #9ca3af;">20 Jun 2026, 14:12</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
