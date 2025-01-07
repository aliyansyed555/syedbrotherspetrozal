ALTER TABLE `daily_reports` ADD COLUMN `tuck_shop_rent` FLOAT(6,2) AFTER `date`, ADD COLUMN `tuck_shop_earning` FLOAT(6,2) AFTER `tuck_shop_rent`, ADD COLUMN `service_station_earning` FLOAT(6,2) AFTER `tuck_shop_earning`, ADD COLUMN `service_station_rent` FLOAT(6,2) AFTER `service_station_earning`, ADD COLUMN `tyre_shop_earning` FLOAT(6,2) AFTER `service_station_rent`, ADD COLUMN `tyre_shop_rent` FLOAT(6,2) AFTER `tyre_shop_earning`, ADD COLUMN `lube_shop_earning` FLOAT(6,2) AFTER `tyre_shop_rent`, ADD COLUMN `lube_shop_rent` FLOAT(6,2) AFTER `lube_shop_earning`;

ALTER TABLE `customer_credits` ADD `is_special` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'no need to add into cash in hand' AFTER `date`;

ALTER TABLE `fuel_prices` ADD `loss_gain_value` FLOAT(10,2) NOT NULL DEFAULT '0' AFTER `date`;
