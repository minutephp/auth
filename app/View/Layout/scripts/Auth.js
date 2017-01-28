/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var AuthController = (function () {
        function AuthController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.read = function (obj, key) {
                return key.split(".").reduce(function (o, x) { return (typeof o == "undefined" || o === null) ? o : o[x]; }, obj);
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            if ($scope.session.request.msg) {
                $ui.toast($scope.session.request.msg, 'error', false, 0);
            }
            $scope.$on('session_user_login', function (event, data) {
                if (_this.read(data, 'user.user_id') > 0) {
                    $timeout(function () { return self.location.href = $scope.session.request.redir || _this.read($scope.session.site, 'urls.login') || '/members'; });
                }
            });
            $scope.$on('session_user_signup', function (event, data) {
                if (_this.read(data, 'user.user_id') > 0) {
                    $timeout(function () { return self.location.href = $scope.session.request.redir || _this.read($scope.session.site, 'urls.signup') || '/'; });
                }
            });
            $scope.$on('session_popup_submit_pass', function (event, data) {
                if (data.operation === 'forgot-password') {
                    $scope.session.login(true);
                    if (_this.read(data, 'data.update') === 'PASSWORD_SENT') {
                        $ui.toast(_this.gettext('Password was successfully sent to your email'), 'success');
                    }
                    else {
                        $ui.toast(_this.gettext('Unable to process request at this time'), 'error');
                    }
                }
                else if (data.operation === 'create-password') {
                    $scope.session.login(true);
                    if (_this.read(data, 'data.update') === 'PASSWORD_RESET') {
                        $ui.toast(_this.gettext('Password successfully updated.'), 'success');
                    }
                    else {
                        $ui.toast(_this.gettext('Unable to process request at this time'), 'error');
                    }
                }
            });
        }
        return AuthController;
    }());
    App.AuthController = AuthController;
    angular.module('authApp', ['MinuteFramework', 'gettext'])
        .controller('authController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', AuthController]);
})(App || (App = {}));
