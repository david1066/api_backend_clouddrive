<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['POST','PUT','DELETE','GET','OPTIONS'],

     'allowed_origins' => ['http://frontend-cloud-drive.s3-website-us-east-1.amazonaws.com','http://localhost:4200'], 

  /*   'allowed_origins' => ['*'], */

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Authorization','Origin','X-API-KEY',  'X-Requested-With', 'Content-Type', 'Accept', 'Access-Control-Request-Method','Sec-Fetch-Mode','User-Agent','Referer','Sec-Fetch-Dest','Sec-Fetch-Site','Access-Control-Request-Headers'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
