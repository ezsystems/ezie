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

ezie.gui.eziegui = function () {
    var that = this;
    var mainWindow = null;
    var toolWindow = null;
    var optsWindow = null;
    var jWindow = null;
    var initialized = false;
    var freeze = false;
    var ezie_edit_button = null;

    var isFrozen = function () {
        return freeze;
    };

    var setFreeze = function (frozen) {
        freeze = frozen;
        if (freeze) {
            freezeGUI();
        } else {
            unfreezeGUI();
        }
    };

    var hide = function() {
        jWindow.fadeOut('fast');
    };

    var show = function() {
        jWindow.fadeIn('fast');
    }

    var hideGUI = function() {
        toolWindow.hide();
        optsWindow.hide();
        mainWindow.hide();

        hide();
    };

    var freezeGUI = function () {
        toolWindow.freeze();
        optsWindow.freeze();
        mainWindow.freeze();
    }

    var unfreezeGUI = function () {
        toolWindow.unfreeze();
        optsWindow.unfreeze();
        mainWindow.unfreeze();
    }

    var closeGUI = function() {
        hideGUI();
    }

    var showGUI = function() {
        $.log('toolwin');
        toolWindow.show();
        $.log('mainwin');
        mainWindow.show();
        $.log('optswin');
        optsWindow.show();
        $.log('goshow');

        show();
    };

    // Undo/Redo states
    var activateUndo = function() {
        $("#ezie_undo").parent("li").addClass("active");
    }
    var desactivateUndo = function() {
        $("#ezie_undo").parent("li").removeClass("active");
    }
    var activateRedo = function() {
        $("#ezie_redo").parent("li").addClass("active");
    }
    var desactivateRedo = function() {
        $("#ezie_redo").parent("li").removeClass("active");
    }

    var initGUI = function() {
        // global functionnalities & effects
        $(".ezieBox").hover(function() {
            if (!$(this).data("init")) {
                $(this).data("init", true);
                $(this).draggable({
                    handle: ".topBar"
                });
            }
        });

        $(".closed").parent(".sectionHeader").next(".sectionContent").hide();
        // TODO: move this
        $(".sectionHeader h4").click(function() {
            $(this).parent(".sectionHeader").next(".sectionContent").slideToggle();
            $(this).toggleClass("closed");
        });

        $("#resize").resizable({
            resize: function() {
                $("#grid").css("height", ($(this).height() - 30));
                $("#ezieMainWindow").css("width", ($(this).width() + 24));
            },
            minHeight: 400,
            minWidth:400,
             stop: ezie.gui.config.zoom().reZoom
        });

        $(".detachBox .sep").live("click", function() {
            var optBox = $('#ezieOptsWindow');
            $(this).closest(".detachBox").removeClass("detachBox").addClass("attachBox").appendTo(optBox.find(".content"));
            optBox.fadeIn();
            $("#grid").animate({
                marginRight: "0px"
            });
            return false;
        });
        $(".attachBox .sep").live("click", function() {
            $("#grid").animate({
                marginRight: "161px"
            });
            $('#ezieOptsWindow').fadeOut().find(".attachBox").removeClass("attachBox").addClass("detachBox").appendTo($("#ezieMainWindow .content")).hide().fadeIn();

            return false;
        });
        $('#colorSelector').ColorPicker({
            color: '#0000ff',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorSelector div').css('backgroundColor', '#' + hex);
                $("#optsRotation input[name='color']").val(hex);
            }
        });

        $(".tools li:not(.less) a").click(function() {
            $(this).closest(".tools").find("li").removeClass("current");
            $(this).parent("li").addClass("current");
        });

        $(".filters li.more a").click(function() {
            $(".filters li.more").removeClass("current");
            $(this).parent("li").addClass("current");
        });

        $(".less").mousedown(function() {
           $(this).addClass("click");
        });
        $(".less").mouseup(function() {
           $(this).removeClass("click");
        });
        $(".less").mouseout(function() {
           $(this).removeClass("click");
        });
    };

    var init = function () {
        initGUI();

        mainWindow = new ezie.gui.main_window();
        toolWindow = new ezie.gui.tools_window();
        optsWindow = new ezie.gui.opts_window();

        jWindow = $("#ezieMainContainer");
        initialized = true;
    };

    // public methods

    // opens the gui
    // prepare_url is the url to call so
    // the backend prepares the image to be edited (see module/ezie/prepare.php)
    var open = function(prepare_url, button) {
        $.log('on open \\o/');
        if (initialized == false) {
            init();
        }
        $.log('show ton gui ?');
        showGUI();


        ezie_edit_button = $(button);
        $.log('kik ezie button ? ' + button);

        ezie.ezconnect.prepare(prepare_url);
    }

    var refreshImages = function() {
        mainWindow.updateImage();
        optsWindow.updateImage();
    }

    var setImages = function(image, thumb) {
        $.log('global set images (' + image + ', '+thumb+')');
        if (image != null && thumb != null)
            ezie.history().add(image, thumb);
        refreshImages();
    }

    // loads an image in the interface
    // TODO: should this be in the mainwindow class? or should this do some things before
    // calling actions on the main windwo ? (same for nload)
    var load = function() {
    }

    // unloads an image
    var unload = function() {
    }

    // closes the interface
    var close = function() {
        unload();
        closeGUI();
    }

    var getMainWindow = function() {
        return mainWindow;
    }

    var getToolWindow = function() {
        return toolWindow;
    }

    var getOptsWindow = function() {
        return optsWindow;
    }

    var getJWindow = function() {
        return jWindow;
    }

    var getButton = function() {
         return ezie_edit_button;
    }

    return {
        open:open,
        close:close,
        load:load,
        unload:unload,

        // These methods return the instance of the corresponding window
        main:getMainWindow,
        tools:getToolWindow,
        opts:getOptsWindow,
        // returns jQuery dom element of the container of all three windows
        jWindow:getJWindow,
        setImages:setImages,
        refreshImages:refreshImages,

        // GUI actions
        activateUndo:activateUndo,
        activateRedo:activateRedo,
        desactivateUndo:desactivateUndo,
        desactivateRedo:desactivateRedo,
        // Freeze the GUI while executing server-side actions
        freezeGUI:freezeGUI,
        unfreezeGUI:unfreezeGUI,
        
        isFrozen:isFrozen,
        freeze:setFreeze,

        button:getButton
    }

};

// static attributes
ezie.gui.eziegui.instance = null;

// static methods
ezie.gui.eziegui.getInstance = function() {
    if (ezie.gui.eziegui.instance == null) {
        ezie.gui.eziegui.instance = new ezie.gui.eziegui();
    }

    return ezie.gui.eziegui.instance;
}

// returns true if the gui object exists
ezie.gui.eziegui.isInstanciated = function() {
    return (ezie.gui.eziegui.instance != null);
}


