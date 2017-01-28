/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var ReadSessionController = (function () {
        function ReadSessionController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return ReadSessionController;
    }());
    Admin.ReadSessionController = ReadSessionController;
    angular.module('ReadSessionApp', ['MinuteFramework', 'gettext'])
        .controller('ReadSessionController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ReadSessionController]);
})(Admin || (Admin = {}));
