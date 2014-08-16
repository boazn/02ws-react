-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: 62.128.42.5
-- Generation Time: Feb 06, 2005 at 11:25 AM
-- Server version: 4.1.7
-- PHP Version: 4.3.9
-- 
-- Database: `boaz`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `average`
-- 

CREATE TABLE `average` (
  `month` smallint(6) default NULL,
  `LowTemp` float default NULL,
  `HighTemp` float default NULL,
  `MidTemp` float default NULL,
  `HighHum` smallint(6) default NULL,
  `LowHum` smallint(6) default NULL,
  `MidHum` smallint(6) default NULL,
  `Rain` float default NULL,
  `RainyDays` float default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `average`
-- 

INSERT INTO `average` VALUES (1, 6.4, 11.8, 8.7, 85, 55, 70, 133.2, 12.9);
INSERT INTO `average` VALUES (2, 6.4, 12.6, 9.5, 83, 48, 66, 118.3, 11.7);
INSERT INTO `average` VALUES (3, 8.4, 15.4, 12.5, 81, 44, 62, 92.7, 9.6);
INSERT INTO `average` VALUES (4, 12.6, 21.5, 16, 74, 36, 54, 24.5, 4.4);
INSERT INTO `average` VALUES (5, 15.7, 25.3, 20, 69, 29, 47, 3.2, 1.3);
INSERT INTO `average` VALUES (6, 17.8, 27.6, 22.3, 73, 31, 50, 0, 0);
INSERT INTO `average` VALUES (7, 19.4, 29, 24.3, 79, 34, 54, 0, 0);
INSERT INTO `average` VALUES (8, 19.5, 29.4, 24.5, 82, 35, 58, 0, 0);
INSERT INTO `average` VALUES (9, 18.6, 28.2, 23.3, 86, 38, 63, 0.3, 0.3);
INSERT INTO `average` VALUES (10, 16.6, 24.7, 20.5, 78, 36, 58, 15.4, 3.6);
INSERT INTO `average` VALUES (11, 12.3, 18.8, 16, 77, 43, 60, 60.8, 7.3);
INSERT INTO `average` VALUES (12, 8.4, 14, 10.5, 84, 54, 69, 105.7, 10.9);

-- --------------------------------------------------------

-- 
-- Table structure for table `dooncechecklist`
-- 

CREATE TABLE `dooncechecklist` (
  `Action` text NOT NULL,
  `Today` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `dooncechecklist`
-- 

INSERT INTO `dooncechecklist` VALUES ('ResetMailSMS', '6/02/05');
INSERT INTO `dooncechecklist` VALUES ('UpdateRainyDays', '');
INSERT INTO `dooncechecklist` VALUES ('LoadArchiveData', '29-08-04');

-- --------------------------------------------------------

-- 
-- Table structure for table `extremes`
-- 

CREATE TABLE `extremes` (
  `param` text,
  `monthly_high` float default NULL,
  `monthly_high_date` text,
  `yearly_high` float default NULL,
  `yearly_high_date` text,
  `monthly_low` float default NULL,
  `monthly_low_date` text,
  `yearly_low` float default NULL,
  `yearly_low_date` text,
  `old_record` float default NULL,
  `old_date` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `extremes`
-- 

INSERT INTO `extremes` VALUES ('temp', 10.2, '4/02/05', 17.7, '01-01-05', 3.9, '5/02/05', 3.2, '6/02/05', 3.2, '18-01-05');
INSERT INTO `extremes` VALUES ('humidity', 97, '07-12-04', 100, '03/02/05', 4, '29-12-04', 12, '01-01-05', 100, '02/02/05');
INSERT INTO `extremes` VALUES ('rainrate', 43.2, '5/02/05', 73.9, '18-11-04', 0, '1/8/2003', 0, '1/1/2003', 43.2, '4/02/05');
INSERT INTO `extremes` VALUES ('wind', 53.9, '6/02/05', 56.5, '24/01/05', 0, '1/8/2003', 0, '1/1/2003', 51.3, '5/02/05');
INSERT INTO `extremes` VALUES ('pressure', 1024.5, '12-01-05', 1024.5, '12-01-05', 1006.4, '24-12-04', 1004.5, '22/01/05', 1004.9, '22-01-05');

-- --------------------------------------------------------

-- 
-- Table structure for table `globalwarming`
-- 

CREATE TABLE `globalwarming` (
  `year` smallint(6) NOT NULL default '0',
  `anomaly` double NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `globalwarming`
-- 

INSERT INTO `globalwarming` VALUES (2002, 0.2);
INSERT INTO `globalwarming` VALUES (2003, -0.3);
INSERT INTO `globalwarming` VALUES (2004, -0.3);
INSERT INTO `globalwarming` VALUES (2005, -1.3);

-- --------------------------------------------------------

-- 
-- Table structure for table `raindailyaverage`
-- 

CREATE TABLE `raindailyaverage` (
  `month` smallint(6) default NULL,
  `decade` smallint(6) default NULL,
  `AccRain` float default NULL,
  `rainyDays` float default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `raindailyaverage`
-- 

INSERT INTO `raindailyaverage` VALUES (9, 1, 0.1, 0);
INSERT INTO `raindailyaverage` VALUES (9, 2, 0.2, 0);
INSERT INTO `raindailyaverage` VALUES (9, 3, 0.3, 0);
INSERT INTO `raindailyaverage` VALUES (10, 1, 4.3, 0);
INSERT INTO `raindailyaverage` VALUES (10, 2, 11.3, 0);
INSERT INTO `raindailyaverage` VALUES (10, 3, 18.3, 0);
INSERT INTO `raindailyaverage` VALUES (11, 1, 33.3, 0);
INSERT INTO `raindailyaverage` VALUES (11, 2, 51.3, 0);
INSERT INTO `raindailyaverage` VALUES (11, 3, 77.3, 0);
INSERT INTO `raindailyaverage` VALUES (12, 1, 114.3, 0);
INSERT INTO `raindailyaverage` VALUES (12, 2, 148.3, 0);
INSERT INTO `raindailyaverage` VALUES (12, 3, 184.3, 0);
INSERT INTO `raindailyaverage` VALUES (1, 1, 216.3, 0);
INSERT INTO `raindailyaverage` VALUES (1, 2, 271.3, 0);
INSERT INTO `raindailyaverage` VALUES (1, 3, 318.3, 0);
INSERT INTO `raindailyaverage` VALUES (2, 1, 366.3, 0);
INSERT INTO `raindailyaverage` VALUES (2, 2, 400.3, 0);
INSERT INTO `raindailyaverage` VALUES (2, 3, 430.3, 0);
INSERT INTO `raindailyaverage` VALUES (3, 1, 467.3, 0);
INSERT INTO `raindailyaverage` VALUES (3, 2, 495.3, 0);
INSERT INTO `raindailyaverage` VALUES (3, 3, 521.3, 0);
INSERT INTO `raindailyaverage` VALUES (4, 1, 533.3, 0);
INSERT INTO `raindailyaverage` VALUES (4, 2, 545.3, 0);
INSERT INTO `raindailyaverage` VALUES (4, 3, 550.3, 0);
INSERT INTO `raindailyaverage` VALUES (5, 1, 551.4, 0);
INSERT INTO `raindailyaverage` VALUES (5, 2, 552.5, 0);
INSERT INTO `raindailyaverage` VALUES (5, 3, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (6, 1, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (6, 2, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (6, 3, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (7, 1, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (7, 2, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (7, 3, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (8, 1, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (8, 2, 553.6, 0);
INSERT INTO `raindailyaverage` VALUES (8, 3, 553.6, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `rainseason`
-- 

CREATE TABLE `rainseason` (
  `season` text,
  `Year` smallint(9) default NULL,
  `month` smallint(6) default NULL,
  `mm` float default NULL,
  `RainyDays` float default '0',
  KEY `month` (`month`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `rainseason`
-- 

INSERT INTO `rainseason` VALUES ('2001-2002', 2001, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('2001-2002', 2001, 10, 9, NULL);
INSERT INTO `rainseason` VALUES ('2001-2002', 2001, 11, 62.6, NULL);
INSERT INTO `rainseason` VALUES ('2001-2002', 2001, 12, 128.2, 10);
INSERT INTO `rainseason` VALUES ('2001-2002', 2002, 1, 218.2, 16);
INSERT INTO `rainseason` VALUES ('2001-2002', 2002, 2, 53.8, 6);
INSERT INTO `rainseason` VALUES ('2001-2002', 2002, 3, 55.1, 9);
INSERT INTO `rainseason` VALUES ('2001-2002', 2002, 4, 54.1, 9);
INSERT INTO `rainseason` VALUES ('2001-2002', 2002, 5, 3.6, 5);
INSERT INTO `rainseason` VALUES ('2001-2002', 2002, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('2001-2002', 2002, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('2001-2002', 2002, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('2002-2003', 2002, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('2002-2003', 2002, 10, 14.5, 5);
INSERT INTO `rainseason` VALUES ('2002-2003', 2002, 11, 22.6, 6);
INSERT INTO `rainseason` VALUES ('2002-2003', 2002, 12, 186.7, 17);
INSERT INTO `rainseason` VALUES ('2002-2003', 2003, 1, 83.3, 13);
INSERT INTO `rainseason` VALUES ('2002-2003', 2003, 2, 298.7, 21);
INSERT INTO `rainseason` VALUES ('2002-2003', 2003, 3, 126.5, 15);
INSERT INTO `rainseason` VALUES ('2002-2003', 2003, 4, 19.1, 4);
INSERT INTO `rainseason` VALUES ('2002-2003', 2003, 5, 0.3, 1);
INSERT INTO `rainseason` VALUES ('2002-2003', 2003, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('2002-2003', 2003, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('2002-2003', 2003, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('2003-2004', 2003, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('2003-2004', 2003, 10, 1.8, 4);
INSERT INTO `rainseason` VALUES ('2003-2004', 2003, 11, 15, 4);
INSERT INTO `rainseason` VALUES ('2003-2004', 2003, 12, 129.3, 11);
INSERT INTO `rainseason` VALUES ('2003-2004', 2004, 1, 149.6, 14);
INSERT INTO `rainseason` VALUES ('2003-2004', 2004, 2, 83.1, 15);
INSERT INTO `rainseason` VALUES ('2003-2004', 2004, 3, 20.8, 5);
INSERT INTO `rainseason` VALUES ('2003-2004', 2004, 4, 3.8, 2);
INSERT INTO `rainseason` VALUES ('2003-2004', 2004, 5, 1.8, 2);
INSERT INTO `rainseason` VALUES ('2003-2004', 2004, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('2003-2004', 2004, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('2003-2004', 2004, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 9, 0.3, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 10, 6, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 11, 57.7, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 12, 92.4, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 1, 99.5, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 2, 103.6, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 3, 78.9, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 4, 19.3, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 5, 5, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 6, 0, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 7, 0, NULL);
INSERT INTO `rainseason` VALUES ('1950-1965', NULL, 8, 0, NULL);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 9, 0.3, 0.3);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 10, 16.1, 3.6);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 11, 59, 7.3);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 12, 107.3, 10.9);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 1, 132.6, 12.9);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 2, 118, 11.7);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 3, 90, 9.6);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 4, 24.1, 4.4);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 5, 5.4, 1.3);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('1970-2000', NULL, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 9, 0.3, 0);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 10, 13.7, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 11, 57.8, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 12, 103.8, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 1, 126.3, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 2, 108.3, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 3, 90, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 4, 22.3, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 5, 5.2, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 6, 0, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 7, 0, NULL);
INSERT INTO `rainseason` VALUES ('1950-2001', NULL, 8, 0, NULL);
INSERT INTO `rainseason` VALUES ('2004-2005', 2004, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('2004-2005', 2004, 10, 11.7, 2);
INSERT INTO `rainseason` VALUES ('2004-2005', 2004, 11, 145.3, 8);
INSERT INTO `rainseason` VALUES ('2004-2005', 2004, 12, 49, 9);
INSERT INTO `rainseason` VALUES ('2004-2005', 2005, 1, 163.1, 13);
INSERT INTO `rainseason` VALUES ('2004-2005', 2005, 2, 41.4, 5);
INSERT INTO `rainseason` VALUES ('2004-2005', 2005, 3, NULL, NULL);
INSERT INTO `rainseason` VALUES ('2004-2005', 2005, 4, NULL, NULL);
INSERT INTO `rainseason` VALUES ('2004-2005', 2005, 5, NULL, NULL);
INSERT INTO `rainseason` VALUES ('2004-2005', 2005, 6, NULL, NULL);
INSERT INTO `rainseason` VALUES ('2004-2005', 2005, 7, NULL, NULL);
INSERT INTO `rainseason` VALUES ('2004-2005', 2005, 8, NULL, NULL);
INSERT INTO `rainseason` VALUES ('2000-2001', 2000, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('2000-2001', 2000, 10, 15, 4);
INSERT INTO `rainseason` VALUES ('2000-2001', 2000, 11, 6, 2);
INSERT INTO `rainseason` VALUES ('2000-2001', 2000, 12, 154, 9);
INSERT INTO `rainseason` VALUES ('2000-2001', 2001, 1, 118, 8);
INSERT INTO `rainseason` VALUES ('2000-2001', 2001, 2, 109, 9);
INSERT INTO `rainseason` VALUES ('2000-2001', 2001, 3, 8, 4);
INSERT INTO `rainseason` VALUES ('2000-2001', 2001, 4, 11, 3);
INSERT INTO `rainseason` VALUES ('2000-2001', 2001, 5, 71, 1);
INSERT INTO `rainseason` VALUES ('2000-2001', 2001, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('2000-2001', 2001, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('2000-2001', 2001, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('1999-2000', 1999, 9, 0.3, 0);
INSERT INTO `rainseason` VALUES ('1999-2000', 1999, 10, 2.8, 1);
INSERT INTO `rainseason` VALUES ('1999-2000', 1999, 11, 13.3, 3);
INSERT INTO `rainseason` VALUES ('1999-2000', 1999, 12, 28, 4);
INSERT INTO `rainseason` VALUES ('1999-2000', 2000, 1, 264.5, 14);
INSERT INTO `rainseason` VALUES ('1999-2000', 2000, 2, 65.8, 9);
INSERT INTO `rainseason` VALUES ('1999-2000', 2000, 3, 93.7, 7);
INSERT INTO `rainseason` VALUES ('1999-2000', 2000, 4, 0.2, 0);
INSERT INTO `rainseason` VALUES ('1999-2000', 2000, 5, 0, 0);
INSERT INTO `rainseason` VALUES ('1999-2000', 2000, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('1999-2000', 2000, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('1999-2000', 2000, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('1998-1999', 1998, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('1998-1999', 1998, 10, 3.5, 1);
INSERT INTO `rainseason` VALUES ('1998-1999', 1998, 11, 6, 1);
INSERT INTO `rainseason` VALUES ('1998-1999', 1998, 12, 31, 5);
INSERT INTO `rainseason` VALUES ('1998-1999', 1999, 1, 90.4, 9);
INSERT INTO `rainseason` VALUES ('1998-1999', 1999, 2, 71.4, 5);
INSERT INTO `rainseason` VALUES ('1998-1999', 1999, 3, 44.8, 5);
INSERT INTO `rainseason` VALUES ('1998-1999', 1999, 4, 17.3, 1);
INSERT INTO `rainseason` VALUES ('1998-1999', 1999, 5, 0, 0);
INSERT INTO `rainseason` VALUES ('1998-1999', 1999, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('1998-1999', 1999, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('1998-1999', 1999, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('1997-1998', 1997, 9, 2.2, 1);
INSERT INTO `rainseason` VALUES ('1997-1998', 1997, 10, 29, 3);
INSERT INTO `rainseason` VALUES ('1997-1998', 1997, 11, 52.8, 7);
INSERT INTO `rainseason` VALUES ('1997-1998', 1997, 12, 140.5, 10);
INSERT INTO `rainseason` VALUES ('1997-1998', 1998, 1, 138.1, 11);
INSERT INTO `rainseason` VALUES ('1997-1998', 1998, 2, 75, 8);
INSERT INTO `rainseason` VALUES ('1997-1998', 1998, 3, 151.1, 12);
INSERT INTO `rainseason` VALUES ('1997-1998', 1998, 4, 1.2, 1);
INSERT INTO `rainseason` VALUES ('1997-1998', 1998, 5, 3.7, 2);
INSERT INTO `rainseason` VALUES ('1997-1998', 1998, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('1997-1998', 1998, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('1997-1998', 1998, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('1996-1997', 1996, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('1996-1997', 1996, 10, 23.7, 5);
INSERT INTO `rainseason` VALUES ('1996-1997', 1996, 11, 6.3, 3);
INSERT INTO `rainseason` VALUES ('1996-1997', 1996, 12, 76.2, 9);
INSERT INTO `rainseason` VALUES ('1996-1997', 1997, 1, 140.5, 7);
INSERT INTO `rainseason` VALUES ('1996-1997', 1997, 2, 163.5, 9);
INSERT INTO `rainseason` VALUES ('1996-1997', 1997, 3, 124.4, 14);
INSERT INTO `rainseason` VALUES ('1996-1997', 1997, 4, 19.2, 5);
INSERT INTO `rainseason` VALUES ('1996-1997', 1997, 5, 12, 3);
INSERT INTO `rainseason` VALUES ('1996-1997', 1997, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('1996-1997', 1997, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('1996-1997', 1997, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('1995-1996', 1995, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('1995-1996', 1995, 10, 0, 0);
INSERT INTO `rainseason` VALUES ('1995-1996', 1995, 11, 68.3, 8);
INSERT INTO `rainseason` VALUES ('1995-1996', 1995, 12, 32, 8);
INSERT INTO `rainseason` VALUES ('1995-1996', 1996, 1, 170.1, 13);
INSERT INTO `rainseason` VALUES ('1995-1996', 1996, 2, 38.4, 7);
INSERT INTO `rainseason` VALUES ('1995-1996', 1996, 3, 178.5, 8);
INSERT INTO `rainseason` VALUES ('1995-1996', 1996, 4, 17.6, 4);
INSERT INTO `rainseason` VALUES ('1995-1996', 1996, 5, 0, 0);
INSERT INTO `rainseason` VALUES ('1995-1996', 1996, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('1995-1996', 1996, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('1995-1996', 1996, 8, 0, 0);
INSERT INTO `rainseason` VALUES ('1994-1995', 1994, 9, 0, 0);
INSERT INTO `rainseason` VALUES ('1994-1995', 1994, 10, 21, 3);
INSERT INTO `rainseason` VALUES ('1994-1995', 1994, 11, 186.7, 16);
INSERT INTO `rainseason` VALUES ('1994-1995', 1994, 12, 240.5, 12);
INSERT INTO `rainseason` VALUES ('1994-1995', 1995, 1, 33.5, 2);
INSERT INTO `rainseason` VALUES ('1994-1995', 1995, 2, 96.4, 10);
INSERT INTO `rainseason` VALUES ('1994-1995', 1995, 3, 51.7, 3);
INSERT INTO `rainseason` VALUES ('1994-1995', 1995, 4, 27.5, 3);
INSERT INTO `rainseason` VALUES ('1994-1995', 1995, 5, 0, 0);
INSERT INTO `rainseason` VALUES ('1994-1995', 1995, 6, 0, 0);
INSERT INTO `rainseason` VALUES ('1994-1995', 1995, 7, 0, 0);
INSERT INTO `rainseason` VALUES ('1994-1995', 1995, 8, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `sendmailsms`
-- 

CREATE TABLE `sendmailsms` (
  `Action` varchar(15) NOT NULL default '',
  `Sent` int(11) default NULL,
  `lastSent` datetime NOT NULL default '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `sendmailsms`
-- 

INSERT INTO `sendmailsms` VALUES ('ExtremeBroken', 0, '0000-00-00 00:00:00');
INSERT INTO `sendmailsms` VALUES ('RainStarted', 1, '2005-02-06 00:53:39');
INSERT INTO `sendmailsms` VALUES ('PrsSinking', 1, '2005-02-06 00:07:29');
INSERT INTO `sendmailsms` VALUES ('HumRise', 0, '0000-00-00 00:00:00');
INSERT INTO `sendmailsms` VALUES ('PrsRise', 0, '0000-00-00 00:00:00');
INSERT INTO `sendmailsms` VALUES ('RainStopped', 1, '2005-02-06 04:08:29');
INSERT INTO `sendmailsms` VALUES ('Windy', 0, '0000-00-00 00:00:00');
INSERT INTO `sendmailsms` VALUES ('Dry', 0, '2004-12-31 01:27:21');
INSERT INTO `sendmailsms` VALUES ('Fog', 0, '2005-02-02 04:23:15');
INSERT INTO `sendmailsms` VALUES ('TempDrop', 0, '0000-00-00 00:00:00');
INSERT INTO `sendmailsms` VALUES ('TempRise', 0, '2004-09-20 03:51:12');
INSERT INTO `sendmailsms` VALUES ('HumDrop', 0, '2004-09-21 00:31:02');
