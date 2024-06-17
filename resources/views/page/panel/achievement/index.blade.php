@extends('layouts.app')

@section('title', 'Data Prestasi')

@push('links')
    <link rel="stylesheet" href="{{ asset('dist/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('dist/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
@endpush

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Data Prestasi</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('home') }}">Beranda Dasbor</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Data Prestasi</li>
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
@endsection
