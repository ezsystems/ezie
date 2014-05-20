<?php
/**
 * File containing the rotation tool handler
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package kernel
 */
$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();

// @todo change hasvariable to haspostvariable
$angle = $http->hasVariable( 'angle' ) ? $http->variable( 'angle' ) : 0;
$color = $http->hasVariable( 'color' ) ? $http->variable( 'color' ) : 'FFFFFF';

// @todo change hasvariable to haspostvariable
if ( $http->hasVariable( 'clockwise' ) && $http->variable( 'clockwise' ) == 'yes' )
{
    $angle = 360 - intval( $angle );
}

$imageconverter = new eZIEezcImageConverter( eZIEImageToolRotation::filter( $angle, $color ) );

$imageconverter->perform(
    $prepare_action->getImagePath(),
    $prepare_action->getNewImagePath()
);

eZIEImageToolResize::doThumb(
    $prepare_action->getNewImagePath(),
    $prepare_action->getNewThumbnailPath()
);

echo (string)$prepare_action;
eZExecution::cleanExit();
?>
