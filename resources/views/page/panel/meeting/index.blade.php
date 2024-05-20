@extends('layouts.app')

@section('title', 'Pertemuan dan Rapat')

@push('links')
    <link rel="stylesheet" href="{{ asset('dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
@endpush

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pertemuan dan Rapat</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Beranda Dasbor</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Pertemuan dan Rapat</li>
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

    <div class="d-flex my-3 justify-content-between">
        <div class="left-side">
        </div>
        <div class="right-side d-flex gap-2 align-items-center">
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
                        <th>Judul</th>
                        <th>Nomor SK</th>
                        <th>Tanggal Berlaku</th>
                        <th>Warna Label</th>
                        <th class="no-sort">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
@endpush

@push('script')
    <script>
        initializeDataTableWithAjax(
            'table-ajax',
            generateAjaxUrl(
                `{{ route('api.decree.index') }}`, {
                    council_level: `{{ request('council_level') }}`,
                    category: `{{ request('category') }}`
                }
            ),
            [{
                    data: 'title'
                },
                {
                    data: 'number'
                },
                {
                    data: 'id',
                    render(a, b, c) {
                        let $start = moment.utc(c.start_from).locale('id').format('D MMMM YYYY');
                        let $end = c.end_to ? moment.utc(c.end_to).locale('id').format('D MMMM YYYY') :
                            'Tidak ditentukan';
                        return `${$start} - ${$end}`;
                    },
                },
                {
                    data: 'user',
                    render(a) {
                        return `<a href="{{ url('/user') }}/${a.id}">${a.fullname}</a>`;
                    },
                },
                {
                    data: 'id',
                    render(a) {
                        return `
                        <form data-target="#table-ajax" data-reload-table="true" action="{{ url('api/decree') }}/${a}" data-success-message="Data berhasil dihapus dari sistem" id="deletedata-${a}" class="form-ajax" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>

                        <div class="d-flex gap-2 align-items-center">
                            <a href="javascript:handleButton('show', '${a}')" class="btn btn-sm btn-primary"><i class="ti ti-eye"></i></a>
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
            if (action == 'show') {
                viewData(dataId);
            }

            if (action == 'edit') {
                editData(dataId);
            }

            if (action === 'delete') {
                runModalConfirmWithSubmit('Data yang akan dihapus, tidak akan kembali lagi.', `#deletedata-${dataId}`)
            }
        }
    </script>
@endpush
