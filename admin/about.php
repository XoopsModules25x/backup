<?php
include '../../../include/cp_header.php';
include 'admin_header.php';
xoops_cp_header();

$module_info =& $module_handler->get($xoopsModule->getVar("mid"));

$aboutAdmin = new ModuleAdmin();

echo $aboutAdmin->addNavigation('about.php');
echo $aboutAdmin->renderabout('xoopsfoundation@gmail.com', false);

include 'admin_footer.php';
