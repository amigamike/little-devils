CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_id_IDX` (`id`) USING BTREE,
  KEY `contacts_child_id_IDX` (`child_id`) USING BTREE,
  KEY `contacts_person_id_IDX` (`person_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;