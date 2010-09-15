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

ezie.gui.selection_impl = function() {
    var selection = {
        x: 0,
        y: 0,
        w: 0,
        h: 0
    };

    var active = false;

    var isSelectionActive = function () {
        return active;
    };

    var removeSelection = function() {
        selection.x = 0;
        selection.y = 0;
        selection.w = 0;
        selection.h = 0;

        deactivate();
    }

    var setSelection = function (c) {
        selection.x = c.x;
        selection.y = c.y;
        selection.w = c.w;
        selection.h = c.h;

        if (c.w == 0 || c.h == 0) {
            deactivate()
        } else {
            activate();
        }

    //$.log('[selection] (x, y) : (' + selection.x + ',  ' + selection.y + ') - (w, h)' + '(' + selection.w + ', ' + selection.h + ')');
    };

    var deactivate = function () {
        active = false;
    }

    var activate = function() {
        active = true;
    }

    var hasSelection = function() {
        return (selection.w != 0 && selection.h != 0);
    }

    var getSelection = function() {
        return selection;
    };

    var getZoomedSelection = function(zoom) {
        zoom = zoom / 100;
        $.log('[zoomed selection] '+
            '(x, y) : (' + (selection.x * zoom) + ',  ' + (selection.y * zoom) + ') '+
            '- (w, h)' + '(' + (selection.w * zoom) + ', ' + (selection.h * zoom) + ')');

        return {
            x: (selection.x * zoom),
            y: (selection.y * zoom),
            w: (selection.w * zoom),
            h: (selection.h * zoom)
        };
    };

    var getArrayZoomedSelection = function(zoom) {
        select = getZoomedSelection(zoom);

        return {
            'selection[x]': select.x,
            'selection[y]': select.y,
            'selection[w]': select.w,
            'selection[h]': select.h
        };
    }

    var getArraySelection = function() {
        select = getSelection();
        var res = [];
        res['x'] = select.x;
        res['y'] = select.y;
        res['w'] = select.w;
        res['h'] = select.h;
        return res;
    }

    return {
        isSelectionActive:isSelectionActive,
        hasSelection:hasSelection,
        remove:removeSelection,
        selection:getSelection,
        set:setSelection,
        zoomedSelection:getZoomedSelection,
        arrayZoomedSelection:getArrayZoomedSelection,
        arraySelection: getArraySelection,
        deactivate:deactivate
    };
}

ezie.gui.selection_instance = null;
ezie.gui.selection = function() {
    if (ezie.gui.selection_instance == null) {
        ezie.gui.selection_instance = new ezie.gui.selection_impl();
    }

    return ezie.gui.selection_instance;
};
