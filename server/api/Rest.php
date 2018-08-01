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
          // dd($path);
            $clearString = mb_strtolower(strip_tags($path));
            $data = trim($clearString);
            preg_match("/\.\w+$/", $data, $format);
            $this->contentFormat = substr($format[0], 1);
            $this->params = preg_replace("/\.\w+$/", "", $data);
            // dd($this->params);
            // dd($this->contentFormat);
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

    public function setMethod($method, $param=null)
    {
        if (method_exists($this, $method)) {
            $this->$method($param);
        } else {
            echo "Error function setMethod"."<br>";
            echo "Error 505";
        }
    }

    public function converter($data)
    {
      if(!empty($this->contentFormat)){
        switch ($this->contentFormat) {
          case 'txt':
          header("Content-Type: text/html");
          $response = var_dump($data);
            break;
          case 'json':
            header("Content-Type: application/json");
            $response = json_encode(print_r($data));
            break;
            case 'html':
                header("Content-Type: text/html");
                $result = print_r($data, true);
                $response = "<html><head></head><body><pre>" . $result . "</pre></body></html>";
                break;
            case 'xml':
                header("Content-Type: application/xml");
                $xml = new SimpleXMLElement('<car/>');
                foreach($data as $car)
                {
                    $car = array_flip($car);
                    array_walk_recursive($car, array($xml, 'addChild'));
                }
                $response = $xml->asXML();
                break;
          default:
            break;
        }
      } else {
        header("Content-Type: application/json");
        $response = json_encode($data, JSON_PRETTY_PRINT);
      }
      echo $response;
    }


}
