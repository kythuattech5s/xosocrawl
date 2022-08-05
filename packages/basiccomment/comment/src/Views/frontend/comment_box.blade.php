@php
    use \basiccomment\comment\Helpers\CommentHelper;
    use \basiccomment\comment\Models\CommentReportType;
@endphp
<div class="modal fade" id="modal-report-commnet" style="z-index: 2000" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-1">
            <div class="modal-body p-1 pt-0">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <p class="my-0" style="font-size: 20px;">⚑ Báo cáo bình luận</p>
                    <div class="close-icon smooth cursor-pointer fs-20 hv-main" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <form action="basiccomment/send-comment-report" class="p-1" method="post" accept-charset="utf8">
                    <div class="mb-3">
                        <p class="robob my-1">Loại vi phạm</p>
                        <input type="hidden" name="comment">
                        <select name="type" class="module-select2">
                            <option value="">Chọn loại vi phạm</option>
                            @foreach (CommentReportType::get() as $item)
                                <option value="{{Support::show($item,'id')}}">{{Support::show($item,'name')}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <p class="robob my-1">Ghi chú thêm (nếu có)</p>
                        <textarea name="content" rows="3" class="p-2 w-100" placeholder="Nhập nội dung"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary py-1" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary text-white py-1 ms-2">Gửi <i class="fa-solid fa-paper-plane ms-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="simple-comment-box" idx="{{CommentHelper::generateHash($commentBoxId)}}" identifier="{{CommentHelper::generateHash($identifier)}}" referrer="{{$referrer}}">
    @include('basiccmt::frontend.simple_form_comment',['target'=>0,'placeholder'=>'Nhận xét...'])
    <div class="comment-fillter-box">
        <span>Sắp xếp: </span>
        <select class="comment-fillter-sort">
            <option value="1">Mới nhất</option>
            <option value="2">Cũ nhất</option>
            <option value="3">Nhiều lượt like nhất</option>
        </select>
    </div>
    <div class="list-comment" cmt-target="0"></div>
</div>
