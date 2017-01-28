<div aria-label="Signup" ng-cloak ng-init="providers = (session.providers | filter:{name:'Email'})">
    <div class="title-bar with-border">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="minute-heading pull-left" translate="">Reset your password</h3>
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
                    <span ng-switch-default>
                        <span translate="">Unable to reset password.</span>
                        <a href="" ng-href="/contact"><span translate="">Contact support</span></a>
                    </span>
                </ng-switch>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form ng-submit="submit()">
                    <fieldset>
                        <div class="form-group">
                            <p class="help-block"><span translate="">We will email you a link to reset your password or activate your account.</span></p>
                        </div>

                        <div class="form-group">
                            <label for="email" ng-show="!!providers[0].settings.labels"><span translate="">Email address:</span></label>
                            <div ng-class="{'input-group':!!providers[0].settings.icons}">
                                <div ng-show="!!providers[0].settings.icons" class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input type="email" class="form-control auto-focus" id="email" placeholder="Your e-mail address" ng-model="data.form.email" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group text-collapsible">
                            <button type="submit" class="btn btn-primary pull-right btn-block" ng-if="!data.isLoading">
                                <span translate="">Reset Password</span> <i class="fa fa-fw fa-angle-right"></i>
                            </button>

                            <button type="submit" class="btn btn-primary pull-right btn-block" ng-if="!!data.isLoading" ng-disabled="true">
                                <i class="fa fa-fw fa-spin fa-spinner"></i> <span translate="">Please wait</span>
                            </button>

                            <div class="clearfix"></div>
                            <br>

                            <div class="small">
                                <i class="fa fa-angle-left"></i> <a href="" ng-click="data.service.login(modal)"><span translate="">Back to sign in</span></a>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>