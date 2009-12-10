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

ezie.gui.config.bind.tool_saturation_show = function() {
    $.log('starting saturation');
    ezie.gui.eziegui.getInstance().opts().showOpts("#optsSaturation");
}

ezie.gui.config.bind.tool_saturation_submit = function() {
    var sat = $("#optsSaturation input[name='saturation']").val();

    ezie.ezconnect.connect.instance().action({
        'action': 'tool_saturation',
        'data': {
            'saturation':sat
        }
    });

    $.log("saturation value send : " + sat);
}

ezie.gui.config.bind.tool_saturation_slide = function(value) {
    $("#optsSaturation input[name='saturation']").val(value);
}

ezie.gui.config.bind.tool_saturation_preview = function() {
    var sat = $("#optsSaturation .slider:first").slider("value");
    $("#optsSaturation input[name='saturation']").val(sat);
    $.log("saturation preview : " + sat);
}