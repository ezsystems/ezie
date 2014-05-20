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

// @todo Use the cluster handler code

// delete all the images in working directory
// delete working directory
$working_folder = eZDir::dirpath( $prepare_action->getImagePath() );

// deletes the working folder recursively
eZDir::recursiveDelete($working_folder);

// @todo delete the user directory if empty

echo json_encode( new StdClass() );
eZExecution::cleanExit();
?>