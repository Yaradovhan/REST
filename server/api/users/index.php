<?php

include '../Rest.php';
include '../Responce.php';


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
        if (!empty($data)) {
            $resData = $this->converter($data);
        } else {
            echo "Error in getUsers with param";
            die();
        }

        echo $this->responce->serverSuccess(200, $resData);
    }

    public function postUsers($data)
    {

        if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['name'])) {
            echo "ошибка в postUsers()->login";
            die();
        }
        if (strlen($_POST['name']) < 3 || strlen($_POST['name']) > 30) {
            echo "имя должно содержать от 3 до 30 символов";
            die();
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "Не вырный email";
            die();
        }

        $selUser = Query::select('users', ['id'])->where(['name'])->build();
        $selUserData = ['name' => $_POST['name']];
        $res = $this->prepareExecute($selUser, $selUserData)->fetch(PDO::FETCH_ASSOC);

        if (empty($res)) {
            $insUser = Query::insert('users', ['name', 'password', 'email', 'hash'])->build();
            $insUserData = [
                'name' => $_POST['name'],
                'password' => $_POST['password'],
                'email' => $_POST['email'],
                'hash' => $this->generateHash()
            ];
            $this->prepareExecute($insUser, $insUserData);
        } else {
            echo "Юзер с таким именем зарегестрирован";
        }

    }

    function generateHash($length = 20)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }

    public function checkUsers($param)
    {
        //метод нужно проверить
        if ($param) {
            $id = $this->dbh->quote(($param['id']));
            $selHash = Query::select('users', ['hash'])->where(['id'])->build();
            $selHashData = ['id' => $id];
            $result = $this->prepareExecute($selHash, $selHashData);
            if (false === $result) {
                return false;
            }
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data['hash'];
        } else {
            return false;
        }
    }

    public function putUsers($param)
    {
        //тут полная барада. расстрелять
        $password =$param['password'];
        $name = $param['name'];
        $selUser = Query::select('users', ['id'])->where(['name', 'password'])->build();
        $selUserData = [
            'name' => $name,
            'password' => $password
        ];
        $resSel = $this->prepareExecute($selUser, $selUserData)->fetch(PDO::FETCH_ASSOC);
        if (false === $resSel) {
            echo "LoginUser->resSel=false";
            die();
        }

        $hash = md5($this->generateHash(10));
        $updUser = Query::update('users', ['hash'])->where(['id'])->build();
        $updUserData = [
            'hash' => $hash,
            'id' => $resSel['id']
        ];
        $count = $this->prepareExecute($updUser, $updUserData);
        if ($count === false) {
            echo "LoginUser->errorUpdate";
            die();
        }
        $id = trim($resSel['id'], "'");
        $hash = trim($hash, "'");
        $arrRes = ['id' => $id, 'hash' => $hash];
        return json_encode($arrRes);
    }

    public function logoutUser()
    {
        if (isset($_COOKIE['id']) && isset($_COOKIE['hash']))
        {
            setcookie("id", "0", time()-3600*24*30*12, '/');
            setcookie("hash", "0", time()-3600*24*30*12, '/');
            return true;
        }
        return false;
    }

}

$user = new Users;
$user->start();