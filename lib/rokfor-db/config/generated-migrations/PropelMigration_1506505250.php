<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1506505250.
 * Generated on 2017-09-27 11:40:50 by urshofer
 */
class PropelMigration_1506505250
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

ALTER TABLE `_pdf`

  CHANGE `__config__` `_fileinfo` TEXT,

  CHANGE `__split__` `_otc` TEXT,

  ADD `_config` TEXT AFTER `_otc`,

  ADD `_configvalue` INTEGER(32) AFTER `_config`,

  DROP `_pages`,

  DROP `__parentnode__`;

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

ALTER TABLE `_pdf`

  CHANGE `_fileinfo` `__config__` TEXT,

  CHANGE `_otc` `__split__` TEXT,

  ADD `_pages` INTEGER(32) AFTER `_plugin`,

  ADD `__parentnode__` INTEGER(32) AFTER `__split__`,

  DROP `_config`,

  DROP `_configvalue`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}