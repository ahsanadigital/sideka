<div class="modal fade" id="editData" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataLabel">Tambah Arsip Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">

                <form action="{{ route('meeting.store') }}" id="editdata-form" class="row form-ajax"
                    enctype="multipart/form-data" method="POST" data-target="#table-ajax" data-reload-table="true"
                    data-reset-form="true" data-success-message="Berhasil menambahkan data Pertemuan / Rapat">

                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <!-- Name -->
                        <div class="form-group mb-3">
                            <label class="form-label" for="title">Nama Agenda</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                id="title" name="title" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Participant -->
                        <div class="form-group mb-3">
                            <label class="form-label" for="participant">Jumlah Peserta</label>
                            <input type="number" class="form-control @error('participant') is-invalid @enderror"
                                id="participant" name="participant" value="{{ old('participant') }}">
                            @error('participant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="date" class="form-label">Tanggal Rapat / Pertemuan</label>

                            <div class="input-group date" id="datepicker-startForm" data-td-target-input="nearest">
                                <input type="text" placeholder="Klik untuk mengubah"
                                    class="form-control @error('date') is-invalid @enderror datetimepicker-input"
                                    name="date" data-target="#datepicker-startForm" value="{{ old('date') }}" />
                                <div class="input-group-text"data-target="#datepicker-startForm"
                                    data-td-toggle="datetimepicker">
                                    <i class="ti ti-calendar" aria-hidden="true"></i>
                                </div>
                            </div>

                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @include('components.category-select', [
                            'targetName' => 'category_id',
                            'title' => 'Jenis Rapat',
                        ])

                        @includeWhen(auth()->user()->hasRole(['region', 'regency']),
                            'components.user-select')

                        @include('components.quill-editor', [
                            'targetId' => 'descriptionEdit',
                            'targetName' => 'description',
                            'placeholder' => 'Silahkan isikan penjelasan rapat ini.',
                            'label' => 'Deskripsi Agenda',
                        ])

                        @include('components.quill-editor', [
                            'targetId' => 'resultEdit',
                            'targetName' => 'result',
                            'placeholder' => 'Silahkan isikan notulensi hasil rapat ini.',
                            'label' => 'Notulensi Hasil Rapat',
                        ])
                    </div>
                    <div class="col-md-6">
                        {{-- Unggah Berkas Dokumentasi --}}
                        <div class="form-group mb-3">
                            <div class="form-label">Unggah Berkas Dokumentasi</div>

                            <div class="file-upload-container">
                                <label for="files-edit">
                                    <input type="file" id="files-edit" name="files[]" class="file-hidden"
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
                                Unggah berkas <code>.png</code>, <code>.jpg</code>, atau <code>.jpeg</code> untuk
                                menambahkan dokumentasinya. Dan
                                maksimal berkasnya adalah 2MB (MegaByte).
                            </div>

                            <div class="error-wrapper"></div>

                            @error('files.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="inject-gallery"></div>
                        </div>

                        {{-- Unggah Dokumen Hasil Rapat --}}
                        <div class="form-group mb-3">
                            <div class="form-label">Unggah Dokumen Hasil Rapat</div>

                            <div class="file-upload-container">
                                <label for="docs-edit">
                                    <input type="file" id="docs-edit" name="docs" class="file-hidden"
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
                                <code>.odt</code> untuk menimpa unggahan sebelumnya. Dan maksimal berkasnya adalah 2MB
                                (MegaByte).
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
                <button type="button" class="btn btn-primary" onclick="submitForm('#editdata-form')">Simpan dan
                    Ubah</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        var startDateInput = document.querySelector('#editData').querySelector('input[name="date"]');
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

    <script>
        function editData(dataId) {
            initAjax(
                null,
                `{{ url('/api/meeting/') }}/${dataId}`,
                'GET',
                () => toastrToast("info", "Sedang memproses..."),
                (a, b, c) => {
                    const data = a.data,
                        userData = data?.user,
                        categoryData = data?.category,
                        meetingImagesData = data?.photos,
                        modal = $('.modal#editData');

                    let $gallery = `
                        <div class="row gy-3 border-top pt-2 mt-3 gx-3">
                            ${meetingImagesData.map((media, index) => `
                                    <div data-gallery-id="${media.id}" class="col-md-3 col-6">
                                        <a href="${media.url}" data-fancybox="gallery" data-caption="Image #${index + 1}">
                                            <div class="ratio ratio-1x1 rounded overflow-hidden">
                                                <img src="${media.thumbnail}" class="object-fit-cover" />
                                            </div>
                                        </a>

                                        <div class="d-grid pt-2">
                                            <button onclick="removeGallery('${media.id}', '{{ url('/api/media/removal/') }}')" type="button" class="btn btn-sm btn-danger">Hapus</button>
                                        </div>
                                    </div>
                                    `).join('')}
                        </div>
                        `;

                    modal.find('#inject-gallery').html($gallery);

                    console.log(data.title)

                    // Change target update data url
                    modal.find('form').attr('action', `{{ url('/api/meeting') }}/${data.id}`);
                    modal.find('input[name="title"]').val(data.title);
                    modal.find('input[name="participant"]').val(data.participant);

                    instanceStartDate.dates.setValue(tempusDominus.DateTime.convert(new Date(data.date)));

                    // Current data for user dropdown
                    let dropdownInjectUserData = $(
                        `<option selected value="${userData.id}">${userData.fullname}</option>`);
                    modal.find('.user-select').html(dropdownInjectUserData).trigger('change');

                    // Change Category Data
                    let dropdownInjectCategoryData = $(
                        `<option selected value="${categoryData.id}">${categoryData.name}</option>`);
                    modal.find('.category-select').html(dropdownInjectCategoryData).trigger('change');

                    var instanceDesc = new Quill.find(document.querySelector('#editData').querySelector(
                        '#descriptionEdit'));
                    var instanceResult = new Quill.find(document.querySelector('#editData').querySelector(
                        '#resultEdit'));
                    setQuillContents(htmlEntityDecodes(data.description), instanceDesc);
                    setQuillContents(htmlEntityDecodes(data.result), instanceResult);

                    modal.modal('show');
                },
                () => {
                    toastrToast(
                        "error",
                        "Ada Kesalahan!",
                    );
                }
            );
        };
    </script>
@endpush
