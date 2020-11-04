CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groups_id_IDX` (`id`) USING BTREE,
  KEY `groups_slug_IDX` (`slug`) USING BTREE,
  KEY `groups_name_IDX` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `groups` WRITE;
INSERT INTO `groups` VALUES (1,'Nursery','nursery','2020-11-03 12:00:00',NULL,NULL),(2,'Parent','parent','2020-11-03 12:00:00',NULL,NULL);
UNLOCK TABLES;