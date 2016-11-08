<?php
    //include ('Top.php');
    include ('cCatalogue.php');
    header('Content-type: text/html; charset=utf-8');
    //Create instance of Catalogue
    $lCatalogue = new cCatalogue();

    // Request Id of parent group
    $lParentGroupName = $_POST['ParentGroupName'];
    $lParentGroupId = $_POST['ParentGroupId'];

    //Request new Id of parent group:
    $lNewGroupId = $lCatalogue->GetNewGroupId();
    $lNewGroupName = $_POST['NewGroupName'];
    $lNativeLangGroupName = $_POST['NativeLangGroupName'];

    //Add group
    $lEcho = $lCatalogue->AddGroup($lNewGroupId, $lNewGroupName, $lNativeLangGroupName); 
    echo $lEcho;
    //Request order of new group 
    $lGroupOrder = $lCatalogue->GetGroupOrger($lParentGroupId);

    //Save link in GroupGraph 
    $lCatalogue->SetGraphLink($lParentGroupId, $lNewGroupId, $lGroupOrder+1);

    $lParentGroupName = $_POST['ParentGroupName'];
    $_GET['GroupId'] = $_POST['ParentGroupId'];
    include ('Catalogue.php');
?>