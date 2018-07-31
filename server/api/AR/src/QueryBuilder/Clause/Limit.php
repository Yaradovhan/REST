<?php

class Limit
{
    private $limit;

    public function __construct()
    {
        $this->limit = null;
    }

    public function setLimit()
    {
        $this->limit = $limit;
    }

    public function build()
    {
        if(is_null($this->limit)) return array("", array());
        return " LIMIT :limit";
    }
}
