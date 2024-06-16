<div class="form-group mb-3">
    <label class="form-label" for="{{ $targetId }}">{{ $label }}</label>
    <div style="height: 200px" id="{{ $targetId }}">{!! old($targetId) !!}</div>
    <input type="hidden" name="{{ $targetName ?? $targetId }}" value="{{ old($targetId) }}" />

    @error($targetId)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('script')
    <script>
        var quillEditorInit = initQuillEditor("#{{ $targetId }}", {
            theme: "snow",
            placeholder: "{{ $placeholder ?? 'Isikan deskripsinya...' }}",
            height: '200px',
        });

        quillEditorInit.on('text-change', function(delta, oldDelta, source) {
            $("#{{ $targetId }}").next().val(document.querySelector('#{{ $targetId }}').children[0]
                .innerHTML);
        })
    </script>
@endpush
