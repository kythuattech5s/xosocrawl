@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('user_sub',$user,'Thay đổi thông tin cá nhân','cap-nhat-tai-khoan')}}
@endsection
@section('main')
<div class="box box-customer">
    <h2 class="tit-mien"><strong>Quản lý tài khoản</strong></h2>
    <div class="row">
        <form id="update-form" class="clearfix form-horizontal form-validate" action="cap-nhat-tai-khoan" absolute method="post" enctype="multipart/form-data" accept-charset="utf8" data-success="AUTH_GUI.updateProfileDone">
            @csrf
            <div style="max-width: 200px;margin:auto;padding: 1rem;">
                <div class="txt-center">
                    <div class="avatar">
                        <img alt="{{$user->fullname}}" itemprop="image" src="{{$user->getAvatarImageSrc()}}"> 
                    </div>
                </div>
            </div>
            <div class="form-group field-customer-image_file">
                <label class="control-label" for="customer-image_file">Ảnh đại diện</label>
                <div class="form-control">
                    <input type="file" id="customer-image_file" name="image_file">
                </div>
            </div>
            @if ($user->count_update > 0)
                <div class="form-group field-customer-fullname">
                    <label class="control-label" for="customer-fullname">Họ tên</label>
                    <input type="text" class="form-control" value="{{$user->fullname}}" readonly disabled="disabled">
                </div>
            @else
                <div class="form-group field-customer-fullname">
                    <label class="control-label" for="customer-fullname">Họ tên</label>
                    <input type="text" class="form-control" name="fullname" value="{{$user->fullname}}" maxlength="64">
                </div>
                <div class="clnote">Chỉ đổi tên một lần duy nhất</div>
            @endif
            <div class="form-group field-customer-username">
                <label class="control-label" for="customer-username">Tên đăng nhập</label>
                <input type="text" class="form-control" value="{{$user->email}}" readonly disabled="disabled">
            </div>
            @if ($user->is_social_account)
                <div class="form-group field-customer-info_source">
                    <label>
                        <input type="checkbox" id="customer-info_source" name="info_source" value="1" {{$user->use_image_social == 1 ? 'checked':''}}>
                        <span>Dùng ảnh đại diện của {{$user->social_method}}</span>
                    </label>
                </div>
            @endif
            <div class="form-group txt-center">
                <button type="submit" class="btn btn-danger">Cập nhật</button>
                <button type="reset" class="btn btn-secondary">Hủy bỏ</button>
                <a href="dang-xuat" style="color:#0084b4">Đăng xuất</a> 
            </div>
        </form>
    </div>
</div>
@endsection
@section('jsl')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
@endsection
@section('js')
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
                    $('#customer-info_source').prop('checked',false);
                }
            };
        }(document.querySelector("#update-form"));
    </script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/auth.js') }}"></script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/ValidateForm.js') }}"></script>
@endsection