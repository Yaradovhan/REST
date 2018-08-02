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
    if($param == null){
      $data = $this->getAll();
    } else {
      $data = $this->findById(intval($param));
    }
    $this->converter($data);
  }

  public function postUsers()
        {
            $login =  Validator::checkLogin($this->params['login'])? $this->params['login'] : false;
            $password = Validator::checkPassword($this->params['password'])? password_hash($this->params['password'], PASSWORD_BCRYPT):false;
            if($login || $password)
            {
                $query = "SELECT id_user from `rest_users` where login = '$login'";
                $sth = $this->pdo->query($query);
                if(!$sth->fetchColumn()>0)
                {
                    $hash =  md5(mt_rand());
                    $time = time();
                    $query = "INSERT INTO rest_users (login, password, hash, time) VALUES ('$login', '$password', '$hash', '$time')";
                    $sth = $this->pdo->prepare($query);
                    if($sth->execute())
                        $this->createResponse(ERR_204, 201);
                    else
                        $this->createResponse(ERR_203, 404);
                }
                else
                    $this->createResponse(ERR_202, 404);
            }
            else
                $this->createResponse(ERR_201, 404);
        }

}

$user = new Users;
$user->start();
// dd($user->tableName());
