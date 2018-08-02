<?php

class Insert
{
    private $table;
    private $params;
    private $value;

    public function __construct($table, $params)
    {
        $this->table($table);
        $this->params($params);
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function params($params)
    {
        $this->params = $params;
        return $this;
    }

    public function addExpression($column)
    {
        $this->value[] .= ":{$column}";

    }

    public function build()
    {

        $columns = array_values($this->params);
        foreach ($columns as $column) {
            $this->addExpression($column);
        }
        $value = array_values($this->value);
        $columns = join(", ", $columns);
        $value = join(", ", $value);
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$value})";

        return $query;
    }
}
