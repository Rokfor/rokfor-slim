<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1505983179.
 * Generated on 2017-09-21 08:39:39 by urshofer
 */
class PropelMigration_1505983179
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
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

ALTER TABLE `_plugins`

  CHANGE `__config__` `_api` TEXT,

  DROP `__split__`,

  DROP `__parentnode__`,

  DROP `__sort__`,

  DROP `_page`,

  DROP `_config`,

  DROP `_callback`;

CREATE TABLE `R_plugin_book`
(
    `_pluginid` INTEGER(4) NOT NULL,
    `_bookid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_pluginid`,`_bookid`),
    INDEX `r_plugin1_a` (`_pluginid`),
    INDEX `r_plugin1_b` (`_bookid`),
    CONSTRAINT `r_plugin1_a`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugin1_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_plugin_format`
(
    `_pluginid` INTEGER(4) NOT NULL,
    `_formatid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_pluginid`,`_formatid`),
    INDEX `r_plugin2_a` (`_pluginid`),
    INDEX `r_plugin2_b` (`_formatid`),
    CONSTRAINT `r_plugin2_a`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugin2_b`
        FOREIGN KEY (`_formatid`)
        REFERENCES `_formats` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_plugin_issue`
(
    `_pluginid` INTEGER(4) NOT NULL,
    `_issueid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_pluginid`,`_issueid`),
    INDEX `r_plugin3_a` (`_pluginid`),
    INDEX `r_plugin3_b` (`_issueid`),
    CONSTRAINT `r_plugin3_a`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugin3_b`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `R_plugin_template`
(
    `_pluginid` INTEGER(4) NOT NULL,
    `_templateid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_pluginid`,`_templateid`),
    INDEX `r_plugin4_a` (`_pluginid`),
    INDEX `r_plugin4_b` (`_templateid`),
    CONSTRAINT `r_plugin4_a`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugin4_b`
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

DROP TABLE IF EXISTS `R_plugin_book`;

DROP TABLE IF EXISTS `R_plugin_format`;

DROP TABLE IF EXISTS `R_plugin_issue`;

DROP TABLE IF EXISTS `R_plugin_template`;

ALTER TABLE `_plugins`

  CHANGE `_api` `__config__` TEXT,

  ADD `__split__` TEXT AFTER `__config__`,

  ADD `__parentnode__` INTEGER(32) AFTER `__split__`,

  ADD `__sort__` INTEGER(32) AFTER `__parentnode__`,

  ADD `_page` TEXT AFTER `__sort__`,

  ADD `_config` TEXT AFTER `_page`,

  ADD `_callback` TEXT AFTER `_config`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}