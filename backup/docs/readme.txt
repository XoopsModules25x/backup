XOOPS Backup & Restore
===================

A module to allow you to easily backup and/or restore your mysql database

installation:
=============
create a folder (upload/backup is suggested) for storing backup files
chmod the folder to 777
Install the module as usual in xoops  (system admin - modules)
If you would create a cron job so that the database can be automatically backup, the URL shall be: YourXoopsUrl/modules/backup/admin/backup.php

Features:
=============
1 backup XOOPS data and store in three ways: on the server, download immediately(admin only) or sent by email(URL or attachments)
2 tables can be select to be exported separately. useful for large tables
3 file number stored on local server can be configured
4 backup can be made by admin or via cronjob
5 restore XOOPS data from db files exported the module or by any db management script like phpmyadmin
6 capable for large file import by multiple sessions
7 restore can be done by non-webmaster, useful for XOOPS user related date restore.
8 timeout issues have been efficiently solved