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

ezie.gui.config.bind.tool_rotation_slider_api = null;

ezie.gui.config.bind.tool_rotation_show = function() {
    $.log('starting rotation');
    ezie.gui.eziegui.getInstance().opts().showOpts("#optsRotation");

    if (ezie.gui.config.bind.tool_rotation_slider_api == null) {
        $('#circularSlider').circularslider({
            clockwise: true,
            zeroPos: 'top',
            giveMeTheValuePlease: function(v) {
                ezie.gui.config.bind.tool_rotation_slide(v);
            }
        },
        function(api) {
            ezie.gui.config.bind.tool_rotation_slider_api = api;
            $("#optsRotation input[name='angle']:first").keyup(function(){
                $.log('kikou on tapote');
                if ($(this).val() >= 0 && $(this).val() <= 359)
                    ezie.gui.config.bind.tool_rotation_slider_api.set($(this).val());
                else
                    ezie.gui.config.bind.tool_rotation_slider_api.set(0);

                $(this).val(ezie.gui.config.bind.tool_rotation_slider_api.get());
            });

        });
    }
}

ezie.gui.config.bind.tool_rotation_submit = function() {
    var angle = $("#optsRotation input[name='angle']").val();
    var color = $("#optsRotation input[name='color']").val();


    ezie.ezconnect.connect.instance().action({
        'action': 'tool_rotation',
        'data': {
            'angle':angle,
            'color':color,
            'clockwise': "yes"
        }
    });

    $.log("rotation value send : " + angle);
}

ezie.gui.config.tool_rotation = function(angle) {
    var color = $("#optsRotation input[name='color']").val();

    ezie.ezconnect.connect.instance().action({
        'action': 'tool_rotation',
        'data': {
            'angle':angle,
            'color':color
        }
    });

    $.log("rotation value send : " + angle);
}

ezie.gui.config.bind.tool_rotation_slide = function(value) {
    $("#optsRotation input[name='angle']").val(value);
}

ezie.gui.config.bind.tool_rotation_preview = function() {
    var angle = $("#optsRotation .slider:first").slider("value");
    $("#optsRotation input[name='angle']").val(angle);
    $.log("rotation preview : " + angle);
}

ezie.gui.config.bind.tool_rotation_preset_value = function(a) {
    $.log('setting a presetted value');

    if (ezie.gui.config.bind.tool_rotation_slider_api != null) {
        var v = $(a).html();
        v = v.substr(0, v.length - 1);
        $.log('valeur en cliquant pliz = ' + v);
        ezie.gui.config.bind.tool_rotation_slider_api.set(v);
    }
    return false;
}