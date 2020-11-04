CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'outstanding',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_id_IDX` (`id`) USING BTREE,
  KEY `invoices_user_id_IDX` (`user_id`) USING BTREE,
  KEY `invoices_person_id_IDX` (`person_id`) USING BTREE,
  KEY `invoices_amount_IDX` (`amount`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;