<?php
include_once("../clases.php");
class TRetorno
{

    public $ok;
    public $msg;
    public function __construct($ok, $msg = "", $datos = null, $save_log = "")
    {
        $this->ok = $ok;
        $this->msg = $msg;
        if ($datos) {
            foreach ($datos as $key => $value) {
                $this->$key = $value;
            }
        }
        if ($save_log && !$ok) {
            Logger::haz_log($save_log, $msg);
        }
    }
}
