#!/usr/bin/env php
<?php
$user           = getenv('U');

$admins = array (
	'tyrael',
);

if (in_array($user, $admins)) {
	echo 'jenkins-admins';
}

exit(0);
