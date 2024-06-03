-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Vært: localhost:8889
-- Genereringstid: 18. 12 2023 kl. 10:50:58
-- Serverversion: 5.7.39
-- PHP-version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_delivery`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `category_img` varchar(30) NOT NULL,
  `category_color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_img`, `category_color`) VALUES
(1, 'italian', '&#127470;&#127481;', '#FCB9AA'),
(2, 'japanese', '&#127471;&#127477;', '#ECEAE4'),
(3, 'american', '&#127482;&#127480;', '#D4F0F0'),
(4, 'mexican', '&#127474;&#127485;', '#CCE2CB'),
(5, 'fruit', '&#127818;', '#FDD7C2'),
(6, 'vegetable', '&#129382;', '#F6EAC2'),
(7, 'alcohol', '&#127867;', '#FEE1E8');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_product_fk` bigint(20) UNSIGNED NOT NULL,
  `order_user_fk` bigint(20) UNSIGNED NOT NULL,
  `order_created_at` char(10) NOT NULL,
  `order_is_delivered` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `orders`
--

INSERT INTO `orders` (`order_id`, `order_product_fk`, `order_user_fk`, `order_created_at`, `order_is_delivered`) VALUES
(1, 12, 2, '', 0),
(2, 6, 3, '', 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products`
--

CREATE TABLE `products` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `product_img` varchar(15) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `product_category_fk` bigint(20) UNSIGNED NOT NULL,
  `product_rating` decimal(2,1) NOT NULL,
  `product_like` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_img`, `product_description`, `product_price`, `product_category_fk`, `product_rating`, `product_like`) VALUES
