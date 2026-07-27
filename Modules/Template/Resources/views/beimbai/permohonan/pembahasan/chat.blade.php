@foreach($data->historis as $value)

    <div class="message-divider">
        {{tgl_indo($value->created_at)}}
    </div>


    <div class="message-item {{$value->id_operator != me()->id ? '' : 'user'}}">
        <div class="content">
            @if($value->id_operator != me()->id)
            <div class="title py-2">{{$value->operator->name}} ( {{$value->operator->roles->first()->name}} )</div>
            @endif
            <div class="bubble">
                {{$value->deskripsi}} oleh {{optional($value->operator)->name}}
            </div>
        </div>
    </div>

    <div class="message-item {{$value->id_operator != me()->id ? '' : 'user'}}">
        <div class="content">
            <a href="{{asset("$value->file")}}" data-lity>
                <div class="bubble px-5 py-5">
                 <iconify-icon icon="ant-design:file-pdf-twotone" class="detail-file"></iconify-icon>
                </div>
            </a>
            <div class="footer">{{waktu_chat($value->created_at)}}</div>
        </div>
    </div>

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
            <div class="footer">{{waktu_chat($value->created_at)}}</div>
        </div>
    </div>
    @endforeach
    @endif


@endforeach