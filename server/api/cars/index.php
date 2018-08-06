<?php

require_once '../Rest.php';
require_once '../Responce.php';


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
        if ($param == null) {
            $data = $this->getAll();
        } else {
            $data = $this->findById(intval($param));
        }
        if (!empty($data)) {
            $resData = $this->converter($data);
        } else {
            echo "Error in getCars with param";
            die();
        }

        echo $this->responce->serverSuccess(200, $resData);
    }

}

$obj = new Cars();
$obj->start();
