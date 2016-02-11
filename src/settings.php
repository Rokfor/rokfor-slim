<?php
return [
    'settings' => [
        'projectname'                         => "ROKFOR",
        'version'                             => "3.0.0-alpha",
        'copy'                                => "<strong>Copyright © 2016 <a href='http://rokfor.ch' target='_blank'>Rokfor</a>.</strong> All rights reserved.",
        'timezone'                            => "Europe/Zurich",
        'locale'                              => 'de_DE',
        'displayErrorDetails'                 => true, // set to false in production
        'determineRouteBeforeAppMiddleware'   => true,

        // Renderer settings
        'view' => [
            'prettyprint'                     => true,
            'template_path'                   => __DIR__ . '/../templates/',
            'cache_path'                      => __DIR__ . '/../cache/',
        ],

        // Monolog settings
        'logger' => [
            'name'                            => 'slim-app',
            'path'                            => __DIR__ . '/../logs/app.log',
        ],

        // Database settings
        'db' => [
            'host'                            => 'localhost',
            'user'                            => '****',
            'pass'                            => '****',
            'dbname'                          => 'pdf_chlit',
            'log'                             => __DIR__ . '/../logs/propel.log'
        ],
        
        // Translations
        
        'translations' => [
            'strings'                         =>  require __DIR__ . '/translations.php'
        ],
        
        // Browser Accessible Routes

        'browser' => [        
            '/rf/login',
            '/rf/logout',
            '/rf/dashboard',
            '/rf/',
            '/rf',
        ],
        
        // Files Paths and Upload Handling

        'paths'   => [
          'sys'                                => __DIR__. '/../public/udb/',
          'systhumbs'                          => __DIR__. '/../public/udb/thumbs/',
          'web'                                => '/udb/',
          'webthumbs'                          => '/udb/thumbs/',
          'thmbsuffix'                         => '-thmb.jpg',
          'scaled'                             => '-preview[*].jpg',
          'quality'                            =>  75,
          'process'                            => ['image/jpg', 'image/png', 'image/gif'],
          'store'                              => ['application/zip', 'video/quicktime', 'video/mp4', 'video/webm', 'audio/mp3', 'application/pdf'],
          'icon'                               => 'thumb.jpg'
        ],
        
        'fieldtypes' => [
          'TypologyCloud',
          'TypologySelect',
          'TypologyKeyword',
          'TypologyMatrix',
          'TypologySlider',
          'Zahl',
          'Tabelle',
          'Bild',
          'Text',
          'Locationpicker',
          '*Ausgeschaltet*',
        ]
        
    ]
];
