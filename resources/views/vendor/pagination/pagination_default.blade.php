@php
    $urlDefault = isset($url) ? url($url) : false;
    $params = request()->all();
@endphp
@if ($paginator->hasPages())
	@php
		$lastPage = $paginator->lastPage();
		$currentPage = $paginator->currentPage();
	@endphp
	<div class="paging txt-center">
		@if ($paginator->onFirstPage())
		@else
			<a href="{{ $paginator->previousPageUrl() }}">«</a>
			@if (!in_array($currentPage, [1, 2, 3, 4]))
				<a href="{{ $urlDefault ? Support::buildLinkPagination($urlDefault, 1) : $paginator->url(1) }}">1</a></li>
				@if ($currentPage !== 5)
					<span style="pointer-events: none"> ... </span>
				@endif
			@endif
		@endif
		@foreach ($elements as $key => $element)
			@if (is_array($element))
				@foreach ($element as $page => $url)
					@if ($page == $currentPage)
                        <a href="javascript:void(0)" class="active">{{$page}}</a></li>
					@elseif($page == $currentPage + 1 || $page == $currentPage + 2 || $page == $currentPage + 3 || $page == $currentPage - 1 || $page == $currentPage - 2 || $page == $currentPage - 3)
						<a href="{{  $urlDefault ? Support::buildLinkPagination($urlDefault,$page) : $url }}">{{$page}}</a></li>
					@endif
				@endforeach
			@endif
		@endforeach
		@if ($paginator->hasMorePages())
			@if (!in_array($currentPage, [$lastPage, $lastPage - 1, $lastPage - 2, $lastPage - 3]))
				@if ($currentPage !== $lastPage - 4)
					<span style="pointer-events: none"> ... </span>
				@endif
				<a href="{{ $urlDefault ? Support::buildLinkPagination($urlDefault,$page) : $paginator->url($page) }}">{{ $page }}</a></li>
			@endif
			<a href="{{ $urlDefault ? Support::buildLinkPagination($urlDefault,$currentPage + 1) : $paginator->nextPageUrl() }}">»</a>
		@else
		@endif
	</div>
@endif
