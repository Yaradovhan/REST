<?php

include '../Rest.php';

class Cars extends Rest
{
    public function tableName()
    {
        $tableName = get_class($this);
        if (($pos = strrpos($tableName, '\\')) !== false)
            return substr($tableName, $pos + 1);
        return mb_strtolower($tableName);
    }

    public function getCars()
    {
        dd($this->getAll());

    }

    public function postCars()
    {
        echo "Post cars";
        echo "enjoy";

    }

    public function putCars()
    {

    }

    public function deleteCars()
    {

    }

}

$obj = new Cars();
$obj->start();
