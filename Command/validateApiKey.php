#!/usr/local/bin/php

<?php
$apikey = $_ENV["PASS"];
$apikey = escapeshellarg($apikey);

if (preg_match('/^\'[A-Za-z0-9]+\'$/', $apikey)) {
	$cmd = "curl -s -f -H 'apikey: " . $apikey . "' http://localhost/api/status/ngen/version.json";
	exec($cmd, $output, $exitcode);
	exit($exitcode);
}
else {
	exit(1);
}
?>
// valido -> exit(0)
// invalid -> exit(1)

