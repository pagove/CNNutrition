<?php
class Imagenes
{
    public static function getFavIcon()
    {
        return  $_SERVER['DOCUMENT_ROOT'] . "/web_images/favIcon/favico.ico";
    }
    public static function getImgTarifas($idImg)
    {
        return self::recuperaImg("imgTarifas/$idImg.jpeg");
    }

    private static function recuperaImg($ruta)
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . "/web_images/" . $ruta;
        $mime_type = mime_content_type($file);
        $b64 = base64_encode(file_get_contents($file));
        $base64_para_html = 'data:' . $mime_type . ';base64,' . $b64;
        return $base64_para_html;
    }
}
