/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class AuthConfigController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            $scope.data = {
                fields: {'name': 'Full name', 'password': 'Password'},
                providers: [
                    {name: 'Email', url: '', icon: 'fa-envelope', description: this.gettext('Direct email signup')},
                    {name: 'Google', url: 'https://console.developers.google.com/project?authuser=0', icon: 'fa-google-plus'},
                    {name: 'Twitter', url: 'https://apps.twitter.com/app/new', icon: 'fa-twitter'},
                    {name: 'Facebook', url: 'https://developers.facebook.com/quickstarts/?platform=web', icon: 'fa-facebook'},
                    {name: 'Yahoo', url: 'https://developer.apps.yahoo.com/dashboard/createKey.html', icon: 'fa-yahoo'},
                    {name: 'GitHub', url: 'https://github.com/settings/applications/new', icon: 'fa-github'},
                    {name: 'Tumblr', url: 'https://www.tumblr.com/oauth/apps', icon: 'fa-tumblr'},
                    {name: 'LinkedIn', url: 'https://www.linkedin.com/secure/developer?newapp=', icon: 'fa-linkedin'}
                ],
                notes: {
                    'Google': 'Requires Contacts API and Google+ API',
                    'GitHub': 'Requires the GitHub hybridauth provider (install using composer)',
                    'Twitter': '1) Paste the Redirect URL in "Callback URL" 2) Set your application access to "Read only" and enable "Request email address from users" in permissions.'
                }
            };

            $scope.config = $scope.configs[0] || $scope.configs.create().attr('type', 'auth').attr('data_json', {});
            $scope.settings = $scope.config.attr('data_json');
            $scope.settings.providers = angular.isArray($scope.settings.providers) && $scope.settings.providers.length ? $scope.settings.providers : $scope.data.providers;
        }

        check = (provider) => {
            if ((provider.name !== 'Email') && provider.enabled && (!provider.key || !provider.secret)) {
                this.configure(provider)
            }
        };

        redirectUrl = function (provider) {
            let name = provider.name;
            return this.$scope.session.site.host + '/auth/hauth/' + name + '?hauth.done=' + name;
        };

        notSavedAlert = () => {
            this.$ui.closePopup();
            this.$ui.toast(this.gettext('Remember to click the "commit settings" button to save changes!'));
        };

        configure = (provider) => {
            let isEmail = provider.name === 'Email';
            this.$ui.popupUrl('/' + (isEmail ? 'email' : 'social') + '-popup.html', false, null, {data: this.$scope.data, provider: provider, ctrl: this}).then(() => {
                if (!isEmail && provider.enabled && (!provider.key || !provider.secret)) {
                    this.$timeout(() => provider.enabled = false);
                }
            });
        };

        save = () => {
            this.$scope.config.save(this.gettext('Auth saved successfully'));
        };
    }

    angular.module('authConfigApp', ['MinuteFramework', 'AdminApp', 'gettext', 'ui.sortable'])
        .controller('authConfigController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', AuthConfigController]);
}
