<div class="content-wrapper ng-cloak" ng-app="TestApp" ng-controller="TestController as mainCtrl" ng-init="init()" ng-cloak="">

    <section class="content debug">
        <!-- var dump start -->
        <div class="panel panel-default">
            <div class="panel-heading"><b>configs</b></div>
            <div class="panel-body">
                <div minute-list-sorter="providers" sort-index="sequence">
                    <div class="list-group-item list-group-item-bar list-group-item-bar-sortable" ng-repeat="provider in providers">
                        <div class="wellz">{{provider}}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- var dump end -->
    </section>

</div>
