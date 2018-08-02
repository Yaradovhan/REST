<?php

class OrderBy
{
    private $query;

    public function __construct()
    {
        $this->query  = array();
    }

    public function setOrders($orders)
    {
        if(is_null($orders)) return;
        foreach($orders as $column => $order){
            $this->addOrder($column, $order);
        }
    }

    public function addOrder($column, $order)
    {
        if(is_int($column)){
            $this->query[] = $order;
        }else{
            $this->query[] = "{$column} {$order}";
        }
    }

    public function build()
    {
        if(empty($this->query)) return "";
        return " ORDER BY " . join(", ", $this->query);
    }
}
