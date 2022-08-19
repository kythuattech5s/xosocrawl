<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use crawlmodule\basecrawler\Crawlers\BaseCrawler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Dtos\HeadTail;
use Lotto\Dtos\LottoItemMnCollection;
use Lotto\Enums\CrawlStatus;
use Lotto\Enums\DayOfWeek;
use Session;

class LottoRecord extends BaseModel
{
    use HasFactory;

    public static function getCurrentRecord($lottoItem)
    {
        return static::getRecordByDate($lottoItem, now());
    }
    public static function getRecordByDate($lottoItem, $date)
    {
        $code = $date->format('Ynj');
        $fullcode = $date->format('Ymd');
        $record = static::where('fullcode', $fullcode)->where('lotto_item_id', $lottoItem->id)->first();
        if (!$record) {
            $now = now();
            $lottoTime = $lottoItem->lottoTimeByDate($date)->first();
            if (!$lottoTime) return null;
            $record = new static;
            $record->code = $code;
            $record->fullcode = $fullcode;
            $record->created_at = $date;
            $record->updated_at = $now;
            $record->lotto_item_id = $lottoItem->id;
            $record->lotto_category_id = $lottoItem->lotto_category_id;
            $record->lotto_time_id = $lottoTime->id;
            $record->status = CrawlStatus::WAIT;
            $record->save();
        }
        return $record;
    }
    public function insertResults($results, $date)
    {
        foreach ($results as $key => $rows) {
            foreach ($rows as $td) {
                $item = new LottoResultDetail();
                $item->lotto_record_id = $this->id;
                $item->lotto_item_id = $this->lotto_item_id;
                $item->lotto_category_id = $this->lotto_category_id;
                $item->created_at = $date;
                $item->updated_at = $date;
                $item->no_prize = $key;
                $item->number = $td;
                $item->save();
            }
        }
    }

    public function dayOfWeek()
    {
        return DayOfWeek::fromDate($this->created_at);
    }
    public function currentDayOfWeek()
    {
        $d = DayOfWeek::fromDate($this->created_at);
        return $d->getValue();
    }

