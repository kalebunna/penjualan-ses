@extends('layouts.dashboard.main')
@section('content')
    <div class="page-heading">
        <h3>Profile Statistics</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldSetting"></i> <!-- Ikon untuk parameter -->
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Parameter</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalParameters }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldBag"></i> <!-- Ikon penjualan -->
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Penjualan</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalPenjualan }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldCalendar"></i> <!-- Ikon kalender -->
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        @isset($penjualan)
                                            <h6 class="text-muted font-semibold">Penjualan
                                                {{ \Carbon\Carbon::createFromFormat('Y-m', $penjualan->last()->bulan)->translatedFormat('F Y') }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ $penjualan->last()->total }}</h6>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldGraph"></i> <!-- Ikon grafik/prediksi -->
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        @isset($prediksiPenjualan)
                                            <h6 class="text-muted
                                        <h6 class="text-muted
                                                font-semibold">Prediksi
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $prediksiPenjualan->preode)->locale('id')->translatedFormat('F Y') }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ $prediksiPenjualan->forcas_result }}</h6>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-penjualan"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Forcasting</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-forcasting"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        let optionsPenjualan = {
            series: [{
                name: 'Penjualan',
                data: @isset($penjualan)
                    @json($penjualan->pluck('total'))
                @endisset
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @isset($penjualan)
                    @json($penjualan->pluck('bulan')),
                @endisset
            },
            yaxis: {
                title: {
                    text: 'Penjualan'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };

        let areaOptions = {
            series: {!! json_encode($series) !!},
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'category',
                categories: {!! json_encode($categories) !!},
            },
            tooltip: {
                x: {
                    format: 'MMMM yyyy'
                }
            },
        }

        let chart = new ApexCharts(document.querySelector("#chart-penjualan"), optionsPenjualan);
        chart.render();

        let chart2 = new ApexCharts(document.querySelector("#chart-forcasting"), areaOptions);
        chart2.render();
    </script>
@endsection
