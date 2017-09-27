<?php

if (! defined('DOWNLOAD_FILE_AUTHOR')) {
	define('DOWNLOAD_FILE_AUTHOR', 'Blis Web Agency');
	define('DOWNLOAD_FILE_AUTHOR_URL', 'http://blis.net.au');
	define('DOWNLOAD_FILE_DESC', 'Put this in a template and it will force the file you\'re calling to download');
	define('DOWNLOAD_FILE_NAME', 'Download File');
	define('DOWNLOAD_FILE_VER', '1.0.2');
}

return array(
	'author' => DOWNLOAD_FILE_AUTHOR,
	'author_url' => DOWNLOAD_FILE_AUTHOR_URL,
	'description' => DOWNLOAD_FILE_DESC,
	'name' => DOWNLOAD_FILE_NAME,
	'namespace' => 'Blis\DownloadFile',
	'version' => DOWNLOAD_FILE_VER
);