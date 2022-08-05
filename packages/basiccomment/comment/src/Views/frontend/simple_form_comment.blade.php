@php
    $user = \Auth::user();
@endphp
@if (\Auth::check())
    <div class="simple-form-comment" target="{{$target}}">
        <div class="avartar">
            <div class="c-img">
                <img src="{{$user->getAvatarImageSrc()}}" alt="Default User Avartar">
            </div>
        </div>
        <div class="edit-content-comment">
            <textarea class="comment-content" placeholder="{{$placeholder}}"></textarea>
        </div>
        <div class="send-comment">
            <button class="btn-send-comment" type="button">Gửi</button>
        </div>
    </div>
@else
    <p style="padding: 3px 3px 3px 15px;margin: 0;">Vui lòng <a href="dang-nhap" class="item_sublink" title="Đăng nhập">đăng nhập</a> để tham gia commment.</p>
@endif