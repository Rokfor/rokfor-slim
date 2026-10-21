<?php

// bootstrap the Propel runtime (and other dependencies)
require_once __DIR__ . '/../../vendor/autoload.php';
set_include_path(__DIR__ . '/../generated-classes' . PATH_SEPARATOR . get_include_path());
include __DIR__ .'/../generated-conf/config.php';

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1452074796.
 * Generated on 2016-01-06 10:06:36 by urshofer
 */
class PropelMigration_1452074796
{
    public $comment = '';

  	/**
  	 * splits serialized multi field text string into parts
  	 *
  	 * @param string $_rawdata 
  	 * @return void
  	 * @author Urs Hofer
  	 */
  	function _splitTextListData($_rawdata) {
  		if (substr($_rawdata, -8)=='<::::::>') $_rawdata = substr($_rawdata, 0, -8);
  		return (explode("<::::::>", $_rawdata));
  	}

  	/**
  	 * splits serialized table data into parts. with $_force_col_count a number of columns can be
  	 * forced, even if there is not enough data in the string. (creating empty cells)
  	 *
  	 * @param string $_rawdata 
  	 * @param int $_force_col_count 	
  	 * @return void
  	 * @author Urs Hofer
  	 */
  	function _splitTableData($_rawdata,$_force_col_count=false) {
  		$_array = explode('<;;;;;;>',$_rawdata);
  		$_retval = Array();
  		foreach ($_array as $_i) if ($_i) {
  			$_row = array();
  			if ($_force_col_count>0) {
  				$_row_raw = explode('<::::::>',$_i);				
  				for ($i=0; $i < $_force_col_count; $i++) { 
  					$_row[$i] = $_row_raw[$i]?$_row_raw[$i]:"";
  				}
  			}
  			else {
  				$_row = explode('<::::::>',$_i);
  			}
  			foreach ($_row as &$_cell) $_cell = str_replace(array("&lt;::::::&gt;","&lt;;;;;;;&gt;"), array("<::::::>","<;;;;;;>"), $_cell);
  			$_retval[] = $_row;
  		}
  		return ($_retval);
  	}
    
  	/**
  	 * splits serialized string into parts
  	 *
  	 * @param string $_rawdata 
  	 * @return void
  	 * @author Urs Hofer
  	 */
  	function _splitWordListData($_rawdata) {
  		if (substr($_rawdata, -8)=='<;;;;;;>') $_rawdata = substr($_rawdata, 0, -8);
  		return (explode("<;;;;;;>", $_rawdata));
  	}
    
  	function _splitCloudData($data,$xmin=-100,$xmax=100,$ymin=-100,$ymax=100)
  	{
		
  		/**
  		 * Frontend: Size of Cloud X
  		 **/
  		if (!defined("FRNTEND_CLOUD_X")) define("FRNTEND_CLOUD_X", 338);
  		/**
  		 * Frontend: Size of Cloud Y
  		 **/
  		if (!defined("FRNTEND_CLOUD_Y")) define("FRNTEND_CLOUD_Y", 290);
		
  		$return  = array();		
  		foreach ($data as $entry) {
  			list($key,$x,$y) = $entry;
  			//if (array_key_exists($key, $return))
  			//{
  			//	$count = 1;
  			//	while ( array_key_exists($key."_#".$count, $return)) $count++;
  			//	$key = $key."_#".$count;
  			//}
			
  			// 3d over time
  			if (stristr($y,'<>')&&stristr($x,'<>')) {
  				$_return = array();
  				if (stristr($x,'<>')) {
  					$_subvals_x = $this->_splitClean('<>', $x);
  					foreach ($_subvals_x as $_subval_x) {
  						list($_time,$_svx) = $this->_splitClean('_', $_subval_x);
  						$_return[$_time][0]= (($xmax - $xmin)/FRNTEND_CLOUD_X*$_svx)+$xmin;
  					}
  				}

  				if (stristr($y,'<>')) {
  					$_subvals_y = $this->_splitClean('<>', $y);				
  					foreach ($_subvals_y as $_subval_y) {
  						list($_time,$_svy) = $this->_splitClean('_', $_subval_y);
  						$_return[$_time][1]= (($ymax - $ymin)/FRNTEND_CLOUD_Y*$_svy)+$ymin;
  					}
  				}
  		 		$return[$key] = $_return;				
  			}

  			// No 3d
  			else {
  		 		$return[$key] = array(array((($xmax - $xmin)/FRNTEND_CLOUD_X*$x)+$xmin,(($ymax - $ymin)/FRNTEND_CLOUD_Y*$y)+$ymin));
  			}
  		}
  		return $return;
  	}
    
