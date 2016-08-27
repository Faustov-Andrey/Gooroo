<?php
    require_once ('cCatalogue.php');
    include ('Top.php');	
?>
<tr>
    <!--display the parent group to the current group-->
    <td><center><p>
        <?php
            $lCatalogue = new cCatalogue();
            $lGroupId = $_GET['GroupId'];
            //echo ("group Id".$lGroupId);
            $lParentGroupId = $lCatalogue->GetParentIdByChildId($lGroupId);
            //echo ("parent group Id".$lParentGroupId);
            $lParentGroupName = $lCatalogue->GetGroupName($lParentGroupId);
            $lNativeLangParentGroupName = $lCatalogue->GetNativeLangGroupName($lParentGroupId);
            //echo ("name of parent group".$lNativeLangGroupName);
            echo "Parent group:   ";
            echo "<A HREF='Catalogue.php?GroupName=$lParentGroupName&GroupId=$lParentGroupId'>$lNativeLangParentGroupName</A>";

        ?>
    </p></center></td>
    <td>
            <center><p>page icons</p></center>
    </td>
    <td>
            <center><p>?</p></center>
    </td>
</tr>
<tr> 
    <td>
        <!-- in this cell display current group and her subgroups  -->
        <p>
            <center>
                <!-- display name of current group -->
                <?php
                    $lCatalogue = new cCatalogue();
                    $lGroupId = $_GET['GroupId'];
                    $lGroupName = $lCatalogue->GetGroupName($lGroupId);//для блока стр. 73-79
                    $lNativeLangGroupName = $lCatalogue->GetNativeLangGroupName($lGroupId);
                    echo "<font size = 3 face = arial>Группа:   </font>"; 
                    echo "<font size = 4 color = blue face = arial>".$lNativeLangGroupName."</font>";
                ?>
            </center>
        </p>

        <!--display subgroups of current group-->
        <?php	//этот блок Нужен?
            if (array_key_exists("GroupId", $_GET))
            {
                // create instance of cCatalogue:
                $lCatalogue = new cCatalogue;
                //request group Id: 
                $lGroupId = $_GET['GroupId'];
                //request child groups:
                print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                $lCatalogue->GetSubgroupList($lGroupId);
                    print "</table>";
            }	
            //забыл уже зачем этот блок !!!
            if (array_key_exists("ParentGroupName", $_POST))
            {
                // create instance of cCatalogue:
                $lCatalogue = new cCatalogue;
                //request group Id: 
                $GroupId = $lCatalogue->GetGroupId($_POST["ParentGroupName"]);
                //request child groups:
                print "<table width=100% border=1 cellspacing=2 cellpadding=2>";
                $lCatalogue->GetSubgroupList($GroupId);
                print "</table>";
            }	
        ?>		
        <td>
            <center>
                <p>
                    <form action="AddNewLeaf.php" method="post">
                        <p>GroupId:<input type="text" name="GroupName" value=<?php echo $lNativeLangGroupName?>></p>
                        <p>GroupId:<input type="text" name="GroupId" value=<?php echo $_GET["GroupId"]?>></p>
                        <p>Comment<Br>
                                <textarea name="NewOpinion" cols="50" rows="5"></textarea>
                        </p>
                        <p><input type="submit"/></p>
                    </form>
                </p>
            </center>
        </td>
        <td>
            <center><p>News advertysing and other</p></center>
        </td>
    </td>    
</tr>
<tr>
    <td>
        <center>
            <p> <!--Generates hyper reference to CatalogueEdit page--> 
                <?php  
                    if (array_key_exists("GroupId", $_GET))
                    {
                            $GroupId = $_GET["GroupId"];
                            echo "<A HREF='CatalogueEdit.php?GroupId=$GroupId'>Edit Catalog</A>"; 
                    }
                    else
                    {
                            echo "<A HREF='CatalogueEdit.php?GroupId=0'>Edit Catalog</A>"; 
                    }
                ?>
            </p>
        </center>
    </td>
    <td>
        <center>
            <p>?</p>
        </center>
    </td>
    <td>
            <center><p>?</p></center>
    </td>
</tr>
<tr>
        <td>
                <center><p>page icons</p></center>

        </td>
        <td>
                <center><p>?</p></center>
        </td>
        <td>
                <center><p><center><p>?</p></center></p></center>
        </td>
</tr>
	
<?php	
	include ('Bottom.php');	
?>