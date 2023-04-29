/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : mi1_sys_ets

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 31/01/2023 00:38:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for calibration
-- ----------------------------
DROP TABLE IF EXISTS `calibration`;
CREATE TABLE `calibration`  (
  `calibration_id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int NOT NULL,
  `CalibrationDate` date NOT NULL,
  `Calibrator` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CalibrationResult` enum('Pass','Fail') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`calibration_id`) USING BTREE,
  INDEX `equipment_id`(`equipment_id` ASC) USING BTREE,
  CONSTRAINT `calibration_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of calibration
-- ----------------------------

-- ----------------------------
-- Table structure for checkout
-- ----------------------------
DROP TABLE IF EXISTS `checkout`;
CREATE TABLE `checkout`  (
  `checkout_id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int NULL DEFAULT NULL,
  `employee_id` int NULL DEFAULT NULL,
  `checkout_date` date NULL DEFAULT NULL,
  `due_date` date NULL DEFAULT NULL,
  `return_date` date NULL DEFAULT NULL,
  `condition_of_return` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `checkout_documentation` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`checkout_id`) USING BTREE,
  INDEX `equipment_id`(`equipment_id` ASC) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of checkout
-- ----------------------------

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department`  (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`department_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of department
-- ----------------------------

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee`  (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `suffix_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `job_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `department_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`employee_id`) USING BTREE,
  INDEX `department_id`(`department_id` ASC) USING BTREE,
  INDEX `role_id`(`role_id` ASC) USING BTREE,
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee
-- ----------------------------

