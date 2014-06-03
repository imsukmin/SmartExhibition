-- 서버 버전: 5.1.73
-- PHP 버전: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 데이터베이스: `gamjachip`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `AP`
--

CREATE TABLE IF NOT EXISTS `AP` (
  `index` int(10) NOT NULL COMMENT 'ap Number',
  `macAddress` varchar(17) NOT NULL COMMENT 'macAddress in AP',
  `x` int(10) NOT NULL,
  `y` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COMMENT='AP Information';


-- --------------------------------------------------------

--
-- 테이블 구조 `BoothInfo`
--

CREATE TABLE IF NOT EXISTS `BoothInfo` (
  `index` int(13) NOT NULL AUTO_INCREMENT,
  `teamName` varchar(200) NOT NULL COMMENT 'boothName',
  `productName` varchar(200) NOT NULL COMMENT 'productNamename',
  `professor` varchar(20) NOT NULL COMMENT '',
  `member` varchar(20) NOT NULL COMMENT 'member of company',
  `outline` text NOT NULL COMMENT 'outline of product',
  `target` varchar(300) NOT NULL COMMENT 'target Mechine',
  `homepage` varchar(200) NOT NULL COMMENT 'homepage',
  `brochure` text NOT NULL COMMENT 'image',
  `nfcTagId` text NOT NULL COMMENT 'nfc Tag ID Value',
  `hitCount` int(13) NOT NULL DEFAULT '0',
  `apLevel` text NOT NULL COMMENT 'AP signal value',
  `summary` text NOT NULL COMMENT 'summery of product',
  PRIMARY KEY (`index`),
  KEY `index` (`index`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr COMMENT='Booth Information' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 테이블 구조 `ExhibitionInfo`
--

CREATE TABLE IF NOT EXISTS `ExhibitionInfo` (
  `title` varchar(200) NOT NULL,
  `host` varchar(100) NOT NULL,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `summary` text NOT NULL,
  `outline` text NOT NULL,
  `map` text NOT NULL,
  `homepage` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COMMENT='전시회정보관리';

-- --------------------------------------------------------

--
-- 테이블 구조 `hitcount`
--

CREATE TABLE IF NOT EXISTS `hitcount` (
  `index` int(13) NOT NULL,
  `id` varchar(100) CHARACTER SET euckr NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='조회수';

-- --------------------------------------------------------

--
-- 테이블 구조 `Member`
--

CREATE TABLE IF NOT EXISTS `Member` (
  `index` int(13) NOT NULL AUTO_INCREMENT,
  `id` varchar(100) NOT NULL COMMENT 'ID',
  `password` varchar(100) NOT NULL COMMENT 'Password',
  `name` varchar(50) NOT NULL COMMENT 'User Name',
  `teamName` varchar(200) NOT NULL COMMENT 'Company of User',
  `email` varchar(200) NOT NULL COMMENT 'E-Mail',
  `phone` varchar(13) NOT NULL COMMENT 'CellPhone Number',
  `level` varchar(20) NOT NULL COMMENT 'User Level : admin, user, awaiter',
  PRIMARY KEY (`index`),
  KEY `index` (`index`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr COMMENT='User Information' AUTO_INCREMENT=2 ;

--
-- 테이블의 덤프 데이터 `Member`
--

INSERT INTO `Member` (`index`, `id`, `password`, `name`, `teamName`, `email`, `phone`, `level`) VALUES
(1, 'admin', PASSWORD('2014hansung'), 'ADMINISTRATOR', 'Smart Exhibition', '', '', 'admin');

-- --------------------------------------------------------

--
-- 테이블 구조 `QnA`
--

CREATE TABLE IF NOT EXISTS `QnA` (
  `index` int(13) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL COMMENT 'title of Question',
  `writer` varchar(50) NOT NULL COMMENT 'Question Owner',
  `date` varchar(10) NOT NULL COMMENT 'Date of Written time',
  `hits` int(11) NOT NULL COMMENT 'How many hit this article',
  `content` text NOT NULL COMMENT 'Content of Question',
  `comment` text NOT NULL COMMENT 'Answer from ADMINISTRATOR',
  PRIMARY KEY (`index`),
  KEY `index` (`index`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr COMMENT='QnA' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
  `index` int(13) NOT NULL COMMENT 'Booth index',
  `userID` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'User''s id',
  `checkIn` varchar(19) DEFAULT NULL COMMENT 'YYYY:MM:DD:hh:mm:ss'
) ENGINE=MyISAM DEFAULT CHARSET=euckr;

--
-- 테이블의 덤프 데이터 `visitors`
--

INSERT INTO `visitors` (`index`, `userID`, `checkIn`) VALUES
(1, '', ''),
(2, '', ''),
(3, '', ''),
(4, '', ''),
(5, '', ''),
(6, '', ''),
(7, '', ''),
(8, '', ''),
(9, '', ''),
(10, '', ''),
(11, '', ''),
(12, '', ''),
(13, '', ''),
(14, '', ''),
(15, '', ''),
(16, '', ''),
(17, '', ''),
(18, '', ''),
(19, '', ''),
(20, '', ''),
(21, '', ''),

