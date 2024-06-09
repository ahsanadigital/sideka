@extends('layouts.app')

@section('title', 'Data Kwartir')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Data Kwartir</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Beranda Dasbor</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Data Kwartir</li>
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

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="text-bg-info p-4 rounded-3 rounded-bottom-0">
                    <div class="text-center text-white display-6">
                        <i class="ti ti-building"></i>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h3>Kwarda Jatim</h3>
                    <p class="text-muted mb-0">Kwartir Daerah</p>
                </div>
            </div>
        </div>
    </div>
@endsection
