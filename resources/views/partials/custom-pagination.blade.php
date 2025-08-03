@if ($paginator->hasPages())
    {{-- $paginator adalah variabel yang otomatis dikirim oleh Laravel ke view pagination --}}
    <nav>
        <ul class="pagination">
            {{-- Tombol "Previous" / "Sebelumnya" --}}
            @if ($paginator->onFirstPage())
                {{-- Nonaktifkan tombol jika sedang di halaman pertama --}}
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">Sebelumnya</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Sebelumnya</a>
                </li>
            @endif

            {{-- Elemen Paginasi (Angka Halaman dan "...") --}}
            @foreach ($elements as $element)
                {{-- Tanda "..." jika halaman terlalu banyak --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Angka Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Beri class "active" untuk halaman yang sedang dilihat --}}
                            <li class="page-item active" aria-current="page"><span
                                    class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol "Next" / "Berikutnya" --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya</a>
                </li>
            @else
                {{-- Nonaktifkan tombol jika sudah di halaman terakhir --}}
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">Berikutnya</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
