<?php

class GroupBy
{
    private $query;


    public function __construct()
    {
        $this->query  = array();
    }


    public function setGroups($groups)
    {
        if(is_null($groups)) return;
        $this->query = $groups;
    }


    public function build()
    {
        if(empty($this->query)) return "";
        return " GROUP BY " . join(", ", $this->query);
    }
}
