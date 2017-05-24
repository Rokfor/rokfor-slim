<?php
use Monolog\Processor\GitProcessor;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;


if ($container->get('settings')['multiple_spaces'] === true)  {
  $app->get('/', function ($request, $response, $args) {
    return $response->withRedirect('/rf/login');
  });
}

/* Browser Call:
 *
 * Render Logout Page
 *
 */

$app->get('/rf', function ($request, $response, $args) {return $response->withRedirect('/rf/dashboard');});


/* Rokfor Application Routes
 *
 * Routes are all grouped within the /rf Group
 *
 */

$app->group('/rf', function () {

  /* Browser Call:
   *
   * Dashboard
   *
   */

  $this->get('/dashboard', function ($request, $response, $args) {

    // Getting Remember State
    $messages = $this->flash->getMessages();
    $args['remember'] = $messages['Remember_Me'][0] === 'remember-me';

    // Project Name
    $args['project'] = $this->get('settings')['projectname'];
    // Tree
    $this->valid_paths = [];
    $args['menu'] = $this->db->getStructure('/rf/contributions/', false, $this->valid_paths);
    // Last entries
    $args['contributions'] = $this->db->getRecentLog('get_contributions', function($data){
      return $this->valid_paths[$data] ? $this->valid_paths[$data] : false;
    });
    $args['contribution']  = $this->db->getRecentLog('get_contribution', function($data){
      return $this->db->getContribution($data);
    });
    // User drop down stuff
    $args['user']  = $this->db->getUser();
    $this->helpers->GetVersionInfo($args);

    // Header
    $args['favourites'] = $this->db->getFavouriteLog('get_contributions', function($data){
      return $this->valid_paths[$data] ? $this->valid_paths[$data] : false;
    });
    $args['shortcuts'] = $this->db->getFavouriteLog('new_contribution', function($data){
      $data = json_decode($data, true);
      $_t = $this->db->getTemplatename($data[1]);
      return $this->valid_paths[$data[0]] && $_t ?
              ["destination"=>$this->valid_paths[$data[0]],"template"=> ["name" => $_t->getName(), "id" => $_t->getId()]] :
              false;
    });

    // Google Api key
    $args['google_api_key'] = $this->get('settings')['google_maps_api'];

    // Render
    $this->view->render($response, 'layout.jade', $args);
  });

  /* Ajax Call:
   *
   * Profile Page
   *
   */

  $this->get('/profile', function ($request, $response, $args) {
    // User drop down stuff
    $args['user']  = $this->db->getUser();
    $this->view->render($response, 'content-wrapper/profile.jade', $args);
  });


  /* Ajax Call:
   *
   * Profile Page - store settings
   *
   */

  $this->post('/profile', function ($request, $response, $args) {
    $form = $request->getParsedBody()['data'];
    $r = $response->withHeader('Content-type', 'application/json');
    $json = $this->view->offsetGet('csrf');
    foreach ($form as $value) {
      if ($value['name']=='action') {
        $action = $value['value'];
      }
    }
    switch ($action) {
      case 'password':
        $errors =[];
        if ($this->db->updatePassword($form[0]['value'], $form[1]['value'], $form[2]['value'], $errors)) {
          $json['success'] = $this->translations['general_success'];
          $json['message'] = $this->translations['profile_pw_updated'];
        }
        else {
          $json['error']   = $this->translations['general_error'];
          foreach ($errors as &$errmes) {
            $errmes = $this->translations[$errmes];
          }
          $json['message'] = join('<br>', $errors);
        }
        break;
      case 'profile':
        $errors =[];

        $config = $this->db->getUser()['config'];
        if (!$config)
          $config = new stdClass;
        $config->cors = [
          get => $form[5]['value'],
          postputdel => $form[6]['value'],
        ];
        if ($this->db->updateProfile($form[0]['value'], $form[1]['value'], $form[2]['value'], $errors, $form[3]['value'], $form[4]['value'], json_encode($config))) {
          $json['success'] = $this->translations['general_success'];
          $json['message'] = $this->translations['profile_updated'];
          $json['trigger']['username'] = $this->db->getUser()['username'];
        }
        else {
          $json['error']   = $this->translations['general_error'];
          foreach ($errors as &$errmes) {
            $errmes = $this->translations[$errmes];
          }
          $json['message'] = join('<br>', $errors);
        }
        break;
      default:
        $json['error']   = $this->translations['general_error'];
        $json['message'] = $this->translations['profile_error_action'];
        break;
    }
    $r->getBody()->write(json_encode($json));
    return $r;
  });

  /* Ajax Call:
   *
   * Users Page (root only)
   *
   */

  $this->get('/users', function ($request, $response, $args) {
    // User drop down stuff
    $args['users']  = $this->db->getUsers();
    $args['groups']  = $this->db->getRights();
    $this->view->render($response, 'content-wrapper/users.jade', $args);
  });

  /* Ajax Call:
   *
   * Returns User Infos as Json
   * Stores new / Updates User Data
   *
   */

  $this->map(['GET','POST'], '/user[/{id:new|[0-9]*}]', function ($request, $response, $args) {
    if ($request->getParsedBody()['data']) {
      $data = [];
      $data["group"] = [];
      foreach ($request->getParsedBody()['data'] as $key) {
        if ($key['name'] == "group")
          $data[$key['name']][] = $key['value'];
        else
          $data[$key['name']] = $key['value'];
      }
      if ($data["id"] == $args['id']) {
        // Edit an existing user
        if ($args['id'] <> "new") {
          $u = $this->db->getUsers()->findPk($args['id']);
          if (!$u) {
            $args['alert'] = $this->translations['user_not_found'];
          }
          else {
            $errors = [];
            if ($this->db->checkUser($data["username"], $data["email"], $data["password"], $args['id'], $errors)) {
              $args['alert'] = $this->translations['user_email_exists'];
              foreach ($errors as $_ekey) {
                $args["alert"]  .= "<br>".$this->translations[$_ekey];
              }
              $u = false;
            }
          }
        }
        // Add a new one. NewUser returns a new user object unless username or email already
        // exists.
        else if ($data["password"]) {
          $errors = [];
          if ($this->db->checkUser($data["username"], $data["email"], $data["password"], false, $errors)) {
            $args['alert'] = $this->translations['user_email_exists'];
            foreach ($errors as $_ekey) {
              $args["alert"]  .= "<br>".$this->translations[$_ekey];
            }
          }
          else {
            $u = $this->db->newUser();
          }
        }

        if ($u) {
          $u->setUsergroup($data["role"])
            ->setUsername($data["username"])
            ->setRightss($this->db->getRights()->filterById($data["group"])->find())
            ->setEmail($data["email"]);
          if ($data["password"]) {
            $u->setPassword(md5($data["password"]));
          }
          $u->setRoapikey($data["api"]);
          $u->setRwapikey($data["rwapi"]);
          $u->setIp($data["acl"]);
          $_config = json_decode($u->getConfigSys());
          if (!$_config) $_config = new stdClass;
          if (!$_config->cors) $_config->cors = new stdClass;
          $_config->cors->get = $data["corsget"] ? $data["corsget"] : "";
          $_config->cors->postputdel = $data["corspostdelput"] ? $data["corspostdelput"] : "";
          $u->setConfigSys(json_encode($_config));
          $u->save();
        }
      }
      $args['users']  = $this->db->getUsers();
      $args['updatecsrf'] = true;
      $this->view->render($response, 'parts/users.table.jade', $args);
    }
    else {
      $r = $response->withHeader('Content-type', 'application/json');
      $json = $this->view->offsetGet('csrf');
      if ($args['id'] == "new") {
        foreach ($this->db->getRights() as $_allright) {
          $rights[] = [id => $_allright->getId(),  name => $_allright->getGroup(), selected => false];
        }
        $json['user']  = [
          "group"     => $rights,
          "id"        => "new"
        ];
      }
      else {
        $u = $this->db->getUsers()->findPk($args['id']);
        $act_rights = [];
        foreach ($u->getRightss() as $_r) {
          $act_rights[] = $_r->getId();
        }
        $rights = [];
        foreach ($this->db->getRights() as $_allright) {
          $rights[] = [id => $_allright->getId(),  name => $_allright->getGroup(), selected => in_array($_allright->getId(), $act_rights) ? true : false];
        }

        $_config = json_decode($u->getConfigSys());
        if (!$_config) $_config = new stdClass;
        $json['user']  = [
          "username"  => $u->getUsername(),
          "email"     => $u->getEmail(),
          "role"      => $u->getUsergroup(),
          "id"        => $u->getId(),
          "password"  => "",
          "group"     => $rights,

          "api"       => $u->getRoapikey(),
          "rwapi"     => $u->getRwapikey(),
          "acl"       => $u->getIp(),
          "corsget"   => $_config->cors->get,
          "corspostdelput" => $_config->cors->postputdel
        ];
      }
      $r->getBody()->write(json_encode($json));
      return $r;
    }
  });

  /* Ajax Call:
   *
   * Returns User Table as HTML
   * Deletes a User
   *
   */


  $this->get('/user/delete/{id:[0-9]*}', function ($request, $response, $args) {
    $u = $this->db->getUsers()->findPk($args['id']);
    $u->delete();
    $args['users']  = $this->db->getUsers();
    $args['updatecsrf'] = true;
    $this->view->render($response, 'parts/users.table.jade', $args);
  });


  /* Ajax Call:
   *
   * Returns Group Infos as Json (GET) or the User Table as HTML (POST)
   * Stores new / Updates Group Data
   *
   */


  $this->map(['GET','POST'], '/group[/{id:new|[0-9]*}]', function ($request, $response, $args) {
    if ($request->getParsedBody()['data']) {
      $data = [
        id => "",
        group => "",
        rbook => [],
        rissue => [],
        rformat => [],
        rtemplate => [],
        ruser => []
      ];
      foreach ($request->getParsedBody()['data'] as $key) {
        if ($key['name'] == "group" || $key['name'] == "id")
          $data[$key['name']] = $key['value'];
        else
          $data[$key['name']][] = $key['value'];
      }
      if ($data["id"] == $args['id']) {
        if ($args['id'] == "new" && $data["group"]) {
          $u = $this->db->newRight();
        }
        else {
          $u = $this->db->getRights()->findPk($args['id']);
        }
        if ($u) {
          $u->setGroup($data['group'])
            ->setBookss($this->db->getBooks()->filterById($data["rbook"])->find())
            ->setTemplatenamess($this->db->getTemplatenames()->filterById($data["rtemplate"])->find())
            ->setFormatss($this->db->getFormats()->filterById($data["rformat"])->find())
            ->setIssuess($this->db->getIssues()->filterById($data["rissue"])->find())
            ->setUserss($this->db->getUsers()->filterById($data["ruser"])->find())
            ->save();
        }
      }
      $args['updatecsrf'] = true;
      $args['groups']  = $this->db->getRights();
      $this->view->render($response, 'parts/groups.table.jade', $args);
    }
    else {
      $r = $response->withHeader('Content-type', 'application/json');
      $json = $this->view->offsetGet('csrf');
      $json['groups'] = [
        books => [],
        templates => [],
        users => []
      ];

      $checkedbooks     = [];
      $checkedformats   = [];
      $checkedissues    = [];
      $checkedtemplates = [];
      $checkedusers     = [];

      if ($args['id'] == "new") {
        $json['groups']['id'] = "new";
      }
      else {
        $right =  $this->db->getRights()->findPk($args['id']);
        $json['groups']['name'] = $right->getGroup();
        $json['groups']['id'] = $right->getId();
        foreach ($right->getBookss() as $checkedbook)
          array_push($checkedbooks, $checkedbook->getId());
        foreach ($right->getFormatss() as $checkedformat)
          array_push($checkedformats, $checkedformat->getId());
        foreach ($right->getIssuess() as $checkedissue)
          array_push($checkedissues, $checkedissue->getId());
        foreach ($right->getUserss() as $checkeduser)
          array_push($checkedusers, $checkeduser->getId());
        foreach ($right->getTemplatenamess() as $checkedtemplate)
          array_push($checkedtemplates, $checkedtemplate->getId());

      }

      foreach ($this->db->getBooks() as $book) {
        $_issues = [];
        $_formats = [];
        foreach ($this->db->getIssues()->filterByBooks($book) as $issue)
          array_push($_issues, ['id' => $issue->getId(), 'name' => $issue->getName(), 'selected' => in_array($issue->getId(), $checkedissues)]);
        foreach ($this->db->getFormats()->filterByBooks($book) as $format) {
          $_templates = [];
          foreach ($this->db->getTemplatenames()->filterByFormats($format) as $template) {
            array_push($_templates, ['id' => $template->getId(), 'name' => $template->getName(), 'selected' => in_array($template->getId(), $checkedtemplates)]);
          }
          array_push($_formats, ['id' => $format->getId(), 'name' => $format->getName(), 'selected' => in_array($format->getId(), $checkedformats), 'templates' =>  $_templates]);
        }
        array_push($json['groups']['books'], [
          'id' => $book->getId(),
          'name' => $book->getName(),
          'selected' => in_array($book->getId(), $checkedbooks),
          'formats' => $_formats,
          'issues' => $_issues
          ]
        );
      }
      foreach ($this->db->getUsers() as $user)
        array_push($json['groups']['users'], ['id' => $user->getId(), 'name' => $user->getUsername(), 'selected' => in_array($user->getId(), $checkedusers)]);

      $r->getBody()->write(json_encode($json));
      return $r;
    }
  });

  /* Ajax Call:
   *
   * Returns Group Table as HTML
   * Deletes a Group
   *
   */


  $this->get('/group/delete/{id:[0-9]*}', function ($request, $response, $args) {
    $u = $this->db->getRight($args['id']);
    $u->delete();
    $args['updatecsrf'] = true;
    $args['groups']  = $this->db->getRights();
    $this->view->render($response, 'parts/groups.table.jade', $args);
  });


  /* Ajax Call:
   *
   * Menu Refresh
   *
   */

  $this->get('/menu', function ($request, $response, $args) {
    // Tree
    $args['project'] = $this->get('settings')['projectname'];
    $args['menu'] = $this->db->getStructure('/rf/contributions/');
    $this->view->render($response, 'parts/menu.structure.jade', $args);
  });

  /* Browser Call:
   *
   * Render Login Page
   *
   */

  $this->map(['GET', 'POST'], '/login', function ($request, $response, $args) {
    $args["message"] = $this->translations['loginIntro'];
    $this->helpers->GetVersionInfo($args);

    if ($request->isPost()) {
            $username = $request->getParsedBody()['username'];
            $password = $request->getParsedBody()['password'];
            $result = $this->authenticator->authenticate($username, $password);
            if ($result->isValid()) {
              $this->flash->addMessage('Remember_Me', $request->getParsedBody()['remember-me']);
              return $response->withRedirect('/rf/dashboard');
            }
            else {
              $args["message"] = $this->translations['loginFailed'];
            }
    }
    $this->view->render($response, 'login.jade', $args);
  });

  /* Browser Call:
   *
   * Render Logout Page
   *
   */

  $this->get('/logout', function ($request, $response, $args) {
      $this->get('authenticator')->logout();
      $args["message"] = $this->translations['logout'];
      $this->view->render($response, 'login.jade', $args);
  });

  /* Browser Call:
   *
   * Render Logout Page
   *
   */

  $this->map(['get','post'], '/forgot', function ($request, $response, $args) {
    $email = $request->getParsedBody()['email'];
    $args["showform"] = true;
    $template = 'forgot.jade';
    if ($email) {
      $q = $this->db->getUserByEmail($email);
      if ($q === false) {
        $args["message"] = $this->translations['send_reminder_fail'];
      }
      else {
        $user = $q->findOne();
        $otcstack = json_decode($user->getConfigSys());
        if (!$otcstack)
          $otcstack = new stdClass;
        $otcstack->otc = uniqid('otc-', true);
        $user->setConfigSys(json_encode($otcstack))->save();


        $signer = new Sha256();
        $token = (new Builder())->setIssuer($_SERVER['HTTP_HOST'])    // Configures the issuer (iss claim)
                                ->setAudience($_SERVER['HTTP_HOST'])  // Configures the audience (aud claim)
                                ->setId(uniqid('rf', true), true)     // Configures the id (jti claim), replicating as a header item
                                ->setIssuedAt(time())                 // Configures the time that the token was issue (iat claim)
                                ->setNotBefore(time())                // Configures the time that the token can be used (nbf claim)
                                ->setExpiration(time() + 3600)        // Configures the expiration time of the token (nbf claim)
                                ->set('uid', $user->getId())             // Configures a new claim, called "uid"
                                ->sign($signer,  $otcstack->otc)   // creates a signature using "testing" as key
                                ->getToken();                         // Retrieves the generated token

        $_mailtext = $this->translations['remember-mail'].'<br><br><a href="'.$_SERVER[HTTP_REFERER].'?otc='.$token.'">'.$this->translations['remember-mail-send'].'</a>';
        $this->get('sendmail')->sendmail($email, '[ROKFOR CMS] - Password Reminder', $_mailtext);
        $args["message"] = $this->translations['send_reminder_success'];
        $args["showform"] = false;
      }
    }
    else {
      $otc = $request->getQueryParams()['otc'] ? $request->getQueryParams()['otc'] : $request->getParsedBody()['otc'];
      if ($otc) {
        try {
          $signer = new Sha256();
          $token  = (new Parser())->parse((string) $otc); // Parses from a string
          $u      = $this->db->getUsers()->findPk((int)$token->getClaim('uid'));
          $data   = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
          $data->setIssuer($_SERVER['HTTP_HOST']);
          $data->setAudience($_SERVER['HTTP_HOST']);
        } catch (Exception $e) {
          $args["message"]  = 'Link is not valid';
          $args["showform"] = false;
        }
        if ($u) {
          $otcstack = json_decode($u->getConfigSys());
          if ($token->verify($signer, $otcstack->otc ? $otcstack->otc : "-") && $token->validate($data)) {
            $args["otc"] = $otc;
            $template = 'newpw.jade';
            $errors = [];
            if ($request->getParsedBody()['password1'] && $request->getParsedBody()['password2']) {
              if ($this->db->updateRemindedPassword($u, $request->getParsedBody()['password1'], $request->getParsedBody()['password2'], $errors)) {
                $args["message"]  = $this->translations['remember_pw_updated'];
                $otcstack->otc = null;
                $u->setConfigSys(json_encode($otcstack))->save();
                $args["showform"] = false;
              }
              else {
                $args["message"] = '<ul style="color: red; text-align: left; display: block;">';
                foreach ($errors as $_ekey) {
                  $args["message"]  .= "<li>".$this->translations[$_ekey].'</li>';
                }
                $args["message"] .= '</ul>';
              }
            }
            else {
              $args["message"]  = $this->translations['remember_pw_newset'];
            }
          }
          else {
            $args["message"]  = $this->translations['mail-referer-not-valid'];
            $args["showform"] = false;
          }
        }
        else {
          $args["message"]  = $this->translations['mail-referer-not-valid'];
          $args["showform"] = false;
        }
      }
      else {
        $args["message"] = $this->translations['send_reminder'];
      }
    }
    $this->view->render($response, $template, $args);
  });

  /* Ajax Call:
   *
   * List Contributions
   *
   */

  $this->map(['get','post'], '/contributions/search', function ($request, $response, $args) {
    $data = $request->getParsedBody()['data'];
    if (!$data) {
      $data = $request->getQueryParams()['q'];
    }
    if (is_array($data) && array_key_exists('action', $data)) {
      switch ($data['action']) {
        case 'Deleted':
        case 'Open':
        case 'Draft':
        case 'Close':
          $this->db->ChangeStateContributions($data['id'], $data['action']);
        break;
        case 'Trash':
          $this->db->DeleteContributions($data['id']);
        break;
        case 'clone':
          $this->db->CloneContributions($data['id'], $this->translations["copy"]);
        break;
      }
      $r = $response->withHeader('Content-type', 'application/json');
      $json = $this->view->offsetGet('csrf');
      $json['action']  = $data['action'];
      $r->getBody()->write(json_encode($json));
      return $r;
    }
    else {
      $args['base_path'] = '/rf/contributions/search?q=' . rawurlencode($data);
      $args['breadcrumb'] = [
        [
          "class" => "fa-search",
          "name"  => $this->translations['searchresults_title']
        ]
      ];
      $args['contributions'] = $this->db->searchContributions($data);
      $this->view->render($response, 'content-wrapper/contributions.jade', $args);
    }
  });

  /* Ajax Call:
   *
   * List Contributions
   *
   */

  $this->get('/contributions/{book:[0-9]*}/{issue:[0-9]*}/{chapter:[0-9]*}', function ($request, $response, $args) {
    $args['contributions'] = $this->db->getContributions($args['issue'], $args['chapter']);
    $args['base_path'] = '/rf/contributions/'.$args['book'].'/'.$args['issue'].'/'.$args['chapter'];
    $format = $this->db->getFormat($args['chapter']);
    $book   = $this->db->getBook($args['book']);
    $issue  = $this->db->getIssue($args['issue']);
    if (!$book || !$format || !$issue) {
      return false;
    }
    $args['breadcrumb'] = [
      [
        "class" => "fa-book",
        "name"  => $book->getName()
      ],
      [
        "class" => "fa-folder-o",
        "name"  => $issue->getName()
      ],
      [
        "class" => "fa-files-o",
        "name"  => $format->getName()
      ]
    ];
    $args['templates'] = $this->db->getTemplates($format);
    $args['apikey'] = $this->db->getUser()['api'];

    $this->db->addLog('get_contributions', md5("/rf/contributions/".$args['book']."/".$args['issue']."/".$args['chapter']) , $request->getAttribute('ip_address'));
    $this->view->render($response, 'content-wrapper/contributions.jade', $args);
  });

  /* Ajax Call:
   *
   * Bulk Actions on Contributions: set state, reorder, trash, new: todo: clone
   *
   */

  $this->post('/contributions/{book:[0-9]*}/{issue:[0-9]*}/{chapter:[0-9]*}', function ($request, $response, $args) {
    $format = $this->db->getFormat($args['chapter']);
    $book   = $this->db->getBook($args['book']);
    $issue  = $this->db->getIssue($args['issue']);
    $data   = $request->getParsedBody()['data'];

    switch ($data['action']) {
      case 'Deleted':
      case 'Open':
      case 'Draft':
      case 'Close':
        $this->db->ChangeStateContributions($data['id'], $data['action']);
      break;
      case 'Trash':
        $this->db->DeleteContributions($data['id']);
      break;
      case 'reorder':
/*        $ids = [];
        foreach ($data['id'] as $value)
          array_push($ids, $value['id']);
        $this->db->ReorderContributions($ids);
*/
        if (is_array($data['id'])) {
          foreach ($data['id'] as $value) {
            $contribution = $this->db->getContribution($value['id']);
            $contribution->setSort($value['sort'])
            ->updateCache()
            ->save();
          }
        }

      break;
      case 'new':
        $args['contribution'] = $this->db->NewContribution($issue, $format, $data['template'], $data['name']);
        $this->db->addLog(
          'new_contribution',
          json_encode([md5("/rf/contributions/".$args['book']."/".$args['issue']."/".$args['chapter']), $data['template']]) ,
          $request->getAttribute('ip_address')
        );
        $this->helpers->prepareContributionTemplate($args['contribution'], $args);
        $this->view->render($response, 'content-wrapper/contribution.jade', $args);
        return;
      break;
      case 'clone':
        $this->db->CloneContributions($data['id'], $this->translations["copy"]);
      break;
      default:
        # code...
        break;
    }
    $r = $response->withHeader('Content-type', 'application/json');
    $json = $this->view->offsetGet('csrf');
    $json['action']  = $data['action'];
    $r->getBody()->write(json_encode($json));
    return $r;
  });

  /* Ajax Call:
   *
   * Edit Contribution (GET: id)
   *
   */

  $this->get('/contribution/{id:[0-9]*}', function ($request, $response, $args) {
    $contribution = $this->db->getContribution($args['id']);
    $this->helpers->prepareContributionTemplate($contribution, $args);
    // Store in Laste Open Log File
    $this->db->addLog('get_contribution', $args['id'] , $request->getAttribute('ip_address'));
    $this->view->render($response, 'content-wrapper/contribution.jade', $args);
  });

  /* Ajax Call:
   *
   * Work on Single Contribution: rename, move to other contrib/issue reference, reload
   * data from other contribution, change template reference and delete/add fields.
   *
   */

  $this->get('/contribution/{action}/{id:[0-9]*}', function ($request, $response, $args) {
    $_c = $this->db->getContribution($args['id']);
    if ($this->db->DisableVersioning()) {
      switch ($args['action']) {
        case 'revertversion':
          $current = $_c->getVersion();
          if ($current > 1) {
            $_c
              ->toVersion($current - 1)
              ->save();
          }
          break;
        case 'clearversion':
          $this->db
            ->ContributionsVersionQuery()
            ->filterByContributions($_c)
            ->delete();
          $this->db
            ->DataVersionQuery()
            ->filterByForcontribution($_c->getId())
            ->delete();
          foreach ($_c->getDatas() as $_data) {
            $_data->setVersion(1)->save();
          }
          $_c->setVersion(1)->save();
          break;
      }
      $_c->updateCache();
      $this->db->EnableVersioning();
    }
    $this->helpers->prepareContributionTemplate($_c, $args);
    $this->view->render($response, 'content-wrapper/contribution.jade', $args);
  });


  /* Ajax Call:
   *
   * Work on Single Contribution: rename, move to other contrib/issue reference, reload
   * data from other contribution, change template reference and delete/add fields.
   *
   */

  $this->post('/contribution/{action}/{id:[0-9]*}', function ($request, $response, $args) {
    $data   = $request->getParsedBody()['data'];
    $_c = $this->db->getContribution($args['id']);
    $_c->updateCache();

    switch ($args['action']) {
      // Json Return (list mode)
      case 'releasedate':
        $config = json_decode($_c->getConfigSys(), true);
        if ($config === NULL || !$config['lockdate']) $config = json_decode($this->db->ContributionDefaultConfig(), true);
        $parsed = date_parse_from_format('d/m/Y H:i', $data);
        $config['lockdate'] = mktime($parsed[hour], $parsed[minute], $parsed[second], $parsed[month], $parsed[day], $parsed[year]);
        $_c
          ->setConfigSys(json_encode($config))
          ->save();

        $r = $response->withHeader('Content-type', 'application/json');
        $r->getBody()->write(json_encode($this->view->offsetGet('csrf')));
        return $r;
        break;

      // Json Return (list mode)
      case 'rename':
        $_c
          ->setName($data)
          ->save();
        $r = $response->withHeader('Content-type', 'application/json');
        $r->getBody()->write(json_encode($this->view->offsetGet('csrf')));
        return $r;
        break;

      // Complete Reload (template mode)
      case 'move':
        list($chapter_id, $issue_id) = json_decode($data, true);
        if ($issue_id && $chapter_id) {
          $format = $this->db->getFormat($chapter_id);
          $issue  = $this->db->getIssue($issue_id);
          $_c
            ->setForissue($issue_id)
            ->setForchapter($chapter_id)
            ->save();
          $args["alert"] = [
            "success"  => true,
            "text" => str_replace('[x]', $issue->getName().'/'.$format->getName(), $this->translations['alert_moved_success'])
          ];
        }
        else {
          $args["alert"] = [
            "success"  => false,
            "text" => $this->translations['alert_moved_error'],
          ];
        }

        break;
      // Complete Reload (template mode)
      case 'import':
        if ($_fromname = $this->db->ImportContribution($data, $args['id'])) {
          $args["alert"] = [
           "success"  => true,
           "text" => str_replace('[x]', $_fromname, $this->translations['alert_import_success'])
          ];
        }
        else {
          $args["alert"] = [
            "success"  => false,
            "text" => $this->translations['alert_import_error'],
          ];
        }
        break;
      // Complete Reload (template mode)
      case 'chtemp':
        if ($_templatename = $this->db->ChangeTemplateContribution($args['id'], $data)) {
          $args["alert"] = [
           "success"  => true,
           "text" => str_replace('[x]', $_templatename, $this->translations['alert_chtemp_success'])
          ];
        }
        else {
          $args["alert"] = [
            "success"  => false,
            "text" => $this->translations['alert_chtemp_error'],
          ];
        }
        break;
    }
    // Return complete template: Same as /contribution/{id:[0-9]*}'
    $this->helpers->prepareContributionTemplate($_c, $args);
    $this->view->render($response, 'content-wrapper/contribution.jade', $args);
  });

  /* Ajax Call:
   *
   * Post Field Data Contribution
   *
   */

  $this->post('/field/{id:[0-9]*}', function ($request, $response, $args) {
    $json = $this->view->offsetGet('csrf');
    $json['success']  = false;
    $field = $this->db->getField($args['id']);
    if ($field) {
      $template = $field->getTemplates();
      $type     = $template->getFieldtype();
      $settings = json_decode($template->getConfigSys(), true);
      switch ($type) {
        // Binary Uploads
        case 'Bild':
          $file = $request->getUploadedFiles()['file'];
          $data = json_decode($request->getParsedBody()['data'], true);
          if ((is_object($file) && $file->getError() == 0) && $data['action'] == 'add') {
            $json['success'] = $this->db->FileStore($args['id'], $file, $json['original'], $json['relative'], $json['thumb'], $json['caption'], $json['newindex']);
            $json['growing'] = $settings['growing'];
          }
          else if ($data['action'] == 'modify') {
            $json['success'] = $this->db->FileModify($args['id'],  $data['data']);
          }
        break;
        // Number Uploads: Determine if Date
        case 'Zahl':
          if ($settings['integer'] == true) {
            $value = $request->getParsedBody()['data'];
          }
          else {
            $parsed = date_parse_from_format($settings['dateformat'] ? $settings['dateformat'] : 'd/m/Y H:i', $request->getParsedBody()['data']);
            // Set Zero Months and Days to 1
            $parsed[month] = $parsed[month] ? $parsed[month] : 1;
            $parsed[day]   = $parsed[day] ? $parsed[day] : 1;
            $value = mktime($parsed[hour], $parsed[minute], $parsed[second], $parsed[month], $parsed[day], $parsed[year]);
          }
          $json['success'] = $this->db->setField($args['id'], $value);
        break;

        default:
          # code...
          $json['success'] = $this->db->setField($args['id'],  $request->getParsedBody()['data']);
          break;
      }
      // Call Post Processor
      foreach (\FieldpostprocessorQuery::create()->filterByTemplates($template) as $proc) {
        # code...
        $this->helpers->apiCall(
          $proc->getCode(),
          $proc->getSplit(),
          [
            "Contribution" => $this->db->getField($args['id'])->getForcontribution(),
            "Field"        => (int)$args['id'],
            "Data"         => $this->db->getField($args['id'])->getContent()
          ]
        );
      }

      // Update Store Time & Updating Contribution Cache via callback function
      $_t = time();
      $field->getContributions()
        ->updateCache()
        ->setModdate($_t)
        ->setUserSys($this->db->getUser()['id'])
        ->save();
      $json['trigger']['modtime']         = $this->helpers->diffTime(time() - $_t);
      $json['trigger']['username']        = $this->db->getUser()['username'];
      $json['trigger']['contribversion']  = 'rev. '.$field->getContributions()->getVersion();
    }
    else {
        $json['error']  = "Field not existing";
    }
    $r = $response->withHeader('Content-type', 'application/json');
    $r->getBody()->write(json_encode($json));
    return $r;
  });


  /* Ajax Call:
   *
   * Show Structure Template
   *
   */

  $this->get('/structure', function ($request, $response, $args) {
    $this->helpers->prepareStructureTemplate($args);
    $this->view->render($response, 'content-wrapper/structure.jade', $args);
  });

  /* Ajax Calls from Structure Settings:
   *
   * SORTING
   *
   * POST /rf/structure/sort/book
   * POST /rf/structure/sort/chapter/9
   *
   * ADDING
   *
   * POST /rf/structure/add/book
   * POST /rf/structure/add/issue/9
   * POST /rf/structure/add/chapter/9
   *
   */

  $this->post('/structure/{action:add|sort}/{type}[/{id:[0-9]*}]', function ($request, $response, $args) {

    // Actions
    $funcname = $args['action'].ucfirst($args['type']);
    if ($args['id'])
      $this->db->$funcname($request->getParsedBody()['data'], $args['id']);
    else
      $this->db->$funcname($request->getParsedBody()['data']);

    switch ($args['action']) {
      case 'sort':
        # code...
        $r = $response->withHeader('Content-type', 'application/json');
        $json = $this->view->offsetGet('csrf');
        $r->getBody()->write(json_encode($json));
        return $r;
        break;
      case 'add':
        // Render partial only
        if ($args['type'] <> "book") {
          if ($args['id']) {
            $_struc = $this->db->getStructure('/rf/contributions/', $args['id']);
            $args['book'] = $_struc[0];
          }
          $this->view->render($response, 'parts/structure.book.jade', $args);
        }
        // Render whole template: Assuming a book has been added
        else {
          $this->helpers->prepareStructureTemplate($args);
          $this->view->render($response, 'content-wrapper/structure.jade', $args);
        }
        break;
    }
  });

  /* Ajax Calls from Structure Settings:
   *
   * RENAMING
   *
   * POST /rf/structure/rename/book/9
   * POST /rf/structure/rename/issue/10
   * POST /rf/structure/rename/chapter/10
   *
   */

  $this->post('/structure/{action:rename|rights|settings}/{type}/{id:[0-9]*}', function ($request, $response, $args) {
    $json = $this->view->offsetGet('csrf');
    // Actions
    $funcname = $args['action'].ucfirst($args['type']);
    $this->db->$funcname($args['id'], $request->getParsedBody()['data']);
    $r = $response->withHeader('Content-type', 'application/json');
    $r->getBody()->write(json_encode($json));
    return $r;
  });

  /* Ajax Calls from Structure Settings:
   *
   * DUPLICATING & DELETING
   *
   * GET /rf/structure/duplicate/book/9
   * GET /rf/structure/duplicate/chapter/33
   *
   * GET /rf/structure/delete/book/9
   * GET /rf/structure/delete/issue/10
   * GET /rf/structure/delete/chapter/33
   *
   */

  $this->get('/structure/{action:duplicate|delete|open|close}/{type}/{id:[0-9]*}', function ($request, $response, $args) {
    // Determine Book id before deletion
    $bookid = false;
   if ($args['type'] == 'chapter')
     $bookid = $this->db->getFormat($args['id'])->getForbook();
   if ($args['type'] == 'issue')
     $bookid = $this->db->getIssue($args['id'])->getForbook();

    // Actions
    $funcname = $args['action'].ucfirst($args['type']);
    $this->db->$funcname($args['id']);

    // Render partial only
    if ($args['type'] == "book") {
      $this->helpers->prepareStructureTemplate($args);
      $this->view->render($response, 'content-wrapper/structure.jade', $args);
    }

    // Render whole template: Assuming a book has been added
    else {
      if ($bookid) {
        $_struc = $this->db->getStructure('/rf/contributions/', $bookid);
        $args['book'] = $_struc[0];
      }
      $this->view->render($response, 'parts/structure.book.jade', $args);
    }
  });


  /* Ajax Call:
   *
   * Edit Templates
   *
   */

  $this->get('/templates', function ($request, $response, $args) {
    $this->helpers->prepareTemplatesTemplate($args);
    $this->view->render($response, 'content-wrapper/templates.jade', $args);
  });

  /* Ajax Call:
   *
   * Store Template Changes
   *
   * GET /rf/templates/delete/id
   * GET /rf/templates/duplicate/id
   * POST /rf/templates/add
   *
   */
  $this->map(['GET', 'POST'], '/templates/{action:add|duplicate|delete}[/{id:[0-9]*}]', function ($request, $response, $args) {
    // Trigger Function
    $funcname = $args['action'].ucfirst('templates');

    if ($args['id'] && $request->getParsedBody()['data'])
      $this->db->$funcname($args['id'], $request->getParsedBody()['data']);
    else
      $this->db->$funcname($args['id'] ? $args['id'] : $request->getParsedBody()['data']);

    // Return complete page on template add / delete / duplicate
    $this->helpers->prepareTemplatesTemplate($args);
    $this->view->render($response, 'content-wrapper/templates.jade', $args);
  });


  /* Ajax Call:
   *
   * Store Template Changes
   *
   * POST /rf/templates/rename/id
   * POST /rf/templates/update/id
   */
  $this->post('/templates/{action:rename|update}/{id:[0-9]*}', function ($request, $response, $args) {
    // Trigger Function
    $funcname = $args['action'].ucfirst('templates');
    $this->db->$funcname($args['id'], $request->getParsedBody()['data']);
    // Return json on update / rename
    $this->helpers->prepareTemplatesTemplate($args, $args['id']);
    $r = $response->withHeader('Content-type', 'application/json');
    $json = $this->view->offsetGet('csrf');
    // Nasty: schema is sent already as json. decode and add to array
    $json['schema'] = json_decode($args['schema'], true);
    $json['template'] = $args['template'];
    $r->getBody()->write(json_encode($json));
    return $r;
  });

  /* Ajax Call:
   *
   * Store Template Fields Changes
   *
   * GET /rf/templates/field/delete/id
   * GET /rf/templates/field/duplicate/id
   * POST /rf/templates/field/add
   *
   */
   $this->map(['GET', 'POST'], '/templates/field/{action:add|duplicate|delete}/{id:[0-9]*}', function ($request, $response, $args) {
     // Get Template Id: Mostly it is the reference to forTemplate of Templatefield $args['id'],
     // only when adding, it's directly a template reference
     $templateId = $args['action'] == "add" ? $args['id']
                                            : $this->db->getTemplatefields()->findPk($args['id'])->getFortemplate();

     // Actions
     $funcname = $args['action'].ucfirst('templatefield');
     $request->getParsedBody()['data']
       ? $this->db->$funcname($args['id'], $request->getParsedBody()['data'])
       : $this->db->$funcname($args['id']);

    // Load Template
    $this->helpers->prepareTemplatesTemplate($args, $templateId);

    // Default Pane
    $args['type'] = 'fields';
    $this->view->render($response, 'parts/templates.field.jade', $args);
  });

  /* Ajax Call:
   *
   * Store Template Fields Changes
   *
   * POST /rf/templates/field/rename/id
   * POST /rf/templates/field/update/id
   * POST /rf/templates/field/update/sort
   *
   *
   */
  $this->post('/templates/field/{action:rename|update|sort}/{id:[0-9]*}', function ($request, $response, $args) {
    // Actions
    $funcname = $args['action'].ucfirst('templatefield');
    $this->db->$funcname($args['id'], $request->getParsedBody()['data']);

    // Get Template Id: Mostly it is the reference to forTemplate of Templatefield $args['id'],
    // only when adding, it's directly a template reference
    $templateId = $args['action'] == "sort" ? $args['id']
                                           : $this->db->getTemplatefields()->findPk($args['id'])->getFortemplate();
    // Load Template
    $this->helpers->prepareTemplatesTemplate($args, $templateId);

    // Return json on update / rename
    $r = $response->withHeader('Content-type', 'application/json');
    $json = $this->view->offsetGet('csrf');
    // Template for various info
    $json['template'] = $args['template'];
    // Schema for the configuration editor
    // Nasty: schema is sent already as json. decode and add to array
    $json['schema'] = json_decode($args['schema'], true);
    // Fields array to overrule the enums for lengthInfluence in the schema.
    // Done via javascript on load in rf.templates.js
    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->addAscendingOrderByColumn(__sort__);
    $fields_in_template = [];
    foreach ($args['template']->getTemplatess($criteria) as $field) {
      $fields_in_template["id"][] = $field->getId();
      $fields_in_template["label"][] = $field->getFieldname();
      if ($field->getId()==$args['id']) {
        $json['newconfig'] = $field->GetFilteredConfigsys();
      }
    }
    $json['fieldinfo'] = $fields_in_template;
    $r->getBody()->write(json_encode($json));
    return $r;
  });


  /* Exporters
   *
   * Show List of registered exporters and trigger hooks on post
   *
   * GET /rf/exporters
   * POST /rf/exporters
   *
   */
  $this->map(['GET', 'POST'], '/exporters[/{id:[0-9]*}]', function ($request, $response, $args) {
    $args['processors'] = \PluginsQuery::create();
    $args['post']       = $request->isPost();
    if ($args['id']) {
      $u = new \Pdf();
      $u->setDate(time())
        ->setPlugin($args['id'])
        ->setPages(0)
        ->setFile('–')
        ->setConfigSys("Processing");
      $u->save();
    }
    $args['exports'] = \PdfQuery::create()->orderByDate('desc')->limit(20);
    $this->view->render($response, 'content-wrapper/exporters.jade', $args);
  });

  /* Batch Hooks
   *
   * Call an Url on a certain action
   *
   * GET /rf/batchhooks[/{id:[0-9]*}]
   * POST /rf/batchhooks[/{id:[0-9]*}]
   *
   */
  $this->map(['GET', 'POST'], '/batchhooks[/{id:[0-9]*}]', function ($request, $response, $args) {
    $args['processors'] = \PluginsQuery::create();
    $args['post']       = $request->isPost();

    if ($args['post']) {
      if ($request->getParsedBody()['data'] === "Delete") {
        $u = $args['processors']->findPk($args['id']);
        $u->delete();
      }
      else {
        /*
        Array (
        [0] => Array ( name] => id [value] => )
        [1] => Array ( [name] => setCode [value] => )
        [2] => Array ( [name] => setConfigSys [value] => )
        [3] => Array ( [name] => setSplit [value] => )
        [4] => Array ( [name] => setField [value] => 2 )
        )
        */
        $u = new \Plugins();

        foreach ($request->getParsedBody()['data'] as $value) {
          if ($value['name'] === "addTemplates" && $value['value'] !== -1) {
            $value['value'] = $this->db->getTemplatefields()->findPk($value['value']);
          }
          if (method_exists($u, $value['name']) && $value['value']) {
            $u->{$value['name']}($value['value']);
          }
        }
        $u->save();
      }
    }


    $this->view->render($response, 'content-wrapper/hooks.batch.jade', $args);
  });

  /* Route Hooks
   *
   * Call an Url on a certain action
   *
   * GET /rf/routehooks[/{id:[0-9]*}]
   * POST /rf/routehooks[/{id:[0-9]*}]
   *
   */
  $this->map(['GET', 'POST'], '/routehooks[/{id:[0-9]*}]', function ($request, $response, $args) {
    $args['processors'] = \FieldpostprocessorQuery::create();
    $args['fields']      = $this->db->getTemplatefields();
    $args['post']       = $request->isPost();

    if ($args['post']) {
      if ($request->getParsedBody()['data'] === "Delete") {
        $u = $args['processors']->findPk($args['id']);
        $u->delete();
      }
      else {
        /*
        Array (
        [0] => Array ( name] => id [value] => )
        [1] => Array ( [name] => setCode [value] => )
        [2] => Array ( [name] => setConfigSys [value] => )
        [3] => Array ( [name] => setSplit [value] => )
        [4] => Array ( [name] => setField [value] => 2 )
        )
        */
        $u = new \Fieldpostprocessor();

        foreach ($request->getParsedBody()['data'] as $value) {
          if ($value['name'] === "addTemplates" && $value['value'] !== -1) {
            $value['value'] = $this->db->getTemplatefields()->findPk($value['value']);
          }
          if (method_exists($u, $value['name']) && $value['value']) {
            $u->{$value['name']}($value['value']);
          }
        }
        $u->save();
      }
    }


    $this->view->render($response, 'content-wrapper/hooks.route.jade', $args);
  });


  /* Proxy for private binary resources
   *
   *
   * GET /rf/proxy
   *
   */
  $this->get('/proxy', function ($request, $response, $args) {
    $url = base64_decode(array_keys($request->getQueryParams())[0]);
    if ($url) {
      return $this->db->proxy($url, $response);
    }
    else {
      $r = $response->withHeader('Content-type', 'application/json');
      $r->getBody()->write(json_encode(['error' => "404", 'message' => "File not found"]));
      return $r;
    }
  });

})->add($redis)->add($identificator)->add($csrf)->add($authentification)->add($ajaxcheck)->add($routeHook);
