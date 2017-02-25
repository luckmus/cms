<?php         
    $host = GetHost();
  if ($_SESSION[_LOGIN_ID]!=null){
    $lbl = '<a href="#" onclick="logOut();">Выход</a>';
    $cabinetLink = '<td><div class="mmitem"><a href="'.$host.'cabinet.php" >Личный кабинет</a></div></td>';
  }
  else{
      $lbl = '<a href="#" onclick="showLogin(modalLoginPlace);">Авторизация</a>';
      $cabinetLink = '<td><div class="mmitem">&nbsp;</div></td>';
  }



  
   echo '             

            <div class="item" >                                
                <div class="mmitem">
        <table border="0" width=100%>
            <tr>
                <td>
                    <table>
                        
                            <tr><td width=300"><div class="mmitem"><a href="'.$host.'?show=info&id=1" >О магазине</a></div></td></tr>
                            <tr><td><div class="mmitem"><a href="'.$host.'" >Каталог</a></div></td></tr>
                            <tr><td><div class="mmitem"><a href="'.$host.'?show=info&id=21">Доставка</a></div></td></tr>
                    </table>
                </td>
                <td>
                    <table>
                        
                            <tr><td><div class="mmitem"><a href="'.$host.'?show=allnews" >Новости</a></div></td></tr>
                            <tr><td><div class="mmitem"><a href="'.$host.'?show=allask" >Вопросы</a></div></td></tr>
                            <tr><td><div class="mmitem"><a href="'.$host.'?show=allregards" >Отзывы</a></div></td></tr>
                    </table>
                </td>                
                <td>
                    <table>
                        
                            <tr><td><div class="mmitem">'.$lbl.'</div></td></tr>
                            <tr>'.$cabinetLink.'</tr>
                            <tr><td><div class="mmitem"></div></td></tr>
                    </table>
                </td>
                <td>
        <div class="telephone" align="right">
            <div class="item">
                <p class="hphonecomment">Заказ товара, подробности доставки и&nbsp;наличия товара по&nbsp;телефону:</p>
                <div class="contact-tel">+7(812) 961-00-08<br> +7(921) 944-62-22</div>
            </div>
        </div>
                </td>                
            </tr>
        
        </table>

            </div>                                
                <!-- /плашка поиска товара -->
          </div>  
          <div class="menu">
            <div class="item">
            </div>
            </div>';
            return;
 
  
  
  
  echo '             
          <div class="menu">
            <div class="item" >                                
                <div class="mmitem">
                    <table border="0"  width=300>
                        <tr>
                            <td width=300"><div class="mmitem"><a href="'.$host.'?show=info&id=1" >О магазине</a></div></td>
                            <td><div class="mmitem"><a href="'.$host.'?show=allnews" >Новости</a></div></td>
                            <td><div class="mmitem">'.$lbl.'</div></td>
                        </tr>
                        <tr>
                            <td><div class="mmitem"><a href="'.$host.'" >Каталог</a></div></td>
                            <td><div class="mmitem"><a href="'.$host.'?show=allask" >Вопросы</a></div></td>
                            '.$cabinetLink.'
                        </tr>
                        <tr>
                            <td><div class="mmitem"><a href="'.$host.'?show=info&id=21">Доставка</a></div></td>
                            <td><div class="mmitem"><a href="'.$host.'?show=allregards" >Отзывы</a></div></td>
                        </tr>
                    </table>
                </div>
            </div>                                
                <!-- /плашка поиска товара -->
          </div>  
          <div class="menu">
            <div class="item">
            </div>
            </div>';
            return;
            
  echo '             
          <div class="catalog">
            <div class="item">                                
                <div class="mmitem"><a href="?show=info&id=1" >О магазине</a></div>
                <div class="mmitem"><a href="?" >Каталог</a></div>
                <div class="mmitem"><a href="?show=info&id=21">Доставка</a></div>
            </div>                                
                <!-- /плашка поиска товара -->
          </div>  
          <div class="menu">
            <div class="item">
                 <div class="mmitem"><a href="?show=allnews" >Новости</a></div>
                 <div class="mmitem"><a href="?show=allask" >Вопросы</a></div>
                 <div class="mmitem"><a href="?show=allregards" >Отзывы</a></div>
            </div>
            </div>';

?>