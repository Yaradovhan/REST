<?php

class Arecord extends Mysql
{

    private $data;
    protected $tableFields;

    /**
     * Arecord constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->getFieldsFromTable();
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $key
     */
    public function __get($key)
    {
        $this->data[$key];
    }

    /**
     * @param $key
     * @param $value
     * @throws Exception
     */
    public function __set($key, $value)
    {
        if (in_array($key, $this->tableFields)) {
            $this->data[$key] = $value;
        } else {
            throw new \Exception("There are no such fields in the table: " . $this->tableName(), 1);
        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getAll()
    {
        $res = $this->prepareExecute(Query::select($this->tableName(), ['*'])->build());
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function findById($id)
    {
        if (is_int($id)) {
            $res = $this->prepareExecute((Query::select($this->tableName(), ['*'])->where([$this->tableFields[0]])->limit()->build()), [$this->tableFields[0] => $id, 'limit' => 1]);
            return $res->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Your id is not integer ", 1);
        }
    }

    /**
     * @throws Exception
     */
    public function deleteAll()
    {
        $this->prepareExecute((Query::delete($this->tableName())->build()));
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function deleteById($id)
    {
        if (is_int($id) || 0) {
            if ($this->ifIssetIdInTable($id)) {
                $this->prepareExecute((Query::delete($this->tableName())->where([$this->tableFields[0]])->build()), [$this->tableFields[0] => $id]);
            } else {
                throw new \Exception("Your id is not found in the table", 1);
            }
        } else {
            throw new \Exception("Your id is not integer ", 1);
        }
    }

    /**
     * @throws Exception
     */
    public function save()
    {
        $tmp = $this->data[$this->tableFields[0]];
        if (is_int($tmp)) {
            if ($this->ifIssetIdInTable($tmp)) {
                $whereArr = array_slice($this->tableFields, 1);
                $this->prepareExecute((Query::update($this->tableName(), $whereArr)->where([$this->tableFields[0]])->build()), $this->data);
            } else {
                $this->prepareExecute(Query::insert($this->tableName(), $this->tableFields)->build(), $this->data);
            }
        } else {
            throw new \Exception("Your id is not integer ", 1);
        }
    }

    /**
     * @return array
     */
    public function getFieldsFromTable()
    {
        $results = $this->con->query('SHOW COLUMNS FROM ' . $this->tableName());
        foreach ($results as $result) {
            $this->tableFields[] = $result['Field'];
        }
        return $this->tableFields;
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function ifIssetIdInTable($id)
    {
        $query = $this->prepareExecute((Query::select($this->tableName(), [$this->tableFields[0]])->where([$this->tableFields[0]])->limit()->build()), [$this->tableFields[0] => $id, 'limit' => 1]);
        $resArr = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($resArr != null) {
            return true;
        } else {
            return false;
        }
    }

}
