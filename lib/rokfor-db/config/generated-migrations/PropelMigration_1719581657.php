<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1719581657.
 * Generated on 2024-06-28 13:34:17 by urshofer
 */
class PropelMigration_1719581657
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
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
ALTER TABLE `_contributions_cache`
  ADD `_book` TEXT(65535) AFTER `_cache`,
  ADD `_issue` TEXT(65535) AFTER `_book`,
  ADD `_chapter` TEXT(65535) AFTER `_issue`,
  ADD `_template` TEXT(65535) AFTER `_chapter`,
  ADD `_contribution` TEXT(65535) AFTER `_template`,
  ADD `_touched` timestamp NULL DEFAULT CURRENT_TIMESTAMP;
  CREATE INDEX `_book_index` ON `_contributions_cache` (`_book`(768));
  CREATE INDEX `_issue_index` ON `_contributions_cache` (`_issue`(768));
  CREATE INDEX `_chapter_index` ON `_contributions_cache` (`_chapter`(768));
  CREATE INDEX `_template_index` ON `_contributions_cache` (`_template`(768));
  CREATE INDEX `_contribution_index` ON `_contributions_cache` (`_contribution`(768));
',
);
    }

}