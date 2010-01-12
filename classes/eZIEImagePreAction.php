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
class eZIEImagePreAction {
    private $image_path;
    private $image_id;
    private $image_version;
    private $history_version;
    private $key;
    private $original_image;
    private $working_folder;
    private $region;

    /**
     * @return unknown_type
     */
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

        // check if file exists (that will mean the data sent is correct)
        $absolute_image_path = eZSys::rootDir() . "/" . $this->image_path;
 
        $fs_handler = new eZFSFileHandler();
        if (!$fs_handler->fileExists($absolute_image_path)) {
            // TODO: manage error
            return;
        }

        $this->prepare_region();
    }

    /**
     * @return unknown_type
     */
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

    /**
     * @return unknown_type
     */
    public function hasRegion() {
        return $this->region !== null;
    }

    /**
     * @return unknown_type
     */
    public function getRegion() {
        return $this->region;
    }

    /**
     * @return unknown_type
     */
    public function getAbsoluteImagePath() { // var/ezie/{user_id}/{image_id}-{image_version}/{history_version}-
        return eZSys::rootDir() . "/" . $this->getImagePath();
    }

    /**
     * @return unknown_type
     */
    public function getImagePath() {
        return $this->image_path;
    }

    /**
     * @return unknown_type
     */
    public function getThumbnailPath() {
        return $this->working_folder . "/thumb-" . $this->getHistoryVersion() . "-"
            . $this->original_image->attributeFromOriginal('filename');
    }

    /**
     * @return unknown_type
     */
    public function getAbsoluteThumbnailPath() {
        return eZSys::rootDir() . "/" . $this->getThumbnailPath();
    }

    /**
     * @return unknown_type
     */
    public function getAbsoluteNewThumbnailPath() {
        return eZSys::rootDir() . "/" . $this->getNewThumbnailPath();
    }

    /**
     * @return unknown_type
     */
    public function getNewThumbnailPath() {
        return $this->working_folder . "/thumb-" . $this->getNewHistoryVersion() . "-"
            . $this->original_image->attributeFromOriginal('filename');
    }

    /**
     * @return unknown_type
     */
    public function getAbsoluteNewImagePath() {
        return eZSys::rootDir() . "/" . $this->getNewImagePath();
    }

    /**
     * @return unknown_type
     */
    public function getNewImagePath() {
        return $this->working_folder . "/"
            . $this->getNewHistoryVersion() . "-"
            . $this->original_image->attributeFromOriginal('filename');
    }

    /**
     * @return unknown_type
     */
    public function getVersion() {
        return $this->image_version;
    }

    /**
     * @return unknown_type
     */
    public function getHistoryVersion() {
        return $this->history_version;
    }

    /**
     * @return unknown_type
     */
    public function getNewHistoryVersion() {
        return $this->history_version + 1;
    }

    /**
     * @return unknown_type
     */
    public function responseArray() {
        return array( 'original' => $this->getNewImagePath(),
        'thumbnail' => $this->getNewThumbnailPath(),
        'history_version' => $this->getNewHistoryVersion()
        );
    }

    /**
     * @return unknown_type
     */
    public function getWorkingFolder() {
        return $this->working_folder;
    }

    /**
     * @return unknown_type
     */
    public function getAbsoluteWorkingFolder() {
        return eZSys::rootDir() . "/" . $this->working_folder;
    }

    /**
     * @return unknown_type
     */
    public function getImageHandler() {
        return $this->original_image;
    }

    /**
     * @return unknown_type
     */
    public function getImageId() {
        return $this->image_id;
    }

    /**
     * @return unknown_type
     */
    public function getImageVersion() {
        return $this->image_version;
    }
}

?>
