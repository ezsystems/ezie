<?php
/**
 * File containing the eZIEImageToolFlipHor class.
 * 
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package ezie
 */
class eZIEImageToolFlipHorizontally extends eZIEImageAction
{
    /**
     * Creates a horizontal flip filter
     * @param  array(int) $region Affected region, as an array of 4 keys: w, h, x, y
     * @return array( ezcImageFilter )
     */
    static function filter( $region = null )
    {
        return array(
            new ezcImageFilter( 
                'horizontalFlip',
                array( 
                    'region' => $region 
                )
            )
        );
    }
}

?>