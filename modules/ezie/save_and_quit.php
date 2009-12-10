<?php

include_once 'kernel/common/template.php';

$prepare_action = new eZIEImagePreAction();
$imageId = $prepare_action->getImageId();
$imageVersion = $prepare_action->getImageVersion();

$imageAttribute = eZContentObjectAttribute::fetch($imageId,  $imageVersion);
// Save the class attribute
$imageHandler = $prepare_action->getImageHandler();
$imageHandler->initializeFromFile( $prepare_action->getAbsoluteImagePath(), false , false );
$imageHandler->store( $imageAttribute  ); // TODO: what's $contentobjectattribute (ask jerome) ?

// remove view cache if needed
eZContentCacheManager::clearObjectViewCacheIfNeeded( $prepare_action->getImageHandler()->attribute('id') );

// delete all the images in working directory
// delete working directory
$working_folder = eZDir::dirpath($prepare_action->getAbsoluteImagePath());

// deletes the working folder recursively
eZDir::recursiveDelete($working_folder);


// new attribute
$imageAttribute = eZContentObjectAttribute::fetch($imageId,  $imageVersion);

$Result = array();
$Result["pagelayout"] = false;

$tpl = templateInit();
$tpl->setVariable('ezie_ajax_response', true);
$tpl->setVariable('attribute', $imageAttribute);
$Result["content"] = $tpl->fetch("design:content/datatype/edit/ezimage.tpl");

?>
