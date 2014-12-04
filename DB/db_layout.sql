SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `carts` (
`item_id` int(10) unsigned NOT NULL,
  `email` varchar(60) NOT NULL,
  `option_id` int(10) unsigned zerofill NOT NULL,
  `quantity` smallint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `codes` (
`primary` int(10) unsigned NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `discount` decimal(8,2) unsigned NOT NULL,
  `type` varchar(4) NOT NULL DEFAULT 'pct',
  `valid_from` datetime NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `forums` (
`forum_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `images` (
`image_id` int(10) unsigned zerofill NOT NULL,
  `product_id` int(10) unsigned zerofill NOT NULL,
  `site` varchar(40) NOT NULL,
  `directory` varchar(25) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `messages` (
`message_id` int(11) NOT NULL,
  `forum_id` tinyint(4) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `username` varchar(30) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `body` longtext NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `orders` (
`order_id` int(10) unsigned zerofill NOT NULL,
  `email` varchar(60) NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `despatch_date` datetime DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000000000 ;

CREATE TABLE `order_details` (
`key` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned zerofill NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(10) unsigned zerofill NOT NULL,
  `quantity` int(3) NOT NULL DEFAULT '1',
  `total_price` decimal(8,2) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `products` (
`product_id` int(10) unsigned zerofill NOT NULL,
  `image_id` int(10) unsigned zerofill NOT NULL,
  `name` varchar(50) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL,
  `category` set('clothes','womanswear','menswear','childrenswear','babywear','footwear','sportswear','accessory','scarves','bags','hats','gloves','knitted socks','gifts','decorative accessories','soft furnishings','kitchen & tableware','childrens gifts & toys','storage bags','educational toys','misc. gifts','jewellery','necklaces','earings','bracelets','jewellery sets','sport','balls','toiletries') NOT NULL,
  `size_options` set('S','M','L','XL','S/M','M/L','3','4','5','6','7','8','9','10','11','12','13','14','16','18','Newborn','0-3 months','3-6 months','6-9 months','9-12 months','12-18 months','0-6 months','6-12 months','1-2 years','2-3 years','3-4 years','4-5 years','5-6 years','6-7 years','7-8 years','8-9 years','9-10 years') DEFAULT NULL,
  `colour_options` set('Red','Black','Grey','White','Yellow','Cream','Blue','Light Blue','Royal Blue','Navy','Green','Dark Green','Light Green','Brown','Orange','Pink','Cerise','Pink/Blue','Bronze','Purple','Green/Blue','Olive/Black Trim') DEFAULT NULL,
  `in_stock` int(10) unsigned NOT NULL,
  `show_item` tinyint(1) NOT NULL DEFAULT '1',
  `on_sale` tinyint(1) NOT NULL DEFAULT '0',
  `reduced_from` decimal(10,2) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `product_opts` (
  `product_id` int(10) NOT NULL,
`option_id` int(10) unsigned zerofill NOT NULL,
  `image_id` int(10) unsigned zerofill NOT NULL,
  `image_id2` int(10) DEFAULT NULL,
  `image_id3` int(10) DEFAULT NULL,
  `image_id4` int(10) DEFAULT NULL,
  `image_id5` int(10) DEFAULT NULL,
  `image_id6` int(10) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL,
  `category` set('clothes','womanswear','menswear','childrenswear','babywear','footwear','sportswear','accessory','scarves','bags','hats','gloves','knitted socks','gifts','decorative accessories','soft furnishings','kitchen & tableware','childrens gifts & toys','storage bags','educational toys','misc. gifts','jewellery','necklaces','earings','bracelets','jewellery sets','sport','balls','toiletries') NOT NULL,
  `size_options` set('S','M','L','XL','S/M','M/L','3','4','5','6','7','8','9','10','11','12','13','14','16','18','Newborn','0-3 months','3-6 months','6-9 months','9-12 months','12-18 months','0-6 months','6-12 months','1-2 years','2-3 years','3-4 years','4-5 years','5-6 years','6-7 years','7-8 years','8-9 years','9-10 years') DEFAULT NULL,
  `colour_options` set('Red','Black','Grey','White','Yellow','Cream','Blue','Light Blue','Royal Blue','Navy','Green','Dark Green','Light Green','Brown','Orange','Pink','Cerise','Pink/Blue','Bronze','Purple','Green/Blue','Olive/Black Trim') DEFAULT NULL,
  `in_stock` int(10) unsigned NOT NULL,
  `show_item` tinyint(1) NOT NULL DEFAULT '1',
  `on_sale` tinyint(1) NOT NULL DEFAULT '0',
  `reduced_from` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `slides` (
`slide_id` int(10) unsigned zerofill NOT NULL,
  `product_id` int(10) unsigned zerofill NOT NULL,
  `site` varchar(40) NOT NULL,
  `directory` varchar(25) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `tn_directory` varchar(25) NOT NULL,
  `tn_filename` varchar(255) NOT NULL,
  `alt` varchar(100) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `thumbs` (
`image_id` int(10) unsigned zerofill NOT NULL,
  `product_id` int(10) unsigned zerofill NOT NULL,
  `site` varchar(40) NOT NULL,
  `directory` varchar(100) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `users` (
  `email` varchar(60) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `pass` char(40) NOT NULL,
  `addr1` varchar(60) NOT NULL,
  `addr2` varchar(60) DEFAULT NULL,
  `city` varchar(20) NOT NULL,
  `county` varchar(30) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `telephone` char(11) DEFAULT NULL,
  `marketing` tinyint(1) NOT NULL,
  `wlpass` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `wishlist` (
`primary` int(11) unsigned NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(10) unsigned zerofill NOT NULL,
  `quantity` int(3) NOT NULL DEFAULT '1',
  `email` varchar(60) NOT NULL,
  `comment` char(250) DEFAULT NULL,
  `in_stock` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `carts`
 ADD PRIMARY KEY (`item_id`);

ALTER TABLE `codes`
 ADD PRIMARY KEY (`primary`), ADD UNIQUE KEY `code` (`code`);

ALTER TABLE `forums`
 ADD PRIMARY KEY (`forum_id`), ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `images`
 ADD UNIQUE KEY `image_id` (`image_id`), ADD KEY `filename` (`filename`), ADD KEY `product_id` (`product_id`);

ALTER TABLE `messages`
 ADD PRIMARY KEY (`message_id`), ADD KEY `forum_id` (`forum_id`,`parent_id`,`user_id`,`date_entered`), ADD KEY `username` (`username`);

ALTER TABLE `orders`
 ADD PRIMARY KEY (`order_id`);

ALTER TABLE `order_details`
 ADD PRIMARY KEY (`key`);

ALTER TABLE `products`
 ADD PRIMARY KEY (`product_id`), ADD KEY `price` (`price`,`in_stock`), ADD KEY `name_2` (`name`), ADD KEY `image_id_2` (`image_id`);

ALTER TABLE `product_opts`
 ADD PRIMARY KEY (`option_id`), ADD KEY `price` (`price`,`in_stock`), ADD KEY `name_2` (`name`), ADD KEY `image_id_2` (`image_id`);

ALTER TABLE `slides`
 ADD UNIQUE KEY `image_id` (`slide_id`), ADD KEY `filename` (`filename`), ADD KEY `product_id` (`product_id`);

ALTER TABLE `thumbs`
 ADD UNIQUE KEY `image_id` (`image_id`), ADD KEY `filename` (`filename`), ADD KEY `product_id` (`product_id`);

ALTER TABLE `users`
 ADD PRIMARY KEY (`email`);

ALTER TABLE `wishlist`
 ADD PRIMARY KEY (`primary`);


ALTER TABLE `carts`
MODIFY `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `codes`
MODIFY `primary` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `forums`
MODIFY `forum_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `images`
MODIFY `image_id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT;
ALTER TABLE `messages`
MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `orders`
MODIFY `order_id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT;
ALTER TABLE `order_details`
MODIFY `key` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `products`
MODIFY `product_id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT;
ALTER TABLE `product_opts`
MODIFY `option_id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT;
ALTER TABLE `slides`
MODIFY `slide_id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT;
ALTER TABLE `thumbs`
MODIFY `image_id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT;
ALTER TABLE `wishlist`
MODIFY `primary` int(11) unsigned NOT NULL AUTO_INCREMENT;SET FOREIGN_KEY_CHECKS=1;
