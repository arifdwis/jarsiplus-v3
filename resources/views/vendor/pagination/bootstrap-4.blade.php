{{--
    Paginator JARSIPLUS.

    Berkas ini wajib ada di path ini: beberapa view memanggil
    ->links('vendor.pagination.bootstrap-4'). Sebelumnya berkasnya tidak ada,
    sehingga halaman dengan lebih dari satu halaman data melempar error
    "View [vendor.pagination.bootstrap-4] not found".
--}}

@if ($paginator->hasPages())
    <nav class="jp-pagination" role="navigation" aria-label="Navigasi halaman">
        <p class="jp-pagination__info">
            Menampilkan <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong>
            dari <strong>{{ $paginator->total() }}</strong> data
        </p>

        <ul class="pagination">
            {{-- Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <x-icon name="chevron-left" size="14" />
                        <span class="u-hide-mobile">Sebelumnya</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <x-icon name="chevron-left" size="14" />
                        <span class="u-hide-mobile">Sebelumnya</span>
                    </a>
                </li>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span class="u-hide-mobile">Selanjutnya</span>
                        <x-icon name="chevron-right" size="14" />
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <span class="u-hide-mobile">Selanjutnya</span>
                        <x-icon name="chevron-right" size="14" />
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
