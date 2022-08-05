@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Đặt lại mật khẩu','lay-lai-mat-khau')}}
@endsection
@section('main')
<div class="box">
    <h2 class="title-bor bold">Đặt lại mật khẩu</h2>
    <div class="social-title pad10">Mời bạn đặt lại mật khẩu</div>
    <div class="row pad10">
        <div class="col-lg-5">
            <form id="request-password-reset-form" absolute class="clearfix form-horizontal form-validate" action="lay-lai-mat-khau" method="post" data-success="AUTH_GUI.resetPasswordDone" accept-charset="utf8">
                @csrf
                <input type="hidden" name="email" value="{{ request()->input('email') }}">
                <input type="hidden" name="token" value="{{ request()->input('token') }}">
                <div class="form-group field-password">
                    <label class="control-label" for="password">Mật khẩu</label>
                    <input type="password" id="password" class="form-control" name="password" rules="required||minLength:8">
                </div>
                <div class="form-group field-password_confirmation">
                    <label class="control-label" for="password_confirmation">Xác nhận lại mật khẩu</label>
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" ules="required||same:password||minLength:8">
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