<!-- Modal Create -->
<div class="modal fade" id="modalCreation" tabindex="-1" aria-labelledby="modalCreationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCreationLabel">Tambah Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form data-target="#table-ajax" data-reload-table="true" action="{{ route('council-category.store') }}"
                    data-reset-form="true" data-success-message="Berhasil menambahkan data Surat Keterangan"
                    id="createdata-form" method="POST" class="form-adddata form-ajax">
                    @csrf

                    {{-- Nama Kategori --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Nama Kategori</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Nama Kategorinya&hellip;"
                            name="name" id="name" />

                        <div class="error-wrapper"></div>
                    </div>

                    {{-- Warna Kategori --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="color">Warna Kategori</label>
                        <input type="color" class="form-control @error('color') is-invalid @enderror"
                            value="{{ old('color') }}" placeholder="Warna Kategorinya&hellip;"
                            name="color" id="color" />

                        <div class="error-wrapper"></div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Deskripsi</label>
                        <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description"
                            id="description" placeholder="Deskripsinya&hellip;">{{ old('description') }}</textarea>

                        <div class="error-wrapper"></div>
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
