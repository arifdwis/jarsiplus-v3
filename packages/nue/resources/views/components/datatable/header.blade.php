<div class="d-flex bg-white align-items-center p-2">
    <div class="col-sm d-sm-flex align-items-center">
        @isset($create)
            <a class="btn btn-soft-primary btn-sm" href="{{ $create }}">
                <span class="iconify" data-icon="ps:plus"></span>
                Tambah
            </a>
        @endisset
        @isset($back)
            <a class="btn btn-soft-secondary btn-sm" href="{{ $back }}">
                <span class="iconify" data-icon="ic:round-arrow-back-ios-new"></span>
                Kembali
            </a>
        @endisset
    </div>
    <div class="col-sm-auto d-sm-flex align-items-center d-none">
        @isset($legend)
            {!! $legend !!}
        @endisset
        @isset($datatable)
            <div id="datatable-checkbox-info" style="display: none;">
                <button type="button" class="btn btn-soft-danger btn-sm" id="delete-selected">
                    <i class="bi bi-trash me-1"></i>
                    Delete <span id="datatable-checkbox">0</span> rows
                </button>
            </div>
            <div class="ms-1">
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend input-group-text px-2">
                        <i class="bi-search"></i>
                    </div>
                    <input id="datatabe-search" type="search" class="form-control form-control-sm ps-5" placeholder="Search" aria-label="Search">
                </div>
            </div>
        @endisset
    </div>
</div>


