-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.byetcluster.com
-- Generation Time: May 25, 2025 at 02:34 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38984964_adidas`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Footwear'),
(2, 'Clothing'),
(3, 'Slides'),
(4, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `shipping_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_status` enum('Pending','Rejected','Confirmed','In Progress','Shipping','Delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `total_price`, `payment_method`, `order_date`, `shipping_address`, `order_status`, `phone_number`) VALUES
(1, 2, '80.00', 'Cash on Delivery', '2025-05-21 15:31:29', 'beirut', 'Delivered', '71527930'),
(2, 3, '355.00', 'Cash on Delivery', '2025-05-21 16:12:49', 'Beirut', 'In Progress', '76553846'),
(3, 3, '265.00', 'Cash on Delivery', '2025-05-21 16:15:10', 'Beirut', 'Confirmed', '76553846'),
(4, 4, '160.00', 'Cash on Delivery', '2025-05-22 09:24:54', '109 passage des alouettes', 'Delivered', '+33644042555'),
(5, 4, '55.00', 'Cash on Delivery', '2025-05-22 09:28:40', 'Abou ta3am bldg, St therese', 'Confirmed', '+33 6 56 83 59 22'),
(6, 5, '690.00', 'Cash on Delivery', '2025-05-22 09:32:00', 'Haret hreik dakash street', 'Confirmed', '70804851'),
(7, 7, '235.00', 'Cash on Delivery', '2025-05-22 09:36:23', 'beirut, hay el american, facing supermarket ezzeddine', 'Confirmed', '70664106'),
(8, 8, '394.00', 'Cash on Delivery', '2025-05-22 09:37:08', 'Tyre lebanon', 'Confirmed', '123456'),
(9, 6, '857.00', 'Cash on Delivery', '2025-05-22 09:39:46', 'jamous street delfa building floor 6.5', 'Confirmed', '76677539'),
(10, 3, '70.00', 'Cash on Delivery', '2025-05-23 09:34:30', 'beirut', 'Confirmed', '76553846'),
(11, 3, '26.00', 'Cash on Delivery', '2025-05-24 08:30:48', 'Beirut', 'Confirmed', '76553846'),
(12, 3, '240.00', 'Cash on Delivery', '2025-05-25 02:36:15', 'Beirut', 'Confirmed', '76553846');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `variant_id`, `quantity`, `unit_price`) VALUES
(1, 1, 80, 1, '80.00'),
(2, 2, 111, 1, '95.00'),
(3, 2, 139, 1, '140.00'),
(4, 2, 178, 1, '120.00'),
(5, 3, 94, 1, '90.00'),
(6, 3, 20, 1, '35.00'),
(7, 3, 49, 2, '70.00'),
(8, 4, 62, 2, '80.00'),
(9, 5, 327, 1, '28.00'),
(10, 5, 7, 1, '27.00'),
(11, 6, 142, 1, '90.00'),
(12, 6, 256, 1, '120.00'),
(13, 6, 63, 1, '80.00'),
(14, 6, 239, 2, '200.00'),
(15, 7, 50, 1, '70.00'),
(16, 7, 89, 1, '80.00'),
(17, 7, 320, 1, '85.00'),
(18, 8, 63, 2, '80.00'),
(19, 8, 237, 1, '200.00'),
(20, 8, 13, 2, '17.00'),
(21, 9, 13, 1, '17.00'),
(22, 9, 61, 1, '80.00'),
(23, 9, 173, 1, '120.00'),
(24, 9, 269, 1, '120.00'),
(25, 9, 131, 1, '120.00'),
(26, 9, 255, 1, '120.00'),
(27, 9, 135, 1, '120.00'),
(28, 9, 157, 1, '80.00'),
(29, 9, 323, 1, '80.00'),
(30, 10, 48, 1, '70.00'),
(31, 11, 44, 1, '26.00'),
(32, 12, 74, 1, '80.00'),
(33, 12, 236, 1, '160.00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_on_promotion` tinyint(1) DEFAULT 0,
  `promotion_price` decimal(10,2) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `description`, `image_1`, `price`, `category_id`, `is_on_promotion`, `promotion_price`, `is_deleted`) VALUES
