<div class="d-flex bg-white align-items-center p-2">
    <div class="col-sm">
        <h2 class="page-header-title mb-0">{!! $title !!}</h2>
        <p class="mb-0">{!! $description !!}</p>
    </div>
    <div class="col-sm-auto d-sm-flex d-none">
        @isset($filter)
        <div class="dropdown">
          <button class="btn btn-white btn-sm ms-1 dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Filter Data
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            @foreach(Modules\Core\Entities\Dapodik\Agregat::where('agregat','status_kepegawaian')->get() as $item)
            <li class="dropdown-item pt-1 pb-1">
                <a class="text-dark d-block fw-bold" href="{{route("$prefix.filter",$item->value)}}">{{$item->value}}</a>
                <small class="">{{$item->total}} Orang</small>
            </li>
            @endforeach
        </ul>
        </div>
        @endisset

        @isset($datatable)
            <div id="datatable-checkbox-info" style="display: none;">
                <button type="button" class="btn btn-soft-danger btn-sm" id="delete-selected">
                    <span class="iconify me-1" data-icon="solar:trash-bin-trash-bold"></span>
                    Delete <span id="datatable-checkbox">0</span> rows
                </button>
            </div>
            <div class="ms-1">
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend input-group-text px-2">
                        <span class="iconify" data-icon="solar:magnifer-bold"></span>
                    </div>
                    <input id="datatabe-search" type="search" class="form-control form-control-sm ps-5" placeholder="Search" aria-label="Search">
                </div>
            </div>
        @endisset
        @isset($create)
            <a class="btn btn-white btn-sm ms-1" href="{{ $create }}">
                <span class="iconify" data-icon="solar:add-circle-bold"></span> New
            </a>
        @endisset

        
    </div>
</div>


