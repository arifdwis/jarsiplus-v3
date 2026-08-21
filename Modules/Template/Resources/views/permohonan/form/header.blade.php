<div class="jp-section" style="padding-bottom:0">
    <div class="l-container">
        @if($parent->status == 0)
            @if(role_me() == 4)
                <div class="jp-strip u-mb-xl" style="background:var(--c-amber);color:#fff">
                    <div class="u-flex u-align-center u-gap-sm">
                        <x-icon name="alert-triangle" size="20" style="color:#fff" />
                        <p class="u-mb-0" style="color:#fff;font-weight:600">Menunggu Verifikasi Tim Verifikator</p>
                    </div>
                </div>
            @endif
        @endif

        @if($parent->status == 1)
            <div class="jp-strip u-mb-xl" style="background:var(--c-accent);color:#fff">
                <div class="u-flex u-align-center u-gap-sm">
                    <x-icon name="check" size="20" style="color:#fff" />
                    <p class="u-mb-0" style="color:#fff;font-weight:600">Diteruskan ke Operator</p>
                </div>
            </div>
        @endif

        @if($parent->status == 2)
            <div class="jp-strip u-mb-xl" style="background:var(--c-accent);color:#fff">
                <div class="u-flex u-align-center u-gap-sm">
                    <x-icon name="info" size="20" style="color:#fff" />
                    <p class="u-mb-0" style="color:#fff;font-weight:600">Dalam Proses Verifikasi</p>
                </div>
            </div>
        @endif

        @if($parent->status == 9)
            <div class="jp-strip u-mb-xl" style="background:var(--c-danger);color:#fff">
                <div class="u-flex u-align-center u-gap-sm">
                    <x-icon name="close" size="20" style="color:#fff" />
                    <p class="u-mb-0" style="color:#fff;font-weight:600">DITOLAK</p>
                </div>
            </div>
        @endif

        <div class="l-grid l-grid--2 u-mb-xl">
            <div class="jp-card u-p-lg">
                <div class="jp-data-card" style="margin-bottom:0">
                    <div class="jp-data-card__bar">
                        <h1>Kode</h1>
                    </div>
                    <div class="jp-data-card__body">
                        <h1 style="margin:0;font-size:var(--t-2xl);font-weight:700;color:var(--c-accent);font-family:var(--font-heading)">{{ $parent->kode }}</h1>
                    </div>
                </div>
            </div>
            <div class="jp-card u-p-lg">
                <div class="jp-data-card" style="margin-bottom:0">
                    <div class="jp-data-card__bar">
                        <h1>Judul</h1>
                    </div>
                    <div class="jp-data-card__body">
                        <h1 style="margin:0;font-size:var(--t-lg);font-weight:700;color:var(--c-text);font-family:var(--font-heading)">{{ $parent->title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="jp-divider u-mb-xl"></div>
    </div>
</div>