-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:3306
-- 生成日期： 2024-07-05 23:16:59
-- 服务器版本： 8.0.37-0ubuntu0.22.04.3
-- PHP 版本： 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `pinkcandydb`
--

-- --------------------------------------------------------

--
-- 表的结构 `account`
--

CREATE TABLE `account` (
  `Id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `info` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sex` varchar(255) NOT NULL,
  `sort` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `coin` int NOT NULL,
  `jointime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `badges`
--

CREATE TABLE `badges` (
  `Id` int NOT NULL,
  `code` varchar(255) NOT NULL,
  `badge` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `badges_account`
--

CREATE TABLE `badges_account` (
  `Id` int NOT NULL,
  `code` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `approve` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `board`
--

CREATE TABLE `board` (
  `Id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `ciphertext`
--

CREATE TABLE `ciphertext` (
  `Id` int NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `info` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `filenumber` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `filename` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `entrykey` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `life` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE `comments` (
  `Id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `point` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `connect`
--

CREATE TABLE `connect` (
  `Id` int NOT NULL,
  `tagid` varchar(255) NOT NULL,
  `galleryid` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `essay`
--

CREATE TABLE `essay` (
  `Id` int NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `galleryid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `gallery`
--

CREATE TABLE `gallery` (
  `Id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `info` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `visit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `paw_essay`
--

CREATE TABLE `paw_essay` (
  `Id` int NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `essayid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `paw_postcomments`
--

CREATE TABLE `paw_postcomments` (
  `Id` int NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `commentid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `paw_posts`
--

CREATE TABLE `paw_posts` (
  `Id` int NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `postid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `postcomments`
--

CREATE TABLE `postcomments` (
  `Id` int NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `postid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `galleryid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `postimgid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pawnum` int NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `postimg`
--

CREATE TABLE `postimg` (
  `Id` int NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `postreply`
--

CREATE TABLE `postreply` (
  `Id` int NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `commentid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `postid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `posts`
--

CREATE TABLE `posts` (
  `Id` int NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subtitle` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `postid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `galleryid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `postimgid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pawnum` int NOT NULL,
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `poststar`
--

CREATE TABLE `poststar` (
  `Id` int NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `postid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `star`
--

CREATE TABLE `star` (
  `Id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `galleryid` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `tags`
--

CREATE TABLE `tags` (
  `Id` int NOT NULL,
  `tag` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `tags_posts`
--

CREATE TABLE `tags_posts` (
  `Id` int NOT NULL,
  `tagid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `postid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `watch`
--

CREATE TABLE `watch` (
  `Id` int NOT NULL,
  `watcher` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- 转储表的索引
--

--
-- 表的索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `badges_account`
--
ALTER TABLE `badges_account`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `ciphertext`
--
ALTER TABLE `ciphertext`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `connect`
--
ALTER TABLE `connect`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `essay`
--
ALTER TABLE `essay`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `paw_essay`
--
ALTER TABLE `paw_essay`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `paw_postcomments`
--
ALTER TABLE `paw_postcomments`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `paw_posts`
--
ALTER TABLE `paw_posts`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `postimg`
--
ALTER TABLE `postimg`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `postreply`
--
ALTER TABLE `postreply`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `poststar`
--
ALTER TABLE `poststar`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `star`
--
ALTER TABLE `star`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `tags_posts`
--
ALTER TABLE `tags_posts`
  ADD PRIMARY KEY (`Id`);

--
-- 表的索引 `watch`
--
ALTER TABLE `watch`
  ADD PRIMARY KEY (`Id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `account`
--
ALTER TABLE `account`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `badges`
--
ALTER TABLE `badges`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `badges_account`
--
ALTER TABLE `badges_account`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `board`
--
ALTER TABLE `board`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ciphertext`
--
ALTER TABLE `ciphertext`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `connect`
--
ALTER TABLE `connect`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `essay`
--
ALTER TABLE `essay`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `gallery`
--
ALTER TABLE `gallery`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `paw_essay`
--
ALTER TABLE `paw_essay`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `paw_postcomments`
--
ALTER TABLE `paw_postcomments`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `paw_posts`
--
ALTER TABLE `paw_posts`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `postimg`
--
ALTER TABLE `postimg`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `postreply`
--
ALTER TABLE `postreply`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `poststar`
--
ALTER TABLE `poststar`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `star`
--
ALTER TABLE `star`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tags_posts`
--
ALTER TABLE `tags_posts`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `watch`
--
ALTER TABLE `watch`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
