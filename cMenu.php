<?php
    header('Content-type: text/html; charset=utf-8');
    // Connecting, choosing database
    $mysqli = new mysqli("localhost", "faust", "ioan", "iNDocsNet"); // connecting to DB
    if ($mysqli->connect_error) 
    {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    // Select group ids 
    $result_set = $mysqli->query("SELECT * FROM `menu`"); // selecting rows from "Menu" table
    $items = array(); // menu item array
    while ($line = $result_set->fetch_assoc()) 
    {
        $items[$line["menu_id"]] = $line; // fill the array by selected data
    }
    $childrens = array(); // Array of parent-childs mapping
    foreach ($items as $item) 
    {
        if ($item["parent_menu_id"] and !($item["parent_menu_id"] == 0)) $childrens[$item["menu_id"]] = $item["parent_menu_id"]; // Заполняем массив
    }

    //вывод пунктов меню с рекурсивным выбором
    function printItem($item, $items, $childrens) 
    {
        /* Output menu items */
        //echo "<li>";
        echo "<a href='".$item["link"]."'>".$item["native_lang_title"]."</a>";
        //echo "<a href='".$item["link"]."'>".$item["title"]."</a>";
        $ul = false; // Does child items were been output? 
        while (true) 
        {
            /* Endless cycle in which we find child elements */
            $key = array_search($item["menu_id"], $childrens); // Find child elements
            if (!$key) 
            {
                    /* Childs absent */
                    if ($ul) echo "</ul>"; // If child elements were outputed, then close list.
                    break; // Finishing cycle
            }
            unset($childrens[$key]); // Delete element found (to prevent double output) 
            if (!$ul) 
            {
                    echo "<ul>"; // Starting inner list, if no childs found yet
                    $ul = true; // Set the flag
            }
            echo printItem($items[$key], $items, $childrens); // Recursive deduce all child elements
        }
        //echo "</li>";
    }

    // Output top level menu items / вывод пунктов меню верхнего уровня.
    function topMenu($item, $items) 
    {
        //echo "<li>";
        echo "<a href='".$item["link"]."'>".$item["native_lang_title"]."</a>";

    }

    function subMenu() 
    {
            /* Output subgroup menu items */

    }

?>
