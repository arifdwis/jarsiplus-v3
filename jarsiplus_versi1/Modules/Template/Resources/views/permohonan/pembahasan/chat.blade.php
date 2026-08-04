@foreach($data->historis as $key => $value)
    <div class="message-divider">
        {{tgl_indo($value->created_at)}}
    </div>

    <div class="message-item {{$value->id_operator != me()->id ? '' : 'user'}}">
        <div class="content">
            <div class="title py-2">{{$value->operator->name}} ( {{$value->operator->roles->first()->name}} )</div>
            <div class="bubble">
                {{$value->deskripsi}} oleh {{optional($value->operator)->name}}
            </div>
        </div>
    </div>

    {{-- Tampilkan file dari histori (field file di histori sendiri) --}}
    @if(!empty($value->file) && strlen(trim($value->file)) > 0)
        <div class="message-item {{$value->id_operator != me()->id ? '' : 'user'}}">
            <div class="content">
                <a href="{{asset($value->file)}}" data-lity>
                    <div class="bubble px-5 py-5">
                        <iconify-icon icon="ant-design:file-pdf-twotone" class="detail-file"></iconify-icon>
                    </div>
                </a>
                <div class="footer">{{waktu_chat($value->created_at)}}</div>
            </div>
        </div>
    @endif

    {{-- Tampilkan URL: hanya di histori pertama (submit awal) --}}
    @if($key == 0 && isset($value->dukungs) && !empty($value->dukungs->url))
        <div class="message-item {{$value->id_operator != me()->id ? '' : 'user'}}">
            <div class="content">
                <div class="bubble px-3 py-3">
                    <a href="{{$value->dukungs->url}}" target="_blank" style="color: white; text-decoration: none;">
                        <iconify-icon icon="mdi:link-variant" class="detail-file"></iconify-icon>
                        <br><small style="word-break: break-all;">{{$value->dukungs->url}}</small>
                    </a>
                </div>
                <div class="footer">{{waktu_chat($value->created_at)}}</div>
            </div>
        </div>
    @endif

    @if($value->pembahasans)
        @foreach($value->pembahasans as $child)
            <div class="message-item {{$child->id_operator != me()->id ? '' : 'user'}}">
                <div class="content">
                    @if($child->id_operator != me()->id)
                        <div class="title py-2">{{$child->operator->name}} ( {{$child->operator->roles->first()->name}} )</div>
                    @endif
                    <div class="bubble">
                        {{$child->komentar}}
                    </div>
                    <div class="footer">{{waktu_chat($child->created_at)}}</div>
                </div>
            </div>
        @endforeach
    @endif


@endforeach