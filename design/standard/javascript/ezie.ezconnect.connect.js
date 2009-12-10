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

// This static class stores the information relative to
// the interaction between the gui and ez publish for _one_ edition
//
// Basically it's data that is sent at every action so the backend can
// know what image we are editing. It must be initialiazed at the response
// of prepare (see: ezie.gui.config.action.prepare.js) and should be reseted
// when closing the interface, whether the edition has been saved or not.
//
// This class is a singleton and _MUST_ be used calling
//  ezie.ezzconnect.connect.instance() first
ezie.ezconnect.connect = function() {

    var ezdata = {
        // The key is a value sent by the backend when prepare is called.
        // it has to be sent at every communication with the backend except
        // when calling prepare.        
        'key': null,
        // node id of the image object in ez publish
        'image_id': null,
        // version number of the object in ez publish
        'image_version': null,
        // history version number in ezie
        // Related to the undo and redo actions
        'history_version': null,
        // url used to send make an action (like applying a filter)
        // format: /{site_access}/{module}/
        // append {action_name} to call apply the action on the image
        'module_url': null
    };

    // Sets the attributes at unusables values
    var reset = function() {
        ezdata.key = null;
        ezdata.image_id = null;
        ezdata.image_version = null;
        ezdata.history_version = null;
        ezdata.module_url = null;
    };

    // This method should be called after receiving the response of prepare
    var set = function(options) {
        var settings = {
            'key': ezdata.key,
            'image_id': ezdata.image_id,
            'image_version': ezdata.image_version,
            'history_version': ezdata.history_version,
            'module_url': ezdata.module_url
        };

        $.extend(settings, options);

        ezdata.key = settings.key;
        ezdata.image_id = settings.image_id;
        ezdata.image_version = settings.image_version;
        ezdata.history_version = settings.history_version;
        ezdata.module_url = settings.module_url;
    };

    var sendAction = function(options) {
        var settings = {
            'url': null,
            'success': ezie.ezconnect.success_default,
            'complete': ezie.ezconnect.complete_default,
            'error': ezie.ezconnect.failure_default,
            'type': 'POST',
            'dataType': 'json'
        };

        // TODO: this is not compatible with IE 5.5
        // check with eZ if it's an issue'
        $.extend(settings, options);
        if (!settings.data) {
            settings.data = {}
        }
        $.extend(settings.data, ezdata);
        if (ezie.gui.selection().isSelectionActive()) {
            var zoom = ezie.gui.config.zoom().get();
            var selection = ezie.gui.selection().arrayZoomedSelection((100  * 100) / zoom);

            $.log('curr zoom = ' + zoom + ' => togoto100: ' + (10000/zoom) );

            $.extend(settings.data, selection);
        }

        ezie.gui.config.bind.tool_select_remove();
        ezie.gui.eziegui.getInstance().freeze(true);
        ezie.gui.eziegui.getInstance().main().showLoading();

        $.ajax(settings);
    }

    var prepare = function(options) {
        var settings = {
            'url': null,
            'success': null,
            'complete':null,
            'type': 'GET',
            'error': ezie.ezconnect.failure_default,
            'dataType': 'json'
        };

        $.extend(settings, options);

        if (settings.url == null) {
            $.log('invalid url to prepare the image');
            return;
        }
        ezie.gui.eziegui.getInstance().main().showLoading();
        $.ajax(settings);
    }

    var action = function(options) {
        var settings = {
            'action': null,
            'data': {},
            'url': null
        };

        $.extend(settings, options);
        if (settings.action == null) {
            $.log("No action called...");
            return;
        }

        if (settings.url == null) {
            settings.url = ezdata.module_url + "/" + settings.action;
        }
        sendAction(settings);
    }

    return {
        set:set,
        reset:reset,
        prepare:prepare,
        action:action
    };
}

ezie.ezconnect.connect.the_instance = null;

ezie.ezconnect.connect.instance = function() {
    if (ezie.ezconnect.connect.the_instance == null) {
        ezie.ezconnect.connect.the_instance = new ezie.ezconnect.connect();
    }

    return ezie.ezconnect.connect.the_instance;
}