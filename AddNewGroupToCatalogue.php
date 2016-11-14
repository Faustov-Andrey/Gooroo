<?php
    //include ('Top.php');
    include ('cCatalogue.php');
    header('Content-type: text/html; charset=utf-8');
    //Create instance of Catalogue
    $lCatalogue = new cCatalogue();

    // Request Id of parent group
    //$lParentGroupName = $_POST['ParentGroupName'];
    $lParentGroupName = filter_input(INPUT_POST, 'ParentGroupName', FILTER_SANITIZE_ENCODED);
        
    //$lParentGroupId = $_POST['ParentGroupId'];
    $lParentGroupId = filter_input(INPUT_POST, 'ParentGroupId', FILTER_SANITIZE_ENCODED);
        
    //Request new Id of parent group:
    $lNewGroupId = $lCatalogue->GetNewGroupId();
    //$lNewGroupName = $_POST['NewGroupName'];
    $lNewGroupName = filter_input(INPUT_POST, 'NewGroupName', FILTER_SANITIZE_ENCODED);
    //$lNativeLangGroupName = $_POST['NativeLangGroupName'];
    $lNativeLangGroupName = filter_input(INPUT_POST, 'NativeLangGroupName', FILTER_SANITIZE_ENCODED);
    
    $check = NULL;
    $check = $lCatalogue->CheckUnicGrName($lNewGroupName, $lNativeLangGroupName);
    if ($check == NULL)
    {
        //Add group
        $lEcho = $lCatalogue->AddGroup($lNewGroupId, $lNewGroupName, $lNativeLangGroupName); 
        echo $lEcho;
        //Request order of new group 
        $lGroupOrder = $lCatalogue->GetGroupOrger($lParentGroupId);
        //Save link in GroupGraph 
        $lCatalogue->SetGraphLink($lParentGroupId, $lNewGroupId, $lGroupOrder+1);
    }
    //$lParentGroupName = $_POST['ParentGroupName'];
    $_GET['GroupId'] = filter_input(INPUT_POST, 'ParentGroupId', FILTER_SANITIZE_ENCODED);
    include ('Catalogue.php');
?>