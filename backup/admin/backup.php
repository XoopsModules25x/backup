<?php
//  ------------------------------------------------------------------------ //
// Author: D.J.(phppp) php_pp@hotmail.com                                    //
// URL: http://xoops.org.cn                                                  //
// ------------------------------------------------------------------------- //
include_once '../../../include/cp_header.php';
include 'admin_header.php';
$module_handler =& xoops_gethandler('module');
$xoopsModule =& $module_handler->getByDirname('backup');
$config_handler = & xoops_gethandler( 'config' );
$xoopsModuleConfig = & $config_handler->getConfigsByCat( 0, $xoopsModule->getVar( 'mid' ) );

include_once(XOOPS_ROOT_PATH.'/modules/backup/include/defines.lib.php');
include_once(XOOPS_ROOT_PATH.'/modules/backup/include/build_dump.lib.php');
include_once(XOOPS_ROOT_PATH.'/modules/backup/include/zip.lib.php');
include_once(XOOPS_ROOT_PATH."/class/xoopslists.php");

ini_set("memory_limit", "512M");
$cfgBackupTarget = $xoopsModuleConfig['cfgBackupTarget'];
$drop = $xoopsModuleConfig['drop'];
$cfgZipType = $xoopsModuleConfig['cfgZipType'];
$cfgExecTimeLimit = $xoopsModuleConfig['cfgExecTimeLimit'];
$use_backquotes = $xoopsModuleConfig['use_backquotes'];

$other_tables = (!isset($_POST['tables']))?false:$_POST['tables'];
$db_name = (isset($_GET['db_name']))?$_GET['db_name']:XOOPS_DB_NAME;

if ($db_name) {
$db_selected = mysql_select_db($db_name);
    if (!$db_selected) {
    redirect_header('index.php', 3, 'Database not exist');
    exit;
    }
}

$server = $db_name;
function PMA_myHandler($sql_insert)
{
    global $tmp_buffer;
    $eol_dlm = (isset($GLOBALS['extended_ins']) && ($GLOBALS['current_row'] < $GLOBALS['rows_cnt']))
             ? ','
             : ';';
    $tmp_buffer .= $sql_insert . $eol_dlm . $GLOBALS['crlf'];
}

function PMA_whichCrlf()
{
    $the_crlf = "\n";
    if (PMA_USR_OS == 'Win') {
        $the_crlf = "\r\n";
    }
    else if (PMA_USR_OS == 'Mac') {
        $the_crlf = "\r";
    }
    else {
        $the_crlf = "\n";
    }

    return $the_crlf;
}

$err_url = XOOPS_URL;

@set_time_limit($cfgExecTimeLimit);
$crlf        = PMA_whichCrlf();

if (($cfgZipType == 'bzip') && (PMA_PHP_INT_VERSION >= 40004 && @function_exists('bzcompress'))) {
    $ext       = 'bz2';
    $mime_type = 'application/x-bzip';
} else if (($cfgZipType == 'gzip') &&(PMA_PHP_INT_VERSION >= 40004 && @function_exists('gzencode'))) {
    $ext       = 'gz';
    $mime_type = 'application/x-gzip';
} else if (($cfgZipType == 'zip') && (PMA_PHP_INT_VERSION >= 40000 && @function_exists('gzcompress'))) {
    $ext       = 'zip';
    $mime_type = 'application/x-zip';
} else {
    $ext       = 'sql';
    $cfgZipType = 'none';
    $mime_type = (PMA_USR_BROWSER_AGENT == 'IE' || PMA_USR_BROWSER_AGENT == 'OPERA')
               ? 'application/octetstream'
               : 'application/octet-stream';
}
$db        = $db_name;
$sql        = "SHOW TABLES FROM $db";
$tables    = mysql_query($sql);
$num_tables = @mysql_numrows($tables);

$dirname = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig["dbfiles_path"];
$prefix = 'bkp';

if ($num_tables == 0) {
    echo '# ' ._DB_NOTABLESFOUND;
    if(isset($_GET['oldurl'])){
        redirect_header($_GET['oldurl'], 3, _DB_BACKUP_READY );
    }else{
        redirect_header("javascript:history.go(-1)", 1, _DB_BACKUP_READY );
    }
    exit;
}

$filename_prefix = $prefix.'_'.$db.'-'.date('ymdHi');
if (!$other_tables) {
$split = (is_array($xoopsModuleConfig["dbfiles_split"])&&count($xoopsModuleConfig["dbfiles_split"])>0)?$xoopsModuleConfig["dbfiles_split"]:array("1");
} else {
$split = (is_array($other_tables)&&count($other_tables)>0)?$other_tables:array("1");
}
$files_backup=array();
for($i=0; $i<$num_tables; $i++){
    $name = mysql_tablename($tables, $i);
    if(in_array("1",$split)||in_array($name, $split)){
        $files_backup[$name] = array($name);
    }else{
    if ($xoopsModuleConfig['split']==1) $files_backup["body"][] = $name;
    }
}

$formatted_db_name = (isset($use_backquotes))
                   ? PMA_backquote($db)
                   : '\'' . $db . '\'';
