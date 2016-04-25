<?php
return [
    'settings' => [

        /*
         * General Settings
         */
        
        'projectname'       => "ROKFOR",                           // Shown in the sidebar
        'timezone'          => "Europe/Zurich",                    // Ref. http://php.net/manual/de/timezones.php
        'locale'            => 'de_DE.utf8',                       // Currently only de_DE

        /*
         * Upload Handling
         * 
         * Currently Rokfor supports storage locally in a public availble folder
         * or in the Amazon S3 cloud.
         * If you decide to store files in the cloud, the sys and systhumbs folders must
         * exist on the server as well. They are used to store temporary files but well be empty.
         * 
         */
        
        'paths'   => [
          'sys'             => __DIR__. '/../public/udb/',         // Upload directory - absolute
          'systhumbs'       => __DIR__. '/../public/udb/thumbs/',  // Thumbnail directory - absolute
          'web'             => '/udb/',                            // Upload directory - relative to document root
          'webthumbs'       => '/udb/thumbs/',                     // Thumbnail directory - relative to document root
          'thmbsuffix'      => '-thmb.jpg',                        // Extension for thumbnails
          'scaled'          => '-preview[*].jpg',                  // Extensions for scaled versions
          'quality'         =>  75,                                // Jpeg Quality
          'process'         => [                 
                                  'image/jpeg',                    // Mime Types which should be considered as
                                  'image/jpg',                     // images and scaled
                                  'image/png', 
                                  'image/gif'
                                ],
          'store'           => [
                                  'application/zip',              // Mime Types which are only moved to the repository
                                  'video/quicktime',              // directory without further processing
                                  'video/mp4',
                                  'video/webm',
                                  'audio/mp3',
                                  'application/pdf',
                                  'image/svg+xml'
                                ],
          'icon'            => 'thumb.jpg'                        // Placeholder thumbnail for stored-only files
          's3'              => false,                             // Amazon S3 Connection
          's3_aws_key'      => "",                                // Amazon S3 Key
          's3_aws_secret'   => "",                                // Amazon S3 Secret Key
          's3_aws_region'   => "",                                // Amazon S3 Region
          's3_aws_bucket'   => ""                                 // Amazon S3 Bucket Name
        ],

        /*
         * CORS Header
         *
         * Allowed Domains for R/O and R/W Api
         */
        
        'cors' => [
          'ro'  => '*',
          'rw'  => '*'
        ],

        /*
         * Paths and Error Handling
         * 
         * Unless you change something in the directory structure, there's
         * no need to change anything here
         */

        'view' => [                                               // Jade Renderer settings
          'template_path' => __DIR__ . '/../templates/',        // Path to templates
          'cache_path'    => __DIR__ . '/../cache/',            // Path to cache dir
        ],
        'logger' => [                                             // Monolog settings
          'path'          => __DIR__ . '/../logs/app.log',      // Path to Log File
          'level'         => Monolog\Logger::ERROR,             // Error Level
        ],
        'translations' => [                                       // Translations
          'strings'       => require                            // Path to translation file
                             __DIR__ .  '/../locale/translations.php'
        ],
        
        'displayErrorDetails' => false,                           // Display Error Settings: set to false in production
        

        /*
         * System Settings
         * 
         * There's no need to change anything below this point unless
         * you're implementing new features into the rokfor system.
         */

        // Needs to be true, otherwise auth does not work
        'determineRouteBeforeAppMiddleware'   => true,

        // Implemented Field Types
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
