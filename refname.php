<!DOCTYPE HTML>
<HTML>
 <HEAD>
  <title>   refname   </title>
  <link rel="stylesheet" href="style.css" type="text/css">
 </HEAD>

 <BODY>

<?php

    $name = 'Вася';
    $ref_name = $name;
    $ref_name = "Меня зовут $ref_name";
    echo $ref_name;
    echo $name;

?>


<?php

    $name = 'Вася';
    $ref_name = &$name;
    $ref_name = "Меня зовут $ref_name";
    echo $ref_name;
    echo $name;
?>




 </BODY>
</HTML>
