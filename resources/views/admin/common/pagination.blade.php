@if ($paginator->hasPages())
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 0 0.5rem 0; color: #6b7280; font-size: 0.88rem; flex-wrap: wrap; gap: 1rem;">
        <div class="pagination-info">
            Showing <strong style="color: #111827;">{{ $paginator->firstItem() }}</strong> to <strong style="color: #111827;">{{ $paginator->lastItem() }}</strong> of <strong style="color: #111827;">{{ $paginator->total() }}</strong> entries
        </div>
        <ul style="display: flex; list-style: none; padding: 0; margin: 0; gap: 0.35rem; align-items: center;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span style="display: inline-flex; align-items: center; justify-content: center; height: 34px; padding: 0 0.85rem; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #9ca3af; font-size: 0.82rem; font-weight: 500; cursor: not-allowed;">
                        &laquo; Prev
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" style="display: inline-flex; align-items: center; justify-content: center; height: 34px; padding: 0 0.85rem; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #ffffff; color: #374151; font-size: 0.82rem; font-weight: 500; text-decoration: none; transition: all 0.15s ease;">
                        &laquo; Prev
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; color: #9ca3af; font-size: 0.85rem;">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background-color: #7c3aed; color: #ffffff; font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 4px rgba(124, 58, 237, 0.25);">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #ffffff; color: #374151; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: all 0.15s ease;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" style="display: inline-flex; align-items: center; justify-content: center; height: 34px; padding: 0 0.85rem; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #ffffff; color: #374151; font-size: 0.82rem; font-weight: 500; text-decoration: none; transition: all 0.15s ease;">
                        Next &raquo;
                    </a>
                </li>
            @else
                <li>
                    <span style="display: inline-flex; align-items: center; justify-content: center; height: 34px; padding: 0 0.85rem; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #9ca3af; font-size: 0.82rem; font-weight: 500; cursor: not-allowed;">
                        Next &raquo;
                    </span>
                </li>
            @endif
        </ul>
    </div>
@endif
