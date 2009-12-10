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
    eZIEezcImagePixelate{
    public function rotate($angle, $background) {
        $angle = intval($angle);
        if ( !is_int($angle) || $angle < 0 || $angle > 360) {
            throw new ezcBaseValueException( 'height', $height, 'int > 0 && int < 360' );
        }

        $this->addFilterOption(
            $this->getActiveReference(),
            '-rotate',
            $angle
        );
    }

    public function horizontalFlip($region = null) {
        $this->addFilterOption($this->getActiveReference(), '-flip');
    }

    public function verticalFlip($region = null) {
        $this->addFilterOption($this->getActiveReference(), '-flop');
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
        $this->addFilterOption($this->getActiveRegerence(),
            '-resize',
            '10%'
        );
        $this->addFilterOption($this->getActiveRegerence(),
            '-resize',
            '1000%'
        );
        if ($region) {
            $this->addFilterOption($this->getActiveRegerence(),
            '-region',
                $region["w"] . "x" . $region["h"]
            );
        }
    }
}

?>
