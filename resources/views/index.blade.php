<!DOCTYPE html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="vi">
<head>
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{!! SEOHelper::HEADER_SEO(@$currentItem ? $currentItem : null) !!}
	@yield('cssl')
	<link rel="stylesheet" href="{{Support::asset('theme/frontend/css/toastify.css')}}">
	<link rel="stylesheet" href="{{Support::asset('theme/frontend/css/style.css')}}">
	<link rel="stylesheet" href="{{Support::asset('theme/frontend/css/add.css')}}">
	@yield('css')
	<script type="text/javascript">
        var showNotify = "";
        var messageNotify = "{{ Session::get('messageNotify', '') }}";
        var typeNotify = "{{ Session::get('typeNotify', '') }}";
	</script>
	{[CMS_HEADER]}
</head>
<body>
	{[CMS_BODY]}
	@include('header')
	<div class="linkway">
    	<div class="main">
			@yield('breadcrumb')
		</div>
	</div>
	@include('banner_ads_header')
	<section class="content main clearfix">
		<div class="col-l">
			@yield('main')
		</div>
		@include('base_left_sidebar')
		@include('base_right_sidebar')
	</section>
	@include('footer')
	{[CMS_FOOTER]}
	@include('facebook_base')
	@yield('jsl')
	<script src="theme/frontend/js/toastify.js" defer></script>
	<script src="theme/frontend/js/base.js" defer></script>
	<script src="theme/frontend/js/xhr.js" defer></script>
	@yield('js')
</body>
</html>
