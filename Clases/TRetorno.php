<?php

class TRetorno{

    public $ok;
    public $msg;
    public function __construct($ok, $msg = "", $datos = null) {
        $this->ok = $ok;
        $this->msg = $msg;
        foreach ($datos as $key => $value) {
            $this->$key = $value;
        }
    }

    
}