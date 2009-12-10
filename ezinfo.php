<?php
// SOFTWARE NAME: Image Editor
// SOFTWARE RELEASE: @@@VERSION@@@
// COPYRIGHT NOTICE: Copyright (C) 2009
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.

class ezieInfo {
    static function info() {
        $eZCopyrightString = 'Copyright (C) 1999-' . date('Y') . ' eZ Systems AS';

        return array( 'Name' => '<a href="http://projects.ez.no/epie">eZ Image Editor</a>',
        'Version' => "0.1 (preview only)",
        'Author'	=> 'Stefano Ballabeni, Robin Boutros, Adrien Mogenet',
        'Copyright' => $eZCopyrightString,
        'License' => "GNU General Public License v2.0",
        'Includes the following third-party software' => array( 'Name' => 'jQuery',
                                                                                              'Version' => '1.3.2',
                                                                                              'Copyright' => 'Copyright (c) 2009, jQuery Team. All rights reserved.',
                                                                                              'License' => 'Licensed under the Gnu General Public License (GPL) Version 2',),
        'Includes the following third-party software(2)' => array( 'Name' => 'jQuery UI',
                                                                                              'Version' => '1.7.2',
                                                                                              'Copyright' => 'Copyright (c) 2009, PAUL BAKAUS AND THE JQUERY UI TEAM. All rights reserved.',
                                                                                              'License' => 'Licensed under the Gnu General Public License (GPL) Version 2',),
        'Includes the following third-party software(2)' => array( 'Name' => 'Jcrop',
                                                                                              'Version' => '0.9.8',
                                                                                              'Copyright' => 'Copyright (c) 2008-2009 Deep Liquid Group. All rights reserved.',
                                                                                              'License' => 'Licensed under the MIT License',),

        'Needs the following libraries' => array('eZ Components' => 'http://ezcomponents.org/'),
        );
    }
}
?>
