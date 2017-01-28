/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class TestController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.providers = [{name: 1}, {name: 2}, {name: 3}];
        }
    }

    angular.module('TestApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('TestController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TestController]);
}
