<?php
/**
 * File containing the saturation tool handler
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package kernel
 * @todo Check if this is actually used/implemented
 */
$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();
if ( $http->hasPostVariable( "saturation" ) )
{
    $saturation = $http->variable("saturation");
}

eZIEImageToolSaturation::toolSaturation(
    $prepare_action->getImagePath(),
    $prepare_action->getNewImagePath(),
    $saturation
);

eZIEImageToolResize::doThumb(
    $prepare_action->getNewImagePath(),
    $prepare_action->getNewThumbnailPath()
);

echo (string)$prepare_action;
eZExecution::cleanExit();
?>
