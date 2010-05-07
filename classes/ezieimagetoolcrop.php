<?php
/**
 * File containing the eZIEImageToolCrop class.
 * 
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */
class eZIEImageToolCrop extends eZIEImageAction
{
    /**
    * Creates a crop filter
    * 
    * @param  array(int) $region Affected region, as a 4 keys array: w, h, x, y
    * @return array( ezcImageFilter )
    */
    public static function filter( $region )
    {
        $r = array(
            'x'      => intval( $region['x'] ),
            'y'      => intval( $region['y'] ),
            'width'  => intval( $region['w'] ),
            'height' => intval( $region['h'] ) 
        );
        return array( new ezcImageFilter( 'crop', $r ) );
    }
}

?>
