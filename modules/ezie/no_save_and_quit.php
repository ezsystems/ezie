<?php

include_once 'kernel/common/template.php';

$prepare_action = new eZIEImagePreAction();

// delete all the images in working directory
// delete working directory

$working_folder = eZDir::dirpath($prepare_action->getAbsoluteImagePath());

// deletes the working folder recursively
eZDir::recursiveDelete($working_folder);

// TODO: delete the user directory if empty

$Result = array();
$Result["pagelayout"] = false;

$tpl = templateInit();
$Result["content"] = $tpl->fetch("design:ezie/ajax_responses/empty_json_response.tpl");

?>
