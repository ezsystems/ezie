<?php
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: Ep Image Editor extension for eZ Publish
// SOFTWARE RELEASE: 0.1 (preview only)
// COPYRIGHT NOTICE: Copyright (C) 2009 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##

class eZIEImageToolPixelate extends eZIEImageAction {
    static function filter($region = null) {
        return (array(new ezcImageFilter(
        'pixelate',
        array(
        "region" => $region
        )
        )));
    }

    static function filterImageMagick($region = null) {
    // If no region is selected, we just
    // execute a scale down followed by a scale up
        $filters = array(new ezcImageFilter(
            'scalePercent',
            array(
            'width' => 10,
            'height' => 10,
            )), new ezcImageFilter(
            'scalePercent',
            array(
            'width' => 1000,
            'height' => 1000,
            ))
        );

        return $filters;
    }

    // creates a croped image scaled to 10% of its size
    static function filterImageMagickRegionStep1($region) {
        $filters = array(
            new ezcImageFilter(
            'crop',
            array(
            'x' => intval($region['x']),
            'y' => intval($region['y']),
            'width' => intval($region['w']),
            'height' => intval($region['h'])
            )),
            new ezcImageFilter(
            'scalePercent',
            array(
            'width' => 10,
            'height' => 10
            ))
        );

        return $filters;
    }

    // applies the small image as if it was a watermark, scaling it back to its
    // original size.
    static function filterImageMagickRegionStep2($region, $image) {
        $filters = array(
            new ezcImageFilter(
            'watermarkAbsolute',
            array('image' => $image,
            'posX' => intval($region['x']),
            'posY' => intval($region['y']),
            'width' => intval($region['w']),
            'height' => intval($region['h'])
            ))
        );
        return $filters;
    }
}

?>