CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL DEFAULT 'child',
  `relationship` varchar(255) DEFAULT NULL,
  `room_id` int(11) DEFAULT 0,
  `title` varchar(10) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `phone_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `people_type_IDX` (`type`) USING BTREE,
  KEY `people_first_name_IDX` (`first_name`) USING BTREE,
  KEY `people_last_name_IDX` (`last_name`) USING BTREE,
  KEY `people_address_line_1_IDX` (`address_line_1`) USING BTREE,
  KEY `people_postcode_IDX` (`postcode`) USING BTREE,
  KEY `people_status_IDX` (`status`) USING BTREE,
  KEY `people_phone_no_IDX` (`phone_no`) USING BTREE,
  KEY `people_email_IDX` (`email`) USING BTREE,
  KEY `people_room_id_IDX` (`room_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;