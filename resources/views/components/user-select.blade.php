@role('region')
    @php
        $randomElementId = \Str::uuid();
    @endphp

    @push('links')
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <!-- Or for RTL support -->
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
        <link rel="stylesheet" href="{{ asset('dist/libs/select2/dist/css/select2.min.css') }}" />
    @endpush

    @push('script')
        <script src="{{ asset('dist/libs/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('dist/libs/select2/dist/js/select2.min.js') }}"></script>
    @endpush

    <div class="form-group mb-3">
        <label for="user-select_{{ $randomElementId }}" class="form-label">Pengunggah</label>

        <select name="users_id" id="user-select_{{ $randomElementId }}"
            class="select2 user-select form-control custom-select" style="width: 100%; height: 36px">
        </select>

        <div class="form-check mt-2">
            <input type="checkbox" class="form-check-input" id="assign-as-me_{{ $randomElementId }}" />
            <label for="assign-as-me_{{ $randomElementId }}">Tetapkan ke saya</label>
        </div>

        <div class="error-wrapper"></div>

        @error('users_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @push('script')
        <script>
            var selectTarget = $('#user-select_{{ $randomElementId }}').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih',
                dropdownParent: $('#user-select_{{ $randomElementId }}').parent(),
                minimumInputLength: 3,
                language: 'id',
                ajax: {
                    url: "{{ route('api.user.index', ['isDropdown' => 'true']) }}",
                    dataType: 'json',
                    processResults: function(data) {
                        const results = data;

                        return {
                            results
                        };
                    }
                }
            });

            selectTarget.on('select2:open', (e) => {
                const evt = "scroll.select2";
                $(e.target).parents().off(evt);
                $(window).off(evt);
            });

            $('#assign-as-me_{{ $randomElementId }}').on('change', (event) => {
                if (event.currentTarget.checked) {
                    var $newOption = $(`<option selected="selected" />`).val("{{ auth()->id() }}").text(
                        "{{ auth()->user()->fullname }}")
                    $('#user-select_{{ $randomElementId }}').html($newOption).trigger('change');
                    $('#user-select_{{ $randomElementId }}').next('.select2-container').hide()
                } else {
                    $('#user-select_{{ $randomElementId }}').val(null).removeAttr('disabled').trigger('change');
                    $('#user-select_{{ $randomElementId }}').next('.select2-container').show()
                }
            });
        </script>
    @endpush
@else
    <input type="hidden" name="users_id" value="{{ auth()->id() }}">
@endrole
