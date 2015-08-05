<?php
/**
 * File containing the eZIEImageToolWatermark class.
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
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
        // the watermark images could be in any extension in a subfolder design/*/images/watermarks
        $img_path = realpath( self::eZImage( "watermarks/" . $image ));

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
     * Mimic the ezimage() template operator and find a file that matches the given name
     *
     * @param string $filename
     * @return string the full filepath
     */
    private static function eZImage( $filename )
    {
        $sys = eZSys::instance();
        $skipSlash = true;
        if ( $skipSlash && strlen( $sys->wwwDir() ) !== 0 ) {
            $skipSlash = false;
        }

        $bases = eZTemplateDesignResource::allDesignBases();
        $triedFiles = array();
        $fileInfo = eZTemplateDesignResource::fileMatch( $bases, 'images', $filename, $triedFiles );

        if ( !$fileInfo ) {
            eZLog::write( __METHOD__ . " : Image '$filename' does not exist in any design", 'error.log' );
            eZLog::write( __METHOD__ . " : Tried files: " . implode( ', ', $triedFiles ), 'error.log' );
            $siteDesign = eZTemplateDesignResource::designSetting( 'site' );
            $imgPath = "design/$siteDesign/images/$filename";
        } else {
            $imgPath = $fileInfo['path'];
        }

        return htmlspecialchars( $skipSlash ? $imgPath : $sys->wwwDir() . '/' . $imgPath );
    }

}
?>
