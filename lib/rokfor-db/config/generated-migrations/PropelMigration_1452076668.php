<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1452076668.
 * Generated on 2016-01-06 10:37:48 by urshofer
 */
class PropelMigration_1452076668
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

  DROP `_datatext`,

  DROP `_databinary`,

  DROP `_datainteger`;

DROP INDEX `_formats_u_9d86c7` ON `_formats`;

CREATE UNIQUE INDEX `_formats_u_9d86c7` ON `_formats` (`id`(4));

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

ALTER TABLE `_data`

  ADD `_datatext` TEXT AFTER `_isjson`,

  ADD `_databinary` TEXT AFTER `_datatext`,

  ADD `_datainteger` INTEGER(32) AFTER `_databinary`;

DROP INDEX `_formats_u_9d86c7` ON `_formats`;

CREATE UNIQUE INDEX `_formats_u_9d86c7` ON `_formats` (`id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}