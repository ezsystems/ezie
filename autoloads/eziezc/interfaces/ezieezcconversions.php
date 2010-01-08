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

/**
 * @author eZIE Team
 *
 */
interface eZIEEzcConversions {
	/**
	 * @param int $angle
	 * @param string $color
	 * @return void
	 */
	public function rotate($angle, $color = 'FFFFFF');
	
	/**
	 * @param int $width
	 * @param int $height
	 * @param int $region
	 * @return void
	 */
	public function pixelate($width, $height, $region = null);
	
	/**
	 * @param int[4] $region
	 * @return void
	 */
	public function horizontalFlip($region = null);
    
	/**
	 * @param int[4] $region
	 * @return void
	 */
	public function verticalFlip($region = null);
	
    /**
     * @param string $space
     * @param int[4] $region
     * @return void
     */
    public function colorspace($space, $region = null);
    
    /**
     * @param int $value
     * @return void
     */
    public function brightness($value);
    
    /**
     * @param int $value
     * @return void
     */
    public function contrast($value);
}
