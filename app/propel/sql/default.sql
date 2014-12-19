
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- music_file
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_file`;

CREATE TABLE `music_file`
(
    `file_id` INTEGER,
    `scan_original_tag` TINYINT(1) DEFAULT 1,
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

-- ---------------------------------------------------------------------
-- music_original_tag
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_original_tag`;

CREATE TABLE `music_original_tag`
(
    `music_file_id` INTEGER,
    `type` VARCHAR(255),
    `name` VARCHAR(255),
    `value` VARCHAR(255),
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

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `username` VARCHAR(100) NOT NULL,
    `username_canonical` VARCHAR(255),
    `salt` VARCHAR(15),
    `password` VARCHAR(100),
    `email` VARCHAR(255),
    `roles` TEXT,
    `origin` TINYINT DEFAULT 0,
    `activation_key` VARCHAR(30),
    `is_active` TINYINT(1) DEFAULT 0,
    `is_delete` TINYINT(1) DEFAULT 0,
    `is_erase` TINYINT(1) DEFAULT 0,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `unique_username_canonical` (`username_canonical`),
    UNIQUE INDEX `unique_email` (`email`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- file
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `file`;

CREATE TABLE `file`
(
    `type` TINYINT DEFAULT 0,
    `original_path` VARCHAR(255),
    `path` VARCHAR(255),
    `original_ext` TINYINT DEFAULT 0,
    `guess_ext` TINYINT DEFAULT 0,
    `ext` TINYINT DEFAULT 0,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
