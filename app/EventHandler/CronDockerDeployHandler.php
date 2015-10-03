<?php
/**
 * Created by PhpStorm.
 * User: san
 * Date: 5/10/2015
 * Time: 4:06 PM
 */

namespace App\EventHandler {

    use Minute\Events\AddContentEvent;

    class CronDockerDeployHandler {
        public function menu(AddContentEvent $event) {
            $event->addContent('RUN crontab -l | { cat; echo "* * * * * /var/www/vendor/bin/cron-runner"; } | crontab -');
        }
    }
}