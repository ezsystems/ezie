<?php
/**
 * File containing the eZAutoloadGenerator class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package kernel
 * @author eZIE Team
 */
class eZIEezcImageConverter
{
    /**
     * @var ezcImageConverter
     */
    private $converter;

    /**
    * Instanciantes the image converter with a set of filters
    *
    * @param array(ezcImageFilter) $filter Filters to add to the image converter
    * @return void
    * @throws ezcBaseSettingValueException Error adding the transformation
    */
    public function __construct( $filter )
    {
        $ini = eZINI::instance( "image.ini" );
        // we use in priority image magick
        $hasImageMagick = $ini->variable( "ImageMagick", "IsEnabled" );

        if ( $hasImageMagick == "true" )
        {
            $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'ImageMagick', 'eZIEEzcImageMagickHandler' ) ) );
        }
        else
        {
            $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'GD', 'eZIEEzcGDHandler' ) ) );
        }

        $this->converter = new ezcImageConverter( $settings );

        $mimeType = array( 'image/jpeg', 'image/png' );

        $this->converter->createTransformation( 'transformation', $filter, $mimeType );
    }

    /**
    * Performs the ezcImageConverter transformation
    *
    * @param  string $src Source image
    * @param  string $dst Destination image
    * @return void
    */
    public function perform( $src, $dst )
    {
        // fetch the input file locally
        $inClusterHandler = eZClusterFileHandler::instance( $src );
        $inClusterHandler->fetch();

        try {
            $this->converter->transform( 'transformation', $src, $dst );
        }
        catch ( Exception $e )
        {
            $inClusterHandler->deleteLocal();
            throw $e;
        }

        // store the output file to the cluster
        $outClusterHandler = eZClusterFileHandler::instance();

        // @todo Check if the local output file can be deleted at that stage. Theorically yes.
        $outClusterHandler->fileStore( $dst, true );
    }

    /**
    * Returns the ezcImageConverter in use
    * @return ezcImageConverter
    */
    public function getConverter()
    {
        return $this->converter;
    }
}

?>
