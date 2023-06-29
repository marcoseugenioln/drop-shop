-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2018 at 04:26 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `store`

-- Table structure for table `cart`

CREATE TABLE `carts` (
  `cart_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (product_id) REFERENCES users(product_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `orders`

CREATE TABLE `orders` (
  `order_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `order_date` date NOT NULL,
  `delivery_address` text NOT NULL,
  `delivery_status` varchar(10) NOT NULL DEFAULT 'no',
  `delivery_date` date NOT NULL,
  `delivery` varchar(30) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (product_id) REFERENCES users(product_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `products`

CREATE TABLE `products` (
  `product_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `product_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `piece` int(11) NOT NULL,
  `description` text NOT NULL,
  `available` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `item` varchar(100) NOT NULL,
  `product_code` varchar(20) NOT NULL,
  `picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `user`

CREATE TABLE `users` (
  `user_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(120) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_code` varchar(10) NOT NULL,
  `active` INTEGER DEFAULT (0),
  `is_admin` INTEGER DEFAULT (0)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `admin`

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile`, `address`, `password`, `confirm_code`) VALUES
('Marcos', 'Nascimento', 'marcos.eugenioln@gmail.com', '5512974047394', 'okay', 'bb9aaadad4583fc30dea55c701ff2ea487121bec', '7394');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
