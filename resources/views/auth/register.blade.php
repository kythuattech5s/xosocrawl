@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Đăng ký','dang-ky')}}
@endsection
@section('main')
<div class="box box-customer">
    <h2 class="tit-mien"><strong>Đăng ký tài khoản</strong></h2>
    <div class="row">
        <form id="update-form" class="clearfix form-horizontal form-validate" absolute action="dang-ky" method="post" enctype="multipart/form-data" accept-charset="utf8" data-success="AUTH_GUI.registerDone">
            @csrf
            <div style="max-width: 150px;margin:auto;padding: 1rem;">
                <div class="txt-center">
                    <div class="avatar">
                        <img alt="" itemprop="image" src="theme/frontend/images/default_avatar.gif"> 
                    </div>
                </div>
            </div>
            <div class="form-group field-customer-image_file">
                <label class="control-label" for="customer-image_file">Ảnh đại diện</label>
                <div class="form-control">
                    <input type="file" id="customer-image_file" name="image_file">
                </div>
            </div>
            <div class="form-group field-customer-fullname">
                <label class="control-label" for="customer-fullname">Họ và tên</label>
                <input type="text" id="customer-fullname" class="form-control" name="fullname" maxlength="255" rules="required">
            </div>
            <div class="form-group field-customer-email">
                <label class="control-label" for="customer-email">Email</label>
                <input type="text" id="customer-email" rules="required||email" class="form-control" name="email" maxlength="255">
            </div>
            <div class="form-group field-customer-password">
                <label class="control-label" for="customer-password">Mật khẩu</label>
                <input type="password" id="customer-password" rules="required" class="form-control" name="password" maxlength="255">
            </div>
            <div class="form-group field-customer-password_confirmation">
                <label class="control-label" for="customer-password_confirmation">Nhập lại mật khẩu</label>
                <input type="password" id="customer-password_confirmation" class="form-control" name="password_confirmation" rules="required||same:password||minLength:8">
            </div>
            <div class="form-group txt-center">
                <button type="submit" class="btn btn-danger">Đăng ký</button>
                <button type="reset" class="btn btn-secondary">Hủy bỏ</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('jsl')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
@endsection
@section('js')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/auth.js') }}"></script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/ValidateForm.js') }}"></script>
    <script>
        fitImagesSize = function (imgs, ratio) {
            for (var i = 0; i < imgs.length; i++) {
                !function (img) {
                    img.onload = function() {
                        if (img.naturalWidth / img.naturalHeight > ratio) {
                            img.style.width = "auto";
                            img.style.height = "100%";
                        } else {
                            img.style.width = "100%";
                            img.style.height = "auto";
                        }
                    };
                }(imgs[i]);
            }
        };
        !function(form) {
            var file_input = form.querySelector("#customer-image_file");
            var file_name = form.querySelector(".custom-file-name");
            file_input.onchange = function() {
                if (file_input.files && file_input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#update-form .avatar img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file_input.files[0]);
                }
            };
        }(document.querySelector("#update-form"));
    </script>
@endsection