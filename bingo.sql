

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bingo`
--

-- --------------------------------------------------------

--
-- Table structure for table `bingo_game`
--

CREATE TABLE IF NOT EXISTS `bingo_game` (
  `id` int(11) NOT NULL auto_increment,
  `game_id` varchar(30) NOT NULL,
  `player_list` varchar(70) NOT NULL,
  `checked_list` varchar(100) NOT NULL,
  `winner` varchar(2) NOT NULL default '-1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
