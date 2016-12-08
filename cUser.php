<?php
    //require ('.php'); 
    header('Content-type: text/html; charset=utf-8');
    // Leaf class.
    class cUser 
    {
        // variable-members
        var $mUser = array();
        var $mUserList = array();
        var $mCounter;
        // method-members:

        //************************************************************************************************
        /**
         * Request from DB data from fild leafable.
         */
        function IsRegistredUser($pUserNickNm, $pUserPW) 
        {
            $lResult = NULL;
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT user_id FROM user WHERE user_nickname = (?) AND user_pw = (?)"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("ss", $pUserNickNm, $pUserPW)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lUserId);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lResult = $lUserId;
            }
            // free memory
            $stmt->close();
            
            return $lResult;
        }

        
        //************************************************************************************************
        /**
         * Request from DB data from fild leafable.
         */
        function CheckUnickUserNick($pUserNickNm) 
        {
            $lResult = NULL;
            // Connecting to DB
            $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
            if ($mysqli->connect_error) 
            {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");
            // Select group ids 
            
            // подготавливаемый запрос, первая стадия: подготовка 
            if (!($stmt = $mysqli->prepare("SELECT user_id FROM user WHERE user_nickname = (?)"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("s", $pUserNickNm)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lUserId);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lResult = $lUserId;
            }
            // free memory
            $stmt->close();
            
            return $lResult;
        }
        
        //************************************************************************************************
        /**
         * Request from DB list of opinions linkt to the group
         */
        function GetUserListOnDate($pRegDate) 
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
                if (!($stmt = $mysqli->prepare("SELECT user_id, user_name, user_nickname, user_pw, user_email, user_phone, user_ip, reg_date, reg_time  FROM user WHERE reg_date = (?)"))) {
                    echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                // подготавливаемый запрос, вторая стадия: привязка и выполнение 
                if (!$stmt->bind_param("i", $pRegDate)) {
                    echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
                }
                // выполняю запрос
                if (!$stmt->execute()) {
                    echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
                }                
                // Определяю переменные для результата 
                $stmt->bind_result($lUsrId, $lUsrNm, $lUsrNckNm, $lUserPw, $lUserEMl, $lUserPhn, $lUserIP, $lRegDt, $lRegTm);                
                $mUserList = NULL;
                $lCounter = 0;
                // Выбираю значения изрезалтсета
                while ($stmt->fetch()) 
                {   
                    $mUser = [
                                $lUsrId, 
                                $lUsrNm, 
                                $lUsrNckNm,
                                $lUserPw, 
                                $lUserEMl, 
                                $lUserPhn, 
                                $lUserIP, 
                                $lRegDt,
                                $lRegTm
                            ];
                    $mUserList[$lCounter] = $mUser;
                    $lCounter = $lCounter + 1;
                }                
                if(count($mUserList)==0){
                    $mLeafList[0] = [
                                        -1, 
                                        "absent", 
                                        "absent", 
                                        "absent", 
                                        "absent", 
                                        "absent", 
                                        "absent", 
                                        "absent", 
                                        "2000.01.01",
                                        "2000.01.01 00:00:00"
                                    ];
                }
                // free memory
                $stmt->close();
                
                return $mLeafList;

            }	
        }

        //************************************************************************************************
        /**
         * Request from DB user data
         */
        function GetUserOnNickName($pUserNickName, $pUserPw) 
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
                if (!($stmt = $mysqli->prepare("SELECT user_id, user_name, user_nickname, user_pw, user_email, user_phone, user_ip, reg_date, reg_time  FROM user WHERE user_nickname = (?) AND user_pw = (?)"))) {
                    echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                // подготавливаемый запрос, вторая стадия: привязка и выполнение 
                if (!$stmt->bind_param("ss", $pUserNickName, $pUserPw)) {
                    echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
                }
                // выполняю запрос
                if (!$stmt->execute()) {
                    echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
                }                
                // Определяю переменные для результата 
                $stmt->bind_result($lUsrId, $lUsrNm, $lUsrNckNm, $lUserPw, $lUserEMl, $lUserPhn, $lUserIP, $lRegDt, $lRegTm);                
                // Выбираю значения изрезалтсета
                while ($stmt->fetch()) 
                {   
                    $mUser = [
                                $lUsrId, 
                                $lUsrNm, 
                                $lUsrNckNm,
                                $lUserPw, 
                                $lUserEMl, 
                                $lUserPhn, 
                                $lUserIP, 
                                $lRegDt,
                                $lRegTm
                            ];
                    
                }                
                if(count($mUserList)==0){
                    $mUser = [
                                -1, 
                                "absent", 
                                "absent", 
                                "absent", 
                                "absent", 
                                "absent", 
                                "absent", 
                                "absent", 
                                "2000.01.01",
                                "2000.01.01 00:00:00"
                            ];
                }
                // free memory
                $stmt->close();
                
                return $mUser;

            }	
        }
        
        //************************************************************************************************
        /**
         * Request from DB user nickname on user ID
         */
        function GetUserNickNameOnId($pUserId) 
        {
            {
                $lUserNickname = NULL;
                // Connecting to DB
                $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsnet"); // connecting to DB
                if ($mysqli->connect_error) 
                {
                    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
                }
                $mysqli->set_charset("utf8");                
                
                // подготавливаемый запрос, первая стадия: подготовка 
                if (!($stmt = $mysqli->prepare("SELECT user_nickname FROM user WHERE user_id = (?)"))) {
                    echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                // подготавливаемый запрос, вторая стадия: привязка и выполнение 
                if (!$stmt->bind_param("i", $pUserId)) {
                    echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
                }
                // выполняю запрос
                if (!$stmt->execute()) {
                    echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
                }                
                // Определяю переменные для результата 
                $stmt->bind_result($lUsrNckNm);                
                // Выбираю значения изрезалтсета
                while ($stmt->fetch()) 
                {   
                    $lUserNickname = $lUsrNckNm;                    
                }                
                
                
                return $lUserNickname;

            }	
        }
        
        
        //************************************************************************************************
        /**
         * Request from DB list of user's opinions @TODO realize
         */
        function GetLeafListOnUserId() 
        {
                        echo 'GetList';
        }        

        //************************************************************************************************
        /**
         * Request from DB Id of new leaf
         */
        function GetNewUserId() 
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
            if (!($stmt = $mysqli->prepare("SELECT MAX(user_id) FROM user"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // Определяю переменные для результата 
            $stmt->bind_result($lUsrId);                
            // Выбираю значения изрезалтсета
            while ($stmt->fetch()) {
               $lResul = $lUsrId;
            }
            // free memory
            $stmt->close();
            
            return $lResul + 1;
        }


        //************************************************************************************************
        /**
         * Add new leaf to DB
         */
        function AddUser($lUserId, $lUserName, $lUserNickName, $lUserPw, $lUserEMail, $lUserPhone, $lUserIP, $lRegDate, $lRegTime, $pProperties) 
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
            if (!($stmt = $mysqli->prepare("INSERT INTO user (user_id, user_name, user_nickname, user_pw, user_email, user_phone, user_ip, reg_date, reg_time, properties) VALUES ((?), (?), (?), (?), (?), (?), (?), (?), (?), (?))"))) {
                echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            // подготавливаемый запрос, вторая стадия: привязка и выполнение 
            if (!$stmt->bind_param("isssssssss", $lUserId, $lUserName, $lUserNickName, $lUserPw, $lUserEMail, $lUserPhone, $lUserIP, $lRegDate, $lRegTime, $pProperties)) {
                echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
            }
            // выполняю запрос
            if (!$stmt->execute()) {
                echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
            }                
            // free memory
            $stmt->close();

        }	
    }
?>
