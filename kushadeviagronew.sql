-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2023 at 10:08 AM
-- Server version: 8.1.0
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kushadeviagronew`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_admin`
--

CREATE TABLE `t_admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_admin`
--

INSERT INTO `t_admin` (`username`, `password`) VALUES
('admin', '$2y$10$hOplNDHUP1NCy/47uP5fHuYm6jrmZQzpLK6DZ/ruqQIbCcosTcPqa');

-- --------------------------------------------------------

--
-- Table structure for table `t_customer`
--

CREATE TABLE `t_customer` (
  `cust_id` int NOT NULL,
  `cust_fname` varchar(255) NOT NULL,
  `cust_lname` varchar(255) NOT NULL,
  `cust_email` varchar(255) NOT NULL,
  `cust_password` varchar(255) NOT NULL,
  `cust_phone` varchar(50) NOT NULL,
  `cust_address` text NOT NULL,
  `cust_city` varchar(50) NOT NULL,
  `cust_state` varchar(50) NOT NULL,
  `cust_datetime` datetime NOT NULL,
  `cust_status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_customer`
--

INSERT INTO `t_customer` (`cust_id`, `cust_fname`, `cust_lname`, `cust_email`, `cust_password`, `cust_phone`, `cust_address`, `cust_city`, `cust_state`, `cust_datetime`, `cust_status`) VALUES
(1, 'Bijay', 'Adhikari', 'bijay.adhikari1000@gmail.com', '$2y$10$9.XR4.NzlqzWt5eQIz91Be5JvVqM3J1UpiKKKm6PweSi1PksMn8Hm', '9849284218', 'Kushadevi-03', 'Panauti', 'Bagmati', '2023-08-25 20:03:10', 1),
(2, 'Udaya', 'Adhikari', 'udayadhykary@gmail.com', '$2y$10$2vXq51lLm5nFBE6A6EzIA.IDnTEHugXtBAmm6m3Pn9U5qUsrZu3j.', '9861603601', 'Kushadevi-03', 'Panauti', 'Bagmati', '2023-08-25 20:04:11', 0),
(3, 'Rakesh', 'Gurung', 'gurungrakhesh34@gmail.com', '$2y$10$YKWlqpQ51jmFOexaGswlAONInRfWs8Eb.NAVkpzt8LqL/P3bbTiPa', '9741118880', 'Panchkhal-05', 'Panchkhal', 'Bagmati', '2023-08-25 20:05:19', 1),
(4, 'Samir', 'Neupane', 'samirneupane422@gmail.com', '$2y$10$JndrdogLHd0w19cuY3gxQOdWzTh.uNhXkTKzskOvYbLICDJ7LKwYa', '9860464876', 'Pandubazar', 'Bhaktapur', 'Bagmati', '2023-08-25 20:06:11', 1),
(5, 'Ram', 'Shah', 'ram@gmail.com', '$2y$10$AqUi2QMhtvKZDR9C3cW1HO32amNJtS4n2ORsGwSfGod63KnvEHjX2', '9849293421', 'Barpak', 'Gorkha', 'Bagmati', '2023-08-26 10:17:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_cust_message`
--

CREATE TABLE `t_cust_message` (
  `msg_id` int NOT NULL,
  `msg_datetime` datetime NOT NULL,
  `msg_subject` text NOT NULL,
  `msg_actual_msg` text NOT NULL,
  `cust_id` int NOT NULL,
  `msg_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_cust_message`
--

INSERT INTO `t_cust_message` (`msg_id`, `msg_datetime`, `msg_subject`, `msg_actual_msg`, `cust_id`, `msg_status`) VALUES
(1, '2023-08-25 20:09:36', 'About Order', 'Hello sir I\'ve ordered some products. Please check it and deliver as fast as possible. Thanks', 1, 1),
(2, '2023-08-25 20:12:59', 'Plant Inquiry', 'Hello sir tapai sanga lahare aap ko plant xa ki nai?? Vaye dekhi add garnus na, I want to buy it.', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_discount`
--

CREATE TABLE `t_discount` (
  `disc_id` int NOT NULL,
  `disc_day` varchar(50) NOT NULL,
  `disc_amt` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_discount`
--

INSERT INTO `t_discount` (`disc_id`, `disc_day`, `disc_amt`) VALUES
(1, 'Sunday', 50),
(2, 'Monday', 0),
(3, 'Tuesday', 10),
(4, 'Wednesday', 20),
(5, 'Thursday', 50),
(6, 'Friday', 50),
(7, 'Saturday', 10);

-- --------------------------------------------------------

--
-- Table structure for table `t_main_category`
--

CREATE TABLE `t_main_category` (
  `m_cat_id` int NOT NULL,
  `m_cat_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_main_category`
--

INSERT INTO `t_main_category` (`m_cat_id`, `m_cat_name`) VALUES
(1, 'Fruits'),
(2, 'Vegetables'),
(3, 'Herbs'),
(4, 'Flowers'),
(5, 'Seeds');

-- --------------------------------------------------------

--
-- Table structure for table `t_order`
--

CREATE TABLE `t_order` (
  `o_id` int NOT NULL,
  `o_datetime` datetime NOT NULL,
  `cust_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_order`
--

INSERT INTO `t_order` (`o_id`, `o_datetime`, `cust_id`) VALUES
(1692973315, '2023-08-25 20:06:55', 1),
(1692973361, '2023-08-25 20:07:41', 1),
(1692973596, '2023-08-25 20:11:36', 4);

-- --------------------------------------------------------

--
-- Table structure for table `t_order_item`
--

CREATE TABLE `t_order_item` (
  `o_item_id` int NOT NULL,
  `o_item_qty` int NOT NULL,
  `o_item_price` int NOT NULL,
  `o_item_disc` int NOT NULL,
  `o_item_shipping` int NOT NULL,
  `is_delivered` int NOT NULL DEFAULT '0',
  `delivery_date` date DEFAULT NULL,
  `p_id` int DEFAULT NULL,
  `o_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_order_item`
--

INSERT INTO `t_order_item` (`o_item_id`, `o_item_qty`, `o_item_price`, `o_item_disc`, `o_item_shipping`, `is_delivered`, `delivery_date`, `p_id`, `o_id`) VALUES
(1, 3, 600, 150, 200, 1, '2023-08-25', 1, 1692973315),
(2, 1, 150, 50, 200, -1, NULL, 9, 1692973315),
(3, 1, 550, 50, 200, 1, '2023-08-25', 4, 1692973315),
(4, 1, 440, 50, 200, 0, NULL, 16, 1692973361),
(5, 1, 460, 50, 200, 0, NULL, 13, 1692973361),
(6, 2, 700, 100, 200, 1, '2023-08-25', 3, 1692973596),
(7, 1, 570, 50, 200, 1, '2023-08-25', 2, 1692973596);

-- --------------------------------------------------------

--
-- Table structure for table `t_product`
--

CREATE TABLE `t_product` (
  `p_id` int NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_price` int NOT NULL,
  `p_available_qty` int NOT NULL,
  `p_featured_photo` varchar(255) NOT NULL,
  `p_description` text NOT NULL,
  `m_cat_id` int NOT NULL,
  `s_cat_id` int DEFAULT NULL,
  `p_is_featured` int NOT NULL,
  `p_is_active` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_product`
--

INSERT INTO `t_product` (`p_id`, `p_name`, `p_price`, `p_available_qty`, `p_featured_photo`, `p_description`, `m_cat_id`, `s_cat_id`, `p_is_featured`, `p_is_active`) VALUES
(1, 'Orange Plant', 600, 13, 'product-featured-1.png', '<p>The orange, a vibrant and juicy citrus fruit, is beloved worldwide for its delightful sweetness and tanginess. With its bright orange hue and refreshing aroma, the orange is not only a feast for the senses but also a nutritional powerhouse. Originating in Southeast Asia, oranges are now grown in various tropical and subtropical regions. Packed with vitamin C, fiber, and various antioxidants, oranges offer a range of health benefits. Whether enjoyed fresh, squeezed into juice, or used as a versatile ingredient in both sweet and savory dishes, the orange remains an iconic and invigorating fruit that embodies a burst of natural energy and zest.</p>\r\n', 1, NULL, 1, 1),
(2, 'Avocado Plant', 570, 14, 'product-featured-2.png', '<p>The avocado, often referred to as nature&#39;s butter, is a distinctive and creamy fruit known for its rich, nutty flavor and smooth texture. Native to Central and South America, avocados have become a global culinary sensation. Encased in a rough, dark green or black skin, the fruit&#39;s vibrant green flesh is prized for its versatility and nutritional value. Avocados are celebrated for their high content of healthy monounsaturated fats, which contribute to heart health. They also provide essential nutrients like potassium, vitamin K, vitamin E, and folate. Whether spread on toast, blended into guacamole, or added to salads and various dishes, avocados offer a delectable way to enhance both flavor and nutrition in a wide range of meals.</p>\r\n', 1, NULL, 1, 1),
(3, 'Kiwi Plant', 700, 9, 'product-featured-3.png', '<p>The kiwi fruit, also known simply as &quot;kiwi,&quot; is a small but captivating fruit originating from China and later cultivated in New Zealand. Its most distinctive feature is its fuzzy, brownish-green exterior, which encases a vibrant, emerald-green flesh speckled with tiny black seeds. The kiwi&#39;s flavor is a delightful combination of sweet and tangy, offering a unique sensory experience. Bursting with nutrients, kiwi is an excellent source of vitamin C, vitamin K, and dietary fiber. Its nutritional profile contributes to immune support, skin health, and digestion. Often eaten peeled and sliced, the kiwi fruit is also a popular addition to fruit salads, smoothies, and desserts due to its refreshing taste and visual appeal.</p>\r\n', 1, NULL, 1, 1),
(4, 'Dragon fruit Plant', 550, 3, 'product-featured-4.png', '<p>Dragon fruit, also known as pitaya, is a striking tropical fruit that captures attention with its vibrant appearance and subtle sweetness. Native to Central America, the dragon fruit&#39;s distinctive feature is its unique outer skin, which can be either bright pink or yellow, adorned with green scales that give it a mystical appearance. Once sliced open, the fruit reveals a white or red flesh speckled with tiny black seeds. The flavor is mild and mildly sweet, reminiscent of a blend between a kiwi and a pear. Dragon fruit is not only visually captivating but also nutritious, containing vitamin C, antioxidants, and dietary fiber. It&#39;s often enjoyed fresh, either scooped out with a spoon or added to fruit salads and smoothie bowls, adding both flavor and an exotic touch to culinary creations.</p>\r\n', 1, NULL, 0, 1),
(5, 'Strawberry Plant', 360, 3, 'product-featured-5.png', '<p>The strawberry, a symbol of sweetness and summertime, is a luscious and aromatic berry cherished for its rich red color, juicy texture, and delightful flavor. Originating from various parts of the world, strawberries are now widely cultivated. Their heart-shaped appearance and tiny seeds on the surface add to their visual charm. Strawberries are not only a treat for the taste buds but also a nutritional gem, packed with vitamin C, antioxidants, and dietary fiber. Whether enjoyed fresh on their own, mixed into desserts, or added to salads, strawberries offer a burst of natural sweetness that captures the essence of sunny days and indulgence.</p>\r\n', 1, NULL, 0, 1),
(6, 'Persimmon Plant', 660, 9, 'product-featured-6.png', '<p>The persimmon, a captivating fruit with a warm and rich hue, is celebrated for its sweet and flavorful taste. Originating from East Asia, this fruit comes in several varieties, with two main types being the astringent and non-astringent persimmons. The astringent type must be fully ripe to be enjoyed, while the non-astringent type can be eaten while still firm. The persimmon&#39;s smooth skin encases a tender, often orange or reddish flesh that ranges from honey-like sweetness to a subtle tanginess, depending on the variety. Rich in vitamins A and C, as well as dietary fiber, persimmons offer both a delectable treat and nutritional benefits. They are commonly eaten fresh, added to salads, or incorporated into baked goods and desserts, embodying a balance between natural sweetness and versatility.</p>\r\n', 1, NULL, 0, 1),
(7, 'Sichuan Pepper', 480, 2, 'product-featured-7.png', '<p>Sichuan pepper, also known as Szechuan pepper or Chinese pepper, is a distinctive spice originating from the Sichuan province of China. Despite its name, it&#39;s not a true pepper but rather the dried husks of berries from the prickly ash tree. Renowned for its unique flavor profile, Sichuan pepper offers a tingling and numbing sensation on the tongue, which is often accompanied by a citrusy and slightly spicy taste. This sensation is due to the presence of hydroxy-alpha-sanshool compounds.&nbsp;</p>\r\n\r\n<p>Used extensively in Sichuan cuisine, this spice adds a distinct dimension to dishes, creating a balance between heat, numbing, and citrusy notes. It&#39;s a key ingredient in famous dishes like mapo tofu and kung pao chicken. Apart from its culinary use, Sichuan pepper has been appreciated for its potential digestive and medicinal properties in traditional Chinese medicine. With its ability to transform flavors and evoke a unique sensory experience, Sichuan pepper is an essential component of the rich tapestry of Asian cuisine.</p>\r\n', 3, NULL, 0, 1),
(8, 'Stevia Plant', 300, 10, 'product-featured-8.png', '<p>Stevia, a natural sweetener derived from the leaves of the Stevia rebaudiana plant, has gained popularity as a sugar substitute due to its intense sweetness without the calories and carbohydrates found in traditional sugars. Native to South America, particularly Paraguay and Brazil, stevia has been used for centuries by indigenous communities to sweeten beverages and foods.&nbsp;</p>\r\n\r\n<p>The sweetness of stevia comes from its natural compounds called steviol glycosides, which can be up to 300 times sweeter than sucrose (table sugar). Despite its potency, stevia has a minimal impact on blood sugar levels, making it a preferred choice for people looking to manage their sugar intake, including those with diabetes.&nbsp;</p>\r\n', 3, NULL, 0, 1),
(9, 'Red crown of thorns', 150, 32, 'product-featured-9.png', '<p>The red crown of thorns (Euphorbia milii), a resilient and striking succulent plant, is known for its vibrant blossoms and distinctive appearance. Native to Madagascar, this plant features fleshy, spiky stems and leaves, which add to its unique visual charm. The &quot;crown of thorns&quot; moniker comes from the long, sharp thorns that grow along the stems.</p>\r\n\r\n<p>The plant&#39;s main attraction is its clusters of small, colorful flowers that come in various shades, with red being one of the most common. These flowers are surrounded by colorful bracts, which are modified leaves that often steal the show with their intense hues. Despite its delicate appearance, the red crown of thorns is surprisingly hardy and can thrive in challenging conditions, making it a popular choice for indoor and outdoor gardens.</p>\r\n', 4, NULL, 0, 1),
(10, 'Indian Plum', 600, 0, 'product-featured-10.png', '<p>The Indian plum, scientifically known as Flacourtia indica, is a fruit-bearing tree native to regions of Asia, including the Indian subcontinent. Also referred to as Governor&#39;s Plum or Ramontchi, this tree produces small, spherical fruits that are known for their tart and slightly sweet flavor. The fruits are usually about the size of a cherry and range in color from green to red as they ripen.</p>\r\n\r\n<p>The Indian plum tree is appreciated for its hardiness and ability to thrive in various soil types. Its fruits are often used to make jams, jellies, and beverages due to their unique taste. Additionally, the tree has traditional medicinal uses in various cultures, with parts of the plant used for their potential health benefits.</p>\r\n', 1, NULL, 0, 1),
(11, 'Pipal Plant', 440, 1, 'product-featured-11.png', '<p>The pipal plant, scientifically known as Ficus religiosa, holds deep spiritual and cultural significance in many Asian societies. Also known as the sacred fig or bodhi tree, this deciduous tree is revered for its association with spiritual enlightenment. According to tradition, it was under a pipal tree that Siddhartha Gautama, the historical Buddha, attained enlightenment.</p>\r\n\r\n<p>The pipal tree has distinctive heart-shaped leaves that rustle in the wind, creating a soothing ambiance. It has a widespread canopy that provides ample shade, making it a natural gathering place for meditation and reflection. In addition to its spiritual importance, the pipal tree is valued for its ecological contributions, including its role in supporting diverse ecosystems and acting as a habitat for various organisms.</p>\r\n', 3, NULL, 0, 1),
(12, 'Silverberry Plant', 390, 2, 'product-featured-12.png', '<p>Silverberry fruit, also known as silver buffaloberry or Shepherdia argentea, is a small yet notable fruit-bearing shrub native to North America. The fruit derives its name from the silvery appearance of its leaves and the pale hue of the berries.</p>\r\n\r\n<p>The silverberry fruit typically grows in clusters and is oval in shape, with a dusty, silvery coating that gives it a distinctive appearance. The berries are small and often slightly tart, but they are rich in nutrients, including vitamins, antioxidants, and essential fatty acids.</p>\r\n', 1, NULL, 0, 1),
(13, 'Rosemary Plant', 460, 4, 'product-featured-13.png', '<p>The rosemary plant, with its fragrant needle-like leaves and aromatic presence, is a cherished herb widely recognized for its culinary, medicinal, and ornamental uses. Native to the Mediterranean region, rosemary (Rosmarinus officinalis) is an evergreen shrub that exudes a distinct earthy and pine-like fragrance.</p>\r\n\r\n<p>Rosemary&#39;s culinary versatility is showcased in various cuisines, where its leaves are used to enhance the flavors of meats, roasted vegetables, and sauces. Beyond the kitchen, rosemary has been valued for its potential health benefits, including antioxidant properties and memory-enhancing effects.</p>\r\n\r\n<p>In addition to its practical uses, rosemary&#39;s attractive appearance and invigorating scent make it a popular choice for ornamental landscaping and gardening. It&#39;s often cultivated in gardens or as potted plants, and its blue flowers add a touch of color to its green foliage.</p>\r\n', 3, NULL, 0, 1),
(15, 'Ashwagandha Plant', 700, 8, 'product-featured-15.png', '<p>The ashwagandha plant, scientifically known as Withania somnifera, is a revered herb in traditional Ayurvedic medicine and is gaining recognition for its potential health benefits worldwide. Also referred to as Indian ginseng or winter cherry, ashwagandha is native to India and some parts of Africa.</p>\r\n\r\n<p>The plant features small greenish-yellow flowers and produces small, orange-red berries. However, it&#39;s the root of the ashwagandha plant that is most valued for its medicinal properties. Ashwagandha has been used traditionally to help manage stress, boost energy, and enhance overall well-being. It is classified as an adaptogen, believed to help the body adapt to various stressors.</p>\r\n', 3, NULL, 0, 1),
(16, 'Asparagus Plant', 440, 1, 'product-featured-16.png', '<p>The asparagus plant (Asparagus officinalis) is a perennial flowering plant renowned for its tender, edible shoots. Native to Europe, North Africa, and Western Asia, it is now cultivated globally for its culinary and nutritional value. Asparagus spears emerge from the ground in spring, characterized by their vibrant green color and tightly closed tips. These spears are typically harvested when they reach a height of 6 to 8 inches. Asparagus is prized for its delicate flavor and is often enjoyed grilled, roasted, saut&eacute;ed, or steamed. Beyond its culinary appeal, asparagus is a low-calorie vegetable rich in nutrients like folate, vitamin K, and fiber. It is also known for its historical medicinal uses and is celebrated as a nutritious addition to a balanced diet.</p>\r\n', 2, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_product_photo`
--

CREATE TABLE `t_product_photo` (
  `p_photo_id` int NOT NULL,
  `photo` varchar(255) NOT NULL,
  `p_id` int NOT NULL,
  `p_box_no` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_product_photo`
--

INSERT INTO `t_product_photo` (`p_photo_id`, `photo`, `p_id`, `p_box_no`) VALUES
(30, '30.jpg', 1, 1),
(31, '31.jpg', 1, 2),
(32, '32.jpg', 1, 3),
(34, '34.jpg', 1, 4),
(35, '35.jpg', 2, 1),
(38, '38.jpg', 2, 4),
(39, '39.webp', 2, 2),
(40, '40.jpg', 2, 3),
(41, '41.webp', 3, 1),
(42, '42.webp', 3, 2),
(43, '43.webp', 3, 3),
(44, '44.webp', 4, 1),
(45, '45.jpg', 4, 2),
(46, '46.jpg', 4, 3),
(47, '47.webp', 4, 4),
(48, '48.jpg', 5, 1),
(49, '49.webp', 5, 2),
(50, '50.jpg', 5, 3),
(51, '51.webp', 6, 1),
(52, '52.webp', 6, 2),
(53, '53.jpg', 6, 3),
(54, '54.jpg', 6, 4),
(55, '55.webp', 7, 1),
(56, '56.webp', 7, 2),
(57, '57.webp', 7, 3),
(58, '58.webp', 7, 4),
(59, '59.jpg', 8, 1),
(60, '60.webp', 8, 2),
(61, '61.webp', 8, 3),
(62, '62.webp', 9, 1),
(63, '63.jpg', 9, 2),
(64, '64.webp', 9, 3),
(65, '65.jpg', 10, 1),
(66, '66.jpg', 10, 2),
(67, '67.jpg', 10, 3),
(68, '68.webp', 11, 1),
(69, '69.jpg', 11, 2),
(70, '70.jpg', 11, 3),
(71, '71.jpg', 12, 1),
(72, '72.webp', 12, 2),
(73, '73.webp', 12, 3),
(74, '74.jpg', 13, 1),
(75, '75.jpg', 13, 2),
(76, '76.jpg', 15, 1),
(77, '77.jpg', 15, 2),
(78, '78.jpg', 15, 3),
(79, '79.jpg', 16, 1),
(80, '80.webp', 16, 2),
(81, '81.jpg', 16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `t_shipping`
--

CREATE TABLE `t_shipping` (
  `id` int NOT NULL,
  `s_fee_amt` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_shipping`
--

INSERT INTO `t_shipping` (`id`, `s_fee_amt`) VALUES
(1, 200);

-- --------------------------------------------------------

--
-- Table structure for table `t_sub_category`
--

CREATE TABLE `t_sub_category` (
  `s_cat_id` int NOT NULL,
  `s_cat_name` varchar(50) NOT NULL,
  `m_cat_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_sub_category`
--

INSERT INTO `t_sub_category` (`s_cat_id`, `s_cat_name`, `m_cat_id`) VALUES
(1, 'Potato', 5),
(2, 'Paddy', 5),
(3, 'Maize', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `t_customer`
--
ALTER TABLE `t_customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `t_cust_message`
--
ALTER TABLE `t_cust_message`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `t_discount`
--
ALTER TABLE `t_discount`
  ADD PRIMARY KEY (`disc_id`);

--
-- Indexes for table `t_main_category`
--
ALTER TABLE `t_main_category`
  ADD PRIMARY KEY (`m_cat_id`);

--
-- Indexes for table `t_order`
--
ALTER TABLE `t_order`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `t_order_item`
--
ALTER TABLE `t_order_item`
  ADD PRIMARY KEY (`o_item_id`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `t_order_item_ibfk_2` (`o_id`);

--
-- Indexes for table `t_product`
--
ALTER TABLE `t_product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `t_product_photo`
--
ALTER TABLE `t_product_photo`
  ADD PRIMARY KEY (`p_photo_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `t_shipping`
--
ALTER TABLE `t_shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_sub_category`
--
ALTER TABLE `t_sub_category`
  ADD PRIMARY KEY (`s_cat_id`),
  ADD KEY `m_cat_id` (`m_cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `cust_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_cust_message`
--
ALTER TABLE `t_cust_message`
  MODIFY `msg_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_main_category`
--
ALTER TABLE `t_main_category`
  MODIFY `m_cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `t_order_item`
--
ALTER TABLE `t_order_item`
  MODIFY `o_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_product`
--
ALTER TABLE `t_product`
  MODIFY `p_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `t_product_photo`
--
ALTER TABLE `t_product_photo`
  MODIFY `p_photo_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `t_sub_category`
--
ALTER TABLE `t_sub_category`
  MODIFY `s_cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_cust_message`
--
ALTER TABLE `t_cust_message`
  ADD CONSTRAINT `t_cust_message_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `t_customer` (`cust_id`) ON DELETE CASCADE;

--
-- Constraints for table `t_order`
--
ALTER TABLE `t_order`
  ADD CONSTRAINT `t_order_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `t_customer` (`cust_id`) ON DELETE CASCADE;

--
-- Constraints for table `t_order_item`
--
ALTER TABLE `t_order_item`
  ADD CONSTRAINT `t_order_item_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `t_product` (`p_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `t_order_item_ibfk_2` FOREIGN KEY (`o_id`) REFERENCES `t_order` (`o_id`) ON DELETE CASCADE;

--
-- Constraints for table `t_product_photo`
--
ALTER TABLE `t_product_photo`
  ADD CONSTRAINT `t_product_photo_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `t_product` (`p_id`) ON DELETE CASCADE;

--
-- Constraints for table `t_sub_category`
--
ALTER TABLE `t_sub_category`
  ADD CONSTRAINT `t_sub_category_ibfk_1` FOREIGN KEY (`m_cat_id`) REFERENCES `t_main_category` (`m_cat_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
