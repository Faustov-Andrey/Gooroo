<?php
	include ('Top.php');
        require_once ('cCatalogue.php');	
?>
    <tr>
        <td>
            <center><p>
                <?php //<!--displays the name of the parent group to the current group-->
                    //$GroupName = $_GET['GroupName'];
                    $lCatalogue = new cCatalogue();
                    //$lGroupId = $lCatalogue->GetGroupId($GroupName);
                    $lGroupId = $_GET['GroupId'];
                    //echo ("group Id".$lGroupId);
                    $lParentGroupId = $lCatalogue->GetParentIdByChildId($lGroupId);
                    //echo ("parent group Id".$lParentGroupId);
                    $lParentGroupName = $lCatalogue->GetGroupName($lParentGroupId);
                    $lNativeLangParentGroupName = $lCatalogue->GetNativeLangGroupName($lParentGroupId);
                    //echo ("name of parent group".$lNativeLangGroupName);
                    echo "parent group:   ";
                    echo "<A HREF='Catalogue.php?GroupName=$lParentGroupName'>$lNativeLangParentGroupName</A></P>";
                ?>
            </p></center>
        </td>
        <td>
                <center><p>page icons</p></center>
        </td>
        <td>
                <center><p>?</p></center>
        </td>
    </tr>
    <tr> 
        <td>
            <center><p>
                <?php //<!--displays the name of the current group-->
                    if (array_key_exists("GroupName", $_GET))
                    {
                        $lGroupName = $_GET['GroupName'];
                    }
                    else
                    {
                        //If this file is docked to AddNewGroupToCatalogue.php after the addition of the new group should be the name of the current group changed
                        $lGroupName = $lParentGroupName;		
                    }	
                    $lCatalogue = new cCatalogue();
                    $lGroupId = $_GET['GroupId'];
                    $lNativeLangGroupName = $lCatalogue->GetNativeLangGroupName($lGroupId);
                    echo "<font size = 3 face = arial>Group:   </font>"; 
                    echo "<font size = 4 color = blue face = arial>".$lNativeLangGroupName."</font>";

                ?>
            </p></center>
            <?php //<!--display the list of subgroups of the clicked group-->	
                if (array_key_exists("GroupId", $_GET))
                {
                    // create instance of Catalogue:
                    $lCatalogue = new cCatalogue;
                    //requested group ID: 
                    $lGroupId = $_GET['GroupId'];
                    //request and display child groups:
                    print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                    $lSubgroupList = $lCatalogue->GetSubgroupList($lGroupId);
                    //здесь нужен цикл для отображения списка групп
                    $lCounter = 0;
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
                //Deprecated!?
                if (array_key_exists("ParentGroupName", $_POST))
                {
                    // create instance of Catalogue:
                    $lCatalogue = new cCatalogue;
                    //requested group ID: 
                    $lGroupId = $lCatalogue->GetGroupId($_POST["ParentGroupName"]);
                    //request and display child groups:
                    print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                    $lCatalogue->GetSubgroupList($lGroupId);
                    print "</table>";
                }	
            ?>
        </td>
        <td>
            <?php //<!--display list of opinions of the clicked group-->
                if (array_key_exists("GroupId", $_GET))
                {
                    // create instance of Leaf:
                    $lLeaf = new cLeaf;
                    $lGroupId = $_GET['GroupId'];
                    //check whether to allow this group to store opinuons
                    $lFlag = $lLeaf->IsLeafable($lGroupId);
                    if ($lFlag == 1)
                    {
                        $lCounter = 0;
                        //request and display child groups:
                        print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                        $lLeafList = $lLeaf->GetLeafList($lGroupId);
                        //TODO: Make circled output of opinions !!!
                        while($lCounter< count($lLeafList))
                        {    
                            $lOpinion = $lLeafList[$lCounter][4];
                            print "<table width=100% border=1 cellspacing=2 cellpadding=2><tr><td><center><p>$lOpinion</p></center></td></tr>";
                            $lCounter = $lCounter +1;
                        }
                        print "</table>";
                    }
                    else
                    {
                        print"<center><p>?</p></center>";
                    }
                }	
                //Deprecated!? похоже да
                if (array_key_exists("ParentGroupName", $_POST))
                {
                    $lGroupId = $_GET['GroupId'];
                    // create instance of Leaf:
                    $lLeaf = new cLeaf;
                    //check whether to allow this group to store the opinuons
                    $lFlag = $lLeaf->IsLeafable($lGroupId);
                    if ($lFlag == 1)
                    {
                        //request and display child groups:
                        print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                        $lLeaf->GetLeafList($lGroupId);
                        print "</table>";
                    }
                    else
                    {
                        print"<td><center><p>?</p></center></td>";
                    }
                }	
            ?>
        </td>
        <td>
                <center><p>?</p></center>
        </td>
    </tr>
    <tr>
        <td>
            <center><p>   
               <?php //<!--Generates hyper reference to CatalogueEdit page--> 
                   $root = 'root';
                   if (array_key_exists("GroupId", $_GET))//TODO: переделать этот if - использовать GroupID
                   {
                       $lGroupId = $_GET["GroupId"];
                       // create instance of Catalogue:
                       $lCatalogue = new cCatalogue;
                       $lGroupName = $lCatalogue->GetGroupName($lGroupId);
                       echo "<A HREF='CatalogueEdit.php?GroupName=$lGroupName&GroupId=$lGroupId'>Edit Catalog</A>"; 
                   }
                   else
                   {
                       echo "<A HREF='CatalogueEdit.php?GroupName=$root'>Edit Catalog</A>"; //TODO: переделать эту ветку
                   }
               ?>
           </p></center>    
        </td>
        <td>
            <center><p>    
                <?php //<!--Generates hiper reference to OpinionEdit page-->
                    if (array_key_exists("GroupId", $_GET))
                    {
                        $lGroupid = $_GET["GroupId"];
                        echo "<A HREF='LeafEdit.php?GroupId=$lGroupId'>Write Your opinion and/or rewiew</A>"; 
                    }
                    else
                    {
                        echo "<A HREF='LeafEdit.php?GroupName=$root'>Write Ypur opinions and/or rewiew</A>"; //TODO: переделать эту ветку
                    }	
                ?>
            </p></center>
    </td>
        <td>
            <center><p><center><p>?</center></p></center>
        </td>
    </tr>
    <tr>
        <td>
            <center><p>?</p></center>
        </td>
        <td>
            <center><p>page icons</p></center>
        </td>
        <td>
            <center><p><center><p>?</p></center></p></center>
        </td>
    </tr>
<?php	
    include ('Bottom.php');	
?>