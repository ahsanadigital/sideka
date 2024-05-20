<!-- Modal Create -->
<div class="modal fade" id="editData" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editDataLabel">Tambah Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form data-target="#table-ajax" data-reload-table="true" action="{{ route('council-category.store') }}"
                    data-reset-form="true" data-success-message="Berhasil menambahkan data Surat Keterangan"
                    id="updatedata-form" method="POST" class="form-adddata form-ajax">
                    @csrf
                    @method('PUT')

                    {{-- Nama Kategori --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Nama Kategori</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Nama Kategorinya&hellip;" name="name"
                            id="name" />

                        <div class="error-wrapper"></div>
                    </div>

                    {{-- Warna Kategori --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="color">Warna Kategori</label>
                        <input type="color" class="form-control @error('color') is-invalid @enderror"
                            value="{{ old('color') }}" placeholder="Warna Kategorinya&hellip;" name="color"
                            id="color" />

                        <div class="error-wrapper"></div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Deskripsi</label>
                        <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description"
                            id="description" placeholder="Deskripsinya&hellip;">{{ old('description') }}</textarea>

                        <div class="error-wrapper"></div>
                    </div>

                    {{-- Status Publikasi --}}
                    <div class="form-group">
                        <label class="form-label">Status</label>

                        <div class="d-flex gap-2">
                            <div class="input-radio-button">
                                <input type="radio" name="active" id="active-edit" value="1" />
                                <label for="active-edit">
                                    <div
                                        class="d-flex gap-2 py-2 w-100 align-items-center flex-column justify-content-center">
                                        <img src="{{ asset('core/images/icons/accept.png') }}" height="32"
                                            alt="Publikasikan" />

                                        <div class="d-flex flex-column text-center justify-content-center">
                                            <strong class="mb-0">Aktifkan</strong>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="input-radio-button">
                                <input type="radio" name="active" id="denonactive-edit" value="0" />
                                <label for="denonactive-edit">
                                    <div
                                        class="d-flex gap-2 py-2 w-100 align-items-center flex-column justify-content-center">
                                        <img src="{{ asset('core/images/icons/cancel.png') }}" height="32"
                                            alt="Publikasikan" />

                                        <div class="d-flex flex-column text-center justify-content-center">
                                            <strong class="mb-0">Denonaktif</strong>
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
                <button onclick="submitForm('#updatedata-form')" type="button"
                    class="btn btn-primary">Ubah Data</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Create -->

@push('script')
    <script>
        function editData(dataId) {
            initAjax(
                null,
                `{{ url('/api/council-category/') }}/${dataId}`,
                'GET',
                () => toastrToast("info", "Sedang memproses..."),
                (a, b, c) => {
                    const data = a.data,
                        modal = $('.modal#editData');

                    // Change target update data url
                    modal.find('form').attr('action', `{{ url('/api/council-category') }}/${data.id}`);

                    modal.find('#name').val(data.name);
                    modal.find('#color').val(data.color);
                    modal.find('#description').val(data.description);

                    if (data.active) {
                        modal.find('#active-edit[name=active]').prop('checked', true);
                        modal.find('#denonactive-edit[name=active]').prop('checked', false);
                    } else {
                        modal.find('#active-edit[name=active]').prop('checked', false);
                        modal.find('#denonactive-edit[name=active]').prop('checked', true);
                    }

                    modal.modal('show');
                },
                () => {
                    toastrToast(
                        "error",
                        "Ada Kesalahan!",
                        "Maaf, ada kesalahan di sisi server. Mohon coba lagi beberapa saat."
                    );
                }
            );
        }
    </script>
@endpush
