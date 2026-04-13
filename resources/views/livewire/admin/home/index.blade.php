@extends('livewire.admin.layouts.master')

@section('header-links')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
@endsection

@section('custom-style')
    <style>
        .dash-wrap {
            background: #f7f8fa;
            min-height: 100vh;
        }
        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 22px 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 18px;
            transition: box-shadow 0.2s;
        }
        .stat-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1.2;
        }
        .stat-label {
            font-size: 0.82rem;
            color: #888;
            margin-top: 2px;
        }
        .stat-sub {
            font-size: 0.75rem;
            color: #aaa;
            margin-top: 2px;
        }
        .panel {
            background: #fff;
            border-radius: 10px;
            padding: 22px 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            margin-bottom: 20px;
        }
        .panel-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 16px;
        }
        .rank-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .rank-table thead th {
            font-size: 0.78rem;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 8px 12px;
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
        }
        .rank-table tbody td {
            font-size: 0.88rem;
            color: #333;
            padding: 10px 12px;
            border-bottom: 1px solid #f7f7f7;
        }
        .rank-table tbody tr:last-child td {
            border-bottom: none;
        }
        .rank-badge {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="col-12 dash-wrap py-4 px-8">
        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-4 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #eef7f4; color: #32705f;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalFarmers }}</div>
                        <div class="stat-label">कुल कृषक</div>
                        <div class="stat-sub">सक्रिय {{ $activeFarmers }} · निष्क्रिय {{ $inactiveFarmers }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #eef2fb; color: #3b6cb5;">
                        <i class="fa-solid fa-glass-water"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalMilkCollected }}</div>
                        <div class="stat-label">कुल दूध (लिटर)</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #f5eefb; color: #7c3aad;">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div>
                        <div class="stat-value">रु {{ $totalMilkIncome }}</div>
                        <div class="stat-label">कुल दूध आम्दानी</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fef4e8; color: #c67e1a;">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalEmployees }}</div>
                        <div class="stat-label">कुल कर्मचारी</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-4">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #e8f8f2; color: #1a9a6e;">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <div class="stat-value">रु {{ $totalAccountBalance }}</div>
                        <div class="stat-label">कुल खाता शेष</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #e8f5ed; color: #27ae60;">
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                    <div>
                        <div class="stat-value">रु {{ $totalDeposits }}</div>
                        <div class="stat-label">कुल जम्मा</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fbeaea; color: #c0392b;">
                        <i class="fa-solid fa-arrow-up"></i>
                    </div>
                    <div>
                        <div class="stat-value">रु {{ $totalWithdrawals }}</div>
                        <div class="stat-label">कुल झिकिएको</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 1 --}}
        <div class="row g-3 mb-3">
            <div class="col-12 col-xl-8">
                <div class="panel">
                    <div class="panel-title">दूध संकलन प्रवृत्ति</div>
                    <canvas id="milkTrendChart" height="110"></canvas>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="panel">
                    <div class="panel-title">कृषक लिङ्ग वितरण</div>
                    <canvas id="genderChart" height="210"></canvas>
                </div>
            </div>
        </div>

        {{-- Charts Row 2 --}}
        <div class="row g-3 mb-3">
            <div class="col-12 col-xl-6">
                <div class="panel">
                    <div class="panel-title">बिहान vs साझ दूध संकलन</div>
                    <canvas id="timeChart" height="180"></canvas>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="panel">
                    <div class="panel-title">कारोबार प्रवृत्ति</div>
                    <canvas id="transactionChart" height="180"></canvas>
                </div>
            </div>
        </div>

        {{-- Bottom Row --}}
        <div class="row g-3 mb-3">
            <div class="col-12 col-xl-6">
                <div class="panel">
                    <div class="panel-title">शीर्ष ५ कृषक</div>
                    <table class="rank-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>नाम</th>
                                <th>कृ.न.</th>
                                <th>दूध (लि.)</th>
                                <th>रकम (रु.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topFarmers as $i => $farmer)
                                <tr>
                                    <td>
                                        <span class="rank-badge" style="background: {{ ['#f4c430','#a8a8a8','#c0835d','#32705f','#3b6cb5'][$i] ?? '#ccc' }}">
                                            {{ $i + 1 }}
                                        </span>
                                    </td>
                                    <td>{{ $farmer->user->owner_name ?? '-' }}</td>
                                    <td>{{ $farmer->user->farmer_number ?? '-' }}</td>
                                    <td>{{ \App\Helpers\NumberHelper::toNepaliNumber($farmer->total_milk) }}</td>
                                    <td>{{ \App\Helpers\NumberHelper::toNepaliNumber($farmer->total_income) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center" style="color:#aaa">डाटा उपलब्ध छैन</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="panel">
                    <div class="panel-title">बिहान vs साझ आम्दानी</div>
                    <canvas id="incomeDonutChart" height="210"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = 'inherit';
            Chart.defaults.color = '#888';

            const c = {
                primary: '#32705f',
                blue: '#3b6cb5',
                green: '#27ae60',
                red: '#c0392b',
                orange: '#f39c12',
                dark: '#34495e',
            };

            // Milk Trend
            new Chart(document.getElementById('milkTrendChart'), {
                type: 'line',
                data: {
                    labels: @json($recentDates),
                    datasets: [
                        {
                            label: 'दूध (लिटर)',
                            data: @json($dailyMilkQuantities),
                            borderColor: c.primary,
                            backgroundColor: 'rgba(50,112,95,0.08)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderWidth: 2,
                            borderWidth: 2,
                        },
                        {
                            label: 'आम्दानी (रु.)',
                            data: @json($dailyMilkIncome),
                            borderColor: c.blue,
                            backgroundColor: 'rgba(59,108,181,0.08)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderWidth: 2,
                            borderWidth: 2,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f3f3f3' }, ticks: { font: { size: 11 } } },
                        y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, ticks: { font: { size: 11 } } },
                        x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                    },
                    plugins: { legend: { labels: { boxWidth: 10, padding: 16, font: { size: 12 } } } }
                }
            });

            // Gender Pie
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: ['पुरुष', 'महिला', 'अन्य'],
                    datasets: [{
                        data: [{{ $maleCount }}, {{ $femaleCount }}, {{ $otherCount }}],
                        backgroundColor: [c.blue, '#e74c3c', c.orange],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '60%',
                    plugins: { legend: { position: 'bottom', labels: { padding: 14, font: { size: 12 }, boxWidth: 10 } } }
                }
            });

            // Morning vs Evening Bar
            new Chart(document.getElementById('timeChart'), {
                type: 'bar',
                data: {
                    labels: ['दूध (लिटर)', 'आम्दानी (रु.)'],
                    datasets: [
                        {
                            label: 'बिहान',
                            data: [{{ $morningMilk }}, {{ $morningIncome }}],
                            backgroundColor: 'rgba(243, 156, 18, 0.75)',
                            borderRadius: 6,
                            barPercentage: 0.5,
                        },
                        {
                            label: 'साझ',
                            data: [{{ $eveningMilk }}, {{ $eveningIncome }}],
                            backgroundColor: 'rgba(52, 73, 94, 0.75)',
                            borderRadius: 6,
                            barPercentage: 0.5,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f3f3f3' }, ticks: { font: { size: 11 } } },
                        x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                    },
                    plugins: { legend: { labels: { boxWidth: 10, padding: 16, font: { size: 12 } } } }
                }
            });

            // Transaction Trend
            new Chart(document.getElementById('transactionChart'), {
                type: 'line',
                data: {
                    labels: @json($recentTransactions),
                    datasets: [
                        {
                            label: 'जम्मा',
                            data: @json($dailyDeposits),
                            borderColor: c.green,
                            backgroundColor: 'rgba(39,174,96,0.08)',
                            fill: true,
                            tension: 0.35,
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderWidth: 2,
                        },
                        {
                            label: 'झिकिएको',
                            data: @json($dailyWithdrawals),
                            borderColor: c.red,
                            backgroundColor: 'rgba(192,57,43,0.08)',
                            fill: true,
                            tension: 0.35,
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderWidth: 2,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f3f3f3' }, ticks: { font: { size: 11 } } },
                        x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                    },
                    plugins: { legend: { labels: { boxWidth: 10, padding: 16, font: { size: 12 } } } }
                }
            });

            // Income Doughnut
            new Chart(document.getElementById('incomeDonutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['बिहान आम्दानी', 'साझ आम्दानी'],
                    datasets: [{
                        data: [{{ $morningIncome }}, {{ $eveningIncome }}],
                        backgroundColor: ['rgba(243,156,18,0.8)', 'rgba(52,73,94,0.8)'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '60%',
                    plugins: { legend: { position: 'bottom', labels: { padding: 14, font: { size: 12 }, boxWidth: 10 } } }
                }
            });
        });
    </script>
@endpush
