<?php
    require_once "modules/em/init_module.php";
    require_once "modules/FRONTEND/skin/{$GLOBALS[SKIN_VAR]}/em_categories_viewer.php";
    print CategoriesViewer::getDescrStatic($viewCategId);

?>