@extends('layouts.dashboard.main')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
                <p class="text-subtitle text-muted">{{ $greeting }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Grafik Penjualan Bulanan</h4>
                            <div class="d-flex align-items-center">
                                <label for="sales-year-filter" class="form-label me-2 mb-0">Tahun:</label>
                                <select class="form-select form-select-sm" id="sales-year-filter" style="width: 100px;">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Grafik Perbandingan Aktual vs. Forecast</h4>
                    </div>
                    <div class="card-body">
                        <form id="forecast-chart-form">
                            <div class="row align-items-end">
                                <div class="col-md-5">
                                    <label for="forecast-year-filter" class="form-label">Tahun:</label>
                                    <select class="form-select" id="forecast-year-filter">
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="alpha-selector" class="form-label">Pilih Nilai Alpha:</label>
                                    <select class="form-select" id="alpha-selector">
                                        <option value="" selected disabled>Pilih satu alpha</option>
                                        @foreach($parameters as $parameter)
                                            <option value="{{ $parameter->id }}">{{ $parameter->alpha }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                        <div id="forecast-chart-info" class="mb-3 mt-4"></div>
                        <div style="position: relative; height: 450px; width: 100%;">
                            <canvas id="forecastChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const numberFormat = (value) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);

            // --- Sales Chart ---
            let salesChart;
            const salesCanvas = document.getElementById('salesChart').getContext('2d');
            const salesYearFilter = document.getElementById('sales-year-filter');
            
            async function fetchSalesData(year) {
                const response = await fetch(`{{ route('dashboard.sales_chart') }}?year=${year}`);
                const data = await response.json();
                
                if (salesChart) {
                    salesChart.destroy();
                }

                salesChart = new Chart(salesCanvas, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Total Penjualan',
                            data: data.data,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { callback: (value) => numberFormat(value) }
                            }
                        },
                        plugins: {
                            tooltip: { callbacks: { label: (context) => numberFormat(context.raw) } }
                        }
                    }
                });
            }

            salesYearFilter.addEventListener('change', (e) => {
                fetchSalesData(e.target.value);
            });
            // Initial load for sales chart
            fetchSalesData(salesYearFilter.value);


            // --- Forecast vs Actual Chart ---
            const forecastCanvas = document.getElementById('forecastChart').getContext('2d');
            const forecastForm = document.getElementById('forecast-chart-form');

            // Initialize the forecast chart instance ONCE with a default configuration.
            let forecastChart = new Chart(forecastCanvas, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 0 // Disable animation during updates to prevent glitches
                    },
                    resizeDelay: 0,
                    onResize: null,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { callback: (value) => numberFormat(value) }
                        }
                    },
                    plugins: {
                        title: { display: true, text: 'Perbandingan Aktual vs. Forecast', font: { size: 16 } },
                        tooltip: { callbacks: { label: (context) => `${context.dataset.label}: ${numberFormat(context.raw)}` } }
                    }
                }
            });

            async function updateForecastChart(year, alphaId) {
                const infoContainer = document.getElementById('forecast-chart-info');
                infoContainer.innerHTML = `<div class="alert alert-light-secondary">Memuat data grafik...</div>`;

                const response = await fetch(`{{ route('dashboard.forecast_chart') }}?year=${year}&alpha_id=${alphaId}`);
                const data = await response.json();
                
                infoContainer.innerHTML = '';

                if (!response.ok) {
                    infoContainer.innerHTML = `<div class="alert alert-light-warning">${data.message || 'Gagal memuat data.'}</div>`;
                    forecastChart.data.labels = [];
                    forecastChart.data.datasets = [];
                    forecastChart.update();
                    return;
                }
                
                forecastChart.options.plugins.title.text = `Perbandingan Aktual vs. Forecast (α=${data.alpha}) untuk Tahun ${year}`;
                forecastChart.data.labels = data.labels;
                forecastChart.data.datasets = [
                    {
                        label: 'Data Aktual',
                        data: data.actuals,
                        borderColor: '#FF6384',
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        tension: 0.1,
                        fill: false,
                        borderWidth: 2
                    },
                    {
                        label: `Forecast (α=${data.alpha})`,
                        data: data.forecasts,
                        borderColor: '#4BC0C0',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.1,
                        fill: false,
                        borderDash: [5, 5],
                        borderWidth: 2
                    }
                ];
                
                forecastChart.update();
            }
            
            forecastForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const year = document.getElementById('forecast-year-filter').value;
                const selectedAlphaId = document.getElementById('alpha-selector').value;

                if (!selectedAlphaId) {
                    const infoContainer = document.getElementById('forecast-chart-info');
                    infoContainer.innerHTML = `<div class="alert alert-light-danger">Peringatan: Silakan pilih nilai alpha untuk ditampilkan.</div>`;
                    forecastChart.data.labels = [];
                    forecastChart.data.datasets = [];
                    forecastChart.update();
                    return;
                }
                
                updateForecastChart(year, selectedAlphaId);
            });
        });
    </script>
@endsection 