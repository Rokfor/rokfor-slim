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
        $this->Parsedown->setBreaksEnabled(true);
    }

    public function isSSL()
    {
        if( !empty( $_SERVER['https'] ) )
            return true;

        if( !empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' )
            return true;

        if ($this->container->paths['enforce_https'])
            return true;

        return false;
    }

    /**
     * adds copyright notices and version info to args array for template rendering
     *
     * @param string $args
     * @return void
     * @author Urs Hofer
     */
    public function GetVersionInfo(&$args) {
      $composer = json_decode(file_get_contents(__DIR__ . '/../composer.json'));
      $args['commit']  = file_get_contents(__DIR__ . '/../version.txt');
      $args['release_notification'] = [];
      foreach ($_SESSION["releasenotification"] as $_notification=>$_active) {
        if ($_active === true)
          $args['release_notification'][]  = $this->Parsedown->text($this->container->translations[$_notification]);
      }
      $args['version'] = 'git';
      $args['copy'] = '&copy; <a href="'.
        $composer->homepage.
        '" target="_blank">'.
        $composer->authors[0]->name.
        "</a> ".
        date('Y').
        ". All rights reserved.";
    }


    /**
     * adds copyright notices and version info to args array for template rendering
     *
     * @param string $args
     * @return void
     * @author Urs Hofer
     */    
    public function removeNotificationFromSession($key) {
      if (is_array($_SESSION["releasenotification"]) && $_SESSION["releasenotification"][$key] !== false) {
        unset($_SESSION["releasenotification"][$key]);
      }
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
    $current = $contribution->getSort();
    $_p = $this->container->db->getContributions($issue->getId(), $format->getId(), 'desc')
          ->findOneBySort(array('max' => $current - 1));
    $_n = $this->container->db->getContributions($issue->getId(), $format->getId())
          ->findOneBySort(array('min' => $current + 1));
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


  static function timeFormatHelper($timestamp, $format) {
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
   * prepares preview links from getHelpImage
   *
   * @param \Childobject\Contributions &$_c
   * @return mixed
   *
   * @author Urs Hofer
   */
  public function createPreviewLinks($_string, $_book, $_issue, $_chapter, $_id) {
    $_previewstring = [];
    if ($_rawpreviewstring = explode(';', $_string)) {
      foreach ($_rawpreviewstring as $_p) {
        if ($_p != "") {
          $__identifier = [];
          preg_match('/\[(.*?)\]/', $_p, $__identifier);
          $_p = preg_replace('/\[(.*?)\]/', '', $_p);
          $__url = str_replace(
            [':book', ':issue',':chapter', ':id'], 
            [
              $_book,
              $_issue,
              $_chapter,
              $_id
            ],$_p);
          $_previewstring[] = [$__url, $__identifier[1] ? $__identifier[1] : 'PREVIEW'];
        }
      }
    }
    return (count($_previewstring)>0 ? $_previewstring : false);
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
        'username' => $_c->getuserSysRef() ? $_c->getuserSysRef()->getUsername() : false,
        'apikey'  => $_c->getuserSysRef() ? $_c->getuserSysRef()->getRoapikey() : false,
        'private' =>  $_c->getTemplatenames()->getPublic() == 1 ? false : true,
        's3'      => $this->container->paths['s3'] === true,
        'db' => &$this->container->db,
        'preview' => $this->createPreviewLinks(
              $_c->getTemplatenames()->getHelpimage(), 
              $_c->getIssues()->getForbook(),
              $_c->getForissue(),
              $_c->getForchapter(),
              $_c->getId()
        )
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
      $args['structure']       = $this->container->db->getStructure('/rf/contributions/');
      $args['rights']          = $this->container->db->getRights();
      $args['chapterschema']   = $this->prepareChapterSchema();
      $args['issueschema']     = $this->prepareIssueSchema();
      $args['issuebook']       = $args['issueschema']; // Right now, issue and book share the schema
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
   * returns the schema for the json chapter config editor.
   *
   * @author Urs Hofer
   */
  public function prepareChapterSchema()
  {
    // Store Chapters
    $fromchapter = ['bookbyid' => [],'labelsbybook' => [],'idbybook' => []];
    foreach ($this->container->db->getFormats() as $f) {
      if (!$fromchapter['labelsbybook'][$f->getForbook()]) {
        $fromchapter['labelsbybook'][$f->getForbook()] = [];
        array_push($fromchapter['labelsbybook'][$f->getForbook()], $this->container->translations['field_type_*Ausgeschaltet*']);
      }
      if (!$fromchapter['idbybook'][$f->getForbook()]) {
        $fromchapter['idbybook'][$f->getForbook()] = [];
        array_push($fromchapter['idbybook'][$f->getForbook()], -1);
      }
      array_push($fromchapter['labelsbybook'][$f->getForbook()], $f->getName());
      array_push($fromchapter['idbybook'][$f->getForbook()], $f->getId());
      $fromchapter['bookbyid'][$f->getId()] = $f->getForbook();
    }

    $schema = [
    'title' => 'Field Configuration',
    'type' => 'object',
    'properties' => [
        'editorcolumns' => [
          'title'  => $this->container->translations['chapter_config'.'keyvaluepairs'],
          'propertyOrder' => 3,
          'type' => 'array',
          'format' => 'table',
          'items' => [
            'type' => 'object',
            'format' => 'grid',
            'title' => 'Row',
            'properties' => [
              "key" => [
                'type' => 'string',
                'title'  => $this->container->translations['chapter_config'.'keyvaluepairs'.'key'],
              ],
              "value" => [
                'type' => 'string',
                'title'  => $this->container->translations['chapter_config'.'keyvaluepairs'.'value'],
              ]
            ]
          ]
        ],
        'locale' => [
          'title'  => $this->container->translations['chapter_config'.'locale'],
          'propertyOrder' => 2,
          'type' => 'array',
          'format' => 'table',
          'items' => [
            'type' => 'object',
            'format' => 'grid',
            'title' => 'Row',
            'properties' => [
              "language" => [
                'type' => 'string',
                'title'  => $this->container->translations['chapter_config'.'locale'.'language'],
              ],
              "translation" => [
                'type' => 'string',
                'title'  => $this->container->translations['chapter_config'.'locale'.'translation'],
              ]
            ]
          ]
        ],
        'parentnode' => [
          'title'  => $this->container->translations['chapter_config'.'parentnode'],
          'format' => 'select',
          'type'   => 'integer',
          'propertyOrder' => 1,
          'uniqueItems' => true,
          'enum' => [],
          'bookbyid' => $fromchapter['bookbyid'],
          'idbybook' => $fromchapter['idbybook'],
          'labelsbybook' => $fromchapter['labelsbybook'],

          'options' => [
            'enum_titles' => [],
            'grid_columns' => 12,
          ]
        ],
        'referenced' => [
          'type' => 'object',
          'options' => [
            'hidden' => 'true'
          ]
        ]
      ]
    ];

    return json_encode($schema);
  }

  /**
   * returns the schema for the json issue config editor.
   *
   * @author Urs Hofer
   */
  public function prepareIssueSchema()
  {

    $schema = [
    'title' => 'Field Configuration',
    'type' => 'object',
    'properties' => [
        'editorcolumns' => [
          'title'  => $this->container->translations['chapter_config'.'keyvaluepairs'],
          'propertyOrder' => 2,
          'type' => 'array',
          'format' => 'table',
          'items' => [
            'type' => 'object',
            'format' => 'grid',
            'title' => 'Row',
            'properties' => [
              "key" => [
                'type' => 'string',
                'title'  => $this->container->translations['chapter_config'.'keyvaluepairs'.'key'],
              ],
              "value" => [
                'type' => 'string',
                'title'  => $this->container->translations['chapter_config'.'keyvaluepairs'.'value'],
              ]
            ]
          ]
        ],
        'locale' => [
          'title'  => $this->container->translations['chapter_config'.'locale'],
          'propertyOrder' => 1,
          'type' => 'array',
          'format' => 'table',
          'items' => [
            'type' => 'object',
            'format' => 'grid',
            'title' => 'Row',
            'properties' => [
              "language" => [
                'type' => 'string',
                'title'  => $this->container->translations['chapter_config'.'locale'.'language'],
              ],
              "translation" => [
                'type' => 'string',
                'title'  => $this->container->translations['chapter_config'.'locale'.'translation'],
              ]
            ]
          ]
        ],
        'referenced' => [
          'type' => 'object',
          'options' => [
            'hidden' => 'true'
          ]
        ]
      ]
    ];

    return json_encode($schema);
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
        'propertyOrder' => 100,
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
              'propertyOrder' => 100,
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
              'propertyOrder' => 100,
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
              'propertyOrder' => 100,
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
            'ajax' => [
              'title'  => $this->container->translations['field_config'.'ajax'],
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
              'propertyOrder' => 100,
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
              'propertyOrder' => 100,
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
              'propertyOrder' => 9,
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
              'propertyOrder' => 10,
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
   * prepares the data for chapters, books or issues
   *
   * @param string $object
   * @param string $followrefs
   * @param string $compact
   * @param string $request
   * @return void
   * @author Urs Hofer
   */
  function prepareApiStructureInfo($object, $followrefs = false, $compact = false, $request = false) {
    if (method_exists($object, "getRDatas")) {
      $_cfg = json_decode($object->getConfigSys());
      $_refs = [];
      if ($followrefs) {
        foreach ($object->getRDatas() as $_field) {
          $_c = $_field->getContributions();
          if ($_c && in_array($_c->getStatus(),["Close","Draft"])) {

            $queryParams = [
              'data'      => $request->getQueryParams()['data'],
              'keys'      => $request->getQueryParams()['keys'],
              'populate'  => $request->getQueryParams()['populate']
            ];
            $_refs[] = array (
              "Contribution"  => $this->prepareApiContribution($_c, $compact, $queryParams),
              "Data"          => $this->prepareApiContributionData($_c, $compact, $queryParams)
            );
          }
        }
      }
      return array (
        "Id"              => $object->getId(),
        "Name"            => method_exists($object, "getName") ? $object->getName() : $object->getFieldName(),
        "ReferencedFrom"  => $_refs,
        "Localization"    => $_cfg->locale,
        "Status"          => method_exists($object, "getStatus") ? $object->getStatus() : null,
        "Options"         => method_exists($object, "getFieldType") ? $_cfg : $_cfg->editorcolumns,
        "Type"            => method_exists($object, "getFieldType") ? $object->getFieldType() : null,
        "Parent"          => $object->getParentNode()
      );
    }
    else return false;
  }

  // Scanning for {{fieldname:counter}} Elements
  // Currently, __vimeo__, __youtube__ and Upload Fields are supported.
  //
  // {{__vimeo__:VIMEOID}}
  // {{__youtube__:VIMEOID}}
  // {{FIELDNAME:index}}

  private function parse_tags($template, $contribid) {

    // Prefixing, unless it is not private and s3 has public pages

    if ($this->container->db->getUser()['config']->assetdomain && filter_var($this->container->db->getUser()['config']->assetdomain, FILTER_VALIDATE_URL) !== false) {
      $_protocol = $this->container->db->getUser()['config']->assetdomain;
    }
    else {
      $_protocol = ($this->container->paths['enforce_https'] ? 'https://' : '//' ).$_SERVER['HTTP_HOST'];
    }


    if (preg_match_all("/{{(.*?)}}/", $template, $m)) {
      foreach ($m[1] as $i => $varname) {
        list($fieldname,$id) = explode(":", $varname);

        switch ($fieldname) {
          case '__vimeo__':
            $_imgstring = '<div class="rf-embedded rf-wrapper"><iframe class="rf-embedded rf-vimeo" src="//player.vimeo.com/video/'.$id.'?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
            $template = str_replace($m[0][$i], $_imgstring, $template);
            break;
          case '__youtube__':
            $_imgstring = '<div class="rf-embedded rf-wrapper"><iframe class="rf-embedded rf-youtube" src="//www.youtube.com/embed/'.$id.'" frameborder="0" allowfullscreen></iframe></div>';
            $template = str_replace($m[0][$i], $_imgstring, $template);
            break;
          case '__iframe__':
            $_imgstring = '<div class="rf-embedded rf-wrapper"><iframe class="rf-embedded rf-youtube" src="'.$id.'" frameborder="0" allowfullscreen></iframe></div>';
            $template = str_replace($m[0][$i], $_imgstring, $template);
            break;            
          default:
            // Resolve Image Field
            $_imagefield = $this->container->db->getData()
              ->filterByForcontribution($contribid)
              ->useTemplatesQuery()
                ->filterByFieldname($fieldname)
              ->endUse()
              ->findOne();
            if ($_imagefield) {
              $_imagedata = $_imagefield->getContent();
              $_imageid   = $_imagefield->getId();
              // Parse Text Field
              if ($_row = @json_decode($_imagedata)[$id-1]) {
                if (is_array($_row[2]->scaled)) {
                  $_imgstring = '<figure class="rf-parsed"><div class="rf-container">';
                  foreach ($_row[2]->scaled as $_key=>$_scaled) {
                    $_landscape = "";
                    if (is_object($_row[3])) {
                      $_landscape  = $_row[3]->{0} > $_row[3]->{1} ? 'scaled_landscape' : 'scaled_portrait';  
                    }
                    $_imgstring .= '<img class="scaled_'.$_key.' '.$_landscape.'" src="';
                    $_imgstring .= $_protocol.$this->container->db->_add_proxy_single_file($_scaled, $private, $contribid, $_imageid);
                    $_imgstring .= '">';
                  }

                  foreach ((array)$_row[0] as $_key=>$caption) {
                    $_imgstring .= '<figcaption rf-caption class="caption_'.$_key.'">'.$caption.'</figcaption>';
                  }
                  $_imgstring .= '</div></figure>';
                  $template = str_replace($m[0][$i], $_imgstring, $template);
                }
              }
            }
            break;
        }
      }
    }
    return $template;
  }

  private function updateContentFromReferences(&$_content, &$_nc, &$field) {
    $_needs_update = false;
    if (is_array($_content) || is_object($_content)) {
      if (is_object($_content)) {
        $_content = array_values((array)$_content);
      }
      // Check for non existent values in _content - add to _content          
      foreach (array_keys($_nc) as $_indb) {
        if (!in_array($_indb, $_content)) {
          $_content[] = $_indb;
          $_needs_update = true;
        }
      }
      // Check for non existent values in relations - delete from _content
      foreach ($_content as $__key => $__vals) {
        if (!in_array($__vals, array_keys($_nc))) {
          unset($_content[$__key]);
          $_needs_update = true;
        }
      }
    }
    else {
      if (array_keys($_nc)[0] != $_content) {
        $_content = "-1";
        $_needs_update = true;
      }
    }
    if ($_needs_update) {
      // always create flat array, only if disabled set to "-1"
      if ($_content != "-1") {
        $_content = array_values($_content);
      }
      $field->setContent(json_encode($_content))->save();
    }
    if (!is_array($_content) && $_content != "-1" && $_content != null) {
      $_content = [$_content];
      foreach ($_content as &$__c) {
        if ($__c) $__c = intval($__c);
      }
    }
  }


  /**
   * prepares the return array for a field if accessed over the json api
   *
   * @return void
   * @author Urs Hofer
   */
  public function prepareApiData($field, $compact = true, $_recursion_check = [], $_fieldlist = false, $_recursion = true, $_follow_references = true, $_reference_status = ['Draft', 'Close'], $flat = false, $_keys = []) {
    /* Preliminary Checks */
    if (!$field) return false;
    if (!$field_id = $field->getId()) return false;
    if (!in_array($field->getContributions()->getStatus(), $_reference_status)) {
      return false;
    }


    /* Recursion Check */
    if (in_array($field_id, $_recursion_check)) return false;
    $_recursion_check[] = $field_id;

    $t = $field->getTemplates();
    $private = $t->getTemplatenames()->getPublic() == 1 ? false : true;

    // Parse Json if it is a json field
    $_content = $field->getIsjson() ? json_decode($field->getContent()) : $field->getContent();

    // Parse & Prepare Image Content
    $_fieldsettings = json_decode($t->getConfigSys());

    $_nc = [];
    $_parsed = false;

    if ($t->getFieldtype() == "Bild") {
      if (is_array($_content)) {

        $this->container->db->sign_request($_content, $private, $field->getForcontribution(), $field_id);
        
        if ($this->container->db->getUser()['config']->assetdomain && filter_var($this->container->db->getUser()['config']->assetdomain, FILTER_VALIDATE_URL) !== false) {
          $_protocol = $this->container->db->getUser()['config']->assetdomain;
        }
        else {
          $_protocol = ($this->container->paths['enforce_https'] ? 'https://' : '//' ).$_SERVER['HTTP_HOST'];
        }

        foreach ($_content as &$_row) {
          $_versions = [];
          $_versions['Thumbnail'] = $_protocol.$_row[2]->thumbnail;
          $_versions['Original']  = $_protocol.$_row[1];
          if (is_array($_row[2]->scaled)) {
            foreach ($_row[2]->scaled as $_scaled) {
              $_versions['Resized'][] = $_protocol.$_scaled;
            }
          }
          // Parse Captions
          $_caps_parsed = [];
          if (is_array($_row[0])) {
            foreach ($_row[0] as $_cap) $_caps_parsed[] = nl2br($_cap);
          }
          else $_caps_parsed = nl2br($_row[0]);

          if ($flat === true) {
            $_row = array_merge(
              (array)$_versions,
              ["Captions" => (array)$_caps_parsed],
              ["Sizes" => (array)$_row[3]]
            );
          }
          else {
            $_row = [
              "Files"    => $_versions,
              "Captions" => $_row[0],
              "Parsed"   => $_caps_parsed,
              "Sizes"    => ($_row[3] ? $_row[3] : false)
            ];
          }
        }
      }
    }

    // Recursively resolve foreign Data

    if ($t->getFieldtype() == "TypologySelect" || $t->getFieldtype() == "TypologyKeyword") {
      switch ($_fieldsettings->history_command) {
        // Just Loading Objects
        case 'structural':
        case 'chapters':
        case 'issues':
        case 'books':
          foreach ($field->getRelationsAsObject($_fieldsettings->history_command) as $related_object) {
            if ($related_object)
              $_nc[$related_object->getId()] = $this->prepareApiStructureInfo($related_object);
          }
          $_content = count($_nc)>0 ? array_keys($_nc) : $_content;
          break;
        // Self is plain Text. For compatibility purposes cloning content into refereneces
        case 'self':
          foreach ((array)$_content as $_value) {
              $_nc[$_value] = $_value;
          }
          break;
        // Resolve Fixed Values from Settings...
        case 'fixed':
          foreach ((array)$_content as $_value) {
              $_nc[$_value] = $_fieldsettings->fixedvalues[$_value];
          }
          break;
          // Resolve Field Content
        case 'other':
          foreach ($field->getRelationsAsObject($_fieldsettings->history_command) as $related_object) {
            if ($related_object)
              $_nc[$related_object->getId()] = $this->prepareApiData($related_object, $compact, $_recursion_check, $_fieldlist, $_recursion, $_recursion == true ? true : false, $_reference_status, $flat, $_keys);
          }
          $_content = count($_nc)>0 ? array_keys($_nc) : $_content;
          break;
        // Resolve Complete
        case 'contributional':
          foreach ($field->getRelationsAsObject($_fieldsettings->history_command) as $_c) {
            if ($_c) {
              if ($flat === true) {
                $_temp = [
                  "_id"                     => $_c->getId(),
                  "_name"                   => $_c->getName()
                ];
                foreach ($_c->getDatas() as $_f) {
                  if ($_follow_references && $_f->getId() && ($_fieldlist == false || (is_array($_fieldlist) && (in_array($_f->getTemplates()->getFieldname(), $_fieldlist)))))
                    $_temp[$_f->getTemplates()->getFieldname()] = $this->prepareApiData($_f, $compact, $_recursion_check, $_fieldlist, $_recursion, $_recursion == true ? true : false, $_reference_status, $flat, $_keys);
                }
              }
              else {
                $_temp = [
                  "__contribution__" => ["Sort" => $_c->getSort(), "Name" => $_c->getName()]
                ];
                foreach ($_c->getDatas() as $_f) {
                  if ($_follow_references && $_f->getId() && ($_fieldlist == false || (is_array($_fieldlist) && (in_array($_f->getTemplates()->getFieldname(), $_fieldlist)))))
                    $_temp[$_f->getTemplates()->getFieldname()] = $this->prepareApiData($_f, $compact, $_recursion_check, $_fieldlist, $_recursion, $_recursion == true ? true : false, $_reference_status, $flat, $_keys);
                }
              }
              $_nc[$_c->getId()] = $_temp;
            }
          }
          $this->updateContentFromReferences($_content, $_nc, $field);
        break;
      }
    }

    // Prepare Text Editors
    // echo $Parsedown->text('Hello _Parsedown_!'); # prints: <p>Hello <em>Parsedown</em>!</p>

    if ($t->getFieldtype() == "Text") {
      if (is_array($_content)) {
        $_parsed = [];
        foreach ($_content as $__c) {
          if ($_fieldsettings->rtfeditor)
            $_parsed[] = $this->parse_tags($__c, $field->getForcontribution());
          else if ($_fieldsettings->markdowneditor)
            $_parsed[] = $this->Parsedown->text($this->parse_tags($__c, $field->getForcontribution()));
          else
            $_parsed[] = nl2br($__c);
        }
      }
      else {
        if ($_fieldsettings->rtfeditor)
          $_parsed = $this->parse_tags($_content, $field->getForcontribution());
        else if ($_fieldsettings->markdowneditor)
          $_parsed = $this->Parsedown->text($this->parse_tags($_content, $field->getForcontribution()));
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
        "Template"  => [
          "Id"               => $t->getId(),
          "Fortemplate"      => $t->getFortemplate(),
          "Fieldname"        => $t->getFieldname(),
          "Fieldtype"        => $t->getFieldtype(),
          //"ConfigSys"        => $_fieldsettings
        ],
        "Field"     => [
          "Id"               => $field->getId(),
          "Forcontribution"  => $field->getForcontribution(),
          "Fortemplatefield" => $field->getFortemplatefield(),
          "Content"          => $_content,
          "Isjson"           => $field->getIsjson()
        ]
      ];
    }
    if (count($_nc)>0) {
      $r['Reference'] = $_nc;
      $r['ReferenceType'] = ucfirst($_fieldsettings->history_command);
    }
    if ($_parsed !== false) {
      $r['Parsed'] = $_parsed;
    }

    // Flat Mode: Export only content
    if ($flat === true) {
      if (count($_nc)>0) {
        $_sorted = [];
        foreach ($_content as $_key) {
          $_sorted[] = $_nc[$_key];
        }
        return $_sorted;
      }
      if ($_parsed !== false) {
        if (array_key_exists($t->getFieldname(),$_keys))
          return $_parsed[$_keys[$t->getFieldname()]];
        else
          return $_parsed;        
      }
      if (array_key_exists($t->getFieldname(),$_keys))
        return $_content[$_keys[$t->getFieldname()]];
      else
        return $_content;
    }
    else {
      return $r;
    }
    
  }

  /**
   * cycles thru all fields of a contribution and prepares the field data
   *
   * @param string $c
   * @param string $compact
   * @return array
   * @author Urs Hofer
   */
  function prepareApiContributionData($c, $compact, $request = null, $recursion = true, $_reference_status = ['Draft', 'Close'], $flat = false) {
    /* Checks */
    if (!$c) return false;
    if (!$c->getId()) return false;
    if (!$this->container->db->checkContributionAccess($c)) return false;


    $d = [];
    $_fids = [];
    $criteria = null;
    static $_oldtemplate = false;

    // Prepare Criteria if a selection of fields needs to be processed

    if ($request !== null && $request['data']) {
      // Reset fids on template change
      if ($c->getFortemplate() <> $_oldtemplate) {
        $_fids = [];
      }
      // Populate Field Ids on the first call
      if (count($_fids) == 0) {
        foreach (explode('|', $request['data']) as $fieldname) {
          $_f = $this->container->db->getTemplatefields()
                         ->filterByFieldname($fieldname)
                         ->filterByFortemplate($c->getFortemplate())
                         ->findOne();
          if ($_f) $_fids[] = $_f->getId();
        }
      }
      $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
      $criteria->add('_fortemplatefield', $_fids, \Propel\Runtime\ActiveQuery\Criteria::IN);
    }

    // Populate Data if called with populate true, if requests are omitted or a criteria is not null

    if ($request === null || $criteria !== null || $request['populate'] == "true") {
      foreach ($c->getDatas($criteria) as $field) {
        // Creating Fieldlist for further API Calls: Default: Do not resolve
        $_fieldlist = [];
        $_keys      = [];
        if ($request !== null) {
          // If fields are defined: Select Fields also for recursive calls
          if ($request['data']) {
            $_fieldlist = explode('|', $request['data']);
          }
          // If Populate is selected: Set to false (populate all data in recursive calls)
          else if($request['populate'] == "true") {
            $_fieldlist = false;
          }
          if ($request['keys']) {
            foreach(@explode('|', $request['keys']) as $_k) {
              $__k = explode(':', $_k);
              if (count($__k)==2) {
                $_keys[$__k[0]] = $__k[1];
              }
            }
          }          
        }
        $d[$field->getTemplates()->getFieldname()] = $this->prepareApiData($field, $compact, [], $_fieldlist, $recursion, true, $_reference_status, $flat, $_keys);
      }
    }


    return $d;
  }

  /**
   * prepares the return array for a contribution if accessed over the json api
   *
   * @return array
   * @author Urs Hofer
   */
  function prepareApiContribution($c, $compact = true, $request = null, $_recursion_check = [], $_recursion = true, $_follow_references = true, $_initial_state = ["Close","Draft"], $flat = false)
  {
    /* Checks */
    if (!$c) return false;
    if (!$c->getId()) return false;
    if (!$this->container->db->checkContributionAccess($c)) return false;

    /* Books */
    static $__book = [];

    /* Recursion Check */
    if (in_array($c->getId(), $_recursion_check)) return false;
    $_recursion_check[] = $c->getId();

    if (!$__book[$c->getFormats()->getForbook()]) {
      $__book[$c->getFormats()->getForbook()] = $this->container->db->getBook($c->getFormats()->getForbook());
    }
    $_book = $__book[$c->getFormats()->getForbook()];
    $_references = [];
    $_reference_object = $c->getRDataContributions();
    // Referenced Contributions
    if ($_follow_references === true) {
      foreach ($_reference_object as $_referencedContribution) {
        $_f = $_referencedContribution->getRData();
        $_c = $_f->getContributions();
        if ($_c && in_array($_c->getStatus(),$_initial_state)) {
          if ($flat === true) {
            $_references[] = array_merge(
              $this->prepareApiContribution($_c, $compact, $request, $_recursion_check, $_recursion, $_recursion == true ? true : false, $_initial_state, $flat),
              $this->prepareApiContributionData($_c, $compact, $request, true, $_initial_state, $flat)
            );
          }
          else {
            array_push($_references, [
              "ByField"       => $_f->getId(),
              "Contribution"  => $this->prepareApiContribution($_c, $compact, $request, $_recursion_check, $_recursion, $_recursion == true ? true : false, $_initial_state, $flat),
              "Data"          => $this->prepareApiContributionData($_c, $compact, $request, true, $_initial_state, $flat)
            ]);
          }
        }
      }
    }

    // FLAT
    if ($flat === true) {
      return [
        "_id"                     => $c->getId(),
        "_name"                   => $c->getName(),
        "_referenced"             => $_references,
      ];
    }


    if ($compact) {
      return [
        "Id"                      => $c->getId(),
        "Name"                    => $c->getName(),
        "Forissue"                => $c->getForissue(),
        "Forchapter"              => $c->getForchapter(),
        "Fortemplate"             => $c->getFortemplate(),
        "Forbook"                 => $_book->getId(),
        "ForissueName"            => $c->getIssues()->getName(),
        "ForchapterName"          => $c->getFormats()->getName(),
        "FortemplateName"         => $c->getTemplatenames()->getName(),
        "ForbookName"             => $_book->getName(),
        "Sort"                    => $c->getSort(),
        "Status"                  => $c->getStatus(),
        "ReferencedFrom"          => $_references,
        "ReferenceCount"          => $_reference_object ? count($_reference_object) : 0
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
        "Forchapter"              => $c->getForchapter(),
        "Forbook"                 => $_book->getId(),
        "ForissueName"            => $c->getIssues()->getName(),
        "ForchapterName"          => $c->getFormats()->getName(),
        "FortemplateName"         => $c->getTemplatenames()->getName(),
        "ForbookName"             => $_book->getName(),
        "Sort"                    => $c->getSort(),
        "ReferencedFrom"          => $_references,
        "ReferenceCount"          => $_reference_object ? count($_reference_object) : 0
      ];
    }
  }

  public function apiCall($url, $method, $data) {
    $json = json_encode($data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_TIMEOUT_MS => 1000,
      CURLOPT_NOSIGNAL => 1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));
    if ($method === "POST") {
      curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    }
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
  }

  public function triggerExporter($id, $mode, $sub, $callback = "") {
    if ($exporter = \PluginsQuery::create()->findPk($id)) {

      /* one time code */

      $uid = uniqid('otc-', true);
      $u = new \Pdf();
      $u->save();
      $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
      $token = (new \Lcobucci\JWT\Builder())->setIssuer($_SERVER['HTTP_HOST'])    // Configures the issuer (iss claim)
                              ->setAudience($_SERVER['HTTP_HOST'])  // Configures the audience (aud claim)
                              ->setId(uniqid('rf', true), true)     // Configures the id (jti claim), replicating as a header item
                              ->setIssuedAt(time())                 // Configures the time that the token was issue (iat claim)
                              ->setNotBefore(time())                // Configures the time that the token can be used (nbf claim)
                              ->set('uid', $u->getId())             // Configures a new claim, called "uid"
                              ->setExpiration(time() + 86400)        // Configures the expiration time of the token (nbf claim)
                              ->sign($signer,  $uid)      // creates a signature using "testing" as key
                              ->getToken();                         // Retrieves the generated token



      $u->setDate(time())
        ->setPlugin($exporter->getId())
        ->setPages("")
        ->setFile($callback)
        ->setIssue($sub)
        ->setConfigSys($mode)
        ->setConfigValue(1)
        ->setOtc($uid);
      $u->save();

      $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
      $criteria->addAscendingOrderByColumn(__sort__);
      $this->apiCall(
        $exporter->getApi(),
        'POST',
        [
          "ProcessId"    => $u->getId(),
          "CallbackUrl"  => 'http'.($this->isSSL()?'s':'').'://'.$_SERVER['HTTP_HOST'].'/api/exporter',
          "Token"        => (string)$token,
          "Configuration" => [
            "Book"         => $exporter->getRBooks($criteria)->toArray(),
            "Issue"        => $exporter->getRIssues($criteria)->toArray(),
            "Chapter"      => $exporter->getRFormats($criteria)->toArray(),
            "Template"     => $exporter->getTemplatenamess($criteria)->toArray()
          ],
          "Selection" => [
            "Mode"         => $mode,
            "Value"        => $sub
          ],            
        ]
      );
      return $u->getId();
    }
    return false;
  }
}




$container = $app->getContainer();

// helper library
$container['helpers'] = function ($c) {
  return new Helpers($c);
};
