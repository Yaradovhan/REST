<?php

class Update
{
    private $table;
    private $params;
    private $where;

    public function __construct($table, $params)
    {
        $this->table($table);
        $this->params($params);
        $this->where = new Condition("WHERE");
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

    public function where($conditions)
    {
        $this->where->setConditions($conditions);
        return $this;
    }

    public function build()
    {
        $columns = array_values($this->params);

        $sets = [];
        foreach($columns as $column){
            $sets[] = "{$column} = :{$column}";
        }
        $sets = join(", ", $sets);

        $query = "UPDATE {$this->table} SET {$sets}";

        list($whereQuery) = $this->where->build();
        return $query . $whereQuery ;
    }
}
