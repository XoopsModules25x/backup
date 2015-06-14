<?php
include_once '../../../include/cp_header.php';
include_once 'admin_header.php';
include_once XOOPS_ROOT_PATH."/modules/" . $xoopsModule->getVar("dirname") . "/include/functions.php";
require_once XOOPS_ROOT_PATH.'/class/pagenav.php' ;

$pos = empty($_GET['pos']) ? 0 : intval( $_GET['pos']);
$num = empty($_GET['num']) ? 20 : intval( $_GET['num']);
if (!empty($_GET['table'])) $table=$_GET['table'];
if (!empty($_POST['tables'])) $table=$_POST['tables'];
if (!empty($_GET['db'])) $db=$_GET['db'];
if (!empty($_POST['db'])) $db=$_POST['db'];

if($db=="" || $table=="") redirect_header('index.php', 3, _NOPERM);

        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation('main.php?op=view');
        $tot=$xoopsDB->query("SELECT COUNT(*) FROM $db.$table");
        list($numrows)=$xoopsDB->fetchRow( $tot );
        $sql=$xoopsDB->query("SELECT * FROM $db.$table LIMIT $pos,$num");
             $nav = new XoopsPageNav( $numrows , $num , $pos , 'pos' , "op=view&num=$num&db=$db&table=$table" ) ;
             $nav_html = $nav->renderNav( 10 ) ;
        echo "<br /><div align=\"center\"><h2>$table</h2></div><br />";
        echo "<div style=\"overflow: auto;\">
		<br /><div align=\"right\">$nav_html</div><br />
		<table class='outer' cellpadding='4' cellspacing='1'>
		<tr valign='middle'>";
        $result = mysql_query("SHOW COLUMNS FROM $db.$table");
        if (!$result) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        if (mysql_num_rows($result) > 0) {
        $rows=mysql_num_rows($result);
            while ($row = mysql_fetch_assoc($result)) {
        $fields[]=$row['Field'];
            echo "<th>".$row['Field']."</th>";
            }
        }
        echo "</tr><tr>";
    $oddeven = 'odd' ;
    echo "<tr>";
    while($result=$xoopsDB->fetchArray($sql)) {
    $oddeven=($oddeven=='odd'?'even':'odd') ;
        for ($i=0; $i<$rows; $i++) {
        echo "<td class='$oddeven'>".$result[$fields[$i]]."</td>";
        }
    echo "</tr>";
    }
    echo "</table>";
    echo "<br /><div align=\"right\">$nav_html</div><br />";

include "admin_footer.php";
