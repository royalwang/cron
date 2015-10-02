<div ng-app="ngApp" ng-controller="ngAppController" ng-init="init()">
    <div class="title">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <h2>Cron jobs</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-lg btn-primary" href="" ng-href="{{session.request.uri + '/edit/0'}}"><i class="fa fa-plus-circle"></i> Create new job</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="alert alert-warning alert-dismissible" role="alert" ng-if="lastRun > 3600">
            <button type="button" class="close" data-dismiss="alert">&times;</button>

            <p>It looks like you haven't configured your <code>cron manager</code> yet (or it isn't running properly).</p>

            <p>You need to add the <code>{{base}}/vendor/bin/cron-runner</code> file to the crontab (task scheduler on Windows) for your cron jobs to work properly as described
                <a href="" minute-help="crontab">here</a>.</p>
        </div>

        <div class="box">
            <table datatable="ng" class="table row-border hover graylinks">
                <thead>
                <tr>
                    <th>ID#</th>
                    <th>Created on</th>
                    <th>Name</th>
                    <th>Run at</th>
                    <th>Status</th>
                    <th>Last Run</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-links" ng-repeat="job in cron_jobs" ng-tr-link="'edit/' + job.cron_job_id">
                    <td>{{job.cron_job_id}}</td>
                    <td data-order="{{job.created_at}}">{{job.created_at | timeAgo}}</td>
                    <td>{{job.name}}</td>
                    <td>{{job.timing == 'fixed_time' && job.fixed_time + ' every day' || 'every ' + job.frequency + ' minutes'}}</td>
                    <td>
                        <span class="{{job.enabled==='y' && job.cron_log.result==='fail'&&'label label-danger'||''}}">{{job.enabled!=='y' && 'Disabled' || job.cron_log.result || 'Never run'}}</span>
                    </td>
                    <td data-order="{{job.updated_at}}">{{job.updated_at | timeAgo}}</td>
                    <td class="unclickable">
                        <div class="dropdown">
                            <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-xs btn-default">
                                <i class="fa fa-cog"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
                                <li ng-if="job.enabled!=='y'"><a href="" ng-click="job.set('enabled', 'y').save('Job enabled')"><i class="fa fa-check-circle"></i> Enable</a></li>
                                <li ng-if="job.enabled==='y'"><a href="" ng-click="job.set('enabled', 'n').save('Job disabled')"><i class="fa fa-power-off"></i> Disable</a></li>
                                <li class="divider"></li>
                                <li><a href="" ng-click="job.removeConfirm('', 'Removed')"><i class="fa fa-trash"></i> Remove</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    angular.module('ngApp', ['minutephp', 'angularTimeAgo', 'datatables', 'angularDatatableLinks'])
        .controller('ngAppController', function ($scope, $rootScope, $minutephp) {
            $minutephp.import($scope, <?= $cron_jobs ?>);
            $scope.base = '<?= $base ?>';
            $scope.lastRun = <?= $lastRun ?>;
        });
</script>

