/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cron_jobs` (
  `cron_job_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('script','action','route') NOT NULL DEFAULT 'script',
  `path` varchar(255) NOT NULL,
  `arguments` varchar(255) DEFAULT NULL COMMENT 'run_as_user (when route)',
  `timing` enum('frequency','fixed_time') NOT NULL,
  `fixed_time` time DEFAULT NULL,
  `frequency` int(11) DEFAULT NULL COMMENT 'minutes',
  `single_instance` enum('y','n') DEFAULT 'y',
  `enabled` enum('y','n') NOT NULL DEFAULT 'y',
  PRIMARY KEY (`cron_job_id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cron_logs` (
  `cron_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `cron_job_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `result` enum('pending','pass','fail') NOT NULL DEFAULT 'pending',
  `run_time` double NOT NULL DEFAULT '0',
  `output` longtext,
  `exceptions` longtext,
  PRIMARY KEY (`cron_log_id`),
  KEY `cron_job_id` (`cron_job_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT IGNORE INTO `events` VALUES (NULL,'docker_deploy','App\\EventHandler\\CronDockerDeployHandler@menu',NULL,0,'Add cron-runner to crontab');
INSERT IGNORE INTO `events` VALUES (NULL,'admin_menu_render','App\\EventHandler\\CronMenuHandler@menu',NULL,0,'Cron menu in admin');