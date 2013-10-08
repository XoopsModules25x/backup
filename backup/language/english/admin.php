<?php
define("_DB_TABLESTRUCTURE","Table structure for table");
define("_DB_DUMPINGDATA","Dumping data for table");
define("_DB_CONFIG","Configure");
//define("_DB_PERMISSIONS","Global Permissions");
define("_DB_NOTABLESFOUND","No tables found in database.");
define("_DB_BACKUP","Backup database");
define("_DB_RESTORE","Restore database");
define("_DB_CACHE","Update module config cache");
define("_DB_SELECTFILE","Select file");
define("_DB_BACKUP_FOR", 'Database Backup For %s');
define("_DB_CREATEON", 'Database Created On');
define("_DB_DOWNLOAD","Download the backup by clicking here");
define("_DB_BACKUP_READY","Database Backup Over!");
define("_AM_DBASE_FILES_DELETED","All files are been deleted");
define("_AM_DBASE_DELETE","Confirm delete?");
define("_AM_DBASE_BACKUP","Confirm backup?");

define("_DB_README","
XOOPS Backup<br /><br />

installation:<ol>
<li>create a folder (upload/backup is suggested) for storing backup files
<li>chmod the folder to 777
<li>Install the module as usual in xoops  (system admin - modules)
<li>If you would create a cron job so that the database can be automatically backup, the URL shall be: YourXoopsUrl/modules/backup/admin/backup.php
</ol>

Authors:<ul> 
<li>backup -- webmaster@nagl.ch ( http://www.nagl.ch )
<li>restore (bigdump) -- Alexey Ozerov (alexey at ozerov dot de)
<li>Integration and improvement: D.J. (phppp, http://xoops.org.cn)
</ul>
");
?>
