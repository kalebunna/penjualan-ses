@extends('layouts.dashboard.main')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Forcasting</h3>
                <p class="text-subtitle text-muted">Data Forcasting.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Forcasting</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header pb-0">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h5 class="card-title">Data Parameter</h5>
                    <p class="text-subtitle text-muted">pilih parameter sebelum melakukan forcasting.</p>
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:void(0)" id="forcasting">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <div class="flex-grow-1">
                            <label for="parameter" class="form-label">Parameter</label>
                            <select class="form-select" id="parameter" aria-label="Default select example">
                                <option selected disabled>Open this select menu</option>
                                @foreach($parameters as $parameter)
                                    <option id="parameter" value="{{ $parameter->id }}">{{ $parameter->alpha }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label d-block invisible">Submit</label>
                            <button type="submit" class="btn btn-primary">Forcas</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-center">
                <h5 class="card-title">Hasil Forcasting</h5>
                <div class="flex accordion-item">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Filter
                    </button>
                </div>
            </div>
            <div id="flush-collapseOne" class="accordion-collapse collapse flex flex-col col-12 px-4 pb-4"
                 aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <form action="javascript:void(0)" id="filter">
                        <div class="row">
                            <div class="col-12 col-md-3 ms-auto ">
                                <label for="parameter" class="form-label">Parameter</label>
                                <select class="form-select" id="parameter-filter" aria-label="Default select example">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach($parameters as $parameter)
                                        <option value="{{ $parameter->id }}">{{ $parameter->alpha }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Preode</th>
                            <th>Aktual</th>
                            <th>Forcasting</th>
                            <th>Error</th>
                            <th>Parameter</th>
                            <th>MAD</th>
                            <th>MSE</th>
                            <th>MAPE</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        let table;
        $(function () {
            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{{ route('forcasting.index') }}',
                    type: "GET",
                    data: function (d) {
                        d.parameter = $('#parameter-filter').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {
                        data: 'preode',
                        name: 'preode',
                        render: function (data, type, row) {
                            return new Date(data).toLocaleDateString('id-ID',{
                                month: 'long',
                                year: 'numeric'
                            });
                        }
                    },
                    {data: 'actual', name: 'aktual'},
                    {data: 'forcas_result', name: 'forcasting'},
                    {data: 'err', name: 'error'},
                    {data: 'parameter.alpha', name: 'alpha'},
                    {data: 'MAD', name: 'mad'},
                    {data: 'MSE', name: 'mse'},
                    {
                        data: 'MAP',
                        name: 'mape',
                        render: function (data, type, row) {
                            return parseFloat(data) + '%';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            return`
                            <a href="javascript:void(0)" onclick="deleteData(${data})" data-id="${data}" class="btn btn-danger btn-sm">
                                <span class="bi bi-trash"></span>
                            </a>`
                        }
                    }
                ],
                language: {
                    emptyTable: "Data Tidak Tersedia",
                }
            });
            $('#parameter-filter').on('change', function (e) {
                table.ajax.reload();
            });

            $('#forcasting').on('submit', function (e) {
                e.preventDefault();
                const parameter = $('#parameter').val();
                $.ajax({
                    url: "{{ route('forcasting.create') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_parameter: parameter
                    },
                    success: function (response) {
                        table.ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Berhasil di tambahkan'
                        })
                    },
                    error: function (xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: `Data Gagal Ditambahkan`
                        })
                    }
                });
            });
        });
        function deleteData(id) {
            Swal.fire({
                title: 'Hapus Data',
                text: "Apakah anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('forcasting.delete', ':id') }}".replace(':id', id),
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            table.ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Berhasil di hapus'
                            })
                        },
                        error: function (xhr) {
                            Toast.fire({
                                icon: 'error',
                                title: `Data Gagal dihapus`
                            })
                        }
                    });
                }
            })
        }
    </script>
@endsection
