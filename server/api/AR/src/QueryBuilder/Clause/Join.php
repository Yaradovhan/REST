<?php

class Join
{
    private $type;
    private $table;
    private $on;

    public function __construct()
    {
        $this->on = new Condition("ON");
    }

    public function leftJoin($table, $conditions = null)
    {
        $this->setJoin("LEFT", $table, $conditions);
    }

    public function innerJoin($table, $conditions = null)
    {
        $this->setJoin("INNER", $table, $conditions);
    }

    public function rightJoin($table, $conditions = null)
    {
        $this->setJoin("RIGHT", $table, $conditions);
    }

    public function crossJoin($table)
    {
        $this->setJoin("CROSS", $table);
    }

    public function naturalJoin($table)
    {
        $this->setJoin("NATURAL", $table);
    }

    private function setJoin($type, $table, $conditions = null)
    {
        $this->type = $type;
        $this->table = $table;
        if ($conditions != null) {
            $this->on->setOnConditions($conditions);
        }
    }

    public function build()
    {
        $query = " {$this->type} JOIN {$this->table}";
        list($on) = $this->on->build();
        return [$query . $on];
    }
}
