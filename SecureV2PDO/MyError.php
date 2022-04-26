<?php


class MyError{

    private $code;
    private $message;
    private $time; 

    function __construct($code = 0, $message =""){
        $this->code = $code;
        $this->message = $message;
        $this->time = new DateTime("NOW", new DateTimeZone("Europe/paris"));
    }

    function __toString(){
        // Ternaire ci-dessous, ? = alors, : = sinon/ou
        return($this->code != 0) ? "[".$this->time->format('Y/m/d H:i:s')."] Error ".$this->code." : ".$this->message : "";
    }

    // A la différence du constructeur qui était l'initiateur de notre futur object Error, là, notre fonction setError remplis 
    // véritablement notre objet en faisant directement appelle à notre fonction au lieu de l'initialiser
    function setError($code = 0, $message=""){
        $this->code = $code;
        $this->message = $message;
        $this->time = new DateTime("NOW", new DateTimeZone("Europe/paris"));
    }
}