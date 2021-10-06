<?php
  namespace vilshub\http;
  use vilshub\helpers\Message;
  use \Exception;
  use vilshub\helpers\Get;
  use vilshub\helpers\Style;
  use vilshub\helpers\TextProcessor;
  use \DataParser;
  use \Route;
  /**
   *
   */
   /**
    *
    */
    define("METHOD", $_SERVER["REQUEST_METHOD"]);   
    define("URI", $_SERVER["REQUEST_URI"]);   
    class Request
   {

    public static $method = METHOD;
    public static $uri = URI;

    public static function data($clean=null){
      $istream = new class ($clean) {
        private $clean;
        function __construct($clean){
          $this->clean = $clean;
        }
        
        public function fromPost($inputName = null){
          if(Request::$method == "POST"){
            if($inputName !=  null){
              if(isset($_POST[$inputName])){
                switch (strtolower($this->clean)) {
                  case 'clean':
                    return DataParser::inText($_POST[$inputName]);
                    break;
                  default:
                    return $_POST[$inputName];
                    break;
                }
              }else{
                return null;
              }
            }else{
              return $_POST;
            }
          }
        }

        public function fromGet($inputName = null){
          if(Request::$method == "GET"){
            if($inputName !=  null){
              if(isset($_GET[$inputName])){
                switch (strtolower($this->clean)) {
                  case 'clean':
                    return DataParser::inText($_GET[$inputName]);
                    break;
                  default:
                    return $_GET[$inputName];
                    break;
                }
              }else{
                return null;
              }
            }else{
              return $_GET;
            }
          }
        }

        public function fromFile($inputName = null){
          if($inputName !=  null){
            if(isset($_FILES[$inputName])){
              return $_FILES[$inputName];
            }else{
              return null;
            }
          }else{
            return $_FILES;
          }
        }

        public function fromStream($key = null){
          $raw = file_get_contents("php://input");
          $parsed = json_decode($raw, true);

          if($key !=  null){//specific field needed
            if(isset($parsed['name'])){
              switch (strtolower($this->clean)) {
                case 'clean':
                  return DataParser::inText($parsed['name']);
                  break;
                default:
                  return $parsed['name'];
                  break;
              }
            }else{
              return null;
            }
          }else{
            return $parsed;
          }
        }
      };
      return $istream;
    }

    public static function get($route, $handlerOrCm){
      if(Request::$method == "GET"){
        Route::validateRoute($route, $handlerOrCm, "api");
      }
    }

    public static function post($route, $handlerOrCm){
      if(Request::$method == "POST"){
        Route::validateRoute($route, $handlerOrCm, "api");
      }
    }

    public static function put($route, $handlerOrCm){
      if(Request::$method == "PUT"){
        Route::validateRoute($route, $handlerOrCm, "api");
      }
    }

    public static function delete($route, $handlerOrCm){
      if(Request::$method == "DELETE"){
        Route::validateRoute($route, $handlerOrCm, "api");
      }
    }
   }
?>