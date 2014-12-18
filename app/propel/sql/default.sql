
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

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
