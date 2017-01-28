<div class="container" ng-app="VerifyAccountApp" ng-controller="VerifyAccountController" ng-cloak="">
    <div class="header">
        <h3 ng-if="!!session.site.logo.dark"><img src="" ng-src="{{session.site.logo.dark}}"></h3>
        <h3 ng-if="!session.site.logo.dark">{{session.site.site_name || 'Verify account'}}</h3>
    </div>
</div>