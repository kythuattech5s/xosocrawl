<!DOCTYPE html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="vi">

<head>
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{!! SEOHelper::HEADER_SEO(@$currentItem ? $currentItem : null) !!}
	@yield('cssl')
	<link rel="stylesheet" href="theme/frontend/css/reset.css">
	<link rel="stylesheet" href="theme/frontend/css/style.css">
	@yield('css')
	<script type="text/javascript">
        var showNotify = "";
        var messageNotify = "{{ Session::get('messageNotify', '') }}";
        var typeNotify = "{{ Session::get('typeNotify', '') }}";
	</script>
	<link rel="stylesheet" href="theme/frontend/css/datepicker.min.css">
	{[CMS_HEADER]}
</head>

<body>
	{[CMS_BODY]}
	@include('header')
	<section class="content main clearfix">
		<div class="col-l">
			@yield('main')
		</div>
		@include('base_left_sidebar')
		@include('base_right_sidebar')
	</section>
	@include('footer')
	{[CMS_FOOTER]}
	@yield('jsl')
	<script>
		function showmnc2(id_mnu2) {
			if (document.getElementById(id_mnu2).style.visibility == 'visible') {
				document.getElementById(id_mnu2).style.visibility = 'hidden';
			} else {
				document.getElementById(id_mnu2).style.visibility = 'visible';
			}
		}
		function showDrawerMenu() {
			document.querySelector('html').classList.toggle('menu-active');
			showmnc2("nav-horizontal");
		}
		expand = function(itemId) {
			Array.from(document.getElementsByClassName('menu-c2')).forEach((e, i) => {
				if (e.id != itemId) e.style.display = 'none'
			});
			elm = document.getElementById(itemId);
			elm.style.display = elm.style.display == 'block' ? 'none' : 'block'
		}
	</script>
	<script src="theme/frontend/js/datepicker.min.js" defer></script>
	<script src="theme/frontend/js/vi.js" defer></script>
	<script src="theme/frontend/js/main.js" defer></script>
	@yield('js')
</body>
</html>