(1, 'Adilette', 'Step into comfort with the iconic Adilette slide. Featuring a clean white base with signature blue 3-Stripes, this lightweight slide is perfect for casual wear, post-workout relaxation, or poolside style. Durable, easy to slip on, and effortlessly classic.', '1747862205_Adilette.png', '25.00', 3, 0, NULL, 0),
(2, 'Adilette Comfort - Black', 'Make a bold statement with the Adilette Comfort Slide in classic black. Featuring a contoured footbed and soft cushioning, these slides offer all-day comfort with standout adidas branding. Perfect for casual wear, lounging, or post-workout recovery.', '1747864659_Adilette1.png', '27.00', 3, 0, NULL, 0),
(3, 'Adilette Shower ', 'Sleek and sporty, the Adilette Shower Slide combines classic adidas style with quick-drying comfort. Featuring bold 3-Stripes and a soft Cloudfoam footbed, itâ€™s perfect for post-training recovery, poolside vibes, or everyday casual wear.', '1747864791_Adilette2.png', '25.00', 3, 1, '17.00', 0),
(4, 'Adilette22 - Beige', 'Inspired by futuristic design and crafted for everyday comfort, the Adilette 22 Slide in beige features a sculpted, 3D-printed look with eco-conscious materials. Lightweight, cushioned, and boldâ€”this slide is built for standout style and all-day wear.', '1747864976_Adilette22(1).png', '35.00', 3, 0, NULL, 0),
(5, 'Adilette22 - White', 'Inspired by futuristic design and crafted for everyday comfort, the Adilette 22 Slide in white features a sculpted, 3D-printed look with eco-conscious materials. Lightweight, cushioned, and boldâ€”this slide is built for standout style and all-day wear.', '1747865065_Adilette22.png', '35.00', 3, 0, NULL, 0),
(6, 'Adilette Aqua - Pink', 'Fresh, clean, and easy to wear, the Adilette Aqua Slide in soft pink offers quick-drying comfort with a single-piece molded design. Perfect for the shower, pool, or laid-back days, it combines lightweight cushioning with minimalist adidas style.', '1747865186_AdiletteAqua.png', '25.00', 3, 0, NULL, 0),
(7, 'Adilette Ayoon - Beige', 'Boldly sculpted and ultra-plush, the Adilette Ayoon Slide in beige redefines comfort with its oversized profile and cushioned one-piece design. Featuring embossed 3-Stripes and a soft footbed, itâ€™s the perfect blend of minimalism and standout style.', '1747865297_AdiletteAyoon.png', '30.00', 3, 0, NULL, 0),
(8, 'Adilette Ayoon - Black', 'Boldly sculpted and ultra-plush, the Adilette Ayoon Slide in black redefines comfort with its oversized profile and cushioned one-piece design. Featuring embossed 3-Stripes and a soft footbed, itâ€™s the perfect blend of minimalism and standout style.', '1747865394_AdiletteAyoon2.png', '30.00', 3, 0, NULL, 0),
(9, 'Adilette Clogs', 'Designed for versatility and comfort, the Adilette Clog blends the iconic adidas look with a breathable, slip-on design. Featuring perforations for airflow and a durable molded build, it\'s perfect for everyday wear, from lounging to light outdoor use.', '1747865490_AdiletteClogs.png', '40.00', 3, 1, '26.00', 0),
(10, 'Adilette Essential', 'Elevate your everyday comfort with the Adilette Essential Slide. Wrapped in a soft textile upper with tonal Trefoil adidas patterns, this sleek black slide delivers cushioned support and subtle style. Ideal for casual days, lounging, or travel.', '1747865583_AdiletteEssential.png', '70.00', 3, 0, NULL, 0),
(11, 'Adilette Platform', 'Take your casual style to new heights with the Adilette Platform Slide. Featuring a bold stacked sole, cushioned footbed, and iconic 3-Stripes strap, this elevated slide delivers comfort and confidence with every step.', '1747865678_AdilettePlatform.png', '75.00', 3, 0, NULL, 0),
(12, 'Campus00s - Green', 'A bold revival of early 2000s street style, the Campus 00s in green brings a fresh twist to a classic silhouette. Featuring premium suede, oversized 3-Stripes, and a retro-inspired chunky sole, this sneaker blends nostalgia with everyday comfort.', '1747865890_Campus00s.png', '80.00', 1, 0, NULL, 0),
(13, 'Campus00s - Black', 'A bold revival of early 2000s street style, the Campus 00s in black brings a fresh twist to a classic silhouette. Featuring premium suede, oversized 3-Stripes, and a retro-inspired chunky sole, this sneaker blends nostalgia with everyday comfort.', '1747865968_Campus00s1.png', '80.00', 1, 0, NULL, 0),
(14, 'Campus00s - Gray', 'A bold revival of early 2000s street style, the Campus 00s in gray brings a fresh twist to a classic silhouette. Featuring premium suede, oversized 3-Stripes, and a retro-inspired chunky sole, this sneaker blends nostalgia with everyday comfort.', '1747866025_Campus00s2.png', '80.00', 1, 0, NULL, 0),
(15, 'Campus00s - Beige', 'A bold revival of early 2000s street style, the Campus 00s in beige brings a fresh twist to a classic silhouette. Featuring premium suede, oversized 3-Stripes, and a retro-inspired chunky sole, this sneaker blends nostalgia with everyday comfort.', '1747866088_Campus00s3.png', '80.00', 1, 0, NULL, 0),
(16, 'Campus00s - Purple', 'A bold revival of early 2000s street style, the Campus 00s in purple brings a fresh twist to a classic silhouette. Featuring premium suede, oversized 3-Stripes, and a retro-inspired chunky sole, this sneaker blends nostalgia with everyday comfort.', '1747866160_Campus00s4.png', '80.00', 1, 0, NULL, 0),
(17, 'Campus00s - Red', 'A bold revival of early 2000s street style, the Campus 00s in red brings a fresh twist to a classic silhouette. Featuring premium suede, oversized 3-Stripes, and a retro-inspired chunky sole, this sneaker blends nostalgia with everyday comfort.', '1747866195_Campus00s5.png', '80.00', 1, 0, NULL, 0),
(18, 'Forum Low - Emerald Green', 'A timeless classic reborn, the Forum Low blends vintage hoops style with modern flair. Featuring a crisp white leather upper, bold green accents, and the signature ankle strap, this silhouette delivers standout looks and everyday comfort.', '1747866306_ForumLow.png', '90.00', 1, 0, NULL, 0),
(19, 'Forum Low CL - Pastel Blue', 'A fresh take on a court legend, the Forum Low CL features a soft leather upper with pastel blue accents and gold adidas branding. With its low-cut silhouette, cushioned sole, and heritage-inspired design, itâ€™s the perfect mix of retro and refined.', '1747866394_ForumLowCL.png', '95.00', 1, 0, NULL, 0),
(20, 'Forum Low CL - Triple White', 'Understated and iconic, the Forum Low CL in triple white delivers a clean, minimalist look with vintage basketball roots. Crafted with smooth leather and tonal detailing, it\'s a versatile essential that blends effortlessly with any outfit.', '1747866606_ForumLowCL1.png', '95.00', 1, 0, NULL, 0),
(21, 'Forum Low CL â€“ Burgundy', 'Blending retro charm with modern flair, the Forum Low CL in white and burgundy stands out with rich suede 3-Stripes and gold adidas branding. The cushioned sole and classic silhouette make it an everyday essential with timeless style.', '1747867107_ForumLowCL2.png', '95.00', 1, 0, NULL, 0),
(22, 'Forum Low CL â€“ Green', 'Classic court DNA meets vibrant flair in the Forum Low CL. With a crisp white leather base, bright green suede accents, and tonal adidas branding, this sneaker delivers retro sport style reimagined for everyday wear.', '1747867290_ForumLowCL3.png', '95.00', 1, 0, NULL, 0),
(23, 'Forum Low CL â€“ Blush Pink', 'Soft and stylish, the Forum Low CL in white and blush pink pairs vintage basketball aesthetics with a delicate modern twist. Featuring premium leather, pastel accents, and signature adidas details, it\'s a feminine take on a timeless classic.', '1747867391_ForumLowCL4.png', '95.00', 1, 0, NULL, 0),
(24, 'Ozelia â€“ Triple White', 'Futuristic and bold, the adidas Ozelia in triple white features sculpted lines, reflective accents, and a sleek silhouette. Built with Adiprene cushioning for all-day comfort, this sneaker merges retro vibes with a space-age aesthetic.', '1747867470_Ozelia.png', '120.00', 1, 0, NULL, 0),
(25, 'Ozelia â€“ Neon Green', 'Make a statement in motion with the adidas Ozelia. Featuring a dynamic blend of futuristic design, bold neon green stripes, and plush Adiprene cushioning, this sneaker is built for standout comfort and street-ready energy.', '1747867594_Ozelia1.png', '120.00', 1, 0, NULL, 0),
(26, 'Ozweego â€“ Beige', 'The adidas Ozweego in beige brings together retro \'90s vibes and futuristic design. With a sculpted sole, layered upper, and ultra-soft cushioning, this sneaker delivers bold style and next-level comfort for everyday wear.', '1747867776_Ozweego.png', '140.00', 1, 1, '90.00', 0),
(27, 'Ozweego - Cream', 'The adidas Ozweego in cream brings a fresh, breathable feel with its mesh upper and sleek black 3-Stripes. Designed for comfort and style, its distinctive silhouette and Adiprene cushioning make it a standout choice for daily wear.', '1747867905_Ozweego1.png', '140.00', 1, 0, NULL, 0),
(28, 'Pureboost 23 â€“ Mauve', 'Engineered for everyday runs, the adidas Pureboost 23 in mauve features a breathable mesh upper and full-length Boost midsole for responsive energy return. Lightweight, stylish, and built for comfort, itâ€™s your go-to trainer from street to track.', '1747867995_Pureboost23.png', '130.00', 1, 1, '100.00', 0),
(29, 'Runfalcon â€“ White', 'Lightweight and versatile, the adidas Runfalcon in white with teal accents is built for both daily runs and casual wear. With a breathable mesh upper and supportive cushioning, it delivers comfort and style in every stride.', '1747868112_Runfalcon.png', '100.00', 1, 1, '80.00', 0),
(30, 'Terrex Trail Rider â€“ Orange', 'Conquer the trail with the adidas Terrex Trail Rider. Built for off-road performance, it features a lightweight mesh upper, responsive cushioning, and a rugged outsole for superior grip. Whether hiking or trail running, it delivers comfort, control, and durability.', '1747868289_RunningTerrexTrailRider.png', '160.00', 1, 0, NULL, 0),
(31, 'Samba OG â€“ White', 'An icon reborn, the adidas Samba OG combines vintage football heritage with timeless street style. Featuring a smooth leather upper, suede toe cap, and gum rubber outsole, it\'s a classic silhouette that never goes out of fashion.', '1747868404_SambaOgShoes.png', '120.00', 1, 0, NULL, 0),
(32, 'Samba OG - Green', 'Classic with a twist, the adidas Samba OG in white and green stays true to its roots with a smooth leather upper, suede toe overlay, and iconic gum rubber sole. A fresh color update for a silhouette that defines timeless style.', '1747868565_SambaOgShoes1.png', '120.00', 1, 0, NULL, 0),
(33, 'Samba OG - Burgundy', 'Sporting a rich burgundy twist on a timeless icon, the Samba OG features a full-grain leather upper, suede toe cap, and gum rubber outsole. A streetwear essential that fuses heritage football design with bold everyday style.', '1747868681_SambaOgShoes2.png', '120.00', 1, 0, NULL, 0),
(34, 'Samba OG â€“ Triple White', 'Minimalist and timeless, the Samba OG in triple white features a sleek leather upper with subtle detailing and a classic gum sole. A clean, versatile take on an adidas legend, perfect for effortless everyday style.', '1747868782_SambaOgShoes3.png', '120.00', 1, 0, NULL, 0),
(35, 'Stan Smith â€“ Green', 'A timeless icon, the adidas Stan Smith in white and green pairs clean lines with effortless style. Featuring a smooth synthetic upper, perforated 3-Stripes, and the signature green heel tab, itâ€™s a staple for classic and sustainable everyday looks.', '1747868874_StanSmith.png', '100.00', 1, 0, NULL, 0),
(36, 'Stan Smith - White', 'Clean, crisp, and endlessly versatile, the Stan Smith in triple white delivers minimalist style with iconic adidas heritage. Featuring a smooth synthetic upper and perforated 3-Stripes, itâ€™s a timeless classic made for modern wardrobes.', '1747868984_StanSmith3.png', '100.00', 1, 0, NULL, 0),
(37, 'Stan Smith - Black', 'Effortlessly sleek, the Stan Smith in triple black offers a bold monochrome look with timeless appeal. Crafted with a smooth synthetic upper and subtle perforated 3-Stripes, itâ€™s a minimalist essential that pairs with anything.', '1747895669_StanSmith2.png', '100.00', 1, 0, NULL, 0),
(38, 'Supernova Rise', 'Designed for comfort and performance, the adidas Supernova Rise features Dreamstrike+ foam for responsive cushioning and a breathable engineered mesh upper. The supportive heel and bold gradient midsole make this a go-to for both casual runners and serious training.', '1747895944_SupernovaRise.png', '240.00', 1, 1, '180.00', 0),
(39, 'Superstar - Black Stripes', 'A true icon since the \'70s, the adidas Superstar features its signature shell toe, smooth leather upper, and bold black 3-Stripes. Timeless and versatile, it\'s the sneaker that blends heritage sport style with everyday streetwear appeal.', '1747896096_superStar.png', '100.00', 1, 0, NULL, 0),
(40, 'Superstar - Black', 'Bold and unmistakable, the adidas Superstar in black with white stripes brings iconic shell-toe heritage with a fresh edge. Crafted in smooth leather with gold branding and contrasting details, it\'s a streetwear staple built to stand out.', '1747896185_superstar1.png', '100.00', 1, 0, NULL, 0),
(41, 'Superstar - White', 'Bold and unmistakable, the adidas Superstar in white brings iconic shell-toe heritage with a fresh edge. Crafted in smooth leather with gold branding and contrasting details, it\'s a streetwear staple built to stand out.', '1747896548_superstar3.png', '100.00', 1, 0, NULL, 0),
(42, 'Ultra 4DFWD', 'Futuristic innovation meets performance in the adidas Ultra 4DFWD. Featuring a 3D-printed midsole engineered for smooth forward motion and a sock-like Primeknit upper, this sleek all-white runner delivers cutting-edge comfort with bold style.', '1747896786_Ultra4DFWD.png', '200.00', 1, 1, '160.00', 0),
(43, 'Ultraboost 22 COLD.RDY 2.0', 'Built for cold-weather comfort, the Ultraboost 22 COLD.RDY 2.0 combines winter-ready insulation with energy-returning Boost cushioning. Featuring a rugged outsole and sleek beige upper with reflective and neon accents, itâ€™s designed to power your runs through any season.', '1747897013_Ultraboost22COLD.RDY2.0.png', '190.00', 1, 0, NULL, 0),
(44, 'Ultraboost Light', 'Engineered for dynamic comfort, the Ultraboost Light blends responsive Light BOOST cushioning with a breathable Primeknit upper. Its elegant cream tones and gold accents add a refined edge to high-performance running designâ€”perfect for pace and style.', '1747897795_UltraboostLight.png', '220.00', 1, 0, NULL, 0),
(45, 'Three Stripes Joggers', 'Classic adidas style meets all-day comfort. These slim-fit joggers feature the iconic 3-Stripes down the sides, soft fleece fabric, and ankle zips for easy on and off. Ideal for workouts, lounging, or casual streetwear.\r\n\r\n', '1747898297_3stripesjoggers.png', '120.00', 2, 0, NULL, 0),
(46, 'Adicolor 3-Stripes Maxi Dress', 'Sporty meets sleek in this bold maxi dress. Featuring adidasâ€™ signature 3-Stripes down the sides and a slim fit that hugs the body, this dress blends streetwear energy with feminine flair. The side slit and open back add a modern edge to the timeless look.', '1747898414_Adicolor3-StripesMaxiDress.png', '80.00', 2, 1, '55.00', 0),
(47, 'Adicolor Adibreak Track Pants', 'A modern take on a retro classic. These Adibreak pants feature snap-button details and bold 3-Stripes down the sides for an iconic look. The relaxed fit and lightweight fabric offer comfort and throwback style for everyday wear.', '1747898524_adicoloradibreak.png', '100.00', 2, 0, NULL, 0),
(48, 'Adizero Essentials Running Jacket', 'Lightweight and built for speed, this jacket keeps you moving through windy conditions. Featuring moisture-wicking fabric and a streamlined fit, it\'s designed to support your performance while offering a clean, minimal look with the signature adidas logo', '1747898637_AdizeroEssentialsRunning.png', '120.00', 2, 0, NULL, 0),
(49, 'Argentina 2024 Messi Home Jersey', 'Celebrate greatness with the iconic No.10. This official 2024 Argentina home jersey features classic sky blue and white stripes, gold championship details, and Messiâ€™s legendary name and number. Made with breathable AEROREADY fabric for all-day comfortâ€”on and off the pitch.', '1747898782_Argentina24MessiHomeJersey.png', '180.00', 2, 0, NULL, 0),
(58, 'Adicolor Backpack', 'Bold and timeless, the Adicolor Backpack combines iconic adidas style with everyday practicality. Featuring a spacious main compartment, a front zip pocket for essentials, and a padded back panel for comfort, this backpack is perfect for school, gym, or daily outings. The deep burgundy color and signature Trefoil logo deliver an unmistakable Originals look that stands out.', '1747928865_adicolorbackpack.png', '80.00', 4, 0, NULL, 0),
(51, 'Firebird Loose Track Pants', 'A timeless adidas icon reimagined for today. These Firebird track pants feature a relaxed, loose fit and classic shiny tricot fabric for a retro-sporty vibe. Complete with side pockets and signature 3-Stripes for effortless everyday style.', '1747899256_FirebirdLooseTrackPants.png', '120.00', 2, 0, NULL, 0),
(52, 'House of Tiro Nations Pack Tee', 'Celebrate global sport style with this standout tee from the Tiro Nations Pack. Made with soft, breathable fabric and a relaxed fit, it features bold adidas Sportswear branding and contrast 3-Stripes for a look that blends heritage and pride.', '1747899374_HouseofTiroNationsPackTee.png', '60.00', 2, 0, NULL, 0),
(53, 'NY Half-Zip Windbreaker', 'Sporty and statement-making, this windbreaker brings retro energy to your wardrobe. Designed with a relaxed fit and bold adidas Trefoil branding, itâ€™s perfect for layering on breezy days or making an impression on the streets.', '1747899493_NYHalf-ZipWindbreaker.png', '85.00', 2, 1, '60.00', 0),
(54, 'Tennis Cardigan', 'Effortlessly chic with a sporty edge, this tennis-inspired cardigan blends classic preppy style with signature adidas detailing. The soft cream fabric is accented by rich green stripes, while the relaxed fit and front pockets add everyday comfort and charm. Perfect for courtside flair or casual layering.', '1747899582_TennisCardigan.png', '100.00', 2, 0, NULL, 0),
(55, 'Stella McCartney Training Vest', 'Precision meets performance in this sleek, form-fitting training vest designed by Stella McCartney for adidas. Crafted from high-stretch technical fabric, it features a full-zip front, ergonomic seams, and discreet thumbholes for added comfort and control. A modern essential for focused workouts and sophisticated streetwear layering.', '1747899680_TrainingVestStellaMcCartney.png', '180.00', 2, 0, NULL, 0),
(56, 'Trefoil Essentials Shorts', 'A timeless staple with everyday comfort. These adidas Trefoil Essentials Shorts are crafted from soft French terry cotton for a relaxed fit that moves with you. Featuring the subtle Trefoil logo and side pockets, theyâ€™re perfect for casual layering, post-workout comfort, or laid-back weekends.', '1747899803_TrefoilEssentialsShorts.png', '70.00', 2, 0, NULL, 0),
(57, 'Velvet Wide-Leg Joggers', 'Elevate your loungewear with these effortlessly chic velvet wide-leg joggers from adidas. Made with plush, soft-touch fabric and a relaxed fit, they offer both comfort and sophistication. The high-rise waistband and subtle adidas embroidery bring a touch of elegance to your off-duty look â€” perfect for pairing with cropped tops or matching jackets.', '1747899892_velvetjoggers.png', '110.00', 2, 1, '85.00', 0),
(59, 'Adicolor Classic Round Bag', 'Make a statement with the Adicolor Classic Round Bag â€” a retro-inspired accessory with a modern twist. Its unique circular shape and soft pastel purple tone offer a playful yet chic look, while the iconic Trefoil logo brings signature adidas style. Featuring an adjustable shoulder strap and zip closure, itâ€™s ideal for light essentials on casual outings or festivals.', '1747929039_AdicolorClassicRoundBag.png', '50.00', 4, 0, NULL, 0),
(60, 'Adidas Cotton Baseball Cap', 'Add a soft, sporty touch to any outfit with this blush-toned adidas Baseball Cap. Made from comfortable cotton, it features an adjustable strap for a perfect fit and embroidered branding for a classic finish. Whether you\'re heading out for a walk or styling up a casual look, this cap brings effortless flair and sun-ready function.', '1747929370_baseballcap.png', '40.00', 4, 0, NULL, 0),
(61, ' Oceaunz Competition Ball â€“ FIFA Womenâ€™s World Cup 2023', 'Celebrate the spirit of the FIFA Womenâ€™s World Cup 2023 with the adidas Oceaunz Competition Ball. Designed with Speedshell panel technology for enhanced flight stability and adorned with vibrant tournament graphics, this match ball replica combines performance with bold energy. Ideal for training or competitive matches, it\'s your ticket to play like a champion.', '1747929458_oceaunzCompetitionBall.png', '160.00', 4, 0, NULL, 0),
(62, 'Originals Relaxed Strap-Back Hat', 'Classic, casual, and timeless. This adidas strap-back cap features a low-profile silhouette with a curved brim and embroidered Trefoil logo for signature style. The adjustable back strap ensures a custom fit, while the soft cotton build delivers all-day comfortâ€”perfect for any laid-back look.', '1747929684_RelaxedStrapBackHat.png', '40.00', 4, 1, '28.00', 0),
(63, 'Originals Liner Socks', 'Keep it minimal and comfortable with these adidas liner socks. Designed to stay hidden beneath your sneakers, they offer a snug fit with a touch of stretch. Featuring a soft cotton blend and subtle Trefoil branding at the toe, theyâ€™re perfect for everyday wear. Comes in a convenient pack of three pairs.', '1747929817_linersocks.png', '22.00', 4, 0, NULL, 0),
(64, 'Originals Monogram Backpack', 'Make a bold statement with this adidas backpack featuring an allover Trefoil monogram pattern. With a spacious main compartment, front zip pocket, and padded shoulder straps, it\'s as functional as it is stylish. The vivid blue design adds a pop of color to your daily carry, perfect for school, gym, or casual outings.', '1747929936_monogramebackpack.png', '80.00', 4, 0, NULL, 0),
(65, 'Sport Sunglasses SP0020', 'Engineered for performance and style, these adidas sunglasses feature a bold wraparound design and mirrored lenses for maximum coverage and UV protection. The lightweight, durable frame ensures comfort during high-impact sports or daily wear, while the futuristic look adds an edge to any outfit.', '1747930033_SportSunglassesSP0020.png', '90.00', 4, 1, '70.00', 0),
(66, 'Steel Metal Bottle', 'Stay hydrated in style with the adidas Steel Metal Bottle. Crafted from durable stainless steel, this 1-liter bottle is perfect for workouts, commutes, or everyday use. The sleek metallic design features multilingual â€œThree Stripe Lifeâ€ text, coordinates, and the adidas logo â€” combining function with a bold statement.', '1747930310_SteelMetalBottle1L.png', '30.00', 4, 0, NULL, 0),
(67, 'Washed Bucket Hat', 'Keep it casual and iconic with the adidas Washed Bucket Hat. Featuring the classic Trefoil logo embroidered on soft, breathable fabric, this hat brings street-ready style and sun protection to any outfit. The washed finish adds a touch of vintage flair, making it a staple for both sporty and everyday looks.', '1747930369_WashedBucketHat.png', '40.00', 4, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_variant`
--

CREATE TABLE `product_variant` (
  `variant_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_variant`
--

INSERT INTO `product_variant` (`variant_id`, `product_id`, `size`, `stock_quantity`) VALUES
(1, 1, '36', 3),
(2, 1, '37', 4),
(3, 1, '38', 4),
(4, 1, '39', 1),
(5, 1, '40', 5),
(6, 2, '38', 6),
(7, 2, '39', 7),
(8, 2, '40', 4),
(9, 2, '41', 5),
(10, 2, '42', 6),
(11, 3, '36', 4),
(12, 3, '37', 2),
(13, 3, '39', 2),
(14, 4, '38', 5),
(15, 4, '39', 10),
(16, 4, '40', 4),
(17, 4, '41', 7),
(18, 4, '42', 8),
(19, 4, '43', 5),
(20, 5, '37', 4),
(21, 5, '38', 6),
(22, 5, '39', 5),
(23, 5, '40', 1),
(24, 5, '41', 2),
(25, 6, '36', 5),
(26, 6, '37', 4),
(27, 6, '38', 3),
(28, 6, '39', 4),
(29, 6, '40', 2),
(30, 7, '36', 2),
(31, 7, '38', 5),
(32, 7, '39', 4),
(33, 7, '40', 4),
(34, 7, '41', 1),
(35, 7, '42', 2),
(36, 8, '36', 3),
(37, 8, '37', 6),
(38, 8, '38', 10),
(39, 8, '39', 2),
(40, 8, '40', 8),
(41, 8, '41', 6),
(42, 9, '38', 9),
(43, 9, '39', 10),
(44, 9, '40', 7),
(45, 9, '41', 10),
(46, 9, '42', 7),
(47, 10, '36', 5),
(48, 10, '37', 1),
(49, 10, '38', 4),
(50, 10, '39', 0),
(51, 10, '40', 4),
(52, 11, '36', 2),
(53, 11, '37', 5),
(54, 11, '38', 6),
(55, 11, '39', 2),
(56, 12, '36', 5),
(57, 12, '37', 6),
(58, 12, '38', 0),
(59, 12, '39', 4),
(60, 12, '40', 2),
(61, 12, '41', 6),
(62, 12, '42', 3),
(63, 12, '43', 0),
(64, 13, '36', 0),
(65, 13, '37', 2),
(66, 13, '38', 1),
(67, 13, '39', 4),
(68, 13, '40', 3),
(69, 13, '41', 6),
(70, 13, '42', 3),
(71, 14, '36', 4),
(72, 14, '37', 0),
(73, 14, '38', 3),
(74, 14, '39', 3),
(75, 14, '40', 2),
(76, 15, '37', 4),
(77, 15, '38', 2),
(78, 15, '39', 3),
(79, 15, '40', 7),
(80, 15, '41', 5),
(81, 16, '36', 2),
(82, 16, '37', 3),
(83, 16, '38', 4),
(84, 16, '39', 3),
(85, 16, '40', 2),
(86, 16, '41', 6),
(87, 16, '42', 1),
(88, 17, '38', 5),
(89, 17, '39', 2),
(90, 17, '40', 3),
(91, 18, '38', 4),
(92, 18, '39', 2),
(93, 18, '40', 0),
(94, 18, '41', 1),
(95, 18, '42', 3),
(96, 19, '36', 5),
(97, 19, '37', 4),
(98, 19, '38', 2),
(99, 19, '39', 2),
(100, 19, '40', 3),
(101, 19, '41', 3),
(102, 20, '36', 3),
(103, 20, '37', 2),
(104, 20, '38', 3),
(105, 20, '39', 4),
(106, 20, '40', 5),
(107, 20, '41', 4),
(108, 20, '42', 6),
(109, 20, '43', 4),
(110, 21, '36', 1),
(111, 21, '37', 1),
(112, 21, '38', 0),
(113, 21, '39', 1),
(114, 21, '40', 0),
(115, 22, '36', 2),
(116, 22, '37', 4),
(117, 22, '38', 3),
(118, 22, '39', 4),
(119, 22, '40', 2),
(120, 22, '41', 3),
(121, 23, '36', 4),
(122, 23, '37', 3),
(123, 23, '38', 3),
(124, 23, '39', 1),
(125, 23, '40', 3),
(126, 24, '36', 0),
(127, 24, '37', 2),
(128, 24, '38', 1),
(129, 24, '39', 3),
(130, 24, '40', 2),
(131, 24, '41', 2),
(132, 25, '38', 3),
(133, 25, '39', 2),
(134, 25, '40', 4),
(135, 25, '41', 2),
(136, 25, '42', 2),
(137, 26, '36', 0),
(138, 26, '37', 2),
(139, 26, '38', 2),
(140, 26, '39', 3),
(141, 26, '40', 2),
(142, 26, '41', 0),
(143, 27, '37', 2),
(144, 27, '38', 3),
(145, 27, '39', 3),
(146, 27, '40', 1),
(147, 27, '41', 4),
(148, 28, '36', 0),
(149, 28, '37', 0),
(150, 28, '38', 0),
(151, 28, '39', 0),
(152, 28, '40', 0),
(153, 28, '41', 0),
(154, 29, '38', 2),
(155, 29, '39', 3),
(156, 29, '40', 3),
(157, 29, '41', 1),
(158, 29, '42', 4),
(159, 29, '43', 3),
(160, 30, '36', 3),
(161, 30, '37', 5),
(162, 30, '38', 4),
(163, 30, '39', 3),
(164, 30, '40', 6),
(165, 30, '41', 2),
(166, 30, '42', 1),
(167, 30, '43', 3),
(168, 31, '36', 3),
(169, 31, '37', 2),
(170, 31, '38', 4),
(171, 31, '39', 4),
(172, 31, '40', 6),
(173, 31, '41', 4),
(174, 32, '36', 2),
(175, 32, '37', 1),
(176, 32, '38', 0),
(177, 32, '39', 0),
(178, 32, '40', 0),
(179, 33, '36', 3),
(180, 33, '37', 4),
(181, 33, '38', 5),
(182, 33, '39', 5),
(183, 33, '40', 4),
(184, 33, '41', 3),
(185, 34, '36', 4),
(186, 34, '37', 3),
(187, 34, '38', 3),
(188, 34, '39', 2),
(189, 34, '40', 2),
(190, 34, '41', 1),
(191, 35, '36', 0),
(192, 35, '37', 1),
(193, 35, '38', 0),
(194, 35, '39', 2),
(195, 35, '40', 1),
(196, 35, '41', 0),
(197, 36, '36', 0),
(198, 36, '37', 0),
(199, 36, '38', 0),
(200, 36, '39', 0),
(201, 36, '40', 0),
(202, 36, '41', 0),
(203, 36, '42', 0),
(204, 37, '36', 5),
(205, 37, '37', 4),
(206, 37, '38', 3),
(207, 37, '39', 4),
(208, 37, '40', 1),
(209, 37, '41', 3),
(210, 37, '42', 0),
(211, 38, '36', 3),
(212, 38, '37', 2),
(213, 38, '38', 4),
(214, 38, '39', 3),
(215, 38, '40', 3),
(216, 38, '41', 2),
(217, 38, '42', 1),
(218, 39, '36', 4),
(219, 39, '37', 3),
(220, 39, '38', 2),
(221, 39, '39', 3),
(222, 39, '40', 6),
(223, 40, '36', 2),
(224, 40, '37', 3),
(225, 40, '38', 4),
(226, 40, '39', 4),
(227, 40, '40', 1),
(228, 40, '41', 2),
(229, 41, '36', 4),
(230, 41, '37', 3),
(231, 41, '38', 0),
(232, 41, '39', 2),
(233, 41, '40', 3),
(234, 41, '41', 1),
(235, 42, '37', 3),
(236, 42, '38', 1),
(237, 42, '39', 0),
(238, 42, '40', 0),
(239, 42, '41', 0),
(240, 43, '36', 3),
(241, 43, '37', 0),
(242, 43, '38', 2),
(243, 43, '39', 1),
(244, 43, '40', 3),
(245, 43, '41', 2),
(246, 43, '42', 0),
(247, 44, '36', 2),
(248, 44, '37', 2),
(249, 44, '38', 4),
(250, 44, '39', 3),
(251, 44, '40', 1),
(252, 44, '41', 2),
(253, 45, 'XS', 6),
(254, 45, 'S', 5),
(255, 45, 'M', 3),
(256, 45, 'L', 3),
(257, 45, 'XL', 0),
(258, 46, 'XS', 2),
(259, 46, 'S', 1),
(260, 46, 'M', 4),
(261, 46, 'L', 3),
(262, 46, 'XL', 2),
(263, 47, 'XS', 0),
(264, 47, 'S', 1),
(265, 47, 'M', 2),
(266, 47, 'L', 2),
(267, 47, 'XL', 0),
(268, 48, 'XS', 2),
(269, 48, 'S', 0),
(270, 48, 'M', 0),
(271, 48, 'L', 4),
(272, 48, 'XL', 2),
(273, 49, 'XXS', 1),
(274, 49, 'XS', 3),
(275, 49, 'S', 2),
(276, 49, 'M', 4),
(277, 49, 'L', 3),
(278, 49, 'XL', 3),
(279, 49, 'XXL', 2),
(325, 60, 'One Size', 13),
(324, 59, 'One Size', 12),
(323, 58, 'One Size', 14),
(285, 51, 'XS', 2),
(286, 51, 'S', 3),
(287, 51, 'M', 4),
(288, 51, 'L', 2),
(289, 51, 'XL', 0),
(290, 52, 'XS', 2),
(291, 52, 'S', 3),
(292, 52, 'M', 2),
(293, 52, 'L', 1),
(294, 52, 'XL', 2),
(295, 53, 'XS', 2),
(296, 53, 'S', 1),
(297, 53, 'M', 0),
(298, 53, 'L', 0),
(299, 53, 'XL', 2),
(300, 54, 'XS', 1),
(301, 54, 'S', 0),
(302, 54, 'M', 2),
(303, 54, 'L', 1),
(304, 54, 'XL', 3),
(305, 55, 'XXS', 2),
(306, 55, 'XS', 3),
(307, 55, 'S', 4),
(308, 55, 'M', 1),
(309, 55, 'L', 0),
(310, 55, 'XL', 2),
(311, 56, 'XS', 1),
(312, 56, 'S', 2),
(313, 56, 'M', 2),
(314, 56, 'L', 4),
(315, 56, 'XL', 3),
(316, 56, 'XXL', 2),
(317, 57, 'XXS', 3),
(318, 57, 'XS', 2),
(319, 57, 'S', 0),
(320, 57, 'M', 2),
(321, 57, 'L', 1),
(322, 57, 'XL', 3),
(326, 61, 'One Size', 4),
(327, 62, 'One Size', 5),
(328, 63, '36-38', 6),
(329, 63, '39-41', 3),
(330, 63, '42-44', 3),
(331, 64, 'One Size', 5),
(332, 65, 'One Size', 7),
(333, 66, '1L', 7),
(334, 67, 'One Size', 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_joined` date NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`, `date_joined`, `role`) VALUES
(1, 'lana nahle', 'lanaanahlee@gmail.com', 'Lana123', '2025-05-21', 'admin'),
(2, 'mahdihaidar', 'mahdihydr517@gmail.com', 'Mahdi000', '2025-05-21', 'user'),
(3, 'Lana Nahle', 'lananahle2@gmail.com', 'Lana1234', '2025-05-21', 'user'),
(4, 'Nancy', 'nancy.mazraani@gmail.com', 'NancyMaz123$', '2025-05-22', 'user'),
(5, 'Majed Issa', 'Majedissa02@gmail.com', 'Majed_is2002', '2025-05-22', 'user'),
(6, 'youssef majed', 'youssefmajed868@gmail.com', 'YoussefMajed313', '2025-05-22', 'user'),
(7, 'avine', 'avine061@gmail.com', 'Adidaslanaavine100$', '2025-05-22', 'user'),
(8, 'Rida Yaakoub', 'ridayaakoub7@gmail.com', 'Rida@123', '2025-05-22', 'user'),
(9, 'rami hammoud', 'rami.hammoud@gmail.com', 'Rami12345', '2025-05-24', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 7, 28, '2025-05-22 09:34:37'),
(3, 1, 10, '2025-05-25 02:53:23'),
(4, 3, 26, '2025-05-25 03:06:27'),
(5, 3, 28, '2025-05-25 03:06:33'),
(6, 3, 12, '2025-05-25 03:07:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `fk_variant_id` (`variant_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_order_user` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `fk_orderdetail_order` (`order_id`),
  ADD KEY `fk_orderdetail_variant` (`variant_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `product_variant`
--
ALTER TABLE `product_variant`
  ADD PRIMARY KEY (`variant_id`),
  ADD KEY `fk_variant_product` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `fk_wishlist_user` (`user_id`),
  ADD KEY `fk_wishlist_product` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `product_variant`
--
ALTER TABLE `product_variant`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
