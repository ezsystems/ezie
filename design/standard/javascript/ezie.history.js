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

ezie.eziehistory = function() {
    var history = [];
    var history_version = -1;

    var resetHistory = function() {
        history = [];
        history_version = -1;
    }

    var tellEzConnect = function() {
        ezie.ezconnect.connect.instance().set({
            'history_version': history_version
        });
    };

    var undo = function() {
        if (history_version > 0) {
            moveInHistory(-1); // goes back one step
        }
    };

    var redo = function() {
        if (history_version < (history.length - 1)) {
            moveInHistory(1);
        }
    };

    var moveInHistory = function(move) {
        history_version = history_version + move;
        tellEzConnect();
    };

    var addItem = function(image_url, thumbnail_url) {
        moveInHistory(1);

        var time = new Date();
        time = time.getTime();

        if (history_version < history.length && history[history_version]) {
            if (history[history_version].mixed == time) {
                time = time + Math.floor(Math.random()*254345);
            }

            history[history_version].mixed = time;
            history[history_version].image = image_url;
            history[history_version].thumbnail = thumbnail_url;

            for (i = history_version + 1; i < history.length; ++i) {
                history[i] = null;
            }

            history.length = history_version + 1;
        }
        else {
            history.push({
                'mixed':        time,
                'image':        image_url,
                'thumbnail':    thumbnail_url
            })
        }
    };

    var setDimensions = function(w, h) {
        history[history_version].w = w;
        history[history_version].h = h;
    }

    var getCurrentDimensions = function() {
        return {
            w: history[history_version].w,
            h: history[history_version].h
        };
    }

    var hasAntecedent = function() {
        return (history_version > 0);
    }
    var hasSuccessor = function() {
        return (history_version != -1 && history_version + 1 < history.length);
    }

    var refreshItem = function() {
        if (history_version < 0 || history_version > history.length) {
            return;
        }

        var time = new Date();
        time = time.getTime();
        if (history[history_version].mixed == time) {
            time = time + Math.floor(Math.random()*254345);
        }

        history[history_version].mixed = time;
    }

    var current = function() {
        if (history_version >= 0
            && history_version < history.length)
            return history[history_version];
        else
            return null;
    }

    var version = function() {
        return history_version;
    }

    return {
        add:addItem,
        undo:undo,
        redo:redo,
        current:current,
        version:version,
        refreshCurrent:refreshItem,
        reset:resetHistory,
        hasSuccessor:hasSuccessor,
        hasAntecedent:hasAntecedent,
        setDimensions:setDimensions,
        getDimensions:getCurrentDimensions
    };
};


ezie.history_instance = null;

ezie.history = function() {
    if (ezie.history_instance == null) {
        ezie.history_instance = new ezie.eziehistory();
    }

    return ezie.history_instance;
}