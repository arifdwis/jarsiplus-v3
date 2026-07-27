<div class="box-typical box-typical-full-height">
    <div class="add-customers-screen tbl">
        <div class="add-customers-screen-in">
            <div class="add-customers-screen-user">
                <i class="{{ $icon }}"></i>
            </div>
            <h2>{{ $judul }}</h2>
            <p class="lead color-blue-grey-lighter">{{ $subjudul }}</p>

            @if(isset($kembali))
                <a href="{{ $kembali }}" class="btn btn-default">Kembali</a>
                <span class="atau"> atau </span>
            @endif

            {{-- @if(isset($kategori))
                <a href="{{ $kategori }}" class="btn btn-default"><i class="fa fa-cog"></i> Kategori</a>
                <span class="atau"> atau </span>
            @endif --}}

            @if(isset($tambah))
            	<a href="{{ $tambah }}" class="btn">Tambah Sekarang</a>
            @endif

        </div>
    </div>
</div>