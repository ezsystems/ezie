<?php
/**
 * File containing the eZIEImagePreAction class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */
class eZIEImagePreAction
{
    /**
     * @var string
     */
    private $image_path;

    /**
     * @var string
     */
    private $image_id;

    /**
     * @var int
     */
    private $image_version;

    /**
      * @var int
      */
    private $history_version;

    /**
     * @var string
     */
    private $key;

    /**
     * Original image object
     * @var eZContentObjectAttribute
     */
    private $original_image;

    /**
     * Image editor work folder
     * @var string
     */
    private $working_folder;

    /**
     * Region affected by the operation
     * @var array(int) Array of 4 integers, with w/h & x/y keys
     */
    private $region;

    /**
     * Constructor
     */
    public function __construct()
    {
        $http = eZHTTPTool::instance();
        //  @todo change hasVariable to hasPostVariable
        if ( !$http->hasVariable( 'key' ) || !$http->hasVariable( 'image_id' ) || !$http->hasVariable( 'image_version' ) || !$http->hasVariable( 'history_version' ) )
        {
            //  @todo manage errors
            return;
        }
        $this->key = $http->variable( 'key' );
        $this->image_id = $http->variable( 'image_id' );
        $this->image_version = $http->variable( 'image_version' );
        $this->history_version = $http->variable( 'history_version' );

        // retieve the attribute image
        $this->original_image = eZContentObjectAttribute::fetch(
            $this->image_id,
            $this->image_version )->attribute( 'content' );
        if ( $this->original_image === null )
        {
            //  @todo manage error (the image_id does not match any existing image)
            return;
        }

        // we could store the images in var/xxx/cache/public
        $this->working_folder = eZSys::cacheDirectory() . "/public/ezie/" . $this->key;

        $this->image_path =
            $this->working_folder . "/" .
            $this->history_version . "-" .
            $this->original_image->attributeFromOriginal( 'filename' );

        // check if file exists (that will mean the data sent is correct)
        $absolute_image_path = eZSys::rootDir() . "/" . $this->image_path;

        $handler = eZClusterFileHandler::instance();
        if ( !$handler->fileExists( $this->image_path ) )
        {
            // @todo manage error
            return;
        }

        $this->prepare_region();
    }

    /**
     *
     * @return unknown_type
     */
    private function prepare_region()
    {
        $region = null;

        $http = eZHTTPTool::instance();
         // @todo Change hasvariable to haspostvariable
        if ( $http->hasVariable( 'selection' ) )
        {
            $selection = $http->variable( 'selection' );
            if ( $selection['x'] >= 0 && $selection['y'] >= 0 && $selection['w'] > 0 && $selection['h'] > 0 )
            {
                $region = array(
                    'x' => intval( $selection['x'] ),
                    'y' => intval( $selection['y'] ),
                    'w' => intval( $selection['w'] ),
                    'h' => intval( $selection['h'] )
                );
            }
        }

        $this->region = $region;
    }

    /**
     * Checks if a region has been defined
     * @return bool
     */
    public function hasRegion()
    {
        return $this->region !== null;
    }

    /**
     * Region affected by the operations
     * @return array(int) Array with 4 keys: x/y & w/h
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Absolute path to the image file
     * @return unknown_type
     */
    public function getAbsoluteImagePath()
    {
        return eZSys::rootDir() . "/" . $this->getImagePath();
    }

    /**
     * Image file path
     * @note var/ezie/{user_id}/{image_id}-{image_version}/{history_version}-
     * @return string
     */
    public function getImagePath()
    {
        return $this->image_path;
    }

    /**
     * Path to the thumbnail
     * @return string
     */
    public function getThumbnailPath()
    {
        return $this->working_folder .
               "/thumb-" .
               $this->getHistoryVersion() .
               "-" .
               $this->original_image->attributeFromOriginal( 'filename' );
    }

    /**
     * Absolute path to the thumbnail
     * @return string
     */
    public function getAbsoluteThumbnailPath()
    {
        return eZSys::rootDir() . "/" . $this->getThumbnailPath();
    }

    /**
     * Absolute path to the new thumbnail version
     *
     * @return string
     */
    public function getAbsoluteNewThumbnailPath()
    {
        return eZSys::rootDir() . "/" . $this->getNewThumbnailPath();
    }

    /**
     * Path to the new thumbnail version
     * @return string
     */
    public function getNewThumbnailPath()
    {
        return $this->working_folder .
               "/thumb-" .
               $this->getNewHistoryVersion() .
               "-" .
               $this->original_image->attributeFromOriginal( 'filename' );
    }

    /**
     * Absolute path for the new image, based on the new history version
     *
     * @return string
     */
    public function getAbsoluteNewImagePath()
    {
        return eZSys::rootDir() . "/" . $this->getNewImagePath();
    }

    /**
     * Path for the new image, based on the new history version
     * @return string
     */
    public function getNewImagePath()
    {
        return $this->working_folder . "/"
         . $this->getNewHistoryVersion() . "-"
         . $this->original_image->attributeFromOriginal( 'filename' );
    }

    /**
     * Current version number
     * @return int
     */
    public function getVersion()
    {
        return $this->image_version;
    }

    /**
     * Current history version
     * @return unknown_type
     */
    public function getHistoryVersion()
    {
        return $this->history_version;
    }

    /**
     * Moves the version to the next one, and return its number
     *
     * @return int
     */
    public function getNewHistoryVersion()
    {
        return $this->history_version + 1;
    }

    /**
     * Formats the current response as a JSON string
     *
     * @return string The JSON encoded object
     */
    public function __toString()
    {
        $stringObject = new stdClass();

        $stringObject->image_url       = $this->getNewImagePath();
        $stringObject->thumbnail_url   = $this->getNewThumbnailPath();
        $stringObject->history_version = $this->getNewHistoryVersion();

        eZURI::transformURI( $stringObject->image_url, true );
        eZURI::transformURI( $stringObject->thumbnail_url, true );

        return json_encode( $stringObject );
    }

    /**
     * Current image editor work folder
     *
     * @return string
     */
    public function getWorkingFolder()
    {
        return $this->working_folder;
    }

    /**
     * Absolute path to the current image editor work folder
     *
     * @return string
     */
    public function getAbsoluteWorkingFolder()
    {
        return eZSys::rootDir() . "/" . $this->working_folder;
    }

    /**
     * Original image object
     * @return eZContentObjectAttribute
     */
    public function getImageHandler()
    {
        return $this->original_image;
    }

    /**
     * Image identifier
     * @return string
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * Current image version
     * @return int
     */
    public function getImageVersion()
    {
        return $this->image_version;
    }
}
?>