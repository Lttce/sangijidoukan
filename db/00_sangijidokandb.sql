-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-11-09 13:33:16
-- サーバのバージョン： 10.4.18-MariaDB
-- PHP のバージョン: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `sangijidoukandb`
--

use sangijidoukandb;

-- --------------------------------------------------------

--
-- テーブルの構造 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL COMMENT '職員番号',
  `userid` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ユーザID',
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'パスワード'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `admin`
--

INSERT INTO `admin` (`id`, `userid`, `password`) VALUES
(1, 'admin', '5b11128827f3e5ebbbb60ab427c47a4810eb6321');

-- --------------------------------------------------------

--
-- テーブルの構造 `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL COMMENT '書籍番号',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '書籍名',
  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '作者',
  `publisher` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '出版社',
  `issue` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '発行日',
  `page` int(11) NOT NULL COMMENT 'ページ数',
  `age` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '対象年齢',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT '説明文',
  `cover` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '表紙画像',
  `pdf` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '書籍PDF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `issue`, `page`, `age`, `description`, `cover`, `pdf`) VALUES
(1, 'ボクは走りたい', '静岡太郎', 'みらい情報出版', '2019/05/05', 18, '6〜8歳', 'ペットの大切さを描いたお話です。\r\nペットも大事な家族です。', 'bokuhahashiritai.png', 'bokuhahashiritai.pdf');

-- --------------------------------------------------------

--
-- テーブルの構造 `lending`
--

CREATE TABLE `lending` (
  `id` int(11) NOT NULL COMMENT '貸出番号',
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '貸出日',
  `returndate` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '返却予定日',
  `number` int(11) NOT NULL COMMENT '書籍番号',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '書籍名',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '児童名',
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '住所',
  `birthday` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '生年月日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `lending`
--

INSERT INTO `lending` (`id`, `date`, `returndate`, `number`, `title`, `name`, `address`, `birthday`) VALUES
(1, '2021/06/14', '2021/06/21', 1, 'ボクは走りたい', '渡辺直也', '長崎県旗夢市宇佐美区和良比3400-43', '1980/03/05');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `lending`
--
ALTER TABLE `lending`
  ADD PRIMARY KEY (`id`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
