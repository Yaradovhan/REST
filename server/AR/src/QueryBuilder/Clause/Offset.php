<?php

class Offset
{
    private $offset;

    public function __construct()
    {
        $this->offset = null;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public function build()
    {
        if(is_null($this->offset)) return array("", array());
        return array(
            " OFFSET ?",
            array($this->offset)
        );
    }
}
