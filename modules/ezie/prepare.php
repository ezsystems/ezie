<?php
/**
 * File containing the ezie/prepare view
 * This view prepares an image for edition, and returns its information as JSON
 * 
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */

$Module = $Params["Module"];
$Params = $Module->getNamedParameters();
// TODO: make sure it's an actual image class node id ?
// retrieve the original image path
$NodeId = $Params['node_id'];
$Version = $Params['version'];

$img = eZContentObjectAttribute::fetch( $NodeId, $Version )->attribute( 'content' );
$image_path = $img->attributeFromOriginal( 'url' );
$absolute_image_path = eZSys::rootDir() . "/" . $image_path;
// TODO: Check for editing rights
// Creation of the editing arborescence
// /{var folder}/ezie/user_id/image_id-version_id
$user = eZUser::instance();

$working_folder_path = eZSys::varDirectory() . "/ezie/"
 . $user->id() . "/" . $NodeId . "-" . $Version;
$working_folder_absolute_path = eZSys::rootDir() . "/" . $working_folder_path;

$fs_handler = new eZFSFileHandler();

if ( !$fs_handler->fileExists( $working_folder_absolute_path ) )
{
    // TODO: manage errors
    $res = eZDir::mkdir( $working_folder_absolute_path, false, true );
}
// Copy the original file in the temp directory
// $work_folder/{history_id}-{file_name}
// (thumb: $working_folder/thumb_{history_id}-{file_name}
$file = "0-" . basename( $image_path );
$thumb = "thumb-" . $file;
// TODO: manage possible errors
$fs_handler->fileCopy( $absolute_image_path,
    $working_folder_absolute_path . "/" . $file );
// Creation of a thumbnail
eZIEImageToolResize::doThumb( $working_folder_absolute_path . "/" . $file,
    $working_folder_absolute_path . "/" . $thumb );
// retrieve image dimensions
$ezcanalyzer = new ezcImageAnalyzer( $working_folder_path . "/" . $file );

$object = new stdClass();

$imageURI = "$working_folder_path/$file";
eZURI::transformURI( $imageURI, true );

$thumbnailURI = "$working_folder_path/$thumb";
eZURI::transformURI( $thumbnailURI, true );

$moduleURI = 'ezie';
eZURI::transformURI( $moduleURI, false );

$object->thumbnail_url = $thumbnailURI;
$object->image_url = $imageURI;
// the key is the folder where the working image is stored
$object->key = $user->id() . "/{$NodeId}-{$Version}";
$object->image_id = (int)$NodeId;
$object->image_version = (int)$Version;
$object->history_version = 0;
$object->module_url = $moduleURI;
$object->image_width = (int)$ezcanalyzer->data->width;
$object->image_height = (int)$ezcanalyzer->data->height;
echo json_encode( $object );

eZExecution::cleanExit();

?>
