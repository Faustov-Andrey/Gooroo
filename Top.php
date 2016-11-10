<?php
	require_once ('cMenu.php');
	//phpinfo(); exit;
        header('Content-type: text/html; charset=utf-8');
        
        function GetMenu($pItem, $pItems, $pChildrens) 
        {
            foreach ($pItems as $pItem) 
                {
                    echo "<td><center>";
                    if (!$pItem["parent_menu_id"]) echo printItem($pItem, $pItems, $pChildrens); // Output elements of upper level
                    echo "</center></td>";
                }
        }
        
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
            <title>   ***   GooRoo   ***   decision making help   ***   </title>
            <link rel="stylesheet" type="text/css" href="style.css">
            <!--
           
            -->
	</HEAD>
	<BODY>
            
            <div class="top_0">
                <div class="top_0_0">
                    <center><img src=gooroo.jpg width=200 height=60></center>
                </div>
                <div class="top_0_1">
                    <center><p>decision making help</p></center>
                </div>
                <div class="top_0_2">
                    <center><p>Banners and indicators</p></center>
                </div>
            </div>
            <div class="top_1">
                <div class="top_1_0">
                    <center>?</center>
                </div>
                <div class="top_1_1">
                    <center><p>
                        <div id="menu">
                            <table width=100% border=1 cellspacing=2 cellpadding=2><tr>
                            <ul>
                                <?php
                                    GetMenu($item, $items, $childrens);
                                ?>
                            </ul>
                            </tr></table>
                        </div>	
                    </p></center>
                </div>
                <div class="top_1_2">
                    <center><p>searcher</p></center>
                </div>
            </div>
            
