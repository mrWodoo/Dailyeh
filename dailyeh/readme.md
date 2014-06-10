## DATABASE

<code>

CREATE TABLE IF NOT EXISTS `dl_presence` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` smallint(6) unsigned NOT NULL,
  `date` date NOT NULL,
  `presence` varchar(64) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student` (`student_id`,`date`),
  KEY `id` (`id`),
  KEY `student_id` (`student_id`),
  KEY `student_id_2` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `dl_students` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) COLLATE utf8_bin NOT NULL,
  `surname` varchar(25) COLLATE utf8_bin NOT NULL,
  `pesel` varchar(11) COLLATE utf8_bin NOT NULL,
  `street_address` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3;
</code>

## HOW TO DEPLOY
1. Just put it on your server
2. Configure files: /app/config/dailyeh.php and /app/config/database.php
3. Remember about CHMODs on /app/storage