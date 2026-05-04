-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: eshop_lavarel
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Áo'),(2,'Quần'),(3,'Váy & Đầm'),(4,'Phụ Kiện'),(5,'Giày Dép'),(6,'Túi Xách');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_04_23_002757_add_slug_to_products_table',1),(2,'2026_04_23_015227_create_product_images_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `user_id` int NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `city` varchar(255) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,'ORD-SZALFYPB','canceled',3,'JohnJohnJohn','DoeDoeDoe','testuser@example.com','0123456789','123 Main St','Hanoi',NULL,920000),(2,'ORD-YBTLCZPX','processing',3,'JohnJohnJohn','DoeDoeDoe','testuser@example.com','0123456789','Huế','Huế',NULL,940000),(3,'ORD-05V4PMD8','processing',3,'JohnJohnJohn','DoeDoeDoe','testuser@example.com','0123456789','Huế','Huế',NULL,940000),(4,'ORD-BASAVBZP','canceled',3,'Test','User','testuser@example.com','0987654321','123 Le Loi, Dist 1','HCM','70000',1240000),(5,'ORD-PZSVR7ZJ','completed',2,'sdfgdfg','fgh','user1@gmail.com','1234567890','Đốc Sơ','Huế','2349',1050000);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quanlity` int DEFAULT NULL,
  `price` double DEFAULT NULL,
  `order_detailscol` varchar(45) DEFAULT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES (1,1,920000,NULL,1,16),(3,1,620000,NULL,3,19),(4,1,320000,NULL,3,11),(5,1,920000,NULL,4,16),(6,1,320000,NULL,4,11),(7,1,680000,NULL,5,62),(8,1,150000,NULL,5,64),(9,1,220000,NULL,5,66);
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,1,'https://images.unsplash.com/photo-1539109132313-3915830d1c6a?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(2,1,'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(3,1,'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(4,2,'https://images.unsplash.com/photo-1539109132313-3915830d1c6a?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(5,2,'https://images.unsplash.com/photo-1434389677669-e08b4cda3a20?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(6,2,'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(7,3,'https://images.unsplash.com/photo-1539109132313-3915830d1c6a?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(8,3,'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(9,3,'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(10,4,'https://images.unsplash.com/photo-1539109132313-3915830d1c6a?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(11,4,'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(12,4,'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(13,5,'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(14,5,'https://images.unsplash.com/photo-1434389677669-e08b4cda3a20?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(15,5,'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(16,6,'https://images.unsplash.com/photo-1539109132313-3915830d1c6a?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(17,6,'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(18,6,'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(19,7,'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(20,7,'https://images.unsplash.com/photo-1434389677669-e08b4cda3a20?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(21,7,'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(22,8,'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(23,8,'https://images.unsplash.com/photo-1539109132313-3915830d1c6a?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(24,8,'https://images.unsplash.com/photo-1434389677669-e08b4cda3a20?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(25,9,'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(26,9,'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(27,9,'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(28,10,'https://images.unsplash.com/photo-1434389677669-e08b4cda3a20?w=800&q=80',0,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(29,10,'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',1,'2026-04-22 18:54:28','2026-04-22 18:54:28'),(30,10,'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',2,'2026-04-22 18:54:28','2026-04-22 18:54:28');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `image` varchar(2048) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `quanlity` int DEFAULT NULL,
  `view` int DEFAULT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Áo Blazer Len Cấu Trúc','ao-blazer-len-cau-truc','Áo blazer cao cấp với kiểu dáng cấu trúc, chất liệu len mịn, phù hợp cho các buổi họp và sự kiện.','https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600&h=800&fit=crop',1200000,15,0,1),(2,'Áo Sơ Mi Linen Trắng','ao-so-mi-linen-trang','Áo sơ mi linen thoáng mát, thiết kế tối giản sang trọng cho ngày hè.','https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600&h=800&fit=crop',650000,30,0,1),(3,'Áo Len Cashmere Cổ V','ao-len-cashmere-co-v','Áo len cashmere siêu mềm mại, tông màu trung tính dễ phối đồ.','https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&h=800&fit=crop',890000,20,0,1),(4,'Áo Khoác Denim Vintage','ao-khoac-denim-vintage','Áo khoác denim phong cách vintage, wash nhẹ tạo cảm giác cổ điển.','https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=600&h=800&fit=crop',780000,12,0,1),(5,'Quần Ống Rộng Xếp Li','quan-ong-rong-xep-li','Quần ống rộng xếp li thanh lịch, chất liệu thoáng mát phù hợp mọi dịp.','https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=600&h=800&fit=crop',720000,25,0,2),(6,'Quần Jeans Slim Fit','quan-jeans-slim-fit','Quần jeans slim fit classic, wash đậm tôn dáng.','https://images.unsplash.com/photo-1542272604-787c3835535d?w=600&h=800&fit=crop',550000,40,0,2),(7,'Quần Khaki Chino','quan-khaki-chino','Quần khaki chino basic, phom dáng chuẩn dễ phối.','https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=600&h=800&fit=crop',480000,35,0,2),(8,'Đầm Midi Lụa Xếp Nếp','dam-midi-lua-xep-nep','Đầm midi lụa mềm mại với các nếp xếp tinh tế, phù hợp dự tiệc.','https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&h=800&fit=crop',1350000,10,0,3),(9,'Váy A-Line Tối Giản','vay-a-line-toi-gian','Váy A-line thiết kế tối giản hiện đại, dễ mặc hàng ngày.','https://images.unsplash.com/photo-1612336307429-8a898d10e223?w=600&h=800&fit=crop',680000,18,0,3),(10,'Đầm Maxi Bohemian','dam-maxi-bohemian','Đầm maxi phong cách bohemian tự do, hoàn hảo cho kỳ nghỉ.','https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600&h=800&fit=crop',950000,8,0,3),(11,'Khăn Lụa Twill','khan-lua-twill','Khăn lụa twill in hoa văn tinh tế, điểm nhấn cho mọi trang phục.','https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?w=800&q=80',320000,48,1,4),(12,'Mũ Fedora Classic','mu-fedora-classic','Mũ fedora kiểu dáng cổ điển, chất liệu len cao cấp.','https://images.unsplash.com/photo-1521369909029-2afed882baee?w=600&h=800&fit=crop',450000,20,3,4),(13,'Kính Mát Aviator','kinh-mat-aviator','Kính mát aviator gọng kim loại, tròng phân cực chống UV.','https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=600&h=800&fit=crop',580000,25,0,4),(14,'Giày Loafer Da Bò','giay-loafer-da-bo','Giày loafer da bò thật, đế cao su chống trượt, thiết kế thanh lịch.','https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?w=600&h=800&fit=crop',1450000,12,0,5),(15,'Sandal Quai Ngang Minimal','sandal-quai-ngang-minimal','Sandal quai ngang thiết kế tối giản, êm chân cho mùa hè.','https://images.unsplash.com/photo-1603487742131-4160ec999306?w=600&h=800&fit=crop',380000,30,0,5),(16,'Giày Sneaker Trắng','giay-sneaker-trang','Giày sneaker trắng basic, đa năng phối được với mọi outfit.','https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&h=800&fit=crop',920000,20,0,5),(17,'Túi Tote Da Minimalist','tui-tote-da-minimalist','Túi tote da thật kiểu dáng tối giản, đựng được laptop 14 inch.','https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&h=800&fit=crop',1680000,8,0,6),(18,'Túi Đeo Chéo Compact','tui-deo-cheo-compact','Túi đeo chéo nhỏ gọn, nhiều ngăn tiện dụng cho đi phố.','https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&h=800&fit=crop',750000,15,0,6),(19,'Ba Lô Canvas Urban','ba-lo-canvas-urban','Ba lô canvas phong cách urban, chống nước nhẹ cho ngày mưa.','https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=800&fit=crop',620000,17,1,6),(20,'Áo Polo Pique Classic','ao-polo-pique-classic','Áo polo nam chất liệu pique cao cấp, cổ bẻ lịch lãm, phù hợp đi làm và dạo phố.','https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=600&h=800&fit=crop',320000,45,0,1),(21,'Áo Khoác Bomber Xanh Rêu','ao-khoac-bomber-xanh-reu','Áo khoác bomber phong cách streetwear, chất liệu gió nhẹ, lót lưới thoáng mát.','https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600&h=600&fit=crop',680000,20,0,1),(22,'Áo Sơ Mi Linen Trắng','ao-so-mi-linen-trang-1','Áo sơ mi linen tự nhiên, thoáng khí mùa hè, phom regular fit thanh lịch.','https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600&h=600&fit=crop',450000,35,0,1),(23,'Áo Hoodie Oversize Đen','ao-hoodie-oversize-den','Áo hoodie oversize unisex, nỉ bông dày dặn, mũ trùm 2 lớp, túi kangaroo tiện dụng.','https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600&h=600&fit=crop',390000,50,0,1),(24,'Áo Thun Graphic Art','ao-thun-graphic-art','Áo thun cotton 100% in hoạ tiết nghệ thuật độc quyền, form boxy hiện đại.','https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=600&h=600&fit=crop',250000,60,0,1),(25,'Quần Jeans Slim Fit Xanh Đậm','quan-jeans-slim-fit-xanh-dam','Quần jeans nam slim fit co giãn nhẹ, wash đậm trẻ trung, dễ phối đồ.','https://images.unsplash.com/photo-1542272604-787c3835535d?w=600&h=600&fit=crop',520000,40,0,2),(26,'Quần Kaki Chinos Be','quan-kaki-chinos-be','Quần kaki chinos ống đứng, chất vải mềm mịn, thích hợp đi làm công sở.','https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=600&h=600&fit=crop',420000,35,0,2),(27,'Quần Jogger Thể Thao','quan-jogger-the-thao','Quần jogger thun nỉ, bo gấu năng động, túi khoá kéo an toàn.','https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600&h=600&fit=crop',350000,55,0,2),(28,'Quần Short Cargo Xám','quan-short-cargo-xam','Quần short cargo nhiều túi hộp phong cách quân đội, vải ripstop bền bỉ.','https://images.unsplash.com/photo-1591195853828-11db59a44f6b?w=600&h=600&fit=crop',290000,40,0,2),(29,'Quần Tây Âu Đen Công Sở','quan-tay-au-den-cong-so','Quần tây âu đen ống suông, ly ép sắc nét, chất liệu polyester blend cao cấp.','https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&h=600&fit=crop',480000,30,0,2),(30,'Đầm Maxi Hoa Nhí Vintage','dam-maxi-hoa-nhi-vintage','Đầm maxi hoạ tiết hoa nhí phong cách vintage, chất vải voan nhẹ nhàng bay bổng.','https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600&h=600&fit=crop',650000,25,0,3),(31,'Váy Midi A-line Trắng','vay-midi-a-line-trang','Váy midi xoè form A thanh lịch, chất liệu linen pha cotton, có lót trong.','https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&h=600&fit=crop',480000,30,0,3),(32,'Đầm Body Đen Cổ Vuông','dam-body-den-co-vuong','Đầm body tôn dáng cổ vuông nữ tính, chất thun gân co giãn tốt.','https://images.unsplash.com/photo-1568252542512-9fe8fe9c87bb?w=600&h=600&fit=crop',380000,35,0,3),(33,'Chân Váy Jean Chữ A','chan-vay-jean-chu-a','Chân váy jean ngắn chữ A, wash nhẹ trẻ trung, kết hợp hoàn hảo với áo croptop.','https://images.unsplash.com/photo-1582552938357-32b906df40cb?w=600&h=800&fit=crop',320000,40,0,3),(34,'Đầm Sơ Mi Caro Nâu','dam-so-mi-caro-nau','Đầm sơ mi dài tay hoạ tiết caro vintage, thắt eo nơ, phù hợp mùa thu đông.','https://images.unsplash.com/photo-1612336307429-8a898d10e223?w=600&h=600&fit=crop',520000,20,0,3),(35,'Kính Mát Gọng Kim Loại','kinh-mat-gong-kim-loai','Kính mát thời trang gọng kim loại vàng hồng, tròng polarized chống UV400.','https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=600&h=600&fit=crop',280000,50,1003,4),(36,'Đồng Hồ Dây Da Nâu','dong-ho-day-da-nau','Đồng hồ nam mặt tròn minimalist, dây da thật màu nâu cognac, chống nước 3ATM.','https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop',1250000,15,0,4),(37,'Thắt Lưng Da Bò Đen','that-lung-da-bo-den','Thắt lưng da bò thật 100%, khoá kim tự động, bề mặt nhám sang trọng.','https://images.unsplash.com/photo-1624222247344-550fb9c1c9c5?w=600&h=600&fit=crop',350000,40,0,4),(38,'Mũ Bucket Vải Canvas','mu-bucket-vai-canvas','Mũ bucket vải canvas dày dặn, chống nắng tốt, phong cách casual unisex.','https://images.unsplash.com/photo-1556306535-0f09a537f0a3?w=600&h=600&fit=crop',180000,60,0,4),(39,'Khăn Choàng Len Cashmere','khan-choang-len-cashmere','Khăn choàng cổ len cashmere mềm mại, giữ ấm mùa đông, nhiều màu thời trang.','https://images.unsplash.com/photo-1609803384069-19f3e5a70e75?w=600&h=600&fit=crop',420000,25,0,4),(40,'Giày Thể Thao Trắng Classic','giay-the-thao-trang-classic','Giày sneaker trắng tinh giản, đế cao su chống trượt, phù hợp mọi outfit.','https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&h=600&fit=crop',890000,30,1000,5),(41,'Giày Oxford Da Nâu','giay-oxford-da-nau','Giày oxford da bò thật, đế cao su đúc, thiết kế brogue cổ điển cho quý ông.','https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=600&h=600&fit=crop',1450000,15,0,5),(42,'Dép Quai Ngang Minimal','dep-quai-ngang-minimal','Dép quai ngang đế dày thiết kế tối giản, chất liệu EVA nhẹ và êm chân.','https://images.unsplash.com/photo-1603487742131-4160ec999306?w=600&h=600&fit=crop',250000,50,0,5),(43,'Boots Chelsea Da Đen','boots-chelsea-da-den','Giày boots chelsea da PU cao cấp, cổ chun co giãn dễ mang, đế block 4cm.','https://images.unsplash.com/photo-1638247025967-b4e38f787b76?w=600&h=600&fit=crop',1280000,18,0,5),(44,'Giày Chạy Bộ Ultra Boost','giay-chay-bo-ultra-boost','Giày chạy bộ đế foam siêu nhẹ, upper knit thoáng khí, hỗ trợ vòm chân.','https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=600&fit=crop',1650000,22,0,5),(45,'Túi Đeo Chéo Mini Da','tui-deo-cheo-mini-da','Túi đeo chéo mini da PU mềm, khoá kéo chắc chắn, dây đeo điều chỉnh.','https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&h=600&fit=crop',420000,35,0,6),(46,'Ba Lô Laptop Chống Nước','ba-lo-laptop-chong-nuoc','Ba lô laptop 15.6 inch, vải oxford chống nước, ngăn chống sốc, cổng sạc USB.','https://images.unsplash.com/photo-1581605405803-3ca5df4f5d6d?w=600&h=600&fit=crop',580000,28,0,6),(47,'Túi Tote Canvas In Chữ','tui-tote-canvas-in-chu','Túi tote vải canvas dày, in chữ typography thời trang, ngăn trong có khoá kéo.','https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&h=600&fit=crop',180000,70,0,6),(48,'Clutch Dự Tiệc Ánh Kim','clutch-du-tiec-anh-kim','Clutch dự tiệc ánh kim sang trọng, khoá cài nam châm, dây xích đeo vai.','https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=600&h=600&fit=crop',520000,15,0,6),(49,'Túi Bao Tử Thể Thao','tui-bao-tu-the-thao','Túi bao tử đeo hông chất liệu nylon chống thấm, 3 ngăn tiện dụng cho outdoor.','https://images.unsplash.com/photo-1622560480654-d96214fdc887?w=600&h=600&fit=crop',280000,45,0,6),(50,'Áo Cardigan Len Mỏng','ao-cardigan-len-mong','Áo cardigan len mỏng nhẹ, cài khuy tròn, phong cách Hàn Quốc dịu dàng.','https://images.unsplash.com/photo-1434389677669-e08b4cda3a20?w=600&h=800&fit=crop',380000,30,0,1),(51,'Áo Tank Top Thể Thao','ao-tank-top-the-thao','Áo tank top tập gym chất liệu dri-fit, thoáng mát, co giãn 4 chiều.','https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=600&h=800&fit=crop',190000,65,0,1),(52,'Áo Khoác Gió Nhẹ Xanh Navy','ao-khoac-gio-nhe-xanh-navy','Áo khoác gió siêu nhẹ, gấp gọn bỏ túi, chống nước nhẹ, lý tưởng cho du lịch.','https://images.unsplash.com/photo-1545594861-3bef43ff2fc8?w=600&h=800&fit=crop',450000,25,0,1),(53,'Quần Legging Yoga Đen','quan-legging-yoga-den','Quần legging yoga cao cấp, cạp cao nâng mông, chất liệu nylon pha spandex.','https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=600&h=800&fit=crop',320000,45,0,2),(54,'Quần Baggy Jean Rách Gối','quan-baggy-jean-rach-goi','Quần baggy jean rách gối phong cách streetwear, wash xanh nhạt cá tính.','https://images.unsplash.com/photo-1604176354204-9268737828e4?w=600&h=800&fit=crop',480000,30,0,2),(55,'Quần Đùi Thể Thao Đen','quan-dui-the-thao-den','Quần đùi thể thao nam, chất thun mát, có túi khoá kéo và dây rút.','https://images.unsplash.com/photo-1562157873-818bc0726f68?w=600&h=800&fit=crop',220000,55,0,2),(56,'Váy Liền Hoa Retro','vay-lien-hoa-retro','Váy liền in hoa retro cổ điển, cổ vuông tay phồng, chất cotton mềm mại.','https://images.unsplash.com/photo-1622122201714-77da0ca8e5d2?w=600&h=800&fit=crop',550000,20,0,3),(57,'Đầm Hai Dây Satin','dam-hai-day-satin','Đầm hai dây satin bóng mượt, dáng xoè nhẹ ngang gối, sang trọng dự tiệc.','https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=600&h=800&fit=crop',620000,18,1000,3),(58,'Chân Váy Xếp Li Dài','chan-vay-xep-li-dai','Chân váy xếp li dài qua gối, chất vải chiffon bay bổng, lưng chun thoải mái.','https://images.unsplash.com/photo-1594633313593-bab3825d0caf?w=600&h=800&fit=crop',420000,28,0,3),(59,'Vòng Tay Bạc Minimalist','vong-tay-bac-minimalist','Vòng tay bạc 925 thiết kế tối giản, mặt khắc chữ, phù hợp làm quà tặng.','https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=600&h=800&fit=crop',350000,35,0,4),(60,'Bông Tai Ngọc Trai','bong-tai-ngoc-trai','Bông tai ngọc trai nhân tạo thanh lịch, khoá bấm an toàn, không gây dị ứng.','https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=600&h=800&fit=crop',180000,50,1,4),(61,'Ví Dài Da Nam','vi-dai-da-nam','Ví dài da PU cao cấp, nhiều ngăn đựng thẻ và tiền, khoá kéo chắc chắn.','https://images.unsplash.com/photo-1627123424574-724758594e93?w=600&h=800&fit=crop',290000,40,0,4),(62,'Giày Cao Gót Mũi Nhọn','giay-cao-got-mui-nhon','Giày cao gót 7cm mũi nhọn thanh lịch, chất liệu da lộn, đệm mút êm.','https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=600&h=800&fit=crop',680000,19,0,5),(63,'Giày Slip-on Vải Canvas','giay-slip-on-vai-canvas','Giày slip-on vải canvas thoáng mát, đế cao su dẻo, dễ mang tháo.','https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=600&h=800&fit=crop',350000,40,1000,5),(64,'Dép Xỏ Ngón Cao Su','dep-xo-ngon-cao-su','Dép xỏ ngón cao su thiên nhiên, đế chống trượt, nhẹ bền cho mùa hè.','https://images.unsplash.com/photo-1603487742131-4160ec999306?w=600&h=800&fit=crop',150000,79,3,5),(65,'Túi Xách Tay Da Nữ','tui-xach-tay-da-nu','Túi xách tay nữ da PU mềm, quai kép chắc chắn, ngăn lót vải dù cao cấp.','https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&h=800&fit=crop',750000,15,1,6),(66,'Túi Đựng iPad Vải Nỉ','tui-dung-ipad-vai-ni','Túi đựng iPad 11 inch chất liệu vải nỉ dày, chống xước, có quai cầm.','https://images.unsplash.com/photo-1559563458-527698bf5295?w=600&h=800&fit=crop',220000,34,2,6),(67,'Túi Gym Duffel Thể Thao','tui-gym-duffel-the-thao','Túi gym duffel chống nước, ngăn riêng đựng giày, dây đeo vai có đệm.','https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=800&fit=crop',450000,25,1008,6);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `cart_data` json DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@gmail.com','$2y$12$ItO6wNz5caS32gRpkzhrken4x4mCtlS632P6tazmY1hi9UkfB503m',NULL,'admin',NULL,NULL),(2,'user1@gmail.com','$2y$12$H3U5s9VC2Gecttlxui4TLuYTcpyq.45AMK6GVcEAk4HRZWBcwiXii','{\"29\": {\"name\": \"Quần Tây Âu Đen Công Sở\", \"slug\": \"quan-tay-au-den-cong-so\", \"image\": \"https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&h=600&fit=crop\", \"price\": 480000, \"quantity\": \"1\"}, \"62\": {\"name\": \"Giày Cao Gót Mũi Nhọn\", \"image\": \"https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=600&h=800&fit=crop\", \"price\": 680000, \"quantity\": \"1\"}, \"63\": {\"name\": \"Giày Slip-on Vải Canvas\", \"slug\": \"giay-slip-on-vai-canvas\", \"image\": \"https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=600&h=800&fit=crop\", \"price\": 350000, \"quantity\": \"1\"}, \"64\": {\"name\": \"Dép Xỏ Ngón Cao Su\", \"image\": \"https://images.unsplash.com/photo-1603487742131-4160ec999306?w=600&h=800&fit=crop\", \"price\": 150000, \"quantity\": \"1\"}, \"65\": {\"name\": \"Túi Xách Tay Da Nữ\", \"slug\": \"tui-xach-tay-da-nu\", \"image\": \"https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&h=800&fit=crop\", \"price\": 750000, \"quantity\": \"1\"}, \"66\": {\"name\": \"Túi Đựng iPad Vải Nỉ\", \"slug\": \"tui-dung-ipad-vai-ni\", \"image\": \"https://images.unsplash.com/photo-1559563458-527698bf5295?w=600&h=800&fit=crop\", \"price\": 220000, \"quantity\": \"1\"}, \"67\": {\"name\": \"Túi Gym Duffel Thể Thao\", \"slug\": \"tui-gym-duffel-the-thao\", \"image\": \"https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=800&fit=crop\", \"price\": 450000, \"quantity\": \"1\"}}','customer',NULL,NULL),(3,'admin2@gmail.com','$2y$12$oGguGwQxHAo.su0ZOyKkY.xP0TQrIc.JI2yKQrb55xPzlh/DBGZC2',NULL,'admin',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-04 16:18:47
