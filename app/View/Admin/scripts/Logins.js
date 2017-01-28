/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var AuthConfigController = (function () {
        function AuthConfigController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.check = function (provider) {
                if ((provider.name !== 'Email') && provider.enabled && (!provider.key || !provider.secret)) {
                    _this.configure(provider);
                }
            };
            this.redirectUrl = function (provider) {
                var name = provider.name;
                return this.$scope.session.site.host + '/auth/hauth/' + name + '?hauth.done=' + name;
            };
            this.notSavedAlert = function () {
                _this.$ui.closePopup();
                _this.$ui.toast(_this.gettext('Remember to click the "commit settings" button to save changes!'));
            };
            this.configure = function (provider) {
                var isEmail = provider.name === 'Email';
                _this.$ui.popupUrl('/' + (isEmail ? 'email' : 'social') + '-popup.html', false, null, { data: _this.$scope.data, provider: provider, ctrl: _this }).then(function () {
                    if (!isEmail && provider.enabled && (!provider.key || !provider.secret)) {
                        _this.$timeout(function () { return provider.enabled = false; });
                    }
                });
            };
            this.save = function () {
                _this.$scope.config.save(_this.gettext('Auth saved successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = {
                fields: { 'name': 'Full name', 'password': 'Password' },
                providers: [
                    { name: 'Email', url: '', icon: 'fa-envelope', description: this.gettext('Direct email signup') },
                    { name: 'Google', url: 'https://console.developers.google.com/project?authuser=0', icon: 'fa-google-plus' },
                    { name: 'Twitter', url: 'https://apps.twitter.com/app/new', icon: 'fa-twitter' },
                    { name: 'Facebook', url: 'https://developers.facebook.com/quickstarts/?platform=web', icon: 'fa-facebook' },
                    { name: 'Yahoo', url: 'https://developer.apps.yahoo.com/dashboard/createKey.html', icon: 'fa-yahoo' },
                    { name: 'GitHub', url: 'https://github.com/settings/applications/new', icon: 'fa-github' },
                    { name: 'Tumblr', url: 'https://www.tumblr.com/oauth/apps', icon: 'fa-tumblr' },
                    { name: 'LinkedIn', url: 'https://www.linkedin.com/secure/developer?newapp=', icon: 'fa-linkedin' }
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
        return AuthConfigController;
    }());
    Admin.AuthConfigController = AuthConfigController;
    angular.module('authConfigApp', ['MinuteFramework', 'AdminApp', 'gettext', 'ui.sortable'])
        .controller('authConfigController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', AuthConfigController]);
})(Admin || (Admin = {}));
