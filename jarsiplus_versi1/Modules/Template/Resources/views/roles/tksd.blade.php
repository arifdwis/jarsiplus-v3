<div class="section pt-2 pb-3">
   <div class="row">
           @foreach(Modules\Formulir\Entities\Permohonan::whereIn('status',[1,2,4])->latest()->get() as $value)
           <div class="col-6 col-lg-3 mb-2">
            <a href="{{route('permohonan.show',$value->kode)}}">
                <div class="card  h-100">
                    <div class="kode bg-primary">
                        @if($value->status == 0)
                        <iconify-icon icon="ic:twotone-pending-actions"></iconify-icon>
                        @elseif($value->status == 1)
                        <iconify-icon icon="ic:twotone-timer"></iconify-icon>
                        @elseif($value->status == 2)
                        <iconify-icon icon="ic:twotone-auto-stories"></iconify-icon>
                        @elseif($value->status == 4)
                        <iconify-icon icon="ic:twotone-check-circle"></iconify-icon>
                        @elseif($value->status == 9)
                        <iconify-icon icon="icon-park-twotone:close-one"></iconify-icon>
                        @endif
                        <h2 style="color: white !important;">{{$value->kode}}</h2>
                    </div>
                    <div class="card-body pt-2">
                        <h6 class="mb-0" style="color: black !important;">Permohonan</h6>
                        <h5 class="mb-0" style="color: black !important;">{{$value->label}}</h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
   </div>
</div>