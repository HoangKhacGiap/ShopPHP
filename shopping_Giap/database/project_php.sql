-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 19, 2023 at 10:49 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Laptop'),
(2, 'Điện thoại'),
(3, 'Máy tính bảng'),
(4, 'Sạc không dây'),
(5, 'Đồng hồ thông minh'),
(6, 'Tai nghe');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Xiaomi'),
(4, 'Huwei'),
(5, 'Vivo'),
(6, 'Oppo');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total` float NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `total`, `status`, `user_id`) VALUES
(10, 3205, '2', 5),
(11, 35305, '2', 5),
(12, 8205, '1', 5),
(13, 3205, '1', 5),
(14, 32805, '2', 5),
(15, 6605, '2', 5),
(16, 10405, '1', 5),
(17, 5005, '0', 2),
(18, 29005, '0', 5),
(19, 7205, '2', 5),
(20, 25005, '0', 2),
(21, 17205, '0', 2),
(22, 72005, '0', 5),
(23, 15005, '2', 5),
(24, 8205, '2', 5),
(25, 32205, '1', 5),
(26, 15405, '1', 5),
(27, 4305, '1', 6),
(28, 38105, '1', 8);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `count` int NOT NULL,
  `orders_id` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_details` (`orders_id`),
  KEY `fk_details_product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `count`, `orders_id`, `product_id`) VALUES
(9, 1, 10, 2),
(10, 1, 11, 2),
(11, 1, 11, 8),
(12, 1, 11, 9),
(13, 1, 11, 7),
(14, 1, 12, 1),
(15, 1, 12, 2),
(16, 1, 13, 2),
(17, 8, 14, 2),
(18, 1, 14, 3),
(19, 1, 15, 6),
(20, 1, 15, 9),
(21, 1, 16, 2),
(22, 1, 16, 3),
(23, 1, 17, 1),
(24, 1, 18, 8),
(25, 5, 18, 5),
(26, 1, 19, 3),
(27, 1, 20, 8),
(28, 1, 21, 4),
(29, 1, 21, 3),
(30, 90, 22, 5),
(31, 1, 23, 4),
(32, 1, 23, 1),
(33, 1, 24, 1),
(34, 1, 24, 2),
(35, 1, 25, 8),
(36, 1, 25, 3),
(37, 1, 26, 1),
(38, 1, 26, 2),
(39, 1, 26, 3),
(40, 1, 27, 5),
(41, 1, 27, 6),
(42, 1, 28, 9),
(43, 1, 28, 4),
(44, 1, 28, 8);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `stocks` int NOT NULL,
  `review` int NOT NULL,
  `manufacturer_id` int NOT NULL,
  `categories_id` int NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `fk_manufacturer_product` (`manufacturer_id`),
  KEY `fk_categories_product` (`categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `stocks`, `review`, `manufacturer_id`, `categories_id`, `image`, `description`) VALUES
