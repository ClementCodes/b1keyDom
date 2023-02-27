<?php

header("Access-Control-Allow-Origin: **");

use App\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';


/**
 *  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
 *  origin.
 *
 *  In a production environment, you probably want to be more restrictive, but this gives you
 *  the general idea of what is involved.  For the nitty-gritty low-down, read:
 *
 *  - https://developer.mozilla.org/en/HTTP_access_control
 *  - https://fetch.spec.whatwg.org/#http-cors-protocol
 *
 */


return function (array $context) {


    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
