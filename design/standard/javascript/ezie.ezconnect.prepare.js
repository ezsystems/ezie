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

ezie.ezconnect.prepare = function (prepare_url) {
    $.log('preparation');
    ezie.ezconnect.connect.instance().reset();
    ezie.history().reset();

    ezie.ezconnect.connect.instance().prepare({
        'url': prepare_url,
        'success': function(response) {
            $.log('image prepared, now binding');
            $.log('type of response : ' + (typeof response));
            // We achieve setting the values for ezie.ezconnect
            ezie.ezconnect.connect.instance().set({
                'key': response.key,
                'image_id': response.image_id,
                'image_version': response.image_version,
                'history_version': response.history_version,
                'module_url': response.module_url
            });

            $.log('connexion preparation')

            ezie.gui.eziegui.getInstance().setImages(response.image_url, response.thumbnail_url);
            ezie.gui.config.zoom().init();
            $.log('prepared');
        },
        'complete': function() {
            ezie.gui.eziegui.getInstance().main().hideLoading();
        }
    });
};

