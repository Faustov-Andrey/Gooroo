<?php	
    include ('Top.php');
    
    function GetMenu($pItem, $pItems, $pChildrens, $lUserId) 
    {
        foreach ($pItems as $pItem) 
            {
                echo "<td><center>";
                if (!$pItem["parent_menu_id"]) echo printItem($pItem, $pItems, $pChildrens, $lUserId); // Output elements of upper level
                echo "</center></td>";
            }
    }
    
?>

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
                                    $lUserId = NULL;
                                    $lUserId = filter_input(INPUT_GET, 'UserId', FILTER_DEFAULT);
                                    if($lUserId == NULL)
                                    {
                                        $lUserId = 1;
                                    }
                                    GetMenu($item, $items, $childrens, $lUserId);
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


<div class="top_1">
    <div class="top_1_0">
        <center>?</center>
    </div>
    <div class="top_1_1">
        <center><p>page numbers</p></center>
    </div>
    <div class="top_1_2">
        <center><p>?</p></center>
    </div>
</div>
<div class="top_1">
   <div class="top_1_0">
       <center>
           <A HREF="Catalogue.php?GroupName=Root&GroupId=0&UserId=<?php echo $lUserId; ?>">[+]</A> <A HREF="Catalogue.php?GroupName=Root&GroupId=0&UserId=<?php echo $lUserId; ?>">Каталог</A> 
           <!-- @TODO UserId must be taken from Authorization page -->
       </center>
   </div>
   <div class="top_1_1">
       <center><p><img src=central_img.JPG width=800 height=500></p></center>
   </div>
   <div class="top_1_2">
       <center><p>news and advertysing</p></center>
   </div>
</div>

<div class="top_1">
    <div class="top_1_0">
        <center>?</center>
    </div>
    <div class="top_1_1">
        <center><p>page numbers</p></center>
    </div>
    <div class="top_1_2">
        <center><p>?</p></center>
    </div>
</div>

<div class="top_1">
    <div class="top_1_0">
        <center>?</center>
    </div>
    <div class="top_1_1">
        <center><p>icons of payment systems</p></center>
    </div>
    <div class="top_1_2">
        <center><p>?</p></center>
    </div>
</div>

<?php	
    include ('Bottom.php');	
?>
