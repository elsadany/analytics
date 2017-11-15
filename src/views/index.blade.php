@extends(config('analyticsConfig.extend'))

@section(config('analyticsConfig.ContentArea'))
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Home page</h2>
    </div>
</div>
<div class="">
    <div class="row">

        <div class="col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="label label-primary pull-right">last Year</span>
                    <h5>visits</h5>
                </div>
                <div class="panel-body">
                    <h1 class="no-margins">{{$year}}</h1>
                    <small>year Sessions</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <span class="label label-info pull-right">last Month</span>
                    <h5>visits</h5>
                </div>
                <div class="panel-body">
                    <h1 class="no-margins">{{$month}}</h1>
                    <small>Month Sessions</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <span class="label label-warning pull-right">last week</span>
                    <h5>visits</h5>
                </div>
                <div class="panel-body">
                    <h1 class="no-margins">{{$week}}</h1>
                    <small>week Sessions</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <span class="label label-warning pull-right">Last Day</span>
                    <h5>visits</h5>
                </div>
                <div class="panel-body">
                    <h1 class="no-margins">{{$day}}</h1>
                    <small>last Day Sessions</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h5>Pages Views</h5>

                </div>
                <div class="panel-content">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Page Link</th>
                                <th>Views</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pageviews as $page)
                            <tr>
                                <td><small>{{$page['ga:pagePath']}}</small></td>

                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{$page['sessions']}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5>Pages Sources</h5>

                </div>
                <div class="panel-content">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Source</th>
                                <th>Sessions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagesource as $source)
                            <tr>
                                <td><small>{{$source['ga:source']}}</small></td>

                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{$source['sessions']}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5>Countries sessions in last Mounth</h5>

                </div>
                <div class="panel-content">

                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-hover margin bottom">
                                <thead>
                                    <tr>
                                        <th style="width: 1%" class="text-center">No.</th>
                                        <th>Country</th>

                                        <th class="text-center">Sessions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach($pagecountry as $key=>$value)
                                        <td class="text-center">{{$key+1}}</td>
                                        <td> {{$value['ga:country']}}
                                        </td>
                                        <td class="text-center"><span class="label label-primary">{{$value['sessions']}}</span></td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>



        </div>
        <div class="col-lg-6">
 <div class="panel panel-success">
                <div class="panel-heading">
                    <h5>Devices Sessions Last Mounth</h5> 
                </div>
       <div class="panel-content">
                <div id="piechart"></div>
        
                </div>
                </div>
     
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h5>Operating Systems Sessions</h5>

                </div>
                <div class="panel-content">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Operating System</th>
                                <th>Sessions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($systems as $system)
                            <tr>
                                <td><small>{{$system['ga:operatingSystem']}}</small></td>

                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{$system['sessions']}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>       
        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5>Last Month Channel Grouping</h5>

                </div>
                <div class="panel-content">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Channel Grouping</th>
                                <th>Users</th>
                                <th>New Users</th>
                                <th>Sessions</th>
                                <th>Bounce Rate</th>
                                <th>pages/sessions</th>
                                <th>Avg.session Durations</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($channels as $channel)
                            <tr>
                                <td><small>{{$channel['ga:channelGrouping']}}</small></td>

                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{$channel['sessions']}} </td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{$channel['users']}} </td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{$channel['newusers']}} </td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{round($channel['bounce'],1)}} % </td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{round($channel['Avgtime']/60)}} minutes </td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i>{{round($channel['avgsessions']/60)}} minutes</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>       
    </div>       
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src=".\bachend\js\plugins\flot\jquery.flot.pie.js"></script>
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages': ['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Sessions', 'Sessions'],
<?php foreach ($pagedata as $dat) { ?>
            ["<?= $dat['ga:deviceCategory'] ?>",<?= $dat['sessions'] ?>],

<?php } ?>
    ]);

    // Optional; add a title and set the width and height of the chart
    var options = {'title': 'Devices Sessions', 'width': 500, 'height': 400};

    // Display the chart inside the <div> element with id="piechart"
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}
</script>
@stop()
