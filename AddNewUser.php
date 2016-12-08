<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    //include ('Top.php');
    include ('cUser.php');
    include ('Top.php');	

    header('Content-type: text/html; charset=utf-8');
    
    function saveUser()
    {
        //Create instance of User
        $lUser = new cUser();

        // Read attributes of new user
        $lUserName = filter_input(INPUT_POST, 'userName', FILTER_DEFAULT);
        $lUserNickName = filter_input(INPUT_POST, 'userNickName', FILTER_DEFAULT);
        $lUserPw = filter_input(INPUT_POST, 'userPw', FILTER_DEFAULT);
        $lUserEMail = filter_input(INPUT_POST, 'userEMail', FILTER_DEFAULT);
        $lUserPhone = filter_input(INPUT_POST, 'userPhone', FILTER_DEFAULT);

//        $lUserName = $_POST["userName"];
//        $lUserNickName = $_POST["userNickName"];
//        $lUserPw = $_POST["userPw"];
//        $lUserEMail = $_POST["userEMail"];
//        $lUserPhone = $_POST["userPhone"];

        $check = NULL;
        $check = $lUser->CheckUnickUserNick($lUserNickName);
        if ($check == NULL)
        {
            //Add user
            $lUserId = $lUser->GetNewUserId();
            $lDate = date("Y-m-d");
            $lTime = time();
            $lUserIP = ""; // @TODO realize request $lUserIP
            $lProperties = ""; // @TODO realize request $lUserIP
            $lEcho = $lUser->AddUser($lUserId, $lUserName, $lUserNickName, $lUserPw, $lUserEMail, $lUserPhone, $lDate, $lTime, $lUserIP, $lProperties); 
            return "Вы зарегистрированы";
            //include ('User.php');
        }  else {
            // @TODO сделать возврат на страницу регистрации с сообщением:
            return "Пользователь с таким именем уже зарегистрирован";
            //include ('Authorization.php');
        }
    }
	
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
                    
                <?php	
                    echo saveUser();	
                ?>     
                                        
            </div>
               
        </div>
    </body>
</html>
<?php	
    include ('Bottom.php');	
?>