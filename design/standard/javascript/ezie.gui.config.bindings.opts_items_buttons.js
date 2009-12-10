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

ezie.gui.config.bindings.opts_items_buttons = [
    {
        'selector':     '#optsBlur button',
        'click':        ezie.gui.config.bind.filter_blur_submit
    },
    {
        'selector':     '#optsRotation button',
        'click':        ezie.gui.config.bind.tool_rotation_submit
    },
    {
        'selector':     '#optsLevels button',
        'click':        ezie.gui.config.bind.tool_levels_submit
    },
    {
        'selector':     '#selectAngle .preset',
        'click':        ezie.gui.config.bind.tool_rotation_preset_value
    },
    {
        'selector':     '#optsSaturation button',
        'click':        ezie.gui.config.bind.tool_saturation_submit
    },
    {
        'selector':     '#optsZoom #zoomIn',
        'click':        ezie.gui.config.tool_zoom_in
    },
    {
        'selector':  '#optsZoom #zoomOut',
        'click':        ezie.gui.config.tool_zoom_out
    },
    {
        'selector':     '#optsZoom #fitOnScreen',
        'click':        ezie.gui.config.tool_zoom_fit_on_screen
    },
    {
        'selector':     '#optsZoom #actualPixels',
        'click':        ezie.gui.config.tool_zoom_actual_pixels
    },
    {
        'selector':    '#optsWatermarks .ezie-watermark-image',
        'click':           ezie.gui.config.bind.tool_place_watermark
    },
    {
        'selector':     '#optsWatermarks button.submit',
        'click':           ezie.gui.config.bind.tool_watermark_submit
    },
    {
        'selector':     '#optsWatermarksPositions button',
        'click':            ezie.gui.config.bind.tool_watermark_set_pos
    }
];
