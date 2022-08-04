@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Đăng nhập','dang-nhap')}}
@endsection
@section('main')
<div class="box box-customer">
    <h2 class="tit-mien">
        <strong>Đăng nhập</strong>
    </h2>
    <div class=" txt-center pad10">
        <button type="button" class="login-button login-gg magb10" id="google-btn-signin" onclick="loginWithGoogle(this)">
            <span class="solid">
                <img src="theme/frontend/images/login_g_icon.svg" alt="google">
            </span>
            <span class="text">Đăng nhập qua Google</span>
        </button>
    </div>
    <div class="social-title pad10 ">Hoặc:</div>
    <form id="login-form" class="form-horizontal form-validate" action="dang-nhap" method="post" accept-charset="utf8" absolute accept-charset="utf8" data-success="AUTH_GUI.registerDone">
        @csrf
        <div class="form-group field-loginform-email">
            <label class="control-label" for="loginform-email">Địa chỉ email</label>
            <input type="text" class="form-control" name="email" placeholder="Địa chỉ email" rules="required||email">
            <div class="help-block"></div>
        </div>
        <div class="form-group field-loginform-password">
            <label class="control-label" for="loginform-password">Mật khẩu</label>
            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" rules="required||minLength:8">
            <div class="help-block"></div>
        </div>
        <div class="form-group field-loginform-rememberme">
            <label>
                <input type="checkbox" name="remember" value="1" checked> Ghi nhớ
            </label>
            <div class="help-block"></div>
        </div>
        <div class="txt-center">
            <button class="btn btn-danger" type="submit">Đăng nhập</button>
            <a class="btn password-reset-link underline" href="lay-lai-mat-khau" title="Quên mật khẩu">Quên mật khẩu</a>
        </div>
    </form>
    <div class="pad10"></div>
    <div class="social-title pad10">* Không đăng nhập được qua Google hoặc không có mật khẩu đăng nhập, bấm <a class="clnote bold underline" href="lay-lai-mat-khau" title="Lấy lại mật khẩu">vào đây</a></div>
</div>
@endsection
@section('jsl')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
@endsection
@section('js')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/auth.js') }}"></script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/ValidateForm.js') }}"></script>
@endsection