<?php

class Query
{

    public static function select($table, $columns)
    {
        return new Select($table, $columns);
    }


    public static function insert($table, $params)
    {
        return new Insert($table, $params);
    }


    public static function update($table, $params)
    {
        return new Update($table, $params);
    }


    public static function delete($table)
    {
        return new Delete($table);
    }
}
