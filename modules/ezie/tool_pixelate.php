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

$imageconverter = new eZIEezcImageConverter(eZIEImageToolPixelate::filter($region));

if ($imageconverter->getConverter()->getHandler() instanceof eZIEEzcImageMagickHandler) {
// We need to use different filters for image magick than for GD.
    if (!$prepare_action->hasRegion()) {
        $imageconverter = new eZIEezcImageConverter(eZIEImageToolPixelate::filterImageMagick($region));

        $imageconverter->perform($prepare_action->getAbsoluteImagePath(),
            $prepare_action->getAbsoluteNewImagePath());
    }
    else {
    // step 1, crop the image and scale the cropped image down to 10% of its size
        $imageconverter = new eZIEezcImageConverter(eZIEImageToolPixelate::filterImageMagickRegionStep1($region));

        $imageconverter->perform($prepare_action->getAbsoluteImagePath(),
            $prepare_action->getAbsoluteNewImagePath()
        );
        // step 2, apply the small image as a watermark resizing it at the actual size
        $imageconverter = new eZIEezcImageConverter(eZIEImageToolPixelate::filterImageMagickRegionStep2($region,
            $prepare_action->getAbsoluteNewImagePath()));
        $imageconverter->perform($prepare_action->getAbsoluteImagePath(),
            $prepare_action->getAbsoluteNewImagePath()
        );
    }
}
else {
    $imageconverter->perform($prepare_action->getAbsoluteImagePath(),
        $prepare_action->getAbsoluteNewImagePath());
}

eZIEImageToolResize::doThumb( $prepare_action->getAbsoluteNewImagePath(),
    $prepare_action->getAbsoluteNewThumbnailPath());

$tpl = templateInit();
$tpl->setVariable("result", $prepare_action->responseArray());

$Result = array();
$Result["pagelayout"] = false;
$Result["content"] = $tpl->fetch("design:ezie/ajax_responses/default_action_response.tpl");

?>
