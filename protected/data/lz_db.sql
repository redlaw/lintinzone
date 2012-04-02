-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2012 at 04:38 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sample-yii_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `lz_email_verification`
--

CREATE TABLE IF NOT EXISTS `lz_email_verification` (
  `email` varchar(50) NOT NULL,
  `verification_key` varchar(50) NOT NULL,
  `sent_date` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verified_date` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`),
  UNIQUE KEY `verification_key` (`verification_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lz_locations`
--

CREATE TABLE IF NOT EXISTS `lz_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_type` varchar(50) NOT NULL,
  `location_title` varchar(50) NOT NULL,
  `location_link_title` varchar(50) NOT NULL,
  `location_summary` varchar(250) DEFAULT NULL,
  `location_description` text,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `parent_location_id` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`location_id`),
  KEY `location_title` (`location_title`),
  KEY `location_link_title` (`location_link_title`),
  KEY `location_summary` (`location_summary`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lz_location_types`
--

CREATE TABLE IF NOT EXISTS `lz_location_types` (
  `type_name` varchar(50) NOT NULL,
  `type_title` varchar(255) NOT NULL,
  `type_description` int(11) DEFAULT NULL,
  `parent_type` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lz_login_history`
--

CREATE TABLE IF NOT EXISTS `lz_login_history` (
  `user_id` int(11) NOT NULL,
  `login_ip` varchar(23) NOT NULL,
  `login_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `duration` int(11) DEFAULT NULL COMMENT 'seconds',
  PRIMARY KEY (`user_id`,`login_ip`,`login_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lz_profile_fields`
--

CREATE TABLE IF NOT EXISTS `lz_profile_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(50) NOT NULL,
  `field_title` varchar(255) NOT NULL,
  `field_type` varchar(20) NOT NULL DEFAULT 'STRING',
  `field_size_max` int(11) NOT NULL,
  `field_size_min` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `error_message` text NOT NULL,
  `position` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `field_name` (`field_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lz_profile_info`
--

CREATE TABLE IF NOT EXISTS `lz_profile_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(50) NOT NULL,
  `field_name` varchar(50) NOT NULL,
  `field_value` text NOT NULL,
  `note` text,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lz_trips`
--

CREATE TABLE IF NOT EXISTS `lz_trips` (
  `trip_id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_title` varchar(50) NOT NULL,
  `trip_link_title` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `departure_location` int(11) NOT NULL,
  `departure_date` timestamp NULL DEFAULT NULL,
  `arrival_location` int(11) NOT NULL,
  `arrival_date` timestamp NULL DEFAULT NULL,
  `trip_status` varchar(50) NOT NULL DEFAULT 'TRIP_STATUS_PLANNING',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`trip_id`),
  KEY `trip_title` (`trip_title`),
  KEY `trip_link_title` (`trip_link_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lz_trip_statuses`
--

CREATE TABLE IF NOT EXISTS `lz_trip_statuses` (
  `trip_status_name` varchar(50) NOT NULL,
  `trip_status_title` varchar(50) NOT NULL,
  `trip_status_description` text,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`trip_status_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lz_users`
--

CREATE TABLE IF NOT EXISTS `lz_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_visited_date` timestamp NULL DEFAULT NULL,
  `last_visited_ip` varchar(23) DEFAULT NULL,
  `last_visited_loc_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;
