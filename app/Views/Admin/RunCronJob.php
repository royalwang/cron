<!DOCTYPE html>
<html lang="en" ng-app="runApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cron job output</title>

    <link rel="stylesheet" href="/static/bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/static/bower_components/bootstrap/dist/css/bootstrap-theme.min.css" />

    <script src="/static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/static/bower_components/angular/angular.min.js"></script>
    <script src="/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container" ng-controller="runCtrl">
        <form class="form-horizontal" name="outputForm">
            <fieldset>
                <legend>Cron job run results</legend>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="cmd">Run command:</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" ng-model="run.cmd" id="cmd" ng-required="true" placeholder="Run command" readonly />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="output">Output log:</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" ng-model="run.result.output" id="output" rows="3" cols="80" ng-required="true" placeholder="Cron job output log" readonly></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="output">Error log:</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" ng-model="run.result.errors" id="error" rows="3" cols="80" ng-required="true" placeholder="Cron job error log" readonly></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-primary" ng-click="top.close();"><i class="fa fa-check-circle"></i> Close window</button>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </fieldset>
        </form>
    </div>
    <script>
        angular.module('runApp', [])
            .controller('runCtrl', ['$scope', function ($scope) {
                $scope.run = <?= $run; ?>;
            }]);
    </script>
</body>
</html>