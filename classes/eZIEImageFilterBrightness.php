<?php
/**
 * File containing the eZIEImageFilterBrightness class.
 * 
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */
class eZIEImageFilterBrightness extends eZIEImageAction
{
    /**
     * Creates a brightness filter
     * 
     * @param int $value Brightness value
     * 
     * @return array( ezcImageFilter )
     */
    static function filter( $value = 0 )
    {
        return array(
            new ezcImageFilter( 
                'brightness',
                array( 'value' => $value )
            )
        );
    }
}
?>