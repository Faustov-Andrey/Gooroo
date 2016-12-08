<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    include ('Top.php');	
    include ('cUser.php');
    header('Content-type: text/html; charset=utf-8');
    
    function checkUser()
    {
        //Create instance of User
        $lUser = new cUser();

        // Read attributes of new user
    //    $lUserNickName = filter_input(INPUT_POST, 'userNickName', FILTER_DEFAULT);
    //    $lUserPw = filter_input(INPUT_POST, 'userPw', FILTER_DEFAULT);
    
        $lUserNickName = $_POST["userNickName"];
        $lUserPw = $_POST["userPw"];
        
        $lUserId = NULL;
        $lUserId = $lUser->CheckUnickUserNick($lUserNickName);
        if ($lUserId != NULL)
        {
            $lEcho = $lUser->IsRegistredUser($lUserNickName, $lUserPw); 
            
            return "<center><p>Добро пожаловать!</p></center>";
            
            
        }  else {
            // @TODO сделать возврат на страницу регистрации с сообщением:
            return "<center><p>Пользователь с таким именем или паролем не зарегистрирован</p></center>";
            
        }
    }
	
    function GetMenu($pItem, $pItems, $pChildrens, $lUserId) 
    {
        foreach ($pItems as $pItem) 
            {
                $lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);
                if($lUserId == NULL)
                {
                    $lUserId = 1;
                }
                echo "<td><center>";
                if (!$pItem["parent_menu_id"]) echo printItem($pItem, $pItems, $pChildrens, $lUserId); // Output elements of upper level
                echo "</center></td>";
            }
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>   ***   GooRoo   ***   decision making help   ***   </title>
        <link rel="stylesheet" type="text/css" href="style.css">        
    </head>
    <body>
        <div class="top_1">
            <div class="top_1_0">
                <center>?</center>
            </div>
            <div class="top_1_1">
                <center><p>
                    <div id="menu">
                        <table width=100% border=1 cellspacing=2 cellpadding=2><tr>
                        <ul>
                            <?php
                                GetMenu($item, $items, $childrens, $lUserId);
                            ?>
                        </ul>
                        </tr></table>
                    </div>	
                </p></center>
            </div>
            <div class="top_1_2">
                <center><p>searcher</p></center>
            </div>
        </div>

        <div class="auth_page">
            
            <div class="auth_form">                
                    
                <?php	
                    echo CheckUser();	
                ?>     
                                        
            </div>
               
        </div>
    </body>
</html>
<?php	
    include ('Bottom.php');	
?>
