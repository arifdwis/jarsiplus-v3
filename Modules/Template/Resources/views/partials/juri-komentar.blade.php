@php
    $comments = collect($juriComments ?? [])->values();
@endphp

<section class="jp-card" id="komentar-juri">
    <header class="jp-card-head">
        <div>
            <span class="jp-badge jp-badge--accent">CATATAN EVALUASI</span>
            <h3 class="u-mt-xs u-mb-0">Catatan &amp; Komentar Tim Juri</h3>
        </div>
        @if($comments->isNotEmpty())
            <span class="jp-badge jp-badge--neutral">{{ $comments->count() }} juri</span>
        @endif
    </header>

    @if($comments->isNotEmpty())
        <div class="u-flex u-flex-col u-gap-sm">
            @foreach($comments as $comment)
                @php
                    $namaJuri = $comment['nama_juri'] ?? null;
                    $nilaiJuri = $comment['nilai_juri'] ?? null;
                    $komentarJuri = trim((string) ($comment['komentar_juri'] ?? ''));
                @endphp

                <article class="jp-card jp-card--compact jp-card--flat" style="border: 1px solid var(--c-border); background-color: var(--c-surface-sunken);">
                    <div class="u-flex u-justify-between u-align-center u-flex-wrap u-gap-sm u-mb-xs">
                        <div style="min-width: 0;">
                            <span class="jp-deflist__label">Juri {{ $loop->iteration }}</span>
                            <strong class="u-block" style="color: var(--c-ink); font-size: var(--t-base);">
                                @if(filled($namaJuri)){{ $namaJuri }}@else<span class="jp-value-empty"></span>@endif
                            </strong>
                        </div>

                        @if(filled($nilaiJuri))
                            <span class="jp-badge jp-badge--success font-mono">Nilai: {{ $nilaiJuri }}</span>
                        @else
                            <span class="jp-badge jp-badge--neutral">Nilai belum tersedia</span>
                        @endif
                    </div>

                    <p class="jp-prose {{ $komentarJuri !== '' ? '' : 'jp-prose--empty' }}" style="white-space: pre-line;">
                        {{ $komentarJuri !== '' ? $komentarJuri : 'Juri belum menuliskan catatan.' }}
                    </p>
                </article>
            @endforeach
        </div>
    @else
        <x-empty
            icon="chat"
            title="Belum ada catatan juri"
            desc="Penilaian tim juri belum tersedia atau belum dipublikasikan untuk usulan ini."
        />
    @endif
</section>
