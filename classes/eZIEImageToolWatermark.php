<?php
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Image Editor extension for eZ Publish
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
class eZIEImageToolWatermark  extends eZIEImageAction {
         /**
          * @param $region
          * @param $image
          * @return unknown_type
          */
         public static function filter($region, $image) {
             // the watermark images are in ezie/design/standard/images/watermarks
             // TODO: use ini file for image paths instead
             $img_path = realpath(dirname(__FILE__)."/../design/standard/images/watermarks") . "/" . $image;

             // retrieve image dimensions
            $ezcanalyzer = new ezcImageAnalyzer($img_path);

            // percentage of the watermark original size to use
            $pc =  $region['w'] / $ezcanalyzer->data->width;

            return array(new ezcImageFilter(
                                'watermarkAbsolute',
                                array('image' => $img_path,
                                    'posX' => $region['x'],
                                    'posY' => $region['y'],
                                    'width' => intval($region['w']),
                                    'height' => intval($region['h'])
                                )));
         }
}

?>
