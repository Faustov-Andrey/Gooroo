<?php
    require_once ('cLeaf.php');
    header('Content-type: text/html; charset=utf-8');
    // Catalog class.
    class cCatalogue 
    {
        // variable-members
        var $mGroup = array(2);
        var $mGroupList = array();
        var $mCounter;
        var $mEcho = "";    
        // method-members:

        //************************************************************************************************
        /**
        * Request from database name of group using Id.
        */
        function GetGroupName($pGroupId) 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            if ($pGroupId != -1)
            {
                // подготавливаемый запрос, первая стадия: подготовка 
                if (!($stmt = $mysqli->prepare("SELECT name FROM groups WHERE group_id = (?)"))) {
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
                $stmt->bind_result($lGrNm);                
                // Выбрать значения 
                while ($stmt->fetch()) {
                   $lGroupName = $lGrNm;
                }
                
//                //Old version                
//                $result_set = $mysqli->query("SELECT name FROM groups WHERE group_id = '$pGroupId'"); // selecting rows from "Groups" table
//                while ($line = $result_set->fetch_assoc()) 
//                {
//                    foreach ($line as $col_value) 
//                    {
//                        $lGroupName = $col_value;
//                    }
//                }
//                $result_set->close();
            }
            else
            {
                $lGroupName = "none";
            }   
            // free memory
            $stmt->close();
            
            //$stmt->close();
            
            //Если нужно использовать опции соединения.
            /*
            $mysqli = mysqli_init();
            if (!$mysqli) {
                die('mysqli_init failed');
            }

            if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
                die('Setting MYSQLI_INIT_COMMAND failed');
            }

            if (!$mysqli->real_connect('localhost', 'my_user', 'my_password', 'my_db')) {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            */    

            return $lGroupName;
        }

        //************************************************************************************************
        /**
        * Request from database name of group in native language using Id.
        */
        function GetNativeLangGroupName($pGroupId) 
        {
            $lGroupName = "";
            
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            if ($pGroupId != -1)
            {
                // подготавливаемый запрос, первая стадия: подготовка 
                if (!($stmt = $mysqli->prepare("SELECT native_lang_name FROM groups WHERE group_id = (?)"))) {
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
                $stmt->bind_result($lGrNm);                
                // Выбираю значения изрезалтсета
                while ($stmt->fetch()) {
                   $lGroupName = $lGrNm;
                }
                // free memory
                $stmt->close();

//                // Old version
//                // Select group ids 
//                $result_set = $mysqli->query("SELECT native_lang_name FROM groups WHERE group_id = '$pGroupId'"); // selecting rows from "Groups" table
//                while ($line = $result_set->fetch_assoc()) 
//                {
//                    foreach ($line as $col_value) 
//                    {
//                        $lGroupName = $col_value;
//                    }
//                }
//                $result_set->close();
            }else 
            {
                $lGroupName = "none";
            }
            
            return $lGroupName;
        } 

        //************************************************************************************************
        /**
        * Request from database Id of group using name.
        */
        function GetGroupId($pGroupName) 
        {
            $lGroupId = 0;
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT group_id FROM groups WHERE name = (?)"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("s", $pGroupName)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lGrId);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lGroupId = $lGrId;
            }
            // free memory
            $stmt->close();
            
//            //Old version
//            // Select group ids 
//            $result_set = $mysqli->query("SELECT group_id FROM groups WHERE name = '$pGroupName'"); // selecting rows from "Groups" table
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                foreach ($line as $col_value) 
//                {
//                    $lGroupId = $col_value;
//                }
//            }    
//            $result_set->close();
            return $lGroupId;
    }

        //************************************************************************************************
        /**
        * Request from DB all groups with partent_group_id = $pGroupId.
        */
        function GetSubgroupList($pGroupId) 
        {			
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT group_id, name, native_lang_name FROM groups WHERE group_id IN (SELECT group_id FROM groups_graph WHERE parent_group_id = (?))"))) {
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
            $stmt->bind_result($lGrId, $lGrNm, $lNativeLangGrNm);                
            $mGroupList = NULL;
            $lCounter = 0;
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {                
                $mGroup = [$lGrId, $lNativeLangGrNm];
                $mGroupList[$lCounter] = $mGroup;
                $lCounter = $lCounter + 1;
            }
            // free memory
            $stmt->close();
            
//            //Old version  
//            // Select group_id's and native_lang_name's 
//            $result_set = $mysqli->query("SELECT group_id, name, native_lang_name FROM groups WHERE group_id IN (SELECT group_id FROM groups_graph WHERE parent_group_id = '$pGroupId')"); // selecting rows from "groups_graph" table
//            $mGroupList = NULL;
//            $lCounter = 0;
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                $mGroup = [$line["group_id"], $line["native_lang_name"]];
//                $mGroupList[$lCounter] = $mGroup;
//                $lCounter = $lCounter + 1;
//            }
//            if(count($mGroupList)==0){
//                $mGroupList[0] = [-1 , "У выбранной группы отсутствуют подгруппы"];
//            }
//            $result_set->close();

            return $mGroupList;
        }

        //************************************************************************************************
        /**
        * Returns the ID of the parent group by the current group name.
        */
        function GetParentIdByChildName($pGroupName) 
        {
            $lGroupId = 0;
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT group_id FROM groups WHERE name = (?)"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("s", $pGroupName)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lGrId);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lGroupId = $lGrId;
            }
            // free memory
            $stmt->close();
            
//            //Old version
//            // Select group ids 
//            $result_set = $mysqli->query("SELECT group_id FROM groups WHERE name = '$pGroupName'"); // selecting rows from "Groups" table
//            //$items = array(); // menu item array
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                foreach ($line as $col_value) 
//                {
//                    $lGroupId = $col_value;					
//                }
//            }    
//            $result_set->close();
            $lParentGroupId = GetParentIdByChildId($lGroupId);
            return $lParentGroupId;

        }

        //************************************************************************************************
        /**
        * Returns the ID of the parent group by the current existing group Id.
        */
        function GetParentIdByChildId($pGroupId) 
        {
            $lParentGroupId = 0;
            
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
             
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT parent_group_id FROM groups_graph WHERE group_id = (?)"))) {
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
            $stmt->bind_result($lPrnGrId);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lParentGroupId = $lPrnGrId;
            }
            // free memory
            $stmt->close();

