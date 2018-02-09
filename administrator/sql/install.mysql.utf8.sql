CREATE TABLE IF NOT EXISTS `#__pm_sic` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`name` VARCHAR(255)  NOT NULL ,
`situation` TEXT NOT NULL ,
`cpf` VARCHAR(255)  NOT NULL ,
`rg` VARCHAR(255)  NOT NULL ,
`telephone` VARCHAR(255)  NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`cep` VARCHAR(255)  NOT NULL ,
`address` VARCHAR(255)  NOT NULL ,
`complement` VARCHAR(255)  NOT NULL ,
`neighborhood` VARCHAR(255)  NOT NULL ,
`city` VARCHAR(255)  NOT NULL ,
`country_state` VARCHAR(255)  NOT NULL ,
`order` VARCHAR(255)  NOT NULL ,
`other_order` VARCHAR(255)  NOT NULL ,
`informations` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

