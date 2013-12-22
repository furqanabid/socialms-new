-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 12 月 22 日 17:52
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

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
(26, 15, 305096535, '305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f', 'andybegin', 'Andy Xiao', '2013-12-20 17:32:12', '2013-12-20 17:32:12', '0');

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
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `xz_users`
--

INSERT INTO `xz_users` (`id`, `email`, `username`, `password`, `create_time`, `update_time`, `last_login_time`, `is_deleted`) VALUES
(15, 'zhexiao@163.com', 'andybegin', '31efe5c727df3e9f116cd46fbb5b2626', '2013-12-16 16:57:44', '2013-12-16 16:57:44', '2013-12-22 15:14:41', '0'),
(17, 'test@qq.com', 'test', '098f6bcd4621d373cade4e832627b4f6', '2013-12-16 17:03:28', '2013-12-16 17:03:28', '2013-12-16 17:03:28', '0');

-- --------------------------------------------------------

--
-- 表的结构 `xz_user_column`
--

CREATE TABLE IF NOT EXISTS `xz_user_column` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `view_id` int(10) unsigned NOT NULL COMMENT '用户可以存在视图1，视图2等',
  `social_type` smallint(3) NOT NULL COMMENT '详细在文件xzModel里面',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- 转存表中的数据 `xz_user_column`
--

INSERT INTO `xz_user_column` (`id`, `user_id`, `view_id`, `social_type`, `instagram_id`, `pinterest_id`, `flickr_id`, `linkedin_id`, `reddit_id`, `renren_id`, `weibo_id`, `video56_id`, `youku_id`, `create_time`, `update_time`, `is_deleted`) VALUES
(58, 15, 2, 2, 26, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-20 20:08:01', '2013-12-20 20:08:01', '0'),
(59, 15, 2, 3, 0, 2, 0, 0, 0, 0, 0, 0, 0, '2013-12-20 20:08:03', '2013-12-20 20:08:03', '0'),
(60, 15, 2, 4, 0, 0, 14, 0, 0, 0, 0, 0, 0, '2013-12-20 20:08:05', '2013-12-20 20:08:05', '0'),
(61, 15, 2, 3, 0, 3, 0, 0, 0, 0, 0, 0, 0, '2013-12-20 20:08:11', '2013-12-21 02:17:33', '1'),
(62, 15, 2, 5, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2013-12-21 16:20:55', '2013-12-21 16:23:04', '1'),
(63, 15, 2, 5, 0, 0, 0, 2, 0, 0, 0, 0, 0, '2013-12-21 16:23:23', '2013-12-21 16:47:51', '1'),
(64, 15, 2, 5, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2013-12-21 16:47:36', '2013-12-21 16:47:43', '1'),
(65, 15, 2, 5, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2013-12-21 16:47:37', '2013-12-21 16:47:43', '1'),
(66, 15, 2, 5, 0, 0, 0, 4, 0, 0, 0, 0, 0, '2013-12-21 16:50:52', '2013-12-21 16:50:52', '0'),
(68, 15, 2, 6, 0, 0, 0, 0, 2, 0, 0, 0, 0, '2013-12-22 17:16:03', '2013-12-22 17:16:09', '1'),
(69, 15, 2, 6, 0, 0, 0, 0, 2, 0, 0, 0, 0, '2013-12-22 17:16:04', '2013-12-22 17:16:09', '1'),
(70, 15, 2, 6, 0, 0, 0, 0, 2, 0, 0, 0, 0, '2013-12-22 17:16:05', '2013-12-22 17:16:09', '1'),
(71, 15, 2, 6, 0, 0, 0, 0, 3, 0, 0, 0, 0, '2013-12-22 17:16:23', '2013-12-22 17:16:23', '0'),
(72, 15, 21, 2, 26, 0, 0, 0, 0, 0, 0, 0, 0, '2013-12-22 17:49:56', '2013-12-22 17:49:56', '0'),
(73, 15, 14, 3, 0, 2, 0, 0, 0, 0, 0, 0, 0, '2013-12-22 17:50:04', '2013-12-22 17:50:04', '0');

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
  `is_active` binary(1) NOT NULL DEFAULT '0' COMMENT '是否使用当前视图',
  `is_deleted` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `xz_user_view`
--

INSERT INTO `xz_user_view` (`id`, `user_id`, `name`, `create_time`, `update_time`, `is_active`, `is_deleted`) VALUES
(1, 3, '默认', '2013-12-16 16:54:00', '2013-12-16 16:54:00', '1', '0'),
(2, 15, '默认', '2013-12-16 16:57:44', '2013-12-22 17:50:07', '1', '0'),
(3, 17, '默认', '2013-12-16 17:03:28', '2013-12-16 17:03:28', '1', '0'),
(4, 15, '默认1', '2013-12-16 16:57:44', '2013-12-16 21:01:46', '0', '1'),
(6, 15, 'asd', '2013-12-16 21:31:42', '2013-12-16 22:16:59', '0', '1'),
(7, 15, 'asd', '2013-12-16 21:31:56', '2013-12-16 22:17:00', '0', '1'),
(8, 15, 'wwww', '2013-12-16 21:38:36', '2013-12-16 22:16:51', '0', '1'),
(9, 15, '123123', '2013-12-16 21:40:00', '2013-12-16 22:16:58', '0', '1'),
(10, 15, '现在', '2013-12-16 21:44:58', '2013-12-16 22:16:47', '0', '1'),
(11, 15, 'neal', '2013-12-16 21:46:37', '2013-12-16 22:15:49', '0', '1'),
(12, 15, '111', '2013-12-16 22:14:06', '2013-12-16 22:15:41', '0', '1'),
(13, 15, '财经', '2013-12-16 22:17:25', '2013-12-16 22:48:31', '0', '1'),
(14, 15, '新闻', '2013-12-16 22:17:33', '2013-12-22 17:50:07', '0', '0'),
(15, 15, '231', '2013-12-16 22:19:54', '2013-12-16 22:20:01', '0', '1'),
(16, 15, '才才', '2013-12-16 22:49:09', '2013-12-16 22:51:35', '0', '1'),
(17, 15, '123', '2013-12-16 23:06:44', '2013-12-16 23:07:06', '0', '1'),
(18, 15, '123dfd', '2013-12-16 23:06:51', '2013-12-16 23:07:08', '0', '1'),
(19, 15, '123dfdgsdfgsdfg', '2013-12-16 23:06:54', '2013-12-16 23:07:04', '0', '1'),
(20, 15, '呵呵', '2013-12-16 23:12:57', '2013-12-16 23:13:08', '0', '1'),
(21, 15, '呵呵', '2013-12-16 23:13:10', '2013-12-22 17:50:06', '0', '0'),
(22, 15, 'good', '2013-12-16 23:36:25', '2013-12-16 23:36:56', '0', '1'),
(23, 15, 'asd', '2013-12-19 17:48:18', '2013-12-19 18:05:35', '0', '1'),
(24, 15, 'asdasd', '2013-12-19 17:49:10', '2013-12-19 18:05:29', '0', '1'),
(25, 15, '2134', '2013-12-19 17:53:24', '2013-12-19 18:05:26', '0', '1'),
(26, 15, '21342', '2013-12-19 17:53:30', '2013-12-19 18:05:23', '0', '1'),
(27, 15, '21342 111', '2013-12-19 17:53:38', '2013-12-19 18:05:19', '0', '1'),
(28, 15, '啊啊啊', '2013-12-19 17:55:45', '2013-12-19 18:05:14', '0', '1'),
(29, 15, 'asd', '2013-12-19 18:05:47', '2013-12-19 18:05:51', '0', '1'),
(30, 15, 'asd', '2013-12-19 18:06:22', '2013-12-19 18:06:25', '0', '1');
