<?php
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/include/cp_functions.php';
include("../../../include/cp_header.php");

//defined ('FRAMEWORKS_ART_FUNCTIONS_INI') || include_once XOOPS_ROOT_PATH . '/Frameworks/art/functions.ini.php' ;
if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
        //return true;
    }else{
        echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
        //return false;
    }

$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathIcon16 = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');
$pathIcon32 = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');

$myts =& MyTextSanitizer::getInstance();

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once XOOPS_ROOT_PATH . '/class/template.php' ;
    $xoopsTpl = new XoopsTpl() ;
}

//Load languages
xoops_loadLanguage('admin', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('modinfo', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('main', $xoopsModule->getVar("dirname"));
