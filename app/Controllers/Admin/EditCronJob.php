<?php

namespace App\Controllers\Admin {

    use Minute\Http\HttpResponse;
    use Minute\Loader\Loader;
    use Minute\Model\ActiveModel;
    use Minute\Model\Permission;
    use Minute\View\View;
    use ReflectionClass;
    use ReflectionMethod;

    class EditCronJob {

        /**
         * @param ActiveModel $cron_jobs
         * @param ActiveModel $cron_log
         */
        public function index($cron_jobs, $cron_log) {
            $allHandlers = [];

            $loader = Loader::getInstance();
            $dirs   = $loader->findDirectories(['App\\']);

            foreach ($dirs as $dir_id => $dir) {
                if ($cronPath = realpath("$dir/Controllers/Cron")) {
                    $classes = glob("$cronPath/*.php");

                    foreach ($classes as $class) {
                        if ($classPath = $loader->toPSR4('Cron', basename($class), 'App\\Controllers')) {//ucfirst(basename(dirname(dirname($class)))))) {
                            if ($reflector = new ReflectionClass($classPath)) {
                                foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                                    if (!preg_match('/^\_/', $method->name)) {
                                        $parts         = explode('vendor', $dir);
                                        $methodValue   = sprintf("%s@%s", $method->class, $method->name);
                                        $methodName    = sprintf("%s (in %s)", $methodValue, @$parts[1] ?: 'app');
                                        $allHandlers[] = ['value' => $methodValue, 'name' => $methodName, 'type' => $method->class];
                                    }
                                }
                            }
                        }
                    }
                }
            }

            View::forge('Admin/Select2/EditCronJob.php', $cron_jobs, $cron_log, ['allHandlers' => $allHandlers]);
        }

        /**
         * @param ActiveModel $model
         * @param string $cmd
         */
        public function save($model, $cmd) {
            if ($cmd == 'remove') {
                $model::$deletePermission = 'admin';

                $result = $model->delete();
            } else {
                $model::$createPermission = 'admin';
                $model::$updatePermission = 'admin';

                $result = $model->save();
            }

            HttpResponse::getInstance()->display($result, empty($result) ? 'Permission denied' : '');
        }

    }
}