-- ----------------------------
-- Table structure for equipment
-- ----------------------------
DROP TABLE IF EXISTS `equipment`;
CREATE TABLE `equipment`  (
  `equipment_id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `model_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `manufacturer_id` int NOT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `serial_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `asset_tag` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `warranty_expiration` date NOT NULL,
  `equipment_category_id` int NOT NULL,
  `equipment_type_id` int NOT NULL,
  `equipment_classification_id` int NOT NULL,
  `purpose_id` int NOT NULL,
  PRIMARY KEY (`equipment_id`) USING BTREE,
  INDEX `manufacturer_id`(`manufacturer_id` ASC) USING BTREE,
  INDEX `equipment_category_id`(`equipment_category_id` ASC) USING BTREE,
  INDEX `equipment_type_id`(`equipment_type_id` ASC) USING BTREE,
  INDEX `equipment_classification_id`(`equipment_classification_id` ASC) USING BTREE,
  INDEX `purpose_id`(`purpose_id` ASC) USING BTREE,
  CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`manufacturer_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `equipment_ibfk_2` FOREIGN KEY (`equipment_category_id`) REFERENCES `equipmentcategory` (`equipment_category_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `equipment_ibfk_3` FOREIGN KEY (`equipment_type_id`) REFERENCES `equipmenttype` (`equipment_type_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `equipment_ibfk_4` FOREIGN KEY (`equipment_classification_id`) REFERENCES `equipmentclassification` (`equipment_classification_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `equipment_ibfk_5` FOREIGN KEY (`purpose_id`) REFERENCES `purpose` (`purpose_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of equipment
-- ----------------------------

-- ----------------------------
-- Table structure for equipmentcategory
-- ----------------------------
DROP TABLE IF EXISTS `equipmentcategory`;
CREATE TABLE `equipmentcategory`  (
  `equipment_category_ID` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`equipment_category_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of equipmentcategory
-- ----------------------------

-- ----------------------------
-- Table structure for equipmentclassification
-- ----------------------------
DROP TABLE IF EXISTS `equipmentclassification`;
CREATE TABLE `equipmentclassification`  (
  `equipment_classification_id` int NOT NULL AUTO_INCREMENT,
  `classification_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`equipment_classification_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of equipmentclassification
-- ----------------------------

-- ----------------------------
-- Table structure for equipmenttype
-- ----------------------------
DROP TABLE IF EXISTS `equipmenttype`;
CREATE TABLE `equipmenttype`  (
  `equipment_type_id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`equipment_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of equipmenttype
-- ----------------------------

-- ----------------------------
-- Table structure for ets_storage
-- ----------------------------
DROP TABLE IF EXISTS `ets_storage`;
CREATE TABLE `ets_storage`  (
  `storage_location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rack_shelf_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `equipment_id` int NOT NULL,
  `quantity` int NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`storage_location`, `rack_shelf_number`, `equipment_id`) USING BTREE,
  INDEX `equipment_id`(`equipment_id` ASC) USING BTREE,
  CONSTRAINT `ets_storage_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ets_storage
-- ----------------------------

-- ----------------------------
-- Table structure for etsusage
-- ----------------------------
DROP TABLE IF EXISTS `etsusage`;
CREATE TABLE `etsusage`  (
  `usage_id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `UsageDate` date NOT NULL,
  `UsageDuration` decimal(10, 2) NOT NULL,
  `Remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`usage_id`) USING BTREE,
  INDEX `equipment_id`(`equipment_id` ASC) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `etsusage_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `etsusage_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of etsusage
-- ----------------------------

-- ----------------------------
-- Table structure for inspection
-- ----------------------------
DROP TABLE IF EXISTS `inspection`;
CREATE TABLE `inspection`  (
  `inspection_id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int NOT NULL,
  `InspectionDate` date NOT NULL,
  `Inspector` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `InspectionResult` enum('Pass','Fail') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`inspection_id`) USING BTREE,
  INDEX `equipment_id`(`equipment_id` ASC) USING BTREE,
  CONSTRAINT `inspection_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inspection
-- ----------------------------

-- ----------------------------
-- Table structure for maintenance
-- ----------------------------
DROP TABLE IF EXISTS `maintenance`;
CREATE TABLE `maintenance`  (
  `maintenance_id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int NULL DEFAULT NULL,
  `maintenance_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `maintenance_date` date NULL DEFAULT NULL,
  `maintenance_cost` decimal(10, 2) NULL DEFAULT NULL,
  `maintenance_provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `maintenance_report` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `maintenance_documentation` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`maintenance_id`) USING BTREE,
  INDEX `equipment_id`(`equipment_id` ASC) USING BTREE,
  CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of maintenance
-- ----------------------------

-- ----------------------------
-- Table structure for manufacturer
-- ----------------------------
DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE `manufacturer`  (
  `manufacturer_id` int NOT NULL AUTO_INCREMENT,
  `manufacturer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`manufacturer_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of manufacturer
-- ----------------------------

-- ----------------------------
-- Table structure for purchase
-- ----------------------------
DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase`  (
  `purchase_id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int NULL DEFAULT NULL,
  `vendor_id` int NULL DEFAULT NULL,
  `purchase_order_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `purchase_date` date NULL DEFAULT NULL,
  `delivery_date` date NULL DEFAULT NULL,
  `invoice_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `delivery_method` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `delivery_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `documentary_requirements` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`purchase_id`) USING BTREE,
  INDEX `equipment_id`(`equipment_id` ASC) USING BTREE,
  INDEX `vendor_id`(`vendor_id` ASC) USING BTREE,
  CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`vendor_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of purchase
-- ----------------------------

-- ----------------------------
-- Table structure for purpose
-- ----------------------------
DROP TABLE IF EXISTS `purpose`;
CREATE TABLE `purpose`  (
  `purpose_id` int NOT NULL AUTO_INCREMENT,
  `purpose_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`purpose_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of purpose
-- ----------------------------

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------

-- ----------------------------
-- Table structure for spareparts
-- ----------------------------
DROP TABLE IF EXISTS `spareparts`;
CREATE TABLE `spareparts`  (
  `spare_part_id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stock` int NOT NULL,
  `stock_level` int NOT NULL,
  `reorder_point` int NOT NULL,
  PRIMARY KEY (`spare_part_id`) USING BTREE,
  INDEX `equipment_id`(`equipment_id` ASC) USING BTREE,
  CONSTRAINT `spareparts_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of spareparts
-- ----------------------------

-- ----------------------------
-- Table structure for vendor
-- ----------------------------
DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor`  (
  `vendor_id` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `contact_person` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `vat_tax_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `payment_terms` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`vendor_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vendor
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
