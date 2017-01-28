/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var VerifyAccountController = (function () {
        function VerifyAccountController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.init = function () {
                var vars = _this.$scope.session.view;
                if (vars.error) {
                    _this.$ui.alert(vars.error).then(function () { return top.location.href = '/'; });
                }
                else if (vars.message) {
                    _this.$ui.alert(vars.message).then(function () { return top.location.href = vars.redirect || '/'; });
                }
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            this.init();
        }
        return VerifyAccountController;
    }());
    App.VerifyAccountController = VerifyAccountController;
    angular.module('VerifyAccountApp', ['MinuteFramework', 'gettext'])
        .controller('VerifyAccountController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', VerifyAccountController]);
})(App || (App = {}));
