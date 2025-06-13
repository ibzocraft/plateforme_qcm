<?php
    require_once __DIR__ . '/../../includes/layout/page.php';
    require_once __DIR__ . '/../../includes/database/db.php';

    if (!is_authenticated()) redirect(get_full_url("pages/auth/connection.php"));
    if (!is_admin()) redirect(get_full_url("pages/portail/dashboard.php"));
?>

<!-- DEBUT PAGE -->
<?php begin_page("Exemple") ?>
<?php include_once __DIR__ . '/../../includes/layout/header_admin.php'; ?>
<!-- /DEBUT PAGE -->


<!-- CONTENU DE LA PAGE -->
<div class="container-fluid p-4 mb-5">
    <div class="row p-4 justify-content-between">
        <div class="col-8">
            <p class="text-custom-dark tracking-light fs-2 fw-bold leading-tight min-w-72">Bonjour, Ibrahim</p>
        </div>

        <div class="col-4">
            
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Summary</h6>
                    <h2 class="card-title">3.55K <small class="text-danger fs-6 align-bottom"><i class="bi bi-arrow-down"></i> 59%</small></h2>
                    <p class="card-text text-muted small">Last week 84,70K</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Engagement</h6>
                    <h2 class="card-title">14.15K <small class="text-success fs-6 align-bottom"><i class="bi bi-arrow-up"></i> 0,5%</small></h2>
                    <p class="card-text text-muted small">Last week 242,99K</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Customers</h6>
                    <h2 class="card-title">0.5M <small class="text-success fs-6 align-bottom"><i class="bi bi-arrow-up"></i> 1,0%</small></h2>
                    <p class="card-text text-muted small">Last week 84,70K</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Churn</h6>
                    <h2 class="card-title">325K <small class="text-danger fs-6 align-bottom"><i class="bi bi-arrow-down"></i> 30%</small></h2>
                    <p class="card-text text-muted small">Last week 950K</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Revenue Chart -->
        <div class="col-lg-7">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="card-subtitle text-muted">Revenue</h6>
                            <h5 class="card-title">$35.550 <small class="text-success">+6%</small></h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="revenue-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                This Year
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="revenue-dropdown">
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex-grow-1" style="position: relative;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Chart -->
        <div class="col-lg-5">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="card-subtitle text-muted">Activity</h6>
                            <h5 class="card-title">4,535 <small class="text-danger">-16%</small></h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="activity-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                This Week
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="activity-dropdown">
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex-grow-1" style="position: relative;">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Audience Insight Chart -->
        <div class="col-lg-7">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Audience Insight <i class="bi bi-info-circle"></i></h6>
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots"></i></button>
                    </div>
                    <div class="flex-grow-1" style="position: relative;">
                        <canvas id="audienceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="col-lg-5">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Transaction history</h6>
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots"></i></button>
                    </div>
                    <ul class="list-unstyled">
                        <li class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:30px; height:30px;"><i class="bi bi-check-lg"></i></div>
                                <div>
                                    <p class="mb-0 small">Payment from <a href="#" class="text-decoration-none">#05896</a></p>
                                    <p class="mb-0 text-muted small">Feb 14, 01:30 PM</p>
                                </div>
                            </div>
                            <span>$95.00</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-warning rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:30px; height:30px;"><i class="bi bi-arrow-clockwise"></i></div>
                                <div>
                                    <p class="mb-0 small">Payment from <a href="#" class="text-decoration-none">#05896</a></p>
                                    <p class="mb-0 text-muted small">Feb 14, 01:30 PM</p>
                                </div>
                            </div>
                            <span>$95.00</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-danger rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:30px; height:30px;"><i class="bi bi-x-lg"></i></div>
                                <div>
                                    <p class="mb-0 small">Payment from <a href="#" class="text-decoration-none">#05896</a></p>
                                    <p class="mb-0 text-muted small">Feb 14, 01:30 PM</p>
                                </div>
                            </div>
                            <span>$95.00</span>
                        </li>
                         <li class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-danger rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:30px; height:30px;"><i class="bi bi-x-lg"></i></div>
                                <div>
                                    <p class="mb-0 small">Payment from <a href="#" class="text-decoration-none">#05896</a></p>
                                    <p class="mb-0 text-muted small">Feb 14, 01:30 PM</p>
                                </div>
                            </div>
                            <span>$95.00</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /CONTENU DE LA PAGE -->

<!-- 
<style>
    .card {
        background-color: #161b22 !important;
        border: 1px solid #30363d !important;
    }

    .text-muted {
        color: #8b949e !important;
    }

    .btn-outline-secondary {
        color: #8b949e;
        border-color: #30363d;
    }

    .btn-outline-secondary:hover {
        background-color: #30363d;
        color: #c9d1d9;
    }
    
    .dropdown-menu-dark {
        background-color: #161b22;
        border-color: #30363d;
    }

    .dropdown-item:hover {
        background-color: #30363d;
    }

    a {
        color: #58a6ff;
    }
</style> -->

<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../includes/layout/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const gridColor = 'rgba(255, 255, 255, 0.1)';
        const fontColor = '#8b949e';

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [20, 40, 35, 60, 45, 80, 70, 50, 65, 55, 75, 60],
                    borderColor: '#58a6ff',
                    backgroundColor: 'rgba(88, 166, 255, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#58a6ff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: fontColor
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            color: fontColor,
                            beginAtZero: true
                        }
                    }
                }
            }
        });

        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        new Chart(activityCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Activity',
                    data: [8, 4, 9, 5, 4, 7, 9],
                    backgroundColor: '#58a6ff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: fontColor
                        }
                    },
                    y: {
                         grid: {
                            color: gridColor
                        },
                        ticks: {
                            color: fontColor,
                             stepSize: 5,
                        }
                    }
                }
            }
        });

        // Audience Insight Chart
        const audienceCtx = document.getElementById('audienceChart').getContext('2d');
        new Chart(audienceCtx, {
            type: 'bar',
            data: {
                labels: ['Dec 25', 'Dec 26', 'Dec 27', 'Dec 28', 'Dec 29', 'Dec 30', 'Dec 31'],
                datasets: [{
                    label: 'Men',
                    data: [70, 65, 70, 65, 75, 85, 80],
                    backgroundColor: '#58a6ff',
                    borderRadius: 4
                }, {
                    label: 'Woman',
                    data: [95, 90, 85, 95, 90, 110, 100],
                    backgroundColor: '#a371f7',
                    borderRadius: 4
                }, {
                    label: 'Not Specific',
                    data: [110, 100, 108, 109, 85, 102, 95],
                    backgroundColor: '#f1e05a',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                 plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: fontColor,
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    }
                },
                scales: {
                     x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: fontColor
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            color: fontColor,
                            beginAtZero: true,
                        }
                    }
                }
            }
        });
    });
</script>

<?php end_page() ?>
<!-- /FIN PAGE -->
