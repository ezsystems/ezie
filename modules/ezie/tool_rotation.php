<?php

include_once 'kernel/common/template.php';

$Module = $Params["Module"];

$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();
if ($http->hasVariable("angle")) { // TODO: change hasvariable to haspostvariable
    $angle = $http->variable("angle");
} else {
    $angle = 0;
}
if ($http->hasVariable("color")) { // TODO: change hasvariable to haspostvariable
    $color = $http->variable("color");
} else {
    $color = 'FFFFFF';
}

if ($http->hasVariable("clockwise") && $http->variable('clockwise') == 'yes') { // TODO: change hasvariable to haspostvariable
    $angle = 360 - intval($angle);
}

$imageconverter = new eZIEezcImageConverter(eZIEImageToolRotation::filter($angle, $color));

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