//            // Old version
//            // Select group ids 
//            $result_set = $mysqli->query("SELECT parent_group_id FROM groups_graph WHERE group_id = '$pGroupId'"); // selecting rows from "GroupGraph" table
//            //$items = array(); // menu item array
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                foreach ($line as $col_value) 
//                {
//                    $lParentGroupId = $col_value;					
//                }
//            }    
//            $result_set->close();
            
            return $lParentGroupId;
        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function GetNewGroupId() 
        {
            $lGroupId = 0;
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT max(group_id) FROM groups"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
//            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
//            if (!$stmt->bind_param("i", $pGroupId)) {
//                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
//            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lGrId);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lGroupId = $lGrId;
            }
            // free memory
            $stmt->close();
            
//            // Old version
//            // Select group ids 
//            $result_set = $mysqli->query("SELECT max(group_id) FROM groups"); // selecting rows from "Groups" table
//            //$items = array(); // menu item array
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                foreach ($line as $col_value) 
//                {
//                    $lGroupId = $col_value;					
//                }
//            }    
//            $result_set->close();
            
            return $lGroupId+1;
            
        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function GetGroupOrger($pParentGroupId) 
        {
            $lResult = 0;
            
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT MAX(group_order) FROM groups_graph WHERE parent_group_id = (?)"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("i", $pParentGroupId)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lGrOrd);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lResult = $lGrOrd;
            }
            // free memory
            $stmt->close();
            
//            //Old version
//            // Select group ids 
//            $result_set = $mysqli->query("SELECT MAX(group_order) FROM groups_graph WHERE parent_group_id = '$pParentGroupId'"); // selecting rows from "GroupGraph" table
//            //$items = array(); // menu item array
//            while ($line = $result_set->fetch_assoc()) 
//            {
//                foreach ($line as $col_value) 
//                {
//                   $lResult = $col_value;					
//                }
//            }    
//            $result_set->close();
            
            return $lResult;
        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function SetGraphLink($pParentGroupId, $pGroupId, $pOrder) 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            
                        // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("INSERT INTO groups_graph (parent_group_id, group_id, group_order, properties) VALUES ((?), (?), (?), '|2016-11-11|')"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("iii", $pParentGroupId, $pGroupId, $pOrder)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // free memory
            $stmt->close();
            
            
//            // Old version
//            // Insert link 
//            $result_set = $mysqli->query("INSERT INTO groups_graph (parent_group_id, group_id, group_order, properties) VALUES ($pParentGroupId, $pGroupId, $pOrder, '|2016-11-11|')"); 
//            //$result_set->close();
        }
        
        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function CheckUnicGrName($pNewGroupName, $pNativeLangNewGroupName) // @TODO использовать prepared statement
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Check that new name is UNIC!!! for THIS group
            $result_set = $mysqli->query("SELECT name FROM groups WHERE name = '$pNewGroupName'"); // selecting subgroup with coincidental names  
            while ($line = $result_set->fetch_assoc()) 
            {
                foreach ($line as $col_value) 
                {
                    $lResult = $col_value;
                    if($lResult == $pNewGroupName)
                    {
                        return $mEcho = "<center><p><font color = red size =  4> Подгруппа с таким англоязычным именем уже есть в этой группе. Выберете другое имя для подгруппы. </font></p></center>";
                    }
                }
            }
            $result_set = $mysqli->query("SELECT native_lang_name FROM groups WHERE native_lang_name = '$pNativeLangNewGroupName'"); // selecting subgroup with coincidental native_lang_names
            while ($line = $result_set->fetch_assoc()) 
            {
                foreach ($line as $col_value) 
                {
                    $lResult = $col_value;
                    if($lResult == $pNativeLangNewGroupName)
                    {
                        return $mEcho = "<center><p><font color = red size =  4> Подгруппа с таким именем на РУССКОМ языке уже есть в этой группе. Выберете другое имя для подгруппы. </font></p></center>";
                    }  
                }
            }
        }
        
        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function AddGroup($pNewGroupId, $pNewGroupName, $pNativeLangNewGroupName) // @TODO использовать prepared statement
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            //Request value of fild leafable and inherit it
            $lLeafable = 1;
            // Save group 
            $result_set = $mysqli->query("INSERT INTO groups (group_id, name, native_lang_name, leafable) VALUES ('$pNewGroupId', '$pNewGroupName', '$pNativeLangNewGroupName', $lLeafable);"); 
            //$result_set->close();
            
        }

        
        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function SetParentGroupByNames($pCildGroupName, $pParentGroupName) 
        {
            $this->name = $name; // @TODO realize
        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function SetParentGroupByIds($pCildGroupId, $pParentGroupId) 
        {
            $this->name = $name; // @TODO realize
        }
    }
?>

