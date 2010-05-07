<?php
/**
 * File containing the eZIEImageFilterSepia class.
 * 
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */
class eZIEImageFilterSepia extends eZIEImageAction
{
    /**
     * Creates a sepia filter
     * 
     * @param array $ (int) $region Affected region, as a 4 keys array: x, y, w, h
     * @return array ( ezcImageFilter )
     */
    static function filter( $region = null )
    {
        return array(
            new ezcImageFilter( 
                'colorspace',
                array( 
                    'space' => ezcImageColorspaceFilters::COLORSPACE_SEPIA,
                    'region' => $region 
                ) 
            ) 
        );
    }
}

?>