<?php
require_once 'config.php';
require_once 'autoload.php';

class Rest extends Arecord
{

    public $params;
    public $table;
    public $method;
    public $contentFormat;
// public $responseCode;

    public function parsUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        list($s, $a, $d, $f, $c, $table, $path) = explode('/', $url, 7);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->table = $table;
        if (!empty($path)) {
            $clearString = mb_strtolower(strip_tags($path));
            $data = trim($clearString);
            preg_match("/\.\w+$/", $data, $format);
            $this->contentFormat = $format[0];
            $this->params = preg_replace("/\.\w+$/", "", $data);
        }
    }

    public function start()
    {
        $this->parsUrl();
        switch ($this->method) {
            case 'GET':
            if($this->params == false){
              $this->setMethod('get' . ucfirst($this->table));
            } else {
              $this->setMethod('get' . ucfirst($this->table), $this->params);
            }
                break;
            case 'DELETE':
                $this->setMethod('delete' . ucfirst($this->table));
                break;
            case 'POST':
                $this->params = $_POST;
                $this->setMethod('post' . ucfirst($this->table));
                break;
            case 'PUT':
                $this->setMethod('put' . ucfirst($this->table));
                break;
            default:
                return false;
        }
    }

    function setMethod($method, $param=null)
    {
        if (method_exists($this, $method)) {
            $this->$method($param);
        } else {
            echo "Error function setMethod";
        }
    }


}
