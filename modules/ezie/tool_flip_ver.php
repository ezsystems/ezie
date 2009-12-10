<?php

include_once 'kernel/common/template.php';

$prepare_action = new eZIEImagePreAction();


$imageconverter = new eZIEezcImageConverter(eZIEImageToolFlipVer::filter());

$imageconverter->perform($prepare_action->getAbsoluteImagePath(),
    $prepare_action->getAbsoluteNewImagePath());

eZIEImageToolResize::doThumb( $prepare_action->getAbsoluteNewImagePath(),
    $prepare_action->getAbsoluteNewThumbnailPath());


$tpl = templateInit();
$tpl->setVariable("result", $prepare_action->responseArray());

$Result = array();
$Result["pagelayout"] = false;
$Result["content"] = $tpl->fetch("design:ezie/ajax_responses/default_action_response.tpl");


?>
