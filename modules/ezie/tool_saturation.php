<?php

include_once 'kernel/common/template.php';

$Module = $Params["Module"];

$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();
if ($http->hasPostVariable("saturation")) {
    $saturation = $http->variable("saturation");
}

eZIEImageToolSaturation::toolSaturation($prepare_action->getAbsoluteImagePath(),
    $prepare_action->getAbsoluteNewImagePath(), $saturation
);

eZIEImageToolResize::doThumb( $prepare_action->getAbsoluteNewImagePath(),
    $prepare_action->getAbsoluteNewThumbnailPath());

$tpl = templateInit();
$tpl->setVariable("result", $prepare_action->responseArray());

$Result = array();
$Result["pagelayout"] = false;
$Result["content"] = $tpl->fetch("design:ezie/ajax_responses/default_action_response.tpl");


?>
