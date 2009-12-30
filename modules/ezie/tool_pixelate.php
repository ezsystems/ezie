<?php

include_once 'kernel/common/template.php';

$Module = $Params["Module"];

$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();

$region = null;
if ($http->hasVariable("selection")) { // TODO: change hasvariable to haspostvariable
    $s = $http->variable("selection");
    $region = array("x" => $s["x"],
            "y" => $s["y"],
            "w" => $s["w"],
            "h" => $s["h"]
    );
}
// retrieve image dimensions
$ezcanalyzer = new ezcImageAnalyzer($prepare_action->getAbsoluteImagePath());

$imageconverter = new eZIEezcImageConverter(eZIEImageToolPixelate::filter(
        $ezcanalyzer->data->width,
        $ezcanalyzer->data->height,
        $region
        )
);

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
