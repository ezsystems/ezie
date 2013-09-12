<?php
/**
 * File containing the ezie/prepare view
 * This view prepares an image for edition, and returns its information as JSON
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */

$Module = $Params['Module'];
$Params = $Module->getNamedParameters();
$objectId     = (int)$Params['object_id'];
$editLanguage = (int)$Params['edit_language'];
$attributeID  = (int)$Params['attribute_id'];
$version      = (int)$Params['version'];

// Check for permissions
$contentObject = eZContentObject::fetch( $objectId );
if ( !$contentObject instanceOf eZContentObject || !$contentObject->canEdit( false, false, false, $editLanguage ) )
{
   die( '// @todo fixme :)' );
}
// retrieve the original image path
$img = eZContentObjectAttribute::fetch( $attributeID, $version )->attribute( 'content' );
$image_path = $img->attributeFromOriginal( 'url' );
$absolute_image_path = eZSys::rootDir() . "/{$image_path}";

// Creation of the editing arborescence
// /{cache folder}/public/ezie/user_id/image_id-version_id
$user = eZUser::instance();

$working_folder_path =
    eZSys::storageDirectory() . '/public/ezie/' .
    $user->id() . "/{$attributeID}-{$version}";
$working_folder_absolute_path = eZSys::rootDir() . "/{$working_folder_path}";

$handler = eZClusterFileHandler::instance();

if ( !$handler->fileExists( $working_folder_absolute_path ) )
{
    // @todo DB Based handlers have no knowledge of folders !
    $res = eZDir::mkdir( $working_folder_absolute_path, false, true );
}


// Copy the original file in the temp directory
// $work_folder/{history_id}-{file_name}
// (thumb: $working_folder/thumb_{history_id}-{file_name}
$file = "0-" . basename( $image_path );
$thumb = "thumb-{$file}";

// @todo Manage possible errors
$handler->fileCopy(
    $image_path,
    "{$working_folder_path}/{$file}"
);


// Creation of a thumbnail
eZIEImageToolResize::doThumb(
    "{$working_folder_path}/{$file}",
    "{$working_folder_path}/{$thumb}"
);
// retrieve image dimensions
$ezcanalyzer = new eZIEImageAnalyzer( "{$working_folder_path}/{$file}", false );


$object = new stdClass();

$imageURI = "{$working_folder_path}/{$file}";
eZURI::transformURI( $imageURI, true );


$thumbnailURI = "{$working_folder_path}/{$thumb}";
eZURI::transformURI( $thumbnailURI, true );

$moduleURI = 'ezie';
eZURI::transformURI( $moduleURI, false );

$object->thumbnail_url = $thumbnailURI;
$object->image_url = $imageURI;

// the key is the folder where the working image is stored
$object->key = $user->id() . "/{$attributeID}-{$version}";
$object->image_id = (int)$attributeID;
$object->image_version = (int)$version;
$object->history_version = 0;
$object->module_url = $moduleURI;
$object->image_width = (int)$ezcanalyzer->data->width;
$object->image_height = (int)$ezcanalyzer->data->height;
echo json_encode( $object );

eZExecution::cleanExit();

?>
