<div ng-app="ngApp" ng-controller="ngAppController" ng-init="init()">
    <div class="title">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <h2><a href="" ng-href="{{session.admin}}/cron-jobs">Cron jobs</a> &gt; {{job.name || 'Untitled'}}</h2>
                </div>

            </div>
        </div>
    </div>

    <div class="content">
        <div class="box">
            <div class="bs-docs-example">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active"><a href="#details" data-toggle="tab">Cron details</a></li>
                    <li ng-if="job.cron_job_id"><a href="#history" data-toggle="tab">History (log)</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="details">
                        <div class="row">
                            <div class="col-lg-8">
                                <form class="form-horizontal" name="cronForm" ng-submit="job.saveAndRedirect('Saved');">
                                    <fieldset>
                                        <legend>Cron job details:</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="name">Name:</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" ng-model="job.name" id="name" ng-required="true" placeholder="Name" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="description">Description:</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" ng-model="job.description" id="description" placeholder="Description" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="type">Job type:</label>

                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="job.type" name="type" ng-value="'action'" ng-required="true"> PHP Controller
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="job.type" name="type" ng-value="'script'" ng-required="true"> PHP Script
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="job.type" name="type" ng-value="'route'" ng-required="true"> Ping Route
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="path">{{job.type==='route'&&'URL'||(job.type==='action'&&'Controller'||'Path')}}:</label>

                                            <div class="col-sm-10" ng-if="job.type!=='action'">
                                                <input type="text" class="form-control" ng-model="job.path" id="path" ng-required="true"
                                                       placeholder="{{job.type==='route'&&('Absolute URL or Relative URL on ' + session.site.domain)||'Absolute path to script on disk'}}" />
                                            </div>

                                            <div class="col-sm-10" ng-if="job.type==='action'">
                                                <ol class="nya-bs-select form-control" ng-model="job.path" data-live-search="true" size="15">
                                                    <li nya-bs-option="option in allHandlers group by option.type" value="option.value">
                                                        <span class="dropdown-header">{{$group}}</span>
                                                        <a>
                                                            <span>{{ option.name }}</span>
                                                            <!-- this content will be search first -->
                                                            <span class="small">{{ option.subtitle }}</span>
                                                            <!-- if the name failed, this will be used -->
                                                            <span class="glyphicon glyphicon-ok check-mark"></span>
                                                        </a>
                                                    </li>
                                                </ol>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="arguments">{{job.type==='route'&&'Run as user'||'Arguments'}}:</label>

                                            <div class="col-sm-10">
                                                <textarea class="form-control" ng-model="job.arguments" id="arguments" rows="2"
                                                          placeholder="{{job.type==='route'&&'E-mail or user_id (for ' + session.site.domain+' URLs only)'||(job.type==='action'&&'JSON encoded arguments to pass to controller'||'Arguments to pass to script')}}">
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="timing">Timing:</label>

                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="job.timing" name="timing" ng-value="'frequency'" ng-required="true"> Frequency (minutes)
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="job.timing" name="timing" ng-value="'fixed_time'" ng-required="true"> Fixed timing (every day)
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-if="job.timing==='fixed_time'">
                                            <label class="col-sm-2 control-label" for="fixed_time">Fixed timing:</label>

                                            <div class="col-sm-2">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Every day at</div>
                                                    <input type="time" class="form-control" time-fix ng-model="job.fixed_time" id="fixed_time" ng-required="true" placeholder="Fixed timing" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-if="job.timing==='frequency'">
                                            <label class="col-sm-2 control-label" for="frequency">Frequency:</label>

                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Every</div>
                                                    <input type="number" class="form-control" ng-model="job.frequency" id="frequency" ng-required="true" placeholder="Frequency" min="1" max="86400" />

                                                    <div class="input-group-addon">minute{{job.frequency>1&&'s'||'&nbsp;'}}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="enabled">Enabled:</label>

                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="job.enabled" name="enabled" ng-value="'y'"> Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="job.enabled" name="enabled" ng-value="'n'"> No
                                                </label>
                                            </div>
                                        </div>

                                        <hr />

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> {{job.cron_job_id && 'Save changes' || 'Create new job'}}</button>
                                                <button type="button" class="btn btn-default with-divider" ng-show="job.cron_job_id" ng-click="run()"><i class="fa fa-bolt"></i> Run job</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="history">
                        <div class="row">
                            <div class="col-lg-8">
                                <p ng-show="!job.cron_log.length">Cron job has never been run.</p>

                                <ul class="list-group">
                                    <li class="list-group-item" ng-repeat="log in job.cron_log">
                                        <div class="pull-right">
                                            <a class="btn btn-default btn-xs" href="#" type="button" data-toggle="collapse" data-target="#log{{$index}}">output</a>
                                            <a class="btn btn-default btn-xs" href="#" data-toggle="collapse" data-target="#errors{{$index}}">errors</a>
                                            <a class="btn btn-danger btn-xs" href="#" ng-click="log.removeConfirm('', 'Removed!');">remove</a>
                                        </div>

                                        <span class="text-capitalize">{{log.created_at | timeAgo}}:</span>
                                        <span class="label label-{{log.result==='fail'&&'danger'||log.result==='pass'&&'success'||'default'}}"
                                        ">{{log.result}}</span> (in {{log.run_time}}ms)

                                        <div class="clearfix"></div>

                                        <div class="collapse" id="log{{$index}}">
                                            <pre><h3 class="title">Output</h3>{{log.output}}</pre>
                                        </div>

                                        <div class="collapse" ng-class="{in:!$index&&log.result==='fail'}" id="errors{{$index}}">
                                            <pre><h3 class="title">Errors</h3>{{log.exceptions}}</pre>
                                        </div>
                                    </li>
                                </ul>

                                <p align="center" ng-if="job.cron_log.more()">
                                    <button type="button" class="btn btn-default" ng-click="job.cron_log.loadNextPage();">Load more</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script>
    angular.module('ngApp', ['minutephp', 'angularTimeAgo', 'nya.bootstrap.select'])
        .controller('ngAppController', function ($scope, $minutephp, $notice) {
            $minutephp.import($scope, <?= $cron_jobs ?>);
            $scope.allHandlers = <?= json_encode($allHandlers); ?>;

            $scope.init = function () {
                $scope.job = $scope.cron_jobs[0] || $scope.cron_jobs.create().set('type', 'action').set('timing', 'frequency').set('frequency', 5);
            };

            $scope.run = function () {
                $notice.confirm2("Running cron jobs manually can have unexpected consequences!<br/><br/>Are you sure you know what you're doing?", $scope.runActually, null, 'runJob',
                    'Run this cron job?', 'Run job', 'Cancel').then($scope.runActually);
            };

            $scope.runActually = function () {
                window.open($scope.session.admin + '/cron-jobs/run/' + $scope.job.cron_job_id, '_popup', 'width=640,height=480');
            };

            $(document).ready(function () {
                if ($scope.job.cron_job_id > 0) {
                    $('#myTab a:last').click();
                }
            });
        });
</script>

