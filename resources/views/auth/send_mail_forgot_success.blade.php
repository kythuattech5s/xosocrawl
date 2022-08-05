@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Đăng ký thành công','dang-ky-thanh-cong')}}
@endsection
@section('main')
<div class="announcement">
    <div class="announcement-body">
        <div class="announcement-title"><span>Thông báo</span></div>
        <div class="description">Hệ thống đã gửi hướng dẫn lấy mật khẩu vào địa chỉ email mà bạn đăng ký. Vui lòng kiểm tra email và làm theo hướng dẫn để đăng nhập.</div>
        <div class="links">
            <a class="btn btn-link" href="/" title="Trang chủ">Trang chủ</a>
            <a class="btn btn-link" href="dien-dan-xo-so" title="Diễn đàn">Diễn đàn</a>
        </div>
    </div>
</div>
@endsection