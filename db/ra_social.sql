-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-02-2019 a las 06:22:37
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ra_social`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `last_access` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `access`
--

INSERT INTO `access` (`id`, `last_access`) VALUES
(2, '1550110048'),
(44, '1534284869'),
(45, '1520295013'),
(46, '1520751952'),
(47, '1534287053'),
(48, '1547840575'),
(49, '1539740307');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `art` varchar(100) DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `id_referencia` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `album`
--

INSERT INTO `album` (`id`, `name`, `art`, `year`, `description`, `status`, `id_referencia`) VALUES
(1, 'Born In Babylon', '573f678bb2b4ce9c6befd7bb289e6759cfedb69b', NULL, NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album_has_channel`
--

CREATE TABLE `album_has_channel` (
  `album_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `album_has_channel`
--

INSERT INTO `album_has_channel` (`album_id`, `channel_id`) VALUES
(1, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album_has_genre`
--

CREATE TABLE `album_has_genre` (
  `album_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artist`
--

CREATE TABLE `artist` (
  `id` int(11) NOT NULL,
  `begin_date` varchar(45) DEFAULT NULL,
  `instrument` varchar(45) DEFAULT NULL,
  `presentation` varchar(400) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `id_referencia` varchar(45) DEFAULT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `artist`
--

INSERT INTO `artist` (`id`, `begin_date`, `instrument`, `presentation`, `name`, `user_id`, `id_referencia`, `profile_id`) VALUES
(1, NULL, NULL, NULL, 'SOJA', NULL, NULL, 1062);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artist_has_album`
--

CREATE TABLE `artist_has_album` (
  `artist_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `artist_has_album`
--

INSERT INTO `artist_has_album` (`artist_id`, `album_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8,
  `rule_name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, 'userGroup', NULL, 1539735191, 1539735191),
('artist', 1, NULL, 'userGroup', NULL, 1539735191, 1539735191),
('crudPlaylist', 2, 'Permition for perform CRUD operations on owned playlists', NULL, NULL, 1539735192, 1539735192),
('listener', 1, NULL, 'userGroup', NULL, 1539735191, 1539735191),
('loadAdminMainPanel', 2, 'Load the Main Panel with specific admininstration items', NULL, NULL, 1539735191, 1539735191),
('loadArtistMainPanel', 2, 'Load the Main Panel with specific artist-navigation items', NULL, NULL, 1539735191, 1539735191),
('loadListenerMainPanel', 2, 'Load the Main Panel with specific items for listener users', NULL, NULL, 1539735191, 1539735191),
('loadRegulatorMainPanel', 2, 'Load the Main Panel with specific catalog-management items', NULL, NULL, 1539735191, 1539735191),
('loginInAdminArea', 2, 'Login for admin/regulators users', NULL, NULL, 1539735191, 1539735191),
('loginInPublicArea', 2, 'Login for listeners and artists users', NULL, NULL, 1539735191, 1539735191),
('playlistOwner', 1, NULL, 'isPlaylistOwner', NULL, 1539735192, 1539735192),
('playlistReader', 1, NULL, 'canReadPlaylist', NULL, 1539735192, 1539735192),
('postExplore', 2, 'Permition for a user to see a post', NULL, NULL, 1539735192, 1539735192),
('postExplorer', 1, NULL, 'canSeePost', NULL, 1539735191, 1539735191),
('readPlaylist', 2, 'Permition for reading playlists', NULL, NULL, 1539735192, 1539735192),
('regulator', 1, NULL, 'userGroup', NULL, 1539735191, 1539735191);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8 NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'loadAdminMainPanel'),
('admin', 'loginInAdminArea'),
('admin', 'regulator'),
('artist', 'listener'),
('artist', 'loadArtistMainPanel'),
('artist', 'loginInPublicArea'),
('listener', 'loadListenerMainPanel'),
('listener', 'loginInPublicArea'),
('playlistOwner', 'crudPlaylist'),
('playlistReader', 'readPlaylist'),
('postExplorer', 'postExplore'),
('regulator', 'loadRegulatorMainPanel'),
('regulator', 'loginInAdminArea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('canReadPlaylist', 0x4f3a32393a22636f6e736f6c655c726261635c506c61796c6973745265616452756c65223a333a7b733a343a226e616d65223b733a31353a2263616e52656164506c61796c697374223b733a393a22637265617465644174223b693a313533393733353139323b733a393a22757064617465644174223b693a313533393733353139323b7d, 1539735192, 1539735192),
('canSeePost', 0x4f3a32383a22636f6e736f6c655c726261635c506f73744578706c6f726552756c65223a333a7b733a343a226e616d65223b733a31303a2263616e536565506f7374223b733a393a22637265617465644174223b693a313533393733353139313b733a393a22757064617465644174223b693a313533393733353139313b7d, 1539735191, 1539735191),
('isPlaylistOwner', 0x4f3a33303a22636f6e736f6c655c726261635c506c61796c6973744f776e657252756c65223a333a7b733a343a226e616d65223b733a31353a226973506c61796c6973744f776e6572223b733a393a22637265617465644174223b693a313533393733353139323b733a393a22757064617465644174223b693a313533393733353139323b7d, 1539735192, 1539735192),
('userGroup', 0x4f3a32363a22636f6e736f6c655c726261635c5573657247726f757052756c65223a333a7b733a343a226e616d65223b733a393a227573657247726f7570223b733a393a22637265617465644174223b693a313533393733353139313b733a393a22757064617465644174223b693a313533393733353139313b7d, 1539735191, 1539735191);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `channel`
--

CREATE TABLE `channel` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `art` varchar(100) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `id_referencia` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `channel`
--

INSERT INTO `channel` (`id`, `name`, `art`, `description`, `id_referencia`) VALUES
(8, 'Acoustic', NULL, NULL, '111'),
(9, 'Euro-House', NULL, NULL, '112'),
(10, 'Indie', NULL, NULL, '109'),
(11, 'Jazz', NULL, NULL, '108'),
(12, 'melodic', NULL, NULL, '113'),
(13, 'Misc', NULL, NULL, '115'),
(14, 'power', NULL, NULL, '114'),
(15, 'Rock', NULL, NULL, '110');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` varchar(500) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `profile_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `meda_data` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment_like`
--

CREATE TABLE `comment_like` (
  `id` int(11) NOT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `comment_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gender`
--

CREATE TABLE `gender` (
  `id_gender` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `gender`
--

INSERT INTO `gender` (`id_gender`, `type`) VALUES
(1, 'male'),
(2, 'female'),
(3, 'custom');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `profile_id` varchar(45) DEFAULT NULL,
  `song_id` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `history`
--

INSERT INTO `history` (`id`, `profile_id`, `song_id`, `date`) VALUES
(390, '1046', '3314', '1539543166'),
(398, '1046', '14258', '1539556252'),
(430, '1046', '5122', '1539740312'),
(431, '1046', '14314', '1539740327'),
(432, '1046', '8105', '1539741588'),
(598, '10', '3582', '1539902230'),
(599, '10', '8787', '1539902260'),
(600, '10', '321', '1539902396'),
(601, '10', '14412', '1539902783'),
(602, '10', '3508', '1539902956'),
(603, '10', '12651', '1539903249'),
(604, '10', '780', '1539903295'),
(605, '10', '6836', '1539903370'),
(606, '10', '8468', '1539903565'),
(607, '10', '2327', '1539903591'),
(608, '10', '13151', '1539903929'),
(609, '10', '4725', '1539904768'),
(610, '10', '397', '1539904787'),
(611, '10', '397', '1539904791'),
(612, '10', '398', '1539904950'),
(613, '10', '12258', '1539905013'),
(614, '10', '2812', '1539905015'),
(615, '10', '2812', '1539905040'),
(616, '10', '15014', '1539905064'),
(617, '10', '15014', '1539905068'),
(618, '10', '2181', '1539905497'),
(619, '10', '5080', '1539905718'),
(620, '10', '534', '1539905841'),
(621, '10', '8047', '1539905879'),
(622, '10', '13640', '1539905980'),
(623, '10', '14629', '1539906042'),
(624, '10', '10141', '1539906048'),
(625, '10', '11574', '1539906288'),
(626, '10', '15464', '1539906492'),
(627, '10', '12473', '1539906949'),
(628, '10', '13578', '1539907128'),
(629, '10', '15464', '1539907275'),
(630, '10', '8156', '1539907402'),
(631, '10', '12651', '1539910112'),
(632, '10', '5054', '1539910177'),
(633, '10', '15733', '1539910208'),
(634, '10', '14258', '1539910231'),
(635, '10', '4725', '1539910306'),
(636, '10', '4725', '1539910431'),
(637, '10', '15475', '1539915253'),
(638, '10', '13971', '1539915275'),
(639, '10', '9268', '1539915278'),
(640, '10', '667', '1539915294'),
(641, '10', '1898', '1539915348'),
(642, '10', '6415', '1539918251'),
(643, '10', '13846', '1539919940'),
(644, '10', '3354', '1539920823'),
(645, '10', '10149', '1539920852'),
(646, '10', '5104', '1539920959'),
(647, '10', '15896', '1539921008'),
(648, '10', '8693', '1539921092'),
(649, '10', '9396', '1539921107'),
(650, '10', '10450', '1539921140'),
(651, '10', '5131', '1540400188'),
(652, '10', '10450', '1542914498'),
(653, '10', '16395', '1542950668'),
(654, '10', '16358', '1542950686'),
(655, '10', '16416', '1542950716'),
(656, '10', '16321', '1542950725'),
(657, '10', '16414', '1547840652'),
(658, '10', '16302', '1547840666'),
(659, '10', '16414', '1547840700'),
(660, '10', '16415', '1547840924'),
(661, '10', '16408', '1547845561'),
(662, '10', '16408', '1547845580'),
(663, '10', '16408', '1547846576'),
(664, '10', '16414', '1547846687'),
(665, '10', '16353', '1547848028'),
(666, '10', '16353', '1547848069'),
(667, '10', '16415', '1547848692'),
(668, '10', '16302', '1547848704'),
(669, '10', '16414', '1547848761'),
(670, '10', '16408', '1547848764'),
(671, '10', '16395', '1547848796'),
(672, '10', '16395', '1547848820'),
(673, '10', '16395', '1547848854'),
(674, '10', '16415', '1547848982'),
(675, '10', '16395', '1547849091'),
(676, '10', '16353', '1547849095'),
(677, '10', '16353', '1547849100'),
(678, '10', '16354', '1547849111'),
(679, '10', '16415', '1547924723'),
(680, '10', '16302', '1547926075'),
(681, '10', '16353', '1547926086'),
(682, '10', '16380', '1547926166'),
(683, '10', '16381', '1547927563'),
(684, '10', '16358', '1547927573'),
(685, '10', '16304', '1547933253'),
(686, '10', '16353', '1547938877'),
(687, '10', '16356', '1547938953'),
(688, '10', '16415', '1548113607'),
(689, '10', '16380', '1548113627'),
(690, '10', '16304', '1548113652'),
(691, '10', '16414', '1548113677'),
(692, '10', '16380', '1548113757'),
(693, '10', '16353', '1548114298'),
(694, '10', '16353', '1548114336'),
(695, '10', '16355', '1548114349'),
(696, '10', '16355', '1548114390'),
(697, '10', '16356', '1548114408');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listener`
--

CREATE TABLE `listener` (
  `id` int(11) NOT NULL,
  `presentation` varchar(400) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `listener`
--

INSERT INTO `listener` (`id`, `presentation`, `name`, `profile_id`, `user_id`) VALUES
(1, NULL, 'Loana Salsati', 1046, 64);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `recevier_id` int(11) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `notification_type_id` int(11) NOT NULL,
  `meta_data` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notification`
--

INSERT INTO `notification` (`id`, `status`, `sender_id`, `recevier_id`, `created_at`, `updated_at`, `notification_type_id`, `meta_data`) VALUES
(1, 1, 1, 10, '1538947682', '1539903036', 4, NULL),
(2, 1, 2, 10, '1538947693', '1539740378', 4, NULL),
(4, 1, 1046, 10, '1539740341', '1539834509', 6, NULL),
(5, 1, 10, 1046, '1539742008', '1539742012', 5, NULL),
(6, 1, 1046, 10, '1539742012', '1539834505', 6, NULL),
(7, 1, 1046, 10, '1539742054', '1539834579', 4, NULL),
(9, 0, 10, 5, '1539834279', '1539834279', 4, NULL),
(10, 0, 10, 0, '1539896304', '1539896304', 13, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification_type`
--

CREATE TABLE `notification_type` (
  `id` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notification_type`
--

INSERT INTO `notification_type` (`id`, `type`) VALUES
(0, 'message'),
(1, 'comment'),
(2, 'comment_to'),
(3, 'mention'),
(4, 'relationship_follow'),
(5, 'relationship_pending'),
(6, 'relationship_accepted'),
(7, 'post_comment'),
(8, 'comment_comment'),
(9, 'post_follow_comment'),
(10, 'like_comment'),
(11, 'like_post'),
(12, 'like_comment_post'),
(13, 'album_upload');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist`
--

CREATE TABLE `playlist` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `profile_id` int(11) NOT NULL,
  `visibility_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`id`, `name`, `profile_id`, `visibility_id`) VALUES
(1, 'qwe', 10, 1),
(2, 'xcvxcv', 10, 1),
(3, 'Album - Aeroblues', 10, 2),
(4, 'Favoritos', 10, 1),
(5, 'Favoritos', 1046, 1),
(6, 'Album - Ultimos dias del tren fantasma', 1046, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist_has_song`
--

CREATE TABLE `playlist_has_song` (
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `playlist_has_song`
--

INSERT INTO `playlist_has_song` (`playlist_id`, `song_id`) VALUES
(1, 1),
(3, 397),
(3, 398),
(3, 399),
(3, 400),
(3, 401),
(3, 402),
(3, 403),
(3, 404),
(3, 405),
(3, 406),
(4, 406),
(4, 3139),
(4, 15014),
(6, 15014),
(6, 15015),
(6, 15016),
(6, 15017),
(6, 15018),
(6, 15019),
(6, 15020),
(6, 15021),
(6, 15022),
(6, 15023),
(6, 15024),
(6, 15025),
(6, 15026);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `content` varchar(500) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `visibility_id` varchar(45) DEFAULT NULL,
  `profile_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `collection_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `post_attached` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `content`, `created_at`, `updated_at`, `visibility_id`, `profile_id`, `album_id`, `collection_id`, `post_id`, `post_attached`) VALUES
(1, 'qweqweqweqw', '1535040268', '1535040268', '1', 10, NULL, 0, NULL, NULL),
(2, 'qwer', '1535040308', '1535040308', '1', 10, 32, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_follow`
--

CREATE TABLE `post_follow` (
  `id_profile` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_like`
--

CREATE TABLE `post_like` (
  `id` int(11) NOT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `post_like`
--

INSERT INTO `post_like` (`id`, `created_at`, `post_id`, `profile_id`) VALUES
(1, '1538666174', 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `birth_date` varchar(45) DEFAULT NULL,
  `birth_location` varchar(45) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `facebook` varchar(45) DEFAULT NULL,
  `twitter` varchar(45) DEFAULT NULL,
  `visibility` tinyint(8) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `options_id` int(11) NOT NULL,
  `gender_desc` varchar(45) DEFAULT NULL,
  `listed` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`id`, `name`, `last_name`, `birth_date`, `birth_location`, `photo`, `mail`, `phone`, `facebook`, `twitter`, `visibility`, `gender_id`, `options_id`, `gender_desc`, `listed`) VALUES
(1, '107 Faunos', NULL, NULL, NULL, 'be11a860f3d9f8f21d7cbcfd7d7b5c71bd6be7b0', NULL, NULL, NULL, NULL, 3, NULL, 1, NULL, 1),
(2, '22-20s', NULL, NULL, NULL, '817ac3fe43faaa08ceaa314b1213bafc1930e29a', NULL, NULL, NULL, NULL, 3, NULL, 2, NULL, 1),
(3, '2:54', NULL, NULL, NULL, '71796c42437383e9144f81bb4e31d7b51d594a55', NULL, NULL, NULL, NULL, 3, NULL, 3, NULL, 1),
(4, '3Pecados', NULL, NULL, NULL, '15522f1685e14d867fe251ab0814333c2cab107f', NULL, NULL, NULL, NULL, 3, NULL, 4, NULL, 1),
(5, 'ABOBINABLE', NULL, NULL, NULL, '7a32cdfe410cd1018a34b39848cc2a1d3b00888a', NULL, NULL, NULL, NULL, 3, NULL, 5, NULL, 1),
(6, 'The Abyssinians', NULL, NULL, NULL, '3faa48d6e4998142d3c45d0cb6ecb478b42b5d34', NULL, NULL, NULL, NULL, 3, NULL, 6, NULL, 1),
(7, 'Acorazado Potemkin', NULL, NULL, NULL, 'be7581bfca6a01dbe0376f739095485576c9a421', NULL, NULL, NULL, NULL, 3, NULL, 7, NULL, 1),
(8, 'The Action', NULL, NULL, NULL, '6105d7040a3a3a0bc62dd2feed1496fedd1cd5a1', NULL, NULL, NULL, NULL, 3, NULL, 8, NULL, 1),
(9, 'Adrian Paoletti', NULL, NULL, NULL, '942ce005124a16b80617915fe247f1a1e59208c8', NULL, NULL, NULL, NULL, 3, NULL, 9, NULL, 1),
(10, 'Aeroblues', 'Champ', '-1577907792', '', '4184f77b2416ac053d0e31927f30e2fa2d5e8525', NULL, '', 'maikndawer', 'maikndawer', 3, 1, 10, NULL, 1),
(11, 'The Afghan Whigs', NULL, NULL, NULL, '99080ef4b3223a957408486c600974256a2665ae', NULL, NULL, NULL, NULL, 3, NULL, 11, NULL, 1),
(12, 'The Aggrovators', NULL, NULL, NULL, 'e8b6a02a4614dd4d3a54151cdf90c059e51398a8', NULL, NULL, NULL, NULL, 3, NULL, 12, NULL, 1),
(13, 'Aguas Tonicas', NULL, NULL, NULL, '8a04cfd49080f0a5e57d875ae33f8bb1c0259316', NULL, NULL, NULL, NULL, 3, NULL, 13, NULL, 1),
(14, 'Akalé Wubé', NULL, NULL, NULL, '48bd0cb2824e6c3d84c9cb8cd2866698b05f4322', NULL, NULL, NULL, NULL, 3, NULL, 14, NULL, 1),
(15, 'Albert Hammond Jr', NULL, NULL, NULL, 'a748d474568cea1e9a50f598c7142d14a1eef996', NULL, NULL, NULL, NULL, 3, NULL, 15, NULL, 1),
(16, 'Albert Pla', NULL, NULL, NULL, '30b2164521cfc0adce214b6fce037b0f85bd9efc', NULL, NULL, NULL, NULL, 3, NULL, 16, NULL, 1),
(17, 'Albrío', NULL, NULL, NULL, 'b49c57cffbecc58a9184a76598b44aa7fd7a6f36', NULL, NULL, NULL, NULL, 3, NULL, 17, NULL, 1),
(18, 'Alejandro Medina', NULL, NULL, NULL, '596126a91426dbfe793a9dae3cc3b1f3095ea0e1', NULL, NULL, NULL, NULL, 3, NULL, 18, NULL, 1),
(19, 'Alfredo Remus', NULL, NULL, NULL, '7ed47a4975d5295350f519915efc53af71e83a6b', NULL, NULL, NULL, NULL, 3, NULL, 19, NULL, 1),
(20, 'All Girl Summer Fun Band', NULL, NULL, NULL, 'fc9ab87222080625079b0523b8450fbb6184b23e', NULL, NULL, NULL, NULL, 3, NULL, 20, NULL, 1),
(21, 'All Them Witches', NULL, NULL, NULL, 'e82b2baa74dae051a0a2bbcb3b03bce29aa3296a', NULL, NULL, NULL, NULL, 3, NULL, 21, NULL, 1),
(22, 'Allah-Las', NULL, NULL, NULL, '7f961054f3077ce378373b31c2452994744fb81f', NULL, NULL, NULL, NULL, 3, NULL, 22, NULL, 1),
(23, 'Allo Darlin\'', NULL, NULL, NULL, '068f844c72b6c68970ff442a78395adf63317988', NULL, NULL, NULL, NULL, 3, NULL, 23, NULL, 1),
(24, 'Almendra', NULL, NULL, NULL, '023eb3ef5978e79cb058af0fe8e0b5843b889e13', NULL, NULL, NULL, NULL, 3, NULL, 24, NULL, 1),
(25, 'Alpha Blondy', NULL, NULL, NULL, 'c02f68b46b5a502723ad1e6dc248919c190c0f20', NULL, NULL, NULL, NULL, 3, NULL, 25, NULL, 1),
(26, 'Altocamet', NULL, NULL, NULL, '2a309816700b43bc1d182fbb7d5d93a956d78455', NULL, NULL, NULL, NULL, 3, NULL, 26, NULL, 1),
(27, 'Alucinaciones en familia', NULL, NULL, NULL, '9c0327ec279837540c6c3a90692c0edcb2e3f0cf', NULL, NULL, NULL, NULL, 3, NULL, 27, NULL, 1),
(28, 'Alucinaria', NULL, NULL, NULL, 'ba5eb1efde60845a041593cbf768473ec67f79f0', NULL, NULL, NULL, NULL, 3, NULL, 28, NULL, 1),
(29, 'Alvin Queen', NULL, NULL, NULL, '4437212a8541bc64014a966f1c21f778c7f206eb', NULL, NULL, NULL, NULL, 3, NULL, 29, NULL, 1),
(30, 'Alvy NAcho & Rubin', NULL, NULL, NULL, '43f8636540ce0e9ce9df5f5230b08d63cd839c86', NULL, NULL, NULL, NULL, 3, NULL, 30, NULL, 1),
(31, 'Amateur', NULL, NULL, NULL, '36cc05b4af972b34f140ed48278d3a3064523b9b', NULL, NULL, NULL, NULL, 3, NULL, 31, NULL, 1),
(32, 'Amazonas de Vulkania', NULL, NULL, NULL, '6ea6c1bbed28f69977822910297e2ef547437547', NULL, NULL, NULL, NULL, 3, NULL, 32, NULL, 1),
(33, 'Amberes', NULL, NULL, NULL, 'e35bf62f88356b0e54096f793731915d5ab2d11d', NULL, NULL, NULL, NULL, 3, NULL, 33, NULL, 1),
(34, 'American Football', NULL, NULL, NULL, '8dbc1b81f44ea2817136eff4bbdbac3edadf0afd', NULL, NULL, NULL, NULL, 3, NULL, 34, NULL, 1),
(35, 'Amor en la isla', NULL, NULL, NULL, '517df9354b2ffc1bbcd0a39b9cb9c40498fd7ea3', NULL, NULL, NULL, NULL, 3, NULL, 35, NULL, 1),
(36, 'Animal Collective', NULL, NULL, NULL, '0f3c71e3276395b5e20615bac7fb42b76e8401cb', NULL, NULL, NULL, NULL, 3, NULL, 36, NULL, 1),
(37, 'Animal Youth', NULL, NULL, NULL, '00692ec1443f0a88118b4c278b775d17a0a99b14', NULL, NULL, NULL, NULL, 3, NULL, 37, NULL, 1),
(38, 'The Animals', NULL, NULL, NULL, 'e056922005642ce245d304a5e8b3a477d8ccda50', NULL, NULL, NULL, NULL, 3, NULL, 38, NULL, 1),
(39, 'Ansel Collins', NULL, NULL, NULL, '0e1c9311c1e819996cd6f89e60f64b589db8c4c1', NULL, NULL, NULL, NULL, 3, NULL, 39, NULL, 1),
(40, 'Ansel Collins with Sly and Robbie', NULL, NULL, NULL, '896235a7b014feff8745871f3f3c4a1f02e5833d', NULL, NULL, NULL, NULL, 3, NULL, 40, NULL, 1),
(41, 'Antonio Birabent', NULL, NULL, NULL, '33e8e351bf397b8545bf2b7b3560abfc892b90dd', NULL, NULL, NULL, NULL, 3, NULL, 41, NULL, 1),
(42, 'The Apartments', NULL, NULL, NULL, '62f35f77b4c3e31c3328e3f20fd9a390ce48a4c0', NULL, NULL, NULL, NULL, 3, NULL, 42, NULL, 1),
(43, 'The Aqua Velvets', NULL, NULL, NULL, 'cfd9ecf65aeb512b862ddc095adcfc665a47591a', NULL, NULL, NULL, NULL, 3, NULL, 43, NULL, 1),
(44, 'Aquelarre', NULL, NULL, NULL, '15ca591adc16185252a971f454607e6b2f22e966', NULL, NULL, NULL, NULL, 3, NULL, 44, NULL, 1),
(45, 'The Arabs', NULL, NULL, NULL, 'e390add1897748760efa25b5c972ae45227c1151', NULL, NULL, NULL, NULL, 3, NULL, 45, NULL, 1),
(46, 'Araca Paris', NULL, NULL, NULL, '57501554ce50d87537241b3db8d13657ce21b16e', NULL, NULL, NULL, NULL, 3, NULL, 46, NULL, 1),
(47, 'Arco Iris', NULL, NULL, NULL, '5b1e6d0425bb5ebf1e0c0922b5e92bbc1b2c6773', NULL, NULL, NULL, NULL, 3, NULL, 47, NULL, 1),
(48, 'Arctic Monkeys', NULL, NULL, NULL, 'c644357194631d9a123c260588e8d17a60051343', NULL, NULL, NULL, NULL, 3, NULL, 48, NULL, 1),
(49, 'Art Blakey', NULL, NULL, NULL, '2d5f242747a3bd8d9718e5098d75393a31371a93', NULL, NULL, NULL, NULL, 3, NULL, 49, NULL, 1),
(50, 'Art Blakey and The Jazz Messengers', NULL, NULL, NULL, '8dbdc82b70181651ffa7848620ef8aa45ecb5904', NULL, NULL, NULL, NULL, 3, NULL, 50, NULL, 1),
(51, 'Art Brut', NULL, NULL, NULL, 'e9949f64d4bad6f24215b4bf8844e828270b6c2d', NULL, NULL, NULL, NULL, 3, NULL, 51, NULL, 1),
(52, 'Art Pepper and Chet Baker', NULL, NULL, NULL, '13d71f056c5100ed3319ea8fc571ad435d7ca44a', NULL, NULL, NULL, NULL, 3, NULL, 52, NULL, 1),
(53, 'At The Drive In', NULL, NULL, NULL, 'f9cd536f9001098f0edf29622faf88b01e949308', NULL, NULL, NULL, NULL, 3, NULL, 53, NULL, 1),
(54, 'Atrás Hay Truenos', NULL, NULL, NULL, 'a4cb287451079b2122ef383480cddde5d4a2f551', NULL, NULL, NULL, NULL, 3, NULL, 54, NULL, 1),
(55, 'Auditores', NULL, NULL, NULL, '0b42dd1e4668664ba709a7b7d03d4b2bf9e086bf', NULL, NULL, NULL, NULL, 3, NULL, 55, NULL, 1),
(56, 'Augustus Pablo', NULL, NULL, NULL, '481035ee8f3ff9ce4f305b155eefb416537246a7', NULL, NULL, NULL, NULL, 3, NULL, 56, NULL, 1),
(57, 'Autolux', NULL, NULL, NULL, 'edcfd1ed2fa784f25c425cddd28be1a6620f5772', NULL, NULL, NULL, NULL, 3, NULL, 58, NULL, 1),
(58, 'Autoramas', NULL, NULL, NULL, 'ae09b4e859645b6a875eea09c6de181a4c64f035', NULL, NULL, NULL, NULL, 3, NULL, 59, NULL, 1),
(59, 'B-Movie', NULL, NULL, NULL, '82e4822cf66fe027fcca670f7e0718956cb8537d', NULL, NULL, NULL, NULL, 3, NULL, 60, NULL, 1),
(60, 'Bad Sleep', NULL, NULL, NULL, '1e7730a3488a562fd20571196c7a2e8002e1ca15', NULL, NULL, NULL, NULL, 3, NULL, 61, NULL, 1),
(61, 'Badly Drawn Boy', NULL, NULL, NULL, 'ef614deb44cc823875349782d320db4b40854287', NULL, NULL, NULL, NULL, 3, NULL, 62, NULL, 1),
(62, 'Banco de suplentes', NULL, NULL, NULL, '660b038b371f76ff0c1535767b947c87b5001961', NULL, NULL, NULL, NULL, 3, NULL, 63, NULL, 1),
(63, 'Banda De Turistas', NULL, NULL, NULL, '37ba54249fbed0eec58a6967f59cb57a9fe0c0da', NULL, NULL, NULL, NULL, 3, NULL, 64, NULL, 1),
(64, 'The Baron Four', NULL, NULL, NULL, 'ac996aa824b02bd73780131900f2a94c41e283ce', NULL, NULL, NULL, NULL, 3, NULL, 65, NULL, 1),
(65, 'Bass Drum of Death', NULL, NULL, NULL, 'a38cbe1bea1b4acc1a505b6f81415cb96be8e718', NULL, NULL, NULL, NULL, 3, NULL, 66, NULL, 1),
(66, 'Bauhaus', NULL, NULL, NULL, '37f70308ab766511c83514c23049e31c787e3b5b', NULL, NULL, NULL, NULL, 3, NULL, 67, NULL, 1),
(67, 'The Beach Boys', NULL, NULL, NULL, '0d7bc635159dc82896fd0d7b30dab29eef7e4793', NULL, NULL, NULL, NULL, 3, NULL, 68, NULL, 1),
(68, 'Beach House', NULL, NULL, NULL, '3551bfb095f29a2183ff9c278956a69f99cdc816', NULL, NULL, NULL, NULL, 3, NULL, 69, NULL, 1),
(69, 'Beaches', NULL, NULL, NULL, '511a3cde07b205348af2f386135c715c4f9a897f', NULL, NULL, NULL, NULL, 3, NULL, 70, NULL, 1),
(70, 'The Beat', NULL, NULL, NULL, 'b342f1e3e3dafecb3edfe51790a402fade9366b9', NULL, NULL, NULL, NULL, 3, NULL, 71, NULL, 1),
(71, 'Beat Happening', NULL, NULL, NULL, '448a14fb94f38ce13cbbba68008386a71b54d4eb', NULL, NULL, NULL, NULL, 3, NULL, 72, NULL, 1),
(72, 'Beck', NULL, NULL, NULL, '70cc15c99985119c5531548063e6b8cd208f1a47', NULL, NULL, NULL, NULL, 3, NULL, 73, NULL, 1),
(73, 'The Beginner\'s Mynd', NULL, NULL, NULL, 'f678e1b080125aa72729ff755bba58a012e4dcc7', NULL, NULL, NULL, NULL, 3, NULL, 74, NULL, 1),
(74, 'Beirut', NULL, NULL, NULL, 'b43eae4ec3e6fd757e3232d57487c1b408fe0010', NULL, NULL, NULL, NULL, 3, NULL, 75, NULL, 1),
(75, 'Belgrado', NULL, NULL, NULL, '5b88bcbe85ec62d0c88d971b4c3594666c0bb8fe', NULL, NULL, NULL, NULL, 3, NULL, 76, NULL, 1),
(76, 'Belle and Sebastian', NULL, NULL, NULL, '1738d05c7e1ae2978f7e0cc3927bbe43f807171e', NULL, NULL, NULL, NULL, 3, NULL, 77, NULL, 1),
(77, 'Belly', NULL, NULL, NULL, '073432ecd9b28a14db9699485b27d0d268575ea7', NULL, NULL, NULL, NULL, 3, NULL, 78, NULL, 1),
(78, 'Benteveo', NULL, NULL, NULL, 'c383ac70c8e42f9b1caada2ae8299ff6bba78d16', NULL, NULL, NULL, NULL, 3, NULL, 79, NULL, 1),
(79, 'The Benturas', NULL, NULL, NULL, '4e5e0ec4a95b988e7c8464767fbec7b8405c6439', NULL, NULL, NULL, NULL, 3, NULL, 80, NULL, 1),
(80, 'Bestia Bebe', NULL, NULL, NULL, 'cb2a591b2834b28f9b27d54014710b5b5ab81c93', NULL, NULL, NULL, NULL, 3, NULL, 81, NULL, 1),
(81, 'The Beta Band', NULL, NULL, NULL, 'e0bb87e53202b8bc3af5c320ab5e24d6429d1cd0', NULL, NULL, NULL, NULL, 3, NULL, 82, NULL, 1),
(82, 'Bicho Bolita y Los Paris Gatitos', NULL, NULL, NULL, 'ff8a1813b8a864d71d234ff22649003f077eb958', NULL, NULL, NULL, NULL, 3, NULL, 83, NULL, 1),
(83, 'Bill Carrothers', NULL, NULL, NULL, '30161bb144002a820c69497755088a130cffe4c0', NULL, NULL, NULL, NULL, 3, NULL, 84, NULL, 1),
(84, 'Bill Evans', NULL, NULL, NULL, '3a2c1eddd361573f311fc567d94522f6a5df4ff0', NULL, NULL, NULL, NULL, 3, NULL, 85, NULL, 1),
(85, 'Bill Evans Trio', NULL, NULL, NULL, '8fd4981df0ab7bb02b68becd40788fb35d77a562', NULL, NULL, NULL, NULL, 3, NULL, 86, NULL, 1),
(86, 'Billie Holiday', NULL, NULL, NULL, '6d56c9a3f4e80a9906699e0aba0aaacc350a9a70', NULL, NULL, NULL, NULL, 3, NULL, 87, NULL, 1),
(87, 'Billy Bond y La Pesada', NULL, NULL, NULL, 'e4d67e46912c9258281139b965fd9a0c0d3ac34e', NULL, NULL, NULL, NULL, 3, NULL, 88, NULL, 1),
(88, 'Billy Higgins, Ray Drummond, Hank Jones', NULL, NULL, NULL, 'f6c07b4dc9db604a4d61e48066c5392f340c57c4', NULL, NULL, NULL, NULL, 3, NULL, 89, NULL, 1),
(89, 'Bim Skala Bim', NULL, NULL, NULL, '823b9aa392a8c574d13c15ca2ce83a56536c8664', NULL, NULL, NULL, NULL, 3, NULL, 90, NULL, 1),
(90, 'Birkins', NULL, NULL, NULL, '7362dc26cb7fbe9b3ff11e1e4b380fbc2bd12228', NULL, NULL, NULL, NULL, 3, NULL, 91, NULL, 1),
(91, 'Biznaga', NULL, NULL, NULL, 'f43069453de793e069d7da53122aea1394fc0ab2', NULL, NULL, NULL, NULL, 3, NULL, 92, NULL, 1),
(92, 'The Black Angels', NULL, NULL, NULL, '9a702cc66ecfba8416c4deda69813e0aeba1910b', NULL, NULL, NULL, NULL, 3, NULL, 93, NULL, 1),
(93, 'Black Beach', NULL, NULL, NULL, '09637524574f12ae853071f7321d998caa46881a', NULL, NULL, NULL, NULL, 3, NULL, 94, NULL, 1),
(94, 'The Black Furs', NULL, NULL, NULL, '9b1cc1f7302c7383718ca2ffffbc926f5f04ee17', NULL, NULL, NULL, NULL, 3, NULL, 95, NULL, 1),
(95, 'The Black Heart Death Cult', NULL, NULL, NULL, '4ca213185d0464d1cb2728bd8f96c20b1915038b', NULL, NULL, NULL, NULL, 3, NULL, 96, NULL, 1),
(96, 'The Black Keys', NULL, NULL, NULL, 'fbf62d3c01ca355c8f9f730a3d46c72e92aa741e', NULL, NULL, NULL, NULL, 3, NULL, 97, NULL, 1),
(97, 'Black Lips', NULL, NULL, NULL, '8cb7195eb237f2f5e8eac84a94ee8d0f24dec237', NULL, NULL, NULL, NULL, 3, NULL, 98, NULL, 1),
(98, 'Black Map', NULL, NULL, NULL, '1fbb29890a5917124f92ccb8be4c0488fd476b67', NULL, NULL, NULL, NULL, 3, NULL, 99, NULL, 1),
(99, 'Black Rebel Motorcycle Club', NULL, NULL, NULL, 'ecaa9ab4c23cab36caf0d98e6c12d605d1d3a8bc', NULL, NULL, NULL, NULL, 3, NULL, 100, NULL, 1),
(100, 'Black Sabbath', NULL, NULL, NULL, '1ad27d6b0fafe8fb42ea075545573e22c9398372', NULL, NULL, NULL, NULL, 3, NULL, 101, NULL, 1),
(101, 'Black Uhuru', NULL, NULL, NULL, '82642eb10323895a27a0662cd222d42face62a43', NULL, NULL, NULL, NULL, 3, NULL, 102, NULL, 1),
(102, 'Blondie', NULL, NULL, NULL, '4dc13d52b823f9c789071b68a824c26a1eeb2e87', NULL, NULL, NULL, NULL, 3, NULL, 103, NULL, 1),
(103, 'The Blue Box', NULL, NULL, NULL, 'faf1ebe8820b2607277918a58da50839336bfcf7', NULL, NULL, NULL, NULL, 3, NULL, 104, NULL, 1),
(104, 'The Bluebeaters', NULL, NULL, NULL, '1d4910e5c3639d0c338b687deadd69dfd2abd361', NULL, NULL, NULL, NULL, 3, NULL, 105, NULL, 1),
(105, 'Blues Magoos', NULL, NULL, NULL, 'b9e0c09b847ccad2344174e1a8c7427ab56e15cd', NULL, NULL, NULL, NULL, 3, NULL, 106, NULL, 1),
(106, 'Blur', NULL, NULL, NULL, '6bac25b0e1c59319ad013e038b3672c39c28a20a', NULL, NULL, NULL, NULL, 3, NULL, 107, NULL, 1),
(107, 'BMX Bandits', NULL, NULL, NULL, '21206ef4c530665b21a7717bc2bd5a2b900e7f67', NULL, NULL, NULL, NULL, 3, NULL, 108, NULL, 1),
(108, 'Bo Diddley', NULL, NULL, NULL, 'b93b35e5af510c0c6cf4d2b9d6577f4171b38eef', NULL, NULL, NULL, NULL, 3, NULL, 109, NULL, 1),
(109, 'Boas Teitas', NULL, NULL, NULL, '707de041a046b9830d5ab22ddaadd36fafbae26d', NULL, NULL, NULL, NULL, 3, NULL, 110, NULL, 1),
(110, 'Bob Andy', NULL, NULL, NULL, '2c9c414c071359489e188ccd9ea1f7a0d46f5a9e', NULL, NULL, NULL, NULL, 3, NULL, 111, NULL, 1),
(111, 'Bob Dylan', NULL, NULL, NULL, 'eba9b1bcce9a7eae9b08f0621f4ae619287f0221', NULL, NULL, NULL, NULL, 3, NULL, 112, NULL, 1),
(112, 'Bob Dylan and the Band', NULL, NULL, NULL, '1a27d5f180f93dc7a463b7b0f06ee214a4a6aa2e', NULL, NULL, NULL, NULL, 3, NULL, 113, NULL, 1),
(113, 'Bob Marley', NULL, NULL, NULL, 'c4494a4bea96e796cadb33a4c23dbbd8c0c531d5', NULL, NULL, NULL, NULL, 3, NULL, 114, NULL, 1),
(114, 'Bob Marley & The Wailers', NULL, NULL, NULL, 'da731a7941f255eeaac03920e487826cd141daa6', NULL, NULL, NULL, NULL, 3, NULL, 115, NULL, 1),
(115, 'BOBKAT\'65', NULL, NULL, NULL, '5d64dc0f40a57f26e694f0983a5f9ea1d3d076e2', NULL, NULL, NULL, NULL, 3, NULL, 116, NULL, 1),
(116, 'Bomboclash', NULL, NULL, NULL, 'af1c1fbe6c7be0bfe90212a7a1e034b97f402054', NULL, NULL, NULL, NULL, 3, NULL, 117, NULL, 1),
(117, 'Boom Boom Kid', NULL, NULL, NULL, '9102a942def54600b67f2b632c66a08a1292a3b0', NULL, NULL, NULL, NULL, 3, NULL, 118, NULL, 1),
(118, 'Boom Pam', NULL, NULL, NULL, '770045b6d9447012b589dc5a755b79596794d0b4', NULL, NULL, NULL, NULL, 3, NULL, 119, NULL, 1),
(119, 'Boris Gardiner', NULL, NULL, NULL, 'de6d495ad675370f0b06c81f8c4526cd7ea71bad', NULL, NULL, NULL, NULL, 3, NULL, 120, NULL, 1),
(120, 'Boss Hog', NULL, NULL, NULL, '67a7c78fcd7bf04670d2ecad70392d5ac8afd36b', NULL, NULL, NULL, NULL, 3, NULL, 121, NULL, 1),
(121, 'The Boys', NULL, NULL, NULL, 'be775db199e40d8cdc2eb67e6f0cfc01f034df98', NULL, NULL, NULL, NULL, 3, NULL, 122, NULL, 1),
(122, 'Branford Marsalis Quartet', NULL, NULL, NULL, 'f9356191ddb6d4759c061fd4ddcfadce0598271d', NULL, NULL, NULL, NULL, 3, NULL, 123, NULL, 1),
(123, 'The Breeders', NULL, NULL, NULL, 'e5892a666290f9010c9502cf487e903cb6b6b6c4', NULL, NULL, NULL, NULL, 3, NULL, 124, NULL, 1),
(124, 'The Brian Jonestown Massacre', NULL, NULL, NULL, '22bcc9d027a436475f5546d3c2e4f5ee962ca6af', NULL, NULL, NULL, NULL, 3, NULL, 125, NULL, 1),
(125, 'Broadcast', NULL, NULL, NULL, 'a9c75a44e7dc0085b16f17bf999667d4cbb4841d', NULL, NULL, NULL, NULL, 3, NULL, 126, NULL, 1),
(126, 'Bud Powell', NULL, NULL, NULL, 'c84f64f5fddce2a36e0f5ddd760bcd258264a6f5', NULL, NULL, NULL, NULL, 3, NULL, 127, NULL, 1),
(127, 'Built To Spill', NULL, NULL, NULL, '32154facda30948c8c83a496f8f63be1845aee28', NULL, NULL, NULL, NULL, 3, NULL, 128, NULL, 1),
(128, 'Bully', NULL, NULL, NULL, 'c543630948860d51f4501ae2c218a91d222d3684', NULL, NULL, NULL, NULL, 3, NULL, 129, NULL, 1),
(129, 'Bunny Lion', NULL, NULL, NULL, 'cc5bfaa96dcd5a994f2021f4c8f16f6cf628b774', NULL, NULL, NULL, NULL, 3, NULL, 130, NULL, 1),
(130, 'Burning Spear', NULL, NULL, NULL, 'afbb215f886d283b3604e8ac2c40676eccd9dd3c', NULL, NULL, NULL, NULL, 3, NULL, 131, NULL, 1),
(131, 'Le Butcherettes', NULL, NULL, NULL, '803d6c747a094ac640e343ca3f723ec1161d1ff9', NULL, NULL, NULL, NULL, 3, NULL, 132, NULL, 1),
(132, 'The Buttertones', NULL, NULL, NULL, '88670a75fbc0fdaba07e26ecae2236d43f19bf50', NULL, NULL, NULL, NULL, 3, NULL, 133, NULL, 1),
(133, 'The Buzzcocks', NULL, NULL, NULL, 'f87d65a9fd2072ff2ca37cdc32edb88fe825bb36', NULL, NULL, NULL, NULL, 3, NULL, 134, NULL, 1),
(134, 'Byron Lee', NULL, NULL, NULL, '836ba7ddd881448526225ef1ad0bb21bc7c75607', NULL, NULL, NULL, NULL, 3, NULL, 135, NULL, 1),
(135, 'Byron Lee & The Dragonaires', NULL, NULL, NULL, '80674554c6c6339418a27f419bfba4293884e22d', NULL, NULL, NULL, NULL, 3, NULL, 136, NULL, 1),
(136, 'Cage The Elephant', NULL, NULL, NULL, 'f4bc120df47fd3c3b946e3ae1ef50ad8665295d1', NULL, NULL, NULL, NULL, 3, NULL, 137, NULL, 1),
(137, 'Cake', NULL, NULL, NULL, 'b466693b6d407f37ea5b2df971bf15c6c3ade9e7', NULL, NULL, NULL, NULL, 3, NULL, 138, NULL, 1),
(138, 'Calvin Johnson', NULL, NULL, NULL, 'a99c1482b1df6284c41d34de257f7790da42835f', NULL, NULL, NULL, NULL, 3, NULL, 139, NULL, 1),
(139, 'Calvin Johnson and The Sons of the Soil', NULL, NULL, NULL, '0ac306a4cb7fb45a09d50fb1cf70d5e853e93553', NULL, NULL, NULL, NULL, 3, NULL, 140, NULL, 1),
(140, 'Camera Obscura', NULL, NULL, NULL, 'cdae29d644068c88fd11ccec48ad39f4b1f4e5e3', NULL, NULL, NULL, NULL, 3, NULL, 141, NULL, 1),
(141, 'Camion', NULL, NULL, NULL, '754882a3f8a3de22c574a9b2a68a5650a556e16c', NULL, NULL, NULL, NULL, 3, NULL, 142, NULL, 1),
(142, 'Campeoncito', NULL, NULL, NULL, '8c27cbba8a8fc59dd6fe46231994543589b7378f', NULL, NULL, NULL, NULL, 3, NULL, 143, NULL, 1),
(143, 'Camper Van Beethoven', NULL, NULL, NULL, '147fc86a77632446f93ac21ba431e06fdcf05f45', NULL, NULL, NULL, NULL, 3, NULL, 144, NULL, 1),
(144, 'Cannonball Adderley', NULL, NULL, NULL, '2478daa2f61bdb288f6bc2f218b3c988e5375b96', NULL, NULL, NULL, NULL, 3, NULL, 145, NULL, 1),
(145, 'Canto el Cuerpo Eléctrico', NULL, NULL, NULL, '525d0cd345735fb4a1d1dc5537b9ffd59a98aeed', NULL, NULL, NULL, NULL, 3, NULL, 146, NULL, 1),
(146, 'Captains of Sea and War', NULL, NULL, NULL, 'e52de51d353143bbee1a89c9e816aadb20ddccc8', NULL, NULL, NULL, NULL, 3, NULL, 147, NULL, 1),
(147, 'Car Seat Headrest', NULL, NULL, NULL, 'ec07707d57363c9b08db8f24eabce92775a56b93', NULL, NULL, NULL, NULL, 3, NULL, 148, NULL, 1),
(148, 'Caras descartables', NULL, NULL, NULL, 'dcbb3f04088f3ee64297870f8c6ea09450c660db', NULL, NULL, NULL, NULL, 3, NULL, 149, NULL, 1),
(149, 'Carca', NULL, NULL, NULL, '7b846c56f3678c7198c5c785ed3946372dd2100b', NULL, NULL, NULL, NULL, 3, NULL, 150, NULL, 1),
(150, 'Casimiro Roble', NULL, NULL, NULL, 'd73d3eded47e09d628f043f63cdaab01c0405bd9', NULL, NULL, NULL, NULL, 3, NULL, 151, NULL, 1),
(151, 'CASTLEBEAT', NULL, NULL, NULL, '0b6a8839f075357069741c57ed4c8bae55213edc', NULL, NULL, NULL, NULL, 3, NULL, 152, NULL, 1),
(152, 'Cat Power', NULL, NULL, NULL, '6fde3e4c1d69a6116b8abd8848644f7181aabf56', NULL, NULL, NULL, NULL, 3, NULL, 153, NULL, 1),
(153, 'Catatonia', NULL, NULL, NULL, '862c8344bdb60e3dc87e17fe8ee269fe255913c9', NULL, NULL, NULL, NULL, 3, NULL, 154, NULL, 1),
(154, 'Cayetana', NULL, NULL, NULL, 'b03e0d36aef24b61a490d65daffbd20882959766', NULL, NULL, NULL, NULL, 3, NULL, 155, NULL, 1),
(155, 'Centella', NULL, NULL, NULL, 'e3823f0e11cc63ba2c546115c0436da0a81f156f', NULL, NULL, NULL, NULL, 3, NULL, 156, NULL, 1),
(156, 'Ceremony', NULL, NULL, NULL, 'f789f7ae4b2628833951ab485e2e1c9ed9296dcb', NULL, NULL, NULL, NULL, 3, NULL, 157, NULL, 1),
(157, 'The Charlatans', NULL, NULL, NULL, 'd4158b70964e453a45442e032cc91a9a020263f5', NULL, NULL, NULL, NULL, 3, NULL, 158, NULL, 1),
(158, 'Charles Mingus', NULL, NULL, NULL, 'f083aed0d116b298e84d335d74748d7b46860710', NULL, NULL, NULL, NULL, 3, NULL, 159, NULL, 1),
(159, 'Charlie Haden & Hank Jones', NULL, NULL, NULL, 'ddba24485cb8cb1ff35f225e37fc3ed9eb0b2645', NULL, NULL, NULL, NULL, 3, NULL, 160, NULL, 1),
(160, 'Charlie Parker', NULL, NULL, NULL, 'f5cf7d7718dfed8fb69a996eb7e5c88e93bd17d9', NULL, NULL, NULL, NULL, 3, NULL, 161, NULL, 1),
(161, 'Charlie Parker and Chet Baker', NULL, NULL, NULL, 'ea5a9353a6dcdd138718dbd27d8c8507d85bfd0e', NULL, NULL, NULL, NULL, 3, NULL, 162, NULL, 1),
(162, 'Cheap Time', NULL, NULL, NULL, 'd3f39eba845060e7dbefffb69d6aa4c7ce0e906b', NULL, NULL, NULL, NULL, 3, NULL, 163, NULL, 1),
(163, 'Cheatahs', NULL, NULL, NULL, '525ef25f62f15e186bbd1e98fd884f5f23d1fecb', NULL, NULL, NULL, NULL, 3, NULL, 164, NULL, 1),
(164, 'Chelsea Light Moving', NULL, NULL, NULL, 'ba0bfe59da62c2c4d9741a9feec6711447cecf2f', NULL, NULL, NULL, NULL, 3, NULL, 165, NULL, 1),
(165, 'Chiquita y Chatarra', NULL, NULL, NULL, '1b726ca204c302a35f24ce1e061180bdd56b3539', NULL, NULL, NULL, NULL, 3, NULL, 166, NULL, 1),
(166, 'Chromatics', NULL, NULL, NULL, '025438ea1163e7b3de43ca7856f05dbc64a25239', NULL, NULL, NULL, NULL, 3, NULL, 167, NULL, 1),
(167, 'Chuck Turner', NULL, NULL, NULL, '9aca8a7c227c4d0038ab18cf5ff5ee22fa8abd4c', NULL, NULL, NULL, NULL, 3, NULL, 168, NULL, 1),
(168, 'Cid Campeador', NULL, NULL, NULL, '9c9c7c31797bd047aaec9161042d26c6e09a018d', NULL, NULL, NULL, NULL, 3, NULL, 169, NULL, 1),
(169, 'Cienfuegos', NULL, NULL, NULL, '8cde2d31c76d7ab85832b9b7fb585339011623f0', NULL, NULL, NULL, NULL, 3, NULL, 170, NULL, 1),
(170, 'Cigarettes After Sex', NULL, NULL, NULL, '2afc733133716ae05f6b10d09e92afcd5acca4a5', NULL, NULL, NULL, NULL, 3, NULL, 171, NULL, 1),
(171, 'Circa Survive', NULL, NULL, NULL, '04ad4e68ff7594a713e002eda6b19e4c25936dac', NULL, NULL, NULL, NULL, 3, NULL, 172, NULL, 1),
(172, 'Citizens!', NULL, NULL, NULL, '4b0248930f0dff20a660b8411620c9cb8522e401', NULL, NULL, NULL, NULL, 3, NULL, 173, NULL, 1),
(173, 'Ciudad Lineal', NULL, NULL, NULL, 'ace00e832f8275707e543d5677d8422b255f3a6f', NULL, NULL, NULL, NULL, 3, NULL, 174, NULL, 1),
(174, 'Civiles', NULL, NULL, NULL, '1f07bdb5bfbc82afafa5a70e612dfc4094489dd1', NULL, NULL, NULL, NULL, 3, NULL, 175, NULL, 1),
(175, 'The Clang Group', NULL, NULL, NULL, 'd5b8e6c5e5d78e770131ae7b8c218d0a77a1929a', NULL, NULL, NULL, NULL, 3, NULL, 176, NULL, 1),
(176, 'The Clash', NULL, NULL, NULL, 'fedbb5c77fc7eedf679b9259075588f3de4b006c', NULL, NULL, NULL, NULL, 3, NULL, 177, NULL, 1),
(177, 'The Clientele', NULL, NULL, NULL, '50f65a771c27ed79e1fdc2b892bb05bcaa9b14f7', NULL, NULL, NULL, NULL, 3, NULL, 178, NULL, 1),
(178, 'Cloud Nothings', NULL, NULL, NULL, '0a962c6d0f4d3af32e188bfe14854568e93bf40f', NULL, NULL, NULL, NULL, 3, NULL, 179, NULL, 1),
(179, 'Cockney Rejects', NULL, NULL, NULL, '726b27aa0f3accbe0c386482d6f6e454fddb31a8', NULL, NULL, NULL, NULL, 3, NULL, 180, NULL, 1),
(180, 'Cocteau Twins', NULL, NULL, NULL, '530ae12e734891ccb1753eadb6ed1e47f39b4a75', NULL, NULL, NULL, NULL, 3, NULL, 181, NULL, 1),
(181, 'La cofradia de flor solar', NULL, NULL, NULL, 'fd91a764502c5789fa2c0d92f569eba145554fa9', NULL, NULL, NULL, NULL, 3, NULL, 182, NULL, 1),
(182, 'La cofradia de la flor solar', NULL, NULL, NULL, '43525c1862a7744fcbdbce5ed1a911bff9c483bb', NULL, NULL, NULL, NULL, 3, NULL, 183, NULL, 1),
(183, 'Cold War Kids', NULL, NULL, NULL, '1648c077ff976c21851f0c02dac065fa44bdc938', NULL, NULL, NULL, NULL, 3, NULL, 184, NULL, 1),
(184, 'Color Humano', NULL, NULL, NULL, '5d838bb90d24c370e8fd6c71fa23e3dacd2ab773', NULL, NULL, NULL, NULL, 3, NULL, 185, NULL, 1),
(185, 'Comet Gain', NULL, NULL, NULL, '04679e565c680a272fa04da5e8db3c46a9fe26d1', NULL, NULL, NULL, NULL, 3, NULL, 186, NULL, 1),
(186, 'cool american', NULL, NULL, NULL, '9a19bd5f2c8543cc1d3219bda5606935e01e09d8', NULL, NULL, NULL, NULL, 3, NULL, 187, NULL, 1),
(187, 'The Coral', NULL, NULL, NULL, '1bfd65779316f39305f0e0b6d8fdb28a5aac4203', NULL, NULL, NULL, NULL, 3, NULL, 188, NULL, 1),
(188, 'Corridor', NULL, NULL, NULL, '8bd1967aeb9ea1b379c1944526e89b1839c6f29b', NULL, NULL, NULL, NULL, 3, NULL, 189, NULL, 1),
(189, 'Cosmo', NULL, NULL, NULL, 'e2d9248d9ce59b951f55926f05c8507493ad3722', NULL, NULL, NULL, NULL, 3, NULL, 190, NULL, 1),
(190, 'Courtney Barnett', NULL, NULL, NULL, '1431eba30b33d57e228df9c9b0d38eff99fffb6a', NULL, NULL, NULL, NULL, 3, NULL, 191, NULL, 1),
(191, 'Courtney Barnett & Kurt Vile', NULL, NULL, NULL, '72495af4ac55d2fd05534d5e4884a5f03d1ddd5d', NULL, NULL, NULL, NULL, 3, NULL, 192, NULL, 1),
(192, 'The Crabs', NULL, NULL, NULL, '73a25df7158e23876a05ad282a5dd872b36054c3', NULL, NULL, NULL, NULL, 3, NULL, 193, NULL, 1),
(193, 'The Cramps', NULL, NULL, NULL, 'a5bfe7eb4e958505d59c35f16667d557971cea96', NULL, NULL, NULL, NULL, 3, NULL, 194, NULL, 1),
(194, 'Cream', NULL, NULL, NULL, 'ec66aa6006b0c1702f21b8e11edb2c1a65cf30d2', NULL, NULL, NULL, NULL, 3, NULL, 195, NULL, 1),
(195, 'Crocodiles', NULL, NULL, NULL, '181b59054dcef2961acea789addb7c4d4ec9b431', NULL, NULL, NULL, NULL, 3, NULL, 196, NULL, 1),
(196, 'Crystal Stilts', NULL, NULL, NULL, 'cf30132539587507968459dec2c415b38b850884', NULL, NULL, NULL, NULL, 3, NULL, 197, NULL, 1),
(197, 'The Cure', NULL, NULL, NULL, '0222f5fd6ab18a5dac94ab3f32fabf3557282721', NULL, NULL, NULL, NULL, 3, NULL, 198, NULL, 1),
(198, 'The Cynics', NULL, NULL, NULL, '063db63957c3c1463f8d8e37c913f1907dd76be7', NULL, NULL, NULL, NULL, 3, NULL, 199, NULL, 1),
(199, 'The Dacios', NULL, NULL, NULL, '0e824e1c597ab56c85f062d3ccd71ba51dcdca3c', NULL, NULL, NULL, NULL, 3, NULL, 200, NULL, 1),
(200, 'The Daktaris', NULL, NULL, NULL, '1f396bd0abc87404fa284c1fe89955c008bd775b', NULL, NULL, NULL, NULL, 3, NULL, 201, NULL, 1),
(201, 'The Damned', NULL, NULL, NULL, '0a0d3209362346bac87a2489891554333b01e8f8', NULL, NULL, NULL, NULL, 3, NULL, 202, NULL, 1),
(202, 'Damon Albarn', NULL, NULL, NULL, '61e21bb345e9905084861b69b575b047700caaa4', NULL, NULL, NULL, NULL, 3, NULL, 203, NULL, 1),
(203, 'Dance Macabre', NULL, NULL, NULL, '29edd9bf7c00cdcca2f10a04c568c1a3ab348816', NULL, NULL, NULL, NULL, 3, NULL, 204, NULL, 1),
(204, 'Dandy Livingstone', NULL, NULL, NULL, '646026a424918fdeefba588a9992ea5ca9195521', NULL, NULL, NULL, NULL, 3, NULL, 205, NULL, 1),
(205, 'The Dandy Warhols', NULL, NULL, NULL, '970a3488dbb755f9a9e82ecfb890e7df6b330d1a', NULL, NULL, NULL, NULL, 3, NULL, 206, NULL, 1),
(206, 'Daniel johnston', NULL, NULL, NULL, 'f769f1f8dab789a3840e2bb70fb914cf9e761e49', NULL, NULL, NULL, NULL, 3, NULL, 207, NULL, 1),
(207, 'Daniel Maza', NULL, NULL, NULL, 'c873ce0a9b97f960c7065fe44f8026170d70df9f', NULL, NULL, NULL, NULL, 3, NULL, 208, NULL, 1),
(208, 'Dave Brubeck', NULL, NULL, NULL, 'b40f6a39ae410efd8a2cde830f5e043b78251283', NULL, NULL, NULL, NULL, 3, NULL, 209, NULL, 1),
(209, 'David Bowie', NULL, NULL, NULL, '569b30988c60fdc0f582bcd9608946e3bfaaa028', NULL, NULL, NULL, NULL, 3, NULL, 210, NULL, 1),
(210, 'Davie Allan & the Arrows', NULL, NULL, NULL, '3eefbfd3091a9c599874a02cb89c17c8cddd92ba', NULL, NULL, NULL, NULL, 3, NULL, 211, NULL, 1),
(211, 'Daytonas', NULL, NULL, NULL, '111b43d068d4f138fd0bf0c23f6e835205cfdb9d', NULL, NULL, NULL, NULL, 3, NULL, 212, NULL, 1),
(212, 'Dead Boys', NULL, NULL, NULL, '548103adb33b784bdcac974d481876c53ddacdcc', NULL, NULL, NULL, NULL, 3, NULL, 213, NULL, 1),
(213, 'Dead Elvis & His One Man Grave', NULL, NULL, NULL, 'c4f430c3710a696c9ef0711e6d5afa0a8ce5f0cf', NULL, NULL, NULL, NULL, 3, NULL, 214, NULL, 1),
(214, 'The Dead Superstars', NULL, NULL, NULL, '80a386d976fd5bf4ffcecb0859781427be12c2fa', NULL, NULL, NULL, NULL, 3, NULL, 215, NULL, 1),
(215, 'The Dead Weather', NULL, NULL, NULL, '3730216a238215fd2de84993af61cbb08d70e628', NULL, NULL, NULL, NULL, 3, NULL, 216, NULL, 1),
(216, 'Deaf Radio', NULL, NULL, NULL, 'f64da02108ccc0bbeaa93f68059199a6585d536f', NULL, NULL, NULL, NULL, 3, NULL, 217, NULL, 1),
(217, 'The Dealers', NULL, NULL, NULL, 'f864850833658b63d5b0b2b5cfe53081ddb868b7', NULL, NULL, NULL, NULL, 3, NULL, 218, NULL, 1),
(218, 'Death', NULL, NULL, NULL, '762af280735987a82e80564aceb431dd346f945d', NULL, NULL, NULL, NULL, 3, NULL, 219, NULL, 1),
(219, 'The Decemberists', NULL, NULL, NULL, 'a491835f71e13ed158ad64cb0f8e90ec712fb497', NULL, NULL, NULL, NULL, 3, NULL, 220, NULL, 1),
(220, 'decurs', NULL, NULL, NULL, '40d5a95b4bebe38d34540f2732a2acb1a87ec0a7', NULL, NULL, NULL, NULL, 3, NULL, 221, NULL, 1),
(221, 'Dee Dee Ramone', NULL, NULL, NULL, '05e530a7a3f06b17f9c2b14d18c160d7f5adcebc', NULL, NULL, NULL, NULL, 3, NULL, 222, NULL, 1),
(222, 'Deep Sea Diver', NULL, NULL, NULL, '0a541f7b65bab1e93fae0c7dce8e277f25e43ebb', NULL, NULL, NULL, NULL, 3, NULL, 223, NULL, 1),
(223, 'Deerhoof', NULL, NULL, NULL, '4d6141044f0ad663d05e2acd04ecc3788fadbce2', NULL, NULL, NULL, NULL, 3, NULL, 224, NULL, 1),
(224, 'The Del Shapiros', NULL, NULL, NULL, '9664b3588828334532d9e607e78b373cb9ac6566', NULL, NULL, NULL, NULL, 3, NULL, 225, NULL, 1),
(225, 'Delroy Wilson Meets Sly & Robbie', NULL, NULL, NULL, 'cbeb62892dd391a3994e241d90a19e7abf6dab19', NULL, NULL, NULL, NULL, 3, NULL, 226, NULL, 1),
(226, 'Delta Sleep', NULL, NULL, NULL, '1514990114ce418e98250845fb4eb6198d068b64', NULL, NULL, NULL, NULL, 3, NULL, 227, NULL, 1),
(227, 'Dennis Brown', NULL, NULL, NULL, 'f2b3c51b1b98eda5eec7d5a01667faed83e65e57', NULL, NULL, NULL, NULL, 3, NULL, 228, NULL, 1),
(228, 'Derrick Harriot', NULL, NULL, NULL, 'ecfd4f332a4a70ba448cca44be2f28833390731f', NULL, NULL, NULL, NULL, 3, NULL, 229, NULL, 1),
(229, 'Derrick Harriott', NULL, NULL, NULL, '653464f18d47de924c0330bdd74239f892efb57d', NULL, NULL, NULL, NULL, 3, NULL, 230, NULL, 1),
(230, 'Desconocido (Huerfano)', NULL, NULL, NULL, '24314ed90fe65a5e1fd90c1bd5163b003cfbf096', NULL, NULL, NULL, NULL, 3, NULL, 231, NULL, 1),
(231, 'Desmond Dekker & The Aces', NULL, NULL, NULL, '68639e205720fefd8fe4a218a62c841e84334cd7', NULL, NULL, NULL, NULL, 3, NULL, 232, NULL, 1),
(232, 'Desmond Dekker and The Specials', NULL, NULL, NULL, '417bfd01f4aa7c3ca92eafb7a5dc1112f1a09216', NULL, NULL, NULL, NULL, 3, NULL, 233, NULL, 1),
(233, 'Destruyan a los robots', NULL, NULL, NULL, '4af0ec87cb3adf9bb95c27ef1abec0c01306a548', NULL, NULL, NULL, NULL, 3, NULL, 234, NULL, 1),
(234, 'The Detroit Cobras', NULL, NULL, NULL, '739cd2060bda46dd8cd38ded0f6b8a91078d9768', NULL, NULL, NULL, NULL, 3, NULL, 235, NULL, 1),
(235, 'Devo', NULL, NULL, NULL, 'eee94d6f0c0cc8d91a3f10332a9397b0c978d742', NULL, NULL, NULL, NULL, 3, NULL, 236, NULL, 1),
(236, 'Dexter Gordon', NULL, NULL, NULL, 'cc8a2272b5d0df816027442c8b646ee7989317d1', NULL, NULL, NULL, NULL, 3, NULL, 237, NULL, 1),
(237, 'Dick Dale And His Del-Tones', NULL, NULL, NULL, 'cfd05a469d42b568cf4688aa9bb29ab891715916', NULL, NULL, NULL, NULL, 3, NULL, 238, NULL, 1),
(238, 'Diego Schissi Doble Cuarteto', NULL, NULL, NULL, 'b62d40c7deac9da19792141a432c288275bee0b2', NULL, NULL, NULL, NULL, 3, NULL, 239, NULL, 1),
(239, 'Diego Schissi Doble Cuartetoi', NULL, NULL, NULL, '0200292ed733f2917c33caaa6de4b690186eba8c', NULL, NULL, NULL, NULL, 3, NULL, 240, NULL, 1),
(240, 'Dillinger', NULL, NULL, NULL, '238ab73d30243a4951d076038d10ff0defe29ce8', NULL, NULL, NULL, NULL, 3, NULL, 241, NULL, 1),
(241, 'Dinosaur Jr', NULL, NULL, NULL, 'b0af070116c76dff1625cf6b5dc565d4732264fa', NULL, NULL, NULL, NULL, 3, NULL, 242, NULL, 1),
(242, 'Dinosaur Jr.', NULL, NULL, NULL, 'b96b0980d0af6584a274be9cde1debb4bc125588', NULL, NULL, NULL, NULL, 3, NULL, 243, NULL, 1),
(243, 'Dios', NULL, NULL, NULL, '7031d7618b4f4c4fedd9143dfde5fbfc0fa70c27', NULL, NULL, NULL, NULL, 3, NULL, 244, NULL, 1),
(244, 'Diosque', NULL, NULL, NULL, '119650a0d169a6bda6fb889a5150e9e129a20353', NULL, NULL, NULL, NULL, 3, NULL, 245, NULL, 1),
(245, 'Dirt Dress', NULL, NULL, NULL, '29982409550e372c3c19733e4e68755d7fcad5e2', NULL, NULL, NULL, NULL, 3, NULL, 246, NULL, 1),
(246, 'Dirty Ghosts', NULL, NULL, NULL, 'a647952f26bf3657158adb426b7c0d2fa695cbae', NULL, NULL, NULL, NULL, 3, NULL, 247, NULL, 1),
(247, 'Dizzy Gillespie', NULL, NULL, NULL, 'ad40f1840b6dc3a4e74d24f40e83a635a102dcdc', NULL, NULL, NULL, NULL, 3, NULL, 248, NULL, 1),
(248, 'Dizzy Reece', NULL, NULL, NULL, 'c5ea2667042094cbe8be72fe490a90baef3e2174', NULL, NULL, NULL, NULL, 3, NULL, 249, NULL, 1),
(249, 'Doctor Explosion', NULL, NULL, NULL, 'f74c33d1853665673d932f5edf530be74dd74dbc', NULL, NULL, NULL, NULL, 3, NULL, 250, NULL, 1),
(250, 'The Dodos', NULL, NULL, NULL, 'a1936635f69405389b32ac1ef1af8abac6ca1851', NULL, NULL, NULL, NULL, 3, NULL, 251, NULL, 1),
(251, 'Don Cherry; John Coltrane', NULL, NULL, NULL, '628b8ff113c0087edadec11f14f4e6d32d7edc88', NULL, NULL, NULL, NULL, 3, NULL, 252, NULL, 1),
(252, 'Don Cornelio y la Zona', NULL, NULL, NULL, '9eb9537339dfc35202a06d6e32a78761347f66e1', NULL, NULL, NULL, NULL, 3, NULL, 253, NULL, 1),
(253, 'The Doors', NULL, NULL, NULL, '86663617a789c388ca7cd37daff1466d36eec454', NULL, NULL, NULL, NULL, 3, NULL, 254, NULL, 1),
(254, 'Dos Astronautas', NULL, NULL, NULL, 'e77c6acecf44f82c75721a60c9e2e831de39285c', NULL, NULL, NULL, NULL, 3, NULL, 255, NULL, 1),
(255, 'The Double Deckers', NULL, NULL, NULL, 'b8d438dbbd840ead9b39cd66dc4a19e64f02b710', NULL, NULL, NULL, NULL, 3, NULL, 256, NULL, 1),
(256, 'Dr Feelgood', NULL, NULL, NULL, 'eef29a9407abcaffffbcde89d0eca6d8aeb8b029', NULL, NULL, NULL, NULL, 3, NULL, 257, NULL, 1),
(257, 'The Dragtones', NULL, NULL, NULL, '980ebebcd5bd771cb3367ce781ffe870a5d5400f', NULL, NULL, NULL, NULL, 3, NULL, 258, NULL, 1),
(258, 'The Dream Syndicate', NULL, NULL, NULL, '7e5339a9832b6eebcc745f34c5f30f76063cb443', NULL, NULL, NULL, NULL, 3, NULL, 259, NULL, 1),
(259, 'Drive-By Truckers', NULL, NULL, NULL, '0d95bc6a71d1a80af617f755123535d44fb90241', NULL, NULL, NULL, NULL, 3, NULL, 260, NULL, 1),
(260, 'The Drums', NULL, NULL, NULL, 'b5d6abdfc4a78756e432b26da03a1a6a1fe55ddf', NULL, NULL, NULL, NULL, 3, NULL, 261, NULL, 1),
(261, 'Dub Specialist', NULL, NULL, NULL, '9b4aeaa9e25bb0acd6e17494715a8b26c705731c', NULL, NULL, NULL, NULL, 3, NULL, 262, NULL, 1),
(262, 'Duck Duck Grey Duck', NULL, NULL, NULL, '33d99ef70ff9f087d64287072815f854061579ed', NULL, NULL, NULL, NULL, 3, NULL, 263, NULL, 1),
(263, 'The Duppies', NULL, NULL, NULL, '8b861fec0ccaf5df914fa47eff21498c9005aa3d', NULL, NULL, NULL, NULL, 3, NULL, 264, NULL, 1),
(264, 'Eagles of Death Metal', NULL, NULL, NULL, '6d40592200b20017a2abb361cad03170d6eca91a', NULL, NULL, NULL, NULL, 3, NULL, 265, NULL, 1),
(265, 'Eagles of Death Metal (Eodm)', NULL, NULL, NULL, '2a662a01fb5a5c3aed7ab1b526727e5525a93055', NULL, NULL, NULL, NULL, 3, NULL, 266, NULL, 1),
(266, 'Eagulls', NULL, NULL, NULL, '3104d9cbb5b35f50f7168ef61f68bb9d8bceaef0', NULL, NULL, NULL, NULL, 3, NULL, 267, NULL, 1),
(267, 'Eddie Vedder', NULL, NULL, NULL, 'dea1ead2f83d2ad6bb74749296f2d327b2b67e18', NULL, NULL, NULL, NULL, 3, NULL, 268, NULL, 1),
(268, 'Editors', NULL, NULL, NULL, 'f2b9071e6927431447be63e7b781f8f2cb9ae49a', NULL, NULL, NULL, NULL, 3, NULL, 269, NULL, 1),
(269, 'Eels', NULL, NULL, NULL, '371ba3e4aacc55405c9d5ae91b7791a5ba856fcc', NULL, NULL, NULL, NULL, 3, NULL, 270, NULL, 1),
(270, 'El Estrellero', NULL, NULL, NULL, 'cd2679bec0372b3146ddcaabf7d536e22cfcf7b1', NULL, NULL, NULL, NULL, 3, NULL, 271, NULL, 1),
(271, 'El Hipnotizador Romántico', NULL, NULL, NULL, 'a2681c0c10f849584b58225c89e26d3566ba8ef0', NULL, NULL, NULL, NULL, 3, NULL, 272, NULL, 1),
(272, 'El Lado Oscuro de la Broca', NULL, NULL, NULL, '7db823c095f5d0a2a598841d98b1790c6381f34d', NULL, NULL, NULL, NULL, 3, NULL, 273, NULL, 1),
(273, 'El Mató A Un Policia Motorizad0', NULL, NULL, NULL, '2c7e770978ed2a1e48a09c88be7a632756a6776d', NULL, NULL, NULL, NULL, 3, NULL, 274, NULL, 1),
(274, 'El Mató A Un Policia Motorizado', NULL, NULL, NULL, 'fdaa41d0d222275caf12caed5b8ea7e828cf5477', NULL, NULL, NULL, NULL, 3, NULL, 275, NULL, 1),
(275, 'El Mato Un Policia Motorizado', NULL, NULL, NULL, '94486142b4ce36267750e25d366f25a3dc6ddace', NULL, NULL, NULL, NULL, 3, NULL, 276, NULL, 1),
(276, 'El perrodiablo', NULL, NULL, NULL, '6a019e261796a7cecc0817b0cfa83c846014a81b', NULL, NULL, NULL, NULL, 3, NULL, 277, NULL, 1),
(277, 'El Plan de la Mariposa', NULL, NULL, NULL, 'ebe256c1e6ffcb2f139245a5fa34a20aedc68900', NULL, NULL, NULL, NULL, 3, NULL, 278, NULL, 1),
(278, 'El Reloj', NULL, NULL, NULL, '703af78568312858c1ff7abfb5b052803a55398b', NULL, NULL, NULL, NULL, 3, NULL, 279, NULL, 1),
(279, 'El Robot Bajo El Agua', NULL, NULL, NULL, '35e8e99ab5c26ecba93d388dfdf668471b5ab549', NULL, NULL, NULL, NULL, 3, NULL, 280, NULL, 1),
(280, 'El Sur', NULL, NULL, NULL, '6a391d0aae68648b5984e0ec1a837e6a7fc1ef9e', NULL, NULL, NULL, NULL, 3, NULL, 281, NULL, 1),
(281, 'Elliot Smith', NULL, NULL, NULL, 'e950cc022cef5800c59c819d27d82153f7ff5407', NULL, NULL, NULL, NULL, 3, NULL, 282, NULL, 1),
(282, 'Elliott Smith', NULL, NULL, NULL, '854ffaa5538f4674b83c42dae751b280e125c38e', NULL, NULL, NULL, NULL, 3, NULL, 283, NULL, 1),
(283, 'Elvin Jones', NULL, NULL, NULL, 'ddf4334e998508894f20bc691dd9920f72d05c8b', NULL, NULL, NULL, NULL, 3, NULL, 284, NULL, 1),
(284, 'Elvis Costello', NULL, NULL, NULL, 'be6619514d624e36daac13d8c8785f70f41c2b88', NULL, NULL, NULL, NULL, 3, NULL, 285, NULL, 1),
(285, 'Elvis Costello & The Attractions', NULL, NULL, NULL, 'dad879486a73422cc6bf9c3dc588c92a4bd44925', NULL, NULL, NULL, NULL, 3, NULL, 286, NULL, 1),
(286, 'Elvis Presley', NULL, NULL, NULL, '22126ac7d2c8d0bbc616eee14823f37bab5ad294', NULL, NULL, NULL, NULL, 3, NULL, 287, NULL, 1),
(287, 'The English Beat', NULL, NULL, NULL, 'e375772dcc250cc3a87f37f52288c52d4d8261da', NULL, NULL, NULL, NULL, 3, NULL, 288, NULL, 1),
(288, 'Epumer Machi Judurcha', NULL, NULL, NULL, '4d403c706d855e4b3a378af1b8530418482fad52', NULL, NULL, NULL, NULL, 3, NULL, 289, NULL, 1),
(289, 'Eric Burdon & The Animals', NULL, NULL, NULL, '49af3d49497b7e453abf25c6af5844c13729e79e', NULL, NULL, NULL, NULL, 3, NULL, 290, NULL, 1),
(290, 'Eric\'s Trip', NULL, NULL, NULL, 'fed05cfe8affc0e093a283db12ba057d7ba74fc5', NULL, NULL, NULL, NULL, 3, NULL, 291, NULL, 1),
(291, 'Ernesto Jodos', NULL, NULL, NULL, 'e404c0f7525a67f3926e3948d9e6677e5ddc5072', NULL, NULL, NULL, NULL, 3, NULL, 292, NULL, 1),
(292, 'Escobar', NULL, NULL, NULL, '6c55b81783eeeb2fbc9b92b6db98f5ce212b274f', NULL, NULL, NULL, NULL, 3, NULL, 293, NULL, 1),
(293, 'Esperanza Spalding', NULL, NULL, NULL, '34b5a72fb12328f30581fe8f18208a344fc45436', NULL, NULL, NULL, NULL, 3, NULL, 294, NULL, 1),
(294, 'Esquizofrenicos', NULL, NULL, NULL, 'b8961e2b34575b4663fc74896bc7f23d2c3773ad', NULL, NULL, NULL, NULL, 3, NULL, 295, NULL, 1),
(295, 'Eternal Summers', NULL, NULL, NULL, 'aa19f5a479dd0d5b501a622ac9e698ca80575ed0', NULL, NULL, NULL, NULL, 3, NULL, 296, NULL, 1),
(296, 'Ethiopians', NULL, NULL, NULL, '1fa8bcaa8fd86af5909431de8f12033e83513adc', NULL, NULL, NULL, NULL, 3, NULL, 297, NULL, 1),
(297, 'The Event', NULL, NULL, NULL, 'a4904beb6748fcb681a618975fa35142911b9fc7', NULL, NULL, NULL, NULL, 3, NULL, 298, NULL, 1),
(298, 'Ex Dealer', NULL, NULL, NULL, 'da22281761b63f5564dc655dd92bb827d0010b35', NULL, NULL, NULL, NULL, 3, NULL, 299, NULL, 1),
(299, 'The Exbats', NULL, NULL, NULL, '77c7b21b85bb1af568c8ba5cc022d84e4725d5b0', NULL, NULL, NULL, NULL, 3, NULL, 300, NULL, 1),
(300, 'Exnovios', NULL, NULL, NULL, '4141f6a658cb81b00d050bc4da6244eec5faf0af', NULL, NULL, NULL, NULL, 3, NULL, 301, NULL, 1),
(301, 'Fabuloso Combo Espectro', NULL, NULL, NULL, '54ab29621af6e1259483dbe10fa629905e015f43', NULL, NULL, NULL, NULL, 3, NULL, 302, NULL, 1),
(302, 'The Falcons', NULL, NULL, NULL, 'db22a0eebb138e04b419e3f4ca6d2fb688c92ad8', NULL, NULL, NULL, NULL, 3, NULL, 303, NULL, 1),
(303, 'The Fall', NULL, NULL, NULL, '961cbcdac3d69318c875bfa10a204bb379ded3cd', NULL, NULL, NULL, NULL, 3, NULL, 304, NULL, 1),
(304, 'Fantasmage', NULL, NULL, NULL, 'ab5aac135283e033c5855c109fd40956ddbf9b60', NULL, NULL, NULL, NULL, 3, NULL, 305, NULL, 1),
(305, 'Fantasmagoria', NULL, NULL, NULL, '8417ed2cbb0230f42f1cf66ae8601144afc8d041', NULL, NULL, NULL, NULL, 3, NULL, 306, NULL, 1),
(306, 'Fat Tulips', NULL, NULL, NULL, '35efbf86af690c843550207f728a00c4c89ab0c4', NULL, NULL, NULL, NULL, 3, NULL, 307, NULL, 1),
(307, 'The Feelies', NULL, NULL, NULL, '9215b611fb9f586072b0fe5dfaffd425eadd1b2d', NULL, NULL, NULL, NULL, 3, NULL, 308, NULL, 1),
(308, 'Fela Anikulapo Kuti', NULL, NULL, NULL, '8cd2e1a5f5943fc0e06e8c2b974cd6781e0e63b2', NULL, NULL, NULL, NULL, 3, NULL, 309, NULL, 1),
(309, 'Fela Kuti', NULL, NULL, NULL, 'bcd53a7ddd6bff196397c07ef1b3174545461c74', NULL, NULL, NULL, NULL, 3, NULL, 310, NULL, 1),
(310, 'Fela Ransome Kuti & the Africa \'70', NULL, NULL, NULL, 'f392dee8adb97363751a975cbb0358c4e62396bc', NULL, NULL, NULL, NULL, 3, NULL, 311, NULL, 1),
(311, 'The Felines', NULL, NULL, NULL, '3de3791c22c42b98a1e0a6cf51246ea2a749426a', NULL, NULL, NULL, NULL, 3, NULL, 312, NULL, 1),
(312, 'Félix', NULL, NULL, NULL, '5c04e57f5ae3fee696d36a4a2fdd24fb5b69e145', NULL, NULL, NULL, NULL, 3, NULL, 313, NULL, 1),
(313, 'Fer Pylo', NULL, NULL, NULL, '576fbf76d53fe80e5115da65576b9cbc5a85de13', NULL, NULL, NULL, NULL, 3, NULL, 314, NULL, 1),
(314, 'The Fire Tornados', NULL, NULL, NULL, 'b992df6f02c884888624d60ce7fb25ecefa1e38e', NULL, NULL, NULL, NULL, 3, NULL, 315, NULL, 1),
(315, 'The Flaming Lips', NULL, NULL, NULL, '80e22645e22da1cf2bb4ee1a6b9da73562c36023', NULL, NULL, NULL, NULL, 3, NULL, 316, NULL, 1),
(316, 'The Fleshtones', NULL, NULL, NULL, '4bee00287188d0e1cdfa44847d2e6935ffd3b465', NULL, NULL, NULL, NULL, 3, NULL, 317, NULL, 1),
(317, 'The Flies', NULL, NULL, NULL, 'f46f91ac11c04ea069bdb222d84a5eed70f552ff', NULL, NULL, NULL, NULL, 3, NULL, 318, NULL, 1),
(318, 'Flopa Minimal', NULL, NULL, NULL, 'decf603cc0388065405a45529f1e488c3aa2ae65', NULL, NULL, NULL, NULL, 3, NULL, 319, NULL, 1),
(319, 'Foals', NULL, NULL, NULL, '89d115d3936adbef3ca00c9a0e00899369ec4a95', NULL, NULL, NULL, NULL, 3, NULL, 320, NULL, 1),
(320, 'Folie', NULL, NULL, NULL, '0e3bd31b8620f74a0db5cb5524af83bc888beb6c', NULL, NULL, NULL, NULL, 3, NULL, 321, NULL, 1),
(321, 'Foo Fighters', NULL, NULL, NULL, '2a99f27d0e8fb34b75c2d5f3e2a623b78b823c48', NULL, NULL, NULL, NULL, 3, NULL, 322, NULL, 1),
(322, 'Four Eyes', NULL, NULL, NULL, '97305c2285733cb9e9c3e1d2bce23ee37421081f', NULL, NULL, NULL, NULL, 3, NULL, 323, NULL, 1),
(323, 'Fraidycat', NULL, NULL, NULL, '3cd27215ee5de945407702567464d25699cdc2ab', NULL, NULL, NULL, NULL, 3, NULL, 324, NULL, 1),
(324, 'Francine', NULL, NULL, NULL, '37947f294bf30b5a0bb215ba4cd7f4d77a345053', NULL, NULL, NULL, NULL, 3, NULL, 325, NULL, 1),
(325, 'Francisco Bochaton', NULL, NULL, NULL, '275d72f4998e77fc7f51c793e8198a3d6f5061d8', NULL, NULL, NULL, NULL, 3, NULL, 326, NULL, 1),
(326, 'Frank Black', NULL, NULL, NULL, '04f61c01ed12fc6484bce186bceef9ce6fd03d67', NULL, NULL, NULL, NULL, 3, NULL, 327, NULL, 1),
(327, 'Frank Black & The Catholics', NULL, NULL, NULL, 'aa55c50620c14c8081b9288f3493a66a50b8fdf2', NULL, NULL, NULL, NULL, 3, NULL, 328, NULL, 1),
(328, 'Frankie Cosmos', NULL, NULL, NULL, 'c354e011d2b74c917ebe1e9a5bd46867c85f1f22', NULL, NULL, NULL, NULL, 3, NULL, 329, NULL, 1),
(329, 'Franny Glass', NULL, NULL, NULL, 'c10ced68e6d9fbb8d3e5af1ceffb04db7906a26c', NULL, NULL, NULL, NULL, 3, NULL, 330, NULL, 1),
(330, 'Frau', NULL, NULL, NULL, 'ed0110e578e33a5e5e7cfa39ab40f0e4e71ed62d', NULL, NULL, NULL, NULL, 3, NULL, 331, NULL, 1),
(331, 'Freddie Hubbard', NULL, NULL, NULL, '57c721a6a0a916b1f5fd635dab0200b067a1c07c', NULL, NULL, NULL, NULL, 3, NULL, 332, NULL, 1),
(332, 'Frisbees', NULL, NULL, NULL, 'd3a5b7693c0cf72abf14c1b31ad20c987b0b58bc', NULL, NULL, NULL, NULL, 3, NULL, 333, NULL, 1),
(333, 'Fugazi', NULL, NULL, NULL, '9a929bb1cc86b9c20ebfe8e6b9e277e346085bc7', NULL, NULL, NULL, NULL, 3, NULL, 334, NULL, 1),
(334, 'Fungi Girls', NULL, NULL, NULL, 'eaf8f7931fc8ac04579d528cfd56e5a1f8eaf49f', NULL, NULL, NULL, NULL, 3, NULL, 335, NULL, 1),
(335, 'The Future Primitives', NULL, NULL, NULL, 'ef3394f9cd8960a2d1597060bacf8e7ad95cd3ee', NULL, NULL, NULL, NULL, 3, NULL, 336, NULL, 1),
(336, 'The Futureheads', NULL, NULL, NULL, 'a4fef75a34661c806c0e3ea897a376f6599a5877', NULL, NULL, NULL, NULL, 3, NULL, 337, NULL, 1),
(337, 'Futuro Terror', NULL, NULL, NULL, '6fe7e6af07b43a19ac602334018a8126c3255fc8', NULL, NULL, NULL, NULL, 3, NULL, 338, NULL, 1),
(338, 'Fuzz', NULL, NULL, NULL, '055079c39bb3b8dcaa74cee6837a27ac0c992bc3', NULL, NULL, NULL, NULL, 3, NULL, 339, NULL, 1),
(339, 'The Fuzztones', NULL, NULL, NULL, '47863a13df88ff4f09e18a0df28d24d4f40a2737', NULL, NULL, NULL, NULL, 3, NULL, 340, NULL, 1),
(340, 'The Galacticats', NULL, NULL, NULL, '94d401332ed89f7a740cd72ed370a22eb2418aae', NULL, NULL, NULL, NULL, 3, NULL, 341, NULL, 1),
(341, 'Galapagos', NULL, NULL, NULL, '771928adac27ac7ac0a15b56254f9cd028904f26', NULL, NULL, NULL, NULL, 3, NULL, 342, NULL, 1),
(342, 'Galaxie 500', NULL, NULL, NULL, '1dde0d8193964d2d2d7fe6f34a4a0b4467b2ac17', NULL, NULL, NULL, NULL, 3, NULL, 343, NULL, 1),
(343, 'Gang Of Four', NULL, NULL, NULL, '44e9f0ce6829f3780880213ebefa9bc9a3eb2d2e', NULL, NULL, NULL, NULL, 3, NULL, 344, NULL, 1),
(344, 'Garbage', NULL, NULL, NULL, 'ebfc3f28f3dde4127038e57cae1b38dc2e0449f3', NULL, NULL, NULL, NULL, 3, NULL, 345, NULL, 1),
(345, 'Gato Barbieri', NULL, NULL, NULL, 'e83ab4a613f039699d48b3853c0381fba14d2a71', NULL, NULL, NULL, NULL, 3, NULL, 346, NULL, 1),
(346, 'Gattopardo', NULL, NULL, NULL, '6b208fcc1a68fd3a5f53c7f4b6a2505e4c931583', NULL, NULL, NULL, NULL, 3, NULL, 347, NULL, 1),
(347, 'George Benson', NULL, NULL, NULL, 'c2ace5ee1b59343207a8a9c1f8cd3316bdd01e51', NULL, NULL, NULL, NULL, 3, NULL, 348, NULL, 1),
(348, 'Gerry Mulligan & Thelonious Monk', NULL, NULL, NULL, 'eb68833c88edfd0cb6682064c76ef845e98834ef', NULL, NULL, NULL, NULL, 3, NULL, 349, NULL, 1),
(349, 'The Ghost Wolves', NULL, NULL, NULL, 'bdd79fa570bdf7bbef9593ca367995439c522f9d', NULL, NULL, NULL, NULL, 3, NULL, 350, NULL, 1),
(350, 'Girl Ray', NULL, NULL, NULL, '9e86437573625d0ee3fc8032a0f3bd28c1dddace', NULL, NULL, NULL, NULL, 3, NULL, 351, NULL, 1),
(351, 'Girls Names', NULL, NULL, NULL, '9dd6991880909ec017c460008274aabc0a8a200c', NULL, NULL, NULL, NULL, 3, NULL, 352, NULL, 1),
(352, 'The Gladiators', NULL, NULL, NULL, '0e24d4547f4210c1baa43f1ec0b60564bbac18b5', NULL, NULL, NULL, NULL, 3, NULL, 353, NULL, 1),
(353, 'Gliss', NULL, NULL, NULL, '0f94a1354a688cb5e0f804ebdc97ebbf6f6c54d5', NULL, NULL, NULL, NULL, 3, NULL, 354, NULL, 1),
(354, 'The Glücks', NULL, NULL, NULL, 'e02f08000b444cd158f6e3e73f0657c661eb23a6', NULL, NULL, NULL, NULL, 3, NULL, 355, NULL, 1),
(355, 'Go No Go', NULL, NULL, NULL, '66f7f9d6c24f8d9f06be1c8ebc677f5dd21977de', NULL, NULL, NULL, NULL, 3, NULL, 356, NULL, 1),
(356, 'Goat', NULL, NULL, NULL, 'f81abadb80c0cd1537639e20eb220f077595715b', NULL, NULL, NULL, NULL, 3, NULL, 357, NULL, 1),
(357, 'Gogol Bordello', NULL, NULL, NULL, 'c41b37d363831a694e54ac5ba0c7b7122558a7b5', NULL, NULL, NULL, NULL, 3, NULL, 358, NULL, 1),
(358, 'The Good, the Bad & the Queen', NULL, NULL, NULL, 'f229ffa233129c309530a52964c0d943f153ef1c', NULL, NULL, NULL, NULL, 3, NULL, 359, NULL, 1),
(359, 'Gorianopolis', NULL, NULL, NULL, '107617db559e69556b444b1545c7ebc0359d41c7', NULL, NULL, NULL, NULL, 3, NULL, 360, NULL, 1),
(360, 'Gories', NULL, NULL, NULL, 'f4432909a74fe8219ef1b0b1c67d833eb957e99e', NULL, NULL, NULL, NULL, 3, NULL, 361, NULL, 1),
(361, 'Gorillaz', NULL, NULL, NULL, 'e6809dc89cbc696967b175160b4f9a10187ef7c5', NULL, NULL, NULL, NULL, 3, NULL, 362, NULL, 1),
(362, 'The Gotobeds', NULL, NULL, NULL, 'be8244d26371ab07b2d8c6498ab5986eddf22419', NULL, NULL, NULL, NULL, 3, NULL, 363, NULL, 1),
(363, 'Graham Coxon', NULL, NULL, NULL, 'b63c706d3e9f85eaf24e76cb0c70f5d89986d064', NULL, NULL, NULL, NULL, 3, NULL, 364, NULL, 1),
(364, 'La Gran Perdida de Energia', NULL, NULL, NULL, '24c65ad8db328ae048c85ec83cf5c1141825ea31', NULL, NULL, NULL, NULL, 3, NULL, 365, NULL, 1),
(365, 'Grandaddy', NULL, NULL, NULL, 'c3f2fe2bdee110b060781b53155c756b19ac4f97', NULL, NULL, NULL, NULL, 3, NULL, 366, NULL, 1),
(366, 'Graveyard', NULL, NULL, NULL, '1ed1135d871d0bb73c1d2a747c880726b40e3af9', NULL, NULL, NULL, NULL, 3, NULL, 367, NULL, 1),
(367, 'Great Thunder & Radiator Hospital', NULL, NULL, NULL, 'f4e01e584d3165cf7e8b82aec6fb8a2a985efcc5', NULL, NULL, NULL, NULL, 3, NULL, 368, NULL, 1),
(368, 'Gregory Isaacs', NULL, NULL, NULL, '9c4ce7e537b2452a362e9d47ba26137a3bb921af', NULL, NULL, NULL, NULL, 3, NULL, 369, NULL, 1),
(369, 'Grinderman', NULL, NULL, NULL, '53855e1e0fd8098f874d6ea247bdadd3a2c82e1f', NULL, NULL, NULL, NULL, 3, NULL, 370, NULL, 1),
(370, 'The Growlers', NULL, NULL, NULL, '5e2adb039ad1ed26d47d1d8c4639eea7b9985967', NULL, NULL, NULL, NULL, 3, NULL, 371, NULL, 1),
(371, 'Grupo de expertos Solynieve', NULL, NULL, NULL, '6d60a9cba78f6896795bf679612191745e39c916', NULL, NULL, NULL, NULL, 3, NULL, 372, NULL, 1),
(372, 'Guachass', NULL, NULL, NULL, '0d5c4f17a81ccf0712c85fb3c403c7722e4d55d9', NULL, NULL, NULL, NULL, 3, NULL, 373, NULL, 1),
(373, 'Güacho', NULL, NULL, NULL, '255ec9992a1f08fb81f33b37603b1735730ec3f6', NULL, NULL, NULL, NULL, 3, NULL, 374, NULL, 1),
(374, 'Guadalupe Plata', NULL, NULL, NULL, 'df6b998efe53f2aca57e0df02f1ed43affb67358', NULL, NULL, NULL, NULL, 3, NULL, 375, NULL, 1),
(375, 'Guantanamo Baywatch', NULL, NULL, NULL, 'dca17e5fe1ff736a9e953458fc5dbad3fff770c3', NULL, NULL, NULL, NULL, 3, NULL, 376, NULL, 1),
(376, 'Guided By Voices', NULL, NULL, NULL, '21a84d57d21619c38cc2608bba5e66e75c671aa8', NULL, NULL, NULL, NULL, 3, NULL, 377, NULL, 1),
(377, 'The Hair', NULL, NULL, NULL, '4bbddf313a84f2f080af1d1a45af7262dba7a871', NULL, NULL, NULL, NULL, 3, NULL, 378, NULL, 1),
(378, 'Half Japanese', NULL, NULL, NULL, 'a01189a66efff9fc3d5251fb7e1acb22258014ee', NULL, NULL, NULL, NULL, 3, NULL, 379, NULL, 1),
(379, 'Hamilton Leithauser', NULL, NULL, NULL, '223b3029267d848e71c0d45a006ed5c6c1a542eb', NULL, NULL, NULL, NULL, 3, NULL, 380, NULL, 1);
INSERT INTO `profile` (`id`, `name`, `last_name`, `birth_date`, `birth_location`, `photo`, `mail`, `phone`, `facebook`, `twitter`, `visibility`, `gender_id`, `options_id`, `gender_desc`, `listed`) VALUES
(380, 'Harbie Hancock', NULL, NULL, NULL, '026768bd3289421e0b6bc3ea212207fc5490cd61', NULL, NULL, NULL, NULL, 3, NULL, 381, NULL, 1),
(381, 'Harlem', NULL, NULL, NULL, 'ce815e70d8a7ba665dcab401f876affefa40ab84', NULL, NULL, NULL, NULL, 3, NULL, 382, NULL, 1),
(382, 'Hazte lapon', NULL, NULL, NULL, 'b4fd36a24bacb063368d66673179f357d7bb6178', NULL, NULL, NULL, NULL, 3, NULL, 383, NULL, 1),
(383, 'Heaters', NULL, NULL, NULL, '8d7625bacdad24c779a9ad94ab7aff652e226d64', NULL, NULL, NULL, NULL, 3, NULL, 384, NULL, 1),
(384, 'Heavy Trash', NULL, NULL, NULL, '79d4a7b8713cd4425e96b7d19e4500021f9b257d', NULL, NULL, NULL, NULL, 3, NULL, 385, NULL, 1),
(385, 'Hefner', NULL, NULL, NULL, 'a4564ff9b25ac4cf3b9d5766bc44eea440c7699a', NULL, NULL, NULL, NULL, 3, NULL, 386, NULL, 1),
(386, 'The Heliocentrics', NULL, NULL, NULL, 'fd236250cd0efecc27310ef8169c9b6bcda2274d', NULL, NULL, NULL, NULL, 3, NULL, 387, NULL, 1),
(387, 'Heptones', NULL, NULL, NULL, 'f2a97fe07521df659fc21a37227ae1eddba65673', NULL, NULL, NULL, NULL, 3, NULL, 388, NULL, 1),
(388, 'Herbie Hancock', NULL, NULL, NULL, '332d70a4544ed34f2415f42b5f988f232c3ba417', NULL, NULL, NULL, NULL, 3, NULL, 389, NULL, 1),
(389, 'Hernan Oliva', NULL, NULL, NULL, '1d69548cd0563af2e5b6e6b95c05003edcdb3588', NULL, NULL, NULL, NULL, 3, NULL, 390, NULL, 1),
(390, 'High Tone', NULL, NULL, NULL, '9d3010920b85f86977680a0a4ec34d19e4ba4bf4', NULL, NULL, NULL, NULL, 3, NULL, 391, NULL, 1),
(391, 'The Hillbilly Moon Explosion', NULL, NULL, NULL, 'c29934ccc7e2c1b0e86bc04e8c1b6855f0517416', NULL, NULL, NULL, NULL, 3, NULL, 392, NULL, 1),
(392, 'Hinds', NULL, NULL, NULL, '5d8e9005c14ed3f55a06b4bb30f0ce6bf326df5f', NULL, NULL, NULL, NULL, 3, NULL, 393, NULL, 1),
(393, 'Historia del Crimen', NULL, NULL, NULL, '795c876ebdb09eaf6706dde145d43677aaddd0e6', NULL, NULL, NULL, NULL, 3, NULL, 394, NULL, 1),
(394, 'The Hive Dwellers', NULL, NULL, NULL, '4720edb4d98bc6e4f88f5c44c72e67168f91f76f', NULL, NULL, NULL, NULL, 3, NULL, 395, NULL, 1),
(395, 'The Hives', NULL, NULL, NULL, '9d34a962e65fc5735801a81e240252fd3a5cbf3d', NULL, NULL, NULL, NULL, 3, NULL, 396, NULL, 1),
(396, 'Hockey Dad', NULL, NULL, NULL, 'b226891655cb66c7ef630c7512ee503c0cbf73c3', NULL, NULL, NULL, NULL, 3, NULL, 397, NULL, 1),
(397, 'Holy Piby', NULL, NULL, NULL, 'c1c5f5eec3e7fd081dbfbc16b2a696cbf4913d4b', NULL, NULL, NULL, NULL, 3, NULL, 398, NULL, 1),
(398, 'HOLY WAVE', NULL, NULL, NULL, '9fd0330c89dbc415b794bb64569fc9613f1545bc', NULL, NULL, NULL, NULL, 3, NULL, 399, NULL, 1),
(399, 'Horace Andy', NULL, NULL, NULL, 'a4592f991d26783f71f14be948845148338e6319', NULL, NULL, NULL, NULL, 3, NULL, 400, NULL, 1),
(400, 'The Horrors', NULL, NULL, NULL, '0c5bf8d421a1e827a7a62fa651ce67de536c0eb1', NULL, NULL, NULL, NULL, 3, NULL, 401, NULL, 1),
(401, 'The Hot Rats', NULL, NULL, NULL, 'e2bd0e9c1a2e3e6a141a6e9f561701dd31073f71', NULL, NULL, NULL, NULL, 3, NULL, 402, NULL, 1),
(402, 'The House Of Love', NULL, NULL, NULL, '3eb8f280a33ff0c6c86b50b479e97f605f5b8429', NULL, NULL, NULL, NULL, 3, NULL, 403, NULL, 1),
(403, 'Hugo Fattoruso', NULL, NULL, NULL, '7eee8e63b571e71fa0789b7c4a34c3ff6786f2f3', NULL, NULL, NULL, NULL, 3, NULL, 404, NULL, 1),
(404, 'Hüsker Dü', NULL, NULL, NULL, 'e88cb0b15fcd7dae98e4a08841bfe8ec3610c6f8', NULL, NULL, NULL, NULL, 3, NULL, 405, NULL, 1),
(405, 'I Kong', NULL, NULL, NULL, '25fd5752919f0e33a600cde6f89d95bc0ac772e6', NULL, NULL, NULL, NULL, 3, NULL, 406, NULL, 1),
(406, 'I Roy', NULL, NULL, NULL, '4275e31f910bfeb79906e7d26803d30bacccaf7b', NULL, NULL, NULL, NULL, 3, NULL, 407, NULL, 1),
(407, 'Ian McCulloch', NULL, NULL, NULL, 'a771cc66caf4c01f2220a37d1892300c7e3b1d7f', NULL, NULL, NULL, NULL, 3, NULL, 408, NULL, 1),
(408, 'Iggy and The Stooges', NULL, NULL, NULL, 'fd3d36f13bbbc8aa4420094a6b4a1e6f43bf6019', NULL, NULL, NULL, NULL, 3, NULL, 409, NULL, 1),
(409, 'Iggy Pop', NULL, NULL, NULL, '224a700eab1c57498091d6515b8bcf96cfcae259', NULL, NULL, NULL, NULL, 3, NULL, 410, NULL, 1),
(410, 'Iggy Pop & The Stooges', NULL, NULL, NULL, '1da5c7f6f65c9cc4f50c427f77ef4819dff40a63', NULL, NULL, NULL, NULL, 3, NULL, 411, NULL, 1),
(411, 'The Iguanas', NULL, NULL, NULL, '52050cc439d504aef5b1ec8658516efdb1c9415a', NULL, NULL, NULL, NULL, 3, NULL, 412, NULL, 1),
(412, 'Indigencia Vip', NULL, NULL, NULL, 'dc9da25a9d464480e4506d2be314e805510942a9', NULL, NULL, NULL, NULL, 3, NULL, 413, NULL, 1),
(413, 'Interpol', NULL, NULL, NULL, '7904948b092cf49a6a947087f591f70a64fcda3a', NULL, NULL, NULL, NULL, 3, NULL, 414, NULL, 1),
(414, 'Isla Mujeres', NULL, NULL, NULL, 'c0f4ebdceb5aaf012cb7b0b144fbb2acdf8ee486', NULL, NULL, NULL, NULL, 3, NULL, 415, NULL, 1),
(415, 'Islands', NULL, NULL, NULL, 'a9f1e1e68fe9ae41bb3440237fce0db55dbabbfe', NULL, NULL, NULL, NULL, 3, NULL, 416, NULL, 1),
(416, 'Israel Vibration', NULL, NULL, NULL, 'e161c782d72ce7f55c8ed009f4536826efaf6fca', NULL, NULL, NULL, NULL, 3, NULL, 417, NULL, 1),
(417, 'J Mascis', NULL, NULL, NULL, '177c03fb68357bfd9184666baca9ca18a5dc7408', NULL, NULL, NULL, NULL, 3, NULL, 418, NULL, 1),
(418, 'J Mascis + The Fog', NULL, NULL, NULL, 'a0dcde4b5b8ccfb1d52654a04a9e894ecaad4cdb', NULL, NULL, NULL, NULL, 3, NULL, 419, NULL, 1),
(419, 'Jack White', NULL, NULL, NULL, 'd81ca3255c846db9d9eca76b50e33993b75c6460', NULL, NULL, NULL, NULL, 3, NULL, 420, NULL, 1),
(420, 'Jaime Sin Tierra', NULL, NULL, NULL, '3684d54ef7c5176f8678a48c06e5548b2e50c6ef', NULL, NULL, NULL, NULL, 3, NULL, 421, NULL, 1),
(421, 'The Jam', NULL, NULL, NULL, '7a01c101763e7f7bb122c5f161665e099094f0dc', NULL, NULL, NULL, NULL, 3, NULL, 422, NULL, 1),
(422, 'James Brown', NULL, NULL, NULL, '834bb44fb681ceec6c091cde7d70f01ea2143ebd', NULL, NULL, NULL, NULL, 3, NULL, 423, NULL, 1),
(423, 'James Skelly & The Intenders', NULL, NULL, NULL, 'bfad925766ada910763f42ee3ff42ca927b76593', NULL, NULL, NULL, NULL, 3, NULL, 424, NULL, 1),
(424, 'Janis Joplin', NULL, NULL, NULL, 'af632cc84571653203957e6f169899de036d25b4', NULL, NULL, NULL, NULL, 3, NULL, 425, NULL, 1),
(425, 'Japanther', NULL, NULL, NULL, 'c0a9399b8fda96f8b73e967c3a48945f4ca93730', NULL, NULL, NULL, NULL, 3, NULL, 426, NULL, 1),
(426, 'Javier Martínez y La Clavo\'s Band', NULL, NULL, NULL, '4090c514506fa08a821b5475a17f8d5795c74d2a', NULL, NULL, NULL, NULL, 3, NULL, 427, NULL, 1),
(427, 'JC Satan', NULL, NULL, NULL, '9b36c26f164d9f23238d4ab52453da051f60bec3', NULL, NULL, NULL, NULL, 3, NULL, 428, NULL, 1),
(428, 'JEFF the Brotherhood', NULL, NULL, NULL, '98dd6e4902351d6f86ffe35385b06d60c42d8d91', NULL, NULL, NULL, NULL, 3, NULL, 429, NULL, 1),
(429, 'Jefferson Airplane', NULL, NULL, NULL, 'be684dd20cb57041adbdb3fbce72dc3643cd8c5e', NULL, NULL, NULL, NULL, 3, NULL, 430, NULL, 1),
(430, 'The Jesus And Mary Chain', NULL, NULL, NULL, 'e408661f8e719f1a520bdde0027cba662666d46a', NULL, NULL, NULL, NULL, 3, NULL, 431, NULL, 1),
(431, 'Jethro Tull', NULL, NULL, NULL, '01021a0aebac136a9e695bed97c5f2fa06f9219a', NULL, NULL, NULL, NULL, 3, NULL, 432, NULL, 1),
(432, 'Jimi Hendrix', NULL, NULL, NULL, 'ee04d1ae7ec6a356bf007c1e241115a78424b1d0', NULL, NULL, NULL, NULL, 3, NULL, 433, NULL, 1),
(433, 'The Jimi Hendrix Experience', NULL, NULL, NULL, 'e92b3d5782451325571858cad6739d7c8591c53c', NULL, NULL, NULL, NULL, 3, NULL, 434, NULL, 1),
(434, 'Jimmy Cliff', NULL, NULL, NULL, '450befe95fbabcf6da1fdb2da183b1554e534f7c', NULL, NULL, NULL, NULL, 3, NULL, 435, NULL, 1),
(435, 'Jimmy Smith', NULL, NULL, NULL, 'e50cd07ba9853ef7335e3075a10a5d504caf902f', NULL, NULL, NULL, NULL, 3, NULL, 436, NULL, 1),
(436, 'The Jins', NULL, NULL, NULL, '0f05db415cfebf5ed16fa032b0f360760714e7ef', NULL, NULL, NULL, NULL, 3, NULL, 437, NULL, 1),
(437, 'Joe Crepusculo', NULL, NULL, NULL, 'cd69bcfee0fcaaab91679916fe78629d9a96aa28', NULL, NULL, NULL, NULL, 3, NULL, 438, NULL, 1),
(438, 'Joe Strummer', NULL, NULL, NULL, '823888a67140891a2aef5af2571495df43665897', NULL, NULL, NULL, NULL, 3, NULL, 439, NULL, 1),
(439, 'Joe Strummer & the Mescaleros', NULL, NULL, NULL, 'a85e09766f7114561cc0b8cd7e03aa82eeddc5d3', NULL, NULL, NULL, NULL, 3, NULL, 440, NULL, 1),
(440, 'Joe Strummer and The Mescaleros', NULL, NULL, NULL, 'f4f554fd07b3a851a92adf285b1c21f9f2029dc4', NULL, NULL, NULL, NULL, 3, NULL, 441, NULL, 1),
(441, 'John Coltrane', NULL, NULL, NULL, '4924ca98286ae0620f8bb14e8eb3e7de6f06a824', NULL, NULL, NULL, NULL, 3, NULL, 442, NULL, 1),
(442, 'John Lennon', NULL, NULL, NULL, '93d5be7aebd7a99ff6bc21e837f5452814598fed', NULL, NULL, NULL, NULL, 3, NULL, 443, NULL, 1),
(443, 'Johnny Cash', NULL, NULL, NULL, '56cc05f75cb48658ae892d097bb34a7221232804', NULL, NULL, NULL, NULL, 3, NULL, 444, NULL, 1),
(444, 'Johnny Marr', NULL, NULL, NULL, '7441c09aa4814d178fe02bb40ca5677aaf363dc8', NULL, NULL, NULL, NULL, 3, NULL, 445, NULL, 1),
(445, 'Johnny Thunders', NULL, NULL, NULL, '0f042f0932df9368d204190bece8cc20d018ed9b', NULL, NULL, NULL, NULL, 3, NULL, 446, NULL, 1),
(446, 'Johnny Thunders & The Heartbreakers', NULL, NULL, NULL, '378ab0da8a1d10bf8a7449a5c0636e84567bbb33', NULL, NULL, NULL, NULL, 3, NULL, 447, NULL, 1),
(447, 'Jon Spencer Blues Explosion', NULL, NULL, NULL, 'b0f117ac46e36cd7d70bf69d58777b1ded1370af', NULL, NULL, NULL, NULL, 3, NULL, 448, NULL, 1),
(448, 'Jose Gonzalez', NULL, NULL, NULL, '94b3dfa0b6979dc0f48c51be316c65ec2e02c448', NULL, NULL, NULL, NULL, 3, NULL, 449, NULL, 1),
(449, 'Joy Division', NULL, NULL, NULL, 'b4fc8e7286b678d1c32d8ed0286235639dbd50b5', NULL, NULL, NULL, NULL, 3, NULL, 450, NULL, 1),
(450, 'joyride!', NULL, NULL, NULL, '659f07a56005728f61bdc89dbb8a1f465e853310', NULL, NULL, NULL, NULL, 3, NULL, 451, NULL, 1),
(451, 'Joystick', NULL, NULL, NULL, '79102aca5204821639bb71986f99e53e5a6a24ba', NULL, NULL, NULL, NULL, 3, NULL, 452, NULL, 1),
(452, 'Juan Irio', NULL, NULL, NULL, '249ec7bd86bae68e876a1ddb6b8da000800e2eb8', NULL, NULL, NULL, NULL, 3, NULL, 453, NULL, 1),
(453, 'Juana Molina', NULL, NULL, NULL, '3d6672280d43fd675dab39a3b68f382d5e9dc5c7', NULL, NULL, NULL, NULL, 3, NULL, 454, NULL, 1),
(454, 'Juanita y Los Feos', NULL, NULL, NULL, 'ee93553bf1f0ca52ee5f1a50d3cba940becbdf5c', NULL, NULL, NULL, NULL, 3, NULL, 455, NULL, 1),
(455, 'Julio y Agosto', NULL, NULL, NULL, 'd8d2ff334b99921effdb36ab557818d9d06e852f', NULL, NULL, NULL, NULL, 3, NULL, 456, NULL, 1),
(456, 'Junior Delgado', NULL, NULL, NULL, '13ca432227ba269e5ce2ca67e2f7a0e1b8c7a074', NULL, NULL, NULL, NULL, 3, NULL, 457, NULL, 1),
(457, 'Jurassic Shark', NULL, NULL, NULL, 'ab0669672850c3e54b5ca302d05ed034eb359784', NULL, NULL, NULL, NULL, 3, NULL, 458, NULL, 1),
(458, 'The Karovas Milkshake', NULL, NULL, NULL, 'bd09d8cb8dc4d994ca6fba0fd46ed79bef15d178', NULL, NULL, NULL, NULL, 3, NULL, 459, NULL, 1),
(459, 'Ken Boothe', NULL, NULL, NULL, '2980c613d4ddd812c5f4f377162e2f21137837c9', NULL, NULL, NULL, NULL, 3, NULL, 460, NULL, 1),
(460, 'Ken Lazarus', NULL, NULL, NULL, '386753cd6c995726af945e82c4a3875acd0bf4fe', NULL, NULL, NULL, NULL, 3, NULL, 461, NULL, 1),
(461, 'Kenny Dorham', NULL, NULL, NULL, '1c177f008521a2ad7da05236b50b6e4e8c1c89e2', NULL, NULL, NULL, NULL, 3, NULL, 462, NULL, 1),
(462, 'Kid Mountain', NULL, NULL, NULL, '77d415231f54e7ae677aa6d957ae6bda1933c841', NULL, NULL, NULL, NULL, 3, NULL, 463, NULL, 1),
(463, 'Kill West', NULL, NULL, NULL, 'be415d65683d629aff14b73b0a42c96827822c48', NULL, NULL, NULL, NULL, 3, NULL, 464, NULL, 1),
(464, 'The Kills', NULL, NULL, NULL, '6817ee7f7ca4bc0887431502e8deeb827b5d02a4', NULL, NULL, NULL, NULL, 3, NULL, 465, NULL, 1),
(465, 'kinder', NULL, NULL, NULL, 'b998e74a04ca503d4f002ba91c15b1520bc73697', NULL, NULL, NULL, NULL, 3, NULL, 466, NULL, 1),
(466, 'King Automatic', NULL, NULL, NULL, 'e215af84955d10bf1c52b47c983e0d77fb320c17', NULL, NULL, NULL, NULL, 3, NULL, 467, NULL, 1),
(467, 'King Gizzard & The Lizard Wizard', NULL, NULL, NULL, 'b3c85af0446094bc5b477889a4e74632f3042f6a', NULL, NULL, NULL, NULL, 3, NULL, 468, NULL, 1),
(468, 'The King Khan & BBQ Show', NULL, NULL, NULL, '22e094caa1b98e09019a117babaedbba35090d4d', NULL, NULL, NULL, NULL, 3, NULL, 469, NULL, 1),
(469, 'King Khan & His Shrines', NULL, NULL, NULL, '920ce6a33af8aefcfc761533f1bb5e5425eaffa3', NULL, NULL, NULL, NULL, 3, NULL, 470, NULL, 1),
(470, 'King Sporty', NULL, NULL, NULL, '658f29d42ed02dc19496b938b6fdbc65b4a9bab8', NULL, NULL, NULL, NULL, 3, NULL, 471, NULL, 1),
(471, 'King Tubby', NULL, NULL, NULL, 'e2daad2d87380750fc9924ec7144fdb0c65679b7', NULL, NULL, NULL, NULL, 3, NULL, 472, NULL, 1),
(472, 'King Tubby & Soul Syndicate', NULL, NULL, NULL, '35c03d3ac61dc84f3dbd1714b99a8edbe570f097', NULL, NULL, NULL, NULL, 3, NULL, 473, NULL, 1),
(473, 'King Tubby and Friends Dub Explosion', NULL, NULL, NULL, 'c7612b351f9d29eb68b2e83841f34d5742ab1a15', NULL, NULL, NULL, NULL, 3, NULL, 474, NULL, 1),
(474, 'King Tuff', NULL, NULL, NULL, '07edef5335bea477badc33ab4001278f158c54fe', NULL, NULL, NULL, NULL, 3, NULL, 475, NULL, 1),
(475, 'The Kinks', NULL, NULL, NULL, '67123e84601b10266f99217dccddd431dbc1afb0', NULL, NULL, NULL, NULL, 3, NULL, 476, NULL, 1),
(476, 'Klaus & Kinski', NULL, NULL, NULL, 'ff9481553570fe74899b7146a2854b13df905f08', NULL, NULL, NULL, NULL, 3, NULL, 477, NULL, 1),
(477, 'Kokoshca', NULL, NULL, NULL, 'f7c7a95e4011b28a9731d99b9efc37f46c77e754', NULL, NULL, NULL, NULL, 3, NULL, 478, NULL, 1),
(478, 'Krupoviesa', NULL, NULL, NULL, '884cc908b3c0418aac0eee824ce4def599c49dab', NULL, NULL, NULL, NULL, 3, NULL, 479, NULL, 1),
(479, 'Kula Shaker', NULL, NULL, NULL, '05370777498aa8fa474deaf80c4d9471af6a967f', NULL, NULL, NULL, NULL, 3, NULL, 480, NULL, 1),
(480, 'Kurt Vile', NULL, NULL, NULL, 'fd3921b37a71a80238db1ea69e91c214dbed58ae', NULL, NULL, NULL, NULL, 3, NULL, 481, NULL, 1),
(481, 'The La\'s', NULL, NULL, NULL, 'cab0ff8a43216753880a63b08eca5e480a376f53', NULL, NULL, NULL, NULL, 3, NULL, 482, NULL, 1),
(482, 'Laika Perra Rusa', NULL, NULL, NULL, 'a454c5e9d59405573c3224ec9c1fcb33c6a7042f', NULL, NULL, NULL, NULL, 3, NULL, 483, NULL, 1),
(483, 'Larry Volta', NULL, NULL, NULL, '36299c89998ec3a055ba188e14a1ecf87cb2dcd8', NULL, NULL, NULL, NULL, 3, NULL, 484, NULL, 1),
(484, 'Las armas', NULL, NULL, NULL, 'db4be4bc1a21b1da3dcc98e60b6218e9229434c3', NULL, NULL, NULL, NULL, 3, NULL, 485, NULL, 1),
(485, 'Las Aspiradoras', NULL, NULL, NULL, '3337eb1e2579e33fdd418ee3ca60dce65a8f5eb3', NULL, NULL, NULL, NULL, 3, NULL, 486, NULL, 1),
(486, 'Las Edades', NULL, NULL, NULL, '216097784bd64f779ccbb368d670ed7e53eb9c9b', NULL, NULL, NULL, NULL, 3, NULL, 487, NULL, 1),
(487, 'Las Kasettes', NULL, NULL, NULL, 'b5bd95fb5604c05b5d34f5e4b78af1db7386705f', NULL, NULL, NULL, NULL, 3, NULL, 488, NULL, 1),
(488, 'Las Kellies', NULL, NULL, NULL, 'dd0f9169e324f242a911af1abb6fd2eab5e6bebf', NULL, NULL, NULL, NULL, 3, NULL, 489, NULL, 1),
(489, 'Las Ligas Menores', NULL, NULL, NULL, 'a59d10fa4c55ab22ec203d8c11b4a7f01ac85d70', NULL, NULL, NULL, NULL, 3, NULL, 490, NULL, 1),
(490, 'Las Olas', NULL, NULL, NULL, '8d0b2b2c8c028b72586bd43584fc53fa1e374e31', NULL, NULL, NULL, NULL, 3, NULL, 491, NULL, 1),
(491, 'Las Pelotas', NULL, NULL, NULL, 'c52d28cb02b8ab424e6384f68e5d6fc976ec77f1', NULL, NULL, NULL, NULL, 3, NULL, 492, NULL, 1),
(492, 'Las Piñas', NULL, NULL, NULL, '4713dcfa49c242cef84c0803af05584fff0c14f8', NULL, NULL, NULL, NULL, 3, NULL, 493, NULL, 1),
(493, 'Las Robertas', NULL, NULL, NULL, 'c3186ca814c333179d227ddc341bb590b5ca151c', NULL, NULL, NULL, NULL, 3, NULL, 494, NULL, 1),
(494, 'Las ruinas', NULL, NULL, NULL, 'd38ef494844f2c9fc8b415ba1957e4f0152ce9c3', NULL, NULL, NULL, NULL, 3, NULL, 495, NULL, 1),
(495, 'Laurel Aitken', NULL, NULL, NULL, 'c0e827d97062c7b9d72e8b5be4e9fa306f9400ee', NULL, NULL, NULL, NULL, 3, NULL, 496, NULL, 1),
(496, 'Lê Almeida', NULL, NULL, NULL, '53a8f3949170d31bf586ee507b5cde315a00a1b9', NULL, NULL, NULL, NULL, 3, NULL, 497, NULL, 1),
(497, 'Lee Morgan', NULL, NULL, NULL, '62c944bb3a1fed3f16f0d69fda67b5f43dfe2b0c', NULL, NULL, NULL, NULL, 3, NULL, 498, NULL, 1),
(498, 'Lee Perry', NULL, NULL, NULL, 'd798425b213dccc550f992533630986243ee67e4', NULL, NULL, NULL, NULL, 3, NULL, 499, NULL, 1),
(499, 'Lee Ranaldo', NULL, NULL, NULL, 'bad596805b4336dd7e7575bb5cae8d2ebc1a0d23', NULL, NULL, NULL, NULL, 3, NULL, 500, NULL, 1),
(500, 'Lee “Scratch” Perry', NULL, NULL, NULL, 'b1cfac3b6f64c9ca3a9149412956773eb0bb1142', NULL, NULL, NULL, NULL, 3, NULL, 501, NULL, 1),
(501, 'Legendary Skatalites In Dub', NULL, NULL, NULL, '91f83672a0c36c31a7789c315a197755f55eaaa5', NULL, NULL, NULL, NULL, 3, NULL, 502, NULL, 1),
(502, 'Leonard Cohen', NULL, NULL, NULL, '32d49537a4542b0195e43c482f2d5ecb1a379acc', NULL, NULL, NULL, NULL, 3, NULL, 503, NULL, 1),
(503, 'The Libertines', NULL, NULL, NULL, '7bb46898d6861b015695472a646f859bb75eb871', NULL, NULL, NULL, NULL, 3, NULL, 504, NULL, 1),
(504, 'Lidia Damunt', NULL, NULL, NULL, '6de029828c04073bdd1534fa367091c26d5f6cf6', NULL, NULL, NULL, NULL, 3, NULL, 505, NULL, 1),
(505, 'Link Wray', NULL, NULL, NULL, 'aa0e47a73f9d5401f946aa0cdb81d43d652ce9f9', NULL, NULL, NULL, NULL, 3, NULL, 506, NULL, 1),
(506, 'Linton Kwesi Johnson', NULL, NULL, NULL, '9932293bdafe09e4cb1a7e6aab2e3b4cf28c217e', NULL, NULL, NULL, NULL, 3, NULL, 507, NULL, 1),
(507, 'Linval Thompson', NULL, NULL, NULL, 'e59bfad52b6b7155500bf5b09b7ee2186cbc845a', NULL, NULL, NULL, NULL, 3, NULL, 508, NULL, 1),
(508, 'Literature', NULL, NULL, NULL, '3da77d1cf1139583d13c4b317fc8945aab4625b1', NULL, NULL, NULL, NULL, 3, NULL, 509, NULL, 1),
(509, 'Liz Phair', NULL, NULL, NULL, '5150a87c03810cada9ca18fee23a649ea1a72357', NULL, NULL, NULL, NULL, 3, NULL, 510, NULL, 1),
(510, 'Lloyd Parks', NULL, NULL, NULL, '80ca7652e7e7de43191b00ba477e0be21bd9e5a1', NULL, NULL, NULL, NULL, 3, NULL, 511, NULL, 1),
(511, 'Lo Inadvertido', NULL, NULL, NULL, '7a2920f181a0ea9c3abbe949c051423bb38b6497', NULL, NULL, NULL, NULL, 3, NULL, 512, NULL, 1),
(512, 'Loquero', NULL, NULL, NULL, 'bc490f21debb0abd5f1279ced07d05407161c0a4', NULL, NULL, NULL, NULL, 3, NULL, 513, NULL, 1),
(513, 'Los accidentes', NULL, NULL, NULL, '631a6a8c089b57efa30c102f27c8b661c9316266', NULL, NULL, NULL, NULL, 3, NULL, 514, NULL, 1),
(514, 'Los Acidos', NULL, NULL, NULL, 'c7310088c49aeefe52d136acfcff83ec841800b2', NULL, NULL, NULL, NULL, 3, NULL, 515, NULL, 1),
(515, 'Los Bengala', NULL, NULL, NULL, 'ec314288809bb225f2b9167c7f189f02143bbb93', NULL, NULL, NULL, NULL, 3, NULL, 516, NULL, 1),
(516, 'Los Bicivoladores', NULL, NULL, NULL, '06086173d4e538a0cfc62c2e0623a64590b3d0d5', NULL, NULL, NULL, NULL, 3, NULL, 517, NULL, 1),
(517, 'Los Campesinos', NULL, NULL, NULL, 'cba18c738f87fb1724751f65c4d2642759c5ecf9', NULL, NULL, NULL, NULL, 3, NULL, 518, NULL, 1),
(518, 'Los Campesinos!', NULL, NULL, NULL, '8e15585a7f435a5890c8a8487b8f668131df5f5d', NULL, NULL, NULL, NULL, 3, NULL, 519, NULL, 1),
(519, 'Los Chicos del Pantano', NULL, NULL, NULL, 'b27fae9abb4d6ee5e76f0dd2d96ae7464820aa1c', NULL, NULL, NULL, NULL, 3, NULL, 520, NULL, 1),
(520, 'Los Claveles', NULL, NULL, NULL, '9a42703b1d5462b8eb7d6cdb33e27fbc7df95704', NULL, NULL, NULL, NULL, 3, NULL, 521, NULL, 1),
(521, 'Los Colmillos', NULL, NULL, NULL, 'ba7da5f0a92f899c3d66944e89e74677ebf7bc35', NULL, NULL, NULL, NULL, 3, NULL, 522, NULL, 1),
(522, 'Los Conjunto', NULL, NULL, NULL, '110db7880b73872c9fd857f36fde2b33ec7958e1', NULL, NULL, NULL, NULL, 3, NULL, 523, NULL, 1),
(523, 'Los Coronas', NULL, NULL, NULL, 'c3291a4eedb1be2748cb8f19477e1081f58fbc2f', NULL, NULL, NULL, NULL, 3, NULL, 524, NULL, 1),
(524, 'Los Cronopios', NULL, NULL, NULL, '327b4dd5e89e55db0140672d6efac67071b9a2c5', NULL, NULL, NULL, NULL, 3, NULL, 525, NULL, 1),
(525, 'Los Culos', NULL, NULL, NULL, '1c3dcf2a6f8210718b2c08c311a7601ac2d764b4', NULL, NULL, NULL, NULL, 3, NULL, 526, NULL, 1),
(526, 'Los de Afuera', NULL, NULL, NULL, '2397396c8f7175f8bc0e6ddfabbb2dd6b906fc06', NULL, NULL, NULL, NULL, 3, NULL, 527, NULL, 1),
(527, 'Los edificios', NULL, NULL, NULL, 'd5fcc742a0df261f40a839857a296be5925b0b29', NULL, NULL, NULL, NULL, 3, NULL, 528, NULL, 1),
(528, 'Los Empleados', NULL, NULL, NULL, '2cb1b04ac3b6ccc205809bed18f28fc9a190eaee', NULL, NULL, NULL, NULL, 3, NULL, 529, NULL, 1),
(529, 'Los Espiritus', NULL, NULL, NULL, '95a0a653cf9159823ca32c6c49ae23e4580447f2', NULL, NULL, NULL, NULL, 3, NULL, 530, NULL, 1),
(530, 'Los Freneticos', NULL, NULL, NULL, 'eb5145a648c2e8a3552d5090f93d84132ece4707', NULL, NULL, NULL, NULL, 3, NULL, 531, NULL, 1),
(531, 'Los Granadians de Espacio Exterior', NULL, NULL, NULL, 'ccef68b283c80c2899c3f8727d2a0071fd735b92', NULL, NULL, NULL, NULL, 3, NULL, 532, NULL, 1),
(532, 'Los Incendios', NULL, NULL, NULL, 'a949234cd3c62f4d0b0d330637eeb68c198a9635', NULL, NULL, NULL, NULL, 3, NULL, 533, NULL, 1),
(533, 'Los Japón', NULL, NULL, NULL, 'd3b2bd82bacdefbd99da9e2d578c7cd39c2a59f5', NULL, NULL, NULL, NULL, 3, NULL, 534, NULL, 1),
(534, 'Los Limbos', NULL, NULL, NULL, '2af6e878a75687e69a35a38d097ee2e477c9b58c', NULL, NULL, NULL, NULL, 3, NULL, 535, NULL, 1),
(535, 'Los Nastys', NULL, NULL, NULL, '06175f0444986dd695139749cced4ed98da03d78', NULL, NULL, NULL, NULL, 3, NULL, 536, NULL, 1),
(536, 'Los Natas', NULL, NULL, NULL, '27db0ad2044651a99e3f2c00c0039692533fddf9', NULL, NULL, NULL, NULL, 3, NULL, 537, NULL, 1),
(537, 'Los Nervios', NULL, NULL, NULL, '36e3cc164152e3dae834157d2631a01eb0a6a176', NULL, NULL, NULL, NULL, 3, NULL, 538, NULL, 1),
(538, 'Los Nuevos Monstruos', NULL, NULL, NULL, '56174110b37be01959f2f06cdaf509353336fcc6', NULL, NULL, NULL, NULL, 3, NULL, 539, NULL, 1),
(539, 'Los Nuevos Mosntruos', NULL, NULL, NULL, 'a37267b23b3ef66aec4cc5d87edc285c9893a5af', NULL, NULL, NULL, NULL, 3, NULL, 540, NULL, 1),
(540, 'Los Outsaiders', NULL, NULL, NULL, '089994e78aa954572262f31001c07b09dae2e860', NULL, NULL, NULL, NULL, 3, NULL, 541, NULL, 1),
(541, 'Los Peligros', NULL, NULL, NULL, '490b2af2fd6ee66191bada234837dfee7a3db8d8', NULL, NULL, NULL, NULL, 3, NULL, 542, NULL, 1),
(542, 'Los Perceptibles', NULL, NULL, NULL, 'a1a119bdd6ae710d0bb16ea228513a32fe7e54e7', NULL, NULL, NULL, NULL, 3, NULL, 543, NULL, 1),
(543, 'Los Peyotes', NULL, NULL, NULL, '80f5fffb7a9435fe9d0d767c60647ff2566ee75b', NULL, NULL, NULL, NULL, 3, NULL, 544, NULL, 1),
(544, 'Los Pillos', NULL, NULL, NULL, 'f17bd8649e9fa919235238637a054051ba552e3b', NULL, NULL, NULL, NULL, 3, NULL, 545, NULL, 1),
(545, 'Los planeta rojo', NULL, NULL, NULL, '5fb8a97d615c804aeec0413671d7977874b5d852', NULL, NULL, NULL, NULL, 3, NULL, 546, NULL, 1),
(546, 'Los Planetas', NULL, NULL, NULL, '6496c0e1171277cb4fbe57613ef17bf24249fbd4', NULL, NULL, NULL, NULL, 3, NULL, 547, NULL, 1),
(547, 'Los Pringonautas', NULL, NULL, NULL, '411a115574925575acf2e0c18d84eb44ea4b9cc8', NULL, NULL, NULL, NULL, 3, NULL, 548, NULL, 1),
(548, 'Los Punsetes', NULL, NULL, NULL, 'babf1c84d811270a0375c4595ad955cbe37c3f76', NULL, NULL, NULL, NULL, 3, NULL, 549, NULL, 1),
(549, 'Los Sedantes', NULL, NULL, NULL, 'e7a7d4263c9442770102388a88f047476bb997ba', NULL, NULL, NULL, NULL, 3, NULL, 550, NULL, 1),
(550, 'Los Seitans', NULL, NULL, NULL, '25e8640ecfd107ca43664360665d0625f3010b94', NULL, NULL, NULL, NULL, 3, NULL, 551, NULL, 1),
(551, 'Los Songlines', NULL, NULL, NULL, '53cbdbe39c7e211f7e6281e38c4ca7a325e0d902', NULL, NULL, NULL, NULL, 3, NULL, 552, NULL, 1),
(552, 'Los Subterraneos', NULL, NULL, NULL, '566dcbc0e87432f278e92c83e4e5cb928b0af073', NULL, NULL, NULL, NULL, 3, NULL, 553, NULL, 1),
(553, 'Los Super Dementes', NULL, NULL, NULL, 'cfaf71f5c011616fc70474bd22ab1a5ba22228b2', NULL, NULL, NULL, NULL, 3, NULL, 554, NULL, 1),
(554, 'Los Tiki Phantoms', NULL, NULL, NULL, 'c092b7b6305fc0a65edb709e73f0f6bb389b6421', NULL, NULL, NULL, NULL, 3, NULL, 555, NULL, 1),
(555, 'Los Tones', NULL, NULL, NULL, 'b7721e7690e1817fa304efbe8d759f9172e08b5d', NULL, NULL, NULL, NULL, 3, NULL, 556, NULL, 1),
(556, 'Los Violadores', NULL, NULL, NULL, '687dffc8e748bdb57290d16a121266e7464a098b', NULL, NULL, NULL, NULL, 3, NULL, 557, NULL, 1),
(557, 'Los Visitantes', NULL, NULL, NULL, '5665a0f2eeb39c5ab0e56d5b1ff0971d256dc508', NULL, NULL, NULL, NULL, 3, NULL, 558, NULL, 1),
(558, 'Los Zapping', NULL, NULL, NULL, 'eaf66ed04cd042b2c7f6e9265341dec7e6db4cbd', NULL, NULL, NULL, NULL, 3, NULL, 559, NULL, 1),
(559, 'Loss edificios', NULL, NULL, NULL, '05a5397e67a7ce347265ecd1308337c396bed742', NULL, NULL, NULL, NULL, 3, NULL, 560, NULL, 1),
(560, 'Lou Reed', NULL, NULL, NULL, '352272aff09c3686124d7533015dd7371178f137', NULL, NULL, NULL, NULL, 3, NULL, 561, NULL, 1),
(561, 'Luca Prodan', NULL, NULL, NULL, '88bb9e5bd500673d7f15c4cd78cd1d13a53ae9e5', NULL, NULL, NULL, NULL, 3, NULL, 562, NULL, 1),
(562, 'Luca Prodana', NULL, NULL, NULL, '0f9877921f81f8ed7fba38b4b945d4d159eac168', NULL, NULL, NULL, NULL, 3, NULL, 563, NULL, 1),
(563, 'Luis & The Wildfires', NULL, NULL, NULL, '904d55e7f835494835e97cd592295c8bce4b1252', NULL, NULL, NULL, NULL, 3, NULL, 564, NULL, 1),
(564, 'Lulacruza', NULL, NULL, NULL, '64158f3e1036e5b6c2bc874ced1184bf78f8404f', NULL, NULL, NULL, NULL, 3, NULL, 565, NULL, 1),
(565, 'Luma', NULL, NULL, NULL, 'b6a68bcb2ee5dee155b8c2b0faea7feb0ea0df3d', NULL, NULL, NULL, NULL, 3, NULL, 566, NULL, 1),
(566, 'Luna', NULL, NULL, NULL, '5325af73343e966188f78ab2627471e1e42be7bc', NULL, NULL, NULL, NULL, 3, NULL, 567, NULL, 1),
(567, 'Lush', NULL, NULL, NULL, '4a75f98287f73f1f5ee0a85b7161d46166e059ce', NULL, NULL, NULL, NULL, 3, NULL, 568, NULL, 1),
(568, 'La Luz', NULL, NULL, NULL, '4acd036e76f0b3045b7b6ca8a0e2dead4d85782b', NULL, NULL, NULL, NULL, 3, NULL, 569, NULL, 1),
(569, 'LVL UP', NULL, NULL, NULL, 'cebf491d6bab916b6831b64b150ce45ed8157e79', NULL, NULL, NULL, NULL, 3, NULL, 570, NULL, 1),
(570, 'Lynn Taitt & The Jets', NULL, NULL, NULL, 'f893637632b5dc08d1a1e5bac3a8fd75a9190bff', NULL, NULL, NULL, NULL, 3, NULL, 571, NULL, 1),
(571, 'Mac DeMarco', NULL, NULL, NULL, '0de681266f43f87b36ea5a2d53eb6cdf22f38679', NULL, NULL, NULL, NULL, 3, NULL, 572, NULL, 1),
(572, 'The Madcaps', NULL, NULL, NULL, 'fdfc619c54ffb2e5ab714f5a32433383f8bce757', NULL, NULL, NULL, NULL, 3, NULL, 573, NULL, 1),
(573, 'Madness', NULL, NULL, NULL, '2e9a6f52856a8523b51a91664d136942f9f36566', NULL, NULL, NULL, NULL, 3, NULL, 574, NULL, 1),
(574, 'Magdalena Records', NULL, NULL, NULL, 'a7c376685cde4a63b8212a3036b1254e4c32a805', NULL, NULL, NULL, NULL, 3, NULL, 575, NULL, 1),
(575, 'Mal Momento', NULL, NULL, NULL, '402e9235717b21fa64ee30a77c38636f8baebf1d', NULL, NULL, NULL, NULL, 3, NULL, 576, NULL, 1),
(576, 'Man Man', NULL, NULL, NULL, 'e0e2f96ad502c1f14069646bca45f3717185a5ad', NULL, NULL, NULL, NULL, 3, NULL, 577, NULL, 1),
(577, 'Man or Astro-Man?', NULL, NULL, NULL, '0f3baaaf8cf1972e00ac70e76deba8c4cfec3aba', NULL, NULL, NULL, NULL, 3, NULL, 578, NULL, 1),
(578, 'Man or Astroman', NULL, NULL, NULL, '1a4d53ef836da06064c0c56b35e7be5f3abccd30', NULL, NULL, NULL, NULL, 3, NULL, 579, NULL, 1),
(579, 'Man or Atroman', NULL, NULL, NULL, 'f595683756c0c2093ac8cb95ee6748fceaf95a57', NULL, NULL, NULL, NULL, 3, NULL, 580, NULL, 1),
(580, 'Man...or Astro-Man?', NULL, NULL, NULL, '3423eaacb10f2464d57d80b18ee9da7d077e443c', NULL, NULL, NULL, NULL, 3, NULL, 581, NULL, 1),
(581, 'Manal', NULL, NULL, NULL, '653e64d222a565b180208b32e1088b5d4aff9f8c', NULL, NULL, NULL, NULL, 3, NULL, 582, NULL, 1),
(582, 'Manal Javier Martínez', NULL, NULL, NULL, 'b4d450aefbca80a36ef04131a9404e3ec1e81478', NULL, NULL, NULL, NULL, 3, NULL, 583, NULL, 1),
(583, 'Manganzoides', NULL, NULL, NULL, '028b4a7b53d1d28cdcb5c6b9c18e5c7ccdfa7167', NULL, NULL, NULL, NULL, 3, NULL, 584, NULL, 1),
(584, 'Manic Street Preachers', NULL, NULL, NULL, '5b196034ed0f3feb09ddb57804f631b867e17ea1', NULL, NULL, NULL, NULL, 3, NULL, 585, NULL, 1),
(585, 'Mano Negra', NULL, NULL, NULL, 'd9cb68f3e640988519df3d58920ed96c6bd5716c', NULL, NULL, NULL, NULL, 3, NULL, 586, NULL, 1),
(586, 'Le Mans', NULL, NULL, NULL, '8ff405cb13c8e654b7612ab203318cf943605f5a', NULL, NULL, NULL, NULL, 3, NULL, 587, NULL, 1),
(587, 'Mapa de Bits', NULL, NULL, NULL, '5e2dfe2b0bded7fa1533ec7d0ca17e2db266e0fa', NULL, NULL, NULL, NULL, 3, NULL, 588, NULL, 1),
(588, 'La Maquina de Hacer Pajaros', NULL, NULL, NULL, '0a65f81adc43f2f558e1c3ccd0a19db42946682a', NULL, NULL, NULL, NULL, 3, NULL, 589, NULL, 1),
(589, 'Marc Ribot y Los cubanos postizos', NULL, NULL, NULL, 'acfb077c2a427bc2e68bd3304706a238397f05b3', NULL, NULL, NULL, NULL, 3, NULL, 590, NULL, 1),
(590, 'Marc Ribot\'s Ceramic Dog', NULL, NULL, NULL, '229b808cdab152bf682673ff737f0015443a45ce', NULL, NULL, NULL, NULL, 3, NULL, 591, NULL, 1),
(591, 'Marcelo Ezquiaga', NULL, NULL, NULL, '11614cb8390128461bd36bd3843dae7efb4ec505', NULL, NULL, NULL, NULL, 3, NULL, 592, NULL, 1),
(592, 'Marcia Griffiths', NULL, NULL, NULL, 'ba7bffc463dee7a3093944bed8ae88c009338c15', NULL, NULL, NULL, NULL, 3, NULL, 593, NULL, 1),
(593, 'Mareaentrance', NULL, NULL, NULL, '8b723d9300ba72fea7bb1e1b33df2beb29655dd6', NULL, NULL, NULL, NULL, 3, NULL, 594, NULL, 1),
(594, 'María Rosa Mística', NULL, NULL, NULL, 'c2ce5fd37386839351719fffe33f9cafbac45082', NULL, NULL, NULL, NULL, 3, NULL, 595, NULL, 1),
(595, 'Marina Fages', NULL, NULL, NULL, 'b383606424b5c13c47de2b232eecfbb72bd51471', NULL, NULL, NULL, NULL, 3, NULL, 596, NULL, 1),
(596, 'Massacre', NULL, NULL, NULL, 'afc160e3c3d10b332f76db4595b05549612972a2', NULL, NULL, NULL, NULL, 3, NULL, 597, NULL, 1),
(597, 'Massive Attack', NULL, NULL, NULL, 'bde42c4b869e4d9ddfb22d560b259de9e1484e91', NULL, NULL, NULL, NULL, 3, NULL, 598, NULL, 1),
(598, 'Matisyahu', NULL, NULL, NULL, 'f073e38649c97dda47467e39375b3bd49db9fad1', NULL, NULL, NULL, NULL, 3, NULL, 599, NULL, 1),
(599, 'Matthew Shipp', NULL, NULL, NULL, '3d26e753bd91c7308b8afd8ca46050462b475158', NULL, NULL, NULL, NULL, 3, NULL, 600, NULL, 1),
(600, 'Max Romeo & The Upsetters', NULL, NULL, NULL, '468641c360485c68b22191efc975f63ba1b05763', NULL, NULL, NULL, NULL, 3, NULL, 601, NULL, 1),
(601, 'Mazzy Star', NULL, NULL, NULL, 'e686146bc1ac279ec0dd03ddf617347719e3de4c', NULL, NULL, NULL, NULL, 3, NULL, 602, NULL, 1),
(602, 'Meat Puppets', NULL, NULL, NULL, '71ca169f3b73feca41d38bb1b3bb24dcaa15b757', NULL, NULL, NULL, NULL, 3, NULL, 603, NULL, 1),
(603, 'Medeski Martin & Wood', NULL, NULL, NULL, 'bc711094757c5bd04ad81e1cf960810326b7d7fb', NULL, NULL, NULL, NULL, 3, NULL, 604, NULL, 1),
(604, 'Medeski Martin and Wood', NULL, NULL, NULL, '637a20a4123dfdc45551f62772689821d6f37f9a', NULL, NULL, NULL, NULL, 3, NULL, 605, NULL, 1),
(605, 'Medeski, Martin & Wood', NULL, NULL, NULL, '25393dd9bf5752e5688c49c15d130f3663c95a67', NULL, NULL, NULL, NULL, 3, NULL, 606, NULL, 1),
(606, 'Mega City Four', NULL, NULL, NULL, '5c639804ae478f1336e08c3857b2ff09d8f5a8fc', NULL, NULL, NULL, NULL, 3, NULL, 607, NULL, 1),
(607, 'Megaherzios', NULL, NULL, NULL, '6456c8c05ee81203ebf1991db819576a72afd4ab', NULL, NULL, NULL, NULL, 3, NULL, 608, NULL, 1),
(608, 'Mejor Actor de Reparto', NULL, NULL, NULL, '8e5101f6039151a3b521057b36834fe428c0448a', NULL, NULL, NULL, NULL, 3, NULL, 609, NULL, 1),
(609, 'Mersey', NULL, NULL, NULL, 'b907e6567887a00a5034e4061edaa1b0315fb493', NULL, NULL, NULL, NULL, 3, NULL, 610, NULL, 1),
(610, 'Messer Chups', NULL, NULL, NULL, 'e4cd069485bd7e441203af282c7e6c9551cce786', NULL, NULL, NULL, NULL, 3, NULL, 611, NULL, 1),
(611, 'The Meteors', NULL, NULL, NULL, '67560f7f7372b7a6343e7a4c9d962ec9e155c672', NULL, NULL, NULL, NULL, 3, NULL, 612, NULL, 1),
(612, 'The Metros', NULL, NULL, NULL, 'ee955091618ead3612eaa7d79336f666d352719e', NULL, NULL, NULL, NULL, 3, NULL, 613, NULL, 1),
(613, 'Metz', NULL, NULL, NULL, 'eddaaed2c46123b358e14a74b5fcb5432fe6b55f', NULL, NULL, NULL, NULL, 3, NULL, 614, NULL, 1),
(614, 'MEXICAN WEIRDOHS', NULL, NULL, NULL, 'a7d58bf3c8547ce67d363e6d6984792ae0b91afe', NULL, NULL, NULL, NULL, 3, NULL, 615, NULL, 1),
(615, 'Mi amigo invencible', NULL, NULL, NULL, '887fcb28b7ae391f2bf615a19f2d52839170b7bc', NULL, NULL, NULL, NULL, 3, NULL, 616, NULL, 1),
(616, 'Mi Nave', NULL, NULL, NULL, '98d2250df7bf99d28eb2792b67bfd5cb219fc9e5', NULL, NULL, NULL, NULL, 3, NULL, 617, NULL, 1),
(617, 'Michel Camilo', NULL, NULL, NULL, 'cf9d45d73df80d486d8d14105798c833a80e2e56', NULL, NULL, NULL, NULL, 3, NULL, 618, NULL, 1),
(618, 'Mick Harvey', NULL, NULL, NULL, '56ce566854928fd353ef27645238b3394d2f3b55', NULL, NULL, NULL, NULL, 3, NULL, 619, NULL, 1),
(619, 'Miles Davis', NULL, NULL, NULL, '7cc3f0b380a1a585227fab75bd4a06aff6e0e6ad', NULL, NULL, NULL, NULL, 3, NULL, 620, NULL, 1),
(620, 'Miles Davis & Robert Glasper', NULL, NULL, NULL, '9d60696d7028fcb5e9e4be2a67b190fb5f8219ca', NULL, NULL, NULL, NULL, 3, NULL, 621, NULL, 1),
(621, 'Mimi Maura', NULL, NULL, NULL, '20c7162a01d4d2c1ef97dea0fa4666d62eb72c5e', NULL, NULL, NULL, NULL, 3, NULL, 622, NULL, 1),
(622, 'Mimi Maura & Los Aggrotones', NULL, NULL, NULL, '55f47dff4436a8d05e7461934b3d5b7e42426752', NULL, NULL, NULL, NULL, 3, NULL, 623, NULL, 1),
(623, 'Mission of Burma', NULL, NULL, NULL, '3f495d6887bb39cc8758d2bca38f26b99ced91e5', NULL, NULL, NULL, NULL, 3, NULL, 624, NULL, 1),
(624, 'The Moaners', NULL, NULL, NULL, '326ab8085a6769f17bbce6f9b101a8ef1ef3cd0c', NULL, NULL, NULL, NULL, 3, NULL, 625, NULL, 1),
(625, 'The Modelos', NULL, NULL, NULL, 'cec2795376584b877269f777c8aa128fe6020a17', NULL, NULL, NULL, NULL, 3, NULL, 626, NULL, 1),
(626, 'Modelos, The', NULL, NULL, NULL, '3730b8ff4f0fdd4c09ded355d6309db7e70fa406', NULL, NULL, NULL, NULL, 3, NULL, 627, NULL, 1),
(627, 'Modern Baseball', NULL, NULL, NULL, 'ceca2408cdb0583dbee44e45a706b3dd329dc7a7', NULL, NULL, NULL, NULL, 3, NULL, 628, NULL, 1),
(628, 'Modern Lovers', NULL, NULL, NULL, 'df4fdbb5a340701ba84ac36621a025ba10f1c07b', NULL, NULL, NULL, NULL, 3, NULL, 629, NULL, 1),
(629, 'Mogwai', NULL, NULL, NULL, '1ffd63289f485eede951242f11fa0314a33fa4a6', NULL, NULL, NULL, NULL, 3, NULL, 630, NULL, 1),
(630, 'The Molochs', NULL, NULL, NULL, '0f42210bbd32e9205b8da8492e2d79d5afd4f8fd', NULL, NULL, NULL, NULL, 3, NULL, 631, NULL, 1),
(631, 'The Mono Men', NULL, NULL, NULL, '493eabf6b8adcb7260cb4bdb8e3b92527cdd3bc7', NULL, NULL, NULL, NULL, 3, NULL, 632, NULL, 1),
(632, 'Monocero', NULL, NULL, NULL, '96d8b238a97b7e7763b36f560818e285eade114b', NULL, NULL, NULL, NULL, 3, NULL, 633, NULL, 1),
(633, 'Monograph', NULL, NULL, NULL, 'cfdf41471129d1d22c81f6adcc01ce5d72b1c483', NULL, NULL, NULL, NULL, 3, NULL, 634, NULL, 1),
(634, 'Moon Duo', NULL, NULL, NULL, '9a5d5e2ce2c8839e517c95f11c060bba6da795c3', NULL, NULL, NULL, NULL, 3, NULL, 635, NULL, 1),
(635, 'Morenas', NULL, NULL, NULL, 'f4bb120fff7b94a5b7ecef05aa38b9f0f843c8e3', NULL, NULL, NULL, NULL, 3, NULL, 636, NULL, 1),
(636, 'Moretons', NULL, NULL, NULL, 'c83408c1fd783d6c029c860c5503e73001928ac3', NULL, NULL, NULL, NULL, 3, NULL, 637, NULL, 1),
(637, 'Moris', NULL, NULL, NULL, '49c52ac5fa2acbef2c0611ab51d6238152c3df5b', NULL, NULL, NULL, NULL, 3, NULL, 638, NULL, 1),
(638, 'Morphine', NULL, NULL, NULL, '1414b7607a9b6a17a1f92901ca78291c405658f9', NULL, NULL, NULL, NULL, 3, NULL, 639, NULL, 1),
(639, 'Morrissey', NULL, NULL, NULL, '48ff55a52c23dd6b06c4089285210de7d016b4ad', NULL, NULL, NULL, NULL, 3, NULL, 640, NULL, 1),
(640, 'Mostruo', NULL, NULL, NULL, '0dee3854c9b3c0407d761c3c7f27e1384fe9ddc2', NULL, NULL, NULL, NULL, 3, NULL, 641, NULL, 1),
(641, 'Mother Liza & Kojak', NULL, NULL, NULL, 'e6ab456e89d386fb3fbcb36a4fc04effb47ca01d', NULL, NULL, NULL, NULL, 3, NULL, 642, NULL, 1),
(642, 'Motorama', NULL, NULL, NULL, 'f3609c3f82bd12990297c0b7d95e372bfd5e1c95', NULL, NULL, NULL, NULL, 3, NULL, 643, NULL, 1),
(643, 'Motorhead', NULL, NULL, NULL, '16d4499dd38bdef7ae20056aca2cd7d8380f0fe1', NULL, NULL, NULL, NULL, 3, NULL, 644, NULL, 1),
(644, 'The Mountain Goats', NULL, NULL, NULL, 'b1530b1b8595578c1bc1ebbcc87f087ef7382c08', NULL, NULL, NULL, NULL, 3, NULL, 645, NULL, 1),
(645, 'Mourn', NULL, NULL, NULL, 'f8225e9197ad0b3fa8141bcf4580359671e61c2d', NULL, NULL, NULL, NULL, 3, NULL, 646, NULL, 1),
(646, 'Mudhoney', NULL, NULL, NULL, '0e3e0c0700b6d698e3b6e53d49c9eab814b4ccee', NULL, NULL, NULL, NULL, 3, NULL, 647, NULL, 1),
(647, 'Mujercitas Terror', NULL, NULL, NULL, '7bd606671504b9d5e61c3d7cfa3d94021a526136', NULL, NULL, NULL, NULL, 3, NULL, 648, NULL, 1),
(648, 'Mujeres', NULL, NULL, NULL, 'eed9d0c3ce38e09a480f476c01eea15443703d99', NULL, NULL, NULL, NULL, 3, NULL, 649, NULL, 1),
(649, 'Mulatu Astatke & The Heliocentrics', NULL, NULL, NULL, 'a2ade1de524cd2bf4694c5291a56f14d09bdb1a2', NULL, NULL, NULL, NULL, 3, NULL, 650, NULL, 1),
(650, 'The Mullet Monster Mafia', NULL, NULL, NULL, '6e98b13101b259eba9722964a3985770006d7b32', NULL, NULL, NULL, NULL, 3, NULL, 651, NULL, 1),
(651, 'Mungulu y Los Trasmutadores', NULL, NULL, NULL, '424599bbed950b8b48211351f1dc8d94194026ec', NULL, NULL, NULL, NULL, 3, NULL, 652, NULL, 1),
(652, 'My Bloody Valentine', NULL, NULL, NULL, 'd94f0e3afbe29584efef89e46371a2447e195c26', NULL, NULL, NULL, NULL, 3, NULL, 653, NULL, 1),
(653, 'The Mystery Lights', NULL, NULL, NULL, '35a7a3c325dbd94f16510c5eaff7f10533f34135', NULL, NULL, NULL, NULL, 3, NULL, 654, NULL, 1),
(654, 'Mystic Braves', NULL, NULL, NULL, 'cba6c69bebdc4347e8342e3ced0f7d9f6ff7a796', NULL, NULL, NULL, NULL, 3, NULL, 655, NULL, 1),
(655, 'Nada Surf', NULL, NULL, NULL, '10b175c1e4ffc983dc3d8c737cef46395cb7226f', NULL, NULL, NULL, NULL, 3, NULL, 656, NULL, 1),
(656, 'Nat Adderley', NULL, NULL, NULL, 'fe3ef3336541850c6352df479195b65fb21b02f6', NULL, NULL, NULL, NULL, 3, NULL, 657, NULL, 1),
(657, 'The National', NULL, NULL, NULL, 'ab2b3f0906d102be54befe3514849d38b8392e51', NULL, NULL, NULL, NULL, 3, NULL, 658, NULL, 1),
(658, 'Natty Combo', NULL, NULL, NULL, 'be9f7cf760ece69c1147fd95e751256f4d13a831', NULL, NULL, NULL, NULL, 3, NULL, 659, NULL, 1),
(659, 'The Nebulas', NULL, NULL, NULL, '391b51daa08896045033f147b304dedce6cc33b4', NULL, NULL, NULL, NULL, 3, NULL, 660, NULL, 1),
(660, 'The Neighbourhood', NULL, NULL, NULL, 'c94fa77b7d9d9034fb985105a2f970d122f6e3e0', NULL, NULL, NULL, NULL, 3, NULL, 661, NULL, 1),
(661, 'Nero\'s Rome', NULL, NULL, NULL, 'ac7b069cd1fce3f30888ec7ba7615079bb1a8d12', NULL, NULL, NULL, NULL, 3, NULL, 662, NULL, 1),
(662, 'Neu!', NULL, NULL, NULL, 'b2aabfb293d6c746827e7da07c9476d97c2ed162', NULL, NULL, NULL, NULL, 3, NULL, 663, NULL, 1),
(663, 'Neutral Milk Hotel', NULL, NULL, NULL, '4c9a0eebc1eff2ee1c22fdbff599830c34eab19a', NULL, NULL, NULL, NULL, 3, NULL, 664, NULL, 1),
(664, 'New Order', NULL, NULL, NULL, '33456b6eb8bc965322c24333df1bde068ac563a4', NULL, NULL, NULL, NULL, 3, NULL, 665, NULL, 1),
(665, 'The New Raemon', NULL, NULL, NULL, 'f506d3524e6ecf9cd4d24da4029edcc772de90e3', NULL, NULL, NULL, NULL, 3, NULL, 666, NULL, 1),
(666, 'The New Review', NULL, NULL, NULL, '8ab6ff1aa6810b49281e15b2ae8f6afe056b1869', NULL, NULL, NULL, NULL, 3, NULL, 667, NULL, 1),
(667, 'New York Dolls', NULL, NULL, NULL, '0fbe690e4bf19a4dacf76eb0983e9c57e84411b7', NULL, NULL, NULL, NULL, 3, NULL, 668, NULL, 1),
(668, 'Nick Cave', NULL, NULL, NULL, '17d16258fe86590d2b12c3ea7d7b6e53376c60d7', NULL, NULL, NULL, NULL, 3, NULL, 669, NULL, 1),
(669, 'Nick Cave & The Bad Seeds', NULL, NULL, NULL, '6a59e14d30c9e0398f5148058334aefd77e78b08', NULL, NULL, NULL, NULL, 3, NULL, 670, NULL, 1),
(670, 'Nick Cave And The Bad Seeds', NULL, NULL, NULL, '82c7d4b9f2bcd7a031f86c393a3f6b895140850f', NULL, NULL, NULL, NULL, 3, NULL, 671, NULL, 1),
(671, 'Niels-Henning Orsted Pedersen', NULL, NULL, NULL, '57032a29b4e97692fbf5997d38433051cfe1b235', NULL, NULL, NULL, NULL, 3, NULL, 672, NULL, 1),
(672, 'Nieva Adentro', NULL, NULL, NULL, '698f2424b5c6bfb4c59a303d3196ef8eca5b177f', NULL, NULL, NULL, NULL, 3, NULL, 673, NULL, 1),
(673, 'Night Beats', NULL, NULL, NULL, '908d6f8a6db82075165eaef09c2d013e0cab090b', NULL, NULL, NULL, NULL, 3, NULL, 674, NULL, 1),
(674, 'Nikita Nipone', NULL, NULL, NULL, '8e5e83d461d9e6a0107a1020cc3be16fd5eeac9c', NULL, NULL, NULL, NULL, 3, NULL, 675, NULL, 1),
(675, 'Nina Simone', NULL, NULL, NULL, 'fd2d897f89d0af9dd13a856e7620e8f2710fa736', NULL, NULL, NULL, NULL, 3, NULL, 676, NULL, 1),
(676, 'Nirvana', NULL, NULL, NULL, 'ce1050f9754e95fcdabac1332f98a6b57ae702a8', NULL, NULL, NULL, NULL, 3, NULL, 677, NULL, 1),
(677, 'No Joy', NULL, NULL, NULL, '00d80f9de8bdf4efa8806651c210fa54ee59a014', NULL, NULL, NULL, NULL, 3, NULL, 678, NULL, 1),
(678, 'NO SABE NO CONTESTA', NULL, NULL, NULL, '1180c0abd65803afb98646e968d72417fb4df31e', NULL, NULL, NULL, NULL, 3, NULL, 679, NULL, 1),
(679, 'Noel Gallagher\'s High Flying Birds', NULL, NULL, NULL, '820cac6e3dd3de4d21bd8b0a0352d7eb3b8feb1d', NULL, NULL, NULL, NULL, 3, NULL, 680, NULL, 1),
(680, 'Nogal', NULL, NULL, NULL, 'e9b344c75ebf4792a1d4c3683b6c2ee7adab8cdc', NULL, NULL, NULL, NULL, 3, NULL, 681, NULL, 1),
(681, 'The Nomads', NULL, NULL, NULL, 'bb530fc2833e0b38442560eac6e1c47eedc92b7e', NULL, NULL, NULL, NULL, 3, NULL, 682, NULL, 1),
(682, 'Nothing', NULL, NULL, NULL, '7efbcee0abc09ae85a952bee6d5a51b37bf06dab', NULL, NULL, NULL, NULL, 3, NULL, 683, NULL, 1),
(683, 'Nouvelle Vague', NULL, NULL, NULL, 'befc13eb9818d52557498adb4ebe334bae5bff95', NULL, NULL, NULL, NULL, 3, NULL, 684, NULL, 1),
(684, 'Novedades Carminha', NULL, NULL, NULL, 'ad5bebd393fec346b74b1d6f4225f279c9000990', NULL, NULL, NULL, NULL, 3, NULL, 685, NULL, 1),
(685, 'Now, Now Every Children', NULL, NULL, NULL, 'd9a0ba283cb9e6717d80f75969b429cceb3e30f7', NULL, NULL, NULL, NULL, 3, NULL, 686, NULL, 1),
(686, 'Nuggets', NULL, NULL, NULL, '23a4c7919f34209778d154f04fa1a98bfea54d43', NULL, NULL, NULL, NULL, 3, NULL, 687, NULL, 1),
(687, 'Ocean Colour Scene', NULL, NULL, NULL, 'efe428f0adfb55818ac15056bb1b1f8fb15012b0', NULL, NULL, NULL, NULL, 3, NULL, 688, NULL, 1),
(688, 'The Ocean Party', NULL, NULL, NULL, '8f646694f6542ebba23374c74a8c3c7459922d7d', NULL, NULL, NULL, NULL, 3, NULL, 689, NULL, 1),
(689, 'Of Monsters And Men', NULL, NULL, NULL, 'ff5e1c984aca3dbd161879257489cf832125779a', NULL, NULL, NULL, NULL, 3, NULL, 690, NULL, 1),
(690, 'Of Montreal', NULL, NULL, NULL, '8a9ce0b022b11a8d6f277960452e08a8778a7b4e', NULL, NULL, NULL, NULL, 3, NULL, 691, NULL, 1),
(691, 'Oh Sees', NULL, NULL, NULL, 'ef6a52f7f0b25d0a9732a5a52b55d3d2a6c52b60', NULL, NULL, NULL, NULL, 3, NULL, 692, NULL, 1),
(692, 'Ok Pirámides', NULL, NULL, NULL, '2331b9c2dc19f9fb86ff21f2c98b5cc2e2466352', NULL, NULL, NULL, NULL, 3, NULL, 693, NULL, 1),
(693, 'Ornamento y Delito', NULL, NULL, NULL, '239cb4f5a869d10ac1e8cbad957642fe3ffa3052', NULL, NULL, NULL, NULL, 3, NULL, 694, NULL, 1),
(694, 'Ornette Coleman', NULL, NULL, NULL, '90ef4bdd6a367e858f6a1c051f294e4826a8ef01', NULL, NULL, NULL, NULL, 3, NULL, 695, NULL, 1),
(695, 'The Orwells', NULL, NULL, NULL, '4c69870668269163b75db84ef410a2761e33ca5d', NULL, NULL, NULL, NULL, 3, NULL, 696, NULL, 1),
(696, 'Oscar Peterson', NULL, NULL, NULL, '3357c6f3826b46f867a7b73eb3b208ba14d7badb', NULL, NULL, NULL, NULL, 3, NULL, 697, NULL, 1),
(697, 'Oscar Peterson Trio', NULL, NULL, NULL, '3b631eb95a41bbde86b89de21037b41539686db3', NULL, NULL, NULL, NULL, 3, NULL, 698, NULL, 1),
(698, 'Oscar Pettiford', NULL, NULL, NULL, '01f619c0441a9fff6f27db90071d1709335cb0f6', NULL, NULL, NULL, NULL, 3, NULL, 699, NULL, 1),
(699, 'Pablo Moses', NULL, NULL, NULL, 'd255604b7d8d4487ac927c335f9076994a91570b', NULL, NULL, NULL, NULL, 3, NULL, 700, NULL, 1),
(700, 'Page One & The Observers', NULL, NULL, NULL, '02739d1c91a10a8feb8f4dd0d7e01cce2f563a61', NULL, NULL, NULL, NULL, 3, NULL, 701, NULL, 1),
(701, 'The Pains Of Being Pure At Heart', NULL, NULL, NULL, '6a9d8cfe59c53d983942b42aa237269eda959a91', NULL, NULL, NULL, NULL, 3, NULL, 702, NULL, 1),
(702, 'Palo & La Hermandad', NULL, NULL, NULL, '1972d99b939aa944e7727a15db99adfac722b9d9', NULL, NULL, NULL, NULL, 3, NULL, 703, NULL, 1),
(703, 'Palo Pandolfo', NULL, NULL, NULL, 'd07b90b72e8d82d874a89a021510606c36db7530', NULL, NULL, NULL, NULL, 3, NULL, 704, NULL, 1),
(704, 'PALS', NULL, NULL, NULL, 'ed9b6e0f28b9c53a4156940a173c98bc66d7de53', NULL, NULL, NULL, NULL, 3, NULL, 705, NULL, 1),
(705, 'Panda Riot', NULL, NULL, NULL, '5e949e5e5c0166a74ab2b749fc150dfe331020c4', NULL, NULL, NULL, NULL, 3, NULL, 706, NULL, 1),
(706, 'Panty Pantera', NULL, NULL, NULL, '8863a5120d62186551a98a5c20ae6f6bd7c71d12', NULL, NULL, NULL, NULL, 3, NULL, 707, NULL, 1),
(707, 'Pappo\'s Blues', NULL, NULL, NULL, 'f76a75e7ea3ee61c324ce4bf708d9bff94ffc1ea', NULL, NULL, NULL, NULL, 3, NULL, 708, NULL, 1),
(708, 'Parque Fantasma', NULL, NULL, NULL, 'b58f2563fb317da88d8b993920c643a8de373014', NULL, NULL, NULL, NULL, 3, NULL, 709, NULL, 1),
(709, 'Parquet Courts', NULL, NULL, NULL, '0c986459859741f3552bc14d42cbefbe280374c4', NULL, NULL, NULL, NULL, 3, NULL, 710, NULL, 1),
(710, 'pasadoverde', NULL, NULL, NULL, '40645ec496411b6f619e8ea46b4a2eea047f9599', NULL, NULL, NULL, NULL, 3, NULL, 711, NULL, 1),
(711, 'The Pastels', NULL, NULL, NULL, '24a83d85e9341a3157350ab14270ae4eebd615e2', NULL, NULL, NULL, NULL, 3, NULL, 712, NULL, 1),
(712, 'Pat Metheny & Ornette Coleman', NULL, NULL, NULL, '6bad552ff5d4e159f3cd7574cf2f3263de3c1065', NULL, NULL, NULL, NULL, 3, NULL, 713, NULL, 1),
(713, 'Patti Smith', NULL, NULL, NULL, '38956059339de579ad099a616d425c02faf63d9c', NULL, NULL, NULL, NULL, 3, NULL, 714, NULL, 1),
(714, 'Paul Chambers', NULL, NULL, NULL, '63b15c31fe1b8ae297dd07b0b169e68ae7c7b7fc', NULL, NULL, NULL, NULL, 3, NULL, 715, NULL, 1),
(715, 'Paul Chambers Quintet', NULL, NULL, NULL, '51d609ba43dc72366830f3d03b744ade9cbd5dab', NULL, NULL, NULL, NULL, 3, NULL, 716, NULL, 1),
(716, 'Paul Desmond', NULL, NULL, NULL, '2c48d22dec3526f0f86cbf0b15aea72522484a9d', NULL, NULL, NULL, NULL, 3, NULL, 717, NULL, 1),
(717, 'Paul Weller', NULL, NULL, NULL, 'f6093494de2e2b6df706e33ffca97bceb8a310b3', NULL, NULL, NULL, NULL, 3, NULL, 718, NULL, 1),
(718, 'Pavement', NULL, NULL, NULL, 'dc081b47d0e9f2637fd041cbaf44778a200e15f2', NULL, NULL, NULL, NULL, 3, NULL, 719, NULL, 1),
(719, 'Pearl Jam', NULL, NULL, NULL, 'ca73f1278c8ead2236d6c927167ac0163c1e505b', NULL, NULL, NULL, NULL, 3, NULL, 720, NULL, 1),
(720, 'Peces Raros', NULL, NULL, NULL, '45dd650ed8d5c07fa394cb39cefe4d2bcecac803', NULL, NULL, NULL, NULL, 3, NULL, 721, NULL, 1),
(721, 'Peces y Pajaros', NULL, NULL, NULL, 'e1db539889c1f9c20d207c47f5a8f80b97261f83', NULL, NULL, NULL, NULL, 3, NULL, 722, NULL, 1),
(722, 'Peligrosos Gorriones', NULL, NULL, NULL, 'aaa453373831be3b68bf7df1e072aea575866e0e', NULL, NULL, NULL, NULL, 3, NULL, 723, NULL, 1),
(723, 'Pere Ubu', NULL, NULL, NULL, '5344065e51fd91fa973db87cc40bb95dfebdabdb', NULL, NULL, NULL, NULL, 3, NULL, 724, NULL, 1),
(724, 'Perez', NULL, NULL, NULL, 'cb7931ac27f30f08fd62dc702d0d09f0481713e7', NULL, NULL, NULL, NULL, 3, NULL, 725, NULL, 1),
(725, 'Perro', NULL, NULL, NULL, '7497c38c3c74c6a3297d15183e0d1ca601417abf', NULL, NULL, NULL, NULL, 3, NULL, 726, NULL, 1),
(726, 'Peru', NULL, NULL, NULL, '68c1871accb468ddc115e34897c3cf4d3d2e1567', NULL, NULL, NULL, NULL, 3, NULL, 727, NULL, 1),
(727, 'Pescado Rabioso', NULL, NULL, NULL, 'b9e73622f47f3f9696866097d638f4b117ab8b4c', NULL, NULL, NULL, NULL, 3, NULL, 728, NULL, 1),
(728, 'Peter Broggs', NULL, NULL, NULL, 'd006a7915fc07c69419f4d066e48d66d46259d28', NULL, NULL, NULL, NULL, 3, NULL, 729, NULL, 1),
(729, 'Peter Doherty', NULL, NULL, NULL, 'fdc476c7193ef4d3cfeb11595d73d88596578d42', NULL, NULL, NULL, NULL, 3, NULL, 730, NULL, 1),
(730, 'Peter Perrett', NULL, NULL, NULL, '71649a1866bbb397039f05249a6835d0fe3df8fd', NULL, NULL, NULL, NULL, 3, NULL, 731, NULL, 1),
(731, 'Peter Tosh', NULL, NULL, NULL, '1bf4a4af695999f437f2b439e5990dced23333b6', NULL, NULL, NULL, NULL, 3, NULL, 732, NULL, 1),
(732, 'Pia Fraus', NULL, NULL, NULL, '457ab03a612733034766b8ada3b1fc5bf58da72c', NULL, NULL, NULL, NULL, 3, NULL, 733, NULL, 1),
(733, 'Piel de Pueblo', NULL, NULL, NULL, 'b31dffb6f445ac1102be432de75788317bef83bf', NULL, NULL, NULL, NULL, 3, NULL, 734, NULL, 1),
(734, 'Pil', NULL, NULL, NULL, 'bca6b3dc909f3d7c19c02341e1ff10f074cf00e9', NULL, NULL, NULL, NULL, 3, NULL, 735, NULL, 1),
(735, 'Pink Floyd', NULL, NULL, NULL, 'f6349a80d5e25e08a21c62bc27391714d35e77d4', NULL, NULL, NULL, NULL, 3, NULL, 736, NULL, 1),
(736, 'Pixies', NULL, NULL, NULL, 'e5bbe5da3b554818f16ab7b3a50d7e824bb3545f', NULL, NULL, NULL, NULL, 3, NULL, 737, NULL, 1),
(737, 'Piyama Party', NULL, NULL, NULL, '3c2cc8a3d65721183102b4dba23c069a9b0fd8d0', NULL, NULL, NULL, NULL, 3, NULL, 738, NULL, 1),
(738, 'PJ Harvey', NULL, NULL, NULL, '5afeb6f9b1400a486e7ae9413ff9a561c026f0fe', NULL, NULL, NULL, NULL, 3, NULL, 739, NULL, 1),
(739, 'Placer', NULL, NULL, NULL, 'fedf23dc41c27bd772d448c953e5d12551cdd074', NULL, NULL, NULL, NULL, 3, NULL, 740, NULL, 1),
(740, 'Pocavida', NULL, NULL, NULL, '08dbe7e74ff4a11b8635556a52fbdaf816b8aa91', NULL, NULL, NULL, NULL, 3, NULL, 741, NULL, 1),
(741, 'Pond', NULL, NULL, NULL, '74e373eae50bbe39934daf0c1d83a3ebf4e96ff6', NULL, NULL, NULL, NULL, 3, NULL, 742, NULL, 1),
(742, 'Portishead', NULL, NULL, NULL, '3c95e858c40d5446dd09da9236f40d1cdad24731', NULL, NULL, NULL, NULL, 3, NULL, 743, NULL, 1),
(743, 'The Posies', NULL, NULL, NULL, '783db0355d454437dfd1600a460f01e013781d8f', NULL, NULL, NULL, NULL, 3, NULL, 744, NULL, 1),
(744, 'The Prayers', NULL, NULL, NULL, 'f334003203d1a378b9b1823201f93b9c457dd151', NULL, NULL, NULL, NULL, 3, NULL, 745, NULL, 1),
(745, 'The Pretty Things', NULL, NULL, NULL, 'c15857faa92c42c4e93b94077cd9841fe0685d95', NULL, NULL, NULL, NULL, 3, NULL, 746, NULL, 1),
(746, 'Priests', NULL, NULL, NULL, 'c13504c259ffbb04ec8efdd5a6b103422c1ad77a', NULL, NULL, NULL, NULL, 3, NULL, 747, NULL, 1),
(747, 'prietto viaja al cosmos con mariano', NULL, NULL, NULL, '8c49f9bfcfc1ef61b9c0a756b8acebb9b103f184', NULL, NULL, NULL, NULL, 3, NULL, 748, NULL, 1),
(748, 'Primal scream', NULL, NULL, NULL, '3683c2c023065d8a9cc6a544c33d001bd50de715', NULL, NULL, NULL, NULL, 3, NULL, 749, NULL, 1),
(749, 'The Primitives', NULL, NULL, NULL, '641bf0d56ed4624d9c98a8a3688a00bf72cb8cb0', NULL, NULL, NULL, NULL, 3, NULL, 750, NULL, 1),
(750, 'Prince Buster', NULL, NULL, NULL, 'f8e43df8fa6a431378b4493cadafec5244994f23', NULL, NULL, NULL, NULL, 3, NULL, 751, NULL, 1),
(751, 'Prince Buster & Baba Brooks', NULL, NULL, NULL, '16b61ad7b949bc4f991b60f8cbaaf5a814811de5', NULL, NULL, NULL, NULL, 3, NULL, 752, NULL, 1),
(752, 'Proyecto Varsovia', NULL, NULL, NULL, '2dafad0dd3e4778accc4c4c5971990bbdbe61010', NULL, NULL, NULL, NULL, 3, NULL, 753, NULL, 1),
(753, 'PS I Love You', NULL, NULL, NULL, 'b55feb61d7643ce4ab9689214c1dac1d014c7725', NULL, NULL, NULL, NULL, 3, NULL, 754, NULL, 1),
(754, 'The Psychedelic Furs', NULL, NULL, NULL, '7c7ff9b693869f85d740c887e7d341c187b09032', NULL, NULL, NULL, NULL, 3, NULL, 755, NULL, 1),
(755, 'Public Image Limited', NULL, NULL, NULL, 'cb0629705e6e830f7e7689a0a05c75e3dcc1b7e7', NULL, NULL, NULL, NULL, 3, NULL, 756, NULL, 1),
(756, 'Pulp', NULL, NULL, NULL, 'd98cf394a5ccf565ba4d5e35083e24e5795c76b2', NULL, NULL, NULL, NULL, 3, NULL, 757, NULL, 1),
(757, 'The Punks', NULL, NULL, NULL, '58e78854aa8e0f53a2d0bb618053006b7bc8d586', NULL, NULL, NULL, NULL, 3, NULL, 758, NULL, 1);
INSERT INTO `profile` (`id`, `name`, `last_name`, `birth_date`, `birth_location`, `photo`, `mail`, `phone`, `facebook`, `twitter`, `visibility`, `gender_id`, `options_id`, `gender_desc`, `listed`) VALUES
(758, 'PYRAMIDES', NULL, NULL, NULL, 'b864e21f96b21f2cb8b6e166d2c0a153d94a082d', NULL, NULL, NULL, NULL, 3, NULL, 759, NULL, 1),
(759, 'Queens of the Stone Age', NULL, NULL, NULL, '21ff13603f67020491c352a60fcb2a1043db59f3', NULL, NULL, NULL, NULL, 3, NULL, 760, NULL, 1),
(760, 'Quemacoches', NULL, NULL, NULL, '5051477600ecb07d8ed04bd0b4095572b4e68556', NULL, NULL, NULL, NULL, 3, NULL, 761, NULL, 1),
(761, 'Quemacochs', NULL, NULL, NULL, 'd592ca49c43ad077a68ed1f77b6f9f3c63317beb', NULL, NULL, NULL, NULL, 3, NULL, 762, NULL, 1),
(762, 'Question Mark And The Mysterians', NULL, NULL, NULL, '5069a6c36c37235dfcbdfd063b414f6ccb79ce5c', NULL, NULL, NULL, NULL, 3, NULL, 763, NULL, 1),
(763, 'R.E.M.', NULL, NULL, NULL, 'f553d4c694b56b159970ee05fb6a7f551e51fdb1', NULL, NULL, NULL, NULL, 3, NULL, 764, NULL, 1),
(764, 'Ra Ra Riot', NULL, NULL, NULL, 'f3181ebd3a0510e1e075d7f9d8035ecd4f0c0394', NULL, NULL, NULL, NULL, 3, NULL, 765, NULL, 1),
(765, 'The Raconteurs', NULL, NULL, NULL, 'a850b55ead2e2abb5711ed40e94febc9731a46bb', NULL, NULL, NULL, NULL, 3, NULL, 766, NULL, 1),
(766, 'Radar Eyes', NULL, NULL, NULL, 'a1a7b174b1f3f9849396f2b07fa9596f24434677', NULL, NULL, NULL, NULL, 3, NULL, 767, NULL, 1),
(767, 'Radio Birdman', NULL, NULL, NULL, '1a7e51c4b81d42949c36ae25b13214bba2dbcfa8', NULL, NULL, NULL, NULL, 3, NULL, 768, NULL, 1),
(768, 'The Radio Dept', NULL, NULL, NULL, 'b9a9ea3969297a0e3df26068a0ce1ba459c51ca4', NULL, NULL, NULL, NULL, 3, NULL, 769, NULL, 1),
(769, 'Radio Moscow', NULL, NULL, NULL, '35843fad6519e542a958abb65ea17a7187d04f3d', NULL, NULL, NULL, NULL, 3, NULL, 770, NULL, 1),
(770, 'Radiohead', NULL, NULL, NULL, '8dd46c0bb5a907a9e6fb5bc46670c03e5ea42d2b', NULL, NULL, NULL, NULL, 3, NULL, 771, NULL, 1),
(771, 'Rage Against the Machine', NULL, NULL, NULL, '906870a2f015fa81c84041b19f55109330f42eaf', NULL, NULL, NULL, NULL, 3, NULL, 772, NULL, 1),
(772, 'The Ramones', NULL, NULL, NULL, 'cd09cb5deeeadd0525bbae1e08d28dcccf49d434', NULL, NULL, NULL, NULL, 3, NULL, 773, NULL, 1),
(773, 'Rata Negra', NULL, NULL, NULL, '3e9e9e81ac4d9882ed04821f18d2342ac647ab7e', NULL, NULL, NULL, NULL, 3, NULL, 774, NULL, 1),
(774, 'Ratboys', NULL, NULL, NULL, 'bb87a51455a2eebebb71c823534a2707f9775d5c', NULL, NULL, NULL, NULL, 3, NULL, 775, NULL, 1),
(775, 'The Raveonettes', NULL, NULL, NULL, 'e99f3d579ae90801f5d1cae7b0f07ac5016bd7d7', NULL, NULL, NULL, NULL, 3, NULL, 776, NULL, 1),
(776, 'Ray Brown', NULL, NULL, NULL, 'f957e48b22709571cd7a765b3890756fde514810', NULL, NULL, NULL, NULL, 3, NULL, 777, NULL, 1),
(777, 'Rayos Laser', NULL, NULL, NULL, '47ec2c1fa973c4d4ddd8b441760f311e32d5e56e', NULL, NULL, NULL, NULL, 3, NULL, 778, NULL, 1),
(778, 'The Reaction', NULL, NULL, NULL, 'a17d64715228928922f378825b295ae9eda16b8f', NULL, NULL, NULL, NULL, 3, NULL, 779, NULL, 1),
(779, 'The Real Kids', NULL, NULL, NULL, 'd9443fbb6e636cebf6a40eb33fbafd64eb32b32e', NULL, NULL, NULL, NULL, 3, NULL, 780, NULL, 1),
(780, 'Red Hot Chili Peppers', NULL, NULL, NULL, 'fbd361587b21cdd29cffa94d6132b75820ebfe15', NULL, NULL, NULL, NULL, 3, NULL, 781, NULL, 1),
(781, 'The Remains', NULL, NULL, NULL, '3c3fc91b3ec10544bb50361b776429a713364fbf', NULL, NULL, NULL, NULL, 3, NULL, 782, NULL, 1),
(782, 'The Replacements', NULL, NULL, NULL, 'baa2e87a0e810d34207957846c9dbc2748b96593', NULL, NULL, NULL, NULL, 3, NULL, 783, NULL, 1),
(783, 'Rescate Internacional', NULL, NULL, NULL, 'fb3e9275e6a2b2b3c79e7f1ea68cac3d47f7274d', NULL, NULL, NULL, NULL, 3, NULL, 784, NULL, 1),
(784, 'Reverend Beat Man', NULL, NULL, NULL, '4b8e1a6d32543758583878c5ccabb580e455c9b0', NULL, NULL, NULL, NULL, 3, NULL, 785, NULL, 1),
(785, 'The Revolters', NULL, NULL, NULL, '83c787ecd3aa1cba80e73661dbb5b357e0eb3412', NULL, NULL, NULL, NULL, 3, NULL, 786, NULL, 1),
(786, 'The Revolutionaires', NULL, NULL, NULL, '0b3781ce98f13bb786191580511d933e65747611', NULL, NULL, NULL, NULL, 3, NULL, 787, NULL, 1),
(787, 'The Rhum Runners', NULL, NULL, NULL, '9064e06c419ac71ac12216ef13ccd51ff952c4d6', NULL, NULL, NULL, NULL, 3, NULL, 788, NULL, 1),
(788, 'Ricardo Gallo', NULL, NULL, NULL, '4bcaa55ed1f73b42d6ae586a5e64e23a77c118ca', NULL, NULL, NULL, NULL, 3, NULL, 789, NULL, 1),
(789, 'Richard Hell & The Voidoids', NULL, NULL, NULL, 'cf42b75cd2553f87c31053f47e4264570ad5bbc1', NULL, NULL, NULL, NULL, 3, NULL, 790, NULL, 1),
(790, 'Rico Rodriguez', NULL, NULL, NULL, '9709b1876732a542b8e0d6b4933bf2d7940ee066', NULL, NULL, NULL, NULL, 3, NULL, 791, NULL, 1),
(791, 'Ride', NULL, NULL, NULL, '0a28ef3f359b595ee42638c1e0c412591d584c7e', NULL, NULL, NULL, NULL, 3, NULL, 792, NULL, 1),
(792, 'Riel', NULL, NULL, NULL, '6bb87dddf5390eed774f5589ccc9fb65d818451a', NULL, NULL, NULL, NULL, 3, NULL, 793, NULL, 1),
(793, 'Ringo Deathstarr', NULL, NULL, NULL, 'e3e9be377518b6637d9102c33e04ded09812ac51', NULL, NULL, NULL, NULL, 3, NULL, 794, NULL, 1),
(794, 'Rita Marley', NULL, NULL, NULL, 'b77f444d5424aaef24f3c2f0a043fa2d337b7dce', NULL, NULL, NULL, NULL, 3, NULL, 795, NULL, 1),
(795, 'Rod Taylor', NULL, NULL, NULL, '6a32de5db89e0e60b420ec3f62aadd7e4737448d', NULL, NULL, NULL, NULL, 3, NULL, 796, NULL, 1),
(796, 'Rodriguez', NULL, NULL, NULL, 'ba77cccb2f74be609e309bb3eb81ffa64f37071a', NULL, NULL, NULL, NULL, 3, NULL, 797, NULL, 1),
(797, 'Roll the Tanks', NULL, NULL, NULL, 'd8a9070edc92776c2196c1f89374b24599488d07', NULL, NULL, NULL, NULL, 3, NULL, 798, NULL, 1),
(798, 'Rolling Stones', NULL, NULL, NULL, '10965d877beedb3e4612a86a4ed68959612affe7', NULL, NULL, NULL, NULL, 3, NULL, 799, NULL, 1),
(799, 'Rollng Stones', NULL, NULL, NULL, 'ab4ecd2ba617d1449392f9903d66a668d0b4946b', NULL, NULL, NULL, NULL, 3, NULL, 800, NULL, 1),
(800, 'Ron Carter, Herbie Hancock, Tony Williams', NULL, NULL, NULL, '74550aee49e8fef90eee96a0eba1e1838ecfbd29', NULL, NULL, NULL, NULL, 3, NULL, 801, NULL, 1),
(801, 'The Rosebuds', NULL, NULL, NULL, 'b07d3e1e734a7b914da2c2c0bd35d0206a195a7f', NULL, NULL, NULL, NULL, 3, NULL, 802, NULL, 1),
(802, 'The Roulettes', NULL, NULL, NULL, '487051394893309bb6afc17f068d9691b230beab', NULL, NULL, NULL, NULL, 3, NULL, 803, NULL, 1),
(803, 'The Routes', NULL, NULL, NULL, '91339f8a65a9aef994f077b04ebb7f423900d142', NULL, NULL, NULL, NULL, 3, NULL, 804, NULL, 1),
(804, 'Royal Blood', NULL, NULL, NULL, '91742b1cfe37f7358e676409123844216ffc4030', NULL, NULL, NULL, NULL, 3, NULL, 805, NULL, 1),
(805, 'Rozwell Kid', NULL, NULL, NULL, 'b72beebea5872a7958b4d62c357a982d0b307169', NULL, NULL, NULL, NULL, 3, NULL, 806, NULL, 1),
(806, 'Rudeboy', NULL, NULL, NULL, '5a08810baedd8e47a77eaed85eed8030a1d5b019', NULL, NULL, NULL, NULL, 3, NULL, 807, NULL, 1),
(807, 'Sabu', NULL, NULL, NULL, '6b1200b46a1e29c6b0118f2e64b6ab13cb17e9e9', NULL, NULL, NULL, NULL, 3, NULL, 808, NULL, 1),
(808, 'The Saints', NULL, NULL, NULL, '4a0f16fab3613897f82050cae7d289d3817cc866', NULL, NULL, NULL, NULL, 3, NULL, 809, NULL, 1),
(809, 'Salad Boys', NULL, NULL, NULL, 'a6d0c0dfb030167f3754f0daaf179e73ca5ed5a3', NULL, NULL, NULL, NULL, 3, NULL, 810, NULL, 1),
(810, 'Salvia', NULL, NULL, NULL, 'af2087676e8d8270841fefaae3aa76e2fccc3489', NULL, NULL, NULL, NULL, 3, NULL, 811, NULL, 1),
(811, 'Sanchez', NULL, NULL, NULL, '920af0814f6ab4880c1baa786936715617fbd0de', NULL, NULL, NULL, NULL, 3, NULL, 812, NULL, 1),
(812, 'Santos Inocentes', NULL, NULL, NULL, 'cd7d60c5a7e96db819384594414e54da863f415e', NULL, NULL, NULL, NULL, 3, NULL, 813, NULL, 1),
(813, 'Sarah Vaughan', NULL, NULL, NULL, '762160995752218e760869917fc629ce6cf6548f', NULL, NULL, NULL, NULL, 3, NULL, 814, NULL, 1),
(814, 'Sauna', NULL, NULL, NULL, '51f04b1ecc8ea61213db632a734929211397975c', NULL, NULL, NULL, NULL, 3, NULL, 815, NULL, 1),
(815, 'The Saurs', NULL, NULL, NULL, '7c8a641676c0c5e3cb37ca26e8c8f3233d11d802', NULL, NULL, NULL, NULL, 3, NULL, 816, NULL, 1),
(816, 'Savages', NULL, NULL, NULL, '7a9992e04a8db0cea22620f924a2e59ac633a1f7', NULL, NULL, NULL, NULL, 3, NULL, 817, NULL, 1),
(817, 'The Schizophonics', NULL, NULL, NULL, '7c7bc065debabb32d2a52df1669b6cd495678c25', NULL, NULL, NULL, NULL, 3, NULL, 818, NULL, 1),
(818, 'Screaming Females', NULL, NULL, NULL, 'ae38d9f482c76c3a98088c193139f7fc44317fb7', NULL, NULL, NULL, NULL, 3, NULL, 819, NULL, 1),
(819, 'Screaming Trees', NULL, NULL, NULL, '19d63e57d870cfdceb293e1d0dface36c25f3c2c', NULL, NULL, NULL, NULL, 3, NULL, 820, NULL, 1),
(820, 'Sea Ghost', NULL, NULL, NULL, '8dc5254af91c33180c13af79626022c3032a4126', NULL, NULL, NULL, NULL, 3, NULL, 821, NULL, 1),
(821, 'Seapony', NULL, NULL, NULL, '6c0037d0d364b499bcd571222184b8825503059b', NULL, NULL, NULL, NULL, 3, NULL, 822, NULL, 1),
(822, 'Sebadoh', NULL, NULL, NULL, 'd88cbcb8b0737b32d75a5168755496dae54685e0', NULL, NULL, NULL, NULL, 3, NULL, 823, NULL, 1),
(823, 'The Seeds', NULL, NULL, NULL, '3958782e1a75faa69231860e55aaab412373d4c7', NULL, NULL, NULL, NULL, 3, NULL, 824, NULL, 1),
(824, 'The Selecter', NULL, NULL, NULL, '11a830c0cf23fcfe438c88d5988fb5a787c60fa7', NULL, NULL, NULL, NULL, 3, NULL, 825, NULL, 1),
(825, 'The Sex Organs', NULL, NULL, NULL, '29161a21a12b5953546b78fc8d82390c89443a54', NULL, NULL, NULL, NULL, 3, NULL, 826, NULL, 1),
(826, 'Sexteto Irreal', NULL, NULL, NULL, '1d35ad1462f1657adc68866f36534ef464b62c3d', NULL, NULL, NULL, NULL, 3, NULL, 827, NULL, 1),
(827, 'Shake Some Action!', NULL, NULL, NULL, 'dbe11409e8be24bb7c8bdb6b811155bed8415f88', NULL, NULL, NULL, NULL, 3, NULL, 828, NULL, 1),
(828, 'Shaman y Los Hombres en llamas', NULL, NULL, NULL, 'e21f280b2d83cc826a63ef5b678eeb2a25801b90', NULL, NULL, NULL, NULL, 3, NULL, 829, NULL, 1),
(829, 'Shaman y Los Pilares de la creacion', NULL, NULL, NULL, 'bc1225ff325f350a936373a78dd207b509ae3597', NULL, NULL, NULL, NULL, 3, NULL, 830, NULL, 1),
(830, 'Shame', NULL, NULL, NULL, 'd4fe3c3fa720d556788fc7a228be55ac3d5e7587', NULL, NULL, NULL, NULL, 3, NULL, 831, NULL, 1),
(831, 'Shapes', NULL, NULL, NULL, 'baadf85423128ccf65b89d7c5f6adc97b5ff0008', NULL, NULL, NULL, NULL, 3, NULL, 832, NULL, 1),
(832, 'The Shivas', NULL, NULL, NULL, '954d60fbec2c5c1ac41100e115194929d8bfd441', NULL, NULL, NULL, NULL, 3, NULL, 833, NULL, 1),
(833, 'Shonen Knife', NULL, NULL, NULL, 'bf4a2b15249bf271ed0a747e8f3dad7b4b969800', NULL, NULL, NULL, NULL, 3, NULL, 834, NULL, 1),
(834, 'Shoot Me Wendy', NULL, NULL, NULL, '42984a8e2850bbe640fa32796d455af0995cefc9', NULL, NULL, NULL, NULL, 3, NULL, 835, NULL, 1),
(835, 'Sibyl Vane', NULL, NULL, NULL, '70c19667d674bf24d34610911085450da6047ec8', NULL, NULL, NULL, NULL, 3, NULL, 836, NULL, 1),
(836, 'Sierra Leona', NULL, NULL, NULL, '256e9022f1aa7a7465fe097c07d7c0916e142d68', NULL, NULL, NULL, NULL, 3, NULL, 837, NULL, 1),
(837, 'Sigur Rós', NULL, NULL, NULL, '080cf71c6682b28ce27813dee885fc484c15a676', NULL, NULL, NULL, NULL, 3, NULL, 838, NULL, 1),
(838, 'The Silhouettes', NULL, NULL, NULL, 'f07ac0e791abc992dac91f8ddedc4e0a03d235bc', NULL, NULL, NULL, NULL, 3, NULL, 839, NULL, 1),
(839, 'Siouxsie and the Banshees', NULL, NULL, NULL, '51ce3375de1a091b89278f08bc7f46e73595cb77', NULL, NULL, NULL, NULL, 3, NULL, 840, NULL, 1),
(840, 'Sistemática', NULL, NULL, NULL, 'd18f3edb0da63238f7b5fbc30693791efb2474e6', NULL, NULL, NULL, NULL, 3, NULL, 841, NULL, 1),
(841, 'The Skatalites', NULL, NULL, NULL, '3915b2e285fc5c80a50a4875ed7521b33eb5e7c2', NULL, NULL, NULL, NULL, 3, NULL, 842, NULL, 1),
(842, 'Sketch Jets', NULL, NULL, NULL, '20035494eb91e4e85bed1bf9b9a3a4c7890a537f', NULL, NULL, NULL, NULL, 3, NULL, 843, NULL, 1),
(843, 'Slint', NULL, NULL, NULL, '2273e6918d0ec1403c5ab438867dcfa2c7d22985', NULL, NULL, NULL, NULL, 3, NULL, 844, NULL, 1),
(844, 'Slowdive', NULL, NULL, NULL, '5d58e933a5a93dcb7525758334dffcd37528d087', NULL, NULL, NULL, NULL, 3, NULL, 845, NULL, 1),
(845, 'The Smashing Pumpkins', NULL, NULL, NULL, 'efc5007831170844e1d7c441cd069130e7efe743', NULL, NULL, NULL, NULL, 3, NULL, 846, NULL, 1),
(846, 'The Smiths', NULL, NULL, NULL, 'c2155ff61d166c4b8a365e1f21e27d77ba0c8a78', NULL, NULL, NULL, NULL, 3, NULL, 847, NULL, 1),
(847, 'The Smoggers', NULL, NULL, NULL, '9b047f74592e06dec6b60d769631d06211b6ec91', NULL, NULL, NULL, NULL, 3, NULL, 848, NULL, 1),
(848, 'The Smudjas', NULL, NULL, NULL, '6c7978fca67715175e8d0e4dd895f29621f7cf77', NULL, NULL, NULL, NULL, 3, NULL, 849, NULL, 1),
(849, 'The Soap Opera', NULL, NULL, NULL, 'd217808155f2ccd8e5d0615bdce323d7c4633fc5', NULL, NULL, NULL, NULL, 3, NULL, 850, NULL, 1),
(850, 'The Soft Moon', NULL, NULL, NULL, 'f6627e53eb82e53a620d2c8c9aa17c4b574988e0', NULL, NULL, NULL, NULL, 3, NULL, 851, NULL, 1),
(851, 'Somos una triste', NULL, NULL, NULL, '8654b7a655cc84200ca6e49f2c2e8c60b97dad5f', NULL, NULL, NULL, NULL, 3, NULL, 852, NULL, 1),
(852, 'Son and The Holy Ghosts', NULL, NULL, NULL, '1abc1fe1afcd8389481802d91d3968d87d59c22e', NULL, NULL, NULL, NULL, 3, NULL, 853, NULL, 1),
(853, 'Sonic Youth', NULL, NULL, NULL, 'e5e30000c4f7c893777f0e0ef09de43a02d2becb', NULL, NULL, NULL, NULL, 3, NULL, 854, NULL, 1),
(854, 'The Sonics', NULL, NULL, NULL, '4a16e8df87b21f01904111afffc653aba15b03e1', NULL, NULL, NULL, NULL, 3, NULL, 855, NULL, 1),
(855, 'Sonny Rollins', NULL, NULL, NULL, 'f7756164827d5833c5510e0226c703f699e4bdd4', NULL, NULL, NULL, NULL, 3, NULL, 856, NULL, 1),
(856, 'Soul Syndicate', NULL, NULL, NULL, '08a587b5ff9856a78b9add8b86cd014d4f72531f', NULL, NULL, NULL, NULL, 3, NULL, 857, NULL, 1),
(857, 'Soviet Soviet', NULL, NULL, NULL, 'df09861bb0187eb3502a832ac2f3cf73ea7cb7fa', NULL, NULL, NULL, NULL, 3, NULL, 858, NULL, 1),
(858, 'Spacemen 3', NULL, NULL, NULL, 'fbe35fe70c3ac91bf83d4b64ba1b5f7f26adb7f7', NULL, NULL, NULL, NULL, 3, NULL, 859, NULL, 1),
(859, 'Sparklehorse', NULL, NULL, NULL, '5951e6a8193d3f6066a321b2edf3aef5b3feb16a', NULL, NULL, NULL, NULL, 3, NULL, 860, NULL, 1),
(860, 'The Specials', NULL, NULL, NULL, 'd5c0e5b8dfdb7402dbb6169c61a2cecd0d11e9ea', NULL, NULL, NULL, NULL, 3, NULL, 861, NULL, 1),
(861, 'Spencer Davis Group', NULL, NULL, NULL, 'f5cf4cfc0797cc70a0127362a13192c310b28908', NULL, NULL, NULL, NULL, 3, NULL, 862, NULL, 1),
(862, 'Spienetta', NULL, NULL, NULL, '03e549d5018663f86edfd3a0d0a8a6fb8e192cdd', NULL, NULL, NULL, NULL, 3, NULL, 863, NULL, 1),
(863, 'Spientta', NULL, NULL, NULL, '1f8a700ae6c559562554ef7f4e25410839e03498', NULL, NULL, NULL, NULL, 3, NULL, 864, NULL, 1),
(864, 'Spinetta', NULL, NULL, NULL, 'e71f47303cc3833872dee11fcda5fe77fea5e3aa', NULL, NULL, NULL, NULL, 3, NULL, 865, NULL, 1),
(865, 'Spinetta y Los socios del desierto', NULL, NULL, NULL, '2b14541407873e070f3bc5c198cc4fd4aa63ede6', NULL, NULL, NULL, NULL, 3, NULL, 866, NULL, 1),
(866, 'The Spinto Band', NULL, NULL, NULL, 'af8afa780ff3177460587206741e4060db56a3c0', NULL, NULL, NULL, NULL, 3, NULL, 867, NULL, 1),
(867, 'Spoon', NULL, NULL, NULL, '1bb9939ca84f6a2fd3357f3ce8c19433fa26261e', NULL, NULL, NULL, NULL, 3, NULL, 868, NULL, 1),
(868, 'SPORTS', NULL, NULL, NULL, '0f0c631c1f17bbcf0e2ec3a853b0fbd776ab6b64', NULL, NULL, NULL, NULL, 3, NULL, 869, NULL, 1),
(869, 'Sr Tomate', NULL, NULL, NULL, '84abc3dec84108a978de1e9242c764268b7d0d01', NULL, NULL, NULL, NULL, 3, NULL, 870, NULL, 1),
(870, 'Srta. Trueno Negro', NULL, NULL, NULL, 'b364fe73c666d3ad0a41e893a22630c7a10d07e0', NULL, NULL, NULL, NULL, 3, NULL, 871, NULL, 1),
(871, 'Stanley Beckford', NULL, NULL, NULL, 'e8c4a07d64d01e89cde82062dc64f0b71e70b34a', NULL, NULL, NULL, NULL, 3, NULL, 872, NULL, 1),
(872, 'The Stargazer Lilies', NULL, NULL, NULL, '83635b4c5d9454f49408d224c027acd768d4157f', NULL, NULL, NULL, NULL, 3, NULL, 873, NULL, 1),
(873, 'Stephane  Grapelli', NULL, NULL, NULL, 'a5d7173089614bcdbf5dd3952624fddbedc2eaa0', NULL, NULL, NULL, NULL, 3, NULL, 874, NULL, 1),
(874, 'Stephane Grapelli', NULL, NULL, NULL, '0b6da49bec02585dfe6a51e0381fc58804937551', NULL, NULL, NULL, NULL, 3, NULL, 875, NULL, 1),
(875, 'Stephen Malkmus', NULL, NULL, NULL, '74dd035dee21f711d2c3124fa5eef9db888f7f17', NULL, NULL, NULL, NULL, 3, NULL, 876, NULL, 1),
(876, 'Stephen Malkmus & the Jicks', NULL, NULL, NULL, '3ba638c0e191946f62469818e1b7dbe17b30d98e', NULL, NULL, NULL, NULL, 3, NULL, 877, NULL, 1),
(877, 'Stereophonics', NULL, NULL, NULL, 'ba9440a2f7e523952b7d25432d801885063263fc', NULL, NULL, NULL, NULL, 3, NULL, 878, NULL, 1),
(878, 'Sterophonics', NULL, NULL, NULL, '96becf2c73bbf0448aadc6a8f979f0eacff96c45', NULL, NULL, NULL, NULL, 3, NULL, 879, NULL, 1),
(879, 'Stiv Bators', NULL, NULL, NULL, 'e78a83fae2d930fcc2ed62a64e30c47555ffde96', NULL, NULL, NULL, NULL, 3, NULL, 880, NULL, 1),
(880, 'The Stone Roses', NULL, NULL, NULL, '47fbf5f5f27d5c6c31ca0bb1c04bb504cb991116', NULL, NULL, NULL, NULL, 3, NULL, 881, NULL, 1),
(881, 'Stone Temple Pilots', NULL, NULL, NULL, 'bdc0335e356540993cd2d0f0060a3caabfb2a242', NULL, NULL, NULL, NULL, 3, NULL, 882, NULL, 1),
(882, 'Stoneage Hearts', NULL, NULL, NULL, 'cb0385b2ed65885e7232acb629b2059f6b0c260f', NULL, NULL, NULL, NULL, 3, NULL, 883, NULL, 1),
(883, 'The Stooges', NULL, NULL, NULL, 'cef73956b704ecd8b101f2a0c28f0a883d389c6c', NULL, NULL, NULL, NULL, 3, NULL, 884, NULL, 1),
(884, 'The Stranglers', NULL, NULL, NULL, '4d0681a4443a16877d682dac70a450fa9f38613b', NULL, NULL, NULL, NULL, 3, NULL, 885, NULL, 1),
(885, 'Stray Cats', NULL, NULL, NULL, '354941128bdd1a76733506f698b5d3226fa31f71', NULL, NULL, NULL, NULL, 3, NULL, 886, NULL, 1),
(886, 'The Strokes', NULL, NULL, NULL, 'fbe1b747eaf48d8dea07df297ba7669dc86c08f3', NULL, NULL, NULL, NULL, 3, NULL, 887, NULL, 1),
(887, 'The Strypes', NULL, NULL, NULL, '1c18170f6a18d4db07e73934a72ed532ef5167dd', NULL, NULL, NULL, NULL, 3, NULL, 888, NULL, 1),
(888, 'Stuka and the fusers', NULL, NULL, NULL, '9d6e6bbe555b265ae7c37a2cf0a133a4b3ce0f4a', NULL, NULL, NULL, NULL, 3, NULL, 889, NULL, 1),
(889, 'Suarez', NULL, NULL, NULL, '61ae39898e81d30a8073bfda7cb077741f57856f', NULL, NULL, NULL, NULL, 3, NULL, 890, NULL, 1),
(890, 'Sub Pop 200', NULL, NULL, NULL, '53036fa9eca2a3a96aa7686da6be5ba16a674178', NULL, NULL, NULL, NULL, 3, NULL, 891, NULL, 1),
(891, 'Sue Mon Mont', NULL, NULL, NULL, 'be47f5df010d3a1c015b7a236c058236b5cdd1af', NULL, NULL, NULL, NULL, 3, NULL, 892, NULL, 1),
(892, 'Suede', NULL, NULL, NULL, 'da8a4ae362d6242f722459148f37482ee26b046d', NULL, NULL, NULL, NULL, 3, NULL, 893, NULL, 1),
(893, 'Sufjan Stevens', NULL, NULL, NULL, 'ec42b427701542f6208b662525ebe961e9a8fb18', NULL, NULL, NULL, NULL, 3, NULL, 894, NULL, 1),
(894, 'Sugar Minott', NULL, NULL, NULL, 'f4f26b6332119c794a113fdfaa8ac6b17fe7bacc', NULL, NULL, NULL, NULL, 3, NULL, 895, NULL, 1),
(895, 'Sun Ra', NULL, NULL, NULL, '21bca499e9395f2ebffa60337a1cced5dbe784cc', NULL, NULL, NULL, NULL, 3, NULL, 896, NULL, 1),
(896, 'The Sundays', NULL, NULL, NULL, '5840c440db9325f3e651bc120e91c8a6470bcfb5', NULL, NULL, NULL, NULL, 3, NULL, 897, NULL, 1),
(897, 'The Sunshine Underground', NULL, NULL, NULL, '261cf127ff57756f80f6037bb6ddeff228fa7591', NULL, NULL, NULL, NULL, 3, NULL, 898, NULL, 1),
(898, 'Supergrass', NULL, NULL, NULL, '394b29886f4bf6f60f4e672966b1996a229c56ad', NULL, NULL, NULL, NULL, 3, NULL, 899, NULL, 1),
(899, 'Superpiba', NULL, NULL, NULL, '065e7baae02076cbc855ffff8205ad642ca3710e', NULL, NULL, NULL, NULL, 3, NULL, 900, NULL, 1),
(900, 'Surfing Maradonas', NULL, NULL, NULL, '8c69009f8825592bb5e49d61b0dd79688397a6ff', NULL, NULL, NULL, NULL, 3, NULL, 901, NULL, 1),
(901, 'Syd Barret', NULL, NULL, NULL, '71e5b5e4a1efb859d143ff296aaa9f664dbdb6b4', NULL, NULL, NULL, NULL, 3, NULL, 902, NULL, 1),
(902, 'Takeshi Terauchi', NULL, NULL, NULL, '559a66f508b888bfbaf252adc645b881da6e9c8b', NULL, NULL, NULL, NULL, 3, NULL, 903, NULL, 1),
(903, 'Talking Heads', NULL, NULL, NULL, '72cbfb166761684c362ed9eb54affd209813b87d', NULL, NULL, NULL, NULL, 3, NULL, 904, NULL, 1),
(904, 'Tame Impala', NULL, NULL, NULL, '0fab64b22c2e3998e2fa3e05e8fa9314442377d9', NULL, NULL, NULL, NULL, 3, NULL, 905, NULL, 1),
(905, 'The Tandooris', NULL, NULL, NULL, '3fa885a00106e8f9c8b159f76598fd24d9a343ff', NULL, NULL, NULL, NULL, 3, NULL, 906, NULL, 1),
(906, 'Tanguito', NULL, NULL, NULL, 'e19286304a9eaaedb4870a9ee1395a4e9c76f9ff', NULL, NULL, NULL, NULL, 3, NULL, 907, NULL, 1),
(907, 'Tantor', NULL, NULL, NULL, '69471696d19809ed26dc403e1467f7fa4eea8c58', NULL, NULL, NULL, NULL, 3, NULL, 908, NULL, 1),
(908, 'Tape Waves', NULL, NULL, NULL, '7b03169ba23b54d5f092d66dd6a589357832a63d', NULL, NULL, NULL, NULL, 3, NULL, 909, NULL, 1),
(909, 'The Techniques', NULL, NULL, NULL, '7a856c9c16c58e9630901aae51e7824ecf78a028', NULL, NULL, NULL, NULL, 3, NULL, 910, NULL, 1),
(910, 'Teenage Fanclub', NULL, NULL, NULL, '6727c1aa88fce9b579b43f45768423eda8f61666', NULL, NULL, NULL, NULL, 3, NULL, 911, NULL, 1),
(911, 'Teenagers', NULL, NULL, NULL, '7fba5070902d012e965ca940ab0f5fd7f9d7fb69', NULL, NULL, NULL, NULL, 3, NULL, 912, NULL, 1),
(912, 'Tegan And Sara', NULL, NULL, NULL, 'dcc2732670faca2935a2945e464b02aa9d1e2e0c', NULL, NULL, NULL, NULL, 3, NULL, 913, NULL, 1),
(913, 'Telescopios', NULL, NULL, NULL, '820c6474303be339e1f2b78b53fe5190e1151934', NULL, NULL, NULL, NULL, 3, NULL, 914, NULL, 1),
(914, 'Television', NULL, NULL, NULL, 'e1334c647fbaa10c6dfd6931858f2d60491b1257', NULL, NULL, NULL, NULL, 3, NULL, 915, NULL, 1),
(915, 'Temples', NULL, NULL, NULL, '016d9a0e9c539ea60f09f78788231d89996c861e', NULL, NULL, NULL, NULL, 3, NULL, 916, NULL, 1),
(916, 'Temporada de tormentas', NULL, NULL, NULL, 'c27679f6ad95dd60bf028189699f074218ede0fd', NULL, NULL, NULL, NULL, 3, NULL, 917, NULL, 1),
(917, 'Tenpole Tudor', NULL, NULL, NULL, '578cb07fc6318ccd6503d43b2dcd4b6c266774dd', NULL, NULL, NULL, NULL, 3, NULL, 918, NULL, 1),
(918, 'La Teoría del Caos', NULL, NULL, NULL, '1cecbe5af8219349b457d316b7b274d728b3a5bc', NULL, NULL, NULL, NULL, 3, NULL, 919, NULL, 1),
(919, 'The Termites', NULL, NULL, NULL, '184140eb0821075b9f0ff9cfc4201a61de43f6b5', NULL, NULL, NULL, NULL, 3, NULL, 920, NULL, 1),
(920, 'Thee Boas', NULL, NULL, NULL, '25686a8c908682b044c0c9c4421b200f2d3c6939', NULL, NULL, NULL, NULL, 3, NULL, 921, NULL, 1),
(921, 'Thee Brandy Hips', NULL, NULL, NULL, 'afe850aebc07decdbce2df04cedc573232e9c8dd', NULL, NULL, NULL, NULL, 3, NULL, 922, NULL, 1),
(922, 'Thee Fine Lines', NULL, NULL, NULL, 'b865ee01932f7ffe2fc14e85775783b02a41e38b', NULL, NULL, NULL, NULL, 3, NULL, 923, NULL, 1),
(923, 'Thee Headcoats', NULL, NULL, NULL, 'f9847837df7728daaeb155732b9980ec04b2ba86', NULL, NULL, NULL, NULL, 3, NULL, 924, NULL, 1),
(924, 'Thee Mighty Caesars', NULL, NULL, NULL, '11a08886e33f95419269b97c5de50cf31a7cde1d', NULL, NULL, NULL, NULL, 3, NULL, 925, NULL, 1),
(925, 'Thee Oh Sees', NULL, NULL, NULL, 'eea469a59accb63f9493373db30916228e503e13', NULL, NULL, NULL, NULL, 3, NULL, 926, NULL, 1),
(926, 'Thelefon', NULL, NULL, NULL, 'e820e1b5d4bab2cc4d2e828cc513fec2e5b16ce4', NULL, NULL, NULL, NULL, 3, NULL, 927, NULL, 1),
(927, 'Thelonious Monk', NULL, NULL, NULL, 'c586d1adf2db1b0cf3da64c8cf109f4a1e043c1f', NULL, NULL, NULL, NULL, 3, NULL, 928, NULL, 1),
(928, 'Thes Siniestros', NULL, NULL, NULL, 'de33ef4a9d9a8f3361f2af16ece9f32a09016a0e', NULL, NULL, NULL, NULL, 3, NULL, 929, NULL, 1),
(929, 'Thin Lizzy', NULL, NULL, NULL, 'cc7ea6e470d6b46959649977a2b695248b1e36da', NULL, NULL, NULL, NULL, 3, NULL, 930, NULL, 1),
(930, 'Thurston Moore', NULL, NULL, NULL, '2f8f4c1bfec8261b942e597acab0f0f1ad9d1495', NULL, NULL, NULL, NULL, 3, NULL, 931, NULL, 1),
(931, 'Tigers Jaw', NULL, NULL, NULL, 'e19b01f5714ac1c4198f0ed88dd40a425e129146', NULL, NULL, NULL, NULL, 3, NULL, 932, NULL, 1),
(932, 'Tigres Leones', NULL, NULL, NULL, '0863ea03d80dd6ee6b15fdc1dc546b1db2a636ed', NULL, NULL, NULL, NULL, 3, NULL, 933, NULL, 1),
(933, 'Tijuana Panthers', NULL, NULL, NULL, 'f9fc1092b360c81577a01453f0039d68dae2143b', NULL, NULL, NULL, NULL, 3, NULL, 934, NULL, 1),
(934, 'The Tills', NULL, NULL, NULL, 'f75ff54944061020961a397916e1e3bbfe586084', NULL, NULL, NULL, NULL, 3, NULL, 935, NULL, 1),
(935, 'Tinariwen', NULL, NULL, NULL, 'e1e163d03abfe9f3781d3c845b3eaa565e4e5040', NULL, NULL, NULL, NULL, 3, NULL, 936, NULL, 1),
(936, 'Tindersticks', NULL, NULL, NULL, 'bda8bd1060417919d5c8ee7139cf307505977516', NULL, NULL, NULL, NULL, 3, NULL, 937, NULL, 1),
(937, 'The Toasters', NULL, NULL, NULL, '134fb289beaadd7148287f9df84df1a9c52eb591', NULL, NULL, NULL, NULL, 3, NULL, 938, NULL, 1),
(938, 'Tobogán Andaluz', NULL, NULL, NULL, '2f290b1a72cbc43854c9b9ea61607a156aef2989', NULL, NULL, NULL, NULL, 3, NULL, 939, NULL, 1),
(939, 'todos los rayos', NULL, NULL, NULL, 'a03872de3f558283328e60c7cca46a6b7e7df4a8', NULL, NULL, NULL, NULL, 3, NULL, 940, NULL, 1),
(940, 'Todos son Culpables', NULL, NULL, NULL, '92d28bf38c5860a1b23d7cbc7442f172e46d1f5c', NULL, NULL, NULL, NULL, 3, NULL, 941, NULL, 1),
(941, 'Tom Waits', NULL, NULL, NULL, '5f7248788f64719a1da5bee2eb5560dc20845693', NULL, NULL, NULL, NULL, 3, NULL, 942, NULL, 1),
(942, 'Tom y La Bestia Bebe', NULL, NULL, NULL, 'f8e149f970474e34f03c915a4ee5a9f206d13763', NULL, NULL, NULL, NULL, 3, NULL, 943, NULL, 1),
(943, 'Tommy McCook & Bobby Ellis', NULL, NULL, NULL, 'ecd413e7947c54e2b46b228b1d53b707748e5209', NULL, NULL, NULL, NULL, 3, NULL, 944, NULL, 1),
(944, 'Tommy McCook & The Supersonics', NULL, NULL, NULL, '83a23fa3699dbe47607868d57b29094a6d420850', NULL, NULL, NULL, NULL, 3, NULL, 945, NULL, 1),
(945, 'Tónicos', NULL, NULL, NULL, '9bc3d29652bcaa8f0afa649d84ed0384359b8894', NULL, NULL, NULL, NULL, 3, NULL, 946, NULL, 1),
(946, 'Tony Allen', NULL, NULL, NULL, 'f5af64e2ec887ef77f786740614b06b517f6a36c', NULL, NULL, NULL, NULL, 3, NULL, 947, NULL, 1),
(947, 'Toots and The Maytals', NULL, NULL, NULL, 'c96eaec5d2554ab2438086dddf1a41976270eed5', NULL, NULL, NULL, NULL, 3, NULL, 948, NULL, 1),
(948, 'The Tormentos', NULL, NULL, NULL, 'f74e1d57d207f0c1c41251b161b06b6daa9accfb', NULL, NULL, NULL, NULL, 3, NULL, 949, NULL, 1),
(949, 'Totorro', NULL, NULL, NULL, '7dbf3f993a5977caa41bf6983d1b43b6ff90138f', NULL, NULL, NULL, NULL, 3, NULL, 950, NULL, 1),
(950, 'Tourista', NULL, NULL, NULL, 'b579216f39da51d15f4fc17d74d5dc68e80aefee', NULL, NULL, NULL, NULL, 3, NULL, 951, NULL, 1),
(951, 'Tradition', NULL, NULL, NULL, '03ccd4d45e73af5a94ae357604bb0cc4e7ea2cca', NULL, NULL, NULL, NULL, 3, NULL, 952, NULL, 1),
(952, 'Train To Skaville 1960-1968', NULL, NULL, NULL, '6af8f873c6e3f2fcb58985389a7a42d11d8ecf5f', NULL, NULL, NULL, NULL, 3, NULL, 953, NULL, 1),
(953, 'Treepeople', NULL, NULL, NULL, 'e27ab06ece0c8b9d24eee342ab2603701a7a7b62', NULL, NULL, NULL, NULL, 3, NULL, 954, NULL, 1),
(954, 'Tributo a The Velvet Underground & Nico', NULL, NULL, NULL, '86d9cb2c237e9514d1b59ba4205a8610e33de08a', NULL, NULL, NULL, NULL, 3, NULL, 955, NULL, 1),
(955, 'Triptides', NULL, NULL, NULL, 'a86808623cd271765341fcf096cfa9036831965e', NULL, NULL, NULL, NULL, 3, NULL, 956, NULL, 1),
(956, 'The Troggs', NULL, NULL, NULL, 'e5e87e7fc86da0d456afecb8bdc10cd379260d85', NULL, NULL, NULL, NULL, 3, NULL, 957, NULL, 1),
(957, 'Trojan', NULL, NULL, NULL, '236fada97aa2ca01658e28a4be24ef17dfa5db9c', NULL, NULL, NULL, NULL, 3, NULL, 958, NULL, 1),
(958, 'Trojan Rude Boy Box Set', NULL, NULL, NULL, '26aa18697306c1b6c3306588a3b03814d6c63e95', NULL, NULL, NULL, NULL, 3, NULL, 959, NULL, 1),
(959, 'The Trojans', NULL, NULL, NULL, 'eae73b54c0ec26fdc7f56683a0ae12e3171aac72', NULL, NULL, NULL, NULL, 3, NULL, 960, NULL, 1),
(960, 'Truly', NULL, NULL, NULL, '44e8f83bfc4e8e10ed7e80c113446d158bae4e87', NULL, NULL, NULL, NULL, 3, NULL, 961, NULL, 1),
(961, 'Tryo', NULL, NULL, NULL, '3407a961e14e8d8cd0576674f9dd1791bbd8f6a5', NULL, NULL, NULL, NULL, 3, NULL, 962, NULL, 1),
(962, 'Turbonegro', NULL, NULL, NULL, '60638f7b2cc5b84d242fc85c772a807543b93601', NULL, NULL, NULL, NULL, 3, NULL, 963, NULL, 1),
(963, 'Tweens', NULL, NULL, NULL, '8e3ab11e92d4f08bd1454763f2dd688ef2ebfcb0', NULL, NULL, NULL, NULL, 3, NULL, 964, NULL, 1),
(964, 'Twin Peaks', NULL, NULL, NULL, '9fe67dd8139b6fa3f2ef1e297d8e7076d7f6cfe0', NULL, NULL, NULL, NULL, 3, NULL, 965, NULL, 1),
(965, 'Ty Segall', NULL, NULL, NULL, '85d9189b74abe2d48a9c2c6f845e2568be86c6db', NULL, NULL, NULL, NULL, 3, NULL, 966, NULL, 1),
(966, 'U Roy', NULL, NULL, NULL, '714e7b594c1825778e97566e38f154fb6e03b501', NULL, NULL, NULL, NULL, 3, NULL, 967, NULL, 1),
(967, 'U-Roy', NULL, NULL, NULL, 'fffb330de333d34e0cad8fafdeeedc6e1b967387', NULL, NULL, NULL, NULL, 3, NULL, 968, NULL, 1),
(968, 'Un día perfecto para el pez banana', NULL, NULL, NULL, '8755a551b0b50051584fd2af889f8865f0efb142', NULL, NULL, NULL, NULL, 3, NULL, 969, NULL, 1),
(969, 'Un Planeta', NULL, NULL, NULL, 'b81330037508f4c04fcea74336807e696cd3f51d', NULL, NULL, NULL, NULL, 3, NULL, 970, NULL, 1),
(970, 'The Undercover Hippy', NULL, NULL, NULL, 'e8aa14b65da58ade781ef416a93750c704bd55ca', NULL, NULL, NULL, NULL, 3, NULL, 971, NULL, 1),
(971, 'The Underground Youth', NULL, NULL, NULL, '35d43379d75d234f657062f669328d74c28d2818', NULL, NULL, NULL, NULL, 3, NULL, 972, NULL, 1),
(972, 'The Unicorns', NULL, NULL, NULL, '01d89f48df06d942b04879d14b941ab3bd4d75ab', NULL, NULL, NULL, NULL, 3, NULL, 973, NULL, 1),
(973, 'Univers', NULL, NULL, NULL, '86440af7a362a1339d9e48f827765290b7b18097', NULL, NULL, NULL, NULL, 3, NULL, 974, NULL, 1),
(974, 'Uno en la Luna', NULL, NULL, NULL, '2677b29ffa6baeec62cb13e1243a2a2a85c65f54', NULL, NULL, NULL, NULL, 3, NULL, 975, NULL, 1),
(975, 'The Upsetters', NULL, NULL, NULL, '806262dd7621fbd34ecd84afc65a550738bae6c2', NULL, NULL, NULL, NULL, 3, NULL, 976, NULL, 1),
(976, 'Usted Señalemelo', NULL, NULL, NULL, 'c0c8c9f0d01bf3ef5908c7e9f3bc081d5dc45c6f', NULL, NULL, NULL, NULL, 3, NULL, 977, NULL, 1),
(977, 'VA', NULL, NULL, NULL, 'b8627fad51527470622eca2ca24d3fac10eac247', NULL, NULL, NULL, NULL, 3, NULL, 978, NULL, 1),
(978, 'The Vaccines', NULL, NULL, NULL, 'fe13fe515559ee72ee7fbca0f086f024e2fd1ac0', NULL, NULL, NULL, NULL, 3, NULL, 979, NULL, 1),
(979, 'Valentin y Los Volcanes', NULL, NULL, NULL, 'bce25ed44a9d80df380245a5a4fa730ebbf9b817', NULL, NULL, NULL, NULL, 3, NULL, 980, NULL, 1),
(980, 'Valise', NULL, NULL, NULL, 'ec85b9548417dbdc748d371d0b30c5ee770aa7a3', NULL, NULL, NULL, NULL, 3, NULL, 981, NULL, 1),
(981, 'The Valkyrians', NULL, NULL, NULL, '64b10461fe8e320171761d703b11049336bbad67', NULL, NULL, NULL, NULL, 3, NULL, 982, NULL, 1),
(982, 'Valle de Muñecas', NULL, NULL, NULL, '993901bd3641da0f52e73f1e6b245ce7eac35d47', NULL, NULL, NULL, NULL, 3, NULL, 983, NULL, 1),
(983, 'Valles', NULL, NULL, NULL, '576cc4bf65ba0b580938bf80cfbd2445e49bde74', NULL, NULL, NULL, NULL, 3, NULL, 984, NULL, 1),
(984, 'Vampire Weekend', NULL, NULL, NULL, '73e90d7249b810aac416c8daf4143a7ef46b4ff7', NULL, NULL, NULL, NULL, 3, NULL, 985, NULL, 1),
(985, 'The Vampires', NULL, NULL, NULL, '7eb436b1e49c8a0baf6130f33be21743b104764e', NULL, NULL, NULL, NULL, 3, NULL, 986, NULL, 1),
(986, 'Van Morrison', NULL, NULL, NULL, '679d1f5ae4918dd5468e1f2b0e5cf806d41910d5', NULL, NULL, NULL, NULL, 3, NULL, 987, NULL, 1),
(987, 'Various', NULL, NULL, NULL, 'b7bb3ac02e5c79d8044d0a3151e2bc7cf9b97dc1', NULL, NULL, NULL, NULL, 3, NULL, 988, NULL, 1),
(988, 'various artists', NULL, NULL, NULL, '9e74903dd10278d3d9e2033295137287bb5d262e', NULL, NULL, NULL, NULL, 3, NULL, 989, NULL, 1),
(989, 'The Vaselines', NULL, NULL, NULL, '90d145526a3ff551ee9af600cff09ae46d763153', NULL, NULL, NULL, NULL, 3, NULL, 990, NULL, 1),
(990, 'The Velvet Underground', NULL, NULL, NULL, '5f62c4ac8ade763d52309f738ed6c26613808517', NULL, NULL, NULL, NULL, 3, NULL, 991, NULL, 1),
(991, 'La Venganza de Cheetara', NULL, NULL, NULL, 'f86307f5d7ddd2ee1d22731256bb3556df9b3293', NULL, NULL, NULL, NULL, 3, NULL, 992, NULL, 1),
(992, 'The Ventures', NULL, NULL, NULL, '8098ddd5d93d32de743012b29d3c347644673e44', NULL, NULL, NULL, NULL, 3, NULL, 993, NULL, 1),
(993, 'The Vermin Poets', NULL, NULL, NULL, '91bb4fc97df1ab1d52d07633a2ed6b673f071607', NULL, NULL, NULL, NULL, 3, NULL, 994, NULL, 1),
(994, 'Veronica Falls', NULL, NULL, NULL, 'f763aacade6922b2a8b291a88ada1f05a8abce22', NULL, NULL, NULL, NULL, 3, NULL, 995, NULL, 1),
(995, 'The Verve', NULL, NULL, NULL, 'fcdcf107a505bf86287a6fffcd2223cf7b7a0262', NULL, NULL, NULL, NULL, 3, NULL, 996, NULL, 1),
(996, 'Vetiver', NULL, NULL, NULL, 'bb72d30de7d4d90852b189c73c62ad87d37e8c4e', NULL, NULL, NULL, NULL, 3, NULL, 997, NULL, 1),
(997, 'Viajes', NULL, NULL, NULL, '971c3d4ab5355a3796e57bed7fd8e804a0647aa8', NULL, NULL, NULL, NULL, 3, NULL, 998, NULL, 1),
(998, 'The Viceroys', NULL, NULL, NULL, '764d5ff829186f879ef26f9082741f8c4d025d2d', NULL, NULL, NULL, NULL, 3, NULL, 999, NULL, 1),
(999, 'Victoria Mil', NULL, NULL, NULL, '73f7dae3cc8ae44bd13696228ade1d7b97f31f0b', NULL, NULL, NULL, NULL, 3, NULL, 1000, NULL, 1),
(1000, 'Villelisa', NULL, NULL, NULL, '9fc1f1046c0f94fbd10aefd8dc32fae0156d0fbd', NULL, NULL, NULL, NULL, 3, NULL, 1001, NULL, 1),
(1001, 'Violent Femmes', NULL, NULL, NULL, '5e6c58a38d3295813e1f557bc078fa9b0e8765fb', NULL, NULL, NULL, NULL, 3, NULL, 1002, NULL, 1),
(1002, 'The Violets', NULL, NULL, NULL, 'dc9c48eb6a1fcc8ea967fb391c35a68b648dfb6d', NULL, NULL, NULL, NULL, 3, NULL, 1003, NULL, 1),
(1003, 'The Virgins', NULL, NULL, NULL, 'c75487cf3b50ea923a5f1a8e5fa4ca25dff2d886', NULL, NULL, NULL, NULL, 3, NULL, 1004, NULL, 1),
(1004, 'Voltura', NULL, NULL, NULL, 'f5f7c264e52c71dc532af383fe268094fe3834f3', NULL, NULL, NULL, NULL, 3, NULL, 1005, NULL, 1),
(1005, 'The Von Bondies', NULL, NULL, NULL, '8202c0194b086b3ebcaac30330e55318c2f06372', NULL, NULL, NULL, NULL, 3, NULL, 1006, NULL, 1),
(1006, 'The Vonneguts', NULL, NULL, NULL, 'c89ce941107e2a41992ebd13a3da2ae35b00f0f1', NULL, NULL, NULL, NULL, 3, NULL, 1007, NULL, 1),
(1007, 'Vox Dei', NULL, NULL, NULL, 'eda9097fb86d1e367be949e727f70888c63194d7', NULL, NULL, NULL, NULL, 3, NULL, 1008, NULL, 1),
(1008, 'V?METRO', NULL, NULL, NULL, 'd6594af5d9280cca7660b8caff366b5935a18e65', NULL, NULL, NULL, NULL, 3, NULL, 1009, NULL, 1),
(1009, 'The Walkmen', NULL, NULL, NULL, '7df8553454fdcfa58b85b504f42c6c3c74d32ee6', NULL, NULL, NULL, NULL, 3, NULL, 1010, NULL, 1),
(1010, 'Walter Malosetti', NULL, NULL, NULL, 'de93848fa0ae86db86d387de15ac221088000ea7', NULL, NULL, NULL, NULL, 3, NULL, 1011, NULL, 1),
(1011, 'The Warlocks', NULL, NULL, NULL, '4d6dd1b6983b015f39b5653b53565129c916f319', NULL, NULL, NULL, NULL, 3, NULL, 1012, NULL, 1),
(1012, 'Warsaw', NULL, NULL, NULL, '340a22e20b02445a32bb607bb3c7b0ccbec94217', NULL, NULL, NULL, NULL, 3, NULL, 1013, NULL, 1),
(1013, 'Was is & always', NULL, NULL, NULL, '5e5369caabc40fea4b4aad3a45782ce294e8246c', NULL, NULL, NULL, NULL, 3, NULL, 1014, NULL, 1),
(1014, 'Wau y los Arrrghs!!!', NULL, NULL, NULL, '6cc23c44608c8f0dfba0bcf48a7c047ea8720013', NULL, NULL, NULL, NULL, 3, NULL, 1015, NULL, 1),
(1015, 'The Wave Pictures', NULL, NULL, NULL, 'c8542a0f93d42c4e3e247f5e403097119fea8432', NULL, NULL, NULL, NULL, 3, NULL, 1016, NULL, 1),
(1016, 'Wavves', NULL, NULL, NULL, '1b83c00df8b4d7a0d446dd09446d025b8b4cc5af', NULL, NULL, NULL, NULL, 3, NULL, 1017, NULL, 1),
(1017, 'Wavves X Cloud Nothings', NULL, NULL, NULL, 'c5bcc50a7f6301de93071d980505448f353a7d17', NULL, NULL, NULL, NULL, 3, NULL, 1018, NULL, 1),
(1018, 'Wayne Shorter', NULL, NULL, NULL, '553b72309fb6d5691466aea8c4921b3dd784ab4d', NULL, NULL, NULL, NULL, 3, NULL, 1019, NULL, 1),
(1019, 'Weaves', NULL, NULL, NULL, '2dccbe80d0447365f1761a52c66ce9059c3e2826', NULL, NULL, NULL, NULL, 3, NULL, 1020, NULL, 1),
(1020, 'The Wedding Present', NULL, NULL, NULL, 'fcab3896a832ad14ee59785c269cdab3d39a685a', NULL, NULL, NULL, NULL, 3, NULL, 1021, NULL, 1),
(1021, 'Weezer', NULL, NULL, NULL, '7ae880a69bb08a803d5e7239a2b938f30efd8997', NULL, NULL, NULL, NULL, 3, NULL, 1022, NULL, 1),
(1022, 'Wes Montgomery', NULL, NULL, NULL, '8723306f16e218fc9d9960bbb849ddf6524326f5', NULL, NULL, NULL, NULL, 3, NULL, 1023, NULL, 1),
(1023, 'White Hounds', NULL, NULL, NULL, 'b140b837960315744ea785e27a717d4eab953689', NULL, NULL, NULL, NULL, 3, NULL, 1024, NULL, 1),
(1024, 'White Lodge', NULL, NULL, NULL, 'f17c2e293c15f61f18592cd6328f7089b245f257', NULL, NULL, NULL, NULL, 3, NULL, 1025, NULL, 1),
(1025, 'The White Stripes', NULL, NULL, NULL, '69740fe4c60961c733512475f1686153cae3f81e', NULL, NULL, NULL, NULL, 3, NULL, 1026, NULL, 1),
(1026, 'Wilco', NULL, NULL, NULL, '8053019d31e8572d414ca634a19368c278595a7c', NULL, NULL, NULL, NULL, 3, NULL, 1027, NULL, 1),
(1027, 'Wild Raccoon', NULL, NULL, NULL, '894a2d0152a2892ffb50256409e155487341d57e', NULL, NULL, NULL, NULL, 3, NULL, 1028, NULL, 1),
(1028, 'Wild Wing', NULL, NULL, NULL, '86a3ca77fbf1830212c40301737222249b5e6ee5', NULL, NULL, NULL, NULL, 3, NULL, 1029, NULL, 1),
(1029, 'Willie Williams', NULL, NULL, NULL, '47de3e03150c0c01014b6b09b72b3dd8e28284af', NULL, NULL, NULL, NULL, 3, NULL, 1030, NULL, 1),
(1030, 'Wipers', NULL, NULL, NULL, '98ca423acc3d5749aec727737a85c7cd233f8988', NULL, NULL, NULL, NULL, 3, NULL, 1031, NULL, 1),
(1031, 'Wire', NULL, NULL, NULL, 'cd2c68bab2a3d513cb48e1bdf4353f652bec756a', NULL, NULL, NULL, NULL, 3, NULL, 1032, NULL, 1),
(1032, 'Wolf Parade', NULL, NULL, NULL, '72454174fb3751f716ce495c3c80178de7fd7c50', NULL, NULL, NULL, NULL, 3, NULL, 1033, NULL, 1),
(1033, 'Wooden Shjips', NULL, NULL, NULL, 'bb8aad45db9badd71a928ba0d8d03de389076247', NULL, NULL, NULL, NULL, 3, NULL, 1034, NULL, 1),
(1034, 'Woods', NULL, NULL, NULL, 'd7a3e848a1aedd7a11212f6b3c277a39fce261a0', NULL, NULL, NULL, NULL, 3, NULL, 1035, NULL, 1),
(1035, 'Woody Shaw', NULL, NULL, NULL, '5b4308cf6788c1e9b6d9784e61a25009ee7984a3', NULL, NULL, NULL, NULL, 3, NULL, 1036, NULL, 1),
(1036, 'WYLDLIFE', NULL, NULL, NULL, '81ed97aa713354f8ace0d580b637a277000172b7', NULL, NULL, NULL, NULL, 3, NULL, 1037, NULL, 1),
(1037, 'Wynton Marsalis', NULL, NULL, NULL, '2eee764f3a0fea354b07f23b72709757b582ac06', NULL, NULL, NULL, NULL, 3, NULL, 1038, NULL, 1),
(1038, 'X', NULL, NULL, NULL, '24928860e43eb4eef27c906479916ff6622175a4', NULL, NULL, NULL, NULL, 3, NULL, 1039, NULL, 1),
(1039, 'X-Ray Spex', NULL, NULL, NULL, '252ab472bbb142a4d81032a4101fe5f0b3d552a4', NULL, NULL, NULL, NULL, 3, NULL, 1040, NULL, 1),
(1040, 'The Yardbirds', NULL, NULL, NULL, '35c5239cc66f920ad261defefe4b52fc5b971c1e', NULL, NULL, NULL, NULL, 3, NULL, 1041, NULL, 1),
(1041, 'Yeah Yeah Yeahs', NULL, NULL, NULL, '2b99ad34ff6ae743b29224cdbb1a3f1f6d580d21', NULL, NULL, NULL, NULL, 3, NULL, 1042, NULL, 1),
(1042, 'Yo La Tengo', NULL, NULL, NULL, '24848977f09d09c4841e70e0109e7bd60acfb0fc', NULL, NULL, NULL, NULL, 3, NULL, 1043, NULL, 1),
(1043, 'Yuck', NULL, NULL, NULL, '10166c0f50ed1c60bd98e69bf2ea651064f89edc', NULL, NULL, NULL, NULL, 3, NULL, 1044, NULL, 1),
(1044, 'Zaino Overo', NULL, NULL, NULL, 'eb1b5fa11807f4056621bd6bf1fb6da7e1e1be93', NULL, NULL, NULL, NULL, 3, NULL, 1045, NULL, 1),
(1045, 'The Zombies', NULL, NULL, NULL, '270786ee4e9ad208157a46acc1b36edf2fd5d13a', NULL, NULL, NULL, NULL, 3, NULL, 1046, NULL, 1),
(1046, 'Loana', 'Salsati', NULL, NULL, NULL, 'osvaldo@gmail.com', NULL, NULL, NULL, NULL, NULL, 1047, NULL, 1),
(1047, 'Aerobluesss', NULL, NULL, NULL, 'e3841e58416a77492b54ac31f909289eb25b2d68', NULL, NULL, NULL, NULL, NULL, NULL, 1048, NULL, 1),
(1048, 'Bersuit', NULL, NULL, NULL, '52b3378a4560dd382bf4307a6bfd354b9025240f', NULL, NULL, NULL, NULL, NULL, NULL, 1049, NULL, 1),
(1049, 'Bersuit Vergarabat', NULL, NULL, NULL, '65b259cf02083a60a23e8bdf8216e34d44498364', NULL, NULL, NULL, NULL, NULL, NULL, 1050, NULL, 1),
(1050, 'El Cachote', NULL, NULL, NULL, '4dcded19b6b45c36a770afdc119ca5e7b12ce0ba', NULL, NULL, NULL, NULL, NULL, NULL, 1051, NULL, 1),
(1051, 'José Luis Perales', NULL, NULL, NULL, '35debfc9920be993838d1b5a0fe0663b8708fe33', NULL, NULL, NULL, NULL, NULL, NULL, 1052, NULL, 1),
(1052, 'Laion', NULL, NULL, NULL, '22a5732a65cbeadc2d59e9537bf39c53072a7d87', NULL, NULL, NULL, NULL, NULL, NULL, 1053, NULL, 1),
(1053, 'Modjo', NULL, NULL, NULL, 'a5d66d3cbe4b8f37e399c25117f0818190afca92', NULL, NULL, NULL, NULL, NULL, NULL, 1054, NULL, 1),
(1054, 'qwe qe', NULL, NULL, NULL, '2429bb752eb26ca3cbf66da1d691f54437b9656f', NULL, NULL, NULL, NULL, NULL, NULL, 1055, NULL, 1),
(1055, 'Rata Blanca', NULL, NULL, NULL, 'f47792f10bfff36e88631d6d36894a7b6f56b159', NULL, NULL, NULL, NULL, NULL, NULL, 1056, NULL, 1),
(1056, 'Sonata Arctica', NULL, NULL, NULL, 'db5cb7ec2e99be583c93e3ba0707db65a50a4333', NULL, NULL, NULL, NULL, NULL, NULL, 1057, NULL, 1),
(1060, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1061, NULL, 1),
(1061, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1062, NULL, 1),
(1062, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1063, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profileOpts`
--

CREATE TABLE `profileOpts` (
  `id` int(11) NOT NULL,
  `begin_date` tinyint(1) DEFAULT NULL,
  `instrument` tinyint(1) DEFAULT NULL,
  `presentation` tinyint(1) DEFAULT NULL,
  `full_name` tinyint(1) DEFAULT NULL,
  `birth_date` tinyint(1) DEFAULT NULL,
  `birth_location` tinyint(1) DEFAULT NULL,
  `phone` tinyint(1) DEFAULT NULL,
  `social` tinyint(1) DEFAULT '0',
  `gender` tinyint(1) DEFAULT NULL,
  `notification_check` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profileOpts`
--

INSERT INTO `profileOpts` (`id`, `begin_date`, `instrument`, `presentation`, `full_name`, `birth_date`, `birth_location`, `phone`, `social`, `gender`, `notification_check`) VALUES
(1, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(2, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(3, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(4, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(5, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(6, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(7, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(8, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(9, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(10, 1, NULL, 1, 1, 1, 1, 1, 1, 1, 1),
(11, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(12, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(13, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(14, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(15, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(16, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(17, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(18, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(19, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(20, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(21, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(22, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(23, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(24, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(25, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(26, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(27, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(28, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(29, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(30, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(31, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(32, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(33, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(34, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(35, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(36, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(37, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(38, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(39, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(40, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(41, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(42, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(43, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(44, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(45, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(46, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(47, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(48, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(49, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(50, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(51, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(52, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(53, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(54, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(55, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(56, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(57, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(58, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(59, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(60, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(61, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(62, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(63, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(64, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(65, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(66, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(67, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(68, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(69, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(70, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(71, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(72, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(73, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(74, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(75, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(76, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(77, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(78, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(79, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(80, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(81, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(82, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(83, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(84, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(85, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(86, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(87, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(88, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(89, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(90, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(91, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(92, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(93, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(94, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(95, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(96, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(97, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(98, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(99, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(100, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(101, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(102, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(103, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(104, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(105, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(106, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(107, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(108, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(109, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(110, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(111, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(112, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(113, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(114, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(115, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(116, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(117, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(118, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(119, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(120, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(121, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(122, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(123, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(124, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(125, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(126, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(127, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(128, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(129, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(130, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(131, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(132, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(133, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(134, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(135, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(136, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(137, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(138, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(139, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(140, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(141, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(142, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(143, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(144, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(145, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(146, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(147, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(148, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(149, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(150, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(151, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(152, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(153, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(154, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(155, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(156, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(157, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(158, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(159, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(160, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(161, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(162, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(163, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(164, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(165, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(166, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(167, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(168, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(169, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(170, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(171, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(172, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(173, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(174, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(175, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(176, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(177, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(178, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(179, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(180, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(181, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(182, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(183, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(184, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(185, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(186, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(187, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(188, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(189, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(190, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(191, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(192, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(193, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(194, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(195, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(196, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(197, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(198, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(199, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(200, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(201, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(202, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(203, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(204, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(205, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(206, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(207, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(208, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(209, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(210, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(211, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(212, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(213, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(214, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(215, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(216, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(217, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(218, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(219, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(220, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(221, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(222, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(223, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(224, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(225, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(226, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(227, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(228, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(229, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(230, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(231, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(232, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(233, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(234, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(235, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(236, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(237, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(238, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(239, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(240, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(241, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(242, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(243, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(244, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(245, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(246, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(247, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(248, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(249, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(250, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(251, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(252, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(253, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(254, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(255, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(256, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(257, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(258, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(259, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(260, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(261, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(262, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(263, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(264, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(265, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(266, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(267, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(268, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(269, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(270, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(271, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(272, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(273, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(274, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(275, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(276, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(277, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(278, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(279, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(280, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(281, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(282, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(283, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(284, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(285, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(286, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(287, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(288, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(289, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(290, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(291, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(292, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(293, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(294, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(295, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(296, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(297, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(298, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(299, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(300, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(301, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(302, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(303, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(304, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(305, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(306, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(307, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(308, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(309, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(310, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(311, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(312, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(313, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(314, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(315, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(316, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(317, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(318, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(319, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(320, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(321, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(322, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(323, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(324, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(325, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(326, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(327, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(328, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(329, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(330, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(331, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(332, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(333, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(334, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(335, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(336, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(337, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(338, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(339, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(340, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(341, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(342, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(343, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(344, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(345, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(346, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(347, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(348, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(349, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(350, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(351, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(352, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(353, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(354, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(355, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(356, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(357, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(358, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(359, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(360, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(361, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(362, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(363, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(364, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(365, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(366, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(367, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(368, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(369, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(370, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(371, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(372, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(373, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(374, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(375, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(376, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(377, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(378, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(379, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(380, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(381, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(382, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(383, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(384, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(385, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(386, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(387, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(388, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(389, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(390, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(391, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(392, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(393, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(394, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(395, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(396, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(397, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(398, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(399, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(400, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(401, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(402, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(403, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(404, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(405, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(406, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(407, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(408, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(409, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(410, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(411, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(412, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(413, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(414, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(415, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(416, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(417, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(418, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(419, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(420, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(421, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(422, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(423, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(424, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(425, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(426, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(427, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(428, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(429, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(430, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(431, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(432, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(433, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(434, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(435, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(436, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(437, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(438, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(439, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(440, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(441, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(442, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(443, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(444, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(445, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(446, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(447, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(448, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(449, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(450, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(451, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(452, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(453, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(454, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(455, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(456, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(457, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(458, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(459, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(460, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(461, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(462, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(463, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(464, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(465, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(466, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(467, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(468, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(469, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(470, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(471, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(472, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(473, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(474, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(475, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(476, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(477, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(478, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(479, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(480, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(481, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(482, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(483, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(484, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(485, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(486, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(487, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(488, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(489, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(490, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(491, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(492, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(493, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(494, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(495, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(496, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(497, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(498, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(499, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(500, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(501, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(502, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(503, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(504, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(505, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(506, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(507, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(508, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(509, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(510, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(511, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(512, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(513, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(514, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(515, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(516, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(517, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(518, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(519, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(520, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(521, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(522, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(523, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(524, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(525, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(526, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(527, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(528, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(529, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(530, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(531, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(532, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(533, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(534, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(535, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(536, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(537, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(538, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(539, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(540, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(541, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(542, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(543, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(544, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(545, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(546, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(547, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(548, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(549, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(550, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(551, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(552, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(553, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(554, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(555, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(556, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(557, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(558, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(559, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(560, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(561, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(562, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(563, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(564, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(565, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(566, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(567, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(568, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(569, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(570, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(571, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(572, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(573, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(574, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(575, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(576, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(577, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(578, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(579, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(580, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(581, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(582, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(583, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(584, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(585, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(586, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(587, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(588, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(589, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(590, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(591, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(592, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(593, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(594, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(595, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(596, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(597, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(598, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(599, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(600, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(601, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(602, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(603, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(604, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(605, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(606, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(607, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(608, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(609, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(610, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(611, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(612, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(613, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(614, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(615, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(616, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(617, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(618, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(619, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(620, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(621, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(622, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(623, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(624, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(625, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(626, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(627, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(628, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(629, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(630, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(631, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(632, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(633, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(634, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(635, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(636, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(637, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(638, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(639, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(640, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(641, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(642, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(643, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(644, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(645, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(646, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(647, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(648, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(649, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(650, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(651, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(652, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(653, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(654, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(655, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(656, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(657, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(658, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(659, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(660, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(661, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(662, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(663, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(664, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(665, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(666, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(667, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(668, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(669, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(670, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(671, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(672, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(673, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(674, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(675, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(676, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(677, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(678, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(679, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(680, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(681, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(682, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(683, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(684, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(685, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(686, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(687, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(688, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(689, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(690, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(691, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(692, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(693, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(694, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(695, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(696, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(697, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(698, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(699, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(700, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(701, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(702, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(703, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(704, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(705, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(706, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(707, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(708, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(709, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(710, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(711, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(712, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(713, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(714, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(715, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(716, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(717, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(718, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(719, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(720, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(721, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(722, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(723, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(724, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(725, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(726, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(727, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(728, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(729, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(730, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(731, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(732, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(733, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(734, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(735, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(736, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(737, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(738, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(739, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(740, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(741, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(742, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(743, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(744, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(745, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(746, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(747, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(748, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(749, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(750, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(751, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(752, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(753, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(754, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(755, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(756, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(757, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(758, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(759, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(760, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(761, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(762, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(763, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(764, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(765, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(766, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(767, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(768, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(769, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(770, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(771, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(772, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(773, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(774, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(775, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(776, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(777, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(778, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(779, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(780, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(781, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(782, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(783, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(784, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(785, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(786, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(787, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(788, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(789, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(790, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(791, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(792, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(793, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(794, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(795, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(796, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(797, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(798, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(799, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(800, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(801, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(802, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(803, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(804, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(805, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(806, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(807, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(808, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(809, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(810, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(811, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(812, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(813, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(814, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(815, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(816, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(817, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(818, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(819, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(820, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(821, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(822, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(823, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(824, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(825, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(826, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(827, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(828, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(829, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(830, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(831, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(832, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(833, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(834, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(835, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(836, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(837, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(838, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(839, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(840, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(841, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(842, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(843, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(844, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(845, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(846, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(847, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(848, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(849, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(850, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(851, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(852, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(853, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(854, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(855, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(856, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(857, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(858, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(859, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(860, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(861, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(862, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(863, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(864, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(865, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(866, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(867, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(868, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(869, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(870, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(871, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(872, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(873, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(874, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(875, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(876, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(877, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(878, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(879, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(880, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(881, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(882, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(883, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(884, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(885, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(886, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(887, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(888, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(889, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(890, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(891, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(892, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(893, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(894, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(895, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(896, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(897, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(898, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(899, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(900, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(901, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(902, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(903, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(904, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(905, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(906, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(907, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(908, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(909, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(910, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(911, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(912, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(913, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(914, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(915, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(916, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(917, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(918, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(919, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(920, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(921, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(922, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(923, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(924, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(925, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(926, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(927, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(928, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(929, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(930, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(931, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(932, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(933, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(934, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(935, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(936, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(937, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(938, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(939, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(940, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(941, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(942, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL);
INSERT INTO `profileOpts` (`id`, `begin_date`, `instrument`, `presentation`, `full_name`, `birth_date`, `birth_location`, `phone`, `social`, `gender`, `notification_check`) VALUES
(943, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(944, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(945, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(946, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(947, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(948, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(949, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(950, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(951, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(952, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(953, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(954, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(955, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(956, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(957, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(958, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(959, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(960, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(961, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(962, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(963, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(964, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(965, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(966, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(967, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(968, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(969, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(970, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(971, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(972, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(973, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(974, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(975, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(976, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(977, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(978, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(979, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(980, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(981, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(982, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(983, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(984, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(985, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(986, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(987, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(988, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(989, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(990, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(991, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(992, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(993, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(994, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(995, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(996, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(997, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(998, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(999, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1000, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1001, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1002, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1003, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1004, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1005, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1006, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1007, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1008, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1009, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1010, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1011, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1012, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1013, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1014, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1015, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1016, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1017, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1018, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1019, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1020, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1021, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1022, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1023, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1024, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1025, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1026, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1027, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1028, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1029, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1030, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1031, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1032, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1033, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1034, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1035, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1036, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1037, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1038, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1039, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1040, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1041, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1042, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1043, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1044, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1045, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1046, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1047, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1),
(1048, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1049, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1050, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1051, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1052, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1053, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1054, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1055, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1056, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1057, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1061, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1062, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
(1063, 1, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relationship`
--

CREATE TABLE `relationship` (
  `profile_one_id` int(11) NOT NULL,
  `profile_two_id` int(11) NOT NULL,
  `one_follow_two_status` tinyint(8) DEFAULT NULL,
  `two_follow_one_status` tinyint(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `relationship`
--

INSERT INTO `relationship` (`profile_one_id`, `profile_two_id`, `one_follow_two_status`, `two_follow_one_status`) VALUES
(1, 10, NULL, 1),
(2, 10, NULL, 1),
(5, 10, NULL, 1),
(10, 1046, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `report_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `report`
--

INSERT INTO `report` (`id`, `sender_id`, `target_id`, `created_at`, `status`, `report_type_id`) VALUES
(1, 10, 1, '1539835323', 0, 3),
(2, 10, 1, '1539835332', 0, 2),
(3, 10, 80, '1542914512', 0, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `report_type`
--

CREATE TABLE `report_type` (
  `id` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `report_type`
--

INSERT INTO `report_type` (`id`, `description`) VALUES
(1, 'copyright'),
(2, 'wrong_content'),
(3, 'bullying'),
(4, 'stolen_identity');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id`, `type`) VALUES
(1, 'admin'),
(2, 'regulator'),
(3, 'listener'),
(4, 'artist');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `song`
--

CREATE TABLE `song` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `path_song` varchar(400) DEFAULT NULL,
  `time` smallint(5) DEFAULT NULL,
  `bitrate` mediumint(8) DEFAULT NULL,
  `rate` mediumint(8) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `id_referencia` varchar(45) DEFAULT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `song`
--

INSERT INTO `song` (`id`, `name`, `path_song`, `time`, `bitrate`, `rate`, `size`, `id_referencia`, `album_id`) VALUES
(1, '01 Born In Babylon', '/opt/lampp/htdocs/radioalbum/catalogo/soja/Born In Babylon/01 Born In Babylon.mp3', 278, 160000, 44100, 5669290, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `song_has_genre`
--

CREATE TABLE `song_has_genre` (
  `song_id` int(11) NOT NULL,
  `song_Album_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `auth_key` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `access_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `password_hash`, `password_reset_token`, `auth_key`, `status`, `created_at`, `updated_at`, `role_id`, `access_id`) VALUES
(1, 'admin', '$2y$13$ttEQCWJrLnSF/4OWmvjbEukCaCNFn8Mh.fVKyJBhe7dfrgR8SOllG', NULL, 'yPPNGayBKehiyPWPhz4H8TuT1l_mFHFi', 10, '1503880286', '1511289229', 1, 2),
(63, 'maikndawer@gmail.com', '$2y$13$7PLj9uoh1aVgoLX4IyDmJu.lgBLLOa/VORcX8CUGTJ5nlgNQ/nFkm', NULL, 'TuStPBu9AqyU-4_QVdm3aNZEH79At2ta', 10, '1534897089', '1534897089', 4, 48),
(64, 'osvaldo@gmail.com', '$2y$13$Y6rZJadIl8FHmKSE.Jr3xuJPpbhkNRlgjMWzwPMQeSZwKAJnlNlo.', NULL, '3vVGuKkUJgyVcvRXMXzlcqPyxQ-QJtBb', 10, '1539543113', '1539543144', 3, 49);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visibility`
--

CREATE TABLE `visibility` (
  `id` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `visibility`
--

INSERT INTO `visibility` (`id`, `type`) VALUES
(1, 'private'),
(2, 'protected'),
(3, 'public');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `album_has_channel`
--
ALTER TABLE `album_has_channel`
  ADD PRIMARY KEY (`album_id`,`channel_id`),
  ADD KEY `fk_album_has_channel_channel1_idx` (`channel_id`),
  ADD KEY `fk_album_has_channel_album1_idx` (`album_id`);

--
-- Indices de la tabla `album_has_genre`
--
ALTER TABLE `album_has_genre`
  ADD PRIMARY KEY (`album_id`,`genre_id`),
  ADD KEY `fk_album_has_genre_genre1_idx` (`genre_id`),
  ADD KEY `fk_album_has_genre_album1_idx` (`album_id`);

--
-- Indices de la tabla `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artist_user1_idx` (`user_id`),
  ADD KEY `fk_artist_profile1_idx` (`profile_id`);

--
-- Indices de la tabla `artist_has_album`
--
ALTER TABLE `artist_has_album`
  ADD PRIMARY KEY (`artist_id`,`album_id`),
  ADD KEY `fk_artist_has_album_album1_idx` (`album_id`),
  ADD KEY `fk_artist_has_album_artist1_idx` (`artist_id`);

--
-- Indices de la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indices de la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indices de la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indices de la tabla `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_profile1_idx` (`profile_id`),
  ADD KEY `fk_comment_post1_idx` (`post_id`);

--
-- Indices de la tabla `comment_like`
--
ALTER TABLE `comment_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_like_comment1_idx` (`comment_id`),
  ADD KEY `fk_comment_like_profile1_idx` (`profile_id`);

--
-- Indices de la tabla `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id_gender`);

--
-- Indices de la tabla `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `listener`
--
ALTER TABLE `listener`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_listener_profile1_idx` (`profile_id`),
  ADD KEY `fk_listener_user1_idx` (`user_id`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notification_notification_type1_idx` (`notification_type_id`);

--
-- Indices de la tabla `notification_type`
--
ALTER TABLE `notification_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`,`profile_id`),
  ADD KEY `fk_playlist_profile1_idx` (`profile_id`),
  ADD KEY `fk_playlist_visibility1_idx` (`visibility_id`);

--
-- Indices de la tabla `playlist_has_song`
--
ALTER TABLE `playlist_has_song`
  ADD PRIMARY KEY (`playlist_id`,`song_id`),
  ADD KEY `fk_playlist_has_song_song1_idx` (`song_id`),
  ADD KEY `fk_playlist_has_song_playlist1_idx` (`playlist_id`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_profile1_idx` (`profile_id`),
  ADD KEY `fk_post_album1_idx` (`album_id`),
  ADD KEY `fk_post_post1` (`post_id`),
  ADD KEY `collection_id` (`collection_id`);

--
-- Indices de la tabla `post_follow`
--
ALTER TABLE `post_follow`
  ADD PRIMARY KEY (`id_profile`,`id_post`);

--
-- Indices de la tabla `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_like_post1_idx` (`post_id`),
  ADD KEY `fk_post_like_profile1_idx` (`profile_id`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_profile_gender1_idx` (`gender_id`),
  ADD KEY `fk_profile_profileOpts1_idx` (`options_id`);

--
-- Indices de la tabla `profileOpts`
--
ALTER TABLE `profileOpts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`profile_one_id`,`profile_two_id`);

--
-- Indices de la tabla `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_report_report_type1_idx` (`report_type_id`);

--
-- Indices de la tabla `report_type`
--
ALTER TABLE `report_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`,`album_id`),
  ADD KEY `fk_song_Album1_idx` (`album_id`);

--
-- Indices de la tabla `song_has_genre`
--
ALTER TABLE `song_has_genre`
  ADD PRIMARY KEY (`song_id`,`song_Album_id`,`genre_id`),
  ADD KEY `fk_song_has_genre_genre1_idx` (`genre_id`),
  ADD KEY `fk_song_has_genre_song1_idx` (`song_id`,`song_Album_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_role1_idx` (`role_id`),
  ADD KEY `fk_user_access1_idx` (`access_id`);

--
-- Indices de la tabla `visibility`
--
ALTER TABLE `visibility`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `channel`
--
ALTER TABLE `channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comment_like`
--
ALTER TABLE `comment_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gender`
--
ALTER TABLE `gender`
  MODIFY `id_gender` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=698;

--
-- AUTO_INCREMENT de la tabla `listener`
--
ALTER TABLE `listener`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `post_like`
--
ALTER TABLE `post_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1063;

--
-- AUTO_INCREMENT de la tabla `profileOpts`
--
ALTER TABLE `profileOpts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1064;

--
-- AUTO_INCREMENT de la tabla `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `report_type`
--
ALTER TABLE `report_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `song`
--
ALTER TABLE `song`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `visibility`
--
ALTER TABLE `visibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `album_has_channel`
--
ALTER TABLE `album_has_channel`
  ADD CONSTRAINT `fk_album_has_channel_album1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_album_has_channel_channel1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `album_has_genre`
--
ALTER TABLE `album_has_genre`
  ADD CONSTRAINT `fk_album_has_genre_album1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_album_has_genre_genre1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `artist`
--
ALTER TABLE `artist`
  ADD CONSTRAINT `fk_artist_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_artist_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `artist_has_album`
--
ALTER TABLE `artist_has_album`
  ADD CONSTRAINT `fk_artist_has_album_album1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_artist_has_album_artist1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comment_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comment_like`
--
ALTER TABLE `comment_like`
  ADD CONSTRAINT `fk_comment_like_comment1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comment_like_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `listener`
--
ALTER TABLE `listener`
  ADD CONSTRAINT `fk_listener_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_listener_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_notification_notification_type1` FOREIGN KEY (`notification_type_id`) REFERENCES `notification_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `fk_playlist_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_playlist_visibility1` FOREIGN KEY (`visibility_id`) REFERENCES `visibility` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `playlist_has_song`
--
ALTER TABLE `playlist_has_song`
  ADD CONSTRAINT `fk_playlist_has_song_playlist1` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_playlist_has_song_song1` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `post_like`
--
ALTER TABLE `post_like`
  ADD CONSTRAINT `fk_post_like_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_post_like_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
