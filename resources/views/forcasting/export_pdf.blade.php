<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Forecasting</title>
    <style>
        @page {
            margin: 20px;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        
        .header h2 {
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            color: #7f8c8d;
        }
        
        .info-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
        }
        
        .info-section h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .info-section p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 10px;
        }
        
        .data-table th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .data-table tr:hover {
            background-color: #e8f4f8;
        }
        
        .summary-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #e8f6f3;
            border: 1px solid #27ae60;
            border-radius: 5px;
        }
        
        .summary-section h3 {
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
            color: #27ae60;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .summary-item {
            background-color: white;
            padding: 10px;
            border-radius: 3px;
            border-left: 3px solid #27ae60;
        }
        
        .summary-item strong {
            color: #2c3e50;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN FORECASTING</h1>
        <h2>Sistem Exponential Smoothing</h2>
    </div>
    
    <!-- Info Section -->
    <div class="info-section">
        <h3>Informasi Laporan</h3>
        <p><strong>Tanggal Export:</strong> {{ date('d F Y H:i:s') }}</p>
        <p><strong>Filter Data:</strong> 
            @if($filterInfo['hasFilter'])
                Parameter Alpha = {{ $filterInfo['alpha'] }}
            @else
                Semua Data
            @endif
        </p>
        <p><strong>Total Data:</strong> {{ count($data) }} record</p>
        <p><strong>Metode:</strong> Single Exponential Smoothing</p>
    </div>
    
    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Periode</th>
                <th>Aktual</th>
                <th>Forecasting</th>
                <th>Error</th>
                <th>Parameter</th>
                <th>MAD</th>
                <th>MSE</th>
                <th>MAPE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->preode)->format('F Y') }}</td>
                <td>{{ number_format($row->actual, 0, ',', '.') }}</td>
                <td>{{ number_format($row->forcas_result, 2, ',', '.') }}</td>
                <td>{{ number_format($row->err, 2, ',', '.') }}</td>
                <td>{{ $row->parameter->alpha }}</td>
                <td>{{ number_format($row->MAD, 2, ',', '.') }}</td>
                <td>{{ number_format($row->MSE, 2, ',', '.') }}</td>
                <td>{{ number_format($row->MAP, 2, ',', '.') }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Summary Section -->
    <div class="summary-section">
        <h3>Ringkasan Prediksi Bulan Selanjutnya</h3>
        
        <div class="summary-grid">
            <div class="summary-item">
                <strong>Bulan Prediksi:</strong><br>
                {{ $nextMonthPrediction['month'] }}
            </div>
            
            <div class="summary-item">
                <strong>Nilai Prediksi:</strong><br>
                {{ number_format($nextMonthPrediction['value'], 2, ',', '.') }}
            </div>
        </div>
        
        <div class="summary-grid">
            <div class="summary-item">
                <strong>Parameter Alpha:</strong><br>
                {{ $nextMonthPrediction['alpha'] }}
            </div>
            
            <div class="summary-item">
                <strong>Akurasi Model:</strong><br>
                MAPE: {{ number_format($nextMonthPrediction['mape'], 2, ',', '.') }}%
            </div>
        </div>
        
        <p><strong>Metode Perhitungan:</strong> Single Exponential Smoothing dengan parameter alpha {{ $nextMonthPrediction['alpha'] }}</p>
        <p><strong>Interpretasi:</strong> Prediksi nilai untuk bulan {{ $nextMonthPrediction['month'] }} adalah {{ number_format($nextMonthPrediction['value'], 2, ',', '.') }} berdasarkan pola data historis yang telah dianalisis.</p>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Forecasting pada {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>