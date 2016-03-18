<?php

/**
 * Description.
 */
class helpers
{
    /**
   * container reference stored as class var.
   *
   * @var string
   */
  private $container;

    public function __construct(&$_container)
    {
        $this->container = $_container;
        $this->Parsedown = new Parsedown();
    }

  /**
   * return the previous and next contribution id of a specified contribution
   * within a certain chapter and issue.
   *
   * @param \Childobject\Issue $issue 
   * @param \Childobject\Format $format 
   * @param \Childobject\Contribution $contribution 
   *
   * @return array
   *
   * @author Urs Hofer
   */
  public function PrevNextContribution(&$contribution)
  {
      $issue = $contribution->getIssues();
      $format = $contribution->getFormats();
      $_p = $this->container->db->getContributions($issue->getId(), $format->getId())
            ->filterBySort($contribution->getSort() - 1)
            ->findOne();
      $_n = $this->container->db->getContributions($issue->getId(), $format->getId())
            ->filterBySort($contribution->getSort() + 1)
            ->findOne();
    /*
    TODO: Does not work if sort is a irregular row of numbers
    $issue = $contribution->getIssues();
    $format = $contribution->getFormats();
    $_p = $this->container->db->getContributions($issue->getId(), $format->getId())
            ->filterBySort($contribution->getSort(), '<')
            ->orderBySort('desc')
            ->limit(1)
            ->findOne();
    $_n = $this->container->db->getContributions($issue->getId(), $format->getId())
            ->filterBySort($contribution->getSort(), '>')
            ->orderBySort('asc')
            ->findOne();
    */
    return [$_p ? $_p->getId() : false, $_n ? $_n->getId() : false];
  }

  /**
   * return an array with infos about 
   * - chapters, where the passed contribution fits in
   * - contributions with the same template
   * - templates within the same chapter.
   *
   * @param string $contribution 
   *
   * @author Urs Hofer
   */
  public function ContributionDropdownHelper(&$contribution)
  {
      $template = $contribution->getTemplatenames();
      $chapter = $contribution->getFormats();
    // Contributions with the same Template (import)
    $contributions = [];
      foreach ($this->container->db->getContributionsByTemplate($template)->orderByForissue()->orderByName() as $key => $value) {
          $contributions[$value->getIssues()->getName()]['name'] = $value->getIssues();
          $contributions[$value->getIssues()->getName()]['data'][] = $value;
      }
    // Templates within the same chapter (change template)
    $templates = $this->container->db->getTemplatenamesByFormats($chapter)->orderByName();

    // Issues and Chapters
    $formats = [];
      foreach ($template->getFormatss() as $format) {
          foreach ($format->getBooks()->getIssuess() as $issue) {
              $formats[$issue->getName()]['name'] = $issue;
              $formats[$issue->getName()]['data'][] = $format;
          }
      }

      return [$contributions, $templates, $formats];
  }

  /**
   * pretty prints a time interval based on translations
   *
   * @param string $interval_in_seconds 
   * @return string
   * @author Urs Hofer
   */
  public function diffTime($interval_in_seconds) {
    $d1 = new DateTime();
    $d2 = new DateTime();
    $d2->add(new DateInterval('PT'.($interval_in_seconds).'S'));
    $difftime = "";
    foreach ($d2->diff($d1) as $t => $v) {
      if ($v>0) {
        $difftime = $v." ".$this->container->translations['diff_time_'.$t.($v==1?'1':'')];
        break;
      }
    }
    return $difftime ? $difftime : $this->container->translations['diff_time_now'];
  }


  public function timeFormatHelper($timestamp, $format) {
    if (!$format) {
      $format = 'd/m/Y H:i';
    }
    $placeholders = [
      'd/m/Y H:i:s' => 'dd/mm/yyyy hh:mm:ss', 
      'd/m/Y H:i'   => 'dd/mm/yyyy hh:mm', 
      'd/m/Y'       => 'dd/mm/yyyy', 
      'm/Y'         => 'mm/yyyy', 
      'Y'           => 'yyyy',
    ];
    $mask = [
      'd/m/Y H:i:s' => 'd/m/y h:s:s', 
      'd/m/Y H:i'   => 'd/m/y h:s', 
      'd/m/Y'       => 'd/m/y', 
      'm/Y'         => 'm/y', 
      'Y'           => 'y', 
    ];
    return [
      'placeholder' => $placeholders[$format],
      'mask'        => '"mask": "'.$mask[$format].'"',
      'value'       => @date($format, $timestamp)
    ];
  }

  /**
   * prepares the args for the contribution template
   * populates the args array which is passed as a reference.
   *
   * @param \Childobject\Contributions &$_c 
   * @param array &$args 
   *
   * @author Urs Hofer
   */
  public function prepareContributionTemplate(&$_c, &$args)
  {
      list($_p, $_n) = $this->PrevNextContribution($_c);
      list($_ddc, $_ddt, $_ddf) = $this->ContributionDropdownHelper($_c);
      $difftime = $this->diffTime(time() - $_c->getModdate());
      $args = array_merge($args,
      [
        'contribution' => $_c,
        'breadcrumb' => [['class' => 'fa-file-text-o', 'name' => $_c->getTemplatenames()->getName()]],
        'prev' => $_p,
        'next' => $_n,
        'dd_contributions' => $_ddc,
        'dd_templates' => $_ddt,
        'dd_formats' => $_ddf,
        'base_path' => '/rf/contributions/'.$_c->getIssues()->getForbook().'/'.$_c->getForissue().'/'.$_c->getForchapter(),
        'moddate' => $difftime,
        'username' => $_c->getuserSysRef() ? $_c->getuserSysRef()->getUsername() : false
      ]
    );
  }

  /**
   * prepares the structure template
   * populates args which are passed as reference.
   *
   * @author Urs Hofer
   */
  public function prepareStructureTemplate(&$args)
  {
      $args['structure'] = $this->container->db->getStructure('/rf/contributions/');
      $args['rights'] = $this->container->db->getRights();
      $args['breadcrumb'] = [
      [
        'class' => 'fa-gears',
        'name' => $this->container->translations['settings_title'],
      ],
      [
        'class' => 'fa-files-o',
        'name' => $this->container->translations['structure_title'],
      ],
    ];
  }

