<div class="content-wrapper ng-cloak" ng-app="authConfigApp" ng-controller="authConfigController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">Configure signup/login providers</span></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-sign-in"></i> <span translate="">Login providers</span></li>
            </ol>
        </section>

        <section class="content">
            <form class="form-inline" name="authForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{authForm.$valid && 'success' || 'danger'}}">
                    <div class="box-body">
                        <div class="list-group">
                            <div ui-sortable ng-model="settings.providers">
                                <div class="list-group-item list-group-item-bar list-group-item-bar-sortable" ng-repeat="provider in settings.providers">
                                    <div class="pull-left">
                                        <div class="list-group-item-heading">
                                            <div class="checkbox">
                                                <label><input type="checkbox" ng-model="provider.enabled" ng-change="mainCtrl.check(provider)">
                                                    <i class="fa fa-fw {{provider.icon}}"></i> {{provider.name | ucfirst}}
                                                </label>
                                            </div>
                                        </div>
                                        <p class="list-group-item-text hidden-xs text-muted">
                                            {{provider.description || (provider.name + ' OAuth provider')}}
                                        </p>
                                    </div>

                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default btn-flat btn-sm" ng-click="mainCtrl.configure(provider)">
                                            <i class="fa fa-cog"></i> <span translate="">Configure..</span>
                                        </button>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="">Save settings</span> <i class="fa fa-fw fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <script type="text/ng-template" id="/email-popup.html">
        <div class="box">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Configure direct signup</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
            </div>

            <form class="form-horizontal" ng-submit="ctrl.notSavedAlert()" name="providerForm">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Fields:</span></label>
                        <div class="col-sm-9">
                            <label class="checkbox-inline" ng-repeat="(field, label) in data.fields">
                                <input type="checkbox" ng-model="provider.fields[field]"> {{label}}
                            </label>
                            <label class="checkbox-inline">
                                <i class="fa fa-check-square-o"></i> Email
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Settings:</span></label>
                        <div class="col-sm-9">
                            <label class="checkbox-inline"><input type="checkbox" ng-model="provider.settings.icons"> <span translate="">Show icons</span></label>
                            <label class="checkbox-inline"><input type="checkbox" ng-model="provider.settings.labels"> <span translate="">Show labels</span></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="blurb"><span translate="">Login title:</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="blurb" placeholder="Welcome back!" ng-model="provider.settings.loginTitle" ng-required="false">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="blurb"><span translate="">Signup title:</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="blurb" placeholder="Start your 14 day free trial!" ng-model="provider.settings.signupTitle" ng-required="false">
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right" ng-disabled="!providerForm.$valid">
                        <span translate>Save</span> <i class="fa fa-fw fa-angle-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="/social-popup.html">
        <div class="box box-md">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Configure </span> {{provider.name}}</b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
            </div>

            <form class="form-horizontal" ng-submit="ctrl.notSavedAlert()" name="oauthForm">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="oauth_key"><span translate="">OAuth Key:</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="oauth_key" placeholder="Enter OAuth Key" ng-model="provider.key" ng-required="true">
                            <p class="help-block"><span translate="">(also known as your Client Id)</span></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="oauth_secret"><span translate="">OAuth Secret:</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="oauth_secret" placeholder="Enter OAuth Secret" ng-model="provider.secret" ng-required="true">
                            <p class="help-block"><span translate="">(also known as your Client secret)</span></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="btn">
                            <span translate="">Button style:</span>
                            <p class="help-block"><span translate="">(optional)</span></p>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="btn-default" ng-model="provider.settings.btnClass" ng-required="false">
                            <p class="help-block"><span translate="">(button class)</span></p>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="fa-{{provider.name | lowercase}}" ng-model="provider.settings.btnIcon" ng-required="false">
                            <p class="help-block"><span translate="">(button icon)</span></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="redir_url"><span translate="">Redirect URL:</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly value="{{ctrl.redirectUrl(provider)}}" title="redirect url" onfocus="this.select()">
                            <p class="help-block text-sm" translate="">(The authorized Redirect URL for your app)</p>
                        </div>
                    </div>

                    <div class="form-group" ng-show="data.notes[provider.name]">
                        <label class="col-sm-4 control-label"><span translate="">Note:</span></label>
                        <div class="col-sm-8">
                            <p class="help-block" translate="">{{data.notes[provider.name]}}</p>
                        </div>
                    </div>

                </div>

                <div class="box-footer with-border">
                    <a href="" ng-href="{{provider.url}}" class="btn btn-flat btn-transparent pull-left" ng-disabled="!provider.url" target="_blank">
                        <span translate="">Create app</span>
                    </a>

                    <button type="submit" class="btn btn-flat btn-primary pull-right" ng-disabled="!oauthForm.$valid">
                        <b><span translate>Save</span></b> <i class="fa fa-fw fa-angle-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </script>
</div>
