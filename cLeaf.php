<?php
    //require ('.php'); 
    header('Content-type: text/html; charset=utf-8');
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
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT leafable FROM Groups where group_id = (?)"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("i", $pGroupId)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lLeafbl);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $mLeafable = $lLeafbl;
            }
            // free memory
            $stmt->close();
            
//            //Old version
//            $result_set = $mysqli->query("SELECT leafable FROM Groups where group_id = '$pGroupId'"); // selecting rows from "Groups" table
//            $items = array(); // menu item array
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                    foreach ($line as $col_value) 
//                    {
//                            $mLeafable = $col_value;
//                    }
//            }    

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
                
                // подготавливаемый запрос, первая стадия: подготовка 
                if (!($stmt = $mysqli->prepare("SELECT leaf_id, group_id, parent_leaf_id, author_id, opinion, creation_date, liked_number, disliked_number, user_nickname FROM leaf, user where group_id = (?) and leaf.author_id = user.user_id"))) {
                    echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                // подготавливаемый запрос, вторая стадия: привязка и выполнение 
                if (!$stmt->bind_param("i", $pGroupId)) {
                    echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
                }
                // выполняю запрос
                if (!$stmt->execute()) {
                    echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
                }                
                // Определяю переменные для результата 
                $stmt->bind_result($lLfId, $lGrId, $lPrnLfId, $lAuthId, $lOpn, $lCrDt, $lLkdNum, $lDislkdNum, $lUserNickNm);                
                $mLeafList = NULL;
                $lCounter = 0;
                // Выбираю значения изрезалтсета
                while ($stmt->fetch()) 
                {   
                    $mLeaf = [
                                $lLfId, 
                                $lGrId, 
                                $lPrnLfId,
                                $lAuthId, 
                                $lOpn, 
                                $lCrDt,
                                $lLkdNum,
                                $lDislkdNum,
                                $lUserNickNm
                            ];
                    $mLeafList[$lCounter] = $mLeaf;
                    $lCounter = $lCounter + 1;
                }                
                if(count($mLeafList)==0){
                    $mLeafList[0] = [
                                        -1, 
                                        -1, 
                                        -1, 
                                        -1, 
                                        "отзывы отсутствуют", 
                                        "обзоры отсутствуют", 
                                        "2000.01.01",
                                        0,
                                        0,
                                        "Nemo"
                                    ];
                }
                // free memory
                $stmt->close();
                
//                //Old version
//                $result_set = $mysqli->query("SELECT leaf_id, group_id, parent_leaf_id, author_id, opinion, opinion, creation_date FROM leaf where group_id = '$pGroupId'"); // selecting rows from "Groups" table
//                $items = array(); // menu item array
//                $mLeafList = NULL;
//                $mCounter = 0;
//                while ($line = $result_set->fetch_assoc()) 
//                {
//                    $mLeaf = [
//                                $line["leaf_id"], 
//                                $line["group_id"], 
//                                $line["parent_leaf_id"], 
//                                $line["author_id"], 
//                                $line["opinion"], 
//                                $line["creation_date"]
//                            ];
//                    $mLeafList[$mCounter] = $mLeaf;
//                    $mCounter = $mCounter + 1;
//                    //echo "<tr><td bgcolor='#FFFFFF'><center>$lOpinion</center><br></td></tr>";//@TODO realyze
//                    //Deprecated?!!
//                    foreach ($line as $col_value) 
//                    {
//                            $lGroupId = $col_value;
//                    }	
//                }
//                if(count($mLeafList)==0){
//                    $mLeafList[0] = [
//                                        -1, 
//                                        -1, 
//                                        -1, 
//                                        -1, 
//                                        "отзывы отсутствуют", 
//                                        "обзоры отсутствуют", 
//                                        "2000.01.01"
//                                    ];
//                }
                
                return $mLeafList;

                //echo "This group couldn't have opinions and reviews";
            }	
        }

        //************************************************************************************************
        /**
         * Request from DB Id of gruop @TODO realize
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
            $lResul = NULL;
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT MAX(leaf_id) FROM leaf"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lLfId);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lResul = $lLfId;
            }
            // free memory
            $stmt->close();
            
//            // Old version
//            $result_set = $mysqli->query("SELECT MAX(leaf_id) FROM leaf"); // selecting rows from "leaf" table
//            $items = array(); // menu item array
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                    foreach ($line as $col_value) 
//                    {
//                             $lResul = $col_value;
//                    }
//            }    

            return $lResul + 1;
        }

        //************************************************************************************************
        /**
         * Request from DB order of new leaf
         */
        function GetLeafOrger($pGroupId) 
        {
            $lResul = NULL;
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT MAX(leaf_order) FROM leaf WHERE group_id = (?)"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("i", $pGroupId)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lLfOrd);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lResult = $lLfOrd;
            }
            // free memory
            $stmt->close();

//            // Old version 
//            $result_set = $mysqli->query("SELECT MAX(leaf_order) FROM leaf WHERE group_id = $pGroupId"); // selecting rows from "leaf" table
//            $items = array(); // menu item array
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                    foreach ($line as $col_value) 
//                    {
//                             $lResul = $col_value;
//                    }
//            }    

            return $lResul + 1;
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
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("INSERT INTO leaf (leaf_id, group_id, parent_leaf_id, author_id, leaf_order, opinion, creation_date, properties) VALUES ((?), (?), (?), (?), (?), (?), (?), (?))"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("iiiiisss", $pNewLeafId, $pGroupId, $pParentLeafId, $pAuthorId, $pLeafOrder, $pNewLeafOpinion, $pCreationDate, $pProperties)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // free memory
            $stmt->close();
            
//            //Old version
//            $result_set = $mysqli->query("INSERT INTO leaf (leaf_id, group_id, parent_leaf_id, author_id, leaf_order, opinion, creation_date, properties) VALUES ('$pNewLeafId', '$pGroupId', '$pParentLeafId', '$pAuthorId', '$pLeafOrder', '$pNewLeafOpinion', '$pCreationDate', '$pProperties')"); 

        }	
    }
?>
