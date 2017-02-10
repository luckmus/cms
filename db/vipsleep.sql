-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 10 2017 г., 09:01
-- Версия сервера: 5.1.37
-- Версия PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `vipsleep`
--

-- --------------------------------------------------------

--
-- Структура таблицы `alteraversion`
--

CREATE TABLE IF NOT EXISTS `alteraversion` (
  `versionui` varchar(20) NOT NULL,
  `versionint` int(11) NOT NULL,
  `relieasedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `alteraversion`
--

INSERT INTO `alteraversion` (`versionui`, `versionint`, `relieasedate`) VALUES
('1.0.0.0', 1000, '2011-03-08 09:34:41');

-- --------------------------------------------------------

--
-- Структура таблицы `ask`
--

CREATE TABLE IF NOT EXISTS `ask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quetion` text,
  `answer` text,
  `qname` char(50) DEFAULT NULL,
  `email` char(255) DEFAULT NULL,
  `qdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `ask`
--

INSERT INTO `ask` (`id`, `quetion`, `answer`, `qname`, `email`, `qdate`) VALUES
(3, 'А вы занимаетесь доставкой билетов?', 'НЕТ!!!!!!', 'инкогнито', NULL, '2008-12-07 08:33:06'),
(4, 'Собственно, суть вопроса мне нужна. прсто хочу посмотреть как вы работаете', '<p><span style="font-family: comic sans ms,sans-serif;">как видите, мы работаем</span><img title="Innocent" src="/briz/adm/tiny_mce/plugins/emotions/img/smiley-innocent.gif" border="0" alt="Innocent" /></p>\r\n<table border="0">\r\n<tbody>\r\n<tr>\r\n<td>$$$</td>\r\n<td><span style="text-decoration: underline;">sdsdsd</span></td>\r\n</tr>\r\n<tr>\r\n<td>****</td>\r\n<td><strong><em>sklrgfsgf</em></strong></td>\r\n</tr>\r\n</tbody>\r\n</table>', 'srt', 'dfd@df..ru', '2010-11-05 13:47:17'),
(13, 'Как дела', '<p>Все, ок, спасибо</p>', 'Сергей', 'luckmus@inbox.ru', '2011-11-20 11:24:37'),
(14, 'Ыв', NULL, 'ффы', 'grace2007@yandex.ru', '2017-01-27 22:40:45');

-- --------------------------------------------------------

--
-- Структура таблицы `dtype`
--

CREATE TABLE IF NOT EXISTS `dtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `dtype`
--

INSERT INTO `dtype` (`id`, `name`) VALUES
(1, 'шт.'),
(2, 'м<sup>2</sup>');

-- --------------------------------------------------------

--
-- Структура таблицы `em_account`
--

CREATE TABLE IF NOT EXISTS `em_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LOGIN` varchar(100) NOT NULL,
  `PWD` varchar(255) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `adres` text,
  `regdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `em_account`
--

INSERT INTO `em_account` (`id`, `LOGIN`, `PWD`, `firstname`, `lastname`, `tel`, `email`, `adres`, `regdate`) VALUES
(2, 'wonder', 'c4ca4238a0b923820dcc509a6f75849b', 'Ерошевич', 'Сергей', '59090', 'grace2007@yandex.ru', 'Конд пр ', '2011-10-26 20:25:04'),
(3, 'luckmus', 'c4ca4238a0b923820dcc509a6f75849b', 'Eroshevich', 'Sergey', '345678', 'luckmus@inbox.ru', 'daas', '2011-10-20 17:04:26'),
(4, '3456', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '1', '12000078@mail.ru', '', '2011-10-22 17:12:13'),
(5, '', 'd41d8cd98f00b204e9800998ecf8427e', '2323', '2323', 'wwewe', 'wdsd@deds.rt', '', '2012-03-27 21:20:17'),
(6, '85128784', 'd41d8cd98f00b204e9800998ecf8427e', '7687', '87887', '98989', 'sf@sfdsd.ru', '', '2012-03-27 21:29:10');

-- --------------------------------------------------------

--
-- Структура таблицы `em_category`
--

CREATE TABLE IF NOT EXISTS `em_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `imagefile` varchar(255) NOT NULL,
  `ordinal` int(11) NOT NULL DEFAULT '0',
  `isarchivate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=61 ;

--
-- Дамп данных таблицы `em_category`
--

INSERT INTO `em_category` (`id`, `name`, `description`, `imagefile`, `ordinal`, `isarchivate`) VALUES
(1, 'Постель', 'Элитное постельное белье', 'null', 1, 0),
(2, 'Одеяла', 'Одеяла', 'C:/xampplite/htdocs/vipsleep/uploadfiles/bravo.jpg', 2, 0),
(6, 'Подушки', '', 'null', 3, 0),
(7, 'Покрывала', 'Покрывала', 'null', 4, 0),
(60, 'awdasd', '', '', 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `em_category_parameters`
--

CREATE TABLE IF NOT EXISTS `em_category_parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `parameterid` int(11) NOT NULL,
  `ordinal` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок паораметров в категории',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='связка категорий и параметров' AUTO_INCREMENT=37 ;

--
-- Дамп данных таблицы `em_category_parameters`
--

INSERT INTO `em_category_parameters` (`id`, `categoryid`, `parameterid`, `ordinal`) VALUES
(1, 1, 1, 0),
(13, 1, 2, 1),
(17, 1, 3, 2),
(18, 1, 4, 3),
(19, 2, 3, 0),
(20, 2, 4, 0),
(21, 6, 3, 0),
(22, 6, 4, 0),
(23, 7, 4, 0),
(24, 7, 2, 0),
(25, 7, 3, 0),
(26, 2, 1, 0),
(27, 2, 2, 0),
(29, 2, 5, 0),
(36, 1, 5, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `em_goods`
--

CREATE TABLE IF NOT EXISTS `em_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `imagefile` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `ordinal` int(11) NOT NULL DEFAULT '0',
  `isarchivate` int(11) NOT NULL DEFAULT '0' COMMENT 'товар а архиве или нет',
  `metadescription` text,
  `metakeywords` text,
  `updatedate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=54 ;

--
-- Дамп данных таблицы `em_goods`
--

INSERT INTO `em_goods` (`id`, `categoryid`, `name`, `description`, `imagefile`, `price`, `ordinal`, `isarchivate`, `metadescription`, `metakeywords`, `updatedate`) VALUES
(12, 1, 'Матрац', '<p>Белье премиум класса. Комбинация жаккардового шелка с хлопком не только красива, но и практична - к телу 100% хлопок. Простынь из 100% хлопка с шелковым купоном. Нижняя сторона пододеяльника 100% хлопок.</p>', 'uploadfiles/satin2.jpg', 0, 8, 0, '', '', '2011-08-21 22:10:33'),
(51, 1, 'насос', '<p>Насос для накачивания бицух</p>', 'uploadfiles/bravo.jpg', NULL, 14, 0, '', '', '2015-02-14 21:29:31'),
(11, 1, 'Насос', '<p>qierhewfrgiq<strong>eruh</strong></p>\n<p><img title="Smile" src="/vipsleep/adm/tiny_mce/plugins/emotions/img/smiley-smile.gif" border="0" alt="Smile" /></p>', 'uploadfiles/orang.jpg', 10, 7, 1, '', '', '0000-00-00 00:00:00'),
(41, 1, 'Сатин', '<p>Привет</p>', 'uploadfiles/sation1.jpg', NULL, 9, 0, 'wd', 'wewe', '2011-09-11 14:43:17'),
(42, 2, 'Одеяло', '<p>Шерстянное одеяло</p>', 'uploadfiles/odeylo 1.jpg', NULL, 10, 0, '', '', '2011-10-17 12:30:55'),
(43, 2, 'Другое одеяло', '<p>Шерстянное одеяло</p>', 'uploadfiles/odeylo 2.jpg', NULL, 11, 0, '', '', '2011-10-17 12:32:37'),
(49, 7, 'Покрывало цветастое', '<p>Разноцветное покрывало</p>', 'uploadfiles/BS84-3.jpg', NULL, 12, 0, '', '', '2011-10-17 14:09:09'),
(50, 1, 'архив', '', 'uploadfiles/BS84-3.jpg', NULL, 13, 1, '', '', '2011-10-21 14:01:03'),
(52, 2, 'лого', '<p>крутой логотип</p>', 'uploadfiles/logo.jpg', NULL, 15, 0, '', '', '2015-02-14 21:46:01'),
(53, 6, 'нечто', '<p>Титаник<span style="text-decoration: line-through;"> наших</span> дней</p>', 'uploadfiles/breeze2.jpg', NULL, 16, 0, '', '', '2015-02-14 21:47:27');

-- --------------------------------------------------------

--
-- Структура таблицы `em_goods_params`
--

CREATE TABLE IF NOT EXISTS `em_goods_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `pvid` int(11) NOT NULL,
  `paramid` int(11) NOT NULL COMMENT 'id  параметра зависимого от параметра описаного в parentId',
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='Хранит значения параметров описывающих единицу товара из em_' AUTO_INCREMENT=85 ;

--
-- Дамп данных таблицы `em_goods_params`
--

INSERT INTO `em_goods_params` (`id`, `parentid`, `gid`, `pvid`, `paramid`, `value`) VALUES
(1, 0, 11, 16, 0, ''),
(48, 0, 42, 16, 0, ''),
(3, 0, 12, 16, 0, ''),
(75, 0, 51, 2, 0, ''),
(5, 0, 12, 14, 0, ''),
(8, 0, 11, 55, 0, '1111'),
(11, 0, 12, 55, 0, '1240'),
(46, 0, 41, 3, 0, ''),
(17, 0, 16, 2, 0, ''),
(16, 0, 15, 2, 0, ''),
(43, 0, 41, 19, 0, ''),
(44, 0, 41, 64, 0, '3500'),
(47, 0, 11, 56, 0, '1000'),
(49, 0, 42, 57, 0, ''),
(50, 0, 42, 64, 0, '2500'),
(51, 0, 43, 16, 0, ''),
(52, 0, 43, 57, 0, ''),
(53, 0, 43, 64, 0, '2500'),
(70, 0, 49, 64, 0, '2000'),
(69, 0, 49, 14, 0, ''),
(72, 0, 50, 2, 0, ''),
(74, 0, 43, 59, 0, ''),
(73, 0, 42, 59, 0, ''),
(79, 0, 51, 59, 0, ''),
(84, 0, 12, 64, 0, '1200'),
(77, 0, 51, 64, 0, '1000'),
(76, 0, 51, 57, 0, ''),
(80, 0, 52, 2, 0, ''),
(81, 0, 52, 57, 0, ''),
(82, 0, 52, 64, 0, '5000'),
(83, 0, 53, 64, 0, '1000000');

-- --------------------------------------------------------

--
-- Структура таблицы `em_order`
--

CREATE TABLE IF NOT EXISTS `em_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) DEFAULT NULL,
  `goodsid` int(11) DEFAULT NULL,
  `cnt` int(11) NOT NULL DEFAULT '1',
  `goodsprice` varchar(20) DEFAULT NULL COMMENT 'Цена товара на момент заказа',
  `discount` int(11) NOT NULL DEFAULT '0',
  `totalsum` decimal(10,2) NOT NULL DEFAULT '0.00',
  `userid` int(11) NOT NULL COMMENT 'пользователь',
  `name` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tel` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `adres` text NOT NULL,
  `iscomlete` smallint(6) NOT NULL DEFAULT '0',
  `datecomplete` date DEFAULT NULL,
  `description` text,
  `managerdesc` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=284 ;

--
-- Дамп данных таблицы `em_order`
--

INSERT INTO `em_order` (`id`, `id_parent`, `goodsid`, `cnt`, `goodsprice`, `discount`, `totalsum`, `userid`, `name`, `firstname`, `lastname`, `date`, `tel`, `email`, `adres`, `iscomlete`, `datecomplete`, `description`, `managerdesc`) VALUES
(278, NULL, NULL, 0, '2500', 2, '2450.00', 0, '', '', '', '2017-02-10 08:17:16', '564135115', '', '{&quot;method&quot;:3,&quot;curr&quot;:{&quot;price&quot;:365.5,&quot;price_base&quot;:140,&quot;price_service&quot;:225.5,&quot;delivery_period&quot;:&quot;2&quot;},&quot;address&quot;:&quot;qwfwfsdf&quot;,&quot;city&quot;:&quot;464564&quot;,&quot;index&quot;:&quot;190000&quot;}', 0, NULL, '', NULL),
(279, 278, 42, 1, '2500', 0, '0.00', 0, '', '', '', '2017-02-10 08:17:16', '564135115', '', '', 0, NULL, '', NULL),
(280, NULL, NULL, 0, '1000000', 0, '1000000.00', 0, '', '', '', '2017-02-10 08:54:38', '3541531351', '', '{&quot;method&quot;:2, &quot;pvzId&quot;:{&quot;id&quot;:&quot;78061&quot;,&quot;zip&quot;:&quot;190031&quot;,&quot;name&quot;:&quot;Санкт-Петербург&quot;,&quot;address&quot;:&quot;190031, Санкт-Петербург г, Московский пр-кт, д.3а&quot;,&quot;phone&quot;:&quot;8-800-700-54-30&quot;,&quot;workschedule&quot;:&quot;пн-сб: 10.00-21.00, вс: 11.00-19.00&quot;,&quot;period&quot;:&quot;2&quot;,&quot;price&quot;:&quot;30142&quot;,&quot;prepaid&quot;:&quot;No&quot;}}', 0, NULL, '', ''),
(281, 280, 53, 1, '1000000', 0, '0.00', 0, '', '', '', '2017-02-10 08:32:28', '3541531351', '', '', 0, NULL, '', NULL),
(282, NULL, NULL, 0, '1000', 2, '980.00', 0, '', '', '', '2017-02-10 08:52:59', '5464664', '', '{&quot;method&quot;:1}', 0, NULL, '', NULL),
(283, 282, 51, 1, '1000', 0, '0.00', 0, '', '', '', '2017-02-10 08:52:59', '5464664', '', '', 0, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `em_parameters`
--

CREATE TABLE IF NOT EXISTS `em_parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relationfrom` int(11) DEFAULT NULL COMMENT 'Показывает зависимоть параметра от другого параметра, ',
  `name` varchar(100) NOT NULL,
  `ordinal` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `em_parameters`
--

INSERT INTO `em_parameters` (`id`, `relationfrom`, `name`, `ordinal`) VALUES
(1, NULL, 'Материал', 1),
(2, NULL, 'Цвет', 2),
(3, NULL, 'Размер', 3),
(4, 3, 'Цена', 5),
(5, NULL, 'Вес кг.', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `em_param_value`
--

CREATE TABLE IF NOT EXISTS `em_param_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `ordinal` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=65 ;

--
-- Дамп данных таблицы `em_param_value`
--

INSERT INTO `em_param_value` (`id`, `pid`, `value`, `description`, `ordinal`) VALUES
(2, 1, 'Cotton', 'Cotton', 1),
(3, 2, 'Red', '', 0),
(19, 1, 'шелк', '', 5),
(14, 2, 'Green', '', 1),
(16, 1, 'шерсть', '', 3),
(32, 1, 'Сатин', '', 6),
(40, 2, 'black', '', 2),
(57, 2, 'Желтый', '', 3),
(59, 5, '120', '', 0),
(60, 1, 'Жакард', 'Суппер крутой жаккард', 7),
(63, 2, 'болотный', '''', 4),
(64, 3, 'обычный', '', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `em_promo`
--

CREATE TABLE IF NOT EXISTS `em_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `descr` text NOT NULL,
  `value` int(11) NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `em_promo`
--

INSERT INTO `em_promo` (`id`, `name`, `descr`, `value`, `end_date`) VALUES
(1, 'test', '<p><em><strong><span style="text-decoration: underline;">ЫВф</span>ЫФыы &nbsp;!</strong></em></p>', 2, '2017-02-28');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ndate` datetime DEFAULT NULL,
  `name` char(75) DEFAULT NULL,
  `news` text,
  `metadescription` text,
  `metakeywords` text,
  PRIMARY KEY (`id`),
  KEY `ndate` (`ndate`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `ndate`, `name`, `news`, `metadescription`, `metakeywords`) VALUES
(9, '2010-10-16 12:54:29', 'Запуск сайта', '<p>Садоводство<span style="text-decoration: underline;"> "Огуречик"</span>. стало на <span style="text-decoration: line-through;">прогрессивыный</span> инновационный путь развития!!! И первый шаг - это создание первого в истории вслеленной <strong>наносайта</strong>.</p>', NULL, NULL),
(10, '2010-12-18 15:01:33', 'новость №1', '<p>вот так новость</p>\r\n<table style="width: 94px; height: 18px;" border="2">\r\n<tbody>\r\n<tr>\r\n<td><img src="/briz/uploadfiles/smallimg/small_long.jpg" alt="" width="200" height="266" /></td>\r\n<td><img src="/briz/uploadfiles/smallimg/small_real.jpg" alt="" width="200" height="266" /></td>\r\n</tr>\r\n</tbody>\r\n</table>', 'цу111', 'цуц11');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `butnum` smallint(6) DEFAULT NULL,
  `name` char(50) NOT NULL,
  `descr` char(150) DEFAULT NULL,
  `pdate` datetime DEFAULT NULL,
  `page` text,
  `ordinal` int(11) DEFAULT NULL,
  `isinclude` smallint(6) NOT NULL DEFAULT '0',
  `metadescription` text,
  `metakeywords` text,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`descr`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `pid`, `butnum`, `name`, `descr`, `pdate`, `page`, `ordinal`, `isinclude`, `metadescription`, `metakeywords`) VALUES
(1, 1, 1, 'О магазине', 'О магазине', '2011-10-17 13:45:37', '<div class="Section1">\r\n<p style="text-align: justify;"><span style="font-size: small;">&nbsp;Приветствуем Вас на страницах нашего <strong>интернет-магазина</strong> <strong>элитного постельного белья</strong><strong> &laquo;ELITE DE COTTON&raquo;</strong>.  Окунитесь в мир сладких снов и хорошего настроения! Сделайте подарок  любимым! Помните, что таким образом Вы дарите не просто вещь, а  достойный отдых, что, согласитесь, бесценно! Каждое изделие,  предложенное Вашему вниманию в нашем <strong>интернет-магазине</strong> отличает исключительное качество исполнения и материала. Мы представляем  эксклюзивные коллекции моделей от ведущих дизайнеров мира. Поднимите  себе настроение!</span></p>\r\n<p style="text-align: justify;"><span style="font-size: small;">Удобство заказа товара через интернет заключается в том, что Вы можете в  спокойной для себя обстановке выбрать то, что нужно именно Вам.  Ознакомьтесь с <a href="/vipsleep/adm/">каталогом</a> представленных в нашем <strong>интернет-магазине</strong> коллекций! Иллюстрации помогут Вам представить, как тот или иной  образец будет смотреться в Вашей спальне, преображая, украшая ее и  создавая неповторимую атмосферу уюта и тепла. Уделите несколько минут на  <a href="http://elitpostel.ru/reg.html">регистрацию</a> в нашем <strong>интернет-магазине</strong>, чтобы оформить заказ на понравившуюся Вам модель. <a href="http://elitpostel.ru/prais.html">Прайс-лист</a> содержит в себе цены на различные группы комплектов белья, которые доступны для заказа в <strong>интернет-магазине</strong>. Если же Вы стремитесь к идеалу во всем и ищите нечто совершенно особенное (например комплект роскошного <strong>элитного постельного белья </strong>класса люкс из натурального шелка), <a href="http://elitpostel.ru/contact.html">свяжитесь</a> с нами любым удобным для Вас способом, и мы сделаем все возможное,  чтобы в ближайшее время осуществить самые смелые Ваши мечты.</span></p>\r\n<p style="text-align: justify;"><span style="font-size: small;">Мы стремимся создать максимум комфорта для Вас. Какой бы комплект Вы ни  заказали, наш курьер доставит выбранный товар в удобное для Вас время  прямо к Вам домой или в офис.</span></p>\r\n<p style="text-align: justify;"><span style="font-size: small;">Если у Вас возникли вопросы, относящиеся к составу тканей или технологии производства <strong>элитного постельного белья</strong>, представленного на страницах нашего сайте, Вы всегда можете обратиться к разделу <a title="Статьи" href="http://elitpostel.ru/articles.html" target="_blank">&laquo;статьи&raquo;</a> и получить ответы на них.  Это очень удобно! Широчайший ассортимент жаккардового, перкалевого, шелкового <strong>элитного постельного белья</strong> и моделей с вышивкой, предложенный Вашему вниманию в нашем <strong>интернет-магазине</strong>, не оставит Вас равнодушными! &nbsp;</span></p>\r\n<p style="text-align: justify; text-indent: 22.7pt;"><span style="color: #010101; font-family: Arial;"><strong><br /></strong></span></p>\r\n</div>', 2, 0, '', ''),
(3, 3, 3, 'Контакты', 'Контакты', '2011-03-02 20:22:05', '<p>По все возникающим вопросам, пишите на наш <strong>e-mail:</strong> info@alteraproject.ru. Так же пишите на наш <a href="/forumBB/">форум&nbsp;</a></p>\r\n<p><strong>телефон:</strong> +7 (911) 174-20-34<br /> <strong>e-mail:</strong> info@alteraproject.ru</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 3, 0, 'Контактная информация\r\n1', 'телефон, email'),
(24, 1, NULL, 'Темпы роста', 'Темпы роста', '2012-03-26 22:05:09', '<p><strong><br /></strong></p>\r\n<table class="table" style="border: 1px solid #000000;" border="0" cellspacing="0" cellpadding="0" align="left">\r\n<tbody>\r\n<tr>\r\n<td rowspan="2" width="121">\r\n<p><strong>Название</strong></p>\r\n</td>\r\n<td rowspan="2" width="66">\r\n<p><strong>Срок</strong></p>\r\n</td>\r\n<td colspan="4" width="784">\r\n<p><strong>%, в мес.</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="227">\r\n<p><strong>Не льготники</strong></p>\r\n</td>\r\n<td width="189">\r\n<p>Пример &ndash; 10т.р.</p>\r\n</td>\r\n<td width="189">\r\n<p><strong>Льготники</strong></p>\r\n</td>\r\n<td width="180">\r\n<p>Пример &ndash; 10т.р</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="121">\r\n<p><strong>Стандартный</strong></p>\r\n</td>\r\n<td width="66">\r\n<p>Бессрочно</p>\r\n</td>\r\n<td width="227">\r\n<p><strong>20%</strong><br />Снять можно в любой момент</p>\r\n</td>\r\n<td width="189">\r\n<p>Всегда прибавляет по 20% в мес. - 10тыс +20%=12тыс+20% и т.д.</p>\r\n</td>\r\n<td width="189">\r\n<p><strong>30%</strong><br />Снять можно в любой момент</p>\r\n</td>\r\n<td width="180">\r\n<p>Всегда прибавляет по 30% в мес. - 10тыс +30%=13тыс+30% и т.д.<strong>&nbsp;</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td rowspan="3" width="121">\r\n<p><strong>Депозит</strong></p>\r\n</td>\r\n<td width="66">\r\n<p>3 мес.</p>\r\n</td>\r\n<td width="227">\r\n<p><strong>30%</strong><br />Досрочно снять возможно с пересчетом по курсу 20%</p>\r\n</td>\r\n<td width="189">\r\n<p>Вы не трогаете деньги 3 мес. и получаете с 10т.р. &ndash; 21970руб.</p>\r\n</td>\r\n<td width="189">\r\n<p><strong>40%</strong><br />Досрочно снять возможно с пересчетом по курсу 30%</p>\r\n</td>\r\n<td width="180">\r\n<p>Вы не трогаете деньги 3 мес. и получаете с 10т.р. &ndash; 27440руб.<strong>&nbsp;</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="66">\r\n<p>6 мес.</p>\r\n</td>\r\n<td width="227">\r\n<p><strong>40%</strong><br />Досрочно снять возможно с пересчетом по курсу 20%</p>\r\n</td>\r\n<td width="189">\r\n<p>Вы не трогаете деньги 6 мес. и получаете с 10т.р. &ndash; 75295руб.<strong>&nbsp;</strong></p>\r\n</td>\r\n<td width="189">\r\n<p><strong>50%</strong><br />Досрочно снять возможно с пересчетом по курсу 30%</p>\r\n</td>\r\n<td width="180">\r\n<p>Вы не трогаете деньги 6 мес. и получаете с 10т.р. &ndash; 113906руб.<strong>&nbsp;</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="66">\r\n<p>12 мес.</p>\r\n</td>\r\n<td width="227">\r\n<p><strong>50%</strong><br />Досрочно снять возможно с пересчетом по курсу 20%</p>\r\n</td>\r\n<td width="189">\r\n<p>Вы не трогаете деньги 12 мес. и получаете с 10т.р. &ndash; 1297463руб.<strong></strong></p>\r\n</td>\r\n<td width="189">\r\n<p><strong>60%</strong><br />Досрочно снять возможно с пересчетом по курсу 30%</p>\r\n</td>\r\n<td width="180">\r\n<p>Вы не трогаете деньги 12 мес. и получаете с 10т.р. &ndash; 2814749руб.<strong></strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td rowspan="3" width="121">\r\n<p><strong>Сверхдоходный депозит</strong></p>\r\n</td>\r\n<td width="66">\r\n<p>3 мес.</p>\r\n</td>\r\n<td width="227">\r\n<p><strong>45%</strong><br />Досрочно снять возможно, но только сумму первоначального взноса с потерей процентов</p>\r\n</td>\r\n<td width="189">\r\n<p>Вы не трогаете деньги 3 мес. и получаете с 10т.р. &ndash; 30486руб<strong></strong></p>\r\n</td>\r\n<td width="189">\r\n<p><strong>55%</strong><br />Досрочно снять возможно, но только сумму первоначального взноса с потерей процентов</p>\r\n</td>\r\n<td width="180">\r\n<p>Вы не трогаете деньги 3 мес. и получаете с 10т.р. &ndash; 37238руб<strong></strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="66">\r\n<p>6 мес.</p>\r\n</td>\r\n<td width="227">\r\n<p><strong>55%</strong><br />Досрочно снять возможно, но только сумму первоначального взноса с потерей процентов</p>\r\n</td>\r\n<td width="189">\r\n<p>Вы не трогаете деньги 6 мес. и получаете с 10т.р. &ndash; 138672руб<strong></strong></p>\r\n</td>\r\n<td width="189">\r\n<p><strong>65%</strong><br />Досрочно снять возможно, но только сумму первоначального взноса с потерей процентов</p>\r\n</td>\r\n<td width="180">\r\n<p>Вы не трогаете деньги 6 мес. и получаете с 10т.р. &ndash; 201791руб<strong></strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="66">\r\n<p>12 мес.</p>\r\n</td>\r\n<td width="227">\r\n<p><strong>65%</strong><br />Досрочно снять возможно, но только сумму первоначального взноса с потерей процентов</p>\r\n</td>\r\n<td width="189">\r\n<p>Вы не трогаете деньги 12 мес. и получаете с 10т.р. &ndash; 4071995руб.<strong></strong></p>\r\n</td>\r\n<td width="189">\r\n<p><strong>75%</strong><br />Досрочно снять возможно, но только сумму первоначального взноса с потерей процентов</p>\r\n</td>\r\n<td width="180">\r\n<p>Вы не трогаете деньги 12 мес. и получаете с 10т.р. &ndash; 8250000руб.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 4, 0, '', ''),
(21, 1, NULL, 'Доставка', 'Доставка', '2011-10-17 13:29:46', '<p>Доставка осуществляется силами компании</p>', 3, 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `parts`
--

CREATE TABLE IF NOT EXISTS `parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(25) DEFAULT NULL,
  `ordinal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ordinal` (`ordinal`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `parts`
--

INSERT INTO `parts` (`id`, `name`, `ordinal`) VALUES
(1, 'О компании', 3),
(3, 'Контакты', 0),
(4, 'Вакансии', 2),
(18, 'new', NULL),
(19, 'caterg', NULL),
(20, NULL, NULL),
(21, 'sad', NULL),
(22, 'qqq', NULL),
(23, 'qqq', NULL),
(24, 'qqq', NULL),
(25, 'ddd', NULL),
(26, 'ddd', NULL),
(27, 'ddd', NULL),
(28, 'new1', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `regards`
--

CREATE TABLE IF NOT EXISTS `regards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `firm` char(100) DEFAULT NULL,
  `rdate` datetime DEFAULT NULL,
  `position` char(100) DEFAULT NULL,
  `regard` text,
  PRIMARY KEY (`id`),
  KEY `rdate` (`rdate`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `regards`
--

INSERT INTO `regards` (`id`, `name`, `firm`, `rdate`, `position`, `regard`) VALUES
(1, 'баба Люба', '', '2008-12-07 18:23:12', 'домохозяйка', 'все отмыли'),
(2, 'инкогнито', '', '2008-12-07 18:30:54', '', 'Если им хорошо заплатить, то они и билетв доставят))))\r\nсервис!!'),
(17, 'Серге', '', '2017-01-27 22:41:22', '', 'фвфыв'),
(16, 'jyjjk', 'ytuio', '2011-11-20 10:54:04', 'ghijk', 'Новый ооваолыаылтоа');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `tid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `tid`) VALUES
(1, 'Мойка окна', 100, 2),
(2, 'чистка дивана', 200, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `ordinal` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `description`, `value`, `ordinal`, `name`, `type`) VALUES
(1, 'количество предложений отображаемых в поиске', '4', 1, 'ClauseCount', 0),
(2, 'Количество отобржаемых результатов поиска', '10', 2, 'PrintSearchResultCount', 0),
(3, 'количество товаров выводимых в кратком каталоге', '5', 1, 'ShortCntGoods', 0),
(4, 'количество отзывов на странице', '2', 4, 'AllregardsCount', 0),
(5, 'длина части новости', '30', 5, 'NewsPartLen', 0),
(6, 'количество новостей в таблице', '5', 6, 'newsCount', 0),
(7, 'Количество вопросов', '2', 7, 'askCount', 0),
(8, 'Количество всех вопросов', '4', 8, 'AllaskCount', 0),
(9, 'Скин отображения', 'bed_skin', 9, 'skin', 0),
(10, 'Валюта', 'RUB', 10, 'currency', 0),
(11, 'Email отправителя  рассылки', 'luckmus@inbox.ru', 11, 'email_sender', 0),
(12, 'email Менеждера', 'luckmus@inbox.ru', 12, 'manager_email', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
