<?php
include '../../../include/cp_header.php';
include 'admin_header.php';
xoops_cp_header();

$module_info =& $module_handler->get($xoopsModule->getVar("mid"));

$aboutAdmin = new ModuleAdmin();

echo $aboutAdmin->addNavigation('about.php');
echo $aboutAdmin->renderabout('6KJ7RW5DR3VTJ', false);

include 'admin_footer.php';

?>
