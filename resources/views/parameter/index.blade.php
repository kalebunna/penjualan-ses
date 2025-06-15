@extends('layouts.dashboard.main')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Parameter</h3>
                <p class="text-subtitle text-muted">Semua Data Parameter.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Parameter</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-center">
                <h5 class="card-title">Data Parameter</h5>
                <div class="flex">
                    <a class="btn btn-primary" id="tambah-data" data-bs-toggle="modal" data-bs-target="#parameterModal">
                        <span class="bi bi-plus"></span> Tambah Data
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Parameter</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @include('parameter.insert')
    @include('parameter.update')
@endsection
@section('script')
    <script>
        let table;
        $(function() {
            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('parameter.index') }}",
                    type: "GET",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'alpha', name: 'parameter'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            console.log(data)
                            return `
                         <a href="javascript:void(0)" onclick="editParameter(${data})" data-id="${data}" class="btn btn-primary btn-sm">
                            <span class="bi bi-pencil"></span>
                        </a>
                        <a href="javascript:void(0)" onclick="deleteParameter(${data})" data-id="${data}" class="btn btn-danger btn-sm">
                            <span class="bi bi-trash"></span>
                        </a>`
                        }
                    },
                ],
                language: {
                    emptyTable: "Data Tidak Tersedia",
                }
            });

            $('#parameterForm').on('submit', function (e) {
                e.preventDefault();
                const alpha = $('#alpha').val();
                if (alpha > 1 || alpha < 0) {
                    Toast.fire({
                        icon: 'error',
                        title: `Data Tidak Valid`
                    })
                }else {
                $.ajax({
                    url: "{{ route('parameter.store') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        alpha: alpha
                    },
                    success: function (response) {
                            $('#parameterModal').modal('hide');
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
                }
            });

            $('#formUpdate').on('submit', function (e) {
                e.preventDefault();
                const alpha = $('#alphaEdit').val();
                const id = $('#idParameter').val();
                if (alpha > 1 || alpha < 0) {
                    Toast.fire({
                        icon: 'error',
                        title: `Data Tidak Valid`
                    })
                }else {
                $.ajax({
                    url: "{{ route('parameter.update', ':id') }}".replace(':id', id),
                    type: "PUT",
                    data: {
                        _token: '{{ csrf_token() }}',
                        alpha: alpha
                    },
                    success: function (response) {
                            $('#updateModal').modal('hide');
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
                }
            });
        });

        function editParameter(id) {
            $('#updateModal').modal('show')
            $.ajax({
                url: "{{ route('parameter.edit', ':id') }}".replace(':id', id),
                type: "GET",
                success: function (response) {
                    $('#alphaEdit').val(response.data.alpha);
                    $('#idParameter').val(response.data.id);
                },
                error: function (xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: `Data Gagal Ditambahkan`
                    })
                }
            });

        }

        function deleteParameter(id) {
            $.ajax({
                url: "{{ route('parameter.destroy', ':id') }}".replace(':id', id),
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    table.ajax.reload();
                    Toast.fire({
                        icon: 'success',
                        title: 'Data Berhasil dihapus'
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
    </script>
@endsection
