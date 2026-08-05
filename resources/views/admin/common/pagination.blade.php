@if ($paginator->hasPages())
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; color: #8e89a5; font-size: 0.9rem;">

        <div class="pagination-info">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
        </div>

        <ul style="display: flex; list-style: none; padding: 0; margin: 0; gap: 0.5rem;">


            @if ($paginator->onFirstPage())
                <li>
                    <span style="display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; background-color: #1e1b2e; color: #4b5563; cursor: not-allowed;">&laquo; Prev</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" style="display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; background-color: #2a263d; color: #e5e7eb; text-decoration: none;">&laquo; Prev</a>
                </li>
            @endif


            @foreach ($elements as $element)

                @if (is_string($element))
                    <li>
                        <span style="display: inline-block; padding: 0.5rem 1rem; color: #8e89a5;">{{ $element }}</span>
                    </li>
                @endif


                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; background-color: #6366f1; color: #ffffff; font-weight: bold;">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; background-color: #2a263d; color: #8e89a5; text-decoration: none;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach


            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" style="display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; background-color: #2a263d; color: #e5e7eb; text-decoration: none;">Next &raquo;</a>
                </li>
            @else
                <li>
                    <span style="display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; background-color: #1e1b2e; color: #4b5563; cursor: not-allowed;">Next &raquo;</span>
                </li>
            @endif
        </ul>
    </div>
@endif
