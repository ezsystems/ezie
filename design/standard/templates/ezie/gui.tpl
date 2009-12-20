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
                        'ezie.gui.config.bind.filter_grain.js',
                        'ezie.gui.config.bind.menu_edit.js',
                        'ezie.gui.config.bind.menu_file.js',
                        'ezie.gui.config.bind.menu_help.js',
                        'ezie.gui.config.bind.menu_close_without_saving.js',
                        'ezie.gui.config.bind.menu_save_and_close.js',
                        'ezie.gui.config.bind.tool_flip_hor.js',
                        'ezie.gui.config.bind.tool_flip_ver.js',
                        'ezie.gui.config.bind.tool_img.js',
                        'ezie.gui.config.bind.tool_pot.js',
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

{ezcss_require( array(  'ezie.css',
                        'slider.css',
                        'imgareaselect-animated.css',
                        'colorpicker.css',
                        'vtip.css',
                        'jquery.Jcrop.css',) )}

<div id="ezieMainContainer">
    <div class="ezieBox drawZone" id="ezieMainWindow">
        <div class="topBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="topBarContent">
                <h2>eZ Image Editor</h2>
                <ul id="window">
                    <!--<li><a id="ezie_expand" class="smallUi" href=""></a></li>-->
                    <li><a id="ezie_close" href="#"></a></li>
                </ul>
            </div>
        </div>
        <div class="contentLeft"><div class="contentRight">
                <div class="content" id="resize">
                    <ul class="topMenu">
                        <li><a href="" id="ezie_save_and_close" title="Save and Close this interface">Save & Close</a></li>
                        <li><a href="" id="ezie_quit_without_saving" title="Close this interface without saving">Quit</a></li>
                    </ul>
                    <div id="grid">
                        <span id="main_image">
                        </span>
                    </div>
                    <div id="sideBar" class="detachBox">
                        <div class="topMenu">
                            <h2>Thumbnail</h2>
                            <a class="sep" href="#"></a>
                        </div>
                        <div id="miniature">

                        </div>
                        <div id="toolsOptions">
                            <div id="optsGrain" class="opts">
                                <div class="topMenu"><h2>Grain</h2></div>
                                <div class="slider"></div>
                            </div>
                            <div id="optsWatermark" class="opts">

                            </div>
                        </div>

                        <div id="optsRotation" class="opts">
                            <div class="topMenu"><h2>Rotation</h2></div>
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

                            <!--ul class="tools">
                                <li><a id="ezie_rotation_left" class="vtip" title="90° counter-clockwise rotation" href="#"></a></li>
                                <li><a id="ezie_rotation_right" class="vtip" title="90° clockwise rotation" href="#"></a></li>
                            </ul-->
                            <!--label for="cw"><input id="cw" type="radio" name="clockwise"  value="yes" checked="checked" />Clockwise</label>
                            <label for="ccw"><input id="ccw" type="radio" name="clockwise" value="no"  />Counter-clockwise</label-->
                            <input type="hidden" name="color" value="FFFFFF" />
                            <div id="colorSelector"><div style="background-color: #ffffff"></div></div>
                            <button type="button">Ok</button>
                        </div>
                        <div id="optsZoom" class="opts">
                            <div class="topMenu"><h2>Zoom</h2></div>
                            <ul class="tools">
                                <li class="current"><a id="zoomIn" href="#"></a></li>
                                <li><a id="zoomOut" href="#"></a></li>
                            </ul>
                            <button id="actualPixels">Actual pixels</button>
                            <button id="fitOnScreen">Fit on screen</button>
                        </div>

                        <div id="optsWatermarks" class="opts">
                            <div class="topMenu"><h2>Watermarks</h2></div>

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

                            <ul>
                                <li><img class="ezie-watermark-image" src={'watermarks/ez-logo.png'|ezimage()} alt="ez watermark" /></li>
                                <li><img class="ezie-watermark-image" src={'watermarks/elephpant.png'|ezimage()} alt="elephpant watermark" /></li>
                                <li><img class="ezie-watermark-image" src={'watermarks/logo_chrome.png'|ezimage()} alt="elephpant watermark" /></li>
                                <li><img class="ezie-watermark-image" src={'watermarks/logo_opera.png'|ezimage()} alt="elephpant watermark" /></li>
                                <li><img class="ezie-watermark-image" src={'watermarks/logo_safari.png'|ezimage()} alt="elephpant watermark" /></li>
                                <li><img class="ezie-watermark-image" src={'watermarks/logo_firefox.png'|ezimage()} alt="elephpant watermark" /></li>
                                <li><img class="ezie-watermark-image" src={'watermarks/logo_ie.png'|ezimage()} alt="elephpant watermark" /></li>
                            </ul>
                            
                            <button class="submit">Apply</button>
                        </div>
                    </div>
                </div>
        </div></div>
        <div class="bottomBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="bottomBarContent">
                <p>Status, informations...</p>
                <div id="loadingBar"></div>
            </div>
        </div>
    </div>


    <div class="ezieBox" id="ezieToolsWindow">
        <div class="topBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="topBarContent">
                <h2>Actions</h2>
            </div>
        </div>
        <div class="contentLeft"><div class="contentRight">
                <div class="content">
                    <div class="section">
                        <div class="sectionHeader">
                            <h4>Tools</h4>
                        </div>
                        <div class="sectionContent">
                            <ul class="tools">
                                <li><a class="vtip" id="ezie_select" href="" title="Select"></a></li>
                                <li class="less"><a class="vtip" id="ezie_undo" href="" title="Undo"></a></li>
                                <li class="less"><a class="vtip" id="ezie_redo" href="" title="Redo"></a></li>
                                <li class="current"><a class="vtip" id="ezie_zoom" href="" title="Zoom"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section">
                        <div class="sectionHeader">
                            <h4>Image</h4>
                        </div>
                        <div class="sectionContent">
                            <ul class="filters">
                                <li><a href="" id="ezie_flip_hor" title="Horizontal Flip">Horizontal Flip</a></li>
                                <li><a href="" id="ezie_flip_ver" title="Vertical Flip">Vertical Flip</a></li>
                                <li class="more"><a href="" id="ezie_rotation" title="Rotation">Rotation</a></li>
                                <li><a href="" id="ezie_crop" title="Crop">Crop</a><span id="ezie_alternative_crop_text">Perform Crop</span></li>
                                <li class="more"><a href="" id="ezie_watermark" title="Watermark">Watermark</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section">
                        <div class="sectionHeader">
                            <h4>Effects</h4>
                        </div>
                        <div class="sectionContent">
                            <ul class="filters">
                                <li><a href="" id="ezie_pixelate" title="Pixelate">Pixelate</a></li>
                                <li><a href="" id="ezie_blackandwhite" title="Black and White">Black and White</a></li>
                                <li><a href="" id="ezie_sepia" title="Sepia">Sepia</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div></div>
        <div class="bottomBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="bottomBarContent">
                <p>Status</p>
            </div>
        </div>
    </div>

    <div class="ezieBox" id="ezieOptsWindow">
        <div class="topBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="topBarContent">
                <h2>Options</h2>
            </div>
        </div>
        <div class="contentLeft"><div class="contentRight">
                <div class="content">

                </div>
        </div></div>
        <div class="bottomBar">
            <div class="leftCorner"></div><div class="rightCorner"></div>
            <div class="bottomBarContent">
                <p>Status</p>
            </div>
        </div>
    </div>


    <div id="ezieControlBar"></div>
</div>
