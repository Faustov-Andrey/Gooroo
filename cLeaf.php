<?php
    //require ('.php'); 

    // Leaf class.
    class cLeaf 
    {
        // variable-members
        var $mLeafable;
        var $mLeaf = array();
        var $mLeafList = array();
        var $mCounter;
        // method-members:

        //************************************************************************************************
        /**
         * Request from DB data from fild leafable.
         */
        function IsLeafable($pGroupId) 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            $result_set = $mysqli->query("SELECT leafable FROM Groups where group_id = '$pGroupId'"); // selecting rows from "Groups" table
            $items = array(); // menu item array
            while ($line = $result_set->fetch_assoc()) 
            {
                    foreach ($line as $col_value) 
                    {
                            $mLeafable = $col_value;
                    }
            }    

            return $mLeafable;
        }

        //************************************************************************************************
        /**
         * Request from DB list of opinions linkt to the group
         */
        function GetLeafList($pGroupId) 
        {
            {
                // Connecting to DB
                $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
                if ($mysqli->connect_error) 
                {
                    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
                }
                $mysqli->set_charset("utf8");
                // Select group ids 
                $result_set = $mysqli->query("SELECT leaf_id, group_id, parent_leaf_id, author_id, opinion, review, creation_date FROM Leaf where group_id = '$pGroupId'"); // selecting rows from "Groups" table
                $items = array(); // menu item array
                $mLeafList = NULL;
                $mCounter = 0;
                while ($line = $result_set->fetch_assoc()) 
                {
                    $mLeaf = [
                                $line["leaf_id"], 
                                $line["group_id"], 
                                $line["parent_leaf_id"], 
                                $line["author_id"], 
                                $line["opinion"], 
                                $line["review"], 
                                $line["creation_date"]
                            ];
                    $mLeafList[$mCounter] = $mLeaf;
                    $mCounter = $mCounter + 1;
                    //echo "<tr><td bgcolor='#FFFFFF'><center>$lOpinion</center><br></td></tr>";//@TODO realyze
                    //Deprecated?!!
                    foreach ($line as $col_value) 
                    {
                            $lGroupId = $col_value;
                    }	
                }    
                
                if(count($mLeafList)==0){
                    $mLeafList[0] = [
                                        -1, 
                                        -1, 
                                        -1, 
                                        -1, 
                                        "отзывы отсутствуют", 
                                        "обзоры отсутствуют", 
                                        "2000.01.01"
                                    ];
                }
                return $mLeafList;

                //echo "This group couldn't have opinions and reviews";
            }	
        }

        //************************************************************************************************
        /**
         * Request from DB Id of gruop
         */
        function GetGroupId() 
        {
                        echo 'GetGroupId';
        }

        //************************************************************************************************
        /**
         * Request from DB Id of new leaf
         */
        function GetNewLeafId() 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            $result_set = $mysqli->query("SELECT MAX(leaf_id) FROM Leaf"); // selecting rows from "Leaf" table
            $items = array(); // menu item array
            while ($line = $result_set->fetch_assoc()) 
            {
                    foreach ($line as $col_value) 
                    {
                             $lResul = $col_value;
                    }
            }    

            return $lResul+1;
        }

        //************************************************************************************************
        /**
         * Request from DB order of new leaf
         */
        function GetLeafOrger($pGroupId) 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            $result_set = $mysqli->query("SELECT MAX(leaf_order) FROM Leaf WHERE group_id = $pGroupId"); // selecting rows from "Leaf" table
            $items = array(); // menu item array
            while ($line = $result_set->fetch_assoc()) 
            {
                    foreach ($line as $col_value) 
                    {
                             $lResul = $col_value;
                    }
            }    

            return $lResul+1;
        }

        //************************************************************************************************
        /**
         * Add new leaf to DB
         */
        function AddLeaf($pNewLeafId, $pGroupId, $pParentLeafId, $pAuthorId, $pLeafOrder, $pNewLeafOpinion, $pNewLeafReviw, $pCreationDate, $pProperties) 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Insert leaf 
            $result_set = $mysqli->query("INSERT INTO Leaf (leaf_id, group_id, parent_leaf_id, author_id, leaf_order, opinion, review, creation_date, properties) VALUES ('$pNewLeafId', '$pGroupId', '$pParentLeafId', '$pAuthorId', '$pLeafOrder', '$pNewLeafOpinion', '$pNewLeafReviw', '$pCreationDate', '$pProperties')"); 

        }	
    }
?>
