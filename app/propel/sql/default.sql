
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- bank_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_group`;

CREATE TABLE `bank_group`
(
    `name` VARCHAR(255),
    `slug` VARCHAR(255),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `bank_group_slug` (`slug`(255))
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- bank_agency
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_agency`;

CREATE TABLE `bank_agency`
(
    `name` VARCHAR(255),
    `bank_group_id` INTEGER,
    `slug` VARCHAR(255),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `bank_agency_slug` (`slug`(255)),
    INDEX `FI_bank_agency_bank_group` (`bank_group_id`),
    CONSTRAINT `fk_bank_agency_bank_group`
        FOREIGN KEY (`bank_group_id`)
        REFERENCES `bank_group` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- bank_account
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_account`;

CREATE TABLE `bank_account`
(
    `name` VARCHAR(255),
    `user_id` INTEGER,
    `type` TINYINT DEFAULT 0,
    `bank_agency_id` INTEGER,
    `slug` VARCHAR(255),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `bank_account_slug` (`slug`(255)),
    INDEX `FI_bank_account_bank_agency` (`bank_agency_id`),
    CONSTRAINT `fk_bank_account_bank_agency`
        FOREIGN KEY (`bank_agency_id`)
        REFERENCES `bank_agency` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- bank_payee
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_payee`;

CREATE TABLE `bank_payee`
(
    `name` VARCHAR(255),
    `user_id` INTEGER,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- bank_category_regroupment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_category_regroupment`;

CREATE TABLE `bank_category_regroupment`
(
    `name` VARCHAR(255),
    `user_id` INTEGER,
    `type` TINYINT DEFAULT 0,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- bank_category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_category`;

CREATE TABLE `bank_category`
(
    `name` VARCHAR(255),
    `user_id` INTEGER,
    `bank_category_regroupment_id` INTEGER,
    `type` TINYINT DEFAULT 0,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_bank_category_bank_category_regroupment` (`bank_category_regroupment_id`),
    CONSTRAINT `fk_bank_category_bank_category_regroupment`
        FOREIGN KEY (`bank_category_regroupment_id`)
        REFERENCES `bank_category_regroupment` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- bank_frequent_operation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_frequent_operation`;

CREATE TABLE `bank_frequent_operation`
(
    `bank_account_id` INTEGER,
    `name` VARCHAR(255),
    `date` DATETIME,
    `bank_payee_id` INTEGER,
    `bank_category_id` INTEGER,
    `payment` FLOAT,
    `deposit` FLOAT,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_bank_frequent_operation_bank_account` (`bank_account_id`),
    INDEX `FI_bank_frequent_operation_bank_payee` (`bank_payee_id`),
    INDEX `FI_bank_frequent_operation_bank_category` (`bank_category_id`),
    CONSTRAINT `fk_bank_frequent_operation_bank_account`
        FOREIGN KEY (`bank_account_id`)
        REFERENCES `bank_account` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_bank_frequent_operation_bank_payee`
        FOREIGN KEY (`bank_payee_id`)
        REFERENCES `bank_payee` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_bank_frequent_operation_bank_category`
        FOREIGN KEY (`bank_category_id`)
        REFERENCES `bank_category` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- bank_operation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_operation`;

CREATE TABLE `bank_operation`
(
    `bank_account_id` INTEGER,
    `name` VARCHAR(255),
    `date` DATETIME,
    `bank_payee_id` INTEGER,
    `bank_category_id` INTEGER,
    `payment` FLOAT,
    `deposit` FLOAT,
    `bank_frequent_operation_id` INTEGER,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_bank_operation_bank_account` (`bank_account_id`),
    INDEX `FI_bank_operation_bank_payee` (`bank_payee_id`),
    INDEX `FI_bank_operation_bank_category` (`bank_category_id`),
    INDEX `FI_bank_operation_bank_frequent_operation` (`bank_frequent_operation_id`),
    CONSTRAINT `fk_bank_operation_bank_account`
        FOREIGN KEY (`bank_account_id`)
        REFERENCES `bank_account` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_bank_operation_bank_payee`
        FOREIGN KEY (`bank_payee_id`)
        REFERENCES `bank_payee` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_bank_operation_bank_category`
        FOREIGN KEY (`bank_category_id`)
        REFERENCES `bank_category` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_bank_operation_bank_frequent_operation`
        FOREIGN KEY (`bank_frequent_operation_id`)
        REFERENCES `bank_frequent_operation` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_artist
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_artist`;

CREATE TABLE `music_artist`
(
    `name` VARCHAR(255),
    `alias` INTEGER,
    `image` TINYINT(1) DEFAULT 0,
    `scan_deezer_search` TINYINT(1) DEFAULT 1,
    `scan_deezer_albums` TINYINT(1) DEFAULT 1,
    `scan_spotify_search` TINYINT(1) DEFAULT 1,
    `slug` VARCHAR(255),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `music_artist_slug` (`slug`(255))
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_album
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_album`;

CREATE TABLE `music_album`
(
    `name` VARCHAR(255),
    `artist_id` INTEGER,
    `alias` INTEGER,
    `image` TINYINT(1) DEFAULT 0,
    `scan_deezer_album` TINYINT(1) DEFAULT 1,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_album_music_artist` (`artist_id`),
    CONSTRAINT `fk_music_album_music_artist`
        FOREIGN KEY (`artist_id`)
        REFERENCES `music_artist` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_track
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_track`;

CREATE TABLE `music_track`
(
    `name` VARCHAR(255),
    `track` INTEGER,
    `disc` INTEGER,
    `artist_id` INTEGER,
    `album_id` INTEGER,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_track_music_artist` (`artist_id`),
    INDEX `FI_music_track_music_album` (`album_id`),
    CONSTRAINT `fk_music_track_music_artist`
        FOREIGN KEY (`artist_id`)
        REFERENCES `music_artist` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_music_track_music_album`
        FOREIGN KEY (`album_id`)
        REFERENCES `music_album` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_file
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_file`;

CREATE TABLE `music_file`
(
    `file_id` INTEGER,
    `track_id` INTEGER,
    `scan_original_tag` TINYINT(1) DEFAULT 1,
    `associate_tags` TINYINT(1) DEFAULT 1,
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_file_file` (`file_id`),
    INDEX `FI_music_file_music_track` (`track_id`),
    CONSTRAINT `fk_music_file_file`
        FOREIGN KEY (`file_id`)
        REFERENCES `file` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_music_file_music_track`
        FOREIGN KEY (`track_id`)
        REFERENCES `music_track` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

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
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_deezer_artist
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_deezer_artist`;

CREATE TABLE `music_deezer_artist`
(
    `deezer_id` INTEGER,
    `artist_id` INTEGER,
    `name` VARCHAR(255),
    `image` TINYINT(1) DEFAULT 0,
    `nb_albums` INTEGER,
    `nb_fan` INTEGER,
    `radio` TINYINT(1),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_deezer_artist_music_artist` (`artist_id`),
    INDEX `I_referenced_fk_music_deezer_album_music_deezer_artist_1` (`deezer_id`),
    CONSTRAINT `fk_music_deezer_artist_music_artist`
        FOREIGN KEY (`artist_id`)
        REFERENCES `music_artist` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_deezer_genre
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_deezer_genre`;

CREATE TABLE `music_deezer_genre`
(
    `deezer_id` INTEGER,
    `name` VARCHAR(255),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_deezer_album
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_deezer_album`;

CREATE TABLE `music_deezer_album`
(
    `deezer_id` INTEGER,
    `album_id` INTEGER,
    `name` VARCHAR(255),
    `image` TINYINT(1) DEFAULT 0,
    `artist_deezer_id` INTEGER,
    `main_genre_deezer_id` INTEGER,
    `genre_deezer_ids` TEXT,
    `record_type` TINYINT,
    `upc` VARCHAR(255),
    `label` VARCHAR(255),
    `nb_tracks` INTEGER,
    `duration` INTEGER,
    `nb_fans` INTEGER,
    `rating` INTEGER,
    `release_date` DATETIME,
    `available` TINYINT(1),
    `explicit_lyrics` TINYINT(1),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_deezer_album_music_album` (`album_id`),
    INDEX `FI_music_deezer_album_music_deezer_artist` (`artist_deezer_id`),
    INDEX `I_referenced_fk_music_deezer_track_music_deezer_album_1` (`deezer_id`),
    CONSTRAINT `fk_music_deezer_album_music_album`
        FOREIGN KEY (`album_id`)
        REFERENCES `music_album` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_music_deezer_album_music_deezer_artist`
        FOREIGN KEY (`artist_deezer_id`)
        REFERENCES `music_deezer_artist` (`deezer_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_deezer_track
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_deezer_track`;

CREATE TABLE `music_deezer_track`
(
    `deezer_id` INTEGER,
    `album_deezer_id` INTEGER,
    `artist_deezer_id` INTEGER,
    `name` VARCHAR(255),
    `readable` TINYINT(1),
    `duration` INTEGER,
    `rank` TINYINT(1),
    `explicit_lyrics` TINYINT(1),
    `preview_link` VARCHAR(255),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_deezer_track_music_deezer_album` (`album_deezer_id`),
    INDEX `FI_music_deezer_track_music_deezer_artist` (`artist_deezer_id`),
    CONSTRAINT `fk_music_deezer_track_music_deezer_album`
        FOREIGN KEY (`album_deezer_id`)
        REFERENCES `music_deezer_album` (`deezer_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fk_music_deezer_track_music_deezer_artist`
        FOREIGN KEY (`artist_deezer_id`)
        REFERENCES `music_deezer_artist` (`deezer_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- music_spotify_artist
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `music_spotify_artist`;

CREATE TABLE `music_spotify_artist`
(
    `spotify_id` VARCHAR(255),
    `artist_id` INTEGER,
    `name` VARCHAR(255),
    `image` TINYINT(1) DEFAULT 0,
    `image_id` VARCHAR(255),
    `popularity` INTEGER,
    `uri` VARCHAR(255),
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_music_spotify_artist_music_artist` (`artist_id`),
    CONSTRAINT `fk_music_spotify_artist_music_artist`
        FOREIGN KEY (`artist_id`)
        REFERENCES `music_artist` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8';

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
