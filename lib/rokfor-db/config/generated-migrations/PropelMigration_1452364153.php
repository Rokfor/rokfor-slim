<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1452364153.
 * Generated on 2016-01-09 18:29:13 by urshofer
 */
class PropelMigration_1452364153
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

ALTER TABLE `_templates`

  DROP `_maxlines`,

  DROP `_textlength`,

  DROP `_imagewidth`,

  DROP `_imageheight`,

  DROP `_cols`,

  DROP `_colNames`,

  DROP `_history`,

  DROP `_growing`,

  DROP `_lengthInfluence`;

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

ALTER TABLE `_templates`

  ADD `_maxlines` INTEGER(32) AFTER `_fieldtype`,

  ADD `_textlength` INTEGER(32) AFTER `_maxlines`,

  ADD `_imagewidth` TEXT AFTER `_textlength`,

  ADD `_imageheight` TEXT AFTER `_imagewidth`,

  ADD `_cols` INTEGER(32) AFTER `_imageheight`,

  ADD `_colNames` TEXT AFTER `_cols`,

  ADD `_history` TEXT AFTER `_colNames`,

  ADD `_growing` TEXT AFTER `_history`,

  ADD `_lengthInfluence` TEXT AFTER `_growing`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}