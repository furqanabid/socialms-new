-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 01 月 24 日 01:10
-- 服务器版本: 5.1.44
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `socialms`
--

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_flickr`
--

CREATE TABLE IF NOT EXISTS `xz_social_flickr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `flickr_nsid` varchar(20) NOT NULL,
  `flickr_token` varchar(70) NOT NULL,
  `flickr_username` varchar(100) NOT NULL,
  `flickr_fullname` varchar(150) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `xz_social_flickr`
--

INSERT INTO `xz_social_flickr` (`id`, `user_id`, `flickr_nsid`, `flickr_token`, `flickr_username`, `flickr_fullname`, `create_time`, `update_time`, `is_deleted`) VALUES
(11, 15, '97781511@N08', '72157637250848554-5527e62a6883970f', 'andybegin', 'Andy Zhe', '2013-11-19 05:52:40', '2013-12-20 22:23:20', '1'),
(12, 15, '97781511@N08', '72157638860931844-f7ae86b1561cfdfa', 'andybegin', 'Andy Zhe', '2013-12-20 20:29:11', '2013-12-20 22:23:23', '1'),
(13, 15, '97781511@N08', '72157638860931844-f7ae86b1561cfdfa', 'andybegin', 'Andy Zhe', '2013-12-20 21:03:13', '2013-12-20 22:23:28', '1'),
(14, 15, '97781511@N08', '72157638860931844-f7ae86b1561cfdfa', 'andybegin', 'Andy Zhe', '2013-12-20 21:09:29', '2013-12-20 21:09:29', '0'),
(15, 15, '97781511@N08', '72157638860931844-f7ae86b1561cfdfa', 'andybegin', 'Andy Zhe', '2013-12-20 21:19:36', '2013-12-20 22:23:07', '1');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_instagram`
--

CREATE TABLE IF NOT EXISTS `xz_social_instagram` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `instagram_userid` int(10) unsigned NOT NULL,
  `instagram_access_token` char(50) NOT NULL,
  `instagram_username` varchar(100) NOT NULL,
  `instagram_fullname` varchar(150) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `xz_social_instagram`
--

INSERT INTO `xz_social_instagram` (`id`, `user_id`, `instagram_userid`, `instagram_access_token`, `instagram_username`, `instagram_fullname`, `create_time`, `update_time`, `is_deleted`) VALUES
(18, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-18 23:29:07', '2013-12-19 18:47:07', '1'),
(19, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-19 18:47:32', '2013-12-19 19:16:25', '1'),
(20, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-19 18:49:33', '2013-12-19 19:17:13', '1'),
(21, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-19 19:17:17', '2013-12-19 20:07:30', '1'),
(22, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-19 20:10:36', '2013-12-19 20:12:26', '1'),
(23, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-19 20:15:22', '2013-12-19 20:15:40', '1'),
(24, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-19 20:17:21', '2013-12-19 20:20:19', '1'),
(25, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-19 20:20:46', '2013-12-19 20:21:05', '1'),
(26, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-20 17:32:12', '2013-12-28 17:46:06', '1'),
(27, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-28 17:52:07', '2013-12-28 17:52:07', '0'),
(28, 17, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-30 14:10:14', '2013-12-30 14:10:14', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_linkedin`
--

