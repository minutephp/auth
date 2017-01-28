<div class="container" ng-app="authApp" ng-controller="authController" ng-init="session.forgotPassword(true)" ng-cloak="">
    <div class="header">
        <h3 ng-if="!!session.site.logo.dark"><img src="" ng-src="{{session.site.logo.dark}}"></h3>
        <h3 ng-if="!session.site.logo.dark">{{session.site.site_name || 'Login to continue'}}</h3>
    </div>
</div>