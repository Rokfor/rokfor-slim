<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1454919452.
 * Generated on 2016-02-08 08:17:32 by urshofer
 */
class PropelMigration_1454919452
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


CREATE TABLE `R_rights_forformat`
(
    `_rightid` INTEGER NOT NULL,
    `_formatid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_formatid`),
    INDEX `r_rights4_b` (`_formatid`),
    CONSTRAINT `r_rights5_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights5_b`
        FOREIGN KEY (`_formatid`)
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

DROP TABLE IF EXISTS `R_rights_forformat`;

DROP INDEX `_user_index` ON `_books`;

CREATE INDEX `user_ref_books` ON `_books` (`__user__`);

DROP INDEX `_user_index` ON `_contributions`;

CREATE INDEX `user_ref_contribs` ON `_contributions` (`__user__`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}