<?php

class eZIEImageToolWatermark  extends eZIEImageAction {
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
