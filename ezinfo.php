<?php
/**
 * File containing the ezieInfo class
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezie
 */
class ezieInfo
{
    static function info()
    {
        $eZCopyrightString = 'Copyright (C) 1999-' . date('Y') . ' eZ Systems AS';

        return array(
            'Name' => '<a href="http://projects.ez.no/epie">eZ Image Editor</a>',
            'Version' => "0.1 (preview only)",
            'Author'	=> 'Stefano Ballabeni, Robin Boutros, Adrien Mogenet',
            'Copyright' => $eZCopyrightString,
            'License' => "GNU General Public License v2.0",
            'Includes the following third-party software' => array(
                'Name' => 'jQuery',
                'Version' => '1.3.2',
                'Copyright' => 'Copyright (c) 2009, jQuery Team. All rights reserved.',
                'License' => 'Licensed under the Gnu General Public License (GPL) Version 2'
            ),
            'Includes the following third-party software(2)' => array(
                'Name' => 'jQuery UI',
                'Version' => '1.7.2',
                'Copyright' => 'Copyright (c) 2009, PAUL BAKAUS AND THE JQUERY UI TEAM. All rights reserved.',
                'License' => 'Licensed under the Gnu General Public License (GPL) Version 2'
            ),
            'Includes the following third-party software(2)' => array(
                'Name' => 'Jcrop',
                'Version' => '0.9.8',
                'Copyright' => 'Copyright (c) 2008-2009 Deep Liquid Group. All rights reserved.',
                'License' => 'Licensed under the MIT License'
            ),
            'Requires the following libraries' => array( 'eZ Components' => 'http://ezcomponents.org/' ),
            'Depends on the follow extensions' => array( 'eZJSCore' => 'http://projects.ez.no/ezjscore' ),
        );
    }
}
?>