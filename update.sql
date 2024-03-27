ALTER TABLE `inventory_transfers` ADD `others` TINYINT(2) NOT NULL DEFAULT '0' COMMENT '0=recipentexsists,1=othersexsists' AFTER `status`;
ALTER TABLE `availabilities` ADD `is_limited` TINYINT(2) NOT NULL COMMENT 'o=not limited,1=limited' AFTER `company_id`;
ALTER TABLE `availabilities` CHANGE `is_limited` `is_limited` TINYINT NOT NULL DEFAULT '0' COMMENT 'o=not limited,1=limited';

UPDATE `taxes` SET `status` = '0' WHERE `taxes`.`id` = 4;
UPDATE `taxes` SET `status` = '0' WHERE `taxes`.`id` = 1;

ALTER TABLE `availabilities` CHANGE `group_id` `group_id` VARCHAR(255) BINARY NULL DEFAULT NULL;
ALTER TABLE `availabilities` CHANGE `company_id` `company_id` VARCHAR(255) BINARY NULL DEFAULT NULL;


ALTER TABLE `inventory_transfer_products` ADD `send` VARCHAR(255) NULL DEFAULT NULL AFTER `batch`;

UPDATE `taxes` SET `name` = 'GST 5% QST 9.77%' WHERE `taxes`.`id` = 4;

UPDATE `taxes` SET `tax` = '14.77' WHERE `taxes`.`id` = 4;

UPDATE `taxes` SET `status` = '1' WHERE `taxes`.`id` = 4;


ALTER TABLE `users` ADD `role_id` INT(11) NULL DEFAULT NULL AFTER `permission_revised`;

ALTER TABLE `groups` ADD `online_payment` VARCHAR(255) NULL AFTER `order_approval`;

ALTER TABLE `groups` ADD `offline_payment` VARCHAR(255) NULL DEFAULT NULL AFTER `online_payment`;
ALTER TABLE `groups` ADD `is_accepted_payment` TINYINT(2) NOT NULL DEFAULT '1' COMMENT 'o=not accepted,1=accepted' AFTER `offline_payment`;

ALTER TABLE `inventory_transfer_products` CHANGE `send` `send` INT(11) NULL;

ALTER TABLE `users` ADD `is_enable` TINYINT(2) NOT NULL DEFAULT '1' COMMENT 'o=not enable,1=enable' AFTER `role_id`;

ALTER TABLE `product_formats` ADD `deposit_amt` DECIMAL(8,2) NULL DEFAULT NULL AFTER `product_format_image_id`;

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '40'), ('2', '40');


ALTER TABLE `product_format_deposit` ADD `created_at` TIMESTAMP NOT NULL AFTER `status`, ADD `updated_at` TIMESTAMP NOT NULL AFTER `created_at`;

ALTER TABLE `roles` ADD `role_name` VARCHAR(255) NULL DEFAULT NULL AFTER `guard_name`;


ALTER TABLE `users` ADD `deleted_at` TIMESTAMP NULL AFTER `is_enable`;
ALTER TABLE `users` ADD `is_deleted` TINYINT(2) NOT NULL DEFAULT '0' COMMENT '1:deleted,0:not delted' AFTER `deleted_at`;
ALTER TABLE `dev-dwc-db`.`order_items` CHANGE `tax` `tax` DECIMAL(8,2) NULL DEFAULT NULL;


ALTER TABLE `shipments` CHANGE `status` `status` ENUM('0','1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '3' COMMENT '4=draft, 3= preparing, 2= shipping, 1= done, 0=returns management';