  	/**
  	 * _splitClean
  	 * like explode, but cleans the final array from empty results
  	 *
  	 * @return array
  	 * @author Urs Hofer
  	 **/
  	function _splitClean($_pattern,$_string)
  	{
  		$ret = array();
  		$expl = explode($_pattern, $_string);
  		foreach ($expl as $val) if ($val<>"") $ret[] = $val;
  		return $ret;
  	}    

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
      $pdo = $manager->getAdapterConnection('rokfor');
      date_default_timezone_set('UTC');
              
      // populate relative fields: _issues
      /*
      foreach (array('_singleplugin','_allplugin','_rtfplugin', '_xmlplugin', '_narrationplugin') as $_field) {
        $datasets = IssuesQuery::create()->find();
        $count = 0;
        foreach ($datasets as $issue) {
          $sql = "SELECT ".$_field." FROM _issues WHERE id = " . $issue->getId();
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          foreach ($this->_splitTextListData($result[$_field]) as $key) {
            $p = PluginsQuery::create()->findPk($key);
            if ($p) {
              echo "Add Plugin with id " . $key . " from ".$_field. "\n";
              switch ($_field) {
                case '_singleplugin':
                $issue->addSinglePlugin($p);
                break;
                case '_allplugin':
                $issue->addAllPlugin($p);
                break;
                case '_rtfplugin':
                $issue->addRtfPlugin($p);
                break;
                case '_xmlplugin':
                $issue->addXmlPlugin($p);
                break;
                case '_narrationplugin':
                $issue->addNarrationPlugin($p);
                break;                        
              }
            }
          }
          $issue->save($pdo);
        }
      }*/
       
      $datasets = RightsQuery::create()->find();
      $count = 0;
      foreach ($datasets as $right) {
        $sql = "SELECT * FROM _rights WHERE id = " . $right->getId();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        foreach (array('_fortemplate', '_forissue', '_forbook', '_foruser') as $_field) {
          foreach ($this->_splitTextListData($result[$_field]) as $key) {
            if ($key) {
              switch ($_field) {
                case '_fortemplate':
                  $p = TemplatenamesQuery::create()->findPk($key);                
                  if ($p) $right->addTemplatenames($p);
                break;
                case '_forissue':
                  $p = IssuesQuery::create()->findPk($key);                
                  if ($p) $right->addIssues($p);
                break;
                case '_forbook':
                  $p = BooksQuery::create()->findPk($key);                
                  if ($p) $right->addBooks($p);
                break;
                case '_foruser':
                  $p = UsersQuery::create()->findPk($key);                                  
                  if ($p) $right->addUsers($p);
                  break;
                }
              }
            }
          }
          $right->save($pdo);
        }
        
        $datasets = BatchQuery::create()->find();
        $count = 0;
        foreach ($datasets as $batch) {
          $sql = "SELECT * FROM _batch WHERE id = " . $batch->getId();
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          foreach (array('_forbook') as $_field) {
            foreach ($this->_splitTextListData($result[$_field]) as $key) {
              if ($key) {
                switch ($_field) {
                  case '_forbook':
                    $p = BooksQuery::create()->findPk($key);                
                    if ($p) $batch->addBooks($p);
                  break;
                }
              }
            }
          }
          $batch->save($pdo);
        }
        
