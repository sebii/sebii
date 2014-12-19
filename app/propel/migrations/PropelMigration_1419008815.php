<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1419008815.
 * Generated on 2014-12-19 18:06:55 by deltarm
 */
class PropelMigration_1419008815
{

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
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `music_file`
(
    `file_id` INTEGER,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_file_file` (`file_id`),
    CONSTRAINT `fk_music_file_file`
        FOREIGN KEY (`file_id`)
        REFERENCES `file` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `music_original_tag`
(
    `music_file_id` INTEGER,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_original_tag_music_file` (`music_file_id`),
    CONSTRAINT `fk_music_original_tag_music_file`
        FOREIGN KEY (`music_file_id`)
        REFERENCES `music_file` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
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
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `music_file`;

DROP TABLE IF EXISTS `music_original_tag`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}