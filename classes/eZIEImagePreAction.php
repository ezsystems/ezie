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
    private $image_path;
    private $image_id;
    private $image_version;
    private $history_version;
    private $key;
    private $original_image;
    private $working_folder;
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

        $this->working_folder = eZSys::varDirectory() . "/ezie/" . $this->key;

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
     *
     * @return unknown_type
     */
    public function hasRegion()
    {
        return $this->region !== null;
    }

    /**
     *
     * @return unknown_type
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @note var/ezie/{user_id}/{image_id}-{image_version}/{history_version}-
     * @return unknown_type
     */
    public function getAbsoluteImagePath()
    {
        return eZSys::rootDir() . "/" . $this->getImagePath();
    }

    /**
     * Returns the image path
     * @return string
     */
    public function getImagePath()
    {
        return $this->image_path;
    }

    /**
     *
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
     *
     * @return string
     */
    public function getAbsoluteThumbnailPath()
    {
        return eZSys::rootDir() . "/" . $this->getThumbnailPath();
    }

    /**
     *
     * @return string
     */
    public function getAbsoluteNewThumbnailPath()
    {
        return eZSys::rootDir() . "/" . $this->getNewThumbnailPath();
    }

    /**
     *
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
     *
     * @return unknown_type
     */
    public function getAbsoluteNewImagePath()
    {
        return eZSys::rootDir() . "/" . $this->getNewImagePath();
    }

    /**
     *
     * @return unknown_type
     */
    public function getNewImagePath()
    {
        return $this->working_folder . "/"
         . $this->getNewHistoryVersion() . "-"
         . $this->original_image->attributeFromOriginal( 'filename' );
    }

    /**
     *
     * @return unknown_type
     */
    public function getVersion()
    {
        return $this->image_version;
    }

    /**
     *
     * @return unknown_type
     */
    public function getHistoryVersion()
    {
        return $this->history_version;
    }

    /**
     *
     * @return unknown_type
     */
    public function getNewHistoryVersion()
    {
        return $this->history_version + 1;
    }

    /**
     * Returns a JSON encoded version of the operation result
     * @return unknown_type
     */
    public function response()
    {
        $response = new eZIEJsonResponse();
        $response->original        = $this->getNewImagePath();
        $response->thumbnail       = $this->getNewThumbnailPath();
        $response->history_version = $this->getNewHistoryVersion();
        return $response;
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
     *
     * @return string
     */
    public function getWorkingFolder()
    {
        return $this->working_folder;
    }

    /**
     *
     * @return unknown_type
     */
    public function getAbsoluteWorkingFolder()
    {
        return eZSys::rootDir() . "/" . $this->working_folder;
    }

    /**
     *
     * @return unknown_type
     */
    public function getImageHandler()
    {
        return $this->original_image;
    }

    /**
     *
     * @return string
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     *
     * @return unknown_type
     */
    public function getImageVersion()
    {
        return $this->image_version;
    }
}

?>