        $datasets = FieldpostprocessorQuery::create()->find();
        $count = 0;
        foreach ($datasets as $proc) {
          $sql = "SELECT * FROM _fieldpostprocessor WHERE id = " . $proc->getId();
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          foreach (array('_forfield') as $_field) {
            foreach ($this->_splitTextListData($result[$_field]) as $key) {
              if ($key) {
                switch ($_field) {
                  case '_forfield':
                    $p = TemplatesQuery::create()->findPk($key);                
                    if ($p) $proc->addTemplates($p);
                  break;
                }
              }
            }
          }
          $proc->save($pdo);
        }                

        $datasets = TemplatenamesQuery::create()->find();
        $count = 0;
        foreach ($datasets as $template) {
          $sql = "SELECT * FROM _templatenames WHERE id = " . $template->getId();
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          foreach (array('_inchapter', '_forbook') as $_field) {
            foreach ($this->_splitTextListData($result[$_field]) as $key) {
              if ($key) {
                switch ($_field) {
                  case '_inchapter':
                    $p = FormatsQuery::create()->findPk($key);                
                    if ($p) $template->addFormats($p);
                  break;
                  case '_forbook':
                    $p = BooksQuery::create()->findPk($key);                
                    if ($p) $template->addBooks($p);
                  break;                  
                }
              }
            }
          }
          $template->save($pdo);
        }  
                    
        DataQuery::disableVersioning();
        // migrate data into new content field, set json to true if it is jsonized.
        $datasets = DataQuery::create()->find();
        $count = 0;
        echo "\n";
        echo "Updating " . count($datasets) . " Fields: ";

