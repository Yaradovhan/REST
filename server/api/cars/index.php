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

    public function getCars($param)
    {
      if($param == null){
        $data = $this->getAll();
      } else {
        $data = $this->findById(intval($param));
      }
      $this->converter($data);
    }

    // public function postCars($param)
    // {
    //     echo "Post cars";
    //     echo "enjoy";
    //
    // }
    //
    // public function putCars()
    // {
    //     echo "PUT";
    // }
    //
    // public function deleteCars()
    // {
    //
    // }

}

$obj = new Cars();
$obj->start();
