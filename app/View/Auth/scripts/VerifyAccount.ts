/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />

module App {
    export class VerifyAccountController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            this.init();
        }

        init = () => {
            let vars = this.$scope.session.view;

            if (vars.error) {
                this.$ui.alert(vars.error).then(() => top.location.href = '/');
            } else if (vars.message) {
                this.$ui.alert(vars.message).then(() => top.location.href = vars.redirect || '/');
            }
        };
    }

    angular.module('VerifyAccountApp', ['MinuteFramework', 'gettext'])
        .controller('VerifyAccountController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', VerifyAccountController]);
}