        foreach ($datasets as $data) {
          echo "$count\n";
          $count++;
          $_parsed_text = "";    
          $_is_json = false;      
          $sql = "SELECT * FROM _data WHERE id = " . $data->getId();
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          
          $sql2 = "SELECT * FROM _templates WHERE id = " . $data->getFortemplatefield();
          $stmt2 = $pdo->prepare($sql2);
          $stmt2->execute();
          $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          
          
          switch ($data->getTemplates()->getFieldtype()) {
    				case 'Bild':
    					$_parsed_text = $this->_splitTableData($result['_databinary']);
              
              
              foreach ($_parsed_text as $__key => &$__value) {
                # code...: $__value[0] == caption $__value[1] == original $__value[2] = scales/thumbs

                $_versions = [];
                for ($i=0; $i < count(explode(';', $result2['_imagewidth'])) ; $i++) { 
                  if ($i==0) {
                    $_versions[] = $__value[1].'-preview.jpg';
                  }
                  else {
                    $_versions[] = $__value[1].'-preview'.$i.'.jpg';
                  }
                }

                $__value[2] = [
                  "thumbnail" => $__value[1]."-thmb.jpg",
                  "scaled"    => $_versions
                ];
              }
              
              $_is_json = true;
    					break;
    				case 'Tabelle':
    					$_parsed_text = $this->_splitTableData($result['_datatext']);
              $_is_json = true;              
    					break;	
    				case 'TypologyCloud':
    					$_parsed_text = $this->_splitCloudData($this->_splitTableData($result['_datatext']));
              $_is_json = true;              
    					break; 
            case 'MetaMatrix':
              $_parsed_text =	json_decode($_parsed_text);
              $_is_json = true;
              break;
            case 'TargetMatrix':  
            case 'TimeMatrix':
              $_parsed_text =	$this->_splitTextListData($result['_datatext']);  
              $_parsed_text[1] =	json_decode($_parsed_text[1]);
              $_is_json = true;              
              break;
    				case 'Zahl':
    				case 'TypologySlider':
    					$_parsed_text = $result['_datainteger'];
    					break;		
    				case 'TypologyKeyword':
    					$_parsed_text =	$this->_splitWordListData($result['_datatext']);
              $_is_json = true;             
    					break;					
    				default:
    					if (stristr($result['_datatext'], '<::::::>')) {
    						$_parsed_text =	$this->_splitTextListData($result['_datatext']);
                $_is_json = true;                
    					}
    					else if (stristr($result['_datatext'], '<;;;;;;>')) {
    						$_parsed_text =	$this->_splitWordListData($result['_datatext']);
                $_is_json = true;                
    					}
    					else $_parsed_text = $result['_datatext'];
    					break;
          }
          $data->setContent($_is_json ? json_encode($_parsed_text) : $_parsed_text);
          $data->setIsjson($_is_json);
          $data->save($pdo);
        }
        echo "\nDone\n";
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

ALTER TABLE `_data` DROP INDEX _datatext_index;
ALTER TABLE `_data` ENGINE=InnoDB;
ALTER TABLE `session` ENGINE=InnoDB;
ALTER TABLE `users` ENGINE=InnoDB;
ALTER TABLE `_batch` ENGINE=InnoDB;
ALTER TABLE `_books` ENGINE=InnoDB;
ALTER TABLE `_fieldpostprocessor` ENGINE=InnoDB;
ALTER TABLE `_formats` ENGINE=InnoDB;
ALTER TABLE `_issues` ENGINE=InnoDB;
ALTER TABLE `_log` ENGINE=InnoDB;
ALTER TABLE `_pdf` ENGINE=InnoDB;
ALTER TABLE `_plugins` ENGINE=InnoDB;
ALTER TABLE `_rights` ENGINE=InnoDB;
ALTER TABLE `_templatenames` ENGINE=InnoDB;
ALTER TABLE `_templates` ENGINE=InnoDB;
ALTER TABLE `_contributions` ENGINE=InnoDB;

ALTER TABLE `_templatenames` CHANGE `id` `id` INT( 4 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `_formats` CHANGE `id` `id` INT( 4 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users` CHANGE `id` `id` INT( 4 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `_contributions` CHANGE `__split__` `__split__` INT( 32 ) NULL DEFAULT NULL;

SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `_contributions`
  CHANGE `__split__` `_forchapter` INTEGER(32);
  CREATE INDEX `_forchapter_key` ON `_contributions` (`_forchapter`);

ALTER TABLE `_contributions` ADD CONSTRAINT `c_chapter_fk`
    FOREIGN KEY (`_forchapter`)
    REFERENCES `_formats` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE `_contributions` ADD CONSTRAINT `c_issue_fk`
    FOREIGN KEY (`_forissue`)
    REFERENCES `_issues` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE `_contributions` ADD CONSTRAINT `c_template_fk`
    FOREIGN KEY (`_fortemplate`)
    REFERENCES `_templatenames` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;


ALTER TABLE `_data`

  CHANGE `_forcontribution` `_forcontribution` INTEGER(4),

  ADD `_content` TEXT AFTER `_fortemplatefield`,

  ADD `_isjson` TINYINT(1) AFTER `_content`;

ALTER TABLE `_data` ADD CONSTRAINT `d_contribution_fk`
    FOREIGN KEY (`_forcontribution`)
    REFERENCES `_contributions` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE `_data` ADD CONSTRAINT `d_template_fk`
    FOREIGN KEY (`_fortemplatefield`)
    REFERENCES `_templates` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE `_formats`
  ADD PRIMARY KEY ( `id` ),
  CHANGE `id` `id` INTEGER(4) NOT NULL AUTO_INCREMENT;

CREATE INDEX `f_book_fk` ON `_formats` (`_forbook`);

CREATE UNIQUE INDEX `_formats_u_9d86c7` ON `_formats` (`id`(4));

ALTER TABLE `_formats` ADD CONSTRAINT `f_book_fk`
    FOREIGN KEY (`_forbook`)
    REFERENCES `_books` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

CREATE INDEX `i_book_fk` ON `_issues` (`_forbook`);

ALTER TABLE `_issues` ADD CONSTRAINT `i_book_fk`
    FOREIGN KEY (`_forbook`)
    REFERENCES `_books` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;


ALTER TABLE `_templatenames`

  CHANGE `id` `id` INTEGER(4) NOT NULL AUTO_INCREMENT,

  ADD PRIMARY KEY (`id`);

CREATE INDEX `_fortemplate_key` ON `_templates` (`_fortemplate`);

ALTER TABLE `_templates` ADD CONSTRAINT `t_template_fk`
    FOREIGN KEY (`_fortemplate`)
    REFERENCES `_templatenames` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE `users`

  CHANGE `id` `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
  CHANGE `filerights` `email` TEXT,
  CHANGE `pluginrights` `roapikey` TEXT,
  ADD `rwapikey` TEXT AFTER `roapikey`;



CREATE TABLE `R_batch_forbook`
(
    `_batchid` INTEGER NOT NULL,
    `_bookid` INTEGER NOT NULL,
    PRIMARY KEY (`_batchid`,`_bookid`),
    INDEX `r_batch_b` (`_bookid`),
    CONSTRAINT `r_batch_a`
        FOREIGN KEY (`_batchid`)
        REFERENCES `_batch` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_batch_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_fieldpostprocessor_forfield`
(
    `_postprocessorid` INTEGER NOT NULL,
    `_templateid` INTEGER NOT NULL,
    PRIMARY KEY (`_postprocessorid`,`_templateid`),
    INDEX `r_post_b` (`_templateid`),
    CONSTRAINT `r_post_a`
        FOREIGN KEY (`_postprocessorid`)
        REFERENCES `_fieldpostprocessor` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_post_b`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templates` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_issues_allplugin`
(
    `_issueid` INTEGER NOT NULL,
    `_pluginid` INTEGER NOT NULL,
    PRIMARY KEY (`_issueid`,`_pluginid`),
    INDEX `r_plugins2_b` (`_pluginid`),
    CONSTRAINT `r_plugins2_a`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugins2_b`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_issues_narrationplugin`
(
    `_issueid` INTEGER NOT NULL,
    `_pluginid` INTEGER NOT NULL,
    PRIMARY KEY (`_issueid`,`_pluginid`),
    INDEX `r_plugins5_b` (`_pluginid`),
    CONSTRAINT `r_plugins5_a`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugins5_b`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_issues_rtfplugin`
(
    `_issueid` INTEGER NOT NULL,
    `_pluginid` INTEGER NOT NULL,
    PRIMARY KEY (`_issueid`,`_pluginid`),
    INDEX `r_plugins3_b` (`_pluginid`),
    CONSTRAINT `r_plugins3_a`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugins3_b`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_issues_singleplugin`
(
    `_issueid` INTEGER NOT NULL,
    `_pluginid` INTEGER NOT NULL,
    PRIMARY KEY (`_issueid`,`_pluginid`),
    INDEX `r_plugins1_b` (`_pluginid`),
    CONSTRAINT `r_plugins1_a`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugins1_b`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_issues_xmlplugin`
(
    `_issueid` INTEGER NOT NULL,
    `_pluginid` INTEGER NOT NULL,
    PRIMARY KEY (`_issueid`,`_pluginid`),
    INDEX `r_plugins4_b` (`_pluginid`),
    CONSTRAINT `r_plugins4_a`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugins4_b`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_rights_forbook`
(
    `_rightid` INTEGER NOT NULL,
    `_bookid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_bookid`),
    INDEX `r_rights3_b` (`_bookid`),
    CONSTRAINT `r_rights3_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights3_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_rights_forissue`
(
    `_rightid` INTEGER NOT NULL,
    `_issueid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_issueid`),
    INDEX `r_rights2_b` (`_issueid`),
    CONSTRAINT `r_rights2_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights2_b`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_rights_fortemplate`
(
    `_rightid` INTEGER NOT NULL,
    `_templateid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_templateid`),
    INDEX `r_rights1_b` (`_templateid`),
    CONSTRAINT `r_rights1_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights1_b`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_rights_foruser`
(
    `_rightid` INTEGER NOT NULL,
    `_userid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_userid`),
    INDEX `r_rights4_b` (`_userid`),
    CONSTRAINT `r_rights4_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights4_b`
        FOREIGN KEY (`_userid`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_templatenames_forbook`
(
    `_templateid` INTEGER NOT NULL,
    `_bookid` INTEGER NOT NULL,
    PRIMARY KEY (`_templateid`,`_bookid`),
    INDEX `r_templates2_b` (`_bookid`),
    CONSTRAINT `r_templates2_a`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_templates2_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_templatenames_inchapter`
(
    `_templateid` INTEGER NOT NULL,
    `_chapterid` INTEGER NOT NULL,
    PRIMARY KEY (`_templateid`,`_chapterid`),
    INDEX `r_templates1_b` (`_chapterid`),
    CONSTRAINT `r_templates1_a`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_templates1_b`
        FOREIGN KEY (`_chapterid`)
        REFERENCES `_formats` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

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

DROP TABLE IF EXISTS `R_batch_forbook`;

DROP TABLE IF EXISTS `R_fieldpostprocessor_forfield`;

DROP TABLE IF EXISTS `R_issues_allplugin`;

DROP TABLE IF EXISTS `R_issues_narrationplugin`;

DROP TABLE IF EXISTS `R_issues_rtfplugin`;

DROP TABLE IF EXISTS `R_issues_singleplugin`;

DROP TABLE IF EXISTS `R_issues_xmlplugin`;

DROP TABLE IF EXISTS `R_rights_forbook`;

DROP TABLE IF EXISTS `R_rights_forissue`;

DROP TABLE IF EXISTS `R_rights_fortemplate`;

DROP TABLE IF EXISTS `R_rights_foruser`;

DROP TABLE IF EXISTS `R_templatenames_forbook`;

DROP TABLE IF EXISTS `R_templatenames_inchapter`;

ALTER TABLE `_contributions` DROP FOREIGN KEY `c_chapter_fk`;

ALTER TABLE `_contributions` DROP FOREIGN KEY `c_issue_fk`;

ALTER TABLE `_contributions` DROP FOREIGN KEY `c_template_fk`;

DROP INDEX `_forchapter_key` ON `_contributions`;

ALTER TABLE `_contributions`

  CHANGE `__split__` `__split__` TEXT;

ALTER TABLE `_data` DROP FOREIGN KEY `d_contribution_fk`;

ALTER TABLE `_data` DROP FOREIGN KEY `d_template_fk`;

ALTER TABLE `_data`

  CHANGE `_forcontribution` `_forcontribution` INTEGER(32),

  DROP `_content`,

  DROP `_isjson`;

CREATE INDEX `_datatext_index` ON `_data` (`_datatext`);

ALTER TABLE `_formats` DROP FOREIGN KEY `f_book_fk`;

DROP INDEX `f_book_fk` ON `_formats`;

DROP INDEX `_formats_u_9d86c7` ON `_formats`;

ALTER TABLE `_formats`
  CHANGE `id` `id` BIGINT(32) NOT NULL AUTO_INCREMENT;

ALTER TABLE `_issues` DROP FOREIGN KEY `i_book_fk`;

DROP INDEX `i_book_fk` ON `_issues`;

ALTER TABLE `_templatenames`

  DROP PRIMARY KEY,

  CHANGE `id` `id` BIGINT(32) NOT NULL AUTO_INCREMENT;

CREATE INDEX `id` ON `_templatenames` (`id`);

ALTER TABLE `_templates` DROP FOREIGN KEY `t_template_fk`;

DROP INDEX `_fortemplate_key` ON `_templates`;

ALTER TABLE `users`

  CHANGE `id` `id` INTEGER(32) NOT NULL AUTO_INCREMENT;
  CHANGE `email` `filerights` TEXT,
  CHANGE `roapikey` `pluginrights` TEXT,
  DROP `rwapikey`;
  

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}