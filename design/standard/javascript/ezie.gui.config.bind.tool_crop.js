// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Image Editor extension for eZ Publish
// SOFTWARE RELEASE: 0.1 (preview only)
// COPYRIGHT NOTICE: Copyright (C) 1999-2010 eZ Systems AS
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

ezie.gui.config.bind.tool_crop = function () {
    ezie.gui.eziegui.getInstance().opts().showOpts("#optsSelect");

    try {
        ezie.gui.config.bind.tool_select_method();
    } catch(e) {}
//    ezie.gui.config.bind.set_tool_select({
//        x:0,
//        y:0,
//        w:100,
//        h:100
//    });
//    
    $('#optsCrop').fadeIn('fast');
}

ezie.gui.config.bind.tool_crop_perform = function() {
    if (ezie.gui.selection().isSelectionActive()) {
        ezie.ezconnect.connect.instance().action({
            'action': 'tool_crop'
        });
        ezie.gui.config.bind.tool_select_remove();
    }
}