<?php
/**
 * File containing the eZIEImageFilterSepia class.
 * 
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
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