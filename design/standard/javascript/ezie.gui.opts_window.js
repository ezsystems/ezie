// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Image Editor extension for eZ Publish
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

ezie.gui.opts_window = function() {
    var jWindow = null;
    var initialized = false;

    // returns the jQuery Dom element corresponding to
    // the window
    var getJWindow = function() {
        return jWindow;
    };

    var setBindsForSliders = function () {
        $.each(ezie.gui.config.bindings.opts_items_sliders, function() {
            var config = this;
            var item = $(config.selector);

            item.slider({
                min:config.min,
                max:config.max,
                step:config.step,
                change:function () {
                    if (!ezie.gui.eziegui.getInstance().isFrozen()) {
                        config.change();
                    }
                    return false;
                },
                slide:function(event, ui) {
                    config.slide(ui.value);
                }
            });
        });
    };

    var setBindsForButtons = function () {
        $.each(ezie.gui.config.bindings.opts_items_buttons, function() {
            var config = this;
            var item = $(config.selector);
            item.click(function() {
                if (!ezie.gui.eziegui.getInstance().isFrozen()) {
                    config.click(this);
                }
                return false;
            });
        });
    };

    var setBinds = function() {
        setBindsForSliders();
        setBindsForButtons();

        $('#optsSelect input[type="text"]').keyup(function(e) {
            if ($('#optsSelect input[type="radio"]:checked:first').val() != 'free') {
                ezie.gui.config.bind.tool_select_method();
            }
            return true;
        });

    };

    var init = function() {
        setBinds();
        jWindow = $("#sideBar");
        hideOptions();
        initialized = true;
    };

    var switchjWindow = function() {
        if (jWindow.is("#sideBar"))
            jWindow = $("#ezieOptsWindow");
        else
            jWindow = $("#sideBar");
    }

    var freeze = function() {
        $("button").freeze();
    }
    var unfreeze = function() {
        $("button").unfreeze();
    }

    var hide = function () {
        if (initialized)
            jWindow.fadeOut('fast');
    };

    var hideOptions = function() {
        jWindow.find(".opts").hide();
    };

    var showOpts = function(id) {
        jWindow.find(".opts").hide();
        jWindow.find(id).fadeIn();
    };

    var show = function () {
        if (!initialized) {
            init();
        }
        jWindow.fadeIn('fast');
        showOpts("#optsZoom");
    }

    var updateImage = function() {
        var currentImage = ezie.history().current();

        img = $("<img></img>").attr("src", currentImage.thumbnail + "?" + currentImage.mixed)
        .attr("alt", "");

        jWindow.find("#miniature").html(img);
    }

    return {
        jWindow:getJWindow,
        show:show,
        hide:hide,
        showOpts:showOpts,
        switchjWindow:switchjWindow,
        updateImage:updateImage,
        freeze:freeze,
        unfreeze:unfreeze
    };
};
