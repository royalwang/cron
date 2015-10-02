<?php
/**
 * Created by PhpStorm.
 * User: san
 * Date: 5/10/2015
 * Time: 4:06 PM
 */

namespace App\EventHandler {

    use Minute\Events\AddHandlerEvent;

    class CronMenuHandler {
        public function menu(AddHandlerEvent $event) {
            $menu = [['name' => 'Experts only', 'icon' => 'glyphicon glyphicon-th-large', 'priority' => 'low',
                      'sub-menu' => [['name' => 'Cron jobs', 'href' => 'cron-jobs', 'icon' => 'glyphicon glyphicon-time', 'priority' => 'low']]]];

            $event->addHandler($menu);
        }
    }
}