<?php

use Base\Data as BaseData;

/**
 * Skeleton subclass for representing a row from the '_data' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Data extends BaseData
{

  /**
   * creates history values for reference fields
   *
   * @return void
   * @author Urs Hofer
   */
  function getHistory()
  {
    $thisfield    = $this->getTemplates();
    $contribution = $this->getContributions();
    $settings     = json_decode($thisfield->getConfigSys(), true);
    $retval = [];

    if ($settings['fromfield'])
      $field = \TemplatesQuery::create()->findPk($settings['fromfield']);
    else
      $field = $thisfield;

    if ($settings['fromtemplate'])
      $template = \TemplatenamesQuery::create()->findPk($settings['fromtemplate']);
    else
      $template = $thisfield->getTemplatenames();

    if ($settings['fromissue'])
      $issue =  \IssuesQuery::create()->findPk($settings['fromissue']);
    else
      $issue =  $contribution->getIssues();

    if ($settings['frombook'])
      $book = \BooksQuery::create()->findPk($settings['frombook']);
    else
      $book = $contribution->getIssues()->getBooks();

    if ($settings['fromchapter'])
      $chapter = \FormatsQuery::create()->findPk($settings['fromchapter']);
    else
      $chapter = $contribution->getFormats();

    if (!$chapter || !$book || !$issue || !$template || !$field) {
      array_push($retval, ["id"=>-1,"value"=>"Error - adjust template settings"]);
    }
    else {
      switch ($settings['history_command']) {
        //
        // BOOK HISTORY
        // needs  : -
        // option : -
        // Returns books
        //
        case 'books':
          foreach(\BooksQuery::create() as $_b) {
            array_push($retval, ["id"=>$_b->getId(),"value"=>$_b->getName()]);
          }
          break;
        //
        // ISSUES HISTORY
        // option : frombook(string), otherwise self
        // option : restrict_to_open(bool)
        // Returns issues of a book
        //
        case 'issues':
          $issues = \IssuesQuery::create()->_if($settings['restrict_to_book'])
                                            ->filterByBooks($book)
                                          ->_endif()
                                          ->_if($settings['restrict_to_open'])
                                            ->filterByStatus('open')
                                          ->_endif();
          foreach($issues as $_b) {
            array_push($retval, ["id"=>$_b->getId(),"value"=>$_b->getName()]);
          }
          break;
        //
        // CHAPTERS HISTORY
        // option : frombook(string), otherwise self
        // Returns chapters of a book
        //
        case 'chapters':
          $formats = \FormatsQuery::create()->_if($settings['restrict_to_book'])
                                              ->filterByBooks($book)
                                            ->_endif();
          foreach($formats as $_b) {
            array_push($retval, ["id"=>$_b->getId(),"value"=>$_b->getName()]);
          }
          break;
        //
        // CLOUD HISTORY
        // TODO
        // Returns cloud matrix data for a field.
        //
        case 'cloud':
            array_push($retval, ["id"=>-1,"value"=>"not yet implemented"]);
        //
        // OTHER HISTORY
        // option: restrict_to_issue(bool): true = fromissue or self / false = all issues
        // option: restrict_to_open(bool): true = open contributions / false = all contributions
        // option: fromfield (necessary for other history)
        // Returns chapters of a book
        //
        case 'other':
          $_data = \DataQuery::create()->filterByTemplates($field)
                                       ->_if($settings['restrict_to_issue'])
                                         ->useContributionsQuery()
                                           ->filterByIssues($issue)
                                         ->endUse()
                                       ->_endif()
                                       ->useContributionsQuery()
                                         ->_if($settings['restrict_to_open'])
                                           ->filterByStatus('Open')
                                         ->_else()
                                           ->filterByStatus('Open')
                                           ->_or()
                                           ->filterByStatus('Close')
                                           ->_or()
                                           ->filterByStatus('Draft')
                                         ->_endif()
                                       ->endUse();

          foreach($_data as $_b) {
            array_push($retval, ["id"=>$_b->getId(),"value"=>$_b->getContent()]);
          }
          break;
        //
        // SELF HISTORY
        // option: restrict_to_issue(bool): true = fromissue or self / false = all issues
        // option: restrict_to_open(bool): true = open contributions / false = all contributions
        // option: fromfield (necessary for other history)
        // Returns chapters of a book
        //
        case 'self':
          $_data = \DataQuery::create()->filterByTemplates($field)
                                       ->_if($settings['restrict_to_issue'])
                                         ->useContributionsQuery()
                                           ->filterByIssues($issue)
                                         ->endUse()
                                       ->_endif()
                                      ->useContributionsQuery()
                                        ->_if($settings['restrict_to_open'])
                                          ->filterByStatus('Open')
                                        ->_else()
                                          ->filterByStatus('Open')
                                          ->_or()
                                          ->filterByStatus('Close')
                                          ->_or()
                                          ->filterByStatus('Draft')
                                        ->_endif()
                                      ->endUse();
          //if (is_array($_data)) {
            foreach($_data as $_b) {
              $_decoded = json_decode($_b->getContent(), true);
              if (is_array($_decoded)) {
                foreach($_decoded as $_d) {
                  if ($_d >= 0) {
                    $retval[$_d] = ["id"=>$_d,"value"=>$_d];
                  }
                }
              }
            }
          ksort($retval);
          break;
          //}
        //
        // CONTRIBUTIONS HISTORY
        // option: restrict_to_issue(bool): true = fromissue or self / false = all issues
        // option: restrict_to_open(bool): true = open contributions / false = all contributions
        // option: restrict_to_chapter(bool): true = fromchapter or self / false = all chapters
        // option: fromtemplate(string), otherwise self
        // Returns contributions of a issue
        //
        case 'contributional':
          $_data = \ContributionsQuery::create()->_if($settings['restrict_to_issue'])
                                                  ->filterByIssues($issue)
                                                ->_endif()
                                                ->_if($settings['restrict_to_open'])
                                                  ->filterByStatus('Open')
                                                ->_else()
                                                  ->filterByStatus('Open')
                                                  ->_or()
                                                  ->filterByStatus('Close')
                                                  ->_or()
                                                  ->filterByStatus('Draft')
                                                ->_endif()
                                                ->_if($settings['restrict_to_chapter'])
                                                  ->filterByFormats($chapter)
                                                ->_endif()
                                                ->_if($settings['restrict_to_template'])
                                                  ->filterByTemplatenames($template)
                                                ->_endif()
                                                ->_if($settings['restrict_to_book'])
                                                  ->useIssuesQuery()
                                                    ->filterByBooks($book)
                                                  ->endUse()
                                                ->_endif();
          foreach($_data as $_b) {
            array_push($retval, ["id"=>$_b->getId(),"value"=>$_b->getName()]);
          }
          break;
        //
        // STRUCTURAL HISTORY
        // option: fromtemplate(string), otherwise fields of own template
        // Returns fields of a template
        //
        case 'structural':
            foreach(\TemplatesQuery::create()->filterByTemplatenames($template) as $_t) {
              array_push($retval, ["id"=>$_t->getId(),"value"=>$_t->getFieldname()]);
            }
          # code...
          break;
        //
        // FIXED HISTORY
        // needs  : fixedvalues(array of strings)
        // option : -
        // Returns fixed string values
        //
        case 'fixed':
          foreach ($settings['fixedvalues'] as $key => $value) {
            array_push($retval, ["id"=>$key,"value"=>$value]);
          }
          break;

      }

      // Always add a disabled state

      array_push($retval, ["id"=>-1,"value"=>"* Disabled *"]);

    }
    return $retval;
  }

  /**
   * decodes the content from json
   * it the result is not an array, it will be created
   *
   * @return void
   * @author Urs Hofer
   */
  function getDataAlwaysAsArray()
  {
    $_c = $this->getContent() ? $this->getContent() : -1;
    $data = json_decode($_c, true);
    return (!is_array($data)?[$data]:$data);
  }

  /**
   * returns the relations of a data field as array of int
   *
   * @return void
   * @author Urs Hofer
   */
  function getRelationsAsArray($history_command)
  {
    if ($relations = $this->getRelationsAsObject($history_command)) {
      if (is_array($relations)) {
        return $relations;
      }
      $ids = [];
      foreach ($relations as $_r) {
        $ids[] = $_r->getId();
      }
      return (count($ids) == 0 ? [-1] : $ids);
    }
    return [];
  }


  /**
   * returns the relations of a data field as array of int
   *
   * @return void
   * @author Urs Hofer
   */
  function getRelationsAsObject($history_command)
  {
    $getAction = false;
    switch ($history_command) {
      case 'contributional':
        $getAction = 'getRContributions';
        break;
      case 'books':
        $getAction = 'getRBooks';
        break;
      case 'issues':
        $getAction = 'getRIssues';
        break;
      case 'chapters':
        $getAction = 'getRFormats';
        break;
      case 'structural':
        $getAction = 'getRTemplates';
        break;
      case 'other':
        $getAction = 'getRDataRefs';
        break;
      default:
        //- Return Plain Values here for self referenced keywords
        return $this->getDataAlwaysAsArray();
        break;
    }
    if ($getAction) {
      return $this->$getAction();
    }
    return false;
  }



}
