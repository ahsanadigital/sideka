@push('links')
    <link rel="stylesheet" href="{{ asset('dist/libs/quill/dist/quill.snow.css') }}" />
@endpush

<div class="form-group mb-3">
    <label class="form-label" for="{{ $targetId }}">{{ $label }}</label>
    <div style="height: 200px" id="{{ $targetId }}">{!! old($targetId) !!}</div>
    <input type="hidden" name="{{ $targetName ?? $targetId }}" value="{{ old($targetId) }}" />

    <div class="error-wrapper"></div>

    @error($targetId)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script src="{{ asset('dist/libs/quill/dist/quill.min.js') }}"></script>
@endpush

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
