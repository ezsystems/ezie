<?php
/**
 * File containing the ezie no save & quit menu item handler
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package ezie
 */

$prepare_action = new eZIEImagePreAction();
$imageId = $prepare_action->getImageId();
$imageVersion = $prepare_action->getImageVersion();

$imageAttribute = eZContentObjectAttribute::fetch( $imageId, $imageVersion );

// Save the class attribute
$imageHandler = $prepare_action->getImageHandler();
$imageHandler->initializeFromFile( $prepare_action->getImagePath(), $imageHandler->attribute( 'alternative_text' ), $imageHandler->attribute( 'original_filename' ) );

// TODO: what's $contentobjectattribute (ask jerome) ?
$imageHandler->store( $imageAttribute );

// remove view cache if needed
eZContentCacheManager::clearObjectViewCacheIfNeeded( $imageAttribute->attribute( 'contentobject_id' ) );

// delete all the images in working directory
// delete working directory
$working_folder = eZDir::dirpath( $prepare_action->getImagePath() );

// deletes the working folder recursively
eZDir::recursiveDelete( $working_folder );

// new attribute
$imageAttribute = eZContentObjectAttribute::fetch( $imageId, $imageVersion );

// @todo Use proper JSON, but this will do for now.
$tpl = eZTemplate::factory();
$tpl->setVariable( 'ezie_ajax_response', true );
$tpl->setVariable( 'attribute', $imageAttribute );
echo $tpl->fetch( "design:content/datatype/edit/ezimage.tpl" );
eZExecution::cleanExit();
?>