(1, 'OPPO Reno8 GGG123', 5000, 30, 4, 6, 2, 'oppo.jpg', 'OPPO Reno8 T là một trong những mẫu điện thoại vừa được nhà OPPO tung ra thị trường vào dịp đầu năm 2023 với nhiều thay đổi ấn tượng, trong đó nổi bật nhất có lẽ là ống kính camera 100 MP, đi cùng lối thiết kế trẻ trung đẹp mắt, hứa hẹn sẽ thu hút bạn ngay từ cái nhìn đầu tiên.'),
(2, 'iPhone 12', 3200, 90, 3, 1, 2, 'iphone.jpg', 'Apple đã trình diện đến người dùng mẫu điện thoại iPhone 12 128GB với sự tuyên bố về một kỷ nguyên mới của iPhone 5G, nâng cấp về màn hình và hiệu năng hứa hẹn đây sẽ là smartphone cao cấp đáng để mọi người đầu tư sở hữu. '),
(3, 'Laptop Asus TUF Gaming F15', 7200, 12, 4, 5, 1, 'laptop.jpg', 'Laptop Asus TUF Gaming F15 FX506HE i7 11800H (HN378W) mang vẻ đẹp ấn tượng, cuốn hút đậm chất gaming, đi cùng cấu hình mạnh mẽ, đa dạng tính năng, chiếc laptop gaming từ nhà Asus này sẽ trở thành người bạn đồng hành lý tưởng trên những chiến trường ảo cho các anh em game thủ.'),
(4, 'Đế sạc không dây Qi 10W Mbest AC63F3 ', 10000, 5, 5, 3, 4, 'sac_khong_day.jpg', 'Sạc không dây Qi 10W Mbest AC63F3 Đen có thiết kế đẹp mắt với các vân hình tròn tinh tế. Vỏ nhôm giúp cho bộ sạc không dây trở nên chắc chắn và sang trọng hơn'),
(5, 'Oppo Band 2', 800, 90, 5, 6, 5, 'smart_watch.jpg', 'OPPO đã cho ra mắt sản phẩm OPPO Band 2 với sự nâng cấp về thiết kế, tính năng theo dõi sức khỏe và các chế độ thể thao hỗ trợ người dùng chăm sóc cơ thể một cách khoa học.'),
(6, 'AirPods Pro Gen 2', 3500, 12, 3, 1, 6, 'airpod.jpg', 'Tai nghe Bluetooth AirPods Pro (2nd Gen) USB-C Charge Apple sở hữu thiết kế mang đậm chất thương hiệu Apple, màu sắc sang trọng, đi cùng nhiều công nghệ cho các iFan: chip Apple H2, chống bụi, chống ồn chủ động,... hứa hẹn mang đến trải nghiệm âm thanh sống động, chinh phục người dùng.\r\n\r\n'),
(7, 'Apple MacBook Air M1', 4000, 20, 4, 1, 1, 'macbook.jpg', 'Laptop Apple MacBook Air M1 2020 thuộc dòng laptop cao cấp sang trọng có cấu hình mạnh mẽ, chinh phục được các tính năng văn phòng lẫn đồ hoạ mà bạn mong muốn, thời lượng pin dài, thiết kế mỏng nhẹ sẽ đáp ứng tốt các nhu cầu làm việc của bạn.'),
(8, 'Samsung Galaxy Watch6', 25000, 3, 5, 2, 5, 'smart_watch_samsung.jpg', 'Galaxy Unpacked là một trong những sự kiện công nghệ đáng chú ý nhất nửa cuối năm của nhà Samsung. Bên cạnh những mẫu điện thoại gập đình đám, Samsung Galaxy Watch6 40mm cũng là một sản phẩm được mong chờ nhất của các tín đồ công nghệ nói chung và fan nhà Samsung nói riêng.'),
(9, 'Xiaomi 13T Pro 5G', 3100, 12, 5, 3, 2, 'xiaomi.jpg', 'Xiaomi 13T Pro 5G là mẫu máy thuộc phân khúc tầm trung đáng chú ý tại thị trường Việt Nam. Điện thoại ấn tượng nhờ được trang bị chip Dimensity 9200+, camera 50 MP có kèm sự hợp tác với Leica cùng kiểu thiết kế tinh tế đầy sang trọng.'),
(10, 'Samsung Galaxy Tab A9+', 1100, 90, 5, 2, 3, 'may_tinh_bang.jpg', 'Với giá cả phải chăng, Samsung Galaxy Tab A9+ 5G là một sản phẩm máy tính bảng của Samsung dành cho người dùng muốn sở hữu một thiết bị giải trí cơ bản với màn hình rộng và khả năng kết nối mạng toàn diện để truy cập internet bất kỳ lúc nào và ở bất kỳ đâu.');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Role_Admin'),
(2, 'Role_Customer');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role_user` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `fullname`, `id`, `role_id`) VALUES
('votien31102002@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Võ Tiến', 1, 2),
('admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 2, 1),
('votien@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Võ Tiến', 3, 2),
('a@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'A', 4, 2),
('giap1108@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Giap', 5, 2),
('tien123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Tien', 6, 2),
('gg123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Giap123', 8, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_details_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_order_details` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_categories_product` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_manufacturer_product` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_role_user` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
