<?php 
/**
 * File containing the eZAutoloadGenerator class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */
$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();

$region = $prepare_action->hasRegion() ? $prepare_action->getRegion() : null;

$imageconverter = new eZIEezcImageConverter( eZIEImageToolFlipHor::filter( $region ) );

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