    public function lottoResultDetails()
    {
        return $this->hasMany(LottoResultDetail::class);
    }
    public function lottoItem()
    {
        return $this->belongsTo(LottoItem::class);
    }
    public function prev($checkLottoItem = true, $dow = false, $limit = 1)
    {
        $q = static::select("lotto_records.*");
        if ($dow) {
            $d = DayOfWeek::fromDate($this->created_at);
            $dowMysql = $d->toDayOfWeekMysql();
            $q->whereRaw('DAYOFWEEK(lotto_records.created_at) = ' . $dowMysql);
        }
        $createdAt = $this->created_at;
        $createdAt->hour = 0;
        $createdAt->minute = 0;
        $createdAt->second = 0;
        $q->where('lotto_records.created_at', '<', $createdAt)->where('lotto_records.lotto_category_id', $this->lotto_category_id);
        if ($checkLottoItem) {
            $q->where('lotto_records.lotto_item_id', $this->lotto_item_id);
        }
        $q->orderBy('lotto_records.created_at', 'desc');
        if ($limit == 1) {
            return $q->limit(1)->first();
        } else {
            return $q->limit($limit)->get();
        }
    }
    public function next($checkLottoItem = true)
    {
        $createdAt = $this->created_at;
        $createdAt->hour = 23;
        $createdAt->minute = 59;
        $createdAt->second = 59;
        $q = static::where('created_at', '>', $createdAt)->where('lotto_category_id', $this->lotto_category_id);
        if ($checkLottoItem) {
            $q = $q->where('lotto_item_id', $this->lotto_item_id);
        }
        return $q->orderBy('created_at', 'asc')->limit(1)->first();
    }
    public function link($prefix = null)
    {
        $paramPrints = [];
        if (isset($prefix) && $prefix != '') {
            $paramPrints[] = $prefix;
        }
        $lottoTime = $this->lottoItem->lottoTime;
        $slugDate = $this->lottoItem->slug_date;
        $count = substr_count($slugDate, "%s");
        $params = array_fill(0, $count, $lottoTime->formatByType($this->created_at));
        $link = vsprintf($slugDate, $params);
        $paramPrints[] = $link;
        return implode('/', $paramPrints);
    }
    public function linkWithFormat($format)
    {
        $f = $format['format'];
        $slug = $format['slug'];
        if ($f == 'thu-dow') {
            $d = DayOfWeek::fromDate($this->created_at);
            $slug = vsprintf($slug, [$d->slug()]);
        } else {
            $slug = vsprintf($slug, [$this->created_at->format($f)]);
        }
        return $slug;
    }
    public function lottoTimes()
    {
        return $this->belongsTo(LottoTime::class, 'lotto_time_id');
    }
    public function headTail()
    {
        return new HeadTail($this->lottoResultDetails);
    }
    public function toLottoItemMnCollection()
    {
        $lottoRecords = static::where('lotto_category_id', $this->lotto_category_id)->where('fullcode', $this->fullcode)->orderBy('created_at', 'desc')->get();
        return LottoItemMnCollection::createFromLottoRecords($lottoRecords);
    }
    public function parseLogan()
    {
        $logan = LottoLogan::where('lotto_record_id', $this->id)->first();
        if ($logan) {
            return $logan->content;
        }
        $crawler = new BaseCrawler();
        $url = 'https://xoso.me/' . $this->lottoItem->prefix_sub_link . '/' . request()->segment(2) . '.html';
        $content = $crawler->exeCurl($url);
        $dom = str_get_html($content);
        $box = $dom->find('.col-l > .box', 2);
        $boxHtml = $crawler->convertContent($box);
        $logan = new LottoLogan;
        $logan->content = $boxHtml;
        $logan->lotto_record_id = $this->id;
        $logan->lotto_category_id = $this->lotto_category_id;
        $logan->created_at = $logan->updated_at = now();
        $logan->save();
        return $boxHtml;
    }
    public static function getLotteDataMbFormat()
    {
        $ret = [
            1 => 1,
            2 => 2,
            3 => 6,
            4 => 4,
            5 => 6,
            6 => 3,
            7 => 4,
            'DB' => 1
        ];
        return $ret;
    }
    public static function getLotteDataMnFormat()
    {
        $ret = [
            8 => 1,
            7 => 1,
            6 => 3,
            5 => 1,
            4 => 7,
            3 => 2,
            2 => 1,
            1 => 1,
            'DB' => 1
        ];
        return $ret;
    }
    public function buildLottoDirectData()
    {

        $listItemDetail = $this->lottoResultDetails()->orderBy('no_prize', 'desc')->get()->groupBy('no_prize');
        $dataFormatConfig = $this->lotto_category_id == 1 ? self::getLotteDataMbFormat() : self::getLotteDataMnFormat();
        $ret = [];
        $addDot = false;
        foreach ($dataFormatConfig as $no => $item) {
            if ($no == 'DB' && $this->lotto_category_id == 1) {
                $ret['MaDb'] = explode(',', $this->description);
            }
            $ret[$no] = [];
            $noPrize = $no == 'DB' ? 0 : $no;
            $countItemEmpty = $item;
            if (isset($listItemDetail[$noPrize])) {
                foreach ($listItemDetail[$noPrize] as $itemDetail) {
                    array_push($ret[$no], $itemDetail->number);
                }
                $countItemEmpty = $item - count($listItemDetail[$noPrize]);
            }
            if ($countItemEmpty > 0) {
                for ($i = 0; $i < $countItemEmpty; $i++) {
                    if (!$addDot) {
                        array_push($ret[$no], '.');
                        $addDot = true;
                    } else {
                        array_push($ret[$no], '');
                    }
                }
            }
        }
        return $ret;
    }
}
