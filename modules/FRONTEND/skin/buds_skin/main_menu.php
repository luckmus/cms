<?php         
    $host = GetHost();
  if ($_SESSION[_LOGIN_ID]!=null){
    $lbl = '<a href="#" onclick="logOut();">�����</a>';
    $cabinetLink = '<td><div class="mmitem"><a href="'.$host.'cabinet.php" >������ �������</a></div></td>';
  }
  else{
      $lbl = '<a href="#" onclick="showLogin(modalLoginPlace);">�����������</a>';
      $cabinetLink = '<td><div class="mmitem">&nbsp;</div></td>';
  }



  
   echo '             

            <div class="item" >                                
                <div class="mmitem">
        <table border="0" width=100%>
            <tr>
                <td>
                    <table>
                        
                            <tr><td width=300"><div class="mmitem"><a href="'.$host.'?show=info&id=1" >� ��������</a></div></td></tr>
                            <tr><td><div class="mmitem"><a href="'.$host.'" >�������</a></div></td></tr>
                            <tr><td><div class="mmitem"><a href="'.$host.'?show=info&id=21">��������</a></div></td></tr>
                    </table>
                </td>
                <td>
                    <table>
                        
                            <tr><td><div class="mmitem"><a href="'.$host.'?show=allnews" >�������</a></div></td></tr>
                            <tr><td><div class="mmitem"><a href="'.$host.'?show=allask" >�������</a></div></td></tr>
                            <tr><td><div class="mmitem"><a href="'.$host.'?show=allregards" >������</a></div></td></tr>
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
                <p class="hphonecomment">����� ������, ����������� �������� �&nbsp;������� ������ ��&nbsp;��������:</p>
                <div class="contact-tel">+7(812) 961-00-08<br> +7(921) 944-62-22</div>
            </div>
        </div>
                </td>                
            </tr>
        
        </table>

            </div>                                
                <!-- /������ ������ ������ -->
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
                            <td width=300"><div class="mmitem"><a href="'.$host.'?show=info&id=1" >� ��������</a></div></td>
                            <td><div class="mmitem"><a href="'.$host.'?show=allnews" >�������</a></div></td>
                            <td><div class="mmitem">'.$lbl.'</div></td>
                        </tr>
                        <tr>
                            <td><div class="mmitem"><a href="'.$host.'" >�������</a></div></td>
                            <td><div class="mmitem"><a href="'.$host.'?show=allask" >�������</a></div></td>
                            '.$cabinetLink.'
                        </tr>
                        <tr>
                            <td><div class="mmitem"><a href="'.$host.'?show=info&id=21">��������</a></div></td>
                            <td><div class="mmitem"><a href="'.$host.'?show=allregards" >������</a></div></td>
                        </tr>
                    </table>
                </div>
            </div>                                
                <!-- /������ ������ ������ -->
          </div>  
          <div class="menu">
            <div class="item">
            </div>
            </div>';
            return;
            
  echo '             
          <div class="catalog">
            <div class="item">                                
                <div class="mmitem"><a href="?show=info&id=1" >� ��������</a></div>
                <div class="mmitem"><a href="?" >�������</a></div>
                <div class="mmitem"><a href="?show=info&id=21">��������</a></div>
            </div>                                
                <!-- /������ ������ ������ -->
          </div>  
          <div class="menu">
            <div class="item">
                 <div class="mmitem"><a href="?show=allnews" >�������</a></div>
                 <div class="mmitem"><a href="?show=allask" >�������</a></div>
                 <div class="mmitem"><a href="?show=allregards" >������</a></div>
            </div>
            </div>';

?>