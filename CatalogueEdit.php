<?php
    include ('Top.php');	
    require_once ('cCatalogue.php');
    header('Content-type: text/html; charset=utf-8');
    
    // <!--display the parent group to the current group-->
    function displParentGroupName() 
    {
        //$lGroupId = $_GET['GroupId'];
        $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
        $lCatalogue = new cCatalogue();
        $lParentGroupId = $lCatalogue->GetParentIdByChildId($lGroupId);
        $lParentGroupName = $lCatalogue->GetGroupName($lParentGroupId);
        $lNativeLangParentGroupName = $lCatalogue->GetNativeLangGroupName($lParentGroupId);
        echo "parent group   ";echo "<A HREF='Catalogue.php?GroupId=$lParentGroupId'>$lNativeLangParentGroupName</A></P></td>";
    }
    
    // <!--display name of current group-->
    function displGroupName() 
    {
        //$lGroupId = $_GET['GroupId'];
        $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
        $lCatalogue = new cCatalogue();// create instance of cCatalogue
        $lNativeLangGroupName = $lCatalogue->GetNativeLangGroupName($lGroupId);
        echo "<font size = 3 face = arial>Группа:   </font>"; 
        echo "<font size = 4 color = blue face = arial>".$lNativeLangGroupName."</font>";
    }
    
    // <!--display subgroups of current group-->
    function displGroupList() 
    {
        if (array_key_exists("GroupId", $_GET))
            {
                // create instance of Catalogue:
                $lCatalogue = new cCatalogue;
                //requested group ID: 
                $lGroupId = $_GET['GroupId'];
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
            <?php // <!--display the parent group to the current group-->
                displParentGroupName();
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

<div class="top_1">
    <div class="top_1_0">
        <center>
            <?php // <!--display name of current group-->
                displGroupName();
            ?>
        </center>
    </div>
    <div class="top_1_1">
        <center><p>Fill the form and press "Add"</p></center>
    </div>
    <div class="top_1_2">
        <center><p>?</p></center>
    </div>
</div>


<div class="top_1">
    <div class="top_1_0">
        <center>
            <?php // <!--display subgroups of current group-->
                displGroupList();
            ?>
        </center>
    </div>
    <div class="top_1_1">
        <center><p>
            <form action="AddNewGroupToCatalogue.php" method="post">
                <p>Parent Group ID:<input type="hidden" name="ParentGroupId" value=<?php echo filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT)?> enabled><?php echo filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT)?></p>
                <p>Parent Group Name:<input type="hidden" name="ParentGroupName" value=<?php echo filter_input(INPUT_GET, 'GroupName', FILTER_DEFAULT)?> enabled><?php echo filter_input(INPUT_GET, 'GroupName', FILTER_DEFAULT)?></p>
                <p>New Group Name in English: <input type="text" name="NewGroupName" /></p>
                <p>New Group Name in Russian: <input type="text" name="NativeLangGroupName" /></p>
                <p><input type="submit" value="Add"><input type="reset" value="Clear"></p>
            </form>
            
        </p></center>
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