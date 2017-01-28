/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class AuthController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            if ($scope.session.request.msg) {
                $ui.toast($scope.session.request.msg, 'error', false, 0);
            }

            $scope.$on('session_user_login', (event, data) => {
                if (this.read(data, 'user.user_id') > 0) {
                    $timeout(() => self.location.href = $scope.session.request.redir || this.read($scope.session.site, 'urls.login') || '/members');
                }
            });

            $scope.$on('session_user_signup', (event, data) => {
                if (this.read(data, 'user.user_id') > 0) {
                    $timeout(() => self.location.href = $scope.session.request.redir || this.read($scope.session.site, 'urls.signup') || '/');
                }
            });

            $scope.$on('session_popup_submit_pass', (event, data) => {
                if (data.operation === 'forgot-password') {
                    $scope.session.login(true);

                    if (this.read(data, 'data.update') === 'PASSWORD_SENT') {
                        $ui.toast(this.gettext('Password was successfully sent to your email'), 'success');
                    } else {
                        $ui.toast(this.gettext('Unable to process request at this time'), 'error');
                    }
                } else if (data.operation === 'create-password') {
                    $scope.session.login(true);

                    if (this.read(data, 'data.update') === 'PASSWORD_RESET') {
                        $ui.toast(this.gettext('Password successfully updated.'), 'success');
                    } else {
                        $ui.toast(this.gettext('Unable to process request at this time'), 'error');
                    }
                }
            });
        }

        read = (obj, key) => {
            return key.split(".").reduce((o, x) =>(typeof o == "undefined" || o === null) ? o : o[x], obj);
        }
    }

    angular.module('authApp', ['MinuteFramework', 'gettext'])
        .controller('authController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', AuthController]);
}
