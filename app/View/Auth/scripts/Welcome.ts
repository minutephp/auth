/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />

module App {
    export class WelcomeController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            $scope.data = {redir: '/members', remaining: 30};
            this.init();
        }

        init = () => {
            this.$timeout(this.countdown, 1000);
            this.$ui.popupUrl('/welcome-popup.html', true, null, {ctrl: this, data: this.$scope.data});
        };

        countdown = () => {
            if (--this.$scope.data.remaining > 0) {
                this.$timeout(this.countdown, 1000);
            } else {
                top.location.href = this.$scope.data.redir;
            }
        };
    }

    angular.module('WelcomeApp', ['MinuteFramework', 'gettext'])
        .controller('WelcomeController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', WelcomeController]);
}