  /**
   * returns the schema for the json field config editor.
   *
   * @author Urs Hofer
   */
  public function prepareConfigSchema()
  {
      // Store Chapters
      $fromchapter = ['labels' => [],'id' => []];
      foreach ($this->container->db->getFormats() as $f) {
        array_push($fromchapter['labels'], $f->getName());
        array_push($fromchapter['id'], $f->getId());
      }

      // Store Issues
      $fromissue = ['labels' => [],'id' => []];
      foreach ($this->container->db->getIssues() as $i) {
        array_push($fromissue['labels'], $i->getName());
        array_push($fromissue['id'], $i->getId());        
      }

      // Store Books
      $frombook = ['labels' => [],'id' => []];
      foreach ($this->container->db->getBooks() as $b) {
        array_push($frombook['labels'], $b->getName());
        array_push($frombook['id'], $b->getId());        
      }
      
      // Store Templates
      $fromtemplate = ['labels' => [],'id' => []];
      foreach ($this->container->db->getTemplatenames() as $t) {
        array_push($fromtemplate['labels'], $t->getName());
        array_push($fromtemplate['id'], $t->getId());        
      }

      // Store Templates
      $fromfield = ['labels' => [],'id' => []];
      foreach ($this->container->db->getTemplatefields() as $t) {
        array_push($fromfield['labels'], $t->getFieldname());
        array_push($fromfield['id'], $t->getId());        
      }
      
      // Store Historytypes
      
      foreach (['books', 'issues', 'chapters', 'cloud', 'other', 'self', 'contributional', 'structural', 'fixed'] as $_ht) {
        $historytypes['id'][] = $_ht;
        $historytypes['labels'][] = $this->container->translations['field_historytype_'.$_ht];
      }

      // Todo
      $thisfields = [
        'labels' => ['fielda', 'fieldb','fieldc'],
        'id' => [1,2,3]
      ];
      
      $lengthinfluence = [
        'title'  => $this->container->translations['field_config'.'lengthinfluence'],
        'options' => [
          'collapsed' => true
        ],
        'type' => 'array',
        'propertyOrder' => 10,
        'format' => 'table',
        'items' => [
          'type' => 'object',
          'format' => 'grid',
          'title' => $this->container->translations['field_config'.'lengthinfluence'.'row'],
          'headerTemplate' => '{{ self.fieldname }}',
          'properties' => [
            'factor' => [
              'type' => 'integer',
              'format' => 'number',
              'title' => $this->container->translations['field_config'.'lengthinfluence'.'factor'],
            ], 
            'fieldname' => [
              'type'   => 'string',
              'uniqueItems' => true,
              'enum' => [],//$fromfield['id'],
              'options' => [
                'enum_titles' => $fromfield['labels'],
                'title' => [],//$this->container->translations['field_config'.'lengthinfluence'.'labels'],
              ]
            ]
          ]
        ]
      ];

      $schema = [
      'title' => 'Field Configuration',
        'type' => 'object',
        'properties' => [
            'imagesize' => [
              'title'  => $this->container->translations['field_config'.'imagesize'],
              'options' => [
                'collapsed' => true
              ],
              'propertyOrder' => 10,
              'type' => 'array',
              'format' => 'table',
              'items' => [
                'type' => 'object',
                'format' => 'grid',
                'title' => $this->container->translations['field_config'.'imagesize'.'row'],
                'properties' => [
                  'width' => [
                    'type' => 'integer',
                    'format' => 'number',
                    'title' => $this->container->translations['field_config'.'imagesize'.'width'],
                  ], 
                  'height' => [
                    'type' => 'integer',
                    'format' => 'number',
                    'title' => $this->container->translations['field_config'.'imagesize'.'height'],
                  ]
                ]
              ]
            ],
            'caption_variants' => [
              'title'  => $this->container->translations['field_config'.'imagecaptions'],
              'options' => [
                'collapsed' => true
              ],
              'propertyOrder' => 11,
              'type' => 'array',
              'format' => 'table',
              'items' => [
                'type' => 'string',
                'title' => $this->container->translations['field_config'.'imagecaption'],
              ]
            ],            
            'history' => [
              'title'  => $this->container->translations['field_config'.'history'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],
            'fullhistory' => [
              'title'  => $this->container->translations['field_config'.'fullhistory'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox',
              'watch' => [
                'hist' => 'history'
              ],
              'hidden' => '!history'
            ],            
            'growing' => [
              'title'  => $this->container->translations['field_config'.'growing'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],
            'maxlines' => [
              'title'  => $this->container->translations['field_config'.'maxlines'],
              'type' => 'integer',
              'propertyOrder' => 2
            ],
            'textlength' => [
              'title'  => $this->container->translations['field_config'.'textlength'],
              'type' => 'integer',
              'propertyOrder' => 2
            ],
            'lengthinfluence' => $lengthinfluence,
            'rtfeditor' => [
              'title'  => $this->container->translations['field_config'.'rtfeditor'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],
            'markdowneditor' => [
              'title'  => $this->container->translations['field_config'.'markdowneditor'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],            
            'codeeditor' => [
              'title'  => $this->container->translations['field_config'.'codeeditor'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],
            'editorcolumns' => [
              'title'  => $this->container->translations['field_config'.'editorcolumns'],
              'options' => [
                'collapsed' => true
              ],
              'propertyOrder' => 10,
              'type' => 'array',
              'format' => 'table',
              'items' => [
                'type' => 'object',
                'format' => 'grid',
                'title' => 'Line',
                'properties' => [
                  "lines" => [
                    'type' => 'integer',
                    'title'  => $this->container->translations['field_config'.'editorcolumns'.'lines'],
                  ], 
                  "label" => [
                    'type' => 'string',
                    'title'  => $this->container->translations['field_config'.'editorcolumns'.'label'],
                  ]
                ]
              ]
            ],
            'arrayeditor' => [
              'title'  => $this->container->translations['field_config'.'arrayeditor'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],
            'columns' => [
              'title'  => $this->container->translations['field_config'.'columns'],
              'type' => 'integer',
              'propertyOrder' => 2
            ],
            'colnames' => [
              'title'  => $this->container->translations['field_config'.'colnames'],
              'options' => [
                'collapsed' => true
              ],
              'propertyOrder' => 10,
              'type' => 'array', 
              'format' => 'table',
              'items' => [
                'type' => 'string',
                'format' => 'text',
                'title'  => $this->container->translations['field_config'.'colnames'.'labels'],
              ]
            ],
            'latitude' => [
              'title'  => $this->container->translations['field_config'.'latitude'],
              'type' => 'number',
              'propertyOrder' => 0
            ],
            'longitude' => [
              'title'  => $this->container->translations['field_config'.'longitude'],
              'type' => 'number',
              'propertyOrder' => 0
            ],
            'dateformat' => [
              'title'  => $this->container->translations['field_config'.'dateformat'],
              'type' => 'string',
              'propertyOrder' => 2,
              'uniqueItems' => true,
              'enum' => [
                'd/m/Y H:i:s', 'd/m/Y H:i', 'd/m/Y', 'm/Y', 'Y'
              ],
              'options' => [
                'enum_titles' => [
                  'dd/mm/yyyy hh:mm:ss', 'dd/mm/yyyy hh:mm', 'dd/mm/yyyy', 'mm/yyyy', 'yyyy'
                ]
              ]
            ],
            'integer' => [
              'title'  => $this->container->translations['field_config'.'integer'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],
            'resolve_foreign' => [
              'title'  => $this->container->translations['field_config'.'resolve_foreign'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],
            'multiple' => [
              'title'  => $this->container->translations['field_config'.'multiple'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],
            //cloud
            'threeDee' => [
              'title'  => $this->container->translations['field_config'.'threeDee'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],                                       
            'history_command' => [
              'title'  => $this->container->translations['field_config'.'history_command'],
              'format' => 'select',
              'propertyOrder' => -1,
              'uniqueItems' => true,
              'type'   => 'string',
              'enum' => $historytypes['id'],
              'options' => [
                'enum_titles' => $historytypes['labels'],
                'grid_columns' => 12,
              ]
            ],
            //legends
            'legends' => [
              'options' => [
                'grid_columns' => 12,
              ],
              'title'  => $this->container->translations['field_config'.'legends'],
              'propertyOrder' => 10,
              'type' => 'array', 
              'format' => 'table',
              'items' => [
                'type' => 'string'
              ]
            ],
            //fixed            
            'fixedvalues' => [
              'options' => [
                'grid_columns' => 12,
              ],
              'title'  => $this->container->translations['field_config'.'fixedvalues'],
              'propertyOrder' => 10,
              'type' => 'array', 
              'format' => 'table',
              'items' => [
                'type' => 'string',
                'title'  => $this->container->translations['field_config'.'fixedvalues'.'row'],
              ]
            ],                                       
            //issues, cloud, self, contributional            
            'restrict_to_open' => [
              'title'  => $this->container->translations['field_config'.'restrict_to_open'],
              'type' => 'boolean',
              'propertyOrder' => 0,
              'format' => 'checkbox'
            ],                                       
            // not implemented so far
            'restrict_to_book' => [
              'title'  => $this->container->translations['field_config'.'restrict_to_book'],
              'type' => 'boolean',
              'propertyOrder' => 2,
              'format' => 'checkbox'
            ],
            //issues, chapters            
            'frombook' => [
              'title'  => $this->container->translations['field_config'.'frombook'],
              'format' => 'select',
              'type'   => 'integer',
              'propertyOrder' => 1,
              'uniqueItems' => true,
              'enum' => $frombook['id'],
              'options' => [
                'enum_titles' => $frombook['labels'],
                'grid_columns' => 12,
              ]                
            ],            
            //cloud, other, self, contributional            
            'restrict_to_issue' => [
              'title'  => $this->container->translations['field_config'.'restrict_to_issue'],
              'type' => 'boolean',
              'propertyOrder' => 4,
              'format' => 'checkbox'
            ],                                       
            //cloud, other, self, contributional
            'fromissue' => [
              'title'  => $this->container->translations['field_config'.'fromissue'],
              'format' => 'select',
              'type'   => 'integer',
              'propertyOrder' => 3,
              'uniqueItems' => true,
              'enum' => $fromissue['id'],
              'options' => [
                'enum_titles' => $fromissue['labels'],
                'grid_columns' => 12,
              ]                    
            ],   
            
           //contributional,
            'restrict_to_chapter' => [
              'title'  => $this->container->translations['field_config'.'restrict_to_chapter'],
              'type' => 'boolean',
              'propertyOrder' => 6,
              'format' => 'checkbox'
            ],
            //contributional 
            'fromchapter' => [
              'title'  => $this->container->translations['field_config'.'fromchapter'],
              'format' => 'select',
              'type'   => 'integer',
              'propertyOrder' => 5,
              'uniqueItems' => true,
              'enum' => $fromchapter['id'],
              'options' => [
                'enum_titles' => $fromchapter['labels'],
                'grid_columns' => 12,
              ]                    
            ],            
            // not implemented so far
            'restrict_to_template' => [
              'title'  => $this->container->translations['field_config'.'restrict_to_template'],
              'type' => 'boolean',
              'propertyOrder' => 7,
              'format' => 'checkbox'
            ],            
            //contributional, structural
            'fromtemplate' => [
              'title'  => $this->container->translations['field_config'.'fromtemplate'],
              'format' => 'select',
              'type'   => 'integer',
              'propertyOrder' => 8,
              'uniqueItems' => true,
              'enum' => $fromtemplate['id'],
              'options' => [
                'enum_titles' => $fromtemplate['labels'],
                'grid_columns' => 12,
              ]                                    
            ],                                       
            //cloud, other
            'fromfield' => [
              'title'  => $this->container->translations['field_config'.'fromfield'],
              'format' => 'select',
              'type'   => 'integer',
              'propertyOrder' => 9,
              'uniqueItems' => true,
              'enum' => $fromfield['id'],
              'options' => [
                'enum_titles' => $fromfield['labels'],
                'grid_columns' => 12,
              ]                 
            ],                                       
          ],
      ];
      return json_encode($schema);
  }

  /**
   * prepares the templates template
   * populates args which are passed as reference.
   *
   * @author Urs Hofer
   */
  public function prepareTemplatesTemplate(&$args, $templateid = false)
  {
      $args['templates'] = $this->container->db->getTemplatenames()
                                             ->_if($templateid)
                                               ->filterById($templateid)
                                             ->_endif();

    // Add Books and Chapters Refences
    foreach ($args['templates'] as &$template) {
        # Get all books, highlight selected
      $checkedbooks = [];
        $availablefomats = [];
        $template->books = [];
        foreach ($template->getBookss() as $checkedbook) {
            array_push($checkedbooks, $checkedbook->getId());
        }
        foreach ($this->container->db->getBooks() as $book) {
            $selected = in_array($book->getId(), $checkedbooks);
            array_push($template->books, ['id' => $book->getId(), 'name' => $book->getName(), 'selected' => $selected]);
        }
      // Get all formats of selected books, highlight selected
      $checkedformats = [];
      $availablefomats = $this->container->db->getFormats()->filterByForbook($checkedbooks);
      $template->formats = [];
      foreach ($template->getFormatss() as $checkedformat) {
          array_push($checkedformats, $checkedformat->getId());
      }
      foreach ($availablefomats as $format) {
          $selected = in_array($format->getId(), $checkedformats);
          array_push($template->formats, ['id' => $format->getId(), 'name' => $format->getName(), 'selected' => $selected]);
      }
      // Add rights for template
      $template->rights = [];
      $checkedrights = [];
      $availablerights = $this->container->db->getRights();

      foreach ($template->getRightss() as $checkedright) {
          array_push($checkedrights, $checkedright->getId());
      }      
      foreach ($availablerights as $right) {
          $selected = in_array($right->getId(), $checkedrights);
          array_push($template->rights, ['id' => $right->getId(), 'name' => $right->getGroup(), 'selected' => $selected]);
      }
            
      if ($templateid) {
        $args['template'] = $template;
        break;
      }
    }
    $args['schema'] = $this->prepareConfigSchema();
    $args['breadcrumb'] = [
      [
        'class' => 'fa-gears',
        'name' => $this->container->translations['settings_title']
      ],
      [
        'class' => 'fa-paper-plane-o',
        'name' => $this->container->translations['templates_title']
      ]
    ];
  }


  /**
   * prepares the return array for a field if accessed over the json api
   *
   * @return void
   * @author Urs Hofer
   */
  public function prepareApiData($field, $compact = true) {
    if (!$field) return false;
    $t = $field->getTemplates();
    // Parse Json if it is a json field
    $_content = $field->getIsjson() ? json_decode($field->getContent()) : $field->getContent();

    // Parse & Prepare Image Content
    $_fieldsettings = json_decode($t->getConfigSys());
    if ($t->getFieldtype() == "Bild") {
      $_protocol = '//';
      foreach ($_content as &$_row) {
        $_versions = [];
        $_versions['thumbnail'] = $_protocol.$_SERVER['HTTP_HOST'].$this->container->paths['webthumbs'].$_row[1].$this->container->paths['thmbsuffix'];
        $_versions['original'] = $_protocol.$_SERVER['HTTP_HOST'].$this->container->paths['web'].$_row[1];
        foreach ($_fieldsettings->imagesize as $key => $value) {
          $_versions['resized'][] = $_protocol.$_SERVER['HTTP_HOST'].$this->container->paths['web'].$_row[1].'-preview'.$key.'.jpg';
        }
        $_row = [
          "files" => $_versions,
          "captions" => $_row[0]
        ];
      }
    }
    
    // Recursively resolve foreign Data
    $_nc = false;
    if ($t->getFieldtype() == "TypologySelect" || $t->getFieldtype() == "TypologyKeyword") {
      $_nc = [];
      foreach ((is_array($_content) ? $_content : [$_content]) as $_value) {
        if ($_value >= 0) {
          switch ($_fieldsettings->history_command) {
            // Just Loading Objects
            case 'books':
              $_nc[$_value] = $this->container->db->getBooks()->filterById($_value)->find()->toArray();
              break;
            case 'issues':
              $_nc[$_value] = $this->container->db->getIssues()->filterById($_value)->find()->toArray();
              break;
            case 'chapters':
              $_nc[$_value] = $this->container->db->getFormats()->filterById($_value)->find()->toArray();
              break;
            case 'structural':
              $_nc[$_value] = $this->container->db->getTemplatefields()->filterById($_value)->find()->toArray();
              break;
            case 'fixed':
              $_nc[$_value] = $_fieldsettings->fixedvalues[$_value];
              break;
            case 'self':
              $_nc[$_value] = $_value;
              break;
              // Resolve Field Content
            case 'other':
              if ($_f = $this->container->db->getField($_value))
                $_nc[$_value] = $this->prepareApiData($_f, $compact);
              break;
            // Resolve Complete
            case 'contributional':
              $_c = $this->container->db->getContribution($_value);
              $_temp = [];
              foreach ($_c->getDatas() as $_f) {
                if ($_f->getId())
                  $_temp[$_f->getTemplates()->getFieldname()] = $this->prepareApiData($_f, $compact);
              }
              $_nc[$_value] = $_temp;
              break;
          } 
        }
      }
    }
    
    // Prepare Text Editors
    // echo $Parsedown->text('Hello _Parsedown_!'); # prints: <p>Hello <em>Parsedown</em>!</p>
    $_parsed = false;
    if ($t->getFieldtype() == "Text") {
      if (is_array($_content)) {
        $_parsed = [];        
        foreach ($_content as $__c) {
          if ($_fieldsettings->rtfeditor)
            $_parsed[] = strip_tags($__c);
          else if ($_fieldsettings->markdowneditor)
            $_parsed[] = $this->Parsedown->text($__c);
          else
            $_parsed[] = nl2br($__c);       
        }
      }
      else {
        if ($_fieldsettings->rtfeditor)
          $_parsed = strip_tags($_content);
        else if ($_fieldsettings->markdowneditor)
          $_parsed = $this->Parsedown->text($_content);
        else
          $_parsed = nl2br($_content);
      }
    }
          
    if ($compact) {
     $r = [
       "Id"               => $field->getId(),
//       "Fieldname"        => $t->getFieldname(),
       "Content"          => $_content
     ]; 
    }
    else {
      $r = [
        "template"  => [
          "Id"               => $t->getId(),
          "Fortemplate"      => $t->getFortemplate(),
          "Fieldname"        => $t->getFieldname(),
          "Fieldtype"        => $t->getFieldtype(),
          //"ConfigSys"        => $_fieldsettings
        ],
        "field"     => [
          "Id"               => $field->getId(),
          "Forcontribution"  => $field->getForcontribution(),
          "Fortemplatefield" => $field->getFortemplatefield(),
          "Content"          => $_content,
          "Isjson"           => $field->getIsjson()
        ]
      ];
    }
    if ($_nc) {
      $r['Reference'] = $_nc;
    }
    if ($_parsed) {
      $r['Parsed'] = $_parsed;
    }    
    return $r;
  }
  
  
  /**
   * prepares the return array for a contribution if accessed over the json api
   *
   * @return void
   * @author Urs Hofer
   */
  function prepareApiContribution($c, $compact = true)
  {
    if ($compact) {
      return [
        "Id"                      => $c->getId(),
        "Name"                    => $c->getName(),
      ];
    }
    else {
        return [
        "Id"                      => $c->getId(),
        "Fortemplate"             => $c->getFortemplate(),
        "Forissue"                => $c->getForissue(),
        "Name"                    => $c->getName(),
        "Status"                  => $c->getStatus(),
        "Newdate"                 => $c->getNewdate(),
        "Moddate"                 => $c->getModdate(),
        "Forchapter"              => $c->getForchapter()
      ];
    }
  }
}

$container = $app->getContainer();

// helper library
$container['helpers'] = function ($c) {
  return new Helpers($c);
};
