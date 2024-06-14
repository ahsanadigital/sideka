@php
    $randomElementId = \Str::uuid();
@endphp

<div class="form-group mb-3">
    <label for="category-select_{{ $randomElementId }}" class="form-label">Kategori</label>

    <select name="{{ $targetName ?? 'category_id' }}" id="category-select_{{ $randomElementId }}" class="select2 category-select form-control custom-select"
        style="width: 100%; height: 36px">
    </select>

    <div class="error-wrapper"></div>

    @error($targetName ?? 'category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

@push('script')
    <script>
        var selectTarget = $('#category-select_{{ $randomElementId }}').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Pilih',
            dropdownParent: $('#category-select_{{ $randomElementId }}').parent(),
            minimumInputLength: 3,
            language: 'id',
            ajax: {
                url: "{{ route('api.council-category.index', ['isDropdown' => 'true']) }}",
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
    </script>
@endpush
