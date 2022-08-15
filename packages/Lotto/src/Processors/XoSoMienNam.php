<?php

namespace Lotto\Processors;

use Lotto\Dtos\ResultObject;
use Lotto\Enums\CrawlStatus;

class XoSoMienNam extends AbstractXoSo
{
    protected function parsePrizes($dom): ResultObject
    {
        $result = new ResultObject();
        $tables = $dom->find('.kqmb.extendable.kqtinh');
        $datas = [];
        if (count($tables) == 0) return $result;
        $table = $tables[0];
        $trs = $table->find('tr');

        for ($i = 0; $i < count($trs); $i++) {
            $tr = $trs[$i];
            $datas[count($trs) - $i - 1] = $this->parseSinglePrize($tr);
        }
        $result->setDatas($datas);
        if (count($datas) > 0) {
            $result->setStatus(CrawlStatus::SUCCESS);
        } else {
            $result->setStatus(CrawlStatus::FAIL);
            $result->setNote($dom->outertext);
        }
        return $result;
    }
    protected function parseSinglePrize($tr)
    {
        $prizes = [];
        $spans = $tr->find('span');
        for ($i = 0; $i < count($spans); $i++) {
            $prizes[] = $spans[$i]->plaintext;
        }
        return $prizes;
    }
}
