
# Dump of table articles
# ------------------------------------------------------------

CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'english',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `content_filtered` text COLLATE utf8_unicode_ci NOT NULL,
  `formatting` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'A condensed version of the content',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'This is the last part of the url string. If left blank, the slug will automatically be created for you.',
  `author_id` int(10) unsigned NOT NULL COMMENT 'If left blank, you will assumed be the author.',
  `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `main_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `list_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `thumbnail_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sticky` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `allow_comments` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `publish_date` datetime NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `og_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `og_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `og_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category_id` int(10) unsigned NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `resource` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `resource_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permalink` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `fuel_permissions` (`id`, `description`, `name`, `active`)
VALUES
	(NULL, 'News', 'news', 'yes'),
	(NULL, 'News: Create', 'news/create', 'yes'),
	(NULL, 'News: Delete', 'news/delete', 'yes'),
	(NULL, 'News: Edit', 'news/edit', 'yes'),
  (NULL, 'News: Publish', 'news/publish', 'yes');