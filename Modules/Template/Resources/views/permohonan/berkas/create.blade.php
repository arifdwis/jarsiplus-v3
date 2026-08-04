@extends('template::layouts.master',['footer'=>false])

@section('title', 'Upload Berkas Permohonan — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="BERKAS PERMOHONAN"
    title="Upload Berkas"
    desc="Unggah dokumen yang diperlukan untuk mendukung permohonan Anda."
    :back="route('permohonan.berkas.index', $parent->uuid)"
    backLabel="Kembali ke Daftar Berkas"
/>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">
        <div class="jp-card">
            <div class="jp-notice jp-notice--accent u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="info" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Ketentuan unggah</strong>
                    <p class="jp-notice__text">Format yang diterima: PDF, JPG, PNG. Maksimal 5 MB per berkas.</p>
                </div>
            </div>

            <form action="{{ route('permohonan.berkas.store', $parent->uuid) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div id="fileInputs">
                    <x-file-drop name="berkas[]" label="Dokumen Pendukung" multiple accept=".pdf,.jpg,.jpeg,.png" maxSize="5MB" />
                </div>

                <div class="jp-form-foot">
                    <a href="{{ route('permohonan.berkas.index', $parent->uuid) }}" class="jp-btn jp-btn--ghost">Batal</a>
                    <button type="submit" class="jp-btn jp-btn--accent">
                        <x-icon name="check" size="16" />
                        Simpan Berkas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    var fileInput = document.querySelector('input[name="berkas[]"]');
    if (fileInput && fileInput.files.length > 0) {
        for (var i = 0; i < fileInput.files.length; i++) {
            if (fileInput.files[i].size > 5242880) {
                e.preventDefault();
                alert('File ' + fileInput.files[i].name + ' melebihi 5MB');
                return false;
            }
        }
    }
});
</script>
@endsection
