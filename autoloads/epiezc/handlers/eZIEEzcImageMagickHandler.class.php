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

    public function pixelate1() {
        $this->addFilterOption($this->getActiveRegerence(),
            '-resize',
            '10%'
        );
        $this->addFilterOption($this->getActiveRegerence(),
            '-resize',
            '1000%'
        );
    }

    public function pixelate($region = null) {
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
}

?>