foreach($files_backup as $fl => $names){
    if ($xoopsModuleConfig['split']==1) {
    $filename = ($fl == "body")?$filename_prefix:$filename_prefix."_".$fl;
    } else {
    $filename = $filename_prefix."_".$fl;
    }
    $dump_buffer       = '# Backup for MySQL' . $crlf
                       .  '#' . $crlf;
    foreach ($names as $table) {
        $formatted_table_name = (isset($use_backquotes))
                              ? PMA_backquote($table)
                              : '\'' . $table . '\'';
        $dump_buffer .= '# --------------------------------------------------------' . $crlf
                     .  $crlf . '#' . $crlf
                     .  '# ' ._DB_TABLESTRUCTURE. ' ' . $formatted_table_name . $crlf
                     .  '#' . $crlf . $crlf
                     .  PMA_getTableDef($db, $table, $crlf, $err_url) . ';' . $crlf;

        $tcmt = $crlf . '#' . $crlf
                     .  '# ' ._DB_DUMPINGDATA. ' ' . $formatted_table_name . $crlf
                     .  '#' . $crlf .$crlf;
        $dump_buffer .= $tcmt;
        $tmp_buffer  = '';
        if (!isset($limit_from) || !isset($limit_to)) {
            $limit_from = $limit_to = 0;
        }
        PMA_getTableContent($db, $table, $limit_from, $limit_to, 'PMA_myHandler', $err_url);
        $dump_buffer .= $tmp_buffer;
    }
    $dump_buffer .= $crlf;
    $dump_buffer=str_replace(' DEFAULT CHARSET=latin1', '', $dump_buffer);
    $dump_buffer=str_replace(' DEFAULT CHARSET=utf8', '', $dump_buffer);

    if ($cfgZipType == 'zip') {
        if (PMA_PHP_INT_VERSION >= 40000 && @function_exists('gzcompress')) {
            $extbis = '.sql';
            $zipfile = new zipfile();
            $zipfile -> addFile($dump_buffer, $filename . $extbis);
            $dump_buffer = $zipfile -> file();
        }
    }
    else if ($cfgZipType == 'bzip') {
        if (PMA_PHP_INT_VERSION >= 40004 && @function_exists('bzcompress')) {
            $dump_buffer = bzcompress($dump_buffer);
        }
    }
    else if ($cfgZipType == 'gzip') {
        if (PMA_PHP_INT_VERSION >= 40004 && @function_exists('gzencode')) {
            // without the optional parameter level because it bug
            $dump_buffer = gzencode($dump_buffer);
        }
    }
    
    $fp = fopen($dirname.'/'. $filename . '.' . $ext,'w');
    //$dump_buffer=str_replace(' DEFAULT CHARSET=latin1','',$dump_buffer);
    fwrite($fp, $dump_buffer);
    fclose($fp);
    
    if ($cfgBackupTarget == 'download') {
        if(!is_object($xoopsUser)||!$xoopsUser->isAdmin()){
            redirect_header("javascript:history.go(-1)", 1, _NOPERM );
            exit;
         }
        header('Content-Type: ' . $mime_type);
        if (PMA_USR_BROWSER_AGENT == 'IE') {
            header('Content-Disposition: inline; filename="' . $filename . '.' . $ext . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Content-Disposition: attachment; filename="' . $filename . '.' . $ext . '"');
            header('Expires: 0');
            header('Pragma: no-cache');
        }
        echo $dump_buffer;
    } elseif ($cfgBackupTarget == 'email') {
        $subject = sprintf(_DB_BACKUP_FOR, $xoopsConfig['sitename']) ;
        $message = _DB_CREATEON.': '.date('H:i D d-M-Y')." \n" ;
        $message .= _DB_DOWNLOAD.":\n";
        $message .= XOOPS_URL."/uploads/backup/".$filename.'.'.$ext."\n\n";
        $message .= "------------------\n";
        $message .= $xoopsConfig['sitename']."\n".$xoopsConfig['xoops_url']."/";
        $xoopsMailer =& xoops_getMailer();
        $xoopsMailer->useMail();
        $emails = explode(',',$xoopsModuleConfig['email_to']);
        foreach ($emails as $key=>$value) { $emails[$key]=trim($value); }
        $xoopsMailer->setToEmails($emails);
        $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setSubject($subject);
        $xoopsMailer->setBody($message);
        if($xoopsModuleConfig['email_attach']){
            $xoopsMailer->multimailer->AddAttachment($dirname.'/'.$filename.'.'.$ext);
        }
        $xoopsMailer->send();
    }
}

$db_files =& XoopsLists::getFileListAsArray($dirname);
$dbfiles = array();
$dbprefix = array();
foreach($db_files as $_file => $_filename){
    if(preg_match("/(^".$prefix."[^_]*)(_.*)?\.(.*)/i", $_filename, $matches)){
        $dbprefix[$matches[1]] = 1;
        $dbfiles[]=$_filename;
    }
}

$dbpre = array_keys($dbprefix);
arsort($dbpre);
reset($dbpre);
$dbpre_valid = array_slice($dbpre, 0, $xoopsModuleConfig['dbfiles_store']);
foreach($dbfiles as $dbfile){
    if(!preg_match("/^(".implode("|",$dbpre_valid).")(_.*)?\.(.*)/i", $dbfile, $matches)){
        unlink($dirname.'/'.$dbfile);
    }
}

if ($cfgBackupTarget != 'download') {
    if(isset($_GET['oldurl'])){
        redirect_header($_GET['oldurl'], 3, _DB_BACKUP_READY );
    }else{
        redirect_header("javascript:history.go(-1)", 1, _DB_BACKUP_READY );
    }
}
include "admin_footer.php";
