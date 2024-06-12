<div class="modal fade" id="modalCreation" tabindex="-1" aria-labelledby="modalCreationLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreationLabel">Tambah Arsip Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{ route('meeting.store') }}" id="createdata-form" class="row"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control" id="name" name="name"
                                placeholder="PERANSAKA NASIONAL" />
                            <label for="name">Nama Agenda</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input required type="number" class="form-control" id="participant" name="participant"
                                placeholder="0-Unlimited" />
                            <label for="participant">Jumlah Peserta</label>
                        </div>

                        <div class="form-group mb-3">
                            <label for="date">Tanggal Kegiatan</label>
                            <input required type="text" class="form-control flatpickr" placeholder="Masukan tanggal"
                                name="date" />
                        </div>

                        @include('components.category-select')

                        @includeWhen(auth()->user()->hasRole(['region', 'regency']),
                            'components.user-select')

                        @include('components.quill-editor', [
                            'targetId' => 'description',
                            'label' => 'Deskripsi Agenda',
                        ])

                        @include('components.quill-editor', [
                            'targetId' => 'result',
                            'label' => 'Hasil Rapat',
                        ])
                    </div>
                    <div class="col-md-6">
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

                            @error('files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Unggah Dokumen Hasil Rapat --}}
                        <div class="form-group mb-3">
                            <div class="form-label">Unggah Dokumen Hasil Rapat</div>

                            <div class="file-upload-container">
                                <label for="docs">
                                    <input type="file" id="docs" name="docs" class="file-hidden"
                                        accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/vnd.oasis.opendocument.text"
                                        multiple data-max-file-size-preview="2M"
                                        data-allowed-file-extensions="pdf doc docx odt" />

                                    <div class="file-upload-label">
                                        <i class="ti ti-upload"></i>
                                        <h3 class="mb-0 h5 fw-bolder">Unggah Berkas</h3>
                                        <p class="mb-0 mt-n2">Silakan seret / pilih berkas.</p>
                                    </div>
                                </label>

                                <ul class="file-list d-none list-group-flush list-group"></ul>
                            </div>

                            <div class="form-text text-muted">
                                Unggah berkas <code>.pdf</code>, <code>.doc</code>, <code>.docx</code>, atau
                                <code>.odt</code>. Dan maksimal berkasnya adalah 2MB (MegaByte).
                            </div>

                            <div class="error-wrapper"></div>

                            @error('docs')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="submitForm('#createdata-form')">Simpan dan Tambahkan</button>
            </div>
        </div>
    </div>
</div>
