@push('links')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css"
        crossorigin="anonymous" />
@endpush

<!-- Modal Create -->
<div class="modal fade" id="modalCreation" tabindex="-1" aria-labelledby="modalCreationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCreationLabel">Tambah Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form data-target="#table-ajax" data-reload-table="true" action="{{ route('decree.store') }}"
                    data-reset-form="true" data-success-message="Berhasil menambahkan data Surat Keterangan"
                    id="createdata-form" method="POST" class="form-adddata form-ajax">
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

                        @error('nomenclature')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nomor Surat --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="number">Nomor Surat</label>
                        <input type="text" class="form-control @error('number') is-invalid @enderror"
                            value="{{ old('number') }}" placeholder="DKD Jatim/Giat/2021/0001/R&hellip;" name="number"
                            id="number" />

                        <div class="error-wrapper"></div>
                    </div>

                    {{-- Start and End Date --}}
                    <div class="row mb-3">
                        <div class="col-md-12 form-label">Tanggal Pemberlakuan</div>

                        <div class="col-md-6 form-group mb-2 mb-md-0">
                            <div class="input-group date" id="datepicker-startForm" data-td-target-input="nearest">
                                <input type="text" placeholder="Klik untuk mengubah"
                                    class="form-control datetimepicker-input" name="start_from"
                                    data-target="#datepicker-startForm" />
                                <div class="input-group-text"data-target="#datepicker-startForm"
                                    data-td-toggle="datetimepicker">
                                    <i class="ti ti-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="input-group date" id="datepicker-endTo" data-td-target-input="nearest">
                                <input type="text" placeholder="Klik untuk mengubah"
                                    class="form-control datetimepicker-input" name="end_to"
                                    data-target="#datepicker-endTo" />
                                <div class="input-group-text"data-target="#datepicker-endTo"
                                    data-td-toggle="datetimepicker">
                                    <i class="ti ti-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-text">Apabila akan berlaku terus-menerus, biarkan kosong kolom "Berakhir"
                            </div>
                        </div>
                    </div>

                    {{-- Select User --}}
                    @includeWhen(auth()->user()->hasRole(['region', 'regency']),
                        'components.user-select')

                    {{-- Unggah Berkas --}}
                    <div class="form-group mb-3">
                        <div class="form-label">Unggah berkas</div>

                        <div class="file-upload-container">
                            <label for="document">
                                <input type="file" id="document" name="document" class="file-hidden"
                                    accept="application/pdf" />

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

                    {{-- Status Publikasi --}}
                    <div class="form-group">
                        <label class="form-label">Publikasi?</label>

                        <div class="d-flex gap-2">
                            <div class="input-radio-button">
                                <input type="radio" name="public" id="publik" name="options"
                                    value="1" />
                                <label for="publik">
                                    <div class="d-flex gap-2 py-2 w-100 align-items-center flex-column justify-content-center">
                                        <img src="{{ asset('core/images/icons/public.png') }}" height="32"
                                            alt="Publikasikan" />

                                        <div class="d-flex flex-column text-center justify-content-center">
                                            <strong class="mb-0">Publikasikan</strong>
                                            <small class="mb-0 opacity-50">Biarkan publik dokumen ini</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="input-radio-button">
                                <input type="radio" name="public" id="private" name="options"
                                    value="0" />
                                <label for="private">
                                    <div class="d-flex gap-2 py-2 w-100 align-items-center flex-column justify-content-center">
                                        <img src="{{ asset('core/images/icons/private.png') }}" height="32"
                                            alt="Publikasikan" />

                                        <div class="d-flex flex-column text-center justify-content-center">
                                            <strong class="mb-0">Privasikan</strong>
                                            <small class="mb-0 opacity-50">Jangan publikasi dokumen ini</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button onclick="submitForm('#createdata-form')" type="button"
                    class="btn btn-primary">Tambahkan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Create -->

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js"></script>
@endpush

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var startDateInput = document.querySelector('input[name="start_from"]');
            var endDateInput = document.querySelector('input[name="end_to"]');

            var instanceStartDate = new tempusDominus.TempusDominus(startDateInput, {
                container: startDateInput.closest('.modal'),
                display: {
                    components: {
                        clock: false,
                        calendar: true,
                    },
                    buttons: {
                        clear: true,
                    },
                    theme: 'light'
                },
                localization: {
                    locale: 'id-ID',
                    format: 'yyyy/MM/dd',
                }
            });

            var instanceEndDate = new tempusDominus.TempusDominus(endDateInput, {
                container: endDateInput.closest('.modal'),
                display: {
                    components: {
                        clock: false,
                        calendar: true,
                    },
                    buttons: {
                        clear: true,
                    },
                    theme: 'light'
                },
                localization: {
                    locale: 'id-ID',
                    format: 'yyyy/MM/dd',
                }
            });
        });
    </script>
@endpush
