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

ezie.gui.config.bind.tool_select_api = null;
ezie.gui.config.select_custom_opts = null;

ezie.gui.config.bind.tool_select = function(selection, options) {
    var settings = {
        onSelect: ezie.gui.selection().set,
        onChange: ezie.gui.selection().set
    };

    if (typeof options != "undefined") {
        $.log('on set custop opts');
        ezie.gui.config.select_custom_opts = options;
        $.extend(settings, options);
    } else {
        $.log('on unset custop opts-0');
        ezie.gui.config.select_custom_opts = null;
    }

    if (ezie.gui.config.bind.tool_select_api != null) {
        if (selection) {
            ezie.gui.config.bind.tool_select_api.setSelect([selection.x, selection.y,
                selection.x + selection.w, selection.y + selection.h])
            ezie.gui.selection().set(selection);
        }
        return;
    }

    ezie.gui.config.bind.tool_select_api  = $.Jcrop("#main_image img:first", settings);
    
    if (selection != null) {
        ezie.gui.config.bind.tool_select_api.setSelect([selection.x, selection.y,
            selection.x + selection.w, selection.y + selection.h])
        ezie.gui.selection().set(selection);
    }
}

ezie.gui.config.bind.tool_select_remove = function (){
    if (ezie.gui.config.bind.tool_select_api  != null) {
        ezie.gui.config.bind.tool_select_api.destroy();
        ezie.gui.selection().deactivate();
        $.log('on unset custop opts-1');
        ezie.gui.config.select_custom_opts = null;
        ezie.gui.config.bind.tool_select_api = null;
    }
}