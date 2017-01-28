<div aria-label="Signup" ng-cloak ng-init="providers = (session.providers | filter:{name:'Email'})">
    <div class="title-bar with-border">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="minute-heading pull-left">{{data.title || 'Complete signup'}}</h3>
                <a href="" ng-show="!modal" class="close-button btn btn-xs btn-default btn-transparent pull-right">&times;</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger alert-dismissible" role="alert" ng-show="!!data.error">
                <button type="button" class="close" aria-label="Close" aria-hidden="true" ng-click="data.error = ''">&times;</button>
                <ng-switch on="data.error">
                    <span ng-switch-when="EMAIL_IN_USE">
                        <span translate>Email is already registered.</span>
                        <span ng-show="!data.loginDisabled">
                            <br class="visible-xs">
                            <a href="" ng-click="data.service.login(modal)"><span translate="">Sign in</span></a> |
                            <a href="" ng-click="data.service.forgotPassword(modal)"><span translate="">Forgot password?</span></a>
                        </span>
                    </span>
                    <span translate ng-switch-when="INVALID_DATA">All fields are required.</span>
                    <span translate ng-switch-default>Unable to process signup.</span>
                </ng-switch>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form ng-submit="submit()" name="completeSignupForm">
                    <fieldset>
                        <div class="form-group">
                            <p class="help-block">{{data.msg || 'Please fill in your email address to complete your registration'}}</p>
                        </div>

                        <div class="form-group">
                            <label for="email" ng-show="!!providers[0].settings.labels">{{data.label || 'Email address:'}}</label>
                            <div ng-class="{'input-group':!!providers[0].settings.icons}">
                                <div ng-show="!!providers[0].settings.icons" class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input type="email" class="form-control auto-focus" id="email" placeholder="{{data.placeholder || 'Type your email'}}" ng-model="data.form.email"
                                       ng-required="true" minlength="3">
                                <p class="help-block text-sm" ng-show="!!data.hint">{{data.hint}}</p>
                            </div>
                        </div>

                        <div class="form-group text-collapsible">
                            <button type="submit" class="btn btn-primary pull-right btn-block" ng-if="!data.isLoading">
                                {{data.cta || 'Complete registration'}} <i class="fa fa-fw fa-angle-right"></i>
                            </button>

                            <button type="submit" class="btn btn-primary pull-right btn-block" ng-if="!!data.isLoading" ng-disabled="true">
                                <i class="fa fa-fw fa-spin fa-spinner"></i> <span translate="">Please wait..</span>
                            </button>
                        </div>

                        <div class="clearfix"></div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>