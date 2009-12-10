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

ezie.gui.config.bindings.tools_window = [
    {
        'selector':     '#ezie_select',
        'click':        ezie.gui.config.bind.tool_select,
        'shortcut':     's'
    },
    {
        'selector':     '#ezie_undo',
        'click':        ezie.gui.config.bind.tool_undo,
        'shortcut':     'ctrl+z'
    },
    {
        'selector':     '#ezie_redo',
        'click':        ezie.gui.config.bind.tool_redo,
        'shortcut':     'ctrl+y'
    },
    {
        'selector':     '#ezie_zoom',
        'click':        ezie.gui.config.bind.tool_zoom_show,
        'shortcut':     'z'
    },
    {
        'selector':     '#ezie_img',
        'click':        ezie.gui.config.bind.tool_img,
        'shortcut':     'i'
    },
    {
        'selector':     '#ezie_watermark',
        'click':        ezie.gui.config.bind.tool_watermark,
        'shortcut':     'w'
    },
    {
        'selector':     '#ezie_blackandwhite',
        'click':        ezie.gui.config.bind.filter_black_and_white,
        'shortcut':     'b'
    },
    {
        'selector':     '#ezie_sepia',
        'click':        ezie.gui.config.bind.filter_sepia,
        'shortcut':     'p'
    },
    {
        'selector':     '#ezie_flip_hor',
        'click':        ezie.gui.config.bind.tool_flip_hor,
        'shortcut':     'h'
    },
    {
        'selector':     '#ezie_flip_ver',
        'click':        ezie.gui.config.bind.tool_flip_ver,
        'shortcut':     'e'
    },
    {
        'selector':      '#ezie_rotation',
        'click':         ezie.gui.config.bind.tool_rotation_show,
        'shortcut':      'n'
    },
    {
        'selector':      '#ezie_levels',
        'click':         ezie.gui.config.bind.tool_levels_show,
        'shortcut':      '1'
    },
    {
        'selector':     '#ezie_pixelate',
        'click':        ezie.gui.config.bind.tool_pixelate,
        'shortcut':     null
    },
    {
        'selector':     '#ezie_crop',
        'click':        ezie.gui.config.bind.tool_crop,
        'shortcut':     'ctrl+c'
    },
    ];