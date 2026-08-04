@if($type == 'pembahasan')
    @if(role_me() == 4 && $parent->status == 1)
        <div class="l-container u-mt-xl">
            <div class="jp-actionbar">
                <p class="jp-actionbar__text">Apakah data sudah lengkap?</p>
                <div class="u-flex u-gap-sm u-flex-wrap">
                    <button type="button" class="jp-btn jp-btn--on-dark"
                            onclick="event.preventDefault();document.getElementById('formLengkapi').submit();">
                        Ya, Lengkapi
                    </button>
                    <button type="button" class="jp-btn jp-btn--on-dark"
                            onclick="event.preventDefault();document.getElementById('formKurang').submit();">
                        Kurang Lengkap
                    </button>
                </div>
            </div>
        </div>
        <form id="formLengkapi" action="{{ route('permohonan.berkas.lengkapi',[$parent->uuid]) }}" method="POST" class="u-hidden">@csrf @method('PATCH')</form>
        <form id="formKurang" action="{{ route('permohonan.berkas.kurang',[$parent->uuid]) }}" method="POST" class="u-hidden">@csrf @method('PATCH')</form>
    @endif

    @if(role_me() == 2 && in_array($parent->status,[2,3]))
        <div class="l-container u-mt-xl">
            <div class="jp-actionbar">
                <p class="jp-actionbar__text">Verifikasi permohonan</p>
                <div class="u-flex u-gap-sm u-flex-wrap">
                    <button type="button" class="jp-btn jp-btn--on-dark"
                            onclick="event.preventDefault();document.getElementById('formSetuju').submit();">
                        Setuju
                    </button>
                    <button type="button" class="jp-btn jp-btn--on-dark"
                            onclick="event.preventDefault();document.getElementById('formTolak').submit();">
                        Tolak
                    </button>
                </div>
            </div>
        </div>
        <form id="formSetuju" action="{{ route('permohonan.berkas.setuju',[$parent->uuid]) }}" method="POST" class="u-hidden">@csrf @method('PATCH')</form>
        <form id="formTolak" action="{{ route('permohonan.berkas.tolak',[$parent->uuid]) }}" method="POST" class="u-hidden">@csrf @method('PATCH')</form>
    @endif
@endif
