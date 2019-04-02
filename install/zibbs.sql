-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 09 月 04 日 07:10
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";##
SET time_zone = "+00:00";##


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;##
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;##
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;##
/*!40101 SET NAMES utf8 */;##

-- --------------------------------------------------------

--
-- 表的结构 `zibbs_admin`
--

CREATE TABLE IF NOT EXISTS `zibbs_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;##

-- --------------------------------------------------------

--
-- 表的结构 `zibbs_master_pmb`
--

CREATE TABLE IF NOT EXISTS `zibbs_master_pmb` (
  `num` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `createdDate` int(11) NOT NULL,
  `createdByUserNum` int(11) unsigned NOT NULL COMMENT '接收人',
  `updatedDate` int(11) NOT NULL,
  `updatedByUserNum` int(11) unsigned NOT NULL COMMENT '发送人',
  `message_read` tinyint(1) unsigned NOT NULL,
  `r_num` int(11) DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `t_num` int(11) DEFAULT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;##

-- --------------------------------------------------------

--
-- 表的结构 `zibbs_posts`
--

CREATE TABLE IF NOT EXISTS `zibbs_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `views` int(11) NOT NULL,
  `answers` int(11) NOT NULL,
  `tagid` int(11) NOT NULL,
  `newtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;##

-- --------------------------------------------------------

--
-- 表的结构 `zibbs_replies`
--

CREATE TABLE IF NOT EXISTS `zibbs_replies` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `ruserid` int(11) NOT NULL,
  `rcontent` text COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL,
  `rtime` datetime NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;##

-- --------------------------------------------------------

--
-- 表的结构 `zibbs_setting`
--

CREATE TABLE IF NOT EXISTS `zibbs_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteurl` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sitetitle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sitekeywords` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sitedescription` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `smtphost` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `smtpuser` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `smtppsw` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `smtpemail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `smtpsubject` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `smtpcontent` text COLLATE utf8_unicode_ci NOT NULL,
  `bbsmeta` text COLLATE utf8_unicode_ci NOT NULL,
  `bbslink` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;##

--
-- 转存表中的数据 `zibbs_setting`
--

INSERT INTO `zibbs_setting` (`id`, `siteurl`, `sitetitle`, `sitekeywords`, `sitedescription`, `smtphost`, `smtpuser`, `smtppsw`, `smtpemail`, `smtpsubject`, `smtpcontent`, `bbsmeta`, `bbslink`) VALUES
(1, '', 'zibbs官方网站,php开源社区论坛', '梓论坛，原创PHP论坛，轻论坛', 'zibbs官方网站,PHP开源社区论坛,PHP论坛源码,PHP轻论坛,全新的社区系统', '', '', '', '', '梓论坛用户激活邮件', '欢迎您的注册，请体验此社区的魅力', '&lt;p style=&quot;text-align:center&quot;&gt;梓论坛 ( zibbs )&lt;/p&gt;\n&lt;p style=&quot;text-indent:2em;font-size:14px;color:#666;line-height:2;&quot;&gt;梓论坛是由原“了了社区”升级而来，正式启用新名称“梓论坛”，是一款基于Bootstrap的轻论坛系统，自适应于PC、平板以及手机设备，同时也是开发者对于轻论坛系统的二次理解，随着技术的不断积累，一些更优秀的插件也需要被引入，服务于广大的用户。&lt;/p&gt;&lt;p&gt;下载地址：&lt;br&gt;&lt;a href=&quot;https://github.com/xujinliang/zibbs&quot;&gt;https://github.com/xujinliang/zibbs&lt;/a&gt;&lt;/p&gt;', 'php混淆加密|http://www.youyax.com/phpjmx\nxlert弹出层|http://www.youyax.com/xlert') ;##

-- --------------------------------------------------------

--
-- 表的结构 `zibbs_slave_pmb`
--

CREATE TABLE IF NOT EXISTS `zibbs_slave_pmb` (
  `num` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `createdDate` int(11) NOT NULL,
  `createdByUserNum` int(11) unsigned NOT NULL COMMENT '发送人',
  `updatedDate` int(11) NOT NULL,
  `updatedByUserNum` int(11) unsigned NOT NULL,
  `message_read` tinyint(1) unsigned NOT NULL,
  `r_num` int(11) DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `t_num` int(11) DEFAULT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;##

-- --------------------------------------------------------

--
-- 表的结构 `zibbs_tags`
--

CREATE TABLE IF NOT EXISTS `zibbs_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;##

-- --------------------------------------------------------

--
-- 表的结构 `zibbs_user`
--

CREATE TABLE IF NOT EXISTS `zibbs_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `msgmark` tinyint(1) NOT NULL COMMENT '消息标记',
  `status` tinyint(1) NOT NULL COMMENT '-1,系统用户，0未激活，1正常状态，2禁言',
  `code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `whoami` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;##

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;##
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;##
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;##
