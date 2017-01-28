/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var TestController = (function () {
        function TestController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.providers = [{ name: 1 }, { name: 2 }, { name: 3 }];
        }
        return TestController;
    }());
    Admin.TestController = TestController;
    angular.module('TestApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('TestController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TestController]);
})(Admin || (Admin = {}));
