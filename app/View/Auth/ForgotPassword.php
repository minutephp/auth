<div class="container" ng-app="authApp" ng-controller="authController" ng-init="session.forgotPassword(true)" ng-cloak="">
    <div class="header">
        <h3 ng-if="!!session.site.logo.light"><img src="" ng-src="{{session.site.logo.light}}" class="site-logo"></h3>
        <h3 ng-if="!session.site.logo.light">{{session.site.site_name || 'Login to continue'}}</h3>
    </div>
</div>