<dialog id="dialog_komentar" class="jp-modal jp-modal--lg">
    <div class="jp-modal__head">
        <div class="u-flex u-align-center u-gap-sm">
            <span class="jp-modal__icon"><x-icon name="chat" size="20" /></span>
            <h3 class="jp-modal__title">Komentar Juri</h3>
        </div>
        <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="this.closest('dialog').close()">
            <x-icon name="close" size="22" />
        </button>
    </div>

    <div class="jp-modal__body">
        @forelse($komentars as $k)
            <div class="jp-chat-item">
                <div class="jp-chat-item__head">
                    <span class="jp-chat-item__name">{{ $k->user->name ?? 'Juri' }}</span>
                    <span class="jp-chat-item__time">{{ $k->created_at->diffForHumans() }}</span>
                </div>
                <p class="jp-chat-item__text">{!! nl2br(e($k->komentar)) !!}</p>
            </div>
        @empty
            <x-empty
                icon="chat"
                title="Belum ada komentar"
                desc="Tim juri belum menuliskan komentar untuk berkas ini."
            />
        @endforelse
    </div>

    <div class="jp-modal__foot">
        <span class="jp-field__hint">{{ count($komentars) }} komentar</span>
        <button type="button" class="jp-btn jp-btn--ghost" onclick="this.closest('dialog').close()">Tutup</button>
    </div>
</dialog>