CREATE TABLE IF NOT EXISTS `xz_social_linkedin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `linkedin_access_token` varchar(250) NOT NULL,
  `linkedin_userid` varchar(20) NOT NULL,
  `linkedin_username` varchar(40) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `xz_social_linkedin`
--

INSERT INTO `xz_social_linkedin` (`id`, `user_id`, `linkedin_access_token`, `linkedin_userid`, `linkedin_username`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 15, 'AQW2rJYlMO0qgvHbTuYuqeBtVTNq8j4v9cO9F8GnPENo2e-ngneTGvPI0-GTqifaR6E-7A7IjDEuHH_2SCwyTFRmWb98RctJJQW8lK_3p5551wQPvCgW2eBny1vG4VlFujtzf1kASxVjte_6hMHmRdEzOLtTh8yHRbZACkRoRsO-21hUmCo', 'X4w47fwaaf', 'Andy Xiao', '2013-12-21 16:04:05', '2013-12-21 16:47:43', '1'),
(2, 15, 'AQWnKG6O86W6F8kaLx4Ul3Jdf4x65isN0FUId6mGkg-G5rVakKVvo2TWv1thUyVu48aaXCBOzBCbmUChikb1frnAlAh10geC6CDMCzTBMe4ubr5iRHNyDOGv0s-bGMWcYrPIGU3_CXQhQM_U1cUAaGx7SoWNDYVqcpjUY7hb_0nQ7iRB340', 'X4w47fwaaf', 'Andy Xiao', '2013-12-21 16:23:18', '2013-12-21 16:47:51', '1'),
(3, 15, 'AQVHfoOXajlRP4hIWELtQNv5gvaDgTY3_gWafOwjFUzCVJLCsQ1QNDaZ2n9ae6N1l5RBuLvjuRLGPGjMfWHthUgHIVIqeTfm9Mq7SQdSOk-fJVGwJjPgnSIK7sqvuNpivIofmpnPBSxYEaV8rQ5XziONOzf3EaGTzJZvjxZk7YzxWOIkodE', 'X4w47fwaaf', 'Andy Xiao', '2013-12-21 16:30:52', '2013-12-21 16:47:55', '1'),
(4, 15, 'AQWlI-T1K2pPwzUc4BPKIFfXOEISTsezDW3LFN_6v_fRzrXt0ApPutqq4604eciIFfeECbMsdcnKfrU8P76qcjmbG4QP3wXAbRLf8S6-Plid7rKY0fS6jdXOfW6xxzaoNxON2BxDvlLfNYIB5op3yKOTQbQcqVDB5XmQISbT6J-V2NvAMzU', 'X4w47fwaaf', 'Andy Xiao', '2013-12-21 16:50:47', '2013-12-21 16:50:47', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_pinterest`
--

CREATE TABLE IF NOT EXISTS `xz_social_pinterest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `xz_social_pinterest`
--

INSERT INTO `xz_social_pinterest` (`id`, `user_id`, `name`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 15, 'FashionEdible', '2013-11-02 00:17:14', '2013-12-20 19:07:50', '1'),
(2, 15, 'sarahlynn2254', '2013-11-02 00:18:39', '2013-11-02 00:18:39', '0'),
(3, 15, 'hehe', '2013-11-10 11:08:21', '2013-11-10 11:08:31', '0'),
(4, 15, 'asd', '2013-12-20 18:24:22', '2013-12-20 18:24:22', '0'),
(5, 15, 'asd111', '2013-12-20 18:24:37', '2013-12-20 18:24:37', '0'),
(6, 15, 'asddasdas', '2013-12-20 18:24:49', '2013-12-20 18:24:49', '0'),
(7, 15, 'asdasdasdasd', '2013-12-20 18:25:10', '2013-12-20 18:25:10', '0'),
(8, 15, 'asdasdasdasd111', '2013-12-20 18:25:16', '2013-12-20 18:25:16', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_reddit`
--

CREATE TABLE IF NOT EXISTS `xz_social_reddit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `reddit_userid` varchar(15) NOT NULL,
  `reddit_access_token` varchar(50) NOT NULL,
  `reddit_refresh_token` varchar(50) NOT NULL,
  `reddit_name` varchar(30) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `xz_social_reddit`
--

INSERT INTO `xz_social_reddit` (`id`, `user_id`, `reddit_userid`, `reddit_access_token`, `reddit_refresh_token`, `reddit_name`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 15, 'duez9', 'JPBbHaoTngdfO_UIOYzeK3BZ2_o', 'BYt_4111j7K1Av0CY051rovyQJo', 'andybegin', '2013-12-22 15:41:54', '2013-12-22 17:15:10', '1'),
(2, 15, 'duez9', 'dfOLJfW_6mKEFaeNNE8f-H37b20', 'TQXjnVhoE3YHiWUPlehkanyzniY', 'andybegin', '2013-12-22 17:16:00', '2013-12-22 17:16:08', '1'),
(3, 15, 'duez9', 'M6hvXYx9x7B7ir8gK7VUJ3yvD-I', 'Qm7wnW1ulNY0OHc0pqmP8pnTPaA', 'andybegin', '2013-12-22 17:16:19', '2013-12-22 17:16:19', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_renren`
--

CREATE TABLE IF NOT EXISTS `xz_social_renren` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `renren_uid` int(10) unsigned NOT NULL,
  `renren_access_token` varchar(100) NOT NULL,
  `renren_refresh_token` varchar(100) NOT NULL,
  `renren_username` varchar(50) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `xz_social_renren`
--

INSERT INTO `xz_social_renren` (`id`, `user_id`, `renren_uid`, `renren_access_token`, `renren_refresh_token`, `renren_username`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 15, 268156679, '244136|6.1da4a466427297a40d1b2c2b4294f4c4.2592000.1390410000-268156679', '244136|0.LzhmwFnZt598305pn86tUliNdHO351bQ.268156679.1384443567457', '肖哲ˉAndyBegin', '2013-12-23 11:57:16', '2013-12-23 15:08:56', '1'),
(2, 15, 268156679, '244136|6.d4392f8559fab30eb0b2b0e830185b6d.2592000.1390424400-268156679', '244136|0.LzhmwFnZt598305pn86tUliNdHO351bQ.268156679.1384443567457', '肖哲ˉAndyBegin', '2013-12-23 15:09:07', '2014-01-17 23:13:04', '1'),
(3, 15, 579314148, '244136|6.cad11ee1b1207613e0bb76d4b5a78a7d.2592000.1392480000-579314148', '244136|0.eK7X6jjpa53rxp9C2QEVbI6cUKyjTsCr.579314148.1389887451373', '肖哲', '2014-01-16 16:50:50', '2014-01-17 23:11:31', '1'),
(4, 15, 579314148, '244136|6.49af52bff9508e2abad225a0a35fac06.2592000.1392591600-579314148', '244136|0.eK7X6jjpa53rxp9C2QEVbI6cUKyjTsCr.579314148.1389887451373', '肖哲', '2014-01-17 23:11:59', '2014-01-17 23:11:59', '0'),
(5, 15, 268156679, '244136|6.7e66b886ac1c172ce3b8011f7e55dd42.2592000.1392591600-268156679', '244136|0.LzhmwFnZt598305pn86tUliNdHO351bQ.268156679.1384443567457', '肖哲ˉAndyBegin', '2014-01-17 23:13:25', '2014-01-17 23:13:25', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_rss`
--

CREATE TABLE IF NOT EXISTS `xz_social_rss` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `rss_master_id` int(10) unsigned NOT NULL,
  `rss_category_id` int(10) unsigned NOT NULL COMMENT '当是用户添加的RSS，则存在。后台添加的不存在。',
  `url` varchar(255) NOT NULL,
  `name` varchar(40) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`rss_master_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `xz_social_rss`
--

INSERT INTO `xz_social_rss` (`id`, `user_id`, `rss_master_id`, `rss_category_id`, `url`, `name`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 15, 1, 0, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', '2013-12-30 01:08:09', '2013-12-30 01:08:09', '0'),
(2, 15, 1, 0, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', '2013-12-30 01:09:00', '2013-12-30 01:09:00', '0'),
(3, 15, 1, 0, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', '2013-12-30 01:19:59', '2013-12-30 01:19:59', '0'),
(4, 15, 1, 0, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', '2013-12-30 01:23:50', '2013-12-30 01:23:50', '0'),
(5, 15, 1, 0, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', '2013-12-30 01:24:11', '2013-12-30 01:24:11', '0'),
(6, 15, 1, 0, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', '2013-12-30 01:24:30', '2013-12-30 01:24:30', '0'),
(7, 15, 1, 0, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', '2013-12-30 01:27:24', '2013-12-30 01:27:24', '0'),
(8, 15, 1, 0, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', '2013-12-30 01:27:26', '2013-12-30 01:27:26', '0'),
(9, 15, 2, 0, 'http://sports.yahoo.com/nba/teams/mia/rss.xml', 'NBA - Miami Heat News', '2013-12-30 14:16:11', '2013-12-30 14:16:11', '0'),
(10, 15, 2, 0, 'http://sports.yahoo.com/nba/teams/mia/rss.xml', 'NBA - Miami Heat News', '2013-12-30 14:17:30', '2013-12-30 14:17:30', '0'),
(12, 15, 3, 4, 'http://sports.yahoo.com/nba/teams/dal/rss.xml', 'dalas', '2013-12-30 16:49:15', '2013-12-30 16:53:17', '1'),
(13, 15, 3, 4, 'http://sports.yahoo.com/nba/teams/dal/rss.xml', 'dallas', '2013-12-30 16:54:10', '2013-12-30 16:54:20', '1'),
(14, 15, 3, 4, 'http://sports.yahoo.com/nba/teams/dal/rss.xml', 'dalllas', '2013-12-30 16:54:38', '2013-12-30 16:54:38', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_rss_category`
--

CREATE TABLE IF NOT EXISTS `xz_social_rss_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `xz_social_rss_category`
--

INSERT INTO `xz_social_rss_category` (`id`, `user_id`, `name`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 0, '新闻', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0'),
(2, 0, '财经', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0'),
(3, 0, '科技', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0'),
(4, 0, '体育', '2013-10-14 23:49:13', '2013-10-14 23:49:16', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_rss_master`
--

CREATE TABLE IF NOT EXISTS `xz_social_rss_master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `name` varchar(40) NOT NULL,
  `add_count` mediumint(5) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `xz_social_rss_master`
--

INSERT INTO `xz_social_rss_master` (`id`, `url`, `name`, `add_count`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 'http://sports.yahoo.com/nba/teams/lac/rss.xml', 'NBA - Los Angeles Clipper', 8, '2013-12-30 01:08:09', '2013-12-30 01:08:09', '0'),
(2, 'http://sports.yahoo.com/nba/teams/mia/rss.xml', 'NBA - Miami Heat News', 2, '2013-12-30 14:16:11', '2013-12-30 14:16:11', '0'),
(3, 'http://sports.yahoo.com/nba/teams/dal/rss.xml', 'dallas', 4, '2013-12-30 16:46:35', '2013-12-30 16:46:35', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_rss_xref_category`
--

CREATE TABLE IF NOT EXISTS `xz_social_rss_xref_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rss_master_id` int(10) unsigned NOT NULL,
  `rss_category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rss_master_id` (`rss_master_id`,`rss_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `xz_social_rss_xref_category`
--

INSERT INTO `xz_social_rss_xref_category` (`id`, `rss_master_id`, `rss_category_id`) VALUES
(9, 1, 1),
(10, 1, 2),
(11, 1, 3),
(12, 2, 4);

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_video56`
--

CREATE TABLE IF NOT EXISTS `xz_social_video56` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `video56_title` varchar(50) NOT NULL,
  `video56_id` smallint(5) unsigned NOT NULL,
  `video56_search_keywords` varchar(50) NOT NULL,
  `video56_type` varbinary(20) NOT NULL COMMENT 'video56的视频类型比如hot,recommend等',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `xz_social_video56`
--

INSERT INTO `xz_social_video56` (`id`, `user_id`, `video56_title`, `video56_id`, `video56_search_keywords`, `video56_type`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 0, '热点视频', 2, '', 'hot', '2013-11-20 23:36:57', '2013-11-20 23:37:00', '0'),
(2, 0, '娱乐视频', 1, '', 'hot', '2013-11-20 23:37:19', '2013-11-20 23:37:21', '0'),
(3, 0, '原创视频', 3, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(4, 0, '搞笑视频', 4, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(5, 0, '音乐视频', 41, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(6, 0, '游戏视频', 26, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(7, 0, '体育视频', 14, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(8, 0, '动漫视频', 8, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(9, 0, '汽车视频', 28, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(10, 0, '旅游视频', 27, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(11, 0, '女性视频', 11, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(12, 0, '科教视频', 10, '', 'hot', '2013-11-21 00:00:00', '2013-11-21 00:00:00', '0'),
(31, 0, '人人那些事儿', 6891, '', 'opera', '2013-11-22 00:09:43', '2013-11-22 00:09:45', '0'),
(33, 0, '大笑一方', 6897, '', 'opera', '2013-11-22 00:09:43', '2013-11-22 00:09:45', '0'),
(34, 0, '微播江湖', 6268, '', 'opera', '2013-11-22 00:09:43', '2013-11-22 00:09:45', '0'),
(35, 0, '娱乐快报', 6363, '', 'opera', '2013-11-22 00:09:43', '2013-11-22 00:09:45', '0'),
(36, 0, '音乐下午茶', 6361, '', 'opera', '2013-11-22 00:09:43', '2013-11-22 00:09:45', '0'),
(37, 0, '红人汇', 6581, '', 'opera', '2013-11-22 00:09:43', '2013-11-22 00:09:45', '0'),
(38, 0, '大话奥运', 6552, '', 'opera', '2013-11-22 00:09:43', '2013-11-22 00:09:45', '0'),
(39, 15, '', 0, 'nba', 'search', '2013-12-23 23:18:43', '2013-12-23 23:32:58', '1'),
(40, 15, '', 0, '音乐下午茶', 'search', '2013-12-24 15:57:03', '2013-12-24 15:57:03', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_social_weibo`
--

CREATE TABLE IF NOT EXISTS `xz_social_weibo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `weibo_uid` int(10) unsigned NOT NULL,
  `weibo_access_token` varchar(50) NOT NULL,
  `weibo_username` varchar(30) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `xz_social_weibo`
--

INSERT INTO `xz_social_weibo` (`id`, `user_id`, `weibo_uid`, `weibo_access_token`, `weibo_username`, `create_time`, `update_time`, `is_deleted`) VALUES
(1, 15, 2022595450, '2.00QTbsMCdY16gBded8a6ed75btEJPB', 'AndyBegin', '2013-12-23 19:27:44', '2013-12-23 20:33:43', '1'),
(2, 15, 2022595450, '2.00QTbsMCdY16gBded8a6ed75btEJPB', 'AndyBegin', '2013-12-23 22:12:10', '2013-12-23 22:12:10', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_users`
--

CREATE TABLE IF NOT EXISTS `xz_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `last_login_time` datetime NOT NULL,
  `is_admin` binary(1) NOT NULL DEFAULT '0',
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `xz_users`
--

INSERT INTO `xz_users` (`id`, `email`, `username`, `password`, `create_time`, `update_time`, `last_login_time`, `is_admin`, `is_deleted`) VALUES
(15, 'zhexiao@163.com', 'andybegin', '31efe5c727df3e9f116cd46fbb5b2626', '2013-12-16 16:57:44', '2013-12-16 16:57:44', '2014-01-24 00:20:05', '1', '0'),
(17, 'test@qq.com', 'test', '098f6bcd4621d373cade4e832627b4f6', '2013-12-16 17:03:28', '2013-12-16 17:03:28', '2014-01-14 23:50:38', '0', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_user_column`
--

CREATE TABLE IF NOT EXISTS `xz_user_column` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `view_id` int(10) unsigned NOT NULL COMMENT '用户可以存在视图1，视图2等',
  `social_type` smallint(3) NOT NULL COMMENT '详细在文件xzModel里面',
  `rss_master_id` int(10) unsigned NOT NULL COMMENT 'xz_social_rss_master的主键',
  `rss_name` varchar(40) NOT NULL,
  `instagram_id` int(10) unsigned NOT NULL COMMENT 'xz_social_instagram的主键',
  `pinterest_id` int(10) unsigned NOT NULL COMMENT 'xz_social_pinterest的主键',
  `flickr_id` int(10) unsigned NOT NULL COMMENT 'xz_social_flickr的主键',
  `linkedin_id` int(10) unsigned NOT NULL COMMENT 'xz_social_linkedin的主键',
  `reddit_id` int(10) unsigned NOT NULL COMMENT 'xz_social_reddit的主键',
  `renren_id` int(10) unsigned NOT NULL COMMENT 'xz_social_renren的主键',
  `weibo_id` int(10) unsigned NOT NULL COMMENT 'xz_social_weibo的主键',
  `video56_id` int(10) unsigned NOT NULL COMMENT 'xz_social_video56的主键',
  `youku_id` int(10) unsigned NOT NULL COMMENT 'xz_social_youku的主键',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `column_width_size` float unsigned NOT NULL DEFAULT '1' COMMENT '列的宽度值*320是当前宽度',
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pinterest_id` (`pinterest_id`),
  KEY `instagram_id` (`instagram_id`),
  KEY `flickr_id` (`flickr_id`),
  KEY `linkedin_id` (`linkedin_id`),
  KEY `reddit_id` (`reddit_id`),
  KEY `renren_id` (`renren_id`),
  KEY `weibo_id` (`weibo_id`),
  KEY `video56_id` (`video56_id`),
  KEY `youku_id` (`youku_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

--
-- 转存表中的数据 `xz_user_column`
--

INSERT INTO `xz_user_column` (`id`, `user_id`, `view_id`, `social_type`, `rss_master_id`, `rss_name`, `instagram_id`, `pinterest_id`, `flickr_id`, `linkedin_id`, `reddit_id`, `renren_id`, `weibo_id`, `video56_id`, `youku_id`, `create_time`, `update_time`, `column_width_size`, `is_deleted`) VALUES
(58, 15, 2, 2, 0, '', 26, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-20 20:08:01', '2013-12-23 11:27:47', 1, '1'),
(59, 15, 2, 3, 0, '', 0, 2, 0, 0, 0, 0, 0, 0, 0, '2013-12-20 20:08:03', '2013-12-23 11:27:45', 1, '1'),
(60, 15, 2, 4, 0, '', 0, 0, 14, 0, 0, 0, 0, 0, 0, '2013-12-20 20:08:05', '2013-12-23 11:27:42', 1, '1'),
(61, 15, 2, 3, 0, '', 0, 3, 0, 0, 0, 0, 0, 0, 0, '2013-12-20 20:08:11', '2013-12-21 02:17:33', 1, '1'),
(62, 15, 2, 5, 0, '', 0, 0, 0, 1, 0, 0, 0, 0, 0, '2013-12-21 16:20:55', '2013-12-21 16:23:04', 1, '1'),
(63, 15, 2, 5, 0, '', 0, 0, 0, 2, 0, 0, 0, 0, 0, '2013-12-21 16:23:23', '2013-12-21 16:47:51', 1, '1'),
(64, 15, 2, 5, 0, '', 0, 0, 0, 1, 0, 0, 0, 0, 0, '2013-12-21 16:47:36', '2013-12-21 16:47:43', 1, '1'),
(65, 15, 2, 5, 0, '', 0, 0, 0, 1, 0, 0, 0, 0, 0, '2013-12-21 16:47:37', '2013-12-21 16:47:43', 1, '1'),
(66, 15, 2, 5, 0, '', 0, 0, 0, 4, 0, 0, 0, 0, 0, '2013-12-21 16:50:52', '2013-12-23 11:27:39', 1, '1'),
(68, 15, 2, 6, 0, '', 0, 0, 0, 0, 2, 0, 0, 0, 0, '2013-12-22 17:16:03', '2013-12-22 17:16:09', 1, '1'),
(69, 15, 2, 6, 0, '', 0, 0, 0, 0, 2, 0, 0, 0, 0, '2013-12-22 17:16:04', '2013-12-22 17:16:09', 1, '1'),
(70, 15, 2, 6, 0, '', 0, 0, 0, 0, 2, 0, 0, 0, 0, '2013-12-22 17:16:05', '2013-12-22 17:16:09', 1, '1'),
(71, 15, 2, 6, 0, '', 0, 0, 0, 0, 3, 0, 0, 0, 0, '2013-12-22 17:16:23', '2013-12-23 11:27:36', 1, '1'),
(72, 15, 21, 2, 0, '', 26, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-22 17:49:56', '2013-12-28 17:51:57', 1, '1'),
(73, 15, 14, 3, 0, '', 0, 2, 0, 0, 0, 0, 0, 0, 0, '2013-12-22 17:50:04', '2013-12-22 17:50:04', 1, '0'),
(74, 15, 2, 7, 0, '', 0, 0, 0, 0, 0, 1, 0, 0, 0, '2013-12-23 11:59:14', '2013-12-23 15:08:56', 1, '1'),
(75, 15, 2, 7, 0, '', 0, 0, 0, 0, 0, 1, 0, 0, 0, '2013-12-23 15:08:51', '2013-12-23 15:08:56', 1, '1'),
(76, 15, 2, 7, 0, '', 0, 0, 0, 0, 0, 1, 0, 0, 0, '2013-12-23 15:08:52', '2013-12-23 15:08:56', 1, '1'),
(77, 15, 2, 7, 0, '', 0, 0, 0, 0, 0, 2, 0, 0, 0, '2013-12-23 15:09:11', '2013-12-23 15:12:15', 1, '1'),
(78, 15, 2, 7, 0, '', 0, 0, 0, 0, 0, 2, 0, 0, 0, '2013-12-23 15:12:20', '2013-12-23 23:06:32', 1, '1'),
(79, 15, 2, 2, 0, '', 26, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-23 15:15:18', '2013-12-23 23:06:29', 1, '1'),
(80, 15, 2, 6, 0, '', 0, 0, 0, 0, 3, 0, 0, 0, 0, '2013-12-23 18:38:21', '2013-12-23 18:39:42', 1, '1'),
(81, 15, 2, 8, 0, '', 0, 0, 0, 0, 0, 0, 1, 0, 0, '2013-12-23 19:58:48', '2013-12-23 20:33:43', 1, '1'),
(82, 15, 2, 8, 0, '', 0, 0, 0, 0, 0, 0, 2, 0, 0, '2013-12-23 22:12:32', '2013-12-23 23:06:27', 1, '1'),
(83, 15, 2, 2, 0, '', 26, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-23 22:15:04', '2013-12-23 22:15:07', 1, '1'),
(84, 15, 2, 9, 0, '', 0, 0, 0, 0, 0, 0, 0, 5, 0, '2013-12-23 22:41:11', '2013-12-23 23:06:42', 1, '1'),
(86, 15, 2, 9, 0, '', 0, 0, 0, 0, 0, 0, 0, 39, 0, '2013-12-23 23:18:43', '2013-12-23 23:27:30', 1, '1'),
(87, 15, 2, 9, 0, '', 0, 0, 0, 0, 0, 0, 0, 39, 0, '2013-12-23 23:27:35', '2013-12-23 23:32:58', 1, '1'),
(88, 15, 2, 9, 0, '', 0, 0, 0, 0, 0, 0, 0, 5, 0, '2013-12-24 15:55:55', '2013-12-24 15:56:51', 1, '1'),
(89, 15, 2, 8, 0, '', 0, 0, 0, 0, 0, 0, 2, 0, 0, '2013-12-24 15:56:38', '2013-12-30 15:51:17', 1.5, '1'),
(90, 15, 2, 7, 0, '', 0, 0, 0, 0, 0, 2, 0, 0, 0, '2013-12-24 15:56:45', '2013-12-30 15:51:14', 1, '1'),
(91, 15, 2, 9, 0, '', 0, 0, 0, 0, 0, 0, 0, 40, 0, '2013-12-24 15:57:04', '2013-12-24 15:57:51', 1, '1'),
(92, 15, 2, 9, 0, '', 0, 0, 0, 0, 0, 0, 0, 5, 0, '2013-12-24 15:58:03', '2013-12-24 16:07:10', 1, '1'),
(93, 15, 2, 2, 0, '', 26, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-24 17:31:43', '2013-12-28 17:46:07', 1, '1'),
(94, 15, 21, 2, 0, '', 27, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-28 17:52:14', '2013-12-28 17:52:14', 1, '0'),
(95, 15, 2, 2, 0, '', 27, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-28 17:53:23', '2013-12-30 15:51:11', 1, '1'),
(96, 17, 3, 2, 0, '', 28, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 14:10:17', '2013-12-30 14:10:21', 1.5, '0'),
(97, 15, 2, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 15:52:40', '2013-12-30 15:59:52', 1, '1'),
(98, 15, 2, 1, 2, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 15:59:55', '2013-12-30 16:34:16', 1, '1'),
(99, 15, 2, 1, 2, 'NBA - Miami Heat News', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:35:19', '2013-12-30 16:36:26', 1, '1'),
(100, 15, 2, 1, 1, 'NBA - Los Angeles Clipper', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:35:56', '2013-12-30 16:36:23', 1, '1'),
(101, 15, 2, 1, 2, 'NBA - Miami Heat News', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:36:28', '2013-12-30 16:48:51', 1.5, '1'),
(102, 15, 2, 1, 3, 'dallas', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:47:06', '2013-12-30 16:48:48', 1, '1'),
(103, 15, 2, 1, 3, 'dalas', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:49:16', '2013-12-30 16:54:01', 1, '1'),
(104, 15, 2, 1, 3, 'dalas', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:53:14', '2013-12-30 16:53:59', 1, '1'),
(105, 15, 2, 1, 3, 'dallas', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:54:12', '2013-12-30 16:54:20', 1, '1'),
(106, 15, 2, 1, 3, 'dallas', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:54:12', '2013-12-30 16:54:20', 1, '1'),
(107, 15, 2, 1, 2, 'NBA - Miami Heat News', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:54:32', '2014-01-02 16:09:11', 1, '1'),
(108, 15, 2, 1, 3, 'dalllas', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-30 16:54:39', '2014-01-02 16:09:08', 1, '1'),
(109, 15, 2, 1, 1, 'NBA - Los Angeles Clipper', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2014-01-13 23:19:15', '2014-01-13 23:19:15', 1, '0'),
(110, 15, 2, 4, 0, '', 0, 0, 14, 0, 0, 0, 0, 0, 0, '2014-01-13 23:19:23', '2014-01-17 21:43:00', 1, '1'),
(111, 15, 2, 2, 0, '', 27, 0, 0, 0, 0, 0, 0, 0, 0, '2014-01-13 23:19:26', '2014-01-21 22:45:53', 1, '1'),
(112, 15, 2, 7, 0, '', 0, 0, 0, 0, 0, 3, 0, 0, 0, '2014-01-16 16:51:11', '2014-01-16 16:51:23', 1, '1'),
(113, 15, 2, 3, 0, '', 0, 2, 0, 0, 0, 0, 0, 0, 0, '2014-01-20 20:31:48', '2014-01-21 22:45:48', 1, '1'),
(114, 15, 2, 8, 0, '', 0, 0, 0, 0, 0, 0, 2, 0, 0, '2014-01-21 22:45:58', '2014-01-22 22:38:47', 1.5, '0'),
(115, 15, 2, 6, 0, '', 0, 0, 0, 0, 3, 0, 0, 0, 0, '2014-01-24 01:09:27', '2014-01-24 01:09:27', 1, '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_user_view`
--

CREATE TABLE IF NOT EXISTS `xz_user_view` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(25) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `view_type` binary(1) NOT NULL DEFAULT '0' COMMENT '0代表列是扩展；1代表列是紧凑',
  `is_active` binary(1) NOT NULL DEFAULT '0' COMMENT '是否使用当前视图',
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `xz_user_view`
--

INSERT INTO `xz_user_view` (`id`, `user_id`, `name`, `create_time`, `update_time`, `view_type`, `is_active`, `is_deleted`) VALUES
(1, 3, '默认', '2013-12-16 16:54:00', '2013-12-16 16:54:00', '0', '1', '0'),
(2, 15, '默认', '2013-12-16 16:57:44', '2014-01-13 23:18:52', '1', '1', '0'),
(3, 17, '默认', '2013-12-16 17:03:28', '2013-12-16 17:03:28', '0', '1', '0'),
(4, 15, '默认1', '2013-12-16 16:57:44', '2013-12-16 21:01:46', '0', '0', '1'),
(6, 15, 'asd', '2013-12-16 21:31:42', '2013-12-16 22:16:59', '0', '0', '1'),
(7, 15, 'asd', '2013-12-16 21:31:56', '2013-12-16 22:17:00', '0', '0', '1'),
(8, 15, 'wwww', '2013-12-16 21:38:36', '2013-12-16 22:16:51', '0', '0', '1'),
(9, 15, '123123', '2013-12-16 21:40:00', '2013-12-16 22:16:58', '0', '0', '1'),
(10, 15, '现在', '2013-12-16 21:44:58', '2013-12-16 22:16:47', '0', '0', '1'),
(11, 15, 'neal', '2013-12-16 21:46:37', '2013-12-16 22:15:49', '0', '0', '1'),
(12, 15, '111', '2013-12-16 22:14:06', '2013-12-16 22:15:41', '0', '0', '1'),
(13, 15, '财经', '2013-12-16 22:17:25', '2013-12-16 22:48:31', '0', '0', '1'),
(14, 15, '新闻', '2013-12-16 22:17:33', '2014-01-13 23:18:43', '0', '0', '0'),
(15, 15, '231', '2013-12-16 22:19:54', '2013-12-16 22:20:01', '0', '0', '1'),
(16, 15, '才才', '2013-12-16 22:49:09', '2013-12-16 22:51:35', '0', '0', '1'),
(17, 15, '123', '2013-12-16 23:06:44', '2013-12-16 23:07:06', '0', '0', '1'),
(18, 15, '123dfd', '2013-12-16 23:06:51', '2013-12-16 23:07:08', '0', '0', '1'),
(19, 15, '123dfdgsdfgsdfg', '2013-12-16 23:06:54', '2013-12-16 23:07:04', '0', '0', '1'),
(20, 15, '呵呵', '2013-12-16 23:12:57', '2013-12-16 23:13:08', '0', '0', '1'),
(21, 15, '呵呵', '2013-12-16 23:13:10', '2014-01-13 23:18:52', '0', '0', '0'),
(22, 15, 'good', '2013-12-16 23:36:25', '2013-12-16 23:36:56', '0', '0', '1'),
(23, 15, 'asd', '2013-12-19 17:48:18', '2013-12-19 18:05:35', '0', '0', '1'),
(24, 15, 'asdasd', '2013-12-19 17:49:10', '2013-12-19 18:05:29', '0', '0', '1'),
(25, 15, '2134', '2013-12-19 17:53:24', '2013-12-19 18:05:26', '0', '0', '1'),
(26, 15, '21342', '2013-12-19 17:53:30', '2013-12-19 18:05:23', '0', '0', '1'),
(27, 15, '21342 111', '2013-12-19 17:53:38', '2013-12-19 18:05:19', '0', '0', '1'),
(28, 15, '啊啊啊', '2013-12-19 17:55:45', '2013-12-19 18:05:14', '0', '0', '1'),
(29, 15, 'asd', '2013-12-19 18:05:47', '2013-12-19 18:05:51', '0', '0', '1'),
(30, 15, 'asd', '2013-12-19 18:06:22', '2013-12-19 18:06:25', '0', '0', '1');
