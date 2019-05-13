@if ($paginator->hasPages())
    <div class="pagenav-box">
        <div class="frm-counter">
            @if ($paginator->onFirstPage())
                <a href="#" class="btn-prev"></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn-prev"></a>
            @endif


            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn-next"></a>
            @else
                <a href="#" class="btn-next"></a>
            @endif

                <input type="text" value="{{$paginator->currentPage()}}">
        </div>
        <div class="page-total">из {{$paginator->total()}}</div>
    </div>
@endif
