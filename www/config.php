<?php
/**'"
 * Created by PhpStorm.
 * Namespaces - permite organização das classes
 */

//autoload das classes armazenadas na pasta "class"
spl_autoload_register(function($nameClass) {
    $fileName = "Classe" . DIRECTORY_SEPARATOR . $nameClass . ".php";

    if (file_exists($fileName)) {
        require_once($fileName);
    }
});

define("MaxSize",(2*1024*1024));

?>