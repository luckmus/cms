INSERT INTO `settings` (`id`, `description`, `value`, `ordinal`, `name`, `type`) VALUES ('19', 'PAW тестовый режим', NULL, '18', 'paw_test_mode', '0');

ALTER TABLE  `em_order` ADD  `pay_result_code` VARCHAR( 100 ) NOT NULL ,
ADD  `pay_desc` VARCHAR( 1000 ) NOT NULL ,
ADD  `pay_amount` DECIMAL NOT NULL