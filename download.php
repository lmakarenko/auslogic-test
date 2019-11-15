<?php

namespace App;

use Common\Request;

// Application entrypoint

// Load constants
require_once 'lib/constants.php';

// Initiate class autoloader
require_once 'lib/autoload.php';

// Creates FileDownloader object and calls its method to download a requested file
(new FileDownloader(
    new FileStorage(),
    [
        'inputFileName' => Request::get('file'),
        'fileName' => 'file.txt',
    ]
))
    ->download();