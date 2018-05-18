/*
 Navicat Premium Data Transfer

 Source Server         : php7
 Source Server Type    : MySQL
 Source Server Version : 50637
 Source Host           : localhost:3306
 Source Schema         : staff

 Target Server Type    : MySQL
 Target Server Version : 50637
 File Encoding         : 65001

 Date: 18/05/2018 17:17:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for part
-- ----------------------------
DROP TABLE IF EXISTS `part`;
CREATE TABLE `part`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(96) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NULL DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `modified_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of part
-- ----------------------------
INSERT INTO `part` VALUES (1, 'Lập trình', 0, 0, '2018-05-14 09:10:42', '2018-05-14 09:24:47');
INSERT INTO `part` VALUES (2, 'Marketting', 0, 1, '2018-05-14 09:11:33', '2018-05-14 09:11:33');
INSERT INTO `part` VALUES (3, 'Lễ tân', 0, 1, '2018-05-14 09:17:10', '2018-05-14 09:17:10');
INSERT INTO `part` VALUES (6, 'Test pagi', 0, 1, '2018-05-14 09:24:17', '2018-05-14 09:24:17');
INSERT INTO `part` VALUES (7, 'Test 1 fgfg', 0, 1, '2018-05-14 09:24:25', '2018-05-17 02:11:11');
INSERT INTO `part` VALUES (8, 'Test part 2', 0, 1, '2018-05-15 07:01:16', '2018-05-15 07:01:24');
INSERT INTO `part` VALUES (9, 'Test 000', 0, 1, '2018-05-15 07:48:36', '2018-05-15 07:48:36');
INSERT INTO `part` VALUES (10, 'Test add 1', 0, 1, '2018-05-17 02:09:32', '2018-05-17 02:09:32');

-- ----------------------------
-- Table structure for position
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(96) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sort_permission` tinyint(4) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `sort_order` int(11) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `modified_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of position
-- ----------------------------
INSERT INTO `position` VALUES (1, 'Trưởng phòng', 5, 1, 0, '2018-05-15 01:04:19', '2018-05-15 08:16:25');
INSERT INTO `position` VALUES (3, 'Nhân viên edit', 8, 1, 0, '2018-05-15 08:12:46', '2018-05-17 02:42:42');
INSERT INTO `position` VALUES (4, 'Phó phòng', 6, 1, 0, '2018-05-15 08:42:31', '2018-05-15 08:42:31');
INSERT INTO `position` VALUES (5, 'Công nhân', 11, 1, 0, '2018-05-16 02:06:40', '2018-05-16 02:06:40');
INSERT INTO `position` VALUES (6, 'test chuc vu exit', 14, 1, 0, '2018-05-17 02:42:32', '2018-05-17 02:42:32');
INSERT INTO `position` VALUES (7, 'fdfdgfgf', 15, 1, 0, '2018-05-17 02:45:24', '2018-05-17 03:06:57');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `gender` tinyint(4) NOT NULL,
  `email` varchar(96) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `username` varchar(96) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(96) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `changed_password` tinyint(2) NOT NULL,
  `is_root` tinyint(2) NOT NULL,
  `birthday` date NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `modified_at` datetime(0) NULL DEFAULT NULL,
  `login_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES (1, 'Ly Nguyen Van', '0986087298', 'Hải Hòa, Hải Hậu, Nam Định', 0, 'admin@gmail.com', NULL, 'admin', '$2y$10$Q2N5Ej6hJRoRjh9Fp7yv2ec23ItV/U9u9Qq1ZF4EzGo2419Dy54U.', NULL, 1, 1, 1, '1991-10-01', NULL, '2018-05-18 17:11:54', '2018-05-18 17:16:46');
INSERT INTO `staff` VALUES (21, 'Nguyễn Văn A', '0147258369', 'Hà Nội', 0, 'lynv110@gmail.com', NULL, 'lynv110', '$2y$10$ogfMF1obB7r66k6pJ3Pi9uy8ImSwpUgbht2RroWTAmOe1DfaF1CUa', NULL, 1, 1, 0, '1991-10-01', '2018-05-16 10:03:19', '2018-05-18 01:31:39', '2018-05-18 17:13:33');
INSERT INTO `staff` VALUES (22, 'Dương Văn An', '0147147147', 'Hải Hòa, hải Hậu, Nam Định', 0, 'lynguyenvan110@gmail.com', 'pexels-photo.jpg', 'duongan', '$2y$10$M.GQdvirmhgTB5aGO58n9.9xuE42i3.VE1bdtN2IIM1LGr5.i5q.e', NULL, 1, 0, 0, '1991-10-01', '2018-05-17 03:18:48', '2018-05-17 04:20:24', NULL);
INSERT INTO `staff` VALUES (24, 'test name staff', '0258258258', NULL, 0, 'lynv@gmail.com', NULL, 'lynv11111', '$2y$10$Vllc6kRuoqyrgWKNqCxg0uNxtgE3fEKoSPKvxrV.PZ4ck6gK.cajG', NULL, 1, 0, 0, NULL, '2018-05-17 04:05:25', '2018-05-18 02:05:29', NULL);
INSERT INTO `staff` VALUES (25, 'Phạm Thị B', '0258258258', NULL, 1, 'dva@gmail.com', NULL, 'adminfdsf', '$2y$10$doenvKa4ppoK7lWfb.3wwOfFgoVuQJgTzfGZ0Mbw.CydImwXoNAwO', NULL, 1, 0, 0, NULL, '2018-05-18 02:55:44', '2018-05-18 09:00:02', NULL);
INSERT INTO `staff` VALUES (26, 'Dương Văn Nam', '5858585', NULL, 0, 'lygfgnv@oft.comadas', NULL, 'adminsdsdsd', '$2y$10$RMW.GcX1Sgxr939nuysa8uHf38Iqor5cpOy.HMRxF1VeJHtww9oOK', NULL, 1, 0, 0, NULL, '2018-05-18 02:56:29', '2018-05-18 03:11:40', NULL);
INSERT INTO `staff` VALUES (27, 'fdsf dfs fs', '1010101010', NULL, 0, 'gfg10@gmail.com', NULL, 'gdfgdfg', '$2y$10$mpl4vlUch5rOZ/ie7uju1OtEvZ5FZh4tQ7E.g3pCOpNfBPsyuBdC.', NULL, 1, 0, 0, NULL, '2018-05-18 02:56:48', '2018-05-18 03:14:28', NULL);
INSERT INTO `staff` VALUES (28, 'ggdfgd dfgdf', '414141414', NULL, 0, 'gfggf0@gmail.com', NULL, 'gdfggdf', '$2y$10$eosc7r56aC8EIu.zvJAn3ulxG4m/4YHXLCVc5oWIqzW9f23zDEsre', NULL, 1, 0, 0, '1992-12-28', '2018-05-18 02:57:07', '2018-05-18 17:13:19', NULL);

-- ----------------------------
-- Table structure for staff_part
-- ----------------------------
DROP TABLE IF EXISTS `staff_part`;
CREATE TABLE `staff_part`  (
  `staff_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  PRIMARY KEY (`staff_id`, `part_id`) USING BTREE,
  INDEX `part_id`(`part_id`) USING BTREE,
  INDEX `staff_id`(`staff_id`) USING BTREE,
  CONSTRAINT `staff_part_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `staff_part_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `part` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of staff_part
-- ----------------------------
INSERT INTO `staff_part` VALUES (21, 1);
INSERT INTO `staff_part` VALUES (21, 2);
INSERT INTO `staff_part` VALUES (27, 2);
INSERT INTO `staff_part` VALUES (21, 3);
INSERT INTO `staff_part` VALUES (22, 3);
INSERT INTO `staff_part` VALUES (26, 3);
INSERT INTO `staff_part` VALUES (24, 6);
INSERT INTO `staff_part` VALUES (22, 10);

-- ----------------------------
-- Table structure for staff_position
-- ----------------------------
DROP TABLE IF EXISTS `staff_position`;
CREATE TABLE `staff_position`  (
  `staff_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  PRIMARY KEY (`staff_id`, `position_id`) USING BTREE,
  INDEX `position_id`(`position_id`) USING BTREE,
  CONSTRAINT `staff_position_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `staff_position_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of staff_position
-- ----------------------------
INSERT INTO `staff_position` VALUES (21, 3);
INSERT INTO `staff_position` VALUES (24, 3);
INSERT INTO `staff_position` VALUES (21, 4);
INSERT INTO `staff_position` VALUES (22, 4);
INSERT INTO `staff_position` VALUES (21, 5);
INSERT INTO `staff_position` VALUES (27, 5);

SET FOREIGN_KEY_CHECKS = 1;
