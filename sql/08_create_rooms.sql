CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_id_IDX` (`id`) USING BTREE,
  KEY `rooms_name_IDX` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `rooms` WRITE;
INSERT INTO `rooms` VALUES (1,'Baby room','2020-11-03 10:00:00',NULL,NULL),(2,'Room 1','2020-11-03 10:00:00',NULL,NULL),(3,'Room 2','2020-11-03 10:00:00',NULL,NULL),(4,'Room 3','2020-11-03 10:00:00',NULL,NULL);
UNLOCK TABLES;