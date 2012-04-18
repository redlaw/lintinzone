<?php
$db_config = array(
	'host' => 'localhost',
	'username' => 'tung',
	'password' => 'tungduy',
	'dbname' => 'gec_db'
);

//@todo: later implementation would divide different logs' types into different files. Also, the logs would be stored by date and by status (issue or resolved).
$log_config = array(
	'mode' => 'file', // there would be other modes, such as database, firebug...
	'filepath' => realpath(dirname(__FILE__) . '/../logs') . DIRECTORY_SEPARATOR . 'exceptions.log',
	'db_table' => '' // if the mode is database, then, this field defines the table to insert logs into.
);
