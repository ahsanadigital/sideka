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
                            <th class="w-25">Judul</th>
                            <td id="title"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Nomor SK</th>
                            <td id="number"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Nomenklatur</th>
                            <td id="nomenclature"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Tanggal Berlaku</th>
                            <td id="implementation-date"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Pengunggah</th>
                            <td id="user"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Berkas</th>
                            <td id="download-file"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Publikasi</th>
                            <td id="publication"></td>
                        </tr>
                        <tr>
                            <th class="w-25">Kategori</th>
                            <td id="category"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="pdf-file">
                    <div id="pdfShowWrapper"></div>
                </div>
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
                `{{ url('/api/decree/') }}/${dataId}`,
                'GET',
                () => toastrToast("info", "Sedang memproses..."),
                (a, b, c) => {
                    const data = a.data,
                        userData = data?.user,
                        categoryData = data?.category,
                        modal = $('.modal#showData');

                    let $start = moment.utc(data.start_from).locale('id').format('D MMMM YYYY');
                    let $end = data.end_to ? moment.utc(data.end_to).locale('id').format('D MMMM YYYY') :
                        'Tidak ditentukan';

                    modal.find('td#title').text(data.title);
                    modal.find('td#number').text(data.number);
                    modal.find('td#nomenclature').text(data.nomenclature);
                    modal.find('td#implementation-date').text(`${$start} - ${$end}`);
                    modal.find('#category').text(categoryData.name);

                    modal.find('td#user').html(
                        `<a href="{{ url('/user') }}/${userData.id}">${userData.fullname}</a>`);
                    modal.find('td#download-file').html(
                        `<div class="d-flex gap-2 align-items-center">
                        <i class="ti ti-download"></i>
                        <a href="{{ route('utils.download-file') }}?${encodeArrayToURL({'path': data.document.fullpath, 'name': `${data.title}.pdf`})}">Unduh Berkas</a>
                    </div>`);
                    modal.find('#publication').html(`<span class="badge ${data.public ? 'bg-success' : 'bg-dark'}">${data.public ? 'Dipublikasikan' : 'Tidak Dipublikasikan'}</span>`);

                    initPDFViewer(data.document.fullurl, 'pdfShowWrapper');

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
