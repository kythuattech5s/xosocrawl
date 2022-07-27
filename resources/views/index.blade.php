<!DOCTYPE html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="vi">

<head>
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{!! SEOHelper::HEADER_SEO(@$currentItem ? $currentItem : null) !!}
	{{-- @php
		$css = [];
	@endphp
	{{ SEOHelper::loadCss($css) }} --}}
	@yield('cssl')
	@yield('css')
	<script type="text/javascript">
        var showNotify = "";
        var messageNotify = "{{ Session::get('messageNotify', '') }}";
        var typeNotify = "{{ Session::get('typeNotify', '') }}";
	</script>
	{[CMS_HEADER]}
</head>

<body>
	@include('header')
	@yield('main')
	@include('footer')
	{[CMS_FOOTER]}
	{{-- @php
		$js = [];
	@endphp
	{{ SEOHelper::loadJs($js) }} --}}
	@yield('jsl')
	@yield('js')
</body>
</html>
