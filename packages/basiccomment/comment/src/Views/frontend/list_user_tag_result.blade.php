@if (count($listUser) > 0)
    @foreach ($listUser as $itemUser)
        <div class="item-user-popup" idx="{{$itemUser->id}}" fullname="{{$itemUser->fullname}}">
            <div class="user-image">
                <div class="c-img">
                    @if ($itemUser->img != '')
                        <img src="{{$itemUser->getAvatarImageSrc()}}" alt="Default User Avartar">
                    @else
                        <img src="theme/frontend/images/default_avatar.gif" alt="Default User Avartar">
                    @endif
                </div>
            </div>
            <div class="item-user-name">{{$itemUser->fullname}}</div>
        </div>
    @endforeach
@else
    <p style="text-align:center;padding: 8px">Không tìm thấy người dùng nào.</p>
@endif