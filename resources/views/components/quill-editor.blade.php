<div class="form-group mb-3">
    <label class="form-label" for="{{ $targetId }}">{{ $label }}</label>
    <div style="height: 200px" id="{{ $targetId }}">{!! old($targetId) !!}</div>
    <input type="hidden" name="{{ $targetId }}" value="{{ old($targetId) }}" />
</div>

@push('script')
    <script>
        var quillEditorInit = initQuillEditor("#{{ $targetId }}", {
            theme: "snow",
            placeholder: "Isikan deskripsi agenda rapat kali ini...",
            height: '200px',
        });

        quillEditorInit.on('text-change', function(delta, oldDelta, source) {
            $("#{{ $targetId }}").next().val(document.querySelector('#{{ $targetId }}').children[0].innerHTML);
        })
    </script>
@endpush
