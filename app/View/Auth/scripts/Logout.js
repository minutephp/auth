/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var LogoutController = (function () {
        function LogoutController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return LogoutController;
    }());
    Admin.LogoutController = LogoutController;
    angular.module('LogoutApp', ['MinuteFramework', 'gettext'])
        .controller('LogoutController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', LogoutController]);
})(Admin || (Admin = {}));
