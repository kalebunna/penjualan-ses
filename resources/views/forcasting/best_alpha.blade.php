@extends('layouts.dashboard.main')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Analisis Alpha</h3>
                <p class="text-subtitle text-muted">Menemukan nilai alpha dengan metrik error (MSE, MAD, MAPE) terbaik.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('forcasting.index') }}">Forcasting</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Analisis Alpha</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        @if($best_alpha)
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4 class="card-title text-white">Alpha Terbaik Ditemukan!</h4>
                    <p>Nilai alpha dengan error terkecil adalah <strong>{{ $best_alpha['alpha'] }}</strong> dengan metrik error sebagai berikut:</p>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h5 class="text-white mb-1">MSE</h5>
                                <p class="mb-0"><strong>{{ number_format($best_alpha['mse'], 2, ',', '.') }}</strong></p>
                                <small class="text-white-50">Mean Squared Error</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h5 class="text-white mb-1">MAD</h5>
                                <p class="mb-0"><strong>{{ number_format($best_alpha['mad'], 2, ',', '.') }}</strong></p>
                                <small class="text-white-50">Mean Absolute Deviation</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h5 class="text-white mb-1">MAPE</h5>
                                <p class="mb-0"><strong>{{ number_format($best_alpha['mape'], 2, ',', '.') }}%</strong></p>
                                <small class="text-white-50">Mean Absolute Percentage Error</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card bg-warning">
                <div class="card-body">
                    <h4 class="card-title">Belum Ada Alpha yang Di-forecast</h4>
                    <p>Lakukan forecasting setidaknya pada satu nilai alpha untuk dapat melakukan analisis.</p>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tabel Metrik Error per Alpha</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-alpha">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nilai Alpha</th>
                                <th>MSE (Mean Squared Error)</th>
                                <th>MAD (Mean Absolute Deviation)</th>
                                <th>MAPE (Mean Absolute Percentage Error)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alpha_results as $index => $result)
                                <tr class="{{ ($best_alpha && $result['alpha'] == $best_alpha['alpha']) ? 'table-success' : '' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $result['alpha'] }}</td>
                                    <td>{{ $result['mse'] !== null ? number_format($result['mse'], 2, ',', '.') : '-' }}</td>
                                    <td>{{ $result['mad'] !== null ? number_format($result['mad'], 2, ',', '.') : '-' }}</td>
                                    <td>{{ $result['mape'] !== null ? number_format($result['mape'], 2, ',', '.') . '%' : '-' }}</td>
                                    <td>
                                        @if($result['status'] == 'Sudah di-forecast')
                                            <span class="badge bg-success">{{ $result['status'] }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $result['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection 