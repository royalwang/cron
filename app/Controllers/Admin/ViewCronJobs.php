<?php

namespace App\Controllers\Admin {

    use Minute\App\App;
    use Minute\Http\HttpResponse;
    use Minute\Model\ActiveModel;
    use Minute\Utils\StringUtils;
    use Minute\View\View;

    class ViewCronJobs {

        /**
         * @param ActiveModel $cron_jobs
         */
        public function index($cron_jobs) {
            $lastRun = time() - App::getInstance()->config->getKey('site/cron/lastrun', 0);

            View::forge('Admin/ListView/ViewCronJobs.php', $cron_jobs, array('lastRun' => $lastRun, 'base' => addslashes(StringUtils::unixPath(BASE_DIR))));
        }

        /**
         * @param ActiveModel $cronjob
         * @param string $cmd
         */
        public function save($cronjob, $cmd) {
            if ($cmd == 'remove') {
                $cronjob::$deletePermission = 'admin';

                $result = $cronjob->delete();
            } else {
                $cronjob::$createPermission = 'admin';
                $cronjob::$updatePermission = 'admin';

                $result = $cronjob->save();
            }

            HttpResponse::getInstance()->display($result, empty($result) ? 'Permission denied' : '');
        }

    }
}
