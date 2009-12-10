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

class eZIEImagePreAction {
    private $image_path;
    private $image_id;
    private $image_version;
    private $history_version;
    private $key;
    private $original_image;
    private $working_folder;
    private $region;

    public function  __construct() {
        $http = eZHTTPTool::instance(); //(hasPostVariables hasVariable variable);

        // TODO: change hasVariable to hasPostVariable
        if ( !$http->hasVariable('key')
            || !$http->hasVariable('image_id')
            || !$http->hasVariable('image_version')
            || !$http->hasVariable('history_version')
        ) {
        // TODO: manage error
            return;
        }
        $this->key = $http->variable('key');
        $this->image_id = $http->variable('image_id');
        $this->image_version = $http->variable('image_version');
        $this->history_version = $http->variable('history_version');

        // retieve the attribute image
        $this->original_image = eZContentObjectAttribute::fetch( $this->image_id,
            $this->image_version )->attribute('content');
        if ($this->original_image === null) {
        // TODO: manage error (the image_id does not match any existing image)
            return;
        }

        $this->working_folder = eZSys::varDirectory() . "/ezie/" . $this->key;

        $this->image_path = $this->working_folder . "/"
            . $this->history_version . "-"
            . $this->original_image->attributeFromOriginal('filename');

        // check if file exists (that will mean the data sent if correct)
        $absolute_image_path = eZSys::rootDir() . "/" . $image_path;
 
        $fs_handler = new eZFSFileHandler();
        if (!$fs_handler->fileExists($absolute_image_path)) {
            // TODO: manage error
            return;
        }

        $this->prepare_region();
    }

    private function prepare_region() {
        $region = null;

        $http = eZHTTPTool::instance(); //(hasPostVariables hasVariable variable);

        if ($http->hasVariable("selection")) { // TODO: change hasvariable to haspostvariable
            $s = $http->variable("selection");
            if ($s['x'] >= 0
                && $s['y'] >= 0
                && $s['w'] > 0
                && $s['h'] > 0) {
                $region = array('x' => intval($s['x']),
                    'y' => intval($s['y']),
                    'w' => intval($s['w']),
                    'h' => intval($s['h'])
                );

            }
        }

        $this->region = $region;
    }

    public function hasRegion() {
        return $this->region !== null;
    }

    public function getRegion() {
        return $this->region;
    }

    public function getAbsoluteImagePath() { // var/ezie/{user_id}/{image_id}-{image_version}/{history_version}-
        return eZSys::rootDir() . "/" . $this->getImagePath();
    }

    public function getImagePath() {
        return $this->image_path;
    }

    public function getThumbnailPath() {
        return $this->working_folder . "/thumb-" . $this->getHistoryVersion() . "-"
            . $this->original_image->attributeFromOriginal('filename');
    }

    public function getAbsoluteThumbnailPath() {
        return eZSys::rootDir() . "/" . $this->getThumbnailPath();
    }

    public function getAbsoluteNewThumbnailPath() {
        return eZSys::rootDir() . "/" . $this->getNewThumbnailPath();
    }

    public function getNewThumbnailPath() {
        return $this->working_folder . "/thumb-" . $this->getNewHistoryVersion() . "-"
            . $this->original_image->attributeFromOriginal('filename');
    }

    public function getAbsoluteNewImagePath() {
        return eZSys::rootDir() . "/" . $this->getNewImagePath();
    }

    public function getNewImagePath() {
        return $this->working_folder . "/"
            . $this->getNewHistoryVersion() . "-"
            . $this->original_image->attributeFromOriginal('filename');
    }

    public function getVersion() {
        return $this->image_version;
    }

    public function getHistoryVersion() {
        return $this->history_version;
    }

    public function getNewHistoryVersion() {
        return $this->history_version + 1;
    }

    public function responseArray() {
        return array( 'original' => $this->getNewImagePath(),
        'thumbnail' => $this->getNewThumbnailPath(),
        'history_version' => $this->getNewHistoryVersion()
        );
    }

    public function getWorkingFolder() {
        return $this->working_folder;
    }

    public function getAbsoluteWorkingFolder() {
        return eZSys::rootDir() . "/" . $this->working_folder;
    }

    public function getImageHandler() {
        return $this->original_image;
    }

    public function getImageId() {
        return $this->image_id;
    }

    public function getImageVersion() {
        return $this->image_version;
    }
}

?>
