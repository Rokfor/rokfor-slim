<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1494930480.
 * Generated on 2017-05-16 10:28:00 by urshofer
 */
class PropelMigration_1494930480
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

DROP TABLE IF EXISTS `R_issues_allplugin`;

DROP TABLE IF EXISTS `R_issues_narrationplugin`;

DROP TABLE IF EXISTS `R_issues_rtfplugin`;

DROP TABLE IF EXISTS `R_issues_singleplugin`;

DROP TABLE IF EXISTS `R_issues_xmlplugin`;

CREATE INDEX `i_pdf_fk` ON `_pdf` (`_plugin`);

ALTER TABLE `_pdf` ADD CONSTRAINT `i_pdf_fk`
    FOREIGN KEY (`_plugin`)
    REFERENCES `_plugins` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE `_plugins`

  CHANGE `_page` `_page` TEXT,

  CHANGE `_config` `_config` TEXT,

  CHANGE `_callback` `_callback` TEXT;

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

ALTER TABLE `_pdf` DROP FOREIGN KEY `i_pdf_fk`;

DROP INDEX `i_pdf_fk` ON `_pdf`;

ALTER TABLE `_plugins`

  CHANGE `_page` `_page` LONGTEXT,

  CHANGE `_config` `_config` LONGTEXT,

  CHANGE `_callback` `_callback` LONGTEXT;

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

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}