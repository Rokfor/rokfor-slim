<?php

// bootstrap the Propel runtime (and other dependencies)
require_once __DIR__ . '/../../vendor/autoload.php';
set_include_path(__DIR__ . '/../generated-classes' . PATH_SEPARATOR . get_include_path());
include __DIR__ .'/../generated-conf/config.php';

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1452358516.
 * Generated on 2016-01-09 16:55:16 by urshofer
 */
class PropelMigration_1452358516
{
    public $comment = '';
    
    function 	_ConvertInfluenceArray($_inf) {
  		// Transform Influence Array
  		$_inf_array = [];
  		foreach (explode('%%%%%%%%%%', $_inf) as $_value) {
        $row = [];
        list($row["factor"], $row["fieldname"]) = explode("%%%%%", $_value);
        if ($row["fieldname"]) {
          $row["fieldname"] = TemplatesQuery::create()->filterByFieldname($row["fieldname"])->findOne()->getId();
          array_push($_inf_array, $row);
        }
  		}
  		return ($_inf_array);				
	  }

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
        $pdo = $manager->getAdapterConnection('rokfor');
        
        $datasets = TemplatesQuery::create()->find();
        $count = 0;
        foreach ($datasets as $field) {
          
          $sql = "SELECT * FROM _templates WHERE id = " . $field->getId();
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          echo "Updating template ".$result['_fieldname']."\n";

          $_sizes = [];
          $_heights = explode(';',$result['_imageheight']);
          foreach (explode(';',$result['_imagewidth']) as $key => $value) {
            array_push($_sizes, [width=>$value, height=>$_heights[$key]]);
          }

          
          $newconfig = Array (
            maxlines    => $result['_maxlines'],
            textlength  => $result['_textlength'],
            imagesize   => $_sizes,
            columns     => $result['_cols'],
            history     => $result['_history'] == "ja",
            growing     => $result['_growing'] == "ja"
          );
          
          $newconfig['lengthinfluence'] = $this->_ConvertInfluenceArray($result['_lengthInfluence']);
          
          $string = $result['_colNames'];

          switch ($field->getFieldtype()) {
            case 'Text':
              $newconfig['fullhistory']  = stristr($string, 'fullhistory=true') ? true : false;
              $newconfig['rtfeditor']    = !stristr($string, 'rtfeditor=false') && !stristr($string, 'codeeditor=true') && !stristr($string, ';');
              $newconfig['codeeditor']   = stristr($string, 'codeeditor=true') ? true : false;
              $string = str_ireplace('fullhistory=true', '',$string);
              $string = str_ireplace('rtfeditor=false', '', $string);
              $string = str_ireplace('codeeditor=true', '', $string);
          		$_columns = explode(";", $string);
              $newconfig['editorcolumns'] = [];
          		if (count($_columns)>1) {
          			$newconfig['arrayeditor'] = true;
          			foreach ($_columns as $_colId=>$_colName) {
                  preg_match("/<(.*)>(.*)/", $_colName, $_LengthName);
                  if ($_LengthName[1] == 0)
                    $_LengthName[1] = 1;
                  array_push($newconfig['editorcolumns'], ["lines" => $_LengthName[1], "label" => $_LengthName[2]]);
                }
              }
              break;
            case 'Tabelle':
              $newconfig['colnames'] = explode(';',$string);
              break;            
            default:


            if (!stristr($string,"=")) {
              $newconfig['colnames'] = explode(';',$string);
            }
            else {
              $init = parse_ini_string ($string,true);
              if (is_array($init)) {
            		foreach ($init as $type=>$row) {
                  if ($type == 'integer')
                    $newconfig['integer']             = $row  ? true : false;
                  if ($type == 'resolve_foreign')
                    $newconfig['resolve_foreign']     = $row ? true : false;
                  if ($type == 'multiple')
                    $newconfig['multiple']            = $row ? true : false;
                  if ($type == 'legends')
                    $newconfig['legends']             = explode(';',trim($row));
                  if ($type == 'history')
                    $newconfig['history_command']     = $row;
                  if ($type == 'dateformat')
                    $newconfig['dateformat']          = $row;
                  if ($type == 'fromtemplate')
                    $newconfig['fromtemplate']        = $row;
                  if ($type == 'fromfield')
                    $newconfig['fromfield']           = $row;
                  if ($type == 'frombook')
                    $newconfig['frombook']            = $row;
                  if ($type == 'values')
                    $newconfig['fixedvalues']         = explode(';',trim($row));	
                  if ($type == 'restrict_to_open')
                    $newconfig['restrict_to_open']    = $row ? true : false;

                  if ($type == 'restrict_to_issue') {
                    if ($newconfig['restrict_to_issue'] === "true") $newconfig['restrict_to_issue']   = true;
                    else if ($newconfig['restrict_to_issue'] === "false") $newconfig['restrict_to_issue']   = false;                    
                    else {
                      $newconfig['restrict_to_issue']   = true;
                      $newconfig['fromissue']   = $row;
                    }
                  }

                  if ($type == 'restrict_to_chapter') {
                    if ($newconfig['restrict_to_chapter'] === "true") $newconfig['restrict_to_chapter']   = true;
                    else if ($newconfig['restrict_to_chapter'] === "false") $newconfig['restrict_to_chapter']   = false;                    
                    else {
                      $newconfig['restrict_to_chapter']   = true;
                      $newconfig['fromchapter']   = $row;
                    }
                  }
                  
                  if ($type == 'restrict_to_book') {
                    if ($newconfig['restrict_to_book'] === "true") $newconfig['restrict_to_book']   = true;
                    else if ($newconfig['restrict_to_book'] === "false") $newconfig['restrict_to_book']   = false;                    
                    else {
                      $newconfig['restrict_to_book']   = true;
                      $newconfig['frombook']   = $row;
                    }                    
                  }
                  if ($type == '3d')
                    $newconfig['threeDee']            = $row ? true : false;
                }
                
                if ($newconfig['frombook']) {
                  if (BooksQuery::create()->filterByName($newconfig['frombook'])->findOne())
                    $newconfig['frombook'] = BooksQuery::create()->filterByName($newconfig['frombook'])->findOne()->getId();
                }
                if ($newconfig['fromchapter']) {
                  if (FormatsQuery::create()->filterByName($newconfig['fromchapter'])->findOne())
                    $newconfig['fromchapter'] = FormatsQuery::create()->filterByName($newconfig['fromchapter'])->findOne()->getId();
                }
                if ($newconfig['fromissue']) {
                  if (IssuesQuery::create()->filterByName($newconfig['fromissue'])->findOne())
                    $newconfig['fromissue'] = IssuesQuery::create()->filterByName($newconfig['fromissue'])->findOne()->getId();       
                }
                if ($newconfig['fromtemplate']) {
                  if (TemplatenamesQuery::create()->filterByName($newconfig['fromtemplate'])->findOne())
                    $newconfig['fromtemplate'] = TemplatenamesQuery::create()->filterByName($newconfig['fromtemplate'])->findOne()->getId();
                }
                if ($newconfig['fromfield']) {
                  if (TemplatesQuery::create()->filterByFieldname($newconfig['fromfield'])->findOne())
                    $newconfig['fromfield']= TemplatesQuery::create()->filterByFieldname($newconfig['fromfield'])->findOne()->getId();
                }
                  
/*                echo "Parsed String\n";
                print_r($init);
                echo "\n---\n";
                print_r($newconfig);
                echo "\n---\n";              */
              }
            }
            break;
          }
          
          $field->setConfigSys(json_encode($newconfig))->save($pdo);
        }
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'rokfor' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'rokfor' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}