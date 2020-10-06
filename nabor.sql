/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 100408
 Source Host           : localhost:3306
 Source Schema         : nabor

 Target Server Type    : MySQL
 Target Server Version : 100408
 File Encoding         : 65001

 Date: 06/10/2020 18:53:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for service_category
-- ----------------------------
DROP TABLE IF EXISTS `service_category`;
CREATE TABLE `service_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of service_category
-- ----------------------------
INSERT INTO `service_category` VALUES (1, 'Plumber');
INSERT INTO `service_category` VALUES (2, 'Dog Walker');
INSERT INTO `service_category` VALUES (3, 'Seller');
INSERT INTO `service_category` VALUES (4, 'Personal Friend');
INSERT INTO `service_category` VALUES (6, 'Marcketor');

-- ----------------------------
-- Table structure for services
-- ----------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(10) NULL DEFAULT NULL,
  `provider` int(10) NULL DEFAULT NULL,
  `service` int(10) NULL DEFAULT NULL,
  `contents` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  `completed_date` datetime(0) NULL DEFAULT NULL,
  `decliened_date` datetime(0) NULL DEFAULT NULL,
  `rejected_date` datetime(0) NULL DEFAULT NULL,
  `status` int(10) NULL DEFAULT 0,
  `reject_reason` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_history` int(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of services
-- ----------------------------
INSERT INTO `services` VALUES (4, 21, 4, 2, 'I need a Dog Walker', '2020-10-05 13:49:00', '2020-10-06 04:10:55', NULL, NULL, 6, NULL, 1);
INSERT INTO `services` VALUES (5, 21, 20, 1, 'I need plumber.', '2020-10-05 13:51:14', NULL, NULL, NULL, 2, NULL, 0);
INSERT INTO `services` VALUES (6, 6, 18, 1, 'I need Plumber.', '2020-10-05 14:01:21', NULL, NULL, NULL, 0, NULL, 0);
INSERT INTO `services` VALUES (8, 21, 16, 3, 'I need Seller', '2020-10-06 03:05:55', '2020-10-06 08:27:01', NULL, NULL, 6, '', 1);
INSERT INTO `services` VALUES (9, 21, 4, 2, 'I need a Dog Walker.', '2020-10-06 08:17:49', NULL, NULL, '2020-10-06 13:42:12', 3, 'Sorry. I am so busy now. I am wrapping request.', 0);
INSERT INTO `services` VALUES (10, 21, 4, 2, 'I need a Dog Walker.', '2020-10-06 08:22:45', NULL, '2020-10-06 14:14:55', NULL, 5, NULL, 1);
INSERT INTO `services` VALUES (11, 21, 16, 3, 'I need a Seller.', '2020-10-06 15:19:01', NULL, NULL, NULL, 1, NULL, 0);
INSERT INTO `services` VALUES (12, 21, 8, 4, 'I need a Personal friend.', '2020-10-06 15:19:56', NULL, NULL, NULL, 4, NULL, 0);

-- ----------------------------
-- Table structure for user_service
-- ----------------------------
DROP TABLE IF EXISTS `user_service`;
CREATE TABLE `user_service`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `service_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_service
-- ----------------------------
INSERT INTO `user_service` VALUES (33, 17, 1);
INSERT INTO `user_service` VALUES (34, 17, 2);
INSERT INTO `user_service` VALUES (35, 17, 3);
INSERT INTO `user_service` VALUES (36, 18, 1);
INSERT INTO `user_service` VALUES (37, 18, 2);
INSERT INTO `user_service` VALUES (38, 19, 1);
INSERT INTO `user_service` VALUES (39, 19, 2);
INSERT INTO `user_service` VALUES (47, 9, 4);
INSERT INTO `user_service` VALUES (48, 9, 6);
INSERT INTO `user_service` VALUES (49, 4, 1);
INSERT INTO `user_service` VALUES (50, 4, 2);
INSERT INTO `user_service` VALUES (51, 8, 4);
INSERT INTO `user_service` VALUES (52, 16, 3);
INSERT INTO `user_service` VALUES (53, 16, 4);
INSERT INTO `user_service` VALUES (54, 20, 1);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  `birthday` date NULL DEFAULT NULL,
  `gender` int(1) NULL DEFAULT 0,
  `user_type` int(10) NULL DEFAULT 0,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `about_me` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rate` double NULL DEFAULT 0,
  `longitude` double NULL DEFAULT NULL,
  `latitude` double NULL DEFAULT NULL,
  `is_deleted` int(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, NULL, NULL, 'administrator@gmail.com', NULL, '/assets/img/avatar.png', NULL, '2020-09-17 06:30:06', NULL, NULL, 2, 'admin', 'admin', NULL, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (2, 'Andrew123', 'Lave123', 'customer@gmail.com', '12312312343', '/uploads/card-profile1-square.jpg', 'Ulitsa Boyaki, 43, Baykit, Krasnoyarsk Krai, Russia, 648360', '2020-09-26 06:30:02', '1980-01-01', 1, 0, 'customer', 'andrew', 'I have served in variety of clinical branches and have extensive clinicl experience. I worked in the Dept. of surgery.', 4.5, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (4, 'Miro', 'Slave', 'provider@gmail.com', '12312312343', '/uploads/card-profile1-square.jpg', 'Ulitsa Boyaki, 43, Baykit, Krasnoyarsk Krai, Russia, 648360', '2020-09-26 06:30:02', '1980-01-01', 0, 1, 'provider', 'provider', 'I have served in variety of clinical branches and have extensive clinicl experience. I worked in the Dept. of surgery.', 4.45, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (6, 'customer1', 'customer1', 'customer0@gmail.com', '12312312343', '/uploads/avatar.jpg', 'Ulitsa Boyaki, 43, Baykit, Krasnoyarsk Krai, Russia, 648360', '2020-09-26 06:30:02', '1980-01-01', 0, 0, 'customer', 'customer1', 'I have served in variety of clinical branches and have extensive clinicl experience. I worked in the Dept. of surgery.', 5, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (7, 'customer2', 'customer2', 'customer1@gmail.com', '12312312343', '/uploads/card-profile1-square.jpg', 'Ulitsa Boyaki, 43, Baykit, Krasnoyarsk Krai, Russia, 648360', '2020-09-26 06:30:02', '1980-01-01', 0, 0, 'customer', 'customer2', 'I have served in variety of clinical branches and have extensive clinicl experience. I worked in the Dept. of surgery.', 4.8, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (8, 'Provider2', 'Provider2', 'provider2@gmail.com', '12312312343', '/uploads/card-profile2-square.jpg', 'Ulitsa Boyaki, 43, Baykit, Krasnoyarsk Krai, Russia, 648360', '2020-09-26 06:30:02', '1980-01-01', 0, 1, 'provider', 'provider2', 'I have served in variety of clinical branches and have extensive clinicl experience. I worked in the Dept. of surgery.', 3.8, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (9, 'Provider3', 'Provider3', 'provider3@gmail.com', '12312312343', '/uploads/avatar.png', 'Ulitsa Boyaki, 43, Baykit, Krasnoyarsk Krai, Russia, 648360', '2020-09-26 06:30:02', '1980-01-01', 1, 1, 'provider', 'provider3', 'I have served in variety of clinical branches and have extensive clinicl experience. I worked in the Dept. of surgery.', 4.6, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (16, 'xc', 'xc', 'provider4@gmail.com', 'sdfsd', '/uploads/avatar.jpg', 'sdfs', '2020-10-01 16:44:45', NULL, 1, 1, 'provider', 'xcz', 'I am happy.', 4, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (17, 'sdf', 'df', 'zxc@df.dfd', 'dfs', NULL, 'sdfs', '2020-10-01 16:54:06', NULL, NULL, 1, 'sdfssdf', 'sdf', NULL, 0, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (18, 'provider', 'provider', 'provider123@gmail.com', '12312312343', NULL, 'United state', '2020-10-02 04:23:11', NULL, NULL, 1, 'provider', 'provider1', NULL, 0, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (19, 'provider', 'provider', 'provider12@gmail.com', '12312312343', NULL, 'United state', '2020-10-02 04:24:33', NULL, NULL, 1, 'provider', 'provider4', NULL, 0, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (20, 'provider', 'provider', 'provider124@gmail.com', '12312312343', '/uploads/marc.jpg', 'United state', '2020-10-02 04:31:05', NULL, 0, 1, 'provider', 'provider5', 'asdf', 0, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (21, 'customer', 'customer', 'customer123@gmail.com', '12312312312', '/uploads/profile2.jpg', 'asdsdfsdf', '2020-10-05 04:56:46', NULL, 1, 0, 'customer', 'customer123', 'I am happy to work for my client.', 5, -122.084, 37.4219983, 0);
INSERT INTO `users` VALUES (22, 'customer', 'customer', 'customer1212@gmail.com', '123123123123', '/uploads/profile.jpg', 'asdfasds', '2020-10-06 08:30:05', NULL, 0, 0, 'customer', 'customer', 'sdfsdfsdfds', 0, -122.084, 37.4219983, 0);

SET FOREIGN_KEY_CHECKS = 1;
