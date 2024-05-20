@extends('layouts.app')

@section('title', 'Kategori Data')

@push('links')
    <link rel="stylesheet" href="{{ asset('dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
@endpush

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Kategori Data</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Beranda Dasbor</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Kategori Data</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('dist/images/breadcrumb/ChatBc.png') }}" alt="modernize-img"
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row my-3 justify-content-end">
        <div class="right-side d-flex col-md-4 justify-content-end gap-2 align-items-center">
            <a href="#" class="btn btn-success d-flex gap-2 align-items-center" onclick="refreshTable()">
                <i class="ti ti-reload"></i><span>Segarkan</span>
            </a>
            <a href="#" class="btn btn-primary d-flex gap-2 align-items-center" data-bs-toggle="modal"
                data-bs-target="#modalCreation">
                <i class="ti ti-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>

    <div class="card shadow-none border card-body">
        <div class="table-responsive">
            <table class="table w-100 table-striped table-bordered table-hover" id="table-ajax">
                <thead>
                    <tr>
                        <th style="width: 20%">Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th style="width: 10%">Warna Kategori</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 10%" class="no-sort">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('page.panel.council-category.create')
    @include('page.panel.council-category.edit')
@endsection

@push('scripts')
    <script src="{{ asset('dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
@endpush

@push('script')
    <script>
        initializeDataTableWithAjax(
            'table-ajax',
            generateAjaxUrl(
                `{{ route('api.council-category.index') }}`, {
                    council_level: `{{ request('council_level') }}`,
                    category: `{{ request('category') }}`
                }
            ),
            [{
                    data: 'name'
                },
                {
                    data: 'description',
                    defaultContent: 'N/A'
                },
                {
                    data: 'color',
                    render(a) {
                        return `<span class="badge" style="font-family: 'Consolas';background: ${a}">${a.toUpperCase()}</span>`
                    }
                },
                {
                    data: 'active',
                    defaultContent: 'N/A',
                    render(a) {
                        return a ?
                            '<span class="badge bg-success">Aktif</span>' :
                            '<span class="badge bg-danger">Tidak aktif</span>';
                    }
                },
                {
                    data: 'id',
                    render(a) {
                        return `
                        <form data-target="#table-ajax" data-reload-table="true" action="{{ url('api/council-category') }}/${a}" data-success-message="Data berhasil dihapus dari sistem" id="deletedata-${a}" class="form-ajax" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>

                        <div class="d-flex gap-2 align-items-center">
                            <a href="javascript:handleButton('edit', '${a}')" class="btn btn-sm btn-light"><i class="ti ti-pencil"></i></a>
                            <a href="javascript:handleButton('delete', '${a}')" class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></a>
                        </div>
                    `;
                    },
                }
            ]
        );

        function refreshTable() {
            reloadDataTable('#table-ajax')
        }

        function handleButton(action, dataId) {
            if (action == 'edit') {
                editData(dataId);
            }

            if (action === 'delete') {
                runModalConfirmWithSubmit('Data yang akan dihapus, tidak akan kembali lagi.', `#deletedata-${dataId}`)
            }
        }
    </script>
@endpush
