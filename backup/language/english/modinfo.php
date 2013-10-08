<?php
define("_DB_BACKUP_NAME","XOOPS DB backup");
define("_DB_BACKUP_DESC","Backup your Database");

define("_DB_TARGET","Target");
define("_DB_ZIPTYPE","Save as file");
define("_DB_EXECTIMELIMIT","Maximum execution time in seconds (o for no limit)");
define("_DB_ALLOWBACKQUOTES","Enclose table and field names with backquotes");
define("_DB_ALLOWDROP","Add 'drop table'");

define("_DB_EMAILTO","Email addresses to be sent to");
define("_DB_EMAILTO_DESC","Separate by ','");
define("_DB_EMAILATTACH","Email sql file as attachment");
define("_DB_EMAILATTACH_DESC","Restricted by the file size");
define("_DB_DBFILES","Database files stored on server");
define("_DB_DBFILES_DESC","Old files will be removed");
define("_DB_DBFILES_PATH","Path for backup files");
define("_DB_DBFILES_PATH_DESC","Must be <strong>writable</strong>");
define("_DB_SINGLE_SELECT","Select all tables");
define("_DB_SINGLE_SELECT_DESC","");
define("_DB_DBFILES_SPLIT","Split file in system Database");
define("_DB_DBFILES_SPLIT_DESC","each file for each table; recommend for large table.<br />
If 'Select all tables' is in no position, can create single file saved or that's selected");
define("_DB_TABLES","Select Tables");
define("_DB_CHARSET","Destination Character Set");
define("_DB_INSERT","Insert Database");
define("_DB_DBASE","Insert database name");
define("_DB_TO_CHARSET","To charset database");
define("_DB_BACKUP_TITLE","Backup other Database");
define("_DB_CONVERT_DB","Convert Database");
define("_DB_VIEW_TABLE","View Table Content");
define("_DB_POSLINE","Use line number as indicator for file pointer position");
define("_DB_POSLINE_DESC","ftell could give a wrong result due to operation systems; using line number is inefficient but guarantee a correct result");

//3.1
define('_MI_BACKUP_ADMIN_HOME',"Home");
define("_MI_BACKUP_ADMIN_HOME_DESC","Back to Home");
define("_MI_BACKUP_ADMENU2","System Backup");
define("_MI_BACKUP_ADMENU3","Other Database");
define("_MI_BACKUP_ADMENU4","Restore or convert");
define("_MI_BACKUP_ADMENU5","Delete files");
define("_MI_BACKUP_ADMENU6","View Table");
define("_MI_BACKUP_ADMENU6_DESC","View table content");
define("_MI_BACKUP_ADMENU7","Delete Database");
define("_MI_BACKUP_ADMIN_ABOUT" , "About");
define("_MI_BACKUP_ADMIN_ABOUT_DESC" , "About this module");
?>
