<?php
require_once '../../config.php';
require_once '../../autoload.php';

class Rest extends Arecord
{

    protected $table;
    protected $method;
    protected $contentFormat;
    protected $data;
    protected $responce;

    public function __construct()
    {
        parent::__construct();
        $this->responce = new Response();
    }

    public function start()
    {
        $this->getData();
        switch ($this->method) {
            case 'GET':
                $this->setMethod('get' . ucfirst($this->table), $this->getData());
                break;
            case 'DELETE':
                $this->setMethod('delete' . ucfirst($this->table), $this->getData());
                break;
            case 'POST':
                $this->setMethod('post' . ucfirst($this->table), $this->getData());
                break;
            case 'PUT':
                $this->setMethod('put' . ucfirst($this->table), $this->getData());
                break;
            default:
                return false;
        }
    }

    public function getData()
    {
        $url = $_SERVER['REQUEST_URI'];
        list($s, $a, $d, $table, $path) = explode('/', $url, 5);
        $this->method = $_SERVER['REQUEST_METHOD'];
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: PUT, POST, GET, DELETE');
        header('Access-Control-Allow-Headers: Authorization, Content-Type');
        $this->table = $table;

        if ($this->method == 'GET' || $this->method == 'DELETE') {
            $clearString = mb_strtolower(strip_tags($path));
            $data = trim($clearString);
            preg_match("/\.\w+$/", $data, $format);
            if (!empty($format)) {
                $this->contentFormat = substr($format[0], 1);
            }
            $this->data = preg_replace("/\.\w+$/", "", $data);

            return $this->data;
        }

        if ($this->method == 'POST') {
            $this->data = $_POST;

            return $this->data;
        }

        if ($this->method == 'PUT') {
            $this->data = json_decode(file_get_contents("php://input"), true);

            return $this->data;
        }
    }

    public function setMethod($method, $data = null)
    {
        if (method_exists($this, $method)) {
            $this->$method($data);
        } else {
            echo $this->method . "Error function setMethod" . "<br>";
        }
    }

    public function converter($data)
    {
        if (!empty($this->contentFormat)) {
            switch ($this->contentFormat) {
                case 'txt':
                    header("Content-Type: text/html");
                    $response = print_r($data);
                    break;
                case 'json':
                    header("Content-Type: application/json");
                    $response = json_encode($data);
                    break;
                case 'html':
                    header("Content-Type: text/html");
                    $result = print_r($data, true);
                    $response = "<html><head></head><body><pre>" . $result . "</pre></body></html>";
                    break;
                case 'xml':
                    header("Content-Type: application/xml");
                    $xml = new SimpleXMLElement('<car/>');
                    $data = array_flip($data);
                    array_walk_recursive($data, array($xml, 'addChild'));
                    $response = $xml->asXML();
                    break;
                default:
                    break;
            }
        } else {
            header(DEFAULT_HEADER);
            $response = json_encode($data);
        }
        return $response;
    }


}
