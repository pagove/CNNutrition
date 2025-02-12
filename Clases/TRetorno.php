<?php
#[AllowDynamicProperties]
class TRetorno
{

    public $ok;
    public $msg;
    public function __construct($ok, $msg = "", $datos = null, $save_log = "")
    {
        $this->ok = $ok;
        $this->msg = $msg;
        if ($datos) {
            Logger::haz_log("GOVE-------->", var_export($datos, true));
            foreach ($datos as $key => $value) {
                $this->$key = $value;
            }
        }
        if ($save_log && !$ok) {
            Logger::haz_log($save_log, var_export(debug_backtrace(), true));
            Logger::haz_log($save_log, var_export($this, true));
        }
    }
}
