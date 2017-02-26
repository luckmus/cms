<?php
    require_once "modules/content/Part.php";
    require_once "modules/content/Page.php";
    Includer::initSkins();
    include "modules/FRONTEND/skin/{$GLOBALS[SKIN_VAR]}/content_parts_viewer.php";
    
    $catalog = new GoodsCatalog($viewCategId);
    $parts = new Parts();
    $arrayOfParts = $parts->getParts();
    //addLog($arrayOfParts);
    print PartsViewer::getViewer($arrayOfParts);
?>