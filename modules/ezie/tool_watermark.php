<?php
/**
 * File containing the watermark tool handler
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package ezie
 */
$prepare_action = new eZIEImagePreAction();

$http = eZHTTPTool::instance();

if ( $prepare_action->hasRegion() && $http->hasPostVariable( 'watermark_image' ) )
{
    try{
        $imageconverter = new eZIEezcImageConverter(
            eZIEImageToolWatermark::filter(
                $prepare_action->getRegion(),
                $http->variable( 'watermark_image' )
            )
        );
    }
    catch( ezcBaseFileNotFoundException $e )
    {
        header( 'HTTP/1.0 500 Internal Server Error' );
        if( eZDebug::isDebugEnabled() )
        {
            echo $e->getMessage();
        }
        eZExecution::cleanExit();
    }
}
else
{
    // @todo Error handling
}

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
