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

class eZIEEzcImageMagickHandler extends ezcImageImagemagickHandler
implements eZIEezcImageRotate,
eZIEezcImageFlip,
eZIEezcImagePixelate {

    private function setRegion($region) {
        if ($region === null)
            return;

        $this->addFilterOption($this->getActiveReference(),
                '-region',
                $region["w"] . "x" . $region["h"].'+' . $region['x'] . '+' . $region['y']
        );
    }

    public function rotate($angle, $background = 'FFFFFF') {
        $angle = intval($angle);
        if ( !is_int($angle) || $angle < 0 || $angle > 360) {
            throw new ezcBaseValueException( 'height', $height, 'int > 0 && int < 360' );
        }

        $angle = 360 - $angle;
        $background = '#' . $background;

        $this->addFilterOption(
                $this->getActiveReference(),
                '-background',
                $background
        );

        $this->addFilterOption(
                $this->getActiveReference(),
                '-rotate',
                $angle
        );
    }

    public function horizontalFlip($region = null) {
        $this->addFilterOption($this->getActiveReference(), '-flop');
    }

    public function verticalFlip($region = null) {
        $this->addFilterOption($this->getActiveReference(), '-flip');
    }

    public function pixelate($width, $height, $region = null) {
        $size = ceil(max($width, $height) / 42);

        if ($region === null) {
            $region = array(
                    'x' => 0,
                    'y' => 0,
                    'w' => $width,
                    'h' => $height
            );
        }

        $tmpRegion = array(
                'x' => $region['x'],
                'y' => $region['y'],
                'w' => $size,
                'h' => $size
        );

        $activeReference = $this->getActiveReference();
        $blur = ($size * 3).'x'.($size * 4);

        $i = $region['x'];

        $i_max = $region['w'] + $region['x'];
        $j_max = $region['h'] + $region['y'];

        for (; $i < $i_max; $i += $size) {
            $tmpRegion['x'] = $i;

            $j = $region['y'];
            for (; $j < $j_max; $j += $size) {
                $tmpRegion['y'] = $j;

                $this->setRegion($tmpRegion);

                $this->addFilterOption($activeReference,
                        '-blur',
                        $blur
                );
            }
        }

    }

    /*
     * Reimplementation of the very same function of the parent class
     * but withou the restriction on the width.
     * See related issue: http://issues.ez.no/IssueView.php?Id=15976&
    */
    public function scalePercent( $width, $height ) {
        if ( !is_int( $height ) || $height < 1 ) {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }

        if ( !is_int( $width ) || $width < 1) {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }
        $this->addFilterOption(
                $this->getActiveReference(),
                '-resize',
                $width.'%x'.$height.'%'
        );
    }

    public function colorspace($space, $region = null) {
        $this->setRegion($region);

        parent::colorspace($space);
    }

    public function brightness($value) {
        if ($value < -255 || $value > 255) {
            throw new ezcBaseValueException( 'value', $value, 'int >= -255 && int <= 255' );
        }

        // 0 = -255
        // 50 = half as bright = -127
        // 100 = regular brightness = 0
        // 150 = 127
        // 200 = twice as bright = 255
        $value = (200 * ($value + 255)) / 512;

        $this->addFilterOption(
                $this->getActiveReference(),
                '-modulate',
                $value
        );
    }

    public function contrast($value) {
        if ($value < -100 || $value > 100) {
            throw new ezcBaseValueException( 'value', $value, 'int >= -100 && int <= 100' );
        }

        $round_value = round($value / 10);

        if ($round_value >= 0) {
            $option = '+contrast';
        } else {
            $option = '-contrast';
            $round_value = -$round_value;
        }

        for ($i = 0; $i < $round_value; ++$i) {
            $this->addFilterOption(
                    $this->getActiveReference(),
                    $option
            );
        }
    }
}

?>
