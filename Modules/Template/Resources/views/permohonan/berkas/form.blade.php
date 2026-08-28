@if($label != 'upload')
    <div class="u-flex u-flex-wrap u-gap-sm u-mb-lg">
        @foreach($berkas as $b)
            <div class="jp-badge jp-badge--accent u-flex u-gap-xs u-align-center" style="max-width:100%">
                <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $b->name ?? $b->getClientOriginalName() }}</span>
                <a href="{{ file_url($b->path) }}" target="_blank" class="jp-btn jp-btn--quiet jp-btn--xs" title="Lihat">
                    <x-icon name="eye" size="14" />
                </a>
            </div>
        @endforeach
    </div>
@endif

@if($label == 'upload')
    <div class="jp-field u-mb-lg">
        <label class="jp-label">Upload</label>
        <x-file-drop name="berkas[{{ $id }}][]" multiple accept=".pdf,.jpg,.jpeg,.png" />
    </div>
@endif