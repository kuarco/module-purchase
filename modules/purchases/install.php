<?php

$CI = &get_instance();

// Create necessary database tables
$CI->db->query("
CREATE TABLE IF NOT EXISTS `tblpurchase_orders` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `po_number` varchar(50) NOT NULL,
    `vendor_id` int(11) NOT NULL,
    `date` date NOT NULL,
    `status` varchar(20) NOT NULL DEFAULT 'draft',
    `subtotal` decimal(15,2) NOT NULL,
    `tax` decimal(15,2) NOT NULL,
    `total` decimal(15,2) NOT NULL,
    `notes` text,
    `created_by` int(11) NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$CI->db->query("
CREATE TABLE IF NOT EXISTS `tblvendors` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `company` varchar(200) NOT NULL,
    `vat` varchar(50),
    `phone` varchar(50),
    `email` varchar(100),
    `address` text,
    `city` varchar(100),
    `state` varchar(100),
    `zip` varchar(20),
    `country` varchar(100),
    `status` tinyint(1) DEFAULT '1',
    `created_at` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$CI->db->query("
CREATE TABLE IF NOT EXISTS `tblpurchase_items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `purchase_order_id` int(11) NOT NULL,
    `item_id` int(11) NOT NULL,
    `description` text,
    `quantity` decimal(15,2) NOT NULL,
    `unit_price` decimal(15,2) NOT NULL,
    `tax` decimal(15,2) DEFAULT '0.00',
    `total` decimal(15,2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

// Add permissions
$CI->db->query("
INSERT INTO `tblpermissions` (`name`, `shortname`) VALUES
('Purchases View', 'purchases_view'),
('Purchases Create', 'purchases_create'),
('Purchases Edit', 'purchases_edit'),
('Purchases Delete', 'purchases_delete'),
('Vendors View', 'vendors_view'),
('Vendors Create', 'vendors_create'),
('Vendors Edit', 'vendors_edit'),
('Vendors Delete', 'vendors_delete')
");