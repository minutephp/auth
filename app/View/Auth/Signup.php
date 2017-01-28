<div class="container" ng-app="authApp" ng-controller="authController" ng-init="session.signup(true)" ng-cloak="">
    <div class="header" ng-switch="!!session.site.logo_light_url">
        <h3 ng-switch-when="true"><img src="" ng-src="{{session.site.logo_light_url}}" class="site-logo"></h3>
        <h3 ng-switch-default="">{{session.site.site_name || 'Login to continue'}}</h3>
    </div>
</div>