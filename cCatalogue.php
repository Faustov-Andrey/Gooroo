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
                $result_set = $mysqli->query("SELECT name FROM groups WHERE group_id = '$pGroupId'"); // selecting rows from "Groups" table
                while ($line = $result_set->fetch_assoc()) 
                {
                    foreach ($line as $col_value) 
                    {
                        $lGroupName = $col_value;
                    }
                }
            }
            else
            {
                $lGroupName = "none";
            }   
            
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
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            if ($pGroupId != -1)
            {
                // Select group ids 
                $result_set = $mysqli->query("SELECT native_lang_name FROM groups WHERE group_id = '$pGroupId'"); // selecting rows from "Groups" table
                while ($line = $result_set->fetch_assoc()) 
                {
                    foreach ($line as $col_value) 
                    {
                        $lGroupName = $col_value;
                    }
                }
            }
            else 
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
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            $result_set = $mysqli->query("SELECT group_id FROM groups WHERE name = '$pGroupName'"); // selecting rows from "Groups" table
            while ($line = $result_set->fetch_assoc()) 
            {
                foreach ($line as $col_value) 
                {
                    $lGroupId = $col_value;
                }
            }    

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
            // Select group_id's and native_lang_name's 
            $result_set = $mysqli->query("SELECT group_id, name, native_lang_name FROM groups WHERE group_id IN (SELECT group_id FROM groups_graph WHERE parent_group_id = '$pGroupId')"); // selecting rows from "groups_graph" table
            $mGroupList = NULL;
            $lCounter = 0;
            while ($line = $result_set->fetch_assoc()) 
            {
                $mGroup = [$line["group_id"], $line["native_lang_name"]];
                $mGroupList[$lCounter] = $mGroup;
                $lCounter = $lCounter + 1;
            }
            if(count($mGroupList)==0){
                $mGroupList[0] = [-1 , "У выбранной группы отсутствуют подгруппы"];
            }
            
            return $mGroupList;
        }

        //************************************************************************************************
        /**
        * Returns the ID of the parent group by the current group name.
        */
        function GetParentIdByChildName($pGroupName) 
        {
           // Connecting to DB
           $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
           if ($mysqli->connect_error) 
           {
               die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
           }
            $mysqli->set_charset("utf8");
            // Select group ids 
            $result_set = $mysqli->query("SELECT group_id FROM groups WHERE name = '$pGroupName'"); // selecting rows from "Groups" table
            //$items = array(); // menu item array
            while ($line = $result_set->fetch_assoc()) 
            {
                foreach ($line as $col_value) 
                {
                    $lGroupId = $col_value;					
                }
            }    

            $lParentGroupId = GetParentIdByChildId($lGroupId);
            return $lParentGroupId;

        }

        //************************************************************************************************
        /**
        * Returns the ID of the parent group by the current existing group Id.
        */
        function GetParentIdByChildId($pGroupId) 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            $result_set = $mysqli->query("SELECT parent_group_id FROM groups_graph WHERE group_id = '$pGroupId'"); // selecting rows from "GroupGraph" table
            //$items = array(); // menu item array
            while ($line = $result_set->fetch_assoc()) 
            {
                foreach ($line as $col_value) 
                {
                    $lParentGroupId = $col_value;					
                }
            }    

            return $lParentGroupId;
        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function GetNewGroupId() 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            $result_set = $mysqli->query("SELECT max(group_id) FROM groups"); // selecting rows from "Groups" table
            //$items = array(); // menu item array
            while ($line = $result_set->fetch_assoc()) 
            {
                foreach ($line as $col_value) 
                {
                    $lGroupId = $col_value;					
                }
            }    

             return $lGroupId+1;
            
        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function GetGroupOrger($pParentGroupId) 
        {
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            $result_set = $mysqli->query("SELECT MAX(group_order) FROM groups_graph WHERE parent_group_id = '$pParentGroupId'"); // selecting rows from "GroupGraph" table
            //$items = array(); // menu item array
            while ($line = $result_set->fetch_assoc()) 
            {
                foreach ($line as $col_value) 
                {
                   $lResult = $col_value;					
                }
            }    

            
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
            // Insert link 
            $result_set = $mysqli->query("INSERT INTO  groups_graph (parent_group_id, group_id, group_order, properties) VALUES ($pParentGroupId, $pGroupId, $pOrder, '|2015-11-07|')"); 

        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function AddGroup($pNewGroupId, $pNewGroupName, $pNativeLangNewGroupName) 
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
            
            // Save group 
            $result_set = $mysqli->query("INSERT INTO groups (group_id, name, native_lang_name, leafable) VALUES ('$pNewGroupId', '$pNewGroupName', '$pNativeLangNewGroupName', $lLeafable);"); 
            
        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function SetParentGroupByNames($pCildGroupName, $pParentGroupName) 
        {
            $this->name = $name;
        }

        //************************************************************************************************
        /**
        * @TODO Add description of the method
        */
        function SetParentGroupByIds($pCildGroupId, $pParentGroupId) 
        {
            $this->name = $name;
        }
    }
?>

