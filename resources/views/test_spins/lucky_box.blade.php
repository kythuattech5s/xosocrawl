<div class="box mayman" id="bmayman">
    <h3 class="tit-mien bold">Hôm nay vận may có mỉm cười với bạn?</h3>
    <p class="txt-center clplum bold" style="margin: 1rem 0;">Xin mời nhập ngày tháng năm sinh</p>
    <div class=" form-group mayman-form txt-center">
        <select id="mySelect_ngay" name="ngay">
            <option value="">Chọn ngày</option>
            @for ($i = 1; $i <= 31; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
        <select id="mySelect_thang" name="thang">
            <option value="">Chọn tháng</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
        <select id="mySelect" name="nam">
            <option value="">Chọn năm</option>
            @for ($i = 1950; $i <= now()->year; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
    </div>
    <div class="txt-center form-group">
        <button class="submitmm btn btn-danger">Xem ngay</button>
        <button class="xemlai btn btn-secondary" style="display: none;">Xem lại</button>
    </div>
    <div id="ketqua" class="ketqua pad10-5 clplum" style="display: none;">
        <p>Hôm nay ngày <span id="show_ngay"></span> tương quan giữa thiên can, địa chi, ngũ hành, quái số máy tính xin đề xuất số đẹp dựa trên:</p>
        <p>- Cung hoàng đạo của bạn: <span id="cung_hd"></span></p>
        <p>- Sao chiếu mệnh: <span id="sao"></span></p>
        <p>- Màu sắc hợp mạng: <span id="mau_sac"></span></p>
        <p class="kqmm uppercase bold txt-center">Số đại cát nên đánh hôm nay là</p>
        <div class="somm bg-orange pad10-5 bold">
            <p>BTL: <span class="showkq1 s24"></span></p>
            <p>STL: <span class="showkq2 s24"></span> - <span class="showkq22 s24"></span></p>
            <p style="margin-bottom: 0px;">ĐB: <span class="showkq3 s24"></span> - Lót: <span class="showkq32 s24"></span></p>
        </div>
    </div>
</div>