CREATE TABLE `parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parents_id_IDX` (`id`) USING BTREE,
  KEY `parents_child_id_IDX` (`child_id`) USING BTREE,
  KEY `parents_parent_id_IDX` (`parent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;