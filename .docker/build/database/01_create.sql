CREATE TABLE `todo`
(
    `id`       INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL
) ENGINE = InnoDB
  CHARSET = utf8;

# login: test, heslo: test (hashed)
INSERT INTO `todo` (`id`, `title`)
VALUES (1, 'nakup'),
       (2, 'čuč'),
       (3, 'nauč'),
       (4, 'prodej');