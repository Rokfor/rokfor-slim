<?php

use Base\Templates as BaseTemplates;


/**
 * Skeleton subclass for representing a row from the '_templates' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Templates extends BaseTemplates
{
  
  function GetFilteredConfigsys() {
    
    $settings     = json_decode($this->getConfigSys(), true);
    $fieldtype    = $this->getFieldtype();
    $fieldtypes   = [
      'TypologyCloud',    // 0
      'TypologySelect',   // 1
      'TypologyKeyword',  // 2
      'TypologyMatrix',   // 3
      'TypologySlider',   // 4
      'Zahl',             // 5
      'Tabelle',          // 6
      'Bild',             // 7
      'Text',             // 8
      'Locationpicker',   // 9
      '*Ausgeschaltet*',
    ];
    $params = [
      'lengthinfluence'    => [                8, ],
      'imagesize'          => [              7,   ],
      'caption_variants'   => [              7,   ],
      'history'            => [                8, ],
      'growing'            => [            6,7,   ],
      'maxlines'           => [              7,8, ],
      'textlength'         => [              7,8, ],
      'fullhistory'        => [                8, ],
      'rtfeditor'          => [                8, ],
      'markdowneditor'     => [                8, ],
      'codeeditor'         => [                8, ],
      'editorcolumns'      => [                8, ],
      'arrayeditor'        => [                8, ],
      'columns'            => [            6,     ],
      'colnames'           => [            6,     ],
      'dateformat'         => [          5,       ],
      'integer'            => [          5,       ],
      'resolve_foreign'    => [                   ],
      'legends'            => [      3,4,         ],
      'multiple'           => [  1,               ],
      'ajax'               => [  1,               ],
      'history_command'    => [0,1,2,             ],
      'fixedvalues'        => [  1,2,             ],
      'restrict_to_open'   => [0,1,2,             ],
      'restrict_to_issue'  => [0,1,2,             ],
      'restrict_to_chapter'=> [0,1,2,             ],
      'restrict_to_book'   => [0,1,2,             ],
      'restrict_to_template' => [0,1,2,             ],      
      'frombook'           => [0,1,2,             ],
      'fromchapter'        => [0,1,2,             ],
      'fromissue'          => [0,1,2,             ],
      'fromtemplate'       => [0,1,2,             ],
      'fromfield'          => [0,1,2,             ],
      'threeDee'           => [0                  ],
      'latitude'           => [                  9],
      'longitude'          => [                  9],
    ];
    
    $typekey = array_search($this->getFieldtype(), $fieldtypes);
    $filteredparams = [];
    foreach ($params as $key => $typearray) {
      if (in_array($typekey, $typearray)) {
        $filteredparams[$key] = $settings[$key] ? $settings[$key] : false;
      }
    }
    return json_encode($filteredparams);
  }

}
