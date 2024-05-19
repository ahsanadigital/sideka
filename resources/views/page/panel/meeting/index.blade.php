@extends('layouts.app')

@section('title', 'Pertemuan dan Rapat')

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
                        <th>Pengunggah</th>
                        <th class="no-sort">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
