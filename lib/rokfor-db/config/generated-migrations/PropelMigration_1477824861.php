<?php

// bootstrap the Propel runtime (and other dependencies)
require_once __DIR__ . '/../../vendor/autoload.php';
set_include_path(__DIR__ . '/../generated-classes' . PATH_SEPARATOR . get_include_path());
include __DIR__ .'/../generated-conf/config.php';

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1477824861.
 * Generated on 2016-10-30 10:54:21 by urshofer
 */
class PropelMigration_1477824861
{
    public $comment = '';
    
    private function _updateReferencedObjects($field) {
      $type     = $field->getTemplates();
      $data     = $field->getContent();
      if ($type->getFieldtype() == "TypologySelect" || $type->getFieldtype() == "TypologyKeyword") {
        $settings = json_decode($type->getConfigSys());      
        $decoded  = (is_array($data) || is_object($data) || is_numeric($data)) 
                    ? $data
                    : json_decode($data);
        $getAction = false;
        $queryAction = false;
        switch ($settings->history_command) {
          case 'contributional':
            $getAction = 'setRContributions';
            $queryAction = 'ContributionsQuery';
            break;
          case 'books':
            $getAction = 'setRBooks';
            $queryAction = 'BooksQuery';
            break;
          case 'issues':
            $getAction = 'setRIssues';
            $queryAction = 'IssuesQuery';
            break;
          case 'chapters':
            $getAction = 'setRFormats';
            $queryAction = 'FormatsQuery';
            break;      
          case 'structural':
            $getAction = 'setRTemplates';
            $queryAction = 'TemplatesQuery';
            break;
          //case 'self':
          case 'other':
            $getAction = 'setRDataRefs';
            $queryAction = 'DataQuery';
            break;
        }
        if ($getAction && $queryAction) {
          $field->$getAction($queryAction::create()->filterById($decoded)->find())->save();
        }
        echo "Updated {$field->getId()}\n";
      }
    }
    

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
        
        $pdo = $manager->getAdapterConnection('rokfor');
        date_default_timezone_set('UTC');

        // migrate data into new content field, set json to true if it is jsonized.
        $datasets = DataQuery::create()->find();
        $count = 0;
        echo "\n";
        echo "Updating " . count($datasets) . " Fields: ";

        foreach ($datasets as $field) {
          $this->_updateReferencedObjects($field);
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

CREATE TABLE `R_data_data`
(
    `_src` INTEGER(4) NOT NULL,
    `_ref` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_src`,`_ref`),
    INDEX `r_data1_a` (`_src`),
    INDEX `r_data1_b` (`_ref`),
    CONSTRAINT `r_data1_a`
        FOREIGN KEY (`_src`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data1_b`
        FOREIGN KEY (`_ref`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_data_contribution`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_contributionid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_contributionid`),
    INDEX `r_data2_a` (`_dataid`),
    INDEX `r_data2_b` (`_contributionid`),
    CONSTRAINT `r_data2_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data2_b`
        FOREIGN KEY (`_contributionid`)
        REFERENCES `_contributions` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_data_book`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_bookid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_bookid`),
    INDEX `r_data3_a` (`_dataid`),
    INDEX `r_data3_b` (`_bookid`),
    CONSTRAINT `r_data3_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data3_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_data_format`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_formatid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_formatid`),
    INDEX `r_data4_a` (`_dataid`),
    INDEX `r_data4_b` (`_formatid`),
    CONSTRAINT `r_data4_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data4_b`
        FOREIGN KEY (`_formatid`)
        REFERENCES `_formats` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_data_issue`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_issueid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_issueid`),
    INDEX `r_data5_a` (`_dataid`),
    INDEX `r_data5_b` (`_issueid`),
    CONSTRAINT `r_data5_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data5_b`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_data_template`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_templateid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_templateid`),
    INDEX `r_data6_a` (`_dataid`),
    INDEX `r_data6_b` (`_templateid`),
    CONSTRAINT `r_data6_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data6_b`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templates` (`id`)
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

DROP TABLE IF EXISTS `R_data_data`;

DROP TABLE IF EXISTS `R_data_contribution`;

DROP TABLE IF EXISTS `R_data_book`;

DROP TABLE IF EXISTS `R_data_format`;

DROP TABLE IF EXISTS `R_data_issue`;

DROP TABLE IF EXISTS `R_data_template`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}