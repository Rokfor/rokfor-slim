<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1477945744.
 * Generated on 2016-10-31 20:29:04 by urshofer
 */
class PropelMigration_1477824860
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

ALTER TABLE `_data`

  CHANGE `_content` `_content` LONGTEXT;

ALTER TABLE `_data_version`

  CHANGE `_content` `_content` LONGTEXT;

CREATE TABLE `_contributions_cache`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_signature` VARCHAR(255) NOT NULL,
    `_forcontribution` INTEGER(4),
    `_cache` LONGTEXT,
    PRIMARY KEY (`id`),
    INDEX `_cacheforcontribution_index` (`_forcontribution`),
    INDEX `_signature_index` (`_signature`),
    CONSTRAINT `c_contribution_fk`
        FOREIGN KEY (`_forcontribution`)
        REFERENCES `_contributions` (`id`)
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

DROP TABLE IF EXISTS `_contributions_cache`;

ALTER TABLE `_data`

  CHANGE `_content` `_content` TEXT;

ALTER TABLE `_data_version`

  CHANGE `_content` `_content` TEXT;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}