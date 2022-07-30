@if ($paginator->hasPages())
	<div class="loading-page clearfix">
		<a class="secondary" href="{{$paginator->path()}}" title="Đầu trang">
			<b> Đầu trang </b>
		</a>
		@if (!$paginator->onFirstPage())
		 | 
		<a class="secondary" href="{{$paginator->previousPageUrl()}}" title=" Tin trước">
			<img src="theme/frontend/images/left-arrow.png" width="16" height="16" alt="left">
			<b>Tin trước</b>
		</a>
		@endif
		@if (!$paginator->onLastPage())
			<a class="fr primary" href="{{$paginator->nextPageUrl()}}" title="Tin cũ hơn ">
				<b> Tin cũ hơn </b>
				<img alt="right" height="16" src="theme/frontend/images/right-arrow.png" width="16" />
			</a>
		@endif
	</div>
@endif
