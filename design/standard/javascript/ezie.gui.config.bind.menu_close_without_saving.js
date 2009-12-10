// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: Ep Image Editor extension for eZ Publish
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

ezie.gui.config.bind.menu_close_without_saving = function() {
    if (!ezie.gui.eziegui.isInstanciated()) { // TODO: also when the mainwindow is not open/visible
        return;
    }
    
    // TODO: call this when the user leaves the page (ie, fx et chrome)
    if (!confirm('If you leave without saving, all your modifications will be definitely lost')) {
        return;
    }

    $.log('starting quit + no save');

    ezie.gui.eziegui.getInstance().desactivateUndo();
    ezie.gui.eziegui.getInstance().desactivateRedo();

    ezie.ezconnect.connect.instance().action({
        'action': 'no_save_and_quit',
        'success': function() {
            //ezie.ezconnect.success_default(response);
            ezie.gui.eziegui.getInstance().close();
        }
    });

}