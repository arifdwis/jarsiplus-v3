<div class="d-flex bg-white align-items-center p-2">
    <div class="col-sm">
        <h2 class="page-header-title mb-0">{!! $title !!}</h2>
        <p class="mb-0">{!! $description !!}</p>
    </div>
    <div class="col-sm-auto d-sm-flex d-none">
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
        @isset($create)
            <a class="btn btn-white btn-sm ms-1" href="{{ $create }}">
                <i class="bi-plus"></i> New
            </a>
        @endisset
    </div>
</div>


