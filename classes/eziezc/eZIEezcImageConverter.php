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
        $imageINI = eZINI::instance( 'image.ini' );

        // we get an array of handlers, where order of entries in array gives priority
        // for each entry, we need to check if the matching handler is enabled, and this has to be manual
        $imageHandlers = $imageINI->variable( 'ImageConverterSettings', 'ImageConverters' );
        foreach( $imageHandlers as $imageHandler )
        {
            switch( $imageHandler )
            {
                case 'ImageMagick':
                {
                    $hasImageMagick = ( $imageINI->variable( 'ImageMagick', 'IsEnabled' ) == 'true' );
                    if ( $hasImageMagick )
                        break 2;
                } break;

                // GD2 is required for the image editor
                // @todo Make the image editor degrade as nicely as possible if GD is not bundled
                case 'GD':
                {
                    $hasGD2 =
                        $imageINI->variable( 'GD', 'IsEnabled' ) == 'true' &&
                        $imageINI->variable( 'GDSettings', 'HasGD2' == 'true' );
                    if ( $hasGD2 )
                        break 2;
                } break;
            }
        }

        if ( $hasImageMagick )
        {
            // we need to use the ImageMagick path configured in the image.ini file
            $executable = $imageINI->variable( 'ImageMagick', 'Executable' );

            if ( eZSys::osType() == 'win32' && $imageINI->hasVariable( 'ImageMagick', 'ExecutableWin32' ) )
                $executable = $imageINI->variable( 'ImageMagick', 'ExecutableWin32' );
            else if ( eZSys::osType() == 'mac'  && $imageINI->hasVariable( 'ImageMagick', 'ExecutableMac' ) )
                $executable = $imageINI->variable( 'ImageMagick', 'ExecutableMac' );
            else if ( eZSys::osType() == 'unix' && $imageINI->hasVariable( 'ImageMagick', 'ExecutableUnix' ) )
                $executable = $imageINI->variable( 'ImageMagick', 'ExecutableUnix' );
            if ( $imageINI->hasVariable( 'ImageMagick', 'ExecutablePath' ) )
                $executable = $imageINI->variable( 'ImageMagick', 'ExecutablePath' ) . eZSys::fileSeparator() . $executable;
            // @todo Remove if ezc indeed do it automatically
            // if ( eZSys::osType() == 'win32' )
            //    $executable = "\"$executable\"";

            $imageHandlerSettings = new ezcImageHandlerSettings(
                'ImageMagick', 'eZIEEzcImageMagickHandler',
                array( 'binary' => $executable )
            );
            $settings = new ezcImageConverterSettings( array( $imageHandlerSettings ) );
        }
        else
        {
            $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'GD', 'eZIEEzcGDHandler' ) ) );
        }

        $this->converter = new ezcImageConverter( $settings );

        $mimeType = $imageINI->variable( 'OutputSettings', 'AllowedOutputFormat' );

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
    * Active ezcImageConverter
    * @return ezcImageConverter
    */
    public function getConverter()
    {
        return $this->converter;
    }
}

?>
