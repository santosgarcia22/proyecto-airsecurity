@if ($paginator->hasPages())
<nav>
  <ul class="pagination-asg list-unstyled mb-0">
    {{-- Primero --}}
    @if ($paginator->onFirstPage())
      <li class="page-item disabled"><span class="page-link">Primero</span></li>
    @else
      <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">Primero</a></li>
    @endif

    {{-- Anterior --}}
    @if ($paginator->onFirstPage())
      <li class="page-item disabled"><span class="page-link">Anterior</span></li>
    @else
      <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Anterior</a></li>
    @endif

    {{-- Números --}}
    @foreach ($elements as $element)
      @if (is_string($element))
        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
          @else
            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Siguiente --}}
    @if ($paginator->hasMorePages())
      <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Siguiente</a></li>
    @else
      <li class="page-item disabled"><span class="page-link">Siguiente</span></li>
    @endif

    {{-- Último --}}
    @if ($paginator->hasMorePages())
      <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Último</a></li>
    @else
      <li class="page-item disabled"><span class="page-link">Último</span></li>
    @endif
  </ul>
</nav>
@endif
