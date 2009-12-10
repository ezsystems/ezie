<?php

include_once 'kernel/common/template.php';

$Module = $Params["Module"];

$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();
if ($http->hasPostVariable("value")) {
    $value = $http->variable("value");
} else {
    $value = 1;
}

$imageconverter = new eZIEezcImageConverter(eZIEImageFilterBlur::filter($prepare_action->getRegion()));

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
