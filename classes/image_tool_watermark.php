<?php
/**
 * File containing the eZIEImageToolWatermark class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */
class eZIEImageToolWatermark extends eZIEImageAction
{
    /**
     * Watermark filter.
     * Adds the $image watermark at the $region location
     *
     * @param  array $region array with 'x' and 'y' keys
     * @param  string $image Image file name, will be searched in the ezie design folder
     * @return array(ezcImageFilter)s
     */
    public static function filter( $region, $image )
    {
        $img_path = self::findWatermark( $image );

        // retrieve image dimensions
        $analyzer = new ezcImageAnalyzer( $img_path );

        // percentage of the watermark original size to use
        $pc = $region['w'] / $analyzer->data->width;

        return array(
            new ezcImageFilter(
                'watermarkAbsolute',
                array(
                    'image'  => $img_path,
                    'posX'   => $region['x'],
                    'posY'   => $region['y'],
                    'width'  => intval( $region['w'] ),
                    'height' => intval( $region['h'] )
                )
            )
        );
    }

    /**
     * Looks for $imageFileName in each extension watermark repository
     * defined in image.ini and returns its complete path
     *
     * @param string $imageFileName		Watermark file name
     * @return string					Watermark file path
     * @throws ezcBaseFileNotFoundException
     */
    public static function findWatermark( $imageFileName )
    {
        $path = eZURLOperator::eZImage( eZTemplate::factory(), 'watermarks/' . $imageFileName, 'ezimage', true );
        if( file_exists( $path ) )
        {
            return $path;
        }

        eZDebug::writeWarning( 'Could not find watermark ' . $imageFileName, __METHOD__ );
        throw new ezcBaseFileNotFoundException( $imageFileName, 'image' );
    }
}
?>