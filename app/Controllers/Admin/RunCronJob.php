<?php

namespace App\Controllers\Admin {

    use App\Models\CronJob;
    use Minute\View\View;

    class RunCronJob {

        /**
         * @param CronJob $cron_job
         */
        public function index($cron_job) {
            if (!empty($cron_job->cron_job_id)) {
                $script  = realpath(sprintf('%s/vendor/bin/script-runner', BASE_DIR));
                $run_cmd = sprintf('%s %d', $script, $cron_job->cron_job_id);
                $output  = `$run_cmd`;

                View::forgeWithoutLayout('Admin/RunCronJob.php', ['run' => json_encode(['cmd' => $run_cmd, 'result' => @json_decode($output)])]);
            }
        }
    }
}
