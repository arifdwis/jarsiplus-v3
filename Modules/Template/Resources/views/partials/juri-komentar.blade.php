<div class="section pt-2 pb-3" id="komentar-juri">
    <div class="card comment-box">
        <div class="card-body">
            @php
                $comments = collect($juriComments ?? [])->values();
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Komentar Juri</h4>
                <span class="badge bg-primary">{{ $comments->count() }} Juri</span>
            </div>

            @if($comments->isNotEmpty())
                @foreach($comments as $comment)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <div>
                                <strong>Juri {{ $loop->iteration }}</strong>
                                <div class="text-muted small">{{ $comment['nama_juri'] ?? '-' }}</div>
                            </div>
                            <span class="badge bg-primary">Nilai: {{ $comment['nilai_juri'] ?? '-' }}</span>
                        </div>
                        <div class="text-muted" style="white-space: pre-line;">
                            {{ trim((string) ($comment['komentar_juri'] ?? '')) !== '' ? $comment['komentar_juri'] : 'Tidak ada komentar.' }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-light border mb-0">
                    Juri belum menilai atau data komentar belum tersedia.
                </div>
            @endif
        </div>
    </div>
</div>
