@extends('layouts.app')

@section('title', 'Data Prestasi')

@push('links')
    <link rel="stylesheet" href="{{ asset('dist/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css"
        crossorigin="anonymous" />

    <!-- FancyBox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
        integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')
    <script src="{{ asset('dist/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
        integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

    <div class="row my-3 gy-3 pb-3 justify-content-between">
        <div class="left-side col-md-2">
            <form action="{{ request()->fullUrl() }}" class="d-flex gap-2" id="auto-submit-form">
                <select name="council_level" id="council_level" class="form-select">
                    <option value="">Semua</option>
                    @foreach (RoleUserEnum::cases() as $roles)
                        <option value="{{ $roles->value }}"
                            {{ request('council_level') == $roles->value ? 'selected' : '' }}>{{ $roles->label() }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="right-side d-flex col-md-4 justify-content-start justify-content-lg-end gap-2 align-items-center">
            <a href="#" class="btn btn-success d-flex gap-2 align-items-center" onclick="loadAchievements()">
                <i class="ti ti-reload"></i><span>Segarkan</span>
            </a>
            <a href="#" class="btn btn-primary d-flex gap-2 align-items-center" data-bs-toggle="modal"
                data-bs-target="#modalCreation">
                <i class="ti ti-plus"></i><span>Tambah</span>
            </a>
        </div>
    </div>

    <div id="main-data" class="row"></div>
    <div id="pagination" class="d-flex justify-content-center mt-4"></div>

    @include('page.panel.achievement.create')
    @include('page.panel.achievement.show')
    @include('page.panel.achievement.edit')
@endsection

@push('scripts')
    <script src="{{ asset('dist/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('dist/libs/moment/locale/id.js') }}"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            let currentPage =
            '{{ request()->get('page') }}'; // Initialize currentPage with the default page number

            window.loadAchievements = function(page = '{{ request()->get('page') }}') {
                setIsBusy();

                let councilLevel = $('#council_level').val();

                $.ajax({
                    url: "{{ url('/api/achievement') }}",
                    type: 'GET',
                    data: {
                        council_level: councilLevel,
                        page: page // Add page parameter for pagination
                    },
                    success: function(response) {
                        if (response.data.length > 0) {
                            setData(response.data);
                            updatePagination(response); // Update pagination controls
                            currentPage = page; // Update current page
                        } else {
                            setIsNotFound();
                        }
                    },
                    error: function() {
                        setError();
                    }
                });
            }

            function updatePagination(response) {
                let paginationHtml = '';
                currentPage = response.current_page;

                // Previous button
                if (response.prev_page_url) {
                    paginationHtml +=
                        `<a href="#" onclick="loadAchievements(${currentPage - 1})" class="btn btn-outline-primary me-2"><i class="fas fa-chevron-left"></i></a>`;
                }

                // Numbered pages
                response.links.forEach(link => {
                    if (link.url && !isNaN(link.label)) {
                        let pageNumber = link.label;
                        let isActive = link.active ? 'active' : '';
                        paginationHtml +=
                            `<a href="#" onclick="loadAchievements(${pageNumber})" class="btn btn-outline-primary ${isActive} me-2">${pageNumber}</a>`;
                    }
                });

                // Next button
                if (response.next_page_url) {
                    paginationHtml +=
                        `<a href="#" onclick="loadAchievements(${currentPage + 1})" class="btn btn-outline-primary"><i class="fas fa-chevron-right"></i></a>`;
                }

                let currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('page', currentPage);

                // Pushing the updated URL with current page parameter
                window.history.pushState({
                    path: currentUrl.href
                }, '', currentUrl.href);

                $('#pagination').html(paginationHtml);
            }

            // Function to load achievements initially
            window.reloadFunction = function() {
                loadAchievements();
            }

            // Function to delete an item
            window.deleteItem = (dataId) => {
                runModalConfirmWithSubmit('Data yang akan dihapus, tidak akan kembali lagi.',
                    `#deletedata-${dataId}`);
            }

            // Function to handle errors
            function setError() {
                $('#main-data').html(`
            <div class="d-flex justify-content-center">
                <div class="alert alert-danger" role="alert">
                    Terjadi kesalahan!
                </div>
            </div>
            `);
            }

            // Function to handle not found data
            function setIsNotFound() {
                $('#main-data').html(`
            <div class="d-flex justify-content-center">
                <div class="alert alert-danger" role="alert">
                    Data tidak ditemukan!
                </div>
            </div>
            `);
            }

            // Function to set data
            function setData(data) {
                let html = '';
                data.forEach(function(item) {
                    html += `
                    <div class="col-md-3 card-item">
                        <form action="{{ url('api/achievement') }}/${item.id}" data-success-message="Data berhasil dihapus dari sistem" id="deletedata-${item.id}" class="form-ajax" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>

                        <div class="card card-body p-3">
                            <div class="row gx-3 w-100">
                                <div class="col-md-3">
                                    <div class="bg-primary rounded text-white d-flex align-items-center justify-content-center" style="height: 5rem; width: 5rem;">
                                        <i class="fas fa-trophy" style="font-size: 2rem"></i>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <h4 class="fw-semibold mb-1 text-truncate">${item.name}</h4>
                                    <p class="mb-1">${item.place}</p>
                                    <p class="mb-0">${moment.utc(item.date).locale('id').format('D MMMM YYYY')}</p>
                                </div>
                            </div>

                            <div class="dropdown position-absolute no-caret" style="top: 10px; right: 10px;">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton${item.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${item.id}">
                                    <li><a class="dropdown-item d-flex gap-2 align-items-center" href="#" onclick="viewItem(${item.id})"><i class="fas fa-eye"></i> Lihat</a></li>
                                    <li><a class="dropdown-item d-flex gap-2 align-items-center" href="#" onclick="editData(${item.id})"><i class="fas fa-edit"></i> Edit</a></li>
                                    <li><a class="dropdown-item d-flex gap-2 align-items-center" href="#" onclick="deleteItem(${item.id})"><i class="fas fa-trash"></i> Hapus</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                `;
                });
                $('#main-data').html(html);
            }

            // Function to show spinner when loading data
            function setIsBusy() {
                $('#main-data').html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            `);
            }

            // Initial load
            loadAchievements();

            // Trigger loadAchievements on select change
            $('#auto-submit-form').on('change', 'select', function(e) {
                e.preventDefault();
                loadAchievements();
            });
        });
    </script>
@endpush
