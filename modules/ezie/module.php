<?php

$Module = array( 'name' => 'ezie' );

$ViewList = array();

$ViewList['prepare'] = array('script' => 'prepare.php',
                             'params' => array( 'node_id',
                                                'version'),
);

// FILTERS
$ViewList['filter_bw'] = array('script' => 'filter_bw.php');
$ViewList['filter_sepia'] = array('script' => 'filter_sepia.php');
$ViewList['filter_blur'] = array('script' => 'filter_blur.php');

// TOOLS
$ViewList['tool_flip_hor'] = array('script' => 'tool_flip_hor.php');
$ViewList['tool_flip_ver'] = array('script' => 'tool_flip_ver.php');
$ViewList['tool_rotation'] = array('script' => 'tool_rotation.php');
$ViewList['tool_levels'] = array('script' => 'tool_levels.php');
$ViewList['tool_saturation'] = array('script' => 'tool_saturation.php');
$ViewList['tool_pixelate'] = array('script' => 'tool_pixelate.php');
$ViewList['tool_crop'] = array('script' => 'tool_crop.php');
$ViewList['tool_watermark'] = array('script' => 'tool_watermark.php');

// MENU
$ViewList['no_save_and_quit'] = array('script' => 'no_save_and_quit.php');
$ViewList['save_and_quit'] = array('script' => 'save_and_quit.php');

$FunctionList = array();
?>
