<div class="container" ng-app="VerifyAccountApp" ng-controller="VerifyAccountController" ng-cloak="">
    <div class="header">
        <h3 ng-if="!!session.site.logo.light"><img src="" ng-src="{{session.site.logo.light}}" class="site-logo"></h3>
        <h3 ng-if="!session.site.logo.light">{{session.site.site_name || 'Verify account'}}</h3>
    </div>
</div>