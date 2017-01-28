/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var WelcomeController = (function () {
        function WelcomeController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.init = function () {
                _this.$timeout(_this.countdown, 1000);
                _this.$ui.popupUrl('/welcome-popup.html', true, null, { ctrl: _this, data: _this.$scope.data });
            };
            this.countdown = function () {
                if (--_this.$scope.data.remaining > 0) {
                    _this.$timeout(_this.countdown, 1000);
                }
                else {
                    top.location.href = _this.$scope.data.redir;
                }
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { redir: '/members', remaining: 30 };
            this.init();
        }
        return WelcomeController;
    }());
    App.WelcomeController = WelcomeController;
    angular.module('WelcomeApp', ['MinuteFramework', 'gettext'])
        .controller('WelcomeController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', WelcomeController]);
})(App || (App = {}));
