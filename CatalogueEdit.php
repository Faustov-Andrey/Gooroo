<?php
	include ('Top.php');	
        require_once ('cCatalogue.php');
?>
    <tr>
       <td>
            <center><p>                
                <?php // <!--display the parent group to the current group-->
                        $GroupName = $_GET['GroupName'];
                        $lCatalogue = new cCatalogue();
                        $lGroupId = $lCatalogue->GetGroupId($GroupName);
                        //echo ("group Id".$lGroupId);
                        $lParentGroupId = $lCatalogue->GetParentIdByChildId($lGroupId);
                        //echo ("parent group Id".$lParentGroupId);
                        $lParentGroupName = $lCatalogue->GetGroupName($lParentGroupId);
                        $lNativeLangParentGroupName = $lCatalogue->GetNativeLangGroupName($lParentGroupId);
                        //echo ("parent group name".$lNativeLangGroupName);
                        echo "parent group   ";echo "<A HREF='Catalogue.php?GroupName=$lParentGroupName'>$lNativeLangParentGroupName</A></P></td>";
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
            <p><center>
                
                <?php // <!--display name of current group-->
                        $lGroupId = $_GET['GroupId'];
                        $lCatalogue = new cCatalogue();// create instance of cCatalogue
                        //$lGroupId = $lCatalogue->GetGroupId($GroupName);
                        $lNativeLangGroupName = $lCatalogue->GetNativeLangGroupName($lGroupId);
                        echo "<font size = 3 face = arial>Группа:   </font>"; 
                        echo "<font size = 4 color = blue face = arial>".$lNativeLangGroupName."</font>";
                ?>
            </center></p>
            <?php // <!--display subgroups of current group-->
                if (array_key_exists("GroupId", $_GET))
                {
                        // create instance of cCatalogue:
                        $lCatalogue = new cCatalogue;
                        //request group Id: 
                        $lGroupId = $_GET['GroupId'];
                        // request child groups:
                        print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                        $lCatalogue->GetSubgroupList($lGroupId);
                        print "</table>";
                }	
            ?>
        </td>
        <td>
            <table width=100% border=1 cellspacing=2 cellpadding=2>
                <tr>
                    <td colspan = "3">
                        <p><center>Fill the form and press "Add"</center></p>
                    </td>
                </tr>
                <tr>
                    <td width = 25%>
                        <center>?</center>
                    </td>
                    <td>
                        <center><p>
                            <form action="AddNewGroupToCatalogue.php" method="post">
                                <p>Parent Group ID:<input type="hidden" name="ParentGroupId" value=<?php echo $_GET["GroupId"]?> enabled><?php echo $_GET["GroupId"]?></p>
                                <p>Parent Group ID:<input type="hidden" name="ParentGroupName" value=<?php echo $_GET["GroupName"]?> enabled><?php echo $_GET["GroupName"]?></p>
                                <p>New Group Name in English: <input type="text" name="NewGroupName" /></p>
                                <p>New Group Name in Russion: <input type="text" name="NativeLangGroupName" /></p>
                                <p><input type="submit" value="Add"><input type="reset" value="Clear"></p>
                            </form>
                        </p></center>
                    </td>
                    <td width = 25%>
                            <center>?</center>
                    </td>
                </tr>
            </table>			
        </td>		
        <td>
            <center><p>?</p></center>
        </td>
    </tr>
    <tr>
        <td>
            
            <center><p>
            <?php //<!--Generates hyper reference to CatalogueEdit page А ЗАЧЕМ ЭТО ЗДЕСЬ!?!-->
//                if (array_key_exists("GroupId", $_GET))
//                {
//                        $lGroupId = $_GET["GroupId"];
//                        echo "<A HREF='CatalogueEdit.php?GroupName=$lGroupId'>Edit Catalog</A>"; 
//                }
//                else
//                {
//                        echo "<A HREF='CatalogueEdit.php?GroupName=$root'>Edit Catalog</A>"; 
//                }	
            ?>
                </p></center>
        </td>
            <td>
                <center><p>
                    <?php // <!--Generates hiper reference to OpinionEdit page-->
                        if (array_key_exists("GroupId", $_GET))
                        {
                            $lGroupId = $_GET["GroupId"];
                            echo "<A HREF='LeafEdit.php?GroupName=$lGroupId'>Write opinion and/of review</A>"; 
                        }
                        else
                        {
                            echo "<A HREF='LeafEdit.php?GroupName=$root'>Write opinion and/of review</A>"; 
                        }	
                    ?>
                </p></center>
        </td>
        <td>
            <center><p>?</p></center>
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