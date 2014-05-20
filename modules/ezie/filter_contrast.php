<?php
/**
 * File containing the contrast filter handler
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package ezie
 */
$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();
$value = $http->hasPostVariable( 'value' ) ? $http->variable( 'value' ) : 0;
$region = $prepare_action->hasRegion() ? $prepare_action->getRegion() : null;

$imageconverter = new eZIEezcImageConverter( eZIEImageFilterContrast::filter( $value, $region ) );

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
