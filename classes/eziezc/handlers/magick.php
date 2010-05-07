<?php
/**
 * File containing the eZIEEzcImageMagickHandler class.
 *
 * Implements the methods used by the editor (rotate, flip, etc) for image magick.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */
class eZIEEzcImageMagickHandler extends ezcImageImagemagickHandler implements eZIEEzcConversions
{
    /**
    * Sets the filtering region
    *
    * @param array $ (int) $region Array of regions, with 4 keys: h+w & x+y
    * @return void
    */
    private function setRegion( $region )
    {
        if ( $region === null )
            return;

        $this->addFilterOption( $this->getActiveReference(),
            '-region',
            "{$region['w']}x{$region['h']}+{$region['x']}+{$region['y']}"
        );
    }

    /**
     * Adds a rotation filter
     *
     * @param int $angle Rotation angle, 0 <= angle <= 360
     * @param string $color
     * @return void
     */
    public function rotate( $angle, $background = 'FFFFFF' )
    {
        $angle = intval( $angle );
        if ( !is_int( $angle ) || ( $angle < 0 ) || ( $angle > 360 ) )
        {
            throw new ezcBaseValueException( 'height', $height, 'angle < 0 or angle > 360' );
        }

        $angle = 360 - $angle;
        $background = "#{$background}";

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

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#horizontalFlip($region)
     */
    public function horizontalFlip( $region = null )
    {
        $this->addFilterOption( $this->getActiveReference(), '-flop' );
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#verticalFlip($region)
     */
    public function verticalFlip( $region = null )
    {
        $this->addFilterOption( $this->getActiveReference(), '-flip' );
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#pixelate($width, $height, $region)
     */
    public function pixelate( $width, $height, $region = null )
    {
        $size = ceil( max( $width, $height ) / 42 );

        if ( $region === null )
        {
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
        $blur = ( $size * 3 ) . 'x' . ( $size * 4 );

        $i = $region['x'];

        $i_max = $region['w'] + $region['x'];
        $j_max = $region['h'] + $region['y'];

        for ( ; $i < $i_max; $i += $size )
        {
            $tmpRegion['x'] = $i;

            $j = $region['y'];
            for ( ; $j < $j_max; $j += $size )
            {
                $tmpRegion['y'] = $j;

                $this->setRegion( $tmpRegion );

                $this->addFilterOption( $activeReference,
                    '-blur',
                    $blur
                );
            }
        }
    }

    /*
     * Reimplementation of the very same function of the parent class
     * but without the restriction on the width.
     * See related issue: http://issues.ez.no/IssueView.php?Id=15976&
     *
     * @see lib/ezc/ImageConversion/src/handlers/ezcImageImagemagickHandler#scalePercent($width, $height)
     */
    public function scalePercent( $width, $height )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }

        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }
        $this->addFilterOption( $this->getActiveReference(),
            '-resize',
            "{$width}%x{$height}%"
        );
    }

    /* (non-PHPdoc)
     * @see lib/ezc/ImageConversion/src/handlers/ezcImageImagemagickHandler#colorspace($space)
     */
    public function colorspace( $space, $region = null )
    {
        $this->setRegion( $region );

        parent::colorspace( $space );
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#brightness($value)
     */
    public function brightness( $value, $region = null )
    {
        if ( $value < - 255 || $value > 255 )
        {
            throw new ezcBaseValueException( 'value', $value, 'int >= -255 && int <= 255' );
        }
        // 0 = -255
        // 50 = half as bright = -127
        // 100 = regular brightness = 0
        // 150 = 127
        // 200 = twice as bright = 255
        $value = ( 200 * ( $value + 255 ) ) / 512;

        $this->setRegion( $region );
        $this->addFilterOption( $this->getActiveReference(),
            '-modulate',
            $value
        );
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#contrast($value)
     */
    public function contrast( $value, $region = null )
    {
        if ( $value < - 100 || $value > 100 )
        {
            throw new ezcBaseValueException( 'value', $value, 'int >= -100 && int <= 100' );
        }

        $round_value = round( $value / 10 );

        if ( $round_value >= 0 )
        {
            $option = '-contrast';
        }
        else
        {
            $option = '+contrast';
            $round_value = - $round_value;
        }

        $this->setRegion( $region );
        for ( $i = 0; $i < $round_value; ++$i )
        {
            $this->addFilterOption(
                $this->getActiveReference(),
                $option
            );
        }
    }
}

?>
