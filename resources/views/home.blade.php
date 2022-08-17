@extends('index')
@section('main')
    @include('partials.link_du_doan')
    <div class="box">
        <div class="bg_gray">
            <div class=" opt_date_full clearfix">
                <a class="ic-pre fl" href="https://xoso.me/kqxs-19-7-2022-ket-qua-xo-so-ngay-19-7-2022.html"
                    title="Kết quả xổ số ngày 19/07/2022">
                </a>
                <label>
                    <strong> Thứ tư </strong> - <input class="nobor hasDatepicker" id="searchDate" type="text"
                        value="20/07/2022" />
                    <span class="ic ic-calendar">
                    </span>
                </label>
                <a class="ic-next" href="https://xoso.me/kqxs-21-7-2022-ket-qua-xo-so-ngay-21-7-2022.html"
                    title="Kết quả xổ số ngày 21/07/2022">
                </a>
            </div>
        </div>
    </div>
    <div class="box-kq">
        <div class="box mo-thuong-ngay">
            <div class="tit-mien s16">
                <strong> Các tỉnh mở thưởng hôm nay </strong>
            </div>
            <table class="table-fixed">
                <tr>
                    <td>
                        <table>
                            <?php $mns = \Lotto\Models\LottoCategory::find(3)->lottoTodayItems();
                            $count = count($mns); ?>
                            @foreach ($mns as $item)
                                <tr>
                                    <td>
                                        <a href="{{ $item->slug }}" title="Xổ Số {{ $item->name }}"> {{ $item->name }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table>
                            <?php $mts = \Lotto\Models\LottoCategory::find(4)->lottoTodayItems(); ?>
                            @foreach ($mts as $item)
                                <tr>
                                    <td>
                                        <a href="{{ $item->slug }}" title="Xổ Số {{ $item->name }}"> {{ $item->name }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @for ($i = 0; $i < $count - count($mts); $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <?php $mb = \Lotto\Models\LottoCategory::find(1); ?>
                                <td>
                                    <a href="{{ $mb->slug }}" title="{{ $mb->name }}"> Miền Bắc </a>
                                </td>
                            </tr>
                            <?php $dts = \Lotto\Models\LottoCategory::find(2)->lottoTodayItems(); ?>
                            @foreach ($dts as $item)
                                <tr>
                                    <td>
                                        <a href="{{ $item->slug }}" title="Xổ Số {{ $item->name }}">
                                            {{ $item->name }} </a>
                                    </td>
                                </tr>
                            @endforeach
                            @for ($i = 0; $i < $count - count($dts) - 1; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        @include('home/mien_bac', [
            'lottoCategory' => $lottoCategoryMb,
            'lottoItem' => $lottoItemMb,
            'lottoRecord' => $lottoRecordMb,
        ])
        @include('home/mien_nam', [
            'lottoCategory' => $lottoCategoryMn,
            'lottoItem' => $lottoItemMn,
            'lottoRecord' => $lottoRecordMn,
            'lottoItemMnCollection' => $lottoItemMnCollectionMn,
        ])
        @include('home/mien_trung', [
            'lottoCategory' => $lottoCategoryMt,
            'lottoItem' => $lottoItemMt,
            'lottoRecord' => $lottoRecordMt,
            'lottoItemMnCollection' => $lottoItemMnCollectionMt,
        ])
        {!!App\Models\StaticalCrawl::getBoxVietlottContentHome()!!}
        <div class="box box-html">
            {[home_content]}
        </div>
    </div>
@endsection