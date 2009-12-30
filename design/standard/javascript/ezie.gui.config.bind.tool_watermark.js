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

ezie.gui.config.bind.tool_watermark = function() {
    // we will use a selection box to allow the user to place and resize
    // the watermark where he wants it. Therefore, if a selection
    // existed, we remove it.
    ezie.gui.config.bind.tool_select_remove();

    ezie.gui.eziegui.getInstance().opts().showOpts("#optsWatermarks");
}

ezie.gui.config.bind.tool_place_watermark = function(watermark) {
    ezie.gui.config.bind.tool_select_remove();

    var img = $(watermark);
    var ratio = img.width() / img.height();

    $.log('on va se faire un ptit wm de ratio : ' + img.width() + ' / ' + img.height() + " = " + ratio);

    ezie.gui.config.bind.set_tool_select(null, {
        bgColor:     'transparent',
        aspectRatio: ratio,
        bgOpacity: 1,
        setSelect: [10, 10, img.width(), img.height()]
    }, true);

    // this is a trick/hack and it would be nice to find another
    // way of doing it.
    wm = $('<img></img>').attr('src', watermark.src).css({
        width: '100%',
        height: '100%'
    });
    $('.jcrop-tracker:first').append(wm);

    ezie.gui.config.bind.tool_watermark_move();

    $.log('youpi le wm selection:) ');

}

ezie.gui.config.bind.tool_watermark_submit = function() {
    if (!ezie.gui.selection().isSelectionActive()) {
        return;
    } else {
        src = $('.jcrop-tracker:first img').attr('src');

        src = src.substr(src.lastIndexOf('/') + 1);

        ezie.ezconnect.connect.instance().action({
            'action': 'tool_watermark',
            'data': {
                'watermark_image': src
            }
        });
        ezie.gui.config.bind.tool_select_remove();

    }
}

ezie.gui.config.bind.tool_watermark_position = null;

ezie.gui.config.bind.tool_watermark_set_pos = function(button) {
    $('#optsWatermarksPositions').find('.selected').removeClass('selected');

    b = $(button);
    b.addClass('selected');

    ezie.gui.config.bind.tool_watermark_position = $('#optsWatermarksPositions button').index(button);

    if (ezie.gui.selection().isSelectionActive()) {
        // move the selection
        ezie.gui.config.bind.tool_watermark_move();
    }
}

ezie.gui.config.bind.tool_watermark_move = function() {
    if (ezie.gui.config.bind.tool_watermark_position == null) {
        return;
    }

    var img = $("#main_image");
    var sel = ezie.gui.selection().selection();

    var h_off = 10;
    var v_off = 10;

    // Positions:
    // 0 1 2
    // 3 4 5
    // 6 7 8
    var position = {};

    // JavaScript's switch is a bit buggy :('
    switch(ezie.gui.config.bind.tool_watermark_position) {
        // y
        case 0:
        case 1:
        case 2:
            position.y1 = v_off;
            break;
        case 3:
        case 4:
        case 5:
            position.y1 = img.height() / 2 - sel.h / 2;
            break;
        case 6:
        case 7:
        case 8:
            position.y1 = img.height() - sel.h - v_off;
            break;
    }

    switch(ezie.gui.config.bind.tool_watermark_position) {
        // x
        case 0:
        case 3:
        case 6:
            position.x1 = h_off;
            break;
        case 1:
        case 4:
        case 7:
            position.x1 = img.width() / 2 - sel.w / 2;
            break;
        case 2:
        case 5:
        case 8:
            position.x1 = img.width() - sel.w - h_off;
            break;
    }

    
    position.x2 = position.x1 + sel.w;
    position.y2 = position.y1 + sel.h;

    $.log('wm position :');
    $.log('    '+ezie.gui.config.bind.tool_watermark_position)
    $.log('sel :');
    $.log('  w, h: ' + sel.w + ', ' + sel.h);
    $.log('img :');
    $.log('  w, h: ' + img.width() + ', ' + img.height());
    $.log('position : ');
    $.log('  (x1, y1) : (' + position.x1 + ', ' + position.y1 + ')');
    $.log('  (x2, y2) : (' + position.x2 + ', ' + position.y2 + ')');
    ezie.gui.config.bind.tool_select_api.animateTo([position.x1, position.y1, position.x2, position.y2]);
}