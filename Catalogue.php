<?php
	include ('Top.php');
        require_once ('cCatalogue.php');	
        header('Content-type: text/html; charset=utf-8');
        
        //<!--displays the name of the parent group of the current group-->
        function displayParentGroupName()
        {
            $lCatalogue = new cCatalogue();
            //$lGroupId = $_GET['GroupId'];
            $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
            $lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);
            $lParentGroupId = $lCatalogue->GetParentIdByChildId($lGroupId);
            //$lParentGroupName = $lCatalogue->GetGroupName($lParentGroupId);
            $lNativeLangParentGroupName = $lCatalogue->GetNativeLangGroupName($lParentGroupId);
            echo "parent group:   ";
            echo "<A HREF='Catalogue.php?GroupId=$lParentGroupId&UserId=$lUserId'>$lNativeLangParentGroupName</A></P>";
            return $lNativeLangParentGroupName;
        }

        //<!--displays the name of the current group-->
        function displayGroupName($pParentGroupName)
        {
            $lGroupName = filter_input(INPUT_GET, 'GroupName', FILTER_DEFAULT);
            if ($lGroupName == null)
            {
                //If this file is docked to AddNewGroupToCatalogue.php after the addition of the new group should be the name of the current group changed
                $lGroupName = $pParentGroupName;		
            }	
            $lCatalogue = new cCatalogue();
            $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
            $lNativeLangGroupName = $lCatalogue->GetNativeLangGroupName($lGroupId);
            echo "<font size = 3 face = arial>Group:   </font>"; 
            echo "<font size = 4 color = blue face = arial>".$lNativeLangGroupName."</font>";
        }

        //<!--display the list of subgroups of the clicked group-->
        function displayGroupList()
        {
            //requested group ID: 
            $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
            if ($lGroupId != null)
            {
                // create instance of Catalogue:
                $lCatalogue = new cCatalogue;
                //request and display child groups:
                print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                $lSubgroupList = $lCatalogue->GetSubgroupList($lGroupId);
                $lCounter = 0;
                $lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);
                //цикл для отображения списка групп
                while ($lCounter < count($lSubgroupList)) 
                {
                    echo "<tr><td>";

                    $lGroup = $lSubgroupList[$lCounter];
                    $lGroupId = intval($lGroup[0]);
                    $lGroupNativeLangName = $lGroup[1];
                    $lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);
                    echo "<P> [+] <A HREF='Catalogue.php?GroupId=$lGroupId&UserId=$lUserId'>$lGroupNativeLangName</A></P>";				
                    $lCounter = $lCounter + 1;
                    
                    echo "</td></tr>";	
                }    
                print "</table>";
            }
        }

        //<!--display list of opinions of the clicked group-->
        function displayOpinionList()
        {
            $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
            if ($lGroupId != NULL)
            {
                // create instance of Leaf:
                $lLeaf = new cLeaf;
                //check whether to allow this group to store opinuons
                $lFlag = $lLeaf->IsLeafable($lGroupId);
                if ($lFlag == 1)
                {
                    $lCounter = 0;
                    //request and display child groups:
                    print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                    $lLeafList = $lLeaf->GetLeafList($lGroupId);//TODO: Make circled output of opinions !!!                    
                    while($lCounter < count($lLeafList))
                    {    
                        $lAuthor = $lLeafList[$lCounter][8];
                        $lOpinion = $lLeafList[$lCounter][4];
                        $lDate = $lLeafList[$lCounter][5];
                        $lLikes = $lLeafList[$lCounter][6];
                        $lDisLikes = $lLeafList[$lCounter][7];
                        $lLike = "Like:  ";
                        $lDisLike = "Dislike:  ";
                        print "<table width=100% border=1 cellspacing=2 cellpadding=2><tr><td><p>$lAuthor<br><br>$lOpinion<br><br>$lDate  $lLike   $lLikes  $lDisLike  $lDisLikes</p></td></tr>";
                        $lCounter = $lCounter +1;
                    }
                    print "</table>";
                }
                else
                {
                    print"<center><p>?</p></center>";
                }
            }
        }
        
        //<!--Generates hyper reference to CatalogueEdit page-->
        function displayCatalogEditHRef()
        {
            $lRoot = 'root';
            $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
            $lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);
            if ($lGroupId != NULL)
            {
                // create instance of Catalogue:
                $lCatalogue = new cCatalogue;
                $lGroupName = $lCatalogue->GetGroupName($lGroupId);
                echo "<A HREF='CatalogueEdit.php?GroupName=$lGroupName&GroupId=$lGroupId&UserId=$lUserId'>Edit Catalog</A>"; 
            }
            else
            {
                echo "<A HREF='CatalogueEdit.php?GroupName=$lRoot&UserId=$lUserId'>Edit Catalog</A>"; //TODO: переделать эту ветку
            }
        }
        
        //<!--Generates hiper reference to OpinionEdit page-->
        function displayLeafEditHRef()
        {
            $lRoot = 'root';
            $lGroupId = filter_input(INPUT_GET, 'GroupId', FILTER_DEFAULT);
            $lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);;
                    if ($lGroupId != NULL)
            {
                echo "<A HREF='LeafEdit.php?GroupId=$lGroupId&UserId=$lUserId'>Write Your opinion and/or rewiew</A>"; 
            }
            else
            {
                echo "<A HREF='LeafEdit.php?GroupName=$lRoot&UserId=$lUserId'>Write Ypur opinions and/or rewiew</A>"; //TODO: переделать эту ветку
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

<div class="top_1">
    <div class="top_1_0">
        <center>
            <?php //<!--displays the name of the parent group of the current group-->
                $lParentGroupName = displayParentGroupName();
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
            <?php //<!--displays the name of the current group-->
                displayGroupName($lParentGroupName);
            ?>
            <?php //<!--display the list of subgroups of the clicked group-->	
                displayGroupList();
            ?>
        </center>
    </div>
    <div class="top_1_1">
        <center><p>
            <?php //<!--display list of opinions of the clicked group-->
                displayOpinionList();
            ?></p></center>
    </div>
    <div class="top_1_2">
        <center><p>?</p></center>
    </div>
</div>

<div class="top_1">
    <div class="top_1_0">
        <center>
            <?php //<!--Generates hyper reference to CatalogueEdit page--> 
                displayCatalogEditHRef();
            ?>
        </center>
    </div>
    <div class="top_1_1">
        <center><p>
                <?php //<!--Generates hiper reference to OpinionEdit page-->
                    displayLeafEditHRef();
                ?>
        </p></center>
    </div>
    <div class="top_1_2">
        <center><p>?</p></center>
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