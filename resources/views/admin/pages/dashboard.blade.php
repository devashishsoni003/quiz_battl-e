@extends('admin.layouts.index')

@section('title', 'Quiz Battle - Admin Console Dashboard')

@section('content')
<div class="page-title-section">
    <h1 class="page-main-heading">Dashboard</h1>
    <p class="page-sub-heading">Track recognition, engagement, and platform activity from one focused view.</p>
</div>

<!-- Row 1 Stats Grid (4 Columns - Screenshot 2) -->
<section class="stats-grid-4">
    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-purple-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <span class="stat-badge-pill badge-purple">95% active</span>
        </div>
        <div class="stat-label-title">Total Users</div>
        <div class="stat-card-value">46</div>
        <div class="stat-card-sub sub-blue">
            <span>+0 today</span>
            <span>↗</span>
        </div>
    </div>
    
    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-blue-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
            </div>
            <span class="stat-badge-pill badge-blue">Onboarded</span>
        </div>
        <div class="stat-label-title">Creators</div>
        <div class="stat-card-value">7</div>
        <div class="stat-card-sub sub-amber">
            <span>20 quizzes published</span>
            <span>📝</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-green-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <span class="stat-badge-pill badge-green">All time</span>
        </div>
        <div class="stat-label-title">Published Quizzes</div>
        <div class="stat-card-value">20</div>
        <div class="stat-card-sub sub-green">
            <span>20 total (incl. drafts)</span>
            <span>📄</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-amber-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <span class="stat-badge-pill badge-amber">3 redeemed</span>
        </div>
        <div class="stat-label-title">Total Attempts</div>
        <div class="stat-card-value">249</div>
        <div class="stat-card-sub sub-blue">
            <span>+0 today</span>
            <span>↗</span>
        </div>
    </div>
</section>

<!-- Row 2 Stats Grid (Revenue Stats) -->
<section class="stats-grid-4">
    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-green-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
            <span class="stat-badge-pill badge-green">Today</span>
        </div>
        <div class="stat-label-title">Today's Revenue</div>
        <div class="stat-card-value">$0.00</div>
        <div class="stat-card-sub sub-green">
            <span>+0% vs yesterday</span>
            <span>↗</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-blue-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <span class="stat-badge-pill badge-blue">7 Days</span>
        </div>
        <div class="stat-label-title">Revenue (7 days)</div>
        <div class="stat-card-value">$0.00</div>
        <div class="stat-card-sub sub-blue">
            <span>+0% vs prev week</span>
            <span>↗</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-purple-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
            </div>
            <span class="stat-badge-pill badge-purple">30 Days</span>
        </div>
        <div class="stat-label-title">Revenue (30 days)</div>
        <div class="stat-card-value">$0.00</div>
        <div class="stat-card-sub sub-blue">
            <span>Platform commission earned</span>
            <span>💵</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-amber-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
            </div>
            <span class="stat-badge-pill badge-amber">All time</span>
        </div>
        <div class="stat-label-title">All-time Revenue</div>
        <div class="stat-card-value">$1,135.20</div>
        <div class="stat-card-sub sub-amber">
            <span>36 paid orders total</span>
            <span>🛒</span>
        </div>
    </div>
</section>

<!-- Row 3 Stats Grid (AI Generations) -->
<section class="stats-grid-3">
    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-purple-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
            </div>
            <span class="stat-badge-pill badge-green">Live</span>
        </div>
        <div class="stat-label-title">AI Generations Today</div>
        <div class="stat-card-value">0</div>
        <div class="stat-card-sub sub-green">
            <span>0 succeeded · 0 failed</span>
            <span>✓</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-blue-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
            </div>
            <span class="stat-badge-pill badge-blue">Tokens</span>
        </div>
        <div class="stat-label-title">Total Generations</div>
        <div class="stat-card-value">57</div>
        <div class="stat-card-sub sub-blue">
            <span>32,740 tokens used</span>
            <span>🎛️</span>
        </div>
    </div>

    <div class="stat-card-custom">
        <div class="stat-card-top">
            <div class="stat-icon-wrapper icon-amber-bg">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <span class="stat-badge-pill badge-amber">Top Star</span>
        </div>
        <div class="stat-label-title">Top Generator</div>
        <div class="stat-card-value" style="font-size: 1.5rem;">Priya Sharma</div>
        <div class="stat-card-sub sub-blue">
            <span>34 total generations</span>
            <span>★</span>
        </div>
    </div>
</section>

<!-- Top Creators Section Panel (Screenshot 3 & 4) -->
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h2 class="panel-title">Top Creators</h2>
            <p class="panel-subtitle">Ranked by total earnings from quiz sales</p>
        </div>
        <div class="table-search-box">
            <span class="table-search-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input type="text" class="table-search-input" placeholder="Search creators...">
        </div>
    </div>

    <div class="custom-table-container">
        <table class="cheerly-table">
            <thead>
                <tr>
                    <th>Creator</th>
                    <th>Email</th>
                    <th>Published</th>
                    <th>Total Quizzes</th>
                    <th>Earnings</th>
                    <th>Wallet</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #eff6ff; color: #2563eb;">CM</div>
                            <span class="user-name-title">Carlos Mendoza</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">carlos.mendoza@quizora.demo</td>
                    <td><span class="stat-badge-pill badge-purple">3</span></td>
                    <td>3</td>
                    <td><strong style="color: #10b981;">$0.00</strong></td>
                    <td style="font-weight: 600; color: #111827;">$0.00</td>
                    <td style="color: var(--text-muted);">19 Jun 2026</td>
                </tr>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #f3e8ff; color: #7c3aed;">RM</div>
                            <span class="user-name-title">Rahul Mehta</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">rahul@demo.quiz</td>
                    <td><span class="stat-badge-pill badge-purple">4</span></td>
                    <td>4</td>
                    <td><strong style="color: #10b981;">$800.00</strong></td>
                    <td style="font-weight: 600; color: #111827;">$800.00</td>
                    <td style="color: var(--text-muted);">22 Jun 2026</td>
                </tr>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #dcfce7; color: #16a34a;">EW</div>
                            <span class="user-name-title">Emma Wilson</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">emma.wilson@quizora.demo</td>
                    <td><span class="stat-badge-pill badge-purple">3</span></td>
                    <td>3</td>
                    <td><strong style="color: #10b981;">$0.00</strong></td>
                    <td style="font-weight: 600; color: #111827;">$0.00</td>
                    <td style="color: var(--text-muted);">19 Jun 2026</td>
                </tr>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #fef3c7; color: #d97706;">SR</div>
                            <span class="user-name-title">Sofia Rodriguez</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">sofia@demo.quiz</td>
                    <td><span class="stat-badge-pill badge-purple">3</span></td>
                    <td>3</td>
                    <td><strong style="color: #10b981;">$450.00</strong></td>
                    <td style="font-weight: 600; color: #111827;">$450.00</td>
                    <td style="color: var(--text-muted);">22 Jun 2026</td>
                </tr>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #fee2e2; color: #dc2626;">PS</div>
                            <span class="user-name-title">Priya Sharma</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">priya@demo.quiz</td>
                    <td><span class="stat-badge-pill badge-purple">7</span></td>
                    <td>7</td>
                    <td><strong style="color: #10b981;">$1,200.00</strong></td>
                    <td style="font-weight: 600; color: #111827;">$1,200.00</td>
                    <td style="color: var(--text-muted);">22 Jun 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<!-- Recent Orders Section Panel (Screenshot 3 & 4) -->
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h2 class="panel-title">Recent Orders</h2>
            <p class="panel-subtitle">Latest paid transactions on the platform</p>
        </div>
    </div>

    <div class="custom-table-container">
        <table class="cheerly-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Quiz Title</th>
                    <th>Amount</th>
                    <th>Commission</th>
                    <th>Gateway</th>
                    <th>Paid At</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #f3e8ff; color: #7c3aed;">AJ</div>
                            <span class="user-name-title">Aisha Johnson</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">Logical Reasoning — Patterns & Deduction</td>
                    <td><strong style="color: #111827;">$0.00</strong></td>
                    <td><strong style="color: #16a34a;">$0.00</strong></td>
                    <td><span class="status-badge status-active">wallet</span></td>
                    <td style="color: var(--text-muted);">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #eff6ff; color: #2563eb;">SA</div>
                            <span class="user-name-title">Sofia Andersson</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">GMAT Critical Reasoning & Data Sufficiency</td>
                    <td><strong style="color: #111827;">$12.99</strong></td>
                    <td><strong style="color: #16a34a;">$2.60</strong></td>
                    <td><span class="status-badge status-pending">razorpay</span></td>
                    <td style="color: var(--text-muted);">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #dcfce7; color: #16a34a;">MB</div>
                            <span class="user-name-title">Marcus Brown</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">IELTS Academic — Reading & Grammar</td>
                    <td><strong style="color: #111827;">$7.99</strong></td>
                    <td><strong style="color: #16a34a;">$1.60</strong></td>
                    <td><span class="status-badge status-active">stripe</span></td>
                    <td style="color: var(--text-muted);">20 Jun 2026, 20:23</td>
                </tr>
                <tr>
                    <td>
                        <div class="user-cell-wrapper">
                            <div class="user-avatar-initials" style="background-color: #fef3c7; color: #d97706;">ST</div>
                            <span class="user-name-title">Student 7</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">Data Structures & Algorithms</td>
                    <td><strong style="color: #111827;">$299.00</strong></td>
                    <td><strong style="color: #16a34a;">$59.80</strong></td>
                    <td><span class="status-badge status-active">stripe</span></td>
                    <td style="color: var(--text-muted);">20 Jun 2026, 14:12</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
