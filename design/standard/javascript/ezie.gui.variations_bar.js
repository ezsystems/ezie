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

ezie.gui.variations_bar = function() {
    var jWindow = null;
    var initialized = false;

    // returns the jQuery Dom element corresponding to
    // the window
    var getJWindow = function() {
        return jWindow;
    };

    var resizeLi = function(h) {
        $("#ezieVariations li").css({
            'height':  h,
            'width': h
        });
    };


    var setBinds = function () {
        $.each(ezie.gui.config.bindings.variations_bar, function() {
            var config = this;
            item = $(config.selector);

            item.click(function () {
                config.click();
                return false;
            });

            // TODO: decide whether to remove this or add a bottom bar
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

    var initMisc = function() {
        var prev = 0;

        $("#ezieVariations").hide();

        $("#ezieVariationsBar").resizable({
            handles:'n',
            maxHeight: 170,
            minHeight: 5,
            resize: function() {
                var h = ($(this).height() - 40);
                if (prev > 10 && h <= 10) {
                    $("#ezieVariations").hide();
                    prev = h;
                } else if (prev <= 10 && h > 10) {
                    $("#ezieVariations").fadeIn("slow");
                    prev = h;
                }
                resizeLi(h);
            }
        });

    }

    var init = function() {
        setBinds();
        initMisc();
        jWindow = $("#ezieVariationsBar");
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

    return {
        jWindow:getJWindow,
        show:show,
        hide:hide
    };
};
