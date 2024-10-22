@extends('layouts.app')
@section('content')
<main class="main">
    <style>
    .back-btn {
        cursor: pointer;
    }
    </style>
    <div class="d-flex" style="padding-top:1rem;">
        <div class="back-btn" onclick="goBack()">
            <i class="fa-solid fa-arrow-left"></i>
        </div>
        <h1 style="flex:1;text-align:center;">Dashboard</h1>
    </div>
    <div style="display: flex; flex-wrap: wrap; justify-content: space-around;gap:20px">

        <div id="donut_chart" style="width: 400px; height: 300px;"></div>

        <div id="line_chart" style="width: 500px; height: 300px;"></div>

        <div id="bar_chart" style="width: 500px; height: 300px;"></div>

        <div>
            <canvas id="radar_chart" style="width: 500px; height: 300px;"></canvas>
        </div>
    </div>
</main>
@endsection
@push('scripts')

<script>
function goBack() {
    window.history.back();
}
</script>

<script>
var ctx = document.getElementById('radar_chart').getContext('2d');
var radarChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        datasets: [{
            label: 'Traffic Sources',
            data: [500, 1000, 750, 600, 800, 700, 900],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: '#000000',
            pointBackgroundColor: '#000000'
        }]
    },
    options: {
        scale: {
            ticks: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script type="text/javascript">
google.charts.load('current', {
    packages: ['corechart', 'bar']
});

google.charts.setOnLoadCallback(drawDonutChart);

function drawDonutChart() {
    var data = google.visualization.arrayToDataTable([
        ['Status', 'Count'],
        ['Active', 316],
        ['Inactive', 1000]
    ]);

    var options = {
        pieHole: 0.5,
        colors: ['#000000', '#d3d3d3'],
        legend: 'none',
        pieSliceText: 'none',
        pieStartAngle: 100,
        chartArea: {
            width: '100%',
            height: '80%'
        },
        backgroundColor: '#f5f5f5',
    };

    var chart = new google.visualization.PieChart(document.getElementById('donut_chart'));
    chart.draw(data, options);
}

google.charts.setOnLoadCallback(drawLineChart);

function drawLineChart() {
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Customers'],
        ['Jan', 1000],
        ['Feb', 1170],
        ['Mar', 660],
        ['Apr', 1030],
        ['May', 1230],
        ['Jun', 1460],
        ['Jul', 1690],
        ['Aug', 1860]
    ]);

    var options = {
        colors: ['#000000'],
        backgroundColor: '#f5f5f5',
        legend: 'none',
        chartArea: {
            width: '80%',
            height: '80%'
        },
        hAxis: {
            title: 'Month'
        },
        vAxis: {
            title: 'Customers'
        }
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
    chart.draw(data, options);
}

google.charts.setOnLoadCallback(drawBarChart);

function drawBarChart() {
    var data = google.visualization.arrayToDataTable([
        ['Source', 'Direct', 'Referral', 'Social'],
        ['Mon', 1000, 400, 200],
        ['Tue', 1170, 460, 250],
        ['Wed', 660, 1120, 300],
        ['Thu', 1030, 540, 350],
        ['Fri', 900, 550, 400]
    ]);

    var options = {
        isStacked: true,
        backgroundColor: '#f5f5f5',
        colors: ['#000000', '#777777', '#d3d3d3'],
        legend: 'none',
        chartArea: {
            width: '80%',
            height: '80%'
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('bar_chart'));
    chart.draw(data, options);
}
</script>
@endpush