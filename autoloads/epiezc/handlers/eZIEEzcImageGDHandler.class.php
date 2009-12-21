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

class eZIEEzcGDHandler extends ezcImageGdHandler
implements eZIEezcImageRotate,
eZIEezcImageFlip,
eZIEezcImagePixelate,
eZIEezcImageColorSpace {

// Apply a the filter on the specified region and return the new resource
    private function region($filter, $resource, $region, $colorspace = null) {
        $dest = imagecreatetruecolor($region["w"], $region["h"]);
        if (!imagecopy($dest, $resource, 0, 0, $region["x"], $region["y"], $region["w"], $region["h"])) {
            throw new ezcImageFilterFailedException( "1/ " . $function . ' applied on region ' . $region["x"] . "x" . $region["y"]);
        }
        if (!$colorspace) {
            $result = $this->$filter($dest);
        } else {
            $this->setActiveResource( $dest );
            parent::colorspace($colorspace);
            $result = $dest;
        }

        // do we need to create a new resource or is it ok to directly use $resource ? (in case of error ?)
        if (!imagecopy($resource, $result, $region["x"], $region["y"], 0, 0, $region["w"], $region["h"])) {
            throw new ezcImageFilterFailedException( "2/ " . $function . ' applied on region ' . $region["x"] . "x" . $region["y"]);
        }

        return $resource;
    }

    private function bgArrayFromHex($hex) {
        return array(
        'r' => hexdec(substr($hex, 0, 2)),
        'g' => hexdec(substr($hex, 2, 2)),
        'b' => hexdec(substr($hex, 4, 2)),
        'a' => 127
        );
    }

    ////////////////////////////////////////////////////

    public function colorspace($space, $region = null) {
        $resource = $this->getActiveResource();

        if ($region) {
            $newResource = $this->region(null, $resource, $region, $space);
        } else {
            parent::colorspace($space);
            return;
        }

        $this->setActiveResource( $newResource );
    }

    ////////////////////////////////////////////////////

    public function rotate($angle, $background = 'FFFFFF') {
        $angle = intval($angle);
        if ( !is_int($angle) || $angle < 0 || $angle > 360) {
            throw new ezcBaseValueException( 'height', $angle, 'int > 0 && int < 360' );
        }

        $resource = $this->getActiveResource();

        $bg = $this->bgArrayFromHex($background);
        $gdBackgroundColor = imagecolorallocatealpha($resource, $bg['r'], $bg['g'], $bg['b'], $bg['a']);

        $newResource  = ImageRotate($resource, $angle, $gdBackgroundColor);
        if ( $newResource === false ) {
            throw new ezcImageFilterFailedException( 'rotate', 'Rotation of image failed.' );
        }

        imagedestroy( $resource );
        $this->setActiveResource( $newResource );
    }

    public function verticalFlip($region = null) {
        $resource = $this->getActiveResource();

        $w = imagesx($resource);
        $h = imagesy($resource);

        $newResource = imagecreatetruecolor($w, $h);

        imagealphablending($newResource, false);
        imagesavealpha($newResource, true);

        $res = imagecopyresampled($newResource, $resource,
            0,  0,
            0, $h,
            $w, $h,
            $w, -$h);

        if ( $res === false ) {
            throw new ezcImageFilterFailedException( 'rotate', 'Rotation of image failed.' );
        }

        imagedestroy( $resource );
        $this->setActiveResource( $newResource );
    }

    ///////////////////////////////////////////////////////////
    // Horizontal flip

    private function horizontalFlipImg($resource) {
        $w = imagesx($resource);
        $h = imagesy($resource);

        $newResource = imagecreatetruecolor($w, $h);

        imagealphablending($newResource, false);
        imagesavealpha($newResource, true);

        $res = imagecopyresampled($newResource, $resource,
            0,  0,
            $w, 0,
            $w, $h,
            -$w, $h);

        if ( $res === false ) {
            throw new ezcImageFilterFailedException( 'rotate', 'Rotation of image failed.' );
        }

        imagedestroy( $resource );
        return $newResource;
    }
    public function horizontalFlip($region = null) {
        $resource = $this->getActiveResource();

        if ($region) {
            $newResource = $this->region("horizontalFlipImg", $resource, $region);
        } else {
            $newResource = $this->horizontalFlipImg($resource);
        }

        $this->setActiveResource( $newResource );
    }

    // End horizontal flip
    ///////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////
    // Pixelate

    private function pixelateImg($resource) {
        $w = imagesx($resource);
        $h =  imagesy($resource);

        $tmp_w = $w / 10;
        $tmp_h = $h / 10;

        $tmpResource = imagecreatetruecolor($tmp_w, $tmp_h);

        imagealphablending($tmpResource, false);
        imagesavealpha($tmpResource, true);

        $res = imagecopyresampled($tmpResource, $resource,
            0, 0,
            0, 0,
            $tmp_w, $tmp_h,
            $w, $h);

        if ( $res === false ) {
            throw new ezcImageFilterFailedException( 'pixelate', 'First part of pixelate failed.' );
        }
        imagedestroy($resource);

        $newResource = imagecreatetruecolor($w, $h);

        imagealphablending($newResource, false);
        imagesavealpha($newResource, true);

        $res = imagecopyresampled($newResource, $tmpResource,
            0, 0,
            0, 0,
            $w, $h,
            $tmp_w, $tmp_h);

        if ( $res === false ) {
            throw new ezcImageFilterFailedException( 'pixelate', 'Second part of pixelate failed.' );
        }

        imagedestroy( $tmpResource );
        return $newResource;
    }

    public function pixelate($region = null) {
        $resource = $this->getActiveResource();

        if ($region) {
            $newResource = $this->region("pixelateImg", $resource, $region);
        } else {
            $newResource = $this->pixelateImg($resource);
        }

        $this->setActiveResource( $newResource );
    }

    // End pixelate
    ///////////////////////////////////////////////////////////
    private function blurImg($resource, $truc) {
        $gaussian = array(array(1.0, 2.0, 1.0),
                                    array(2.0, 4.0 * $truc, 2.0),
                                    array(1.0, 2.0, 1.0));
        imageconvolution($image, $gaussian, 16, 0);

        return $resource;
    }

    public function blur($truc, $region = null) {
        $resource = $this->getActiveResource();

        if ($region) {
            $newResource = $this->region("blurImg", $resource, $tric, $region);
        } else {
            $newResource = $this->blurImg($resource, $truc);
        }

        $this->setActiveResource($newResource);
    }

    public function brightness($value) {
        $resource = $this->getActiveResource();

        if ($value < -255 || $value > 255) {
            throw new ezcBaseValueException( 'value', $value, 'int >= -255 && int <= 255' );
        }

        imagefilter($resource, IMG_FILTER_BRIGHTNESS, $value);
    }

    public function contrast($value) {
        $resource = $this->getActiveResource();

        if ($value < -100 || $value > 100) {
            throw new ezcBaseValueException( 'value', $value, 'int >= -100 && int <= 100' );
        }
        
        imagefilter($resource, IMG_FILTER_CONTRAST, $value);
    }
}
?>
