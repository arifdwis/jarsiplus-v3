<div class="card-footer py-2">
    <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
        <div class="col-sm d-sm-block d-none">
            <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                <span class="me-2">Showing:</span>
                <div class="tom-select-custom">
                    <select id="datatable-entries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" style="padding:7px 1.8rem 7px .5rem" 
                        data-nue-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                        }'>
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <span class="text-secondary me-2">of</span>
                <span id="datatable-total"></span>
            </div>
        </div>

        <div class="col-sm-auto">
            <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="datatable-pagination" aria-label="Activity pagination"></nav>
            </div>
        </div>
    </div>
</div>