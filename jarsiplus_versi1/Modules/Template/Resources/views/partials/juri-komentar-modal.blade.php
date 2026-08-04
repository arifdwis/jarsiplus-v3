<div class="modal fade" id="modalKomentarJuri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Komentar Juri</h5>
            </div>
            <div class="modal-body">
                @php
                    $comments = collect($juriComments ?? [])->values();
                @endphp

                @if($comments->isNotEmpty())
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">Total Penilai</small>
                        <span class="badge bg-primary">{{ $comments->count() }} Juri</span>
                    </div>

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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
