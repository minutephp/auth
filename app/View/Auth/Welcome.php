<div class="container" ng-app="WelcomeApp" ng-controller="WelcomeController" ng-cloak="">
    <div class="header">
        <h3 ng-if="!!session.site.logo.dark"><img src="" ng-src="{{session.site.logo.dark}}"></h3>
        <h3 ng-if="!session.site.logo.dark">{{session.site.site_name || 'Welcome account'}}</h3>
    </div>

    <script type="text/ng-template" id="/welcome-popup.html">
        <div class="box">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Thanks for signing up!</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form class="form-horizontal">
                <div class="box-body">
                    <p><img src="http://i.imgur.com/4sJzC6D.png" width="100%"></p>
                    <p><span translate="">Please look for our email (from @{{session.site.domain}}) and click the verification link to activate your account.</span></p>
                </div>

                <hr>

                <div class="box-footer with-border">
                    <small class="pull-left hidden-xs"><span translate="">Redirecting in {{data.remaining}} seconds..</span></small>

                    <a ng-href="{{data.redir}}" class="btn btn-flat btn-primary text-bold pull-right">
                        <span translate>Continue</span> <i class="fa fa-angle-right"></i>
                    </a>

                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </script>
</div>