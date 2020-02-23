<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => env('SNAPPY_BIN', '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"'), //untuk windows
        // 'binary'  => '/usr/local/bin/wkhtmltopdf', //untuk linux or unix
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
