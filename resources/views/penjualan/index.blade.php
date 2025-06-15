@extends('layouts.dashboard.main')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Penjualan</h3>
                <p class="text-subtitle text-muted">Semua Data Penjualan.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-center">
                <h5 class="card-title">Data Penjualan</h5>
                <div class="flex">
                    <a class="btn btn-primary" id="tambah-data" data-bs-toggle="modal" data-bs-target="#insertModal">
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
                            <th>Tanggal</th>
                            <th>Total Penjualan</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @include('penjualan.insert')
    @include('penjualan.update')
@endsection

@section('script')
    <script>
        let table;
        $(function () {
            // Inisialisasi DataTables
            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: "{{ route('penjualan.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        render: function(data, type, row) {
                            if (!data) return '';

                            const date = new Date(data);
                            const day = String(date.getDate()).padStart(2, '0');
                            const monthNames = [
                                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                            ];
                            const month = monthNames[date.getMonth()];
                            const year = date.getFullYear();

                            return `${day} ${month} ${year}`;
                        }
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            console.log(data)
                            return `
                         <a href="javascript:void(0)" onclick="editPenjualan(${data})" data-id="${data}" class="btn btn-primary btn-sm">
                            <span class="bi bi-pencil"></span>
                        </a>
                        <a href="javascript:void(0)" onclick="deletePenjualan(${data})" data-id="${data}" class="btn btn-danger btn-sm">
                            <span class="bi bi-trash"></span>
                        </a>`
                        }
                    }
                ],
                language: {
                    emptyTable: "Data Masih Kosong"
                }
            });


            // Handler submit form
            $('#formInsert').on('submit', function (e) {
                e.preventDefault();
                const tanggal = $('#date').val();
                const total = $('#total').val();

                $.ajax({
                    url: "{{ route('penjualan.store') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        total: total
                    },
                    success: function (res) {
                        $('#insertModal').modal('hide');
                        $('#formInsert')[0].reset();
                        table.ajax.reload();
                        Toast.fire({
                            icon:'success',
                            title: 'Data Berhasil di tambahkan'
                        })
                    },
                    error: function (xhr) {
                       Toast.fire({
                           icon:'error',
                           title: `Data Gagal Ditambahkan`
                       })
                    }
                });
            });

            $('#formEdit').on('submit', function (e){
                e.preventDefault()
                const id = $('#editId').val()
                const tanggal = $('#editDate').val();
                const total  = $('#editTotal').val();
                console.log(id)
                $.ajax({
                    url:'{{route('penjualan.update',':id')}}'.replace(':id', id),
                    type:'PUT',
                    data:{
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        total: total
                    },
                    success: function (res){
                        $('#updateModal').modal('hide');
                        $('#formEdit')[0].reset();
                        table.ajax.reload();
                        Toast.fire({
                            icon:'success',
                            title: 'Data Berhasil di tambahkan'
                        })
                    },
                    error: function (xhr){
                        Toast.fire({
                            icon:'error',
                            title: `Data Gagal Ditambahkan`
                        })
                    }
                })
            });
        });
        function editPenjualan(id){
            const url = '{{route('penjualan.edit', ':id')}}'.replace(':id', id);
            $.get(url, function (data){
                $('#editId').val(data.data.id);
                $('#editDate').val(data.data.tanggal);
                $('#editTotal').val(data.data.total);
                $('#updateModal').modal('show');
            })
                .fail(function (data){
                    console.log(data)
                })
        }

        function deletePenjualan(id){
            $.ajax({
                url:'{{route('penjualan.destroy', ':id')}}'.replace(':id', id),
                type:'DELETE',
                data:{
                    _token:"{{csrf_token()}}"
                },
                success: function (res){
                    table.ajax.reload()
                    Toast.fire({
                        icon:'success',
                        title:'Data Berhasil dihapus'
                    })
                },
                error: function (){
                    Toast.fire({
                        icon:'error',
                        title:'Gagal menghapus data'
                    })
                }
            })

        }
    </script>
@endsection
