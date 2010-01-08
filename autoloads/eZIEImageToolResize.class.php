<?php
/**
 * @package eZ Image Editor
 * @version 1.0alpha
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

class eZIEImageToolResize extends eZIEImageAction {
    static function filter($w, $h) {
        return (array(new ezcImageFilter(
        'scale',
        array(
        'width' => intval($w),
        'height' => intval($h),
        'direction' => ezcImageGeometryFilters::SCALE_BOTH
        ))));
    }

    static function resize($src, $dst, $w, $h) {
        $imageconverter = new eZIEezcImageConverter(self::filter($h, $w));
        $imageconverter->perform($src, $dst);
    }

    static function doThumb($src, $dst) {
        self::resize($src, $dst, 250, 250);
    }
}
?>
