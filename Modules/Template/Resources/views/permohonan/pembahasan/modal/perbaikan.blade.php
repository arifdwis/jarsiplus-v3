<dialog class="jp-dialog" id="addActionSheet">
    <div style="padding:20px 24px;border-bottom:1px solid var(--c-border)">
        <h3 style="margin:0;font-size:1.1rem;font-weight:700;color:var(--c-text)">
            @if($data->jenis == 'url')
                Perbarui Link
            @else
                Perbaikan Berkas
            @endif
        </h3>
    </div>

    {!! Form::model($data, ['route' => ["$prefix.update", [$parent->uuid, $data->uuid]], 'autocomplete' => 'off', 'method' => 'PUT', 'files' => true]) !!}

    <div style="padding:24px">
        @if ($errors->any())
            <div style="padding:12px;background:var(--c-danger-light);border:1px solid var(--c-danger);border-radius:var(--r-card);margin-bottom:16px;color:var(--c-danger);font-size:var(--t-sm)">
                <ul style="margin:0;padding-left:16px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($data->jenis == 'url')
            <div class="jp-field u-mb-lg">
                <label class="jp-label require-form" for="url">URL / Link</label>
                {!! Form::text('url', $data->url, ['class' => 'jp-input', 'placeholder' => 'Masukkan URL lengkap (https://...)']) !!}
            </div>
        @else
            <div class="jp-field u-mb-lg">
                <label class="jp-label require-form" for="file-upload-perbaikan">File Berkas</label>
                <div style="padding:10px 14px;background:#FFF3CD;border:1px solid #FFC107;border-radius:var(--r-card);font-size:var(--t-sm);color:#856404;margin-bottom:12px">
                    <strong>⚠ Perhatian:</strong> Ukuran file maksimal <b>10 MB</b>
                </div>
                <div class="jp-file-drop">
                    <input type="file" name="file" id="file-upload-perbaikan" class="jp-file-drop__input" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.mp4">
                    <label for="file-upload-perbaikan" class="jp-file-drop__label">
                        <x-icon name="upload" size="24" style="color:var(--c-text-muted);margin-bottom:4px" />
                        <span style="font-size:var(--t-sm);color:var(--c-text-muted)">Tap to Upload</span>
                    </label>
                </div>
            </div>
        @endif

        <div class="u-flex u-justify-end u-gap-md" style="padding-top:16px;border-top:1px solid var(--c-border)">
            <button type="button" class="jp-btn jp-btn--ghost" onclick="this.closest('dialog').close()">Batal</button>
            <button type="submit" class="jp-btn jp-btn--accent">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</dialog>

@section('js')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fileInput = document.getElementById('file-upload-perbaikan');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    var file = this.files[0];
                    if (file && file.size > 10 * 1024 * 1024) {
                        alert('Ukuran file maksimal 10 MB! File yang dipilih: ' + (file.size / 1024 / 1024).toFixed(2) + ' MB');
                        this.value = '';
                    }
                });
            }
        });
    </script>
@endsection