-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主机： mysql.zhjlfx.cn
-- 生成日期： 2020-08-28 20:09:00
-- 服务器版本： 10.3.17-MariaDB
-- PHP 版本： 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `ucenter`
--

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `username` char(50) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `email` char(32) NOT NULL DEFAULT '',
  `myid` char(30) NOT NULL DEFAULT '',
  `myidkey` char(16) NOT NULL DEFAULT '',
  `regip` char(50) NOT NULL DEFAULT '',
  `regdate` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lastloginip` int(10) NOT NULL DEFAULT 0,
  `lastlogintime` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `salt` char(6) NOT NULL,
  `secques` char(8) NOT NULL DEFAULT '',
  `vtime` int(11) NOT NULL DEFAULT 0,
  `userid` varchar(50) DEFAULT NULL,
  `uuid` varchar(50) DEFAULT NULL,
  `texturedata` text NOT NULL DEFAULT '{"timestamp":1597140006232,"profileId":"cabb3c5768f33e1c87a407ad30e355bf","profileName":"noavatar","isPublic":true,"textures":{"SKIN":{"url":"https://skin.9cymc.cn/textures/83cee5ca6afcdb171285aa00e8049c297b2dbeba0efb8ff970a5677a1b644032","metadata":{"model":"slim"}}}}',
  `mojang` varchar(255) DEFAULT 'false',
  `space` varchar(50) DEFAULT '&nbsp'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `vailtoken`
--

DROP TABLE IF EXISTS `vailtoken`;
CREATE TABLE `vailtoken` (
  `id` int(10) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `vtime` int(10) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `userid` (`userid`),
  ADD KEY `email` (`email`);

--
-- 表的索引 `vailtoken`
--
ALTER TABLE `vailtoken`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `uid` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `vailtoken`
--
ALTER TABLE `vailtoken`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
