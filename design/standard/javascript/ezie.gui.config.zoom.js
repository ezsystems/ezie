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

ezie.gui.config.zoom_impl = function() {
    var jImgBlock = $('#main_image');
    var currentZoom = 100;
    var realWidth = 0;
    var realHeight = 0;

    var init = function() {
        jImgBlock.css({
            'width': 'auto',
            'height': 'auto'
        });

        var img = jImgBlock.find('img:first');
        img.css({
            'width': 'auto',
            'height': 'auto'
        });

        img.load(function() {
            realWidth = this.width;
            realHeight = this.height;
            setZoom(currentZoom);
            $(this).css('width', '100%').css('height', '100%');
        })
    }

    var reset = function() {
        realWidth = 0;
        realHeight = 0;
        currentZoom = 100;
        jImgBlock.css('width', 'auto').css('height', 'auto');
        jImgBlock.find('img:first').css('width', 'auto').css('height', 'auto');
    }

    var setZoom = function(zoom) {
        //var oldZoom = currentZoom;
        var selection = null;
        // for watermark & text tool
        var selectionData = null;
        var selectionOptions = null;
        if (ezie.gui.selection().isSelectionActive()) {
            selection = ezie.gui.selection().zoomedSelection((zoom  * 100) / currentZoom);
            selectionData = $('.jcrop-tracker:first').html();
            selectionOptions = ezie.gui.config.select_custom_opts;
            $.log('1| sel options ' + selectionOptions);
            ezie.gui.config.bind.tool_select_remove();
        }

        if (zoom < 10 || zoom > 1500) {
            return;
        }

        currentZoom = zoom;

        jImgBlock.css({
            'height': (zoom * realHeight / 100) + 'px',
            'width': (zoom * realWidth / 100) + 'px'
        });

        var gridH = $('#grid').height();

        if ((jImgBlock.height() - 2) < gridH) {
           mt = (gridH - (jImgBlock.height() - 2)) / 2;
           jImgBlock.css('margin-top',  mt + 'px');
        } else {
            jImgBlock.css('margin-top', '0px');
        }

        if (selection != null) {
            $.log('2| sel opts :' + selectionOptions);
            ezie.gui.config.bind.tool_select(selection, selectionOptions);
            if (selectionData) {
                $('.jcrop-tracker:first').html(selectionData);
            }

        }

        $.log('new zoom = ' + zoom + "% on ["+realWidth+" x "+realHeight+"]");
    }

    var zoomAt = function(zoom) {
        $.log(jImgBlock.height())

        setZoom(currentZoom * zoom / 100);
    }

    var reZoom = function(fromCache) {
        var img = jImgBlock.find('img:first');

        jImgBlock.css({
            'height': 'auto',
            'width': 'auto'
        });

        img.css({
            'height': 'auto',
            'width': 'auto'
        });

        $.log('fromcache : "' + typeof fromCache + '"');

        img.load(function() {
            $.log('rezoom from load');

            // this is in case the image has been resized but the load function triggered
            jImgBlock.css({
                'height': 'auto',
                'width': 'auto'
            });

            $(this).css({
                'height': 'auto',
                'width': 'auto'
            });
            realWidth = $(this).width();
            realHeight = $(this).height();

            ezie.history().setDimensions(realWidth, realHeight);

            $(this).css({
                'height': '100%',
                'width': '100%'
            });

            setZoom(currentZoom);
        });

        if (fromCache) {
            $.log('rezoom from cache');
            dims = ezie.history().getDimensions();

            realWidth = dims.w;
            realHeight = dims.h;

            img.css({
                'height': '100%',
                'width': '100%'
            });

            setZoom(currentZoom);
        }
    }

    var fitScreen = function () {
        var grid = $("#grid");
        if (realWidth / grid.width() >= realHeight / grid.height()) {
            fitWidth();
        } else {
            fitHeight();
        }
    }

    var getZoom = function() {
        return currentZoom;
    }

    var fitWidth = function() {
        jImgBlock.css('width', '100%');

        var newZoom = ((jImgBlock.width() - 2) / realWidth) * 100;

        setZoom(newZoom);
    }

    var fitHeight = function() {
        jImgBlock.css('height', '100%');
        var newZoom = ((jImgBlock.height() - 2) / realHeight) * 100;
        setZoom(newZoom);
    }

    return {
        init:init,
        reset:reset,
        fitWidth:fitWidth,
        fitHeight:fitHeight,
        fitScreen:fitScreen,
        zoom:setZoom,
        zoomAt:zoomAt,
        get:getZoom,
        reZoom:reZoom
    };
}

ezie.gui.config.zoom_instance = null;
ezie.gui.config.zoom = function() {
    if (ezie.gui.config.zoom_instance == null) {
        ezie.gui.config.zoom_instance = new ezie.gui.config.zoom_impl();
    }

    return ezie.gui.config.zoom_instance;
};
