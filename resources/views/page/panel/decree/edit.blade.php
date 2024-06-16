<!-- Modal Create -->
<div class="modal fade" id="editData" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editDataLabel">Ubah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form data-target="#table-ajax" data-reload-table="true" data-reset-form="true"
                    data-success-message="Berhasil menambahkan data Surat Keterangan" id="editdata-form" method="POST"
                    class="form-adddata form-ajax">
                    @csrf
                    @method('PUT')

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
                        <input type="text" class="form-control @error('nomenclature') is-invalid @enderror"
                            value="{{ old('nomenclature') }}" placeholder="Deskripsi surat keputusan&hellip;"
                            name="nomenclature" id="nomenclature">

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
                    <div class="form-group mb-3">
                        <label class="form-label">Tanggal Berlaku dan Berakhir</label>

                        <div class="input-daterange input-group" id="date-range-edit">
                            <input type="text" class="form-control" placeholder="Berlaku" id="start-from"
                                name="start_from" />
                            <span class="input-group-text bg-info b-0 text-white">s/d</span>
                            <input type="text" class="form-control" placeholder="Berakhir" id="end-to"
                                name="end_to" />
                        </div>

                        <div class="form-text">Apabila akan berlaku terus-menerus, biarkan kosong kolom "Berakhir"
                        </div>

                        @error(['start_from', 'end_to'])
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Select User --}}
                    @includeWhen(auth()->user()->hasRole(['region', 'regency']),
                        'components.user-select')

                    {{-- Category --}}
                    @include('components.category-select')

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

                        <div class="form-text">Seret / pilih berkas untuk memperbaharui dokumen.</div>

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
                                <input type="radio" name="public" id="publik-edit" value="1" />
                                <label for="publik-edit">
                                    <div
                                        class="d-flex gap-2 py-2 w-100 align-items-center flex-column justify-content-center">
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
                                <input type="radio" name="public" id="private-edit" value="0" />
                                <label for="private-edit">
                                    <div
                                        class="d-flex gap-2 py-2 w-100 align-items-center flex-column justify-content-center">
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
                <button onclick="submitForm('#editdata-form')" type="button" class="btn btn-primary">Simpan
                    Perubahan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Create -->

@push('script')
    <script>
        var startDateInput = document.querySelector('input#start-from');
        var endDateInput = document.querySelector('input#end-to');

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

        const formatDate = (date) => {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = String(date.getFullYear()).slice(-2);
            return `${day}/${month}/${year}`;
        };

        function editData(dataId) {
            initAjax(
                null,
                `{{ url('/api/decree/') }}/${dataId}`,
                'GET',
                () => toastrToast("info", "Sedang memproses..."),
                (a, b, c) => {
                    const data = a.data,
                        userData = data?.user,
                        categoryData = data?.category,
                        modal = $('.modal#editData');

                    // Change target update data url
                    modal.find('form').attr('action', `{{ url('/api/decree') }}/${data.id}`);

                    modal.find('#title').val(data.title);
                    modal.find('#number').val(data.number);
                    modal.find('#nomenclature').val(data.nomenclature);

                    instanceStartDate.dates.setValue(tempusDominus.DateTime.convert(new Date(data.start_from)))

                    if (data.end_to) {
                        instanceEndDate.dates.setValue(tempusDominus.DateTime.convert(new Date(data.end_to)))
                    }

                    modal.find('#publik-edit[name=public]').prop('checked', data.public);
                    modal.find('#private-edit[name=public]').prop('checked', !data.public);

                    // Current data for user dropdown
                    let dropdownInjectUserData = $(
                        `<option selected value="${userData.id}">${userData.fullname}</option>`);
                    modal.find('.user-select').append(dropdownInjectUserData).trigger('change');

                    // Change Category Data
                    let dropdownInjectCategoryData = $(
                        `<option selected value="${categoryData.id}">${categoryData.name}</option>`);
                    modal.find('.category-select').append(dropdownInjectCategoryData).trigger('change');

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
