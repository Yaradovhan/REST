<?php
require_once 'config.php';
require_once 'autoload.php';

class Rest extends Arecord
{

    public $params;
    public $table;
    public $method;
// public $contentFormat;
// public $responseCode;

    public function parsUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        dd($url);
        list($s, $a, $d, $f, $table, $path) = explode('/', $url, 6);
        dd([$s, $a, $d, $f, $table, $path]);
        $this->method = $_SERVER['REQUEST_METHOD'];
        dd($this->method);
        $this->table = $table;
        dd($this->table);
        dd($path);
        if (!empty($path)) {
            $clearString = mb_strtolower(strip_tags($path));
            $data = trim($clearString);
            preg_match("/\.\w+$/", $data, $format);
            $this->contentType = $format[0];
            $this->params = preg_replace("/\.\w+$/", "", $data);
        }
    }

    public function start()
    {
        $this->parsUrl();
        switch ($this->method) {
            case 'GET':
                $this->setMethod('get' . ucfirst($this->table));
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

    function setMethod($method)
    {
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            echo "Error function setMethod";
        }
    }


}
