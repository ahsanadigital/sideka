@extends('layouts.app')

@section('links')
    <link rel="stylesheet" href="{{ asset('dist/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
@endsection

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Surat Keputusan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Beranda Dasbor</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Surat Keputusan</li>
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
        <div class="right-side">
            <a href="#" class="btn btn-primary d-flex gap-2 align-items-center" data-bs-toggle="modal"
                data-bs-target="#modalCreation">
                <i class="ti ti-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreation" tabindex="-1" aria-labelledby="modalCreationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCreationLabel">Tambah Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('decree.store') }}" method="POST" class="form-adddata">
                        @csrf

                        {{-- Judul Surat Keputusan --}}
                        <div class="form-group mb-3">
                            <label class="form-label" for="title">Judul Surat Keputusan</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Surat Keputusan mengenai kegiatan&hellip;"
                                name="title" id="title" />

                            <div class="error-wrapper"></div>
                        </div>

                        {{-- Nomenklatur --}}
                        <div class="form-group mb-3">
                            <label class="form-label" for="nomenclature">Nomenklatur</label>
                            <textarea type="text" rows="5" class="form-control @error('nomenclature') is-invalid @enderror"
                                value="{{ old('nomenclature') }}" placeholder="Deskripsi surat keputusan&hellip;" name="nomenclature"
                                id="nomenclature"></textarea>

                            <div class="error-wrapper"></div>
                        </div>

                        {{-- Start and End Date --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Tanggal Berlaku dan Berakhir</label>

                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control" placeholder="Berlaku" name="start_from" />
                                <span class="input-group-text bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" placeholder="Berakhir" name="end_to" />
                            </div>

                            @error(['start_from', 'end_to'])
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Unggah Berkas --}}
                        <div class="form-group">
                            <div class="form-label">Unggah berkas</div>

                            <div class="file-upload-container">
                                <label for="file">
                                    <input type="file" id="file" class="file-hidden" accept="application/pdf" />

                                    <div class="file-upload-label">
                                        <i class="ti ti-upload"></i>
                                        <h3 class="mb-0 h5 fw-bolder">Unggah Berkas</h3>
                                        <p class="mb-0 mt-n2">Silakan seret / pilih berkas.</p>
                                    </div>

                                </label>

                                <ul class="file-list d-none list-group-flush list-group"></ul>
                            </div>

                            <div class="error-wrapper"></div>

                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Create -->
@endsection

@section('scripts')
    <script src="{{ asset('dist/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('dist/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
@endsection

@section('script')
    <script>
        initFormInput('.file-upload-container');

        $("#date-range").datepicker({
            toggleActive: true,
        });
    </script>
@endsection
