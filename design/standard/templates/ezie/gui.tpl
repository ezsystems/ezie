{*?template charset=utf-8?*}
{* Require jQuery, using JS Core *}
{ezscript_require( array( 'ezjsc::jquery',
                        'ezjsc::jqueryio',
                        'jquery-ui-1.7.2.custom.min.js',
                        'ezie.namespaces.js',
                        'ezie.js',
                        'ezie.ezconnect.success_default.js',
                        'ezie.ezconnect.failure_default.js',
                        'ezie.ezconnect.complete_default.js',
                        'ezie.ezconnect.connect.js',
                        'ezie.ezconnect.prepare.js',
                        'ezie.history.js',
                        'ezie.gui.js',
                        'ezie.gui.selection.js',
                        'ezie.gui.config.bind.filter_black_and_white.js',
                        'ezie.gui.config.bind.filter_sepia.js',
                        'ezie.gui.config.bind.filter_contrast.js',
                        'ezie.gui.config.bind.filter_brightness.js',
                        'ezie.gui.config.bind.menu_close_without_saving.js',
                        'ezie.gui.config.bind.menu_save_and_close.js',
                        'ezie.gui.config.bind.tool_flip_hor.js',
                        'ezie.gui.config.bind.tool_flip_ver.js',
                        'ezie.gui.config.bind.tool_redo.js',
                        'ezie.gui.config.bind.tool_select.js',
                        'ezie.gui.config.bind.tool_undo.js',
                        'ezie.gui.config.bind.tool_watermark.js',
                        'ezie.gui.config.bind.tool_pixelate.js',
                        'ezie.gui.config.bind.tool_rotation.js',
                        'ezie.gui.config.bind.tool_zoom.js',
                        'ezie.gui.config.bind.tool_crop.js',
                        'ezie.gui.config.bind.opts_attach.js',
                        'ezie.gui.config.bind.opts_detach.js',
                        'ezie.gui.config.zoom.js',
                        'ezie.gui.main_window.js',
                        'ezie.gui.tools_window.js',
                        'ezie.gui.opts_window.js',
                        'ezie.gui.config.bindings.opts_items_sliders.js',
                        'ezie.gui.config.bindings.opts_items_buttons.js',
                        'ezie.gui.config.bindings.main_window.js',
                        'ezie.gui.config.bindings.tools_window.js',
                        'ezie.gui.config.bindings.opts_window.js',
                        'jquery.ezie.js',
                        'jquery.Jcrop.min.js',
                        'jquery.hotkeys.js',
                        'jquery.circular.slider.js',
                        'colorpicker/colorpicker.js',
                        'eye.js',
                        'utils.js',
                        'vtip-min.js',
                        'wait.js',
                        'ezie.js', )
                        )
}

{ezcss_require( array(  'ezie/ezie.css',
                        'ezie/slider.css',
                        'ezie/imgareaselect-animated.css',
                        'ezie/colorpicker.css',
                        'ezie/vtip.css',
                        'ezie/jquery.Jcrop.css',) )}

