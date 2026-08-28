@if(isset($data->historis) && $data->historis->count() > 0)
    @php
        $myUserId = me() ? me()->id : auth()->id();
    @endphp

    @foreach($data->historis as $key => $value)
        <div class="jp-chat-divider">
            <span>{{ tgl_indo($value->created_at) }}</span>
        </div>

        @php
            $isMine = ($value->id_operator == $myUserId);
            $operatorName = optional($value->operator)->name ?? 'Sistem';
            $operatorRole = optional(optional($value->operator)->roles)->first()->name ?? 'Pengguna';
        @endphp

        {{-- Pesan utama --}}
        <div class="jp-bubble-row {{ $isMine ? 'is-mine' : '' }}">
            <div class="jp-bubble {{ $isMine ? 'jp-bubble--mine' : '' }}">
                <div class="jp-bubble__head">
                    <strong class="jp-bubble__name">
                        {{ $operatorName }}
                        <span class="font-mono jp-bubble__role">({{ $operatorRole }})</span>
                    </strong>
                    <span class="font-mono jp-bubble__time">{{ waktu_chat($value->created_at) }}</span>
                </div>

                <p class="jp-bubble__text">
                    @if(filled($value->deskripsi))
                        {{ $value->deskripsi }}
                    @else
                        <em>Tidak ada keterangan.</em>
                    @endif
                </p>

                @if(!empty($value->file) && strlen(trim($value->file)) > 0)
                    <div class="jp-bubble__attach">
                        <a href="{{ file_url($value->file) }}" target="_blank" rel="noopener" class="jp-bubble__chip">
                            <x-icon name="file" size="14" />
                            {{ basename($value->file) }}
                        </a>
                    </div>
                @endif

                @if($key == 0 && isset($value->dukungs) && !empty($value->dukungs->url))
                    <div class="jp-bubble__attach">
                        <a href="{{ $value->dukungs->url }}" target="_blank" rel="noopener" class="jp-bubble__chip">
                            <x-icon name="link" size="14" />
                            {{ $value->dukungs->url }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tanggapan --}}
        @if($value->pembahasans && $value->pembahasans->count() > 0)
            @foreach($value->pembahasans as $child)
                @php
                    $isChildMine = ($child->id_operator == $myUserId);
                    $childName = optional($child->operator)->name ?? 'Pengguna';
                    $childRole = optional(optional($child->operator)->roles)->first()->name ?? 'Pembahas';
                @endphp

                <div class="jp-bubble-row {{ $isChildMine ? 'is-mine' : '' }}">
                    <div class="jp-bubble jp-bubble--reply {{ $isChildMine ? 'jp-bubble--mine' : '' }}">
                        <div class="jp-bubble__head">
                            <strong class="jp-bubble__name">
                                {{ $childName }}
                                <span class="font-mono jp-bubble__role">({{ $childRole }})</span>
                            </strong>
                            <span class="font-mono jp-bubble__time">{{ waktu_chat($child->created_at) }}</span>
                        </div>
                        <p class="jp-bubble__text">
                            @if(filled($child->komentar))
                                {{ $child->komentar }}
                            @else
                                <em>Tidak ada keterangan.</em>
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
@else
    <x-empty
        icon="chat"
        title="Belum ada pembahasan"
        desc="Belum ada tanggapan atau pesan pada berkas ini. Tulis komentar pertama untuk memulai diskusi."
    />
@endif
