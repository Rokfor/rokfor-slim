<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1452077180.
 * Generated on 2016-01-06 10:46:20 by urshofer
 */
class PropelMigration_1452077180
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

ALTER TABLE `_batch`

  DROP `_forbook`;

ALTER TABLE `_fieldpostprocessor`

  DROP `_forfield`;

DROP INDEX `_formats_u_9d86c7` ON `_formats`;

CREATE UNIQUE INDEX `_formats_u_9d86c7` ON `_formats` (`id`(4));

ALTER TABLE `_issues`

  DROP `_singleplugin`,

  DROP `_allplugin`,

  DROP `_rtfplugin`,

  DROP `_xmlplugin`,

  DROP `_narrationplugin`;

ALTER TABLE `_rights`

  DROP `_fortemplate`,

  DROP `_forissue`,

  DROP `_forbook`,

  DROP `_foruser`;

ALTER TABLE `_templatenames`

  DROP `_inchapter`,

  DROP `_forbook`;

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

ALTER TABLE `_fieldpostprocessor`

  ADD `_forfield` TEXT AFTER `_name`;

DROP INDEX `_formats_u_9d86c7` ON `_formats`;

CREATE UNIQUE INDEX `_formats_u_9d86c7` ON `_formats` (`id`);

ALTER TABLE `_issues`

  ADD `_singleplugin` TEXT AFTER `_forbook`,

  ADD `_allplugin` TEXT AFTER `_singleplugin`,

  ADD `_rtfplugin` TEXT AFTER `_allplugin`,

  ADD `_xmlplugin` TEXT AFTER `_rtfplugin`,

  ADD `_narrationplugin` TEXT AFTER `_xmlplugin`;

ALTER TABLE `_rights`

  ADD `_fortemplate` TEXT AFTER `_group`,

  ADD `_forissue` TEXT AFTER `_fortemplate`,

  ADD `_forbook` TEXT AFTER `_forissue`,

  ADD `_foruser` TEXT AFTER `_forbook`;

ALTER TABLE `_templatenames`

  ADD `_inchapter` TEXT NOT NULL AFTER `_helpimage`,

  ADD `_forbook` TEXT AFTER `_inchapter`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}