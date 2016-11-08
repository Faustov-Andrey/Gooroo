<?php
	include ('cCatalogue.php');
        header('Content-type: text/html; charset=utf-8');
	//include ('cLeaf.php');
	function AddNewLeafToGroup()
	{
            //Create instance of Catalogue
            $lCatalogue = new cCatalogue();

            //Create instance of Leaf
            $lLeaf = new cLeaf();
            if (array_key_exists("GroupId", $_POST))
            {
                $lGroupId = $_POST['GroupId'];
                echo ("   Name of group:   ");
                $lGroupName = $lCatalogue->GetGroupName($lGroupId);
                echo $lGroupName;
            }
            else
            {
                echo ("Group name abcent");
            }

            //Request Id of leaf
            echo ("   Request Id of leaf:   ");
            $lNewLeafId = $lLeaf->GetNewLeafId();
            echo ("   Id of new leaf:   ");
            echo $lNewLeafId;

            //Request order of leaf
            echo ("   Запрашиваем порядок для нового листа:   ");
            $lLeafOrder = $lLeaf->GetLeafOrger($lGroupId);
            echo ("   order of leaf:   ");
            echo $lLeafOrder;
            //Add new leaf:
            echo ("   Add new leaf:   ");
            //$lNewLeafId = ;
            //$lGroupId = ;
            $lParentLeafId = -1;//@TODO realyze
            $lAuthorId = 0;//@TODO realyze
            //$lLeafOrder = ;

            //@TODO realyze
            if (array_key_exists("NewOpinion", $_POST))
            {
                $lNewLeafOpinion = $_POST['NewOpinion'];
                echo ("   Opinion:   ");
                echo $lNewLeafOpinion;
            }
            else
            {
                echo ("Opinion abcent");
            }

            //@TODO realyze
            if (array_key_exists("Review", $_POST))
            {
                $lNewLeafReview = $_POST['Review'];
                echo ("   Review:   ");
                echo $lNewLeafReview;
            }
            else
            {
                echo ("Review abcent");
            }

            $lCreationDate = date("Y-m-d");
            echo ("   Дата:   ");echo $lCreationDate;
            $lProperties = "";//@TODO realyze
            $lNewLeafReviw = "";//@TODO realyze
            $lLeaf->AddLeaf($lNewLeafId, $lGroupId, $lParentLeafId, $lAuthorId, $lLeafOrder, $lNewLeafOpinion, $lNewLeafReviw, $lCreationDate, $lProperties);
            echo ("   Laef added!   ");	
            $_GET['GroupId'] = $_POST['GroupId'];

	}
	echo ("AddLeafEdit");

	AddNewLeafToGroup();
	include ('Catalogue.php');
?>