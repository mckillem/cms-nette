DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
                                         `id` int(11) NOT NULL AUTO_INCREMENT,
                                         `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                         `has_picture` int(11) DEFAULT NULL,
                                         `title` varchar(255) DEFAULT NULL,
                                         `url` varchar(255) DEFAULT NULL,
                                         `short_description` varchar(255) DEFAULT NULL,
                                         `description` text,
                                         PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `article` (`id`, `date_add`, `has_picture`, `title`, `url`, `short_description`, `description`) VALUES
                                                                                                                (1, '2020-03-15 11:54:20', 1, 'Základ PHP', '1-zaklad-php', 'Zde se naučíme základy PHP.', 'Co je to PHP? Jak je rozjet na localu? A na konec základní program Ahoj světe.'),
                                                                                                                (2, '2020-03-16 11:05:31', 1, 'CSS Prakticky', '2-css-prakticky', 'Koukneme se na zoubek CSS.', '<p>Co je to CSS? Uděláme první kroky a ovládneme jej. A na konec si ukážeme best-off neboli <strong>BootStrap</strong> <strong>framework</strong>.</p>');

CREATE TABLE IF NOT EXISTS `user` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `firstname` varchar(255) COLLATE utf8_czech_ci NOT NULL,
                                      `lastname` varchar(255) COLLATE utf8_czech_ci NOT NULL,
                                      `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
                                      `password` varchar(60) COLLATE utf8_czech_ci NOT NULL,
                                      `role` enum('member','admin') COLLATE utf8_czech_ci NOT NULL DEFAULT 'member',
                                      PRIMARY KEY (`id`),
                                      UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

# login cms@itnetwork.cz
# heslo itnetwork
INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `role`) VALUES
    (1, 'it', 'network', 'cms@itnetwork.cz', '$2y$10$arJIJie/xGoqZayCro4yZ.pPEkt9Ps4DJBNZAHSZ/rvbOkj//K/tq', 'admin');


DROP TABLE IF EXISTS `article_category`;
CREATE TABLE IF NOT EXISTS `article_category` (
                                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                                  `article_id` int(11) NOT NULL,
                                                  `category_id` int(11) NOT NULL,
                                                  PRIMARY KEY (`id`),
                                                  UNIQUE KEY `article_category_unique` (`article_id`,`category_id`),
                                                  KEY `category_id` (`category_id`),
                                                  KEY `article_id` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `article_category` (`id`, `article_id`, `category_id`) VALUES
                                                                       (6, 1, 1),
                                                                       (3, 2, 2);

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
                                          `id` int(11) NOT NULL AUTO_INCREMENT,
                                          `name` varchar(255) NOT NULL,
                                          `url` varchar(255) NOT NULL,
                                          PRIMARY KEY (`id`),
                                          UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `category` (`id`, `name`, `url`) VALUES
                                                 (1, 'Programování v PHP', 'programovani-v-php'),
                                                 (2, 'Webdesign', 'webdesign'),
                                                 (3, 'Ostatní', 'ostatni');

ALTER TABLE `article_category`
    ADD CONSTRAINT `article_category_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `article_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
                                          `id` int(11) NOT NULL AUTO_INCREMENT,
                                          `article_id` int(11) NOT NULL,
                                          `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                          `author_name` varchar(255) NOT NULL,
                                          `author_email` varchar(255) NOT NULL,
                                          `content` text NOT NULL,
                                          PRIMARY KEY (`id`),
                                          KEY `comments_blog_articles_id_fk` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `comments` (`id`, `article_id`, `date_add`, `author_name`, `author_email`, `content`) VALUES
                                                                                                      (1, 2, '2020-03-16 11:54:02', 'Michal', 'michal@mail.cz', 'Privní komentář'),
                                                                                                      (2, 1, '2020-03-17 10:58:31', 'Lukáš', 'lukas@mai.cz', 'Koment k php');
ALTER TABLE `comments`
    ADD CONSTRAINT `comments_blog_posts_id_fk` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;
COMMIT;

DROP TABLE IF EXISTS `cms`;
CREATE TABLE IF NOT EXISTS `cms` (
                                     `id` int(11) NOT NULL AUTO_INCREMENT,
                                     `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                     `on_homepage` int(11) DEFAULT '0',
                                     `has_picture` int(11) DEFAULT '0',
                                     `title` varchar(255) DEFAULT NULL,
                                     `url` varchar(255) DEFAULT NULL,
                                     `description` text,
                                     PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `cms` (`id`, `date_add`, `on_homepage`, `has_picture`, `title`, `url`, `description`) VALUES
                                                                                                      (1, '2020-03-15 10:54:29', 1, 1, 'Vítejte', 'vitejte', 'Přivítání'),
                                                                                                      (3, '2020-03-16 14:25:52', 0, 0, 'Servis', 'service', 'Obsah cms stránky servis.'),
                                                                                                      (5, '2020-03-22 09:16:08', 0, 0, 'O Nás', 'o-nas', '<p>O nás</p>');

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
                                         `id` int(11) NOT NULL AUTO_INCREMENT,
                                         `company` varchar(255) DEFAULT NULL,
                                         `street` varchar(255) DEFAULT NULL,
                                         `house_number` varchar(255) DEFAULT NULL,
                                         `zip` int(11) DEFAULT NULL,
                                         `city` varchar(255) DEFAULT NULL,
                                         `state` varchar(255) DEFAULT NULL,
                                         `email` varchar(255) DEFAULT NULL,
                                         `phone` varchar(255) DEFAULT NULL,
                                         PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `contact` (`id`, `company`, `street`, `house_number`, `zip`, `city`, `state`, `email`, `phone`) VALUES
    (1, 'Redakční systém', 'Ulice', '123', 60000, 'Město', 'Česká republika', 'admin@local.cz', '+420 605 123 456');