<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1453122685.
 * Generated on 2016-01-18 13:11:25 by urshofer
 */
class PropelMigration_1453122685
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
        $pdo = $manager->getAdapterConnection('rokfor');

        $sql = "DELETE FROM _contributions WHERE _forissue NOT IN (SELECT id from _issues)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $sql = "DELETE FROM _contributions WHERE _forchapter NOT IN (SELECT id from _formats)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        
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

ALTER TABLE `_books` ADD CONSTRAINT `user_ref_books`
    FOREIGN KEY (`__user__`)
    REFERENCES `users` (`id`)
    ON UPDATE SET NULL
    ON DELETE SET NULL;

ALTER TABLE `_contributions` ADD CONSTRAINT `user_ref_contribs`
    FOREIGN KEY (`__user__`)
    REFERENCES `users` (`id`)
    ON UPDATE SET NULL
    ON DELETE SET NULL;

CREATE INDEX `_user_index` ON `_data` (`__user__`);

ALTER TABLE `_data` ADD CONSTRAINT `user_ref_data`
    FOREIGN KEY (`__user__`)
    REFERENCES `users` (`id`)
    ON UPDATE SET NULL
    ON DELETE SET NULL;

ALTER TABLE `_fieldpostprocessor`

  DROP `__user__`;

CREATE INDEX `_user_index` ON `_formats` (`__user__`);

ALTER TABLE `_formats` ADD CONSTRAINT `user_ref_formats`
    FOREIGN KEY (`__user__`)
    REFERENCES `users` (`id`)
    ON UPDATE SET NULL
    ON DELETE SET NULL;

CREATE INDEX `_user_index` ON `_issues` (`__user__`);

ALTER TABLE `_issues` ADD CONSTRAINT `user_ref_issues`
    FOREIGN KEY (`__user__`)
    REFERENCES `users` (`id`)
    ON UPDATE SET NULL
    ON DELETE SET NULL;

ALTER TABLE `_log`

  DROP `__user__`;

ALTER TABLE `_pdf`

  DROP `__user__`;

ALTER TABLE `_plugins`

  DROP `__user__`;

ALTER TABLE `_rights`

  DROP `__user__`;

ALTER TABLE `_templatenames`

  DROP `__user__`;

ALTER TABLE `_templates`

  DROP `__user__`;
  
ALTER TABLE `_templatenames` 

  CHANGE `_helpimage` `_helpimage` TEXT NULL;

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

ALTER TABLE `_books` DROP FOREIGN KEY `user_ref_books`;

ALTER TABLE `_books` ADD CONSTRAINT `user_ref`
    FOREIGN KEY (`__user__`)
    REFERENCES `users` (`id`)
    ON UPDATE SET NULL
    ON DELETE SET NULL;

ALTER TABLE `_contributions` DROP FOREIGN KEY `user_ref_contribs`;

ALTER TABLE `_data` DROP FOREIGN KEY `user_ref_data`;

DROP INDEX `_user_index` ON `_data`;

ALTER TABLE `_fieldpostprocessor`

  ADD `__user__` INTEGER(4) AFTER `_code`;

ALTER TABLE `_formats` DROP FOREIGN KEY `user_ref_formats`;

DROP INDEX `_user_index` ON `_formats`;

ALTER TABLE `_issues` DROP FOREIGN KEY `user_ref_issues`;

DROP INDEX `_user_index` ON `_issues`;

ALTER TABLE `_log`

  ADD `__user__` INTEGER(4) AFTER `_date`;

ALTER TABLE `_pdf`

  ADD `__user__` INTEGER(4) AFTER `_pages`;

ALTER TABLE `_plugins`

  ADD `__user__` INTEGER(4) AFTER `_name`;

ALTER TABLE `_rights`

  ADD `__user__` INTEGER(4) AFTER `_group`;

ALTER TABLE `_templatenames`

  ADD `__user__` INTEGER(4) AFTER `_public`;

ALTER TABLE `_templates`

  ADD `__user__` INTEGER(4) AFTER `_fieldtype`;
  
ALTER TABLE `_templatenames` 

  CHANGE `_helpimage` `_helpimage` NULL;  


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}