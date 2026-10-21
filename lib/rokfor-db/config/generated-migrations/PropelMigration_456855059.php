<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1456855059.
 * Generated on 2016-03-01 17:57:39 by urshofer
 */
class PropelMigration_456855059
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

ALTER TABLE `_contributions`

  ADD `version` INTEGER DEFAULT 0 AFTER `__sort__`,

  ADD `version_created_at` DATETIME AFTER `version`,

  ADD `version_created_by` VARCHAR(100) AFTER `version_created_at`,

  ADD `version_comment` VARCHAR(255) AFTER `version_created_by`;


ALTER TABLE `_data`

  ADD `version` INTEGER DEFAULT 0 AFTER `__sort__`,

  ADD `version_created_at` DATETIME AFTER `version`,

  ADD `version_created_by` VARCHAR(100) AFTER `version_created_at`,

  ADD `version_comment` VARCHAR(255) AFTER `version_created_by`;

CREATE TABLE `_contributions_version`
(
    `id` INTEGER(4) NOT NULL,
    `_fortemplate` INTEGER(32),
    `_forissue` INTEGER(32),
    `_name` TEXT,
    `_status` TEXT,
    `_newdate` INTEGER(40),
    `_moddate` INTEGER(40),
    `__user__` INTEGER(4),
    `__config__` TEXT,
    `_forchapter` INTEGER(32),
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `version_comment` VARCHAR(255),
    `_data_ids` TEXT,
    `_data_versions` TEXT,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `_contributions_version_fk_58714c`
        FOREIGN KEY (`id`)
        REFERENCES `_contributions` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `_data_version`
(
    `id` INTEGER(4) NOT NULL,
    `_forcontribution` INTEGER(4),
    `_fortemplatefield` INTEGER(32),
    `_content` TEXT,
    `_isjson` TINYINT(1),
    `__user__` INTEGER(4),
    `__config__` TEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `version_comment` VARCHAR(255),
    `_forcontribution_version` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `_data_version_fk_32c4d1`
        FOREIGN KEY (`id`)
        REFERENCES `_data` (`id`)
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

DROP TABLE IF EXISTS `_contributions_version`;

DROP TABLE IF EXISTS `_data_version`;

DROP INDEX `r_rights5_b` ON `R_rights_forformat`;

CREATE INDEX `r_rights4_b` ON `R_rights_forformat` (`_formatid`);

DROP INDEX `_user_index` ON `_books`;

CREATE INDEX `user_ref_books` ON `_books` (`__user__`);

DROP INDEX `_user_index` ON `_contributions`;

ALTER TABLE `_contributions`

  DROP `version`,

  DROP `version_created_at`,

  DROP `version_created_by`,

  DROP `version_comment`;

CREATE INDEX `user_ref_contribs` ON `_contributions` (`__user__`);

ALTER TABLE `_data`

  DROP `version`,

  DROP `version_created_at`,

  DROP `version_created_by`,

  DROP `version_comment`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}