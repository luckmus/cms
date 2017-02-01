 <?php
    //echo "em: "._MODULES_EM_PATH."<br>";
    include _MODULES_EM_PATH."parameter.php";
    $allParams = new Parameters();
    $host = getHost();
    $paramFace = getHost()._ADM_FRONTEND."em_param_values.php";
    echo "<div id='"._MAIN_PARAM_CONT."'>";
    echo "<ul>";
    foreach($allParams->parameters as $param){
        $paramUrl = $paramFace."?id=".$param->id;
        echo "<li><a href='$paramUrl'><span>{$param->name}  </span></a></li>";
    
    }
    echo "</ul>";
    echo "</div>";
    
    $jsScript = "
jQuery("._MAIN_PARAM_CONT.").tabs();
";
echo "<script>$jsScript</script>";
?>