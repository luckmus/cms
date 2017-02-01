<?php
#пример
# header("location:message.php?"mesid=ordersuccessfully);
@session_start();
$_GET['show'] = 'message';
$mesid = $_GET['mesid'];
switch ($mesid)
{
    case "ordersuccessfully":
        $_SESSION['infomessgae'] = "</b>Заказ принят. <br>В ближайшее время с Вами свяжется наш менеджер.</b>";
    break;
}

header("Location:?show=message");

include "index.php";
?>