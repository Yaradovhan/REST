<?php

class Condition
{
    private $phrase;
    private $query;

    public function __construct($phrase)
    {
        $this->phrase = $phrase;
        $this->query = [];
    }

    public function setOnConditions($conditions)
    {
        $this->query[] .= "{$conditions[0]}";
    }

    public function setConditions($conditions)
    {
        foreach ($conditions as $column) {
            $this->addExpression($column);
        }
    }


    public function addExpression($column)
    {
        $this->query[] .= "{$column} = :{$column}";
    }


    public function build()
    {
        if (empty($this->query)) return ["", []];
        return [" {$this->phrase} " . join(" AND ", $this->query)];
    }
}
