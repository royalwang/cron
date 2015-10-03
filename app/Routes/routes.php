<?php

use Minute\Routing\Router;

/** @var Router $router */

$router->get('/admin/cron-jobs', 'Admin/ViewCronJobs.php', 'admin', 'cron_jobs[][99]', 'cron_log[cron_jobs.cron_job_id] order by cron_log_id desc')
       ->setPermissions('CronJobs::$readPermission = "admin"');
$router->post('/admin/cron-jobs', 'Admin/ViewCronJobs.php@save', 'admin', '$model[cronjob]');

$router->get('/admin/cron-jobs/edit/:cron_job_id', 'Admin/EditCronJob.php', 'admin', 'cron_jobs[cron_job_id][]', 'cron_log[cron_jobs.cron_job_id][10] order by cron_log_id desc')
       ->setPermissions('CronJobs::$readPermission = "admin"; CronLog::$readPermission = "admin"');
$router->post('/admin/cron-jobs/edit/:cron_job_id', 'Admin/EditCronJob.php@save', 'admin', '$model[cronjob,cronlog]');

$router->get('/admin/cron-jobs/run/:cron_job_id', 'Admin/RunCronJob.php', 'admin', 'cron_job[cron_job_id]')->setPermissions('CronJobs::$readPermission = "admin"');