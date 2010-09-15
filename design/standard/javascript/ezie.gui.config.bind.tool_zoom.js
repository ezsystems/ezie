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

ezie.gui.config.bind.tool_zoom_show = function () {
    ezie.gui.eziegui.getInstance().opts().showOpts("#optsZoom");
}

ezie.gui.config.tool_zoom_in = function() {
    ezie.gui.config.zoom().zoomAt(115);
}

ezie.gui.config.tool_zoom_out = function() {
    ezie.gui.config.zoom().zoomAt(90);
}

ezie.gui.config.tool_zoom_fit_on_screen = function () {
    ezie.gui.config.zoom().fitScreen();
}

ezie.gui.config.tool_zoom_actual_pixels = function () {
    ezie.gui.config.zoom().zoom(100);
}