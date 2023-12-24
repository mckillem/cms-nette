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
    (1, 'it', 'network', 'cms@itnetwork.cz', '$2y$10$arJIJie/xGoqZayCro4yZ.pPEkt9Ps4DJBNZAHSZ/rvbOkj//K/tq', 'admin')