<!-- Modal Create -->
<div class="modal fade" id="modalCreation" tabindex="-1" aria-labelledby="modalCreationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCreationLabel">Tambah Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form data-target="#table-ajax" action="{{ route('achievement.store') }}"
                    data-reset-form="true" data-success-message="Berhasil menambahkan data prestasi"
                    id="createdata-form" method="POST" class="form-adddata form-ajax">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            {{-- Nama Prestasi --}}
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Nama Kegiatan</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Nama Kegiatan&hellip;" name="name"
                                    id="name" />

                                <div class="error-wrapper"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- Tempat Prestasi --}}
                            <div class="form-group mb-3">
                                <label class="form-label" for="place">Tempat Kegiatan</label>
                                <input type="text" class="form-control @error('place') is-invalid @enderror"
                                    value="{{ old('place') }}" placeholder="Tempat Kegiatan&hellip;" name="place"
                                    id="place" />

                                <div class="error-wrapper"></div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            {{-- Tanggal Prestasi --}}
                            <div class="form-group mb-3">
                                <label class="form-label" for="date">Tgl. Kegiatan</label>
                                <div class="input-group date" id="datepicker-startForm" data-td-target-input="nearest">
                                    <input type="text" placeholder="Klik untuk mengubah"
                                        class="form-control @error('date') is-invalid @enderror datetimepicker-input"
                                        name="date" data-target="#datepicker-startForm" value="{{ old('date') }}" />
                                    <div class="input-group-text"data-target="#datepicker-startForm"
                                        data-td-toggle="datetimepicker">
                                        <i class="ti ti-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="error-wrapper"></div>

                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @include('components.user-select')
                        </div>
                        <div class="col-md-6">
                            {{-- Deskripsi --}}
                            @include('components.quill-editor', [
                                'targetId' => 'description',
                                'placeholder' => 'Silahkan isikan deskripsi kegiatan ini.',
                                'label' => 'Deskripsi',
                            ])
                        </div>
                        <div class="col-md-6">
                            {{-- Catatan --}}
                            @include('components.quill-editor', [
                                'targetId' => 'notes',
                                'placeholder' => 'Silahkan isikan catatan kegiatan ini.',
                                'label' => 'Catatan',
                            ])

                        </div>
                        <div class="col-md-12">
                            {{-- Unggah Berkas Dokumentasi --}}
                            <div class="form-group mb-3">
                                <div class="form-label">Unggah Berkas Dokumentasi</div>

                                <div class="file-upload-container">
                                    <label for="files">
                                        <input type="file" id="files" name="files[]" class="file-hidden"
                                            accept="image/*" multiple data-max-file-size-preview="2M" />

                                        <div class="file-upload-label">
                                            <i class="ti ti-upload"></i>
                                            <h3 class="mb-0 h5 fw-bolder">Unggah Berkas</h3>
                                            <p class="mb-0 mt-n2">Silakan seret / pilih berkas.</p>
                                        </div>
                                    </label>

                                    <ul class="file-list d-none list-group-flush list-group"></ul>
                                </div>

                                <div class="form-text text-muted">
                                    Unggah berkas <code>.png</code>, <code>.jpg</code>, atau <code>.jpeg</code>. Dan
                                    maksimal berkasnya adalah 2MB (MegaByte).
                                </div>

                                <div class="error-wrapper"></div>

                                @error('files.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

@push('script')
    <script>
        var startDateInput = document.querySelector('#modalCreation').querySelector('input[name="date"]');
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
    </script>
@endpush
