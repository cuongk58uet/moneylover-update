DROP DATABASE IF EXISTS moneylover;
CREATE DATABASE moneylover;
USE moneylover;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `category_type` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id`, `category_name`, `category_type`) VALUES
(1, 'Nợ', 'Nợ'),
(2, 'Cho vay', 'Cho Vay'),
(3, 'Ăn uống', 'Chi Tiêu'),
(4, 'Người yêu, bạn bè', 'Chi Tiêu'),
(5, 'Di chuyển', 'Chi Tiêu'),
(6, 'Hóa đơn', 'Chi Tiêu'),
(7, 'Tiện ích', 'Chi Tiêu'),
(8, 'Mua sắm', 'Chi Tiêu'),
(9, 'Giải trí', 'Chi Tiêu'),
(10, 'Du lịch', 'Chi Tiêu'),
(11, 'Sức khỏe', 'Chi Tiêu'),
(12, 'Đầu tư', 'Chi Tiêu'),
(13, 'Khoản chi khác', 'Chi Tiêu'),
(14, 'Học bổng', 'Thu Nhập'),
(15, 'Lương', 'Thu Nhập'),
(16, 'Thưởng', 'Thu Nhập'),
(17, 'Tiền lãi', 'Thu Nhập'),
(18, 'Khoản thu khác', 'Thu Nhập'),
(20, 'Giúp Đỡ', 'Cho Vay');

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `create_date` date NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `wallet_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(12) NOT NULL DEFAULT 'admin',
  `phone` varchar(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `actived` tinyint(2) NOT NULL DEFAULT '0',
  `register_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `wallets` (
  `id` int(11) NOT NULL,
  `wallet_name` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `banlances` bigint(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_id` (`wallet_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `userid` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;

ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;

ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;

ALTER TABLE `transactions`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wallet_id` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `wallets`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
