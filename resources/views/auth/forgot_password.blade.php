@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Quên mật khẩu','quen-mat-khau')}}
@endsection
@section('main')
<div class="box">
    <h2 class="title-bor bold">Lấy mật khẩu</h2>
    <div class="social-title pad10">Vui lòng điền địa chỉ email mà bạn đã đăng ký. Link hướng dẫn lấy mật khẩu sẽ được gửi tới địa chỉ email này.</div>
    <div class="row pad10">
        <div class="col-lg-5">
            <form id="request-password-reset-form" absolute class="clearfix form-horizontal form-validate" action="quen-mat-khau" method="post" data-success="AUTH_GUI.sendEmailForgotPasswordDone" accept-charset="utf8">
                @csrf
                <div class="form-group field-passwordresetrequestform-email required">
                    <label class="control-label" for="passwordresetrequestform-email">Email</label>
                    <input type="text" id="passwordresetrequestform-email" class="form-control" name="email" rules="required||email">
                    <p class="help-block help-block-error"></p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Gửi</button>  
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('jsl')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
@endsection
@section('js')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/auth.js') }}"></script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/ValidateForm.js') }}"></script>
@endsection