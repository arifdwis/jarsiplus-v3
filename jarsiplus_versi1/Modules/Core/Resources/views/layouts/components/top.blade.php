<section class="box-typical faq-page">
    <header class="box-typical-header">
        <div class="tbl-row">

            <div class="tbl-cell tbl-cell-title">
                <h3>
                    <b>{!! $judul !!}</b><br/>
                    <small><small>{!! $subjudul !!}</small></small>
                </h3>
            </div>

            @if(isset($hapus))
                <div class="tbl-cell tbl-cell-action-bordered" id="hapusAll" style="display:none">
                    <span data-toggle="tooltip" data-placement="top" title="Hapus Pilihan">
                        <button type="submit" class="action-btn" onclick="deleteAll()" id="delete-all-button">
                            <i class="font-icon font-icon-trash"></i> Hapus
                        </button>
                    </span>
                </div>
            @endif

            {{-- @if(isset($kategori))
                <div class="tbl-cell tbl-cell-action-bordered">
                    <a class="action-btn" href="{{ $kategori }}">
                        <i class="font-icon font-icon-cogwheel"></i> Kategori
                    </a>
                </div>
            @endif --}}

            @if(isset($permohonan))
                <div class="tbl-cell tbl-cell-action-bordered">
                    <a class="action-btn" href="{{ $permohonan }}">
                        <i class="font-icon font-icon-comment"></i> Permohonan
                    </a>
                </div>
            @endif

            @if(isset($order))
                <div class="tbl-cell tbl-cell-action-bordered">
                    <a class="action-btn" href="{{ $order }}">
                        <i class="fa fa-sort"></i> Order
                    </a>
                </div>
            @endif

            @if(isset($tambah))
                <div class="tbl-cell tbl-cell-action-bordered">
                    <a class="action-btn" href="{{ $tambah }}">
                        <i class="font-icon font-icon-plus"></i> Tambah
                    </a>
                </div>
            @endif

            @if(isset($kembali))
                <div class="tbl-cell tbl-cell-action-bordered">
                    <a class="action-btn" href="{{ $kembali }}">
                        <i class="font-icon font-icon-arrow-left"></i> Kembali
                    </a>
                </div>
            @endif

        </div>
    </header>
</section>