<div id="ezieMainContainer">
    <div class="ezieBox drawZone" id="ezieMainWindow">
        <div class="topBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="topBarContent">
                <h2>{'eZ Image Editor'|i18n('design/standard/ezie')}</h2>
                <ul id="window">
                    <li><a id="ezie_close" href="#"></a></li>
                </ul>
            </div>
        </div>
        <div class="contentLeft"><div class="contentRight">
                <div class="content" id="resize">
                    <ul class="topMenu">
                        <li><a href="" id="ezie_save_and_close" title="{'Save and Close'|i18n('design/standard/ezie')}">{'Save &amp; Close'|i18n('design/standard/ezie')}</a></li>
                        <li><a href="" id="ezie_quit_without_saving" title="{'Close without saving'|i18n('design/standard/ezie')}">{'Quit'|i18n('design/standard/ezie')}</a></li>
                    </ul>
                    <div id="grid">
                        <span id="main_image">
                        </span>
                    </div>
                    <div id="sideBar" class="detachBox">
                        <div class="topMenu">
                            <h2>{'Thumbnail'|i18n('design/standard/ezie')}</h2>
                            <a class="sep" href="#"></a>
                        </div>
                        <div id="miniature">

                        </div>

                        <div id="optsRotation" class="opts">
                            <div class="topMenu"><h2>{'Rotation'|i18n('design/standard/ezie')}</h2></div>
                            <div id="selectAngle">
                                <p class="relative">
                                    <a class="preset zero" href="javascript:void(0)">0°</a>
                                    <a class="preset halfpi" href="javascript:void(0)">90°</a>
                                    <a class="preset pi" href="javascript:void(0)">180°</a>
                                    <a class="preset threehalfpi" href="javascript:void(0)">270°</a>
                                </p>
                                <p id="circularSlider">
                                    <input type="text" name="angle" value="0" />
                                </p>
                             </div>

                            <input type="hidden" name="color" value="FFFFFF" />
                            <div id="colorSelector"><div style="background-color: #ffffff"></div></div>
                            <button type="button">{'Ok'|i18n('design/standard/ezie')}</button>
                        </div>

                        <div id="optsSelect" class="opts">
                            <div class="topMenu"><h2>{'Select'|i18n('design/standard/ezie')}</h2></div>

                            <fieldset>
                                <legend>{'Dimensions'|i18n('design/standard/ezie')}</legend>
                                <input type="text" name="selection_width" value="100" /> x
                                <input type="text" name="selection_height" value="100" />
                            </fieldset>

                            <ul class="box-content">
                                <li><input type="radio" name="selection_type" value="ratio" id="selection_type_ratio" /><label for="selection_type_ratio">{'Keep ratio'|i18n('design/standard/ezie')}</label></li>
                                <li><input type="radio" name="selection_type" value="free" id="selection_type_free" checked="checked" /><label for="selection_type_free">{'Free'|i18n('design/standard/ezie')}</label></li>
                            </ul>

                            <div id="optsCrop" class="opts">
                                <button class="submit">{'Crop'|i18n('design/standard/ezie')}</button>
                            </div>
                        </div>


                        <div id="optsZoom" class="opts">
                            <div class="topMenu"><h2>{'Zoom'|i18n('design/standard/ezie')}</h2></div>
                            <ul class="tools">
                                <li class="current"><a id="zoomIn" href="#"></a></li>
                                <li><a id="zoomOut" href="#"></a></li>
                            </ul>
                            <button class="button" id="actualPixels">{'Actual pixels'|i18n('design/standard/ezie')}</button>
                            <button class="button" id="fitOnScreen">{'Fit on screen'|i18n('design/standard/ezie')}</button>
                        </div>

                        <div id="optsWatermarks" class="opts">
                            <div class="topMenu"><h2>{'Watermarks'|i18n('design/standard/ezie')}</h2></div>

                            <div id="optsWatermarksPositions">
                                <button></button>
                                <button></button>
                                <button></button>
                                <button></button>
                                <button></button>
                                <button></button>
                                <button></button>
                                <button></button>
                                <button></button>
                            </div>

                            {def $watermarks=ezini('eZIE', 'watermarks', 'image.ini')}

                            <ul>
                                {foreach $watermarks as $wm}
                                    <li><img class="ezie-watermark-image" src={concat( 'watermarks/', $wm )|ezimage()} alt="" /></li>
                                {/foreach}
                            </ul>
                            
                            <button class="submit">{'Apply'|i18n('design/standard/ezie')}</button>
                        </div>

                        <!-- CONTRAST -->
                        <div id="optsContrast" class="opts">
                            <div class="topMenu"><h2>{'Contrast'|i18n('design/standard/ezie')}</h2></div>
                            <div>
                                <div class="slider"></div>
                                <input type="text" name="optsContrastValue" value="0" />
                            </div>
                            <button class="submit">{'Apply'|i18n('design/standard/ezie')}</button>
                        </div>

                        <!-- BRIGHTNESS -->
                        <div id="optsBrightness" class="opts">
                            <div class="topMenu"><h2>{'Brightness'|i18n('design/standard/ezie')}</h2></div>
                            <div>
                                <div class="slider"></div>
                                <input type="text" name="optsBrightnessValue" value="0" />
                            </div>
                            <button class="submit">{'Apply'|i18n('design/standard/ezie')}</button>
                        </div>

                    </div>
                </div>
        </div></div>
        <div class="bottomBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="bottomBarContent">
                <p></p>
                <div id="loadingBar"></div>
            </div>
        </div>
    </div>


    <div class="ezieBox" id="ezieToolsWindow">
        <div class="topBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="topBarContent">
                <h2>{'Actions'|i18n('design/standard/ezie')}</h2>
            </div>
        </div>
        <div class="contentLeft"><div class="contentRight">
                <div class="content">
                    <div class="section">
                        <div class="sectionHeader">
                            <h4>{'Tools'|i18n('design/standard/ezie')}</h4>
                        </div>
                        <div class="sectionContent">
                            <ul class="tools">
                                <li><a class="vtip" id="ezie_select" href="" title="{'Select'|i18n('design/standard/ezie')}"></a></li>
                                <li class="current"><a class="vtip" id="ezie_zoom" href="" title="{'Zoom'|i18n('design/standard/ezie')}"></a></li>
                                <li class="less"><a class="vtip" id="ezie_undo" href="" title="{'Undo'|i18n('design/standard/ezie')}"></a></li>
                                <li class="less"><a class="vtip" id="ezie_redo" href="" title="{'Redo'|i18n('design/standard/ezie')}"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section">
                        <div class="sectionHeader">
                            <h4>{'Image'|i18n('design/standard/ezie')}</h4>
                        </div>
                        <div class="sectionContent">
                            <ul class="filters">
                                <li><a href="" id="ezie_flip_hor" title={'Horizontal Flip'|i18n('design/standard/ezie')}">{'Horizontal Flip'|i18n('design/standard/ezie')}</a></li>
                                <li><a href="" id="ezie_flip_ver" title="{'Vertical Flip'|i18n('design/standard/ezie')}">{'Vertical Flip'|i18n('design/standard/ezie')}</a></li>
                                <li class="more"><a href="" id="ezie_rotation" title="{'Rotation'|i18n('design/standard/ezie')}">{'Rotation'|i18n('design/standard/ezie')}</a></li>
                                <li class="more"><a href="" id="ezie_crop" title="Crop">{'Crop'|i18n('design/standard/ezie')}</a><span id="ezie_alternative_crop_text">{'Perform Crop'|i18n('design/standard/ezie')}</span></li>
                                <li class="more"><a href="" id="ezie_watermark" title="{'Watermark'|i18n('design/standard/ezie')}">{'Watermark'|i18n('design/standard/ezie')}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section">
                        <div class="sectionHeader">
                            <h4>{'Effects'|i18n('design/standard/ezie')}</h4>
                        </div>
                        <div class="sectionContent">
                            <ul class="filters">
                                <li class="more"><a href="" id="ezie_contrast" title="{'Contrast'|i18n('design/standard/ezie')}">{'Contrast'|i18n('design/standard/ezie')}</a></li>
                                <li class="more"><a href="" id="ezie_brightness" title="{'Brightness'|i18n('design/standard/ezie')}">{'Brightness'|i18n('design/standard/ezie')}</a></li>
                                <li><a href="" id="ezie_pixelate" title="{'Pixelate'|i18n('design/standard/ezie')}">{'Pixelate'|i18n('design/standard/ezie')}</a></li>
                                <li><a href="" id="ezie_blackandwhite" title="{'Black and White'|i18n('design/standard/ezie')}">{'Black and White'|i18n('design/standard/ezie')}</a></li>
                                <li><a href="" id="ezie_sepia" title="{'Sepia'|i18n('design/standard/ezie')}">{'Sepia'|i18n('design/standard/ezie')}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div></div>
        <div class="bottomBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="bottomBarContent">
                <p></p>
            </div>
        </div>
    </div>

    <div class="ezieBox" id="ezieOptsWindow">
        <div class="topBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="topBarContent">
                <h2>{'Options'|i18n('design/standard/ezie')}</h2>
            </div>
        </div>
        <div class="contentLeft"><div class="contentRight">
                <div class="content">
                </div>
        </div></div>
        <div class="bottomBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="bottomBarContent">
                <p></p>
            </div>
        </div>
    </div>


    <div id="ezieControlBar"></div>
</div>
