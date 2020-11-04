CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'incident',
  `info` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logs_id_IDX` (`id`) USING BTREE,
  KEY `logs_type_IDX` (`type`) USING BTREE,
  KEY `logs_person_id_IDX` (`person_id`) USING BTREE,
  KEY `logs_user_id_IDX` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;