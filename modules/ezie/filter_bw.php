<?php
/**
 * File containing the black & white filter handler
 * 
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package kernel
 */
$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();

$region = null;
if ( $prepare_action->hasRegion() )
{
    $region = $prepare_action->getRegion();
}

$imageconverter = new eZIEezcImageConverter( eZIEImageFilterBW::filter( $region ) );

$imageconverter->perform(
    $prepare_action->getAbsoluteImagePath(),
    $prepare_action->getAbsoluteNewImagePath() 
);

eZIEImageToolResize::doThumb(
    $prepare_action->getAbsoluteNewImagePath(),
    $prepare_action->getAbsoluteNewThumbnailPath()
);

echo (string)$prepare_action;
eZExecution::cleanExit();
?>
