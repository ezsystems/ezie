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

ezie.gui.main_window = function() {
    var jWindow = null;
    var initialized = false;

    // returns the jQuery Dom element corresponding to
    // the window
    var getJWindow = function() {
        return jWindow;
    };

    var setBinds = function () {
        $.each(ezie.gui.config.bindings.main_window, function() {
            var config = this;
            var item = $(config.selector);

            item.click(function () {
                config.click();
                return false;
            });

            if (item.attr('title').length > 0) {
                var p = item.closest('div.ezieBox').find('div.bottomBarContent p')
                var oldcontent = p.html()

                item.hover(function (){
                    p.html($(this).attr('title'))
                }, function () {
                    p.html(oldcontent)
                });
            }

        })

    };

    var freeze = function() {
        $("#grid span").freeze();
    }
    var unfreeze = function() {
        $("#grid span").unfreeze();
    }

    var init = function() {
        setBinds();
        jWindow = $("#ezieMainWindow");
    };

    var hide = function () {
        jWindow.fadeOut('fast');
    };

    var show = function () {
        if (!initialized) {
            init();

            initialized = true;
        }
        jWindow.fadeIn('fast');
    }

    var updateImage = function() {
        $.log('update main image');
        var currentImage = ezie.history().current();
        $.log('  main_image_url = ' + currentImage.image);
        if (currentImage) {
            img = $("<img></img>").attr("src", currentImage.image + "?" + currentImage.mixed)
            .attr("alt", "");
            jWindow.find("#main_image").html(img);
        }
        ezie.gui.config.zoom().reZoom();
    }

    var showLoading = function() {
        $("#loadingBar").fadeIn();
    };
    var hideLoading = function() {
        $("#loadingBar").fadeOut();
    }

    return {
        jWindow:getJWindow,
        show:show,
        hide:hide,
        updateImage:updateImage,
        hideLoading:hideLoading,
        showLoading:showLoading,
        freeze:freeze,
        unfreeze:unfreeze
    };
};
