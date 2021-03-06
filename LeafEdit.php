<?php
    require_once ('cUser.php');
    require_once ('cCatalogue.php');
    include ('Top.php');	
    header('Content-type: text/html; charset=utf-8');
    
    //<!--display the parent group to the current group-->
    function displParenGrp()
    {
        $lCatalogue = new cCatalogue();
        $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
        $lParentGroupId = $lCatalogue->GetParentIdByChildId($lGroupId);
        $lParentGroupName = $lCatalogue->GetGroupName($lParentGroupId);
        $lNativeLangParentGroupName = $lCatalogue->GetNativeLangGroupName($lParentGroupId);
        echo "Parent group:   ";
        echo "<A HREF='Catalogue.php?GroupName=$lParentGroupName&GroupId=$lParentGroupId'>$lNativeLangParentGroupName</A>";
    }
    
    //<!-- display name of current group -->
    function displCurrentGrp()
    {
        $lCatalogue = new cCatalogue();
        $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
        $lNativeLangGroupName = $lCatalogue->GetNativeLangGroupName($lGroupId);
        echo "<font size = 3 face = arial>Группа:   </font>"; 
        echo "<font size = 4 color = blue face = arial>".$lNativeLangGroupName."</font>";
        return $lNativeLangGroupName;
    }
    
    //
    function displGroupLst()
    {
        //requested group ID: 
        $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
        if ($lGroupId != NULL)
        {
            // create instance of Catalogue:
            $lCatalogue = new cCatalogue;
            //request and display child groups:
            print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
            $lSubgroupList = $lCatalogue->GetSubgroupList($lGroupId);
            $lCounter = 0;
            //цикл для отображения списка групп
            while ($lCounter < count($lSubgroupList)) 
            {
                echo "<tr><td>";

                $lGroup = $lSubgroupList[$lCounter];
                $lGroupId = intval($lGroup[0]);
                $lGroupNativeLangName = $lGroup[1];
                echo "<P> [+] <A HREF='Catalogue.php?GroupId=$lGroupId'>$lGroupNativeLangName</A></P>";				
                $lCounter = $lCounter + 1;

                echo "</td></tr>";	
            }    
            print "</table>";
        }
        
    }
        
    //<!--display the user Nickname -->
    function displUserNickName($pUserId)
    {
        $lUser = new cUser();
        //$lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);
        $lUserNickName = $lUser->GetUserNickNameOnId($pUserId);

        return $lUserNickName;

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

<!--HTML code block below-->


<div class="top_1">
    <div class="top_1_0">
        <center>
            <?php
                displParenGrp();
            ?>
        </center>
    </div>
    <div class="top_1_1">
        <center><p>?</p></center>
    </div>
    <div class="top_1_2">
        <center><p>?</p></center>
    </div>
</div>

<!--display the parent group to the current group-->
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

<div class="top_1">
    <div class="top_1_0">
        <center>
            <!-- display name of current group -->
            <?php
                $lNativeLangGroupName = displCurrentGrp();
            ?>
        </center>
        <center>
            <!--display subgroups of current group-->
            <?php	
                displGroupLst();
            ?>
        </center>
        
    </div>
    <div class="top_1_1">
        <center>
            <p>
                <form action="AddNewLeaf.php" method="post">
                    <p>User:
                        <input type="hidden" name="UserId" value=
                            <?php 
                                $lUserId = 2; // @TODO get UserId from User object 
                                $lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);
                                $lUserNicknm = displUserNickName($lUserId); 
                            ?>
                        enabled>
                        <?php 
                            echo $lUserNicknm ;
                        ?>
                    </p>
                    <p>GroupName:<input type="hidden" name="GroupName" value=<?php echo $lNativeLangGroupName?> enabled><?php echo $lNativeLangGroupName?></p> 
                    <!--<p>GroupId:<input type="hidden" name="GroupId" value=<?php //echo filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT)?> enabled><?php //echo filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT)?></p> -->
                    <p>Write Your comment here:<Br>
                        <textarea name="NewOpinion" cols="50" rows="5"></textarea>
                    </p>
                    <p><input type="submit"/></p>
                </form>
            </p>
        </center>
    </div>
    <div class="top_1_2">
        <center><p>News advertysing and other</p></center>
    </div>
</div>

<div class="top_1">
    <div class="top_1_0">
        <center>?</center>
    </div>
    <div class="top_1_1">
        <center><p>icons of payment systems</p></center>
    </div>
    <div class="top_1_2">
        <center><p>?</p></center>
    </div>
</div>

<?php	
	include ('Bottom.php');	
?>