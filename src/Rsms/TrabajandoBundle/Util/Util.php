<?php
namespace Rsms\TrabajandoBundle\Util;
class Util
{
    static public function getSlug($cadena, $separador = '-')
    {
        // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
        setlocale(LC_ALL, 'es_ES');
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = strtolower(trim($slug, $separador));
        $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);
        $slug = preg_replace("/^-/",'', $slug);
        $slug = preg_replace("/-$/",'', $slug);
        return $slug;
    }
    
    static public function getSlugArray($arreglo, $separador = '-')
    {
        // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
        foreach ($arreglo as $cadena) {
            setlocale(LC_ALL, 'es_ES');
            $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
            $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
            $slug = strtolower(trim($slug, $separador));
            $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);
            $slugs[]=$slug;
        }
        
        return $slugs;
    }
    
    static public function preVar($var)
    {
       echo "<pre>";
       var_dump($var);
       echo "</pre>";
    }
    
    static public function unique_id($l = 5) {
        $characters = array(
"A","B","C","D","E","F","G","H","J","K","L","M",
"N","P","Q","R","S","T","U","V","W","X","Y","Z",
"1","2","3","4","5","6","7","8","9");
        $letras = array("");
        $x = mt_rand(0, count($characters)-1);
        return $characters[$x].substr(md5(uniqid(mt_rand(), true)), 0, $l);//."0";
    }
    
    static function json_last_error_msg_($json)
    {
        switch (json_last_error()) {
            default:
                return;
            case JSON_ERROR_DEPTH:
                $error = 'Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
        }
        return ($json.':::::'.$error);
    }
}
?>
