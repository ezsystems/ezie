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

ezie.gui.config.bindings.opts_items_sliders = [
    {
        'selector':     '#optsBlur .slider',
        'change':       ezie.gui.config.bind.filter_blur_preview,
        'slide':        function() {}, // TODO: change this to null?
        'min' :         0,
        'max' :         25,
        'step' :        1
    },
    {
        'selector':     '#optsLevels #channelR',
        'change':       function () { ezie.gui.config.bind.tool_levels_preview('#channelR') },
        'min':          0,
        'max':          100,
        'step' :        0.01
    },
    {
        'selector':     '#optsLevels #channelG',
        'change':       function () { ezie.gui.config.bind.tool_levels_preview('#channelG') },
        'min':          0,
        'max':          100,
        'step' :        0.01
    },
    {
        'selector':     '#optsLevels #channelB',
        'change':       function () { ezie.gui.config.bind.tool_levels_preview('#channelB') },
        'min':          0,
        'max':          100,
        'step' :        0.01
    },
    {
        'selector':     '#optsLevels #channelA',
        'change':       function () { ezie.gui.config.bind.tool_levels_preview('#channelA') },
        'min':          0,
        'max':          100,
        'step' :        0.01
    },
    {
        'selector':     '#optsSaturation .slider',
        'change':       ezie.gui.config.bind.tool_saturation_preview,
        'slide':        function(value) { ezie.gui.config.bind.tool_saturation_slide(value) },
        'min':          -100,
        'max':          100,
        'step' :        1
    },
    ];

