-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2020-06-05 02:39:10
-- 服务器版本： 10.4.10-MariaDB
-- PHP 版本： 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `parts_deal`
--

-- --------------------------------------------------------

--
-- 表的结构 `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `CID` int(11) NOT NULL AUTO_INCREMENT COMMENT '顾客编号',
  `caccount` varchar(20) NOT NULL COMMENT '账号',
  `cpassword` varchar(20) NOT NULL COMMENT '密码',
  `cname` varchar(20) NOT NULL COMMENT '顾客姓名',
  `caddress` varchar(50) NOT NULL COMMENT '地址',
  `cphnumber` varchar(20) NOT NULL COMMENT '联系电话',
  PRIMARY KEY (`CID`),
  UNIQUE KEY `caccount` (`caccount`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='顾客信息';

-- --------------------------------------------------------

--
-- 表的结构 `contract`
--

DROP TABLE IF EXISTS `contract`;
CREATE TABLE IF NOT EXISTS `contract` (
  `CID` int(11) NOT NULL COMMENT '顾客编号',
  `SID` int(11) NOT NULL COMMENT '供应商编号',
  `PID` int(11) NOT NULL COMMENT '零件编号',
  `conprice` varchar(20) NOT NULL COMMENT '价格',
  `conquantity` varchar(20) NOT NULL COMMENT '数量',
  `csign` varchar(20) NOT NULL COMMENT '顾客签名',
  `ssign` varchar(20) NOT NULL COMMENT '供应商签名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='协议书';

-- --------------------------------------------------------

--
-- 表的结构 `deal`
--

DROP TABLE IF EXISTS `deal`;
CREATE TABLE IF NOT EXISTS `deal` (
  `CID` int(11) NOT NULL COMMENT '顾客编号',
  `SID` int(11) NOT NULL COMMENT '供应商编号',
  `PID` int(11) NOT NULL COMMENT '零件编号',
  `dprice` varchar(20) NOT NULL COMMENT '价格',
  `dquantity` varchar(20) NOT NULL COMMENT '数量'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='交易';

-- --------------------------------------------------------

--
-- 表的结构 `parts`
--

DROP TABLE IF EXISTS `parts`;
CREATE TABLE IF NOT EXISTS `parts` (
  `PID` int(11) NOT NULL AUTO_INCREMENT COMMENT '零件编号',
  `color` varchar(10) NOT NULL COMMENT '颜色',
  `pname` varchar(20) NOT NULL COMMENT '零件名',
  `weight` varchar(10) NOT NULL COMMENT '重量',
  `pintro` varchar(100) NOT NULL COMMENT '简介',
  PRIMARY KEY (`PID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='零件信息';

--
-- 转存表中的数据 `parts`
--

INSERT INTO `parts` (`PID`, `color`, `pname`, `weight`, `pintro`) VALUES
(1, '黄', '螺丝', '10g', '超级大螺丝'),
(2, '白', '螺帽', '10g', '无敌小螺帽');

-- --------------------------------------------------------

--
-- 表的结构 `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `SID` int(11) NOT NULL AUTO_INCREMENT COMMENT '供应商编号',
  `saccount` varchar(20) NOT NULL COMMENT '账号',
  `spassword` varchar(20) NOT NULL COMMENT '密码',
  `sname` varchar(20) NOT NULL COMMENT '供应商名',
  `saddress` varchar(50) NOT NULL COMMENT '地址',
  `sphnumber` varchar(20) NOT NULL COMMENT '联系电话',
  `sintro` varchar(100) NOT NULL COMMENT '简介',
  PRIMARY KEY (`SID`),
  UNIQUE KEY `saccount` (`saccount`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='供应商信息';

-- --------------------------------------------------------

--
-- 表的结构 `supply`
--

DROP TABLE IF EXISTS `supply`;
CREATE TABLE IF NOT EXISTS `supply` (
  `PID` int(11) NOT NULL COMMENT '零件编号',
  `SID` int(11) NOT NULL COMMENT '供应商编号',
  `sprice` varchar(20) NOT NULL COMMENT '价格',
  `squantity` int(20) NOT NULL COMMENT '数量',
  PRIMARY KEY (`PID`,`SID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='供应信息';

-- --------------------------------------------------------

--
-- 表的结构 `want`
--

DROP TABLE IF EXISTS `want`;
CREATE TABLE IF NOT EXISTS `want` (
  `CID` int(11) NOT NULL COMMENT '顾客编号',
  `PID` int(11) NOT NULL COMMENT '零件编号',
  `wprice` varchar(20) NOT NULL COMMENT '价格',
  `wquantity` varchar(20) NOT NULL COMMENT '数量',
  PRIMARY KEY (`CID`,`PID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='求购信息';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
