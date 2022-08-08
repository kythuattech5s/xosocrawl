<?php

namespace Lotto\Dtos;

use Lotto\Enums\CrawlStatus;

class ResultObject
{
    protected $datas;
    protected $description;
    protected $note;
    protected $status = CrawlStatus::WAIT;


    public function __construct($datas = [], $description = '')
    {
        $this->datas = $datas;
        $this->description = $description;
    }

    /**
     * Get the value of datas
     *
     * @return  mixed
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * Set the value of datas
     *
     * @param   mixed  $datas  
     *
     * @return  self
     */
    public function setDatas($datas)
    {
        $this->datas = $datas;
        return $this;
    }

    /**
     * Get the value of description
     *
     * @return  mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param   mixed  $description  
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the value of status
     *
     * @return  mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param   mixed  $status  
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get the value of note
     *
     * @return  mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @param   mixed  $note  
     *
     * @return  self
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }
}
