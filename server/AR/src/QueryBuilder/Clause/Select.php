<?php

class Select
{
    private $table;
    private $columns;
    private $distinct;
    private $joins;
    private $where;
    private $order;
    private $group;
    private $limit;
    private $offset;


    public function __construct($table, $columns)
    {
        $this->table($table);
        $this->columns($columns);
        $this->joins  = [];
        $this->where  = new Condition('WHERE');
        $this->order  = new OrderBy();
        $this->group  = new GroupBy();
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function columns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function where($conditions)
    {
        $this->where->setConditions($conditions);
        return $this;
    }

    public function distinct()
    {
        $this->distinct = 'DISTINCT ';
        return $this;
    }

    public function leftJoin($table, $conditions = null)
    {
        $join = new Join();
        $join->leftJoin($table, $conditions);
        $this->joins[] = $join;
        return $this;
    }

    public function rightJoin($table, $conditions = null)
    {
        $join = new Join();
        $join->rightJoin($table, $conditions);
        $this->joins[] = $join;
        return $this;
    }

    public function innerJoin($table, $conditions = null)
    {
        $join = new Join();
        $join->innerJoin($table, $conditions);
        $this->joins[] = $join;
        return $this;
    }

    public function crossJoin($table)
    {
        $join = new Join();
        $join->crossJoin($table);
        $this->joins[] = $join;
        return $this;
    }

    public function naturalJoin($table)
    {
        $join = new Join();
        $join->naturalJoin($table);
        $this->joins[] = $join;
        return $this;
    }

    public function orderBy($orders)
    {
        $this->order->setOrders($orders);
        return $this;
    }

    public function groupBy($groups)
    {
        $this->group->setGroups($groups);
        return $this;
    }

    public function limit()
    {
      $this->limit = ' LIMIT :limit';
      return $this;
    }

    public function offset()
    {
      $this->offset = ' OFFSET :offset ';
      return $this;
    }

    public function build()
    {
        $columns = join(", ", $this->columns);
        $query = "SELECT {$this->distinct}{$columns} FROM {$this->table}";

        foreach($this->joins as $join){
            list($joinQuery) = $join->build();
            $query .= $joinQuery;
        }

        list($whereQuery) = $this->where->build();

        $group = $this->group->build();
        $order = $this->order->build();

        $limit  = $this->limit;
        $offset = $this->offset;

        return $query . $whereQuery . $group . $order . $limit . $offset;
    }
}
