<?php

include_once 'kernel/common/template.php';

$Module = $Params["Module"];

$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();

if ($prepare_action->hasRegion()) {
    $imageconverter = new eZIEezcImageConverter(eZIEImageToolCrop::filter($prepare_action->getRegion()));
} else {
    // TODO: manage error (just return an empty response?)
}


$imageconverter->perform($prepare_action->getAbsoluteImagePath(),
    $prepare_action->getAbsoluteNewImagePath()
);

eZIEImageToolResize::doThumb( $prepare_action->getAbsoluteNewImagePath(),
    $prepare_action->getAbsoluteNewThumbnailPath());


$tpl = templateInit();
$tpl->setVariable("result", $prepare_action->responseArray());

$Result = array();
$Result["pagelayout"] = false;
$Result["content"] = $tpl->fetch("design:ezie/ajax_responses/default_action_response.tpl");

?>
