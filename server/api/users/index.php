<?php

include '../Rest.php';

class Users extends Rest
{

    public function tableName()
    {
        $tableName = get_class($this);
        if (($pos = strrpos($tableName, '\\')) !== false)
            return substr($tableName, $pos + 1);
        return mb_strtolower($tableName);
    }

    public function getUsers($param)
    {
        if ($param == null) {
            $data = $this->getAll();
        } else {
            $data = $this->findById(intval($param));
        }
        $this->converter($data);
    }

    public function postUsers()
    {
        dd($_POST);



        if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['name'])) {
            echo "ошибка в postUsers()->login";
            die();
        }
        if (strlen($_POST['name']) < 3 || strlen($_POST['name']) > 30) {
            echo "имя должно содержать от 3 до 30 символов";
            die();

        }

//        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $insUser = Query::insert('users', ['name', 'password'   , 'email'])->build();
        $insUserData = [
            'name' => $_POST['name'],
            'password' => $_POST['password'],
            'email' => $_POST['email']
        ];
        $this->prepareExecute($insUser, $insUserData);

    }

    function generateHash($length=6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length)
        {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

}

$user = new Users;
$user->start();
// dd($user->tableName());
