<dialog id="dialog_chat" class="jp-modal jp-modal--lg">
    <div class="jp-modal__head">
        <div class="u-flex u-align-center u-gap-sm">
            <span class="jp-modal__icon"><x-icon name="chat" size="20" /></span>
            <h3 class="jp-modal__title">Diskusi</h3>
        </div>
        <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="this.closest('dialog').close()">
            <x-icon name="close" size="22" />
        </button>
    </div>

    <div class="jp-modal__body jp-chat-feed" style="border-bottom: none; max-height: none;">
        @forelse($chats as $chat)
            @php $isMine = $chat->user_id == auth()->id(); @endphp

            <div class="jp-bubble-row {{ $isMine ? 'is-mine' : '' }}">
                <div class="jp-bubble {{ $isMine ? 'jp-bubble--mine' : '' }}">
                    <div class="jp-bubble__head">
                        <strong class="jp-bubble__name">{{ $chat->user->name ?? 'Pengguna' }}</strong>
                        <span class="font-mono jp-bubble__time">{{ $chat->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="jp-bubble__text">{!! nl2br(e($chat->message)) !!}</p>
                </div>
            </div>
        @empty
            <x-empty
                icon="chat"
                title="Belum ada pesan"
                desc="Diskusi pada berkas ini belum dimulai."
            />
        @endforelse
    </div>

    <div class="jp-modal__foot">
        <span class="jp-field__hint">{{ count($chats) }} pesan</span>
        <button type="button" class="jp-btn jp-btn--ghost" onclick="this.closest('dialog').close()">Tutup</button>
    </div>
</dialog>
