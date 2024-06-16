<!-- Modal Show Data -->
<div class="modal fade" id="showData" tabindex="-1" aria-labelledby="showDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showDataLabel">Detail Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover border table-striped">
                    <tbody>
                        <tr>
                            <th class="w-25">Judul Pertemuan</th>
                            <td id="title"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Tanggal</th>
                            <td id="date"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Kategori Kegiatan</th>
                            <td id="category"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Pengunggah</th>
                            <td id="user"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Berkas Hasil Rapat</th>
                            <td id="download-file"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="mb-3 section-description">
                    <div class="fw-bolder mb-1">Deskripsi Rapat</div>
                    <div id="meeting-desc"></div>
                </div>

                <div class="mb-3 section-description">
                    <div class="fw-bolder mb-1">Notulen Hasil Rapat</div>
                    <div id="meeting-result"></div>
                </div>

                <div class="fw-bolder mb-1">Galeri Kegiatan</div>
                <div class="image-galleries"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        function viewData(dataId) {
            initAjax(
                null,
                `{{ url('/api/meeting/') }}/${dataId}`,
                'GET',
                () => toastrToast("info", "Sedang memproses..."),
                (a, b, c) => {
                    const data = a.data,
                        userData = data?.user,
                        categoryData = data?.category,
                        meetingDocsData = data?.docs,
                        meetingImagesData = data?.photos,
                    modal = $('.modal#showData');

                    let $date = moment.utc(data.date).locale('id').format('D MMMM YYYY'),
                        $gallery = `
                        <div class="row gy-3 gx-3">
                            ${meetingImagesData.map((media, index) => `
                            <div class="col-md-3 col-6">
                                <a href="${media.url}" data-fancybox="gallery" data-caption="Image #${index + 1}">
                                    <div class="ratio ratio-1x1 rounded overflow-hidden">
                                        <img src="${media.thumbnail}" class="object-fit-cover" />
                                    </div>
                                </a>
                            </div>
                            `).join('')}
                        </div>
                        `;

                    modal.find('td#title').text(data.title);
                    modal.find('#category').text(categoryData.name);
                    modal.find('td#date').text($date);
                    modal.find('td#download-file').html(
                        `
                        <strong>Meeting-Docs_${moment().locale('id').format('D MMMM YYYY')}_${data.title}.${meetingDocsData.mime}</strong>
                        <div class="d-flex gap-2 align-items-center">
                        <i class="ti ti-download"></i>
                        <span>
                            <a href="{{ route('utils.download-file') }}?${encodeArrayToURL({'path': meetingDocsData.path, 'name': `Meeting-Docs_${moment().locale('id').format('D MMMM YYYY')}_${data.title}.${meetingDocsData.mime}`})}">Unduh Berkas</a>
                        </span>
                    </div>`);

                    modal.find('td#user').html(
                        `<a href="{{ url('/user') }}/${userData.id}">${userData.fullname}</a>`);

                    modal.find('#meeting-desc').html(htmlEntityDecodes(data.description));
                    modal.find('#meeting-result').html(htmlEntityDecodes(data.result));

                    modal.find('.image-galleries').html($gallery);

                    modal.modal('show');
                },
                () => {
                    toastrToast(
                        "error",
                        "Ada Sedikit Kesalahan!",
                        "Mohon periksa kembali inputan yang tidak sesuai!"
                    );
                }
            );
        }
    </script>
@endpush
