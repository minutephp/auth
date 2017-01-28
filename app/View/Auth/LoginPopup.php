<div aria-label="Login" ng-cloak="" ng-init="providers = session.providers">
    <div class="title-bar with-border">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="minute-heading pull-left">{{provider.Email.loginTitle || ('Sign in' | translate)}}</h3>
                <a href="" ng-show="!modal" class="close-button btn btn-xs btn-default btn-transparent pull-right">&times;</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger alert-dismissible" role="alert" ng-show="!!data.error">
                <button type="button" class="close" aria-label="Close" aria-hidden="true" ng-click="data.error = ''">&times;</button>
                <ng-switch on="data.error">
                    <span ng-switch-when="EMAIL_INVALID">
                        <span translate>Email is not registered.</span>
                        <a href="" ng-click="data.service.signup(modal)"><span translate="">Create account?</span></a>
                    </span>
                    <span ng-switch-when="PASSWORD_INVALID">
                        <span translate>Password is incorrect.</span>
                        <a href="" ng-click="data.service.forgotPassword(modal)"><span translate="">Forgot password?</span></a>
                    </span>
                    <span translate ng-switch-default>Unable to process login.</span>
                </ng-switch>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div ng-repeat="provider in providers" ng-show="!!provider.enabled">
                    <div ng-if="provider.name === 'Email'">
                        <hr ng-if="!!$index">
                        <form ng-submit="submit()">
                            <fieldset>
                                <legend ng-if="!!provider.settings.loginTitle">{{provider.settings.loginTitle}}</legend>

                                <div class="form-group">
                                    <label for="email" ng-show="!!provider.settings.labels"><span translate="">Email address:</span></label>
                                    <div ng-class="{'input-group':!!provider.settings.icons}">
                                        <div ng-show="!!provider.settings.icons" class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                        <input type="email" class="form-control auto-focus" id="email" placeholder="Your e-mail address" ng-model="data.form.email" ng-required="true">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" ng-show="!!provider.settings.labels"><span translate="">Password:</span></label>

                                    <div ng-class="{'input-group':!!provider.settings.icons}">
                                        <div ng-show="!!provider.settings.icons" class="input-group-addon"><i class="fa fa-key"></i></div>
                                        <input type="password" class="form-control" id="password" placeholder="Account Password" ng-model="data.form.password" ng-required="true">
                                    </div>
                                </div>

                                <div class="form-group text-collapsible">
                                    <button type="submit" class="btn btn-primary pull-right btn-block">
                                        <span translate="">Sign in</span> <i class="fa fa-fw fa-angle-right"></i>
                                    </button>

                                    <div class="clearfix"></div>
                                    <br>

                                    <div class="pull-left small">
                                        <div class="padded-bottom">
                                            <a href="" ng-click="data.service.forgotPassword(modal)"><span translate="">I forgot my password</span></a>
                                        </div>
                                        <div>
                                            <a href="" ng-click="data.service.signup(modal)"><span translate="">New user? Sign up now!</span></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </fieldset>
                        </form>
                    </div>

                    <div ng-if="provider.name !== 'Email'">
                        <div class="padded-bottom">
                            <button type="button" class="btn btn-block btn-social btn-flat text-collapsible {{provider.settings.btnClass || 'btn-default'}}" ng-click="session.socialLogin(provider.name)">
                                <i class="fa fa-fw {{provider.settings.btnIcon || ('fa-' + provider.name | lowercase)}}"></i>
                                <span translate="" class="hidden-xs">Sign in using</span> {{provider.name}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>