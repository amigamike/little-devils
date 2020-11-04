CREATE TABLE `revenue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `period` date NOT NULL,
  `room_fee` float(10,2) NOT NULL,
  `funding` float(10,2) NOT NULL,
  `total` float(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revenue_id_IDX` (`id`) USING BTREE,
  KEY `revenue_room_id_IDX` (`room_id`) USING BTREE,
  KEY `revenue_period_IDX` (`period`) USING BTREE,
  KEY `revenue_room_fee_IDX` (`room_fee`) USING BTREE,
  KEY `revenue_funding_IDX` (`funding`) USING BTREE,
  KEY `revenue_total_IDX` (`total`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;