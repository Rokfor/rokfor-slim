
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- R_batch_forbook
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_batch_forbook`;

CREATE TABLE `R_batch_forbook`
(
    `_batchid` INTEGER NOT NULL,
    `_bookid` INTEGER NOT NULL,
    PRIMARY KEY (`_batchid`,`_bookid`),
    INDEX `r_batch_b` (`_bookid`),
    CONSTRAINT `r_batch_a`
        FOREIGN KEY (`_batchid`)
        REFERENCES `_batch` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_batch_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_fieldpostprocessor_forfield
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_fieldpostprocessor_forfield`;

CREATE TABLE `R_fieldpostprocessor_forfield`
(
    `_postprocessorid` INTEGER NOT NULL,
    `_templateid` INTEGER NOT NULL,
    PRIMARY KEY (`_postprocessorid`,`_templateid`),
    INDEX `r_post_b` (`_templateid`),
    CONSTRAINT `r_post_a`
        FOREIGN KEY (`_postprocessorid`)
        REFERENCES `_fieldpostprocessor` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_post_b`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templates` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_rights_forbook
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_rights_forbook`;

CREATE TABLE `R_rights_forbook`
(
    `_rightid` INTEGER NOT NULL,
    `_bookid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_bookid`),
    INDEX `r_rights3_b` (`_bookid`),
    CONSTRAINT `r_rights3_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights3_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_rights_forissue
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_rights_forissue`;

CREATE TABLE `R_rights_forissue`
(
    `_rightid` INTEGER NOT NULL,
    `_issueid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_issueid`),
    INDEX `r_rights2_b` (`_issueid`),
    CONSTRAINT `r_rights2_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights2_b`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_rights_fortemplate
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_rights_fortemplate`;

CREATE TABLE `R_rights_fortemplate`
(
    `_rightid` INTEGER NOT NULL,
    `_templateid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_templateid`),
    INDEX `r_rights1_b` (`_templateid`),
    CONSTRAINT `r_rights1_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights1_b`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_rights_forformat
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_rights_forformat`;

CREATE TABLE `R_rights_forformat`
(
    `_rightid` INTEGER NOT NULL,
    `_formatid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_formatid`),
    INDEX `r_rights5_b` (`_formatid`),
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

-- ---------------------------------------------------------------------
-- R_rights_foruser
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_rights_foruser`;

CREATE TABLE `R_rights_foruser`
(
    `_rightid` INTEGER NOT NULL,
    `_userid` INTEGER NOT NULL,
    PRIMARY KEY (`_rightid`,`_userid`),
    INDEX `r_rights4_b` (`_userid`),
    CONSTRAINT `r_rights4_a`
        FOREIGN KEY (`_rightid`)
        REFERENCES `_rights` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_rights4_b`
        FOREIGN KEY (`_userid`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_templatenames_forbook
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_templatenames_forbook`;

CREATE TABLE `R_templatenames_forbook`
(
    `_templateid` INTEGER NOT NULL,
    `_bookid` INTEGER NOT NULL,
    PRIMARY KEY (`_templateid`,`_bookid`),
    INDEX `r_templates2_b` (`_bookid`),
    CONSTRAINT `r_templates2_a`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_templates2_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_templatenames_inchapter
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_templatenames_inchapter`;

CREATE TABLE `R_templatenames_inchapter`
(
    `_templateid` INTEGER NOT NULL,
    `_chapterid` INTEGER NOT NULL,
    PRIMARY KEY (`_templateid`,`_chapterid`),
    INDEX `r_templates1_b` (`_chapterid`),
    CONSTRAINT `r_templates1_a`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_templates1_b`
        FOREIGN KEY (`_chapterid`)
        REFERENCES `_formats` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _batch
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_batch`;

CREATE TABLE `_batch`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_name` TEXT,
    `_description` TEXT,
    `_precode` TEXT,
    `_postcode` TEXT,
    `__config__` TEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _books
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_books`;

CREATE TABLE `_books`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_name` TEXT,
    `__user__` INTEGER(4),
    `__config__` TEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    PRIMARY KEY (`id`),
    INDEX `_user_index` (`__user__`),
    CONSTRAINT `user_ref_books`
        FOREIGN KEY (`__user__`)
        REFERENCES `users` (`id`)
        ON UPDATE SET NULL
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _contributions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_contributions`;

CREATE TABLE `_contributions`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
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
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `version_comment` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `_user_index` (`__user__`),
    INDEX `_contributionfortemplate_index` (`_fortemplate`),
    INDEX `_contributionforissue_index` (`_forissue`),
    INDEX `_contributionname_index` (`_name`(10)),
    INDEX `_forchapter_key` (`_forchapter`),
    CONSTRAINT `user_ref_contribs`
        FOREIGN KEY (`__user__`)
        REFERENCES `users` (`id`)
        ON UPDATE SET NULL
        ON DELETE SET NULL,
    CONSTRAINT `c_chapter_fk`
        FOREIGN KEY (`_forchapter`)
        REFERENCES `_formats` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `c_issue_fk`
        FOREIGN KEY (`_forissue`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `c_template_fk`
        FOREIGN KEY (`_fortemplate`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _contributions_cache
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_contributions_cache`;

CREATE TABLE `_contributions_cache`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_signature` VARCHAR(255) NOT NULL,
    `_forcontribution` INTEGER(4),
    `_cache` LONGTEXT,
    `_book` MEDIUMTEXT,
    `_issue` MEDIUMTEXT,
    `_chapter` MEDIUMTEXT,
    `_template` MEDIUMTEXT,
    `_contribution` MEDIUMTEXT,
    `_touched` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `_cacheforcontribution_index` (`_forcontribution`),
    INDEX `_signature_index` (`_signature`),
    INDEX `_book_index` (`_book`(768)),
    INDEX `_issue_index` (`_issue`(768)),
    INDEX `_chapter_index` (`_chapter`(768)),
    INDEX `_template_index` (`_template`(768)),
    INDEX `_contribution_index` (`_contribution`(768)),
    CONSTRAINT `c_contribution_fk`
        FOREIGN KEY (`_forcontribution`)
        REFERENCES `_contributions` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _data
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_data`;

CREATE TABLE `_data`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_forcontribution` INTEGER(4),
    `_fortemplatefield` INTEGER(32),
    `_content` LONGTEXT,
    `_isjson` TINYINT(1),
    `__user__` INTEGER(4),
    `__config__` TEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `version_comment` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `_user_index` (`__user__`),
    INDEX `_dataforcontribution_index` (`_forcontribution`),
    FULLTEXT INDEX `_content` (`_content`),
    INDEX `_datafortemplatefield_index` (`_fortemplatefield`),
    CONSTRAINT `user_ref_data`
        FOREIGN KEY (`__user__`)
        REFERENCES `users` (`id`)
        ON UPDATE SET NULL
        ON DELETE SET NULL,
    CONSTRAINT `d_contribution_fk`
        FOREIGN KEY (`_forcontribution`)
        REFERENCES `_contributions` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `d_template_fk`
        FOREIGN KEY (`_fortemplatefield`)
        REFERENCES `_templates` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_data_data
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_data_data`;

CREATE TABLE `R_data_data`
(
    `_src` INTEGER(4) NOT NULL,
    `_ref` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_src`,`_ref`),
    INDEX `r_data1_a` (`_src`),
    INDEX `r_data1_b` (`_ref`),
    CONSTRAINT `r_data1_a`
        FOREIGN KEY (`_src`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data1_b`
        FOREIGN KEY (`_ref`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_data_contribution
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_data_contribution`;

CREATE TABLE `R_data_contribution`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_contributionid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_contributionid`),
    INDEX `r_data2_a` (`_dataid`),
    INDEX `r_data2_b` (`_contributionid`),
    CONSTRAINT `r_data2_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data2_b`
        FOREIGN KEY (`_contributionid`)
        REFERENCES `_contributions` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_data_book
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_data_book`;

CREATE TABLE `R_data_book`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_bookid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_bookid`),
    INDEX `r_data3_a` (`_dataid`),
    INDEX `r_data3_b` (`_bookid`),
    CONSTRAINT `r_data3_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data3_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_data_format
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_data_format`;

CREATE TABLE `R_data_format`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_formatid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_formatid`),
    INDEX `r_data4_a` (`_dataid`),
    INDEX `r_data4_b` (`_formatid`),
    CONSTRAINT `r_data4_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data4_b`
        FOREIGN KEY (`_formatid`)
        REFERENCES `_formats` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_data_issue
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_data_issue`;

CREATE TABLE `R_data_issue`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_issueid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_issueid`),
    INDEX `r_data5_a` (`_dataid`),
    INDEX `r_data5_b` (`_issueid`),
    CONSTRAINT `r_data5_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data5_b`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_data_template
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_data_template`;

CREATE TABLE `R_data_template`
(
    `_dataid` INTEGER(4) NOT NULL,
    `_templateid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_dataid`,`_templateid`),
    INDEX `r_data6_a` (`_dataid`),
    INDEX `r_data6_b` (`_templateid`),
    CONSTRAINT `r_data6_a`
        FOREIGN KEY (`_dataid`)
        REFERENCES `_data` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_data6_b`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templates` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_plugin_book
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_plugin_book`;

CREATE TABLE `R_plugin_book`
(
    `_pluginid` INTEGER(4) NOT NULL,
    `_bookid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_pluginid`,`_bookid`),
    INDEX `r_plugin1_a` (`_pluginid`),
    INDEX `r_plugin1_b` (`_bookid`),
    CONSTRAINT `r_plugin1_a`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugin1_b`
        FOREIGN KEY (`_bookid`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_plugin_format
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_plugin_format`;

CREATE TABLE `R_plugin_format`
(
    `_pluginid` INTEGER(4) NOT NULL,
    `_formatid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_pluginid`,`_formatid`),
    INDEX `r_plugin2_a` (`_pluginid`),
    INDEX `r_plugin2_b` (`_formatid`),
    CONSTRAINT `r_plugin2_a`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugin2_b`
        FOREIGN KEY (`_formatid`)
        REFERENCES `_formats` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_plugin_issue
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_plugin_issue`;

CREATE TABLE `R_plugin_issue`
(
    `_pluginid` INTEGER(4) NOT NULL,
    `_issueid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_pluginid`,`_issueid`),
    INDEX `r_plugin3_a` (`_pluginid`),
    INDEX `r_plugin3_b` (`_issueid`),
    CONSTRAINT `r_plugin3_a`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugin3_b`
        FOREIGN KEY (`_issueid`)
        REFERENCES `_issues` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- R_plugin_template
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `R_plugin_template`;

CREATE TABLE `R_plugin_template`
(
    `_pluginid` INTEGER(4) NOT NULL,
    `_templateid` INTEGER(4) NOT NULL,
    PRIMARY KEY (`_pluginid`,`_templateid`),
    INDEX `r_plugin4_a` (`_pluginid`),
    INDEX `r_plugin4_b` (`_templateid`),
    CONSTRAINT `r_plugin4_a`
        FOREIGN KEY (`_pluginid`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `r_plugin4_b`
        FOREIGN KEY (`_templateid`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _fieldpostprocessor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_fieldpostprocessor`;

CREATE TABLE `_fieldpostprocessor`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_name` TEXT,
    `_code` TEXT,
    `__config__` TEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _formats
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_formats`;

CREATE TABLE `_formats`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_name` TEXT NOT NULL,
    `_forbook` INTEGER(32),
    `__user__` INTEGER(4),
    `__config__` MEDIUMTEXT,
    `__split__` TEXT,
    `__sort__` INTEGER(32),
    `__parentnode__` INTEGER(32),
    PRIMARY KEY (`id`),
    INDEX `_user_index` (`__user__`),
    INDEX `id` (`id`),
    INDEX `f_book_fk` (`_forbook`),
    CONSTRAINT `user_ref_formats`
        FOREIGN KEY (`__user__`)
        REFERENCES `users` (`id`)
        ON UPDATE SET NULL
        ON DELETE SET NULL,
    CONSTRAINT `f_book_fk`
        FOREIGN KEY (`_forbook`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _issues
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_issues`;

CREATE TABLE `_issues`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_name` TEXT,
    `_opendate` INTEGER(40),
    `_closedate` INTEGER(40),
    `_status` TEXT,
    `_infotext` TEXT,
    `_forbook` INTEGER(32),
    `__user__` INTEGER(4),
    `__config__` MEDIUMTEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    PRIMARY KEY (`id`),
    INDEX `_user_index` (`__user__`),
    INDEX `i_book_fk` (`_forbook`),
    CONSTRAINT `user_ref_issues`
        FOREIGN KEY (`__user__`)
        REFERENCES `users` (`id`)
        ON UPDATE SET NULL
        ON DELETE SET NULL,
    CONSTRAINT `i_book_fk`
        FOREIGN KEY (`_forbook`)
        REFERENCES `_books` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_log`;

CREATE TABLE `_log`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_ip` TEXT,
    `_agent` TEXT,
    `_user` TEXT,
    `_date` INTEGER(40),
    `__config__` TEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _pdf
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_pdf`;

CREATE TABLE `_pdf`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_file` TEXT,
    `_date` INTEGER(40),
    `_issue` INTEGER(32),
    `_plugin` INTEGER(32),
    `_fileinfo` TEXT,
    `_otc` TEXT,
    `_config` TEXT,
    `_configvalue` INTEGER(32),
    `__sort__` INTEGER(32),
    PRIMARY KEY (`id`),
    INDEX `i_pdf_fk` (`_plugin`),
    CONSTRAINT `i_pdf_fk`
        FOREIGN KEY (`_plugin`)
        REFERENCES `_plugins` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _plugins
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_plugins`;

CREATE TABLE `_plugins`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_name` TEXT,
    `_api` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _rights
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_rights`;

CREATE TABLE `_rights`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_group` TEXT,
    `__config__` TEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _templatenames
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_templatenames`;

CREATE TABLE `_templatenames`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_name` TEXT NOT NULL,
    `_helptext` TEXT,
    `_helpimage` TEXT,
    `_category` TEXT,
    `_public` TEXT,
    `__config__` TEXT,
    `__split__` TEXT,
    `__sort__` INTEGER(32),
    `__parentnode__` INTEGER(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _templates
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_templates`;

CREATE TABLE `_templates`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `_fortemplate` INTEGER(32),
    `_fieldname` TEXT,
    `_helpdescription` TEXT,
    `_helpimage` TEXT,
    `_fieldtype` TEXT,
    `__config__` TEXT,
    `__split__` TEXT,
    `__parentnode__` INTEGER(32),
    `__sort__` INTEGER(32),
    PRIMARY KEY (`id`),
    INDEX `_fortemplate_key` (`_fortemplate`),
    CONSTRAINT `t_template_fk`
        FOREIGN KEY (`_fortemplate`)
        REFERENCES `_templatenames` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- session
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session`
(
    `id` BIGINT(40) NOT NULL AUTO_INCREMENT,
    `session` BIGINT(40) DEFAULT 0 NOT NULL,
    `userid` TINYINT DEFAULT 0 NOT NULL,
    `starttime` BIGINT(40) DEFAULT 0 NOT NULL,
    `currenttime` BIGINT(40) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `username` TEXT NOT NULL,
    `password` TEXT NOT NULL,
    `usergroup` TEXT NOT NULL,
    `email` TEXT,
    `roapikey` TEXT,
    `rwapikey` TEXT,
    `__ip__` TEXT,
    `__config__` TEXT,
    PRIMARY KEY (`id`),
    INDEX `id` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- _contributions_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_contributions_version`;

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

-- ---------------------------------------------------------------------
-- _data_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `_data_version`;

CREATE TABLE `_data_version`
(
    `id` INTEGER(4) NOT NULL,
    `_forcontribution` INTEGER(4),
    `_fortemplatefield` INTEGER(32),
    `_content` LONGTEXT,
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

INSERT into users SET username = "root", password = md5("123"), usergroup = "root";