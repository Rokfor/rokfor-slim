<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1453121154.
 * Generated on 2016-01-18 12:45:54 by urshofer
 */
class PropelMigration_1453121154
{
    public $comment = '';

    public function preUp($manager)
    {
      // add the pre-migration code here
      $pdo = $manager->getAdapterConnection('rokfor');
      $sql = "SELECT id FROM users";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $valid_id = [] ;
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $id) {
        $valid_id[] = $id[id];
      }
      $update_id = reset($valid_id);
      $tables = [_batch, _books, _contributions, _data, _fieldpostprocessor, _formats, _issues, _log, _pdf, _plugins, _rights, _templatenames, _templates];
      foreach ($tables as $table) {
        $sql = "SELECT id, __user__ FROM $table";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
          if (!in_array($value['__user__'], $valid_id)) {
            $sql = "UPDATE $table SET __user__ = $update_id WHERE id = ".$value['id'];
            $st = $pdo->prepare($sql);
            $st->execute();
            echo "$sql\n";
          }
        }
      }
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
SET sql_mode = \'\';

ALTER TABLE `_batch`

  CHANGE `__user__` `__user__` INTEGER(4) DEFAULT NULL;

ALTER TABLE `_books`

  CHANGE `__user__` `__user__` INTEGER(4) DEFAULT NULL;

ALTER TABLE `_contributions`

  CHANGE `__user__` `__user__` INTEGER(4) DEFAULT NULL;

ALTER TABLE `_data`

  CHANGE `__user__` `__user__` INTEGER(4) DEFAULT NULL;

ALTER TABLE `_fieldpostprocessor`

  CHANGE `__user__` `__user__` INTEGER(4) DEFAULT NULL;

DROP INDEX `_formats_u_9d86c7` ON `_formats`;

ALTER TABLE `_formats`

  CHANGE `__user__` `__user__` INTEGER(4) DEFAULT NULL;

ALTER TABLE `_issues`

  CHANGE `__user__` `__user__` INTEGER(4) DEFAULT NULL;

ALTER TABLE `_log`

  CHANGE `__user__` `__user__` INTEGER(4) DEFAULT NULL;

ALTER TABLE `_pdf`

  CHANGE `__user__` `__user__` INTEGER(4);

ALTER TABLE `_plugins`

  CHANGE `__user__` `__user__` INTEGER(4);

ALTER TABLE `_rights`

  CHANGE `__user__` `__user__` INTEGER(4);

DROP INDEX `id` ON `_templatenames`;

ALTER TABLE `_templatenames`

  CHANGE `__user__` `__user__` INTEGER(4);

ALTER TABLE `_templates`

  CHANGE `__user__` `__user__` INTEGER(4);

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

ALTER TABLE `_batch`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_books`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_contributions`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_data`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_fieldpostprocessor`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_formats`

  CHANGE `__user__` `__user__` TEXT;

CREATE UNIQUE INDEX `_formats_u_9d86c7` ON `_formats` (`id`);

ALTER TABLE `_issues`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_log`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_pdf`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_plugins`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_rights`

  CHANGE `__user__` `__user__` TEXT;

ALTER TABLE `_templatenames`

  CHANGE `__user__` `__user__` TEXT;

CREATE INDEX `id` ON `_templatenames` (`id`);

ALTER TABLE `_templates`

  CHANGE `__user__` `__user__` TEXT;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}