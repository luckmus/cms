<?php
    require_once "modules/em/init_module.php";
    include "modules/FRONTEND/skin/{$GLOBALS[SKIN_VAR]}/em_categories_viewer.php";
    print '<div id="sc1">';
    print CategoriesViewer::getViewStatic(new Categoryes(),$viewCategId);
    print '<div>';
?>  