<div aria-label="Signup" ng-cloak ng-init="providers = (session.providers | filter:{name:'Email'})">
    <div class="title-bar with-border">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="minute-heading pull-left" translate="">Create a new password</h3>
                <a href="" ng-show="!modal" class="close-button btn btn-xs btn-default btn-transparent pull-right">&times;</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger alert-dismissible" role="alert" ng-show="!!data.error">
                <button type="button" class="close" aria-label="Close" aria-hidden="true" ng-click="data.error = ''">&times;</button>
                <span translate="">Unable to create new password.</span>
                <a href="" ng-href="/contact"><span translate="">Contact support</span></a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form ng-submit="submit()" name="createPasswordForm">
                    <fieldset>
                        <div class="form-group">
                            <p class="help-block"><span translate="">Strong passwords include numbers, letters, and punctuation marks.</span></p>
                        </div>

                        <div class="form-group">
                            <label for="password" ng-show="!!providers[0].settings.labels"><span translate="">New password:</span></label>
                            <div ng-class="{'input-group':!!providers[0].settings.icons}">
                                <div ng-show="!!providers[0].settings.icons" class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control auto-focus" id="password" placeholder="{{'Type your new password' | translate}}" ng-model="data.form.password"
                                       ng-required="true" minlength="3">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password2" ng-show="!!providers[0].settings.labels"><span translate="">Confirm new password:</span></label>
                            <div ng-class="{'input-group':!!providers[0].settings.icons}">
                                <div ng-show="!!providers[0].settings.icons" class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control auto-focus" id="password2" placeholder="{{'Type your new password one more time' | translate}}"
                                       ng-model="data.form.password2" ng-required="true" minlength="3" ng-focus="data.blur = false" ng-blur="data.blur = true">
                            </div>

                            <p align="center" class="help-block" ng-show="data.blur && !!data.form.password && !!data.form.password2 && data.form.password !== data.form.password2">
                                <span class="text-danger" translate="">Passwords do not match</span>
                            </p>
                        </div>

                        <div class="form-group text-collapsible">
                            <button type="submit" class="btn btn-primary pull-right btn-block" ng-if="!data.isLoading">
                                <span translate="">Update Password</span> <i class="fa fa-fw fa-angle-right"></i>
                            </button>

                            <button type="submit" class="btn btn-primary pull-right btn-block" ng-if="!!data.isLoading" ng-disabled="true">
                                <i class="fa fa-fw fa-spin fa-spinner"></i> <span translate="">Please wait</span>
                            </button>
                        </div>

                        <div class="clearfix"></div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>