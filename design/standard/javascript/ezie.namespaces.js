// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Image Editor extension for eZ Publish
// SOFTWARE RELEASE: 0.1 (preview only)
// COPYRIGHT NOTICE: Copyright (C) 2009 eZ Systems AS
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
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##

var ezie = window.ezie || {};

// This is the global namespace of the UI.
ezie.gui = ezie.gui || {};

// Sub-namespace of the UI namespace, contains various configuration
// objects
ezie.gui.config = ezie.gui.config || {};

// Namespace to set the association between an item and the function to be excuted
ezie.gui.config.bindings = ezie.gui.config.bindings || {};

// Namespace used for the definition of the binded functions
ezie.gui.config.bind = ezie.gui.config.bind || {};
// Namespace used for the definition of actions. Similar to gui.config.bind but
// not for actions triggered by a click event
ezie.gui.config.actions = ezie.gui.config.action || {};

// Namespace for the interactions between the ui and ez publish
ezie.ezconnect = ezie.ezconnect || {};