(1, 'Pizza Pepperoni', '&#127829;', 'A classic favorite, topped with spicy pepperoni and gooey cheese.', '70.00', 1, '8.0', 0),
(2, 'Spaghetti', '&#127837;', 'A classic Italian dish, made with tender pasta and savory tomato sauce.\"', '85.00', 1, '7.5', 0),
(3, 'Sushi', '&#127843;', 'A Japanese delicacy, featuring vinegared rice and various seafood delights.', '125.00', 2, '9.0', 0),
(4, 'Bento Box', '&#127857;', 'A thoughtfully prepared meal, neatly arranged in a compact box, featuring a selection of flavorful items such as fluffy rice, savory meat or fish, crisp vegetables, and often accompanied by a tangy sauce or two.', '185.00', 2, '8.8', 0),
(5, 'Steaming Bowl', '&#127836;', 'A heartwarming Japanese dish, consisting of a generous portion of rice topped with an assortment of succulent seafood, tender chicken or flavorful beef, all steamed to perfection and served in a comforting bowl.', '135.00', 2, '6.5', 0),
(6, 'Dumplings', '&#129375;', 'Savory pockets of delight, filled with choice ingredients such as juicy pork, tender chicken or fragrant vegetables, wrapped in a soft, chewy dough and served steamed or pan-fried to a golden crisp.', '40.00', 2, '7.4', 0),
(7, 'Hamburger', '&#127828;', 'A classic American staple, featuring a juicy patty of ground beef, nestled between a soft bun and topped with an array of tasty fixings such as crispy lettuce, ripe tomato, creamy cheese, and a tangy condiment or two.', '79.00', 3, '8.2', 0),
(8, 'Cheeseburger', '&#127828;', 'A mouthwatering variation of the classic hamburger, featuring a melted slice of gooey cheese atop a savory beef patty, cradled by a soft bun and finished with a fresh salad of lettuce, tomato, and onion, and often enhanced by a zesty sauce.', '79.00', 3, '8.1', 0),
(9, 'French Fries', '&#127839;', 'Golden, crispy, and utterly irresistible, these fries are cooked to perfection and seasoned with just the right amount of salt and pepper, making them the perfect accompaniment to your favorite burger or sandwich, or simply a satisfying snack on their own', '35.00', 3, '7.6', 0),
(10, 'Hot Dog', '&#127789;', 'A tasty treat, topped with tangy mustard, sweet relish, and crunchy chopped onions, all nestled in a soft bun.', '55.00', 3, '6.4', 0),
(11, 'Taco', '&#127790;', 'Savory and flavorful, these tacos are filled with seasoned beef, lettuce, tomatoes, and cheese, all wrapped in a crispy tortilla shell.', '45.00', 4, '8.9', 0),
(12, 'Burrito', '&#127791;', 'A large flour tortilla filled with rice, beans, meat, cheese, and vegetables, all wrapped up tight and served with a side of savory sauce.', '99.00', 4, '8.0', 0),
(13, 'Avocado', '&#129361;', 'A nutritious and versatile fruit, with a creamy texture and delicate flavor, perfect for adding to salads, sandwiches, or enjoying alone as a healthy snack.', '12.00', 4, '9.9', 0),
(14, 'Red Wine', '&#127863;', 'A rich and full-bodied wine, with a deep crimson color and notes of dark fruit, spices, and subtle oak, perfect for sipping by the fire or pairing with a hearty meal.', '200.00', 7, '6.7', 0),
(16, 'Beer', '&#127866;', 'A refreshing and crisp brew, with a golden color and hints of hoppy bitterness, perfect for enjoying on a hot summer day or as a relaxing aperitif.', '49.00', 7, '7.1', 0),
(17, 'Champagne', '&#127870;', 'A luxurious and bubbly drink, made from the finest grapes and aged to perfection, perfect for celebrating special occasions or enjoying as a sophisticated apéritif.', '299.00', 7, '8.6', 0),
(18, 'Whiskey', '&#129347;', 'A smooth and rich liquor, with a warm amber color and notes of oak, vanilla, and caramel, perfect for sipping neat or enjoying over ice, a true classic for any discerning palate.', '89.00', 7, '8.0', 0),
(19, 'Sex on the Beach', '&#127864;', 'A fruity and flirtatious drink, made with vodka, peach schnapps, orange juice, and cranberry juice, served in a tall glass and garnished with a slice of orange, a sweet and tangy treat for the senses.', '119.00', 7, '7.8', 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'User'),
(2, 'Partner'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_first_name` varchar(20) NOT NULL,
  `user_last_name` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_phonenumber` varchar(20) NOT NULL,
  `user_role_fk` bigint(20) UNSIGNED NOT NULL,
  `user_is_blocked` tinyint(1) NOT NULL,
  `user_created_at` char(10) NOT NULL,
  `user_updated_at` char(10) NOT NULL,
  `user_deleted_at` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_email`, `user_password`, `user_phonenumber`, `user_role_fk`, `user_is_blocked`, `user_created_at`, `user_updated_at`, `user_deleted_at`) VALUES
(1, 'aa', 'aa', 'a@a.a', '$2y$10$oP6pBzo/lPrfnvxzUP/vSOv/.3xwg7Wz7AWSnMkZBw227gSABrNE6', '111', 1, 0, '1701687308', '0', '0'),
(2, 'Mille', 'Helbo', 'millehelbo@outlook.dk', '$2y$10$LHK6EkOEVyJuAVln72.E3u7/Nk3fuaDyic7XXUR/RF3MQrfIXLoPO', '21288594', 3, 0, '1701688623', '1702381844', '0'),
(3, 'aa', 'aa', 'a@a.a', '$2y$10$Ya5A/3hM7xahl.mPFIgZr.cVFaZPbGlZkFSqrsUqiT3h0R1.hVd1i', '123123', 1, 1, '1701688632', '0', '1701944176'),
(4, 'John', 'Doe', 'john@doe.com', '$2y$10$IYgLa10zQEPKpg4wDeU1F.UYC.Q0WkdP5KGSAn.XZ/P0D3Y9StrXC', '111', 3, 0, '1701697129', '1702382834', '0'),
(7, 'James', 'Weldon', 'james@wong.com', '$2y$10$wHGnBTAPMtuCHBwvBukLh.ZEn8FAnaCUHv0HUMU/4TVHHXUlXG956', '123456789', 3, 0, '1701859302', '1702381835', '0'),
(8, 'Mille', 'Helbo', 'mille@outlook.dk', '$2y$10$oU4Ax8iUuE0k396eQd/.dewjglzX/vKHVoEq37yNmTYWOahb/Nc46', '21288594', 1, 0, '1701944209', '0', '1701945216'),
(9, 'Asd', 'aSD', 'helbo@outlook.dk', '$2y$10$9MkiOp66fOmD/lnzZY2oZOAqXIjAkClrDm4FIynk8lSoVgBMPdNhW', '21288594', 1, 0, '1701945301', '0', '1701945311'),
(10, 'hej', 'hej', 'hej@outlook.dk', '$2y$10$z0lwURjqhFTWySDQkY/nPubo4Vyvxtkma1d8cHiKX09Ca4iDOzOv.', '21288594', 2, 0, '1701945449', '0', '1701945869'),
(11, 'asger', 'jhb', 'asger@jhb.dk', '$2y$10$vUEd5fTQNU8a0GOnuHEcYO5yPVeMY5mBOmSITwC3wzebLutAoj4Wm', '10203040', 1, 0, '1702380641', '1702380658', '0'),
(12, 'Mille', 'helbob', 'millehelbos@outlook.dk', '$2y$10$.4NcFF0AWDlq2ynhM.DG9OWNjgeSxD95nzBQw.XMtdVju3OQzrWQW', '21288594', 1, 0, '1702896389', '0', '0'),
(13, 'mille', 'helbo', 'hej123@outlook.dk', '$2y$10$lOevlUx/oQjsjhGreZPykeIB7E0keDRhNOZneqqJZG5fa0XkCA.Mi', '21288594', 1, 0, '1702896614', '0', '0');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `categories`
--
ALTER TABLE `categories`
  ADD UNIQUE KEY `category_id` (`category_id`);

--
-- Indeks for tabel `orders`
--
ALTER TABLE `orders`
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `orders_ibfk_1` (`order_user_fk`),
  ADD KEY `orders_ibfk_2` (`order_product_fk`);

--
-- Indeks for tabel `products`
--
ALTER TABLE `products`
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD KEY `products_ibfk_1` (`product_category_fk`);

--
-- Indeks for tabel `roles`
--
ALTER TABLE `roles`
  ADD UNIQUE KEY `role_id` (`role_id`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `users_ibfk_1` (`user_role_fk`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tilføj AUTO_INCREMENT i tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tilføj AUTO_INCREMENT i tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tilføj AUTO_INCREMENT i tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`order_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`order_product_fk`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_category_fk`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role_fk`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
