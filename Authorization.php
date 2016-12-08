<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php	
    include ('Top.php');
    header('Content-type: text/html; charset=utf-8');

    function GetMenu($pItem, $pItems, $pChildrens) 
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
                                GetMenu($item, $items, $childrens);
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
                    <form action="PersonalRoom.php" method="post">
                        <p>Nick: <input type="text" name="userNickName" /></p>
                        <p>Пароль: <input type="text" name="userPw" /></p>
                        <p><input type="submit" value="Enter"><input type="reset" value="Clear"></p>
                    </form>                    
            </div>
               
        </div>
    </body>
</html>
<?php	
    include ('Bottom.php');	
?>