<!-- modals/achievement.blade.php -->

<div class="modal fade" id="showData" tabindex="-1" aria-labelledby="showData-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showData-label">Achievement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <tr>
                        <th>Nama Lomba / Kegiatan</th>
                        <td id="achievement-name"></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td id="achievement-date"></td>
                    </tr>
                    <tr>
                        <th>Tempat</th>
                        <td id="achievement-place"></td>
                    </tr>
                </table>

                <div class="mb-3 section-description">
                    <div class="fw-bolder mb-1">Deskripsi Kegiatan</div>
                    <div id="achievement-desc"></div>
                </div>

                <div class="mb-3 section-description">
                    <div class="fw-bolder mb-1">Notulen Kegiatan</div>
                    <div id="achievement-result"></div>
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
        window.viewItem = function(dataId) {
            initAjax(
                null,
                `{{ url('/api/achievement/') }}/${dataId}`,
                'GET',
                () => toastrToast("info", "Sedang memproses..."),
                (a, b, c) => {
                    const data = a.data,
                        userData = data?.user,
                        categoryData = data?.category,
                        achievementsImagesData = data?.photos,
                        modal = $('.modal#showData');

                    let $date = moment.utc(data.date).locale('id').format('D MMMM YYYY'),
                        $gallery = `
                        <div class="row gy-3 gx-3">
                            ${achievementsImagesData.map((media, index) => `
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

                    modal.find('#achievement-name').text(data.name);
                    modal.find('#achievement-date').text($date);
                    modal.find('#achievement-place').text(data.place);

                    modal.find('#achievement-desc').html(htmlEntityDecodes(data.description));
                    modal.find('#achievement-result').html(htmlEntityDecodes(data.notes));

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
