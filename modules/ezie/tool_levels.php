<?php

include_once 'kernel/common/template.php';

$Module = $Params["Module"];

$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();

$channels = array('r', 'g', 'b', 'a');
$thresholds = array();
foreach ($channels as $c) {
    if ($http->hasPostVariable($c)) {
        $thresholds[$c] = $http->variable($c);
    } else {
        $thresholds[$c] = 0.1;
    }
}

eZIEImageToolLevels::toolLevels($prepare_action->getAbsoluteImagePath(),
    $prepare_action->getAbsoluteNewImagePath(), $thresholds
);

eZIEImageToolResize::doThumb( $prepare_action->getAbsoluteNewImagePath(),
    $prepare_action->getAbsoluteNewThumbnailPath());


$tpl = templateInit();
$tpl->setVariable("result", $prepare_action->responseArray());

$Result = array();
$Result["pagelayout"] = false;
$Result["content"] = $tpl->fetch("design:ezie/ajax_responses/default_action_response.tpl");


?>
