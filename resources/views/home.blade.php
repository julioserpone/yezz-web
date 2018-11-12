@extends('layouts.app')

@section('htmlheader_title')
Home
@endsection


@section('main-content')
	<!--div class="container spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>

					<div class="panel-body">
						test
					</div>
				</div>
			</div>
		</div>
	</div-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<!-- Apply any bg-* class to to the icon to color it -->
					<span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">{{trans('message.active_users')}}</span>
						<span class="info-box-number">{{$user_count}}</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12" >
				<div class="info-box">
					<!-- Apply any bg-* class to to the icon to color it -->
					<span class="info-box-icon bg-green"><i class="fa fa-comments-o"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">YezzTalk - {{trans('message.active_themes')}}</span>
						<span class="info-box-number">{{$themes_count}}</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<!-- Apply any bg-* class to to the icon to color it -->
					<span class="info-box-icon bg-yellow"><i class="fa fa-envelope-o"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">{{trans('message.subscribed_users')}}</span>
						<span class="info-box-number">{{$subscriptions}}</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<!-- Apply any bg-* class to to the icon to color it -->
					<span class="info-box-icon bg-red"><i class="fa fa-bookmark"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">{{trans('message.consult-no')}}</span>
						<span class="info-box-number">93,139</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<canvas id="userChart" width="95%" height="60px"></canvas>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<canvas id="themesChart" width="95%" height="60px"></canvas>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<canvas id="topUserChart" width="95%" height="60px"></canvas>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$('head').append( $('<script type="text/javascript" />').attr('src','/plugins/chartjs/Chart.bundle.js'));
		
		var data_months    = {{$months_users}};
		var data_comments  = {{$months_comments}};
		var labels_themes  = {!!html_entity_decode($top_themes)!!};
	    var data_tComments = {!!$top_comments!!};
		var data_likes     = {!!$top_likes!!};
		var data_dislikes  = {!!$top_dislikes!!};

		var userChartData =  {
			labels: ["January", "February", "March", "April", "May", "June","July", "August","September","October","November","December"],
			datasets: [
			{
				label: "Registered Users",
				backgroundColor: [
				'rgba(0, 115, 183, 0.7)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)'
				],
				borderColor: [
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)'
				],
				borderWidth: 1,
				data: data_months
			},
			{
				type: 'line',						
				label: "YezzTalk Comments Activity",
				fill: false,
				lineTension: 0.1,
				backgroundColor: "rgba(0,166,90,1)",
				borderColor: "rgba(0,166,90,1)",
				borderCapStyle: 'butt',
				borderDash: [],
				borderDashOffset: 0.0,
				borderJoinStyle: 'miter',
				pointBorderColor: "rgba(0,166,90,1)",
				pointBackgroundColor: "#fff",
				pointBorderWidth: 1,
				pointHoverRadius: 5,
				pointHoverBackgroundColor: "rgba(75,192,192,1)",
				pointHoverBorderColor: "rgba(220,220,220,1)",
				pointHoverBorderWidth: 2,
				pointRadius: 1,
				pointHitRadius: 10,
				data: data_comments,
				spanGaps: false,
			}
			]
		};

		var topUsersChartData =  {
			labels: {!!$top_users!!},
			datasets: [
              {
				type: 'line',						
				label: "Top Users",
				fill: false,
				lineTension: 0.1,
				backgroundColor: "rgba(0,166,90,1)",
				borderColor: "rgba(0,166,90,1)",
				borderCapStyle: 'butt',
				borderDash: [],
				borderDashOffset: 0.0,
				borderJoinStyle: 'miter',
				pointBorderColor: "rgba(0,166,90,1)",
				pointBackgroundColor: "#fff",
				pointBorderWidth: 1,
				pointHoverRadius: 5,
				pointHoverBackgroundColor: "rgba(75,192,192,1)",
				pointHoverBorderColor: "rgba(220,220,220,1)",
				pointHoverBorderWidth: 2,
				pointRadius: 1,
				pointHitRadius: 10,
				data: {!!$top_users_points!!},
				spanGaps: false,
			 },
			 {
				label: "Likes",
				backgroundColor: [
				'rgba(0, 115, 183, 0.7)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(54, 162, 235, 0.5)'
				],
				borderColor: [
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)'
				],
				borderWidth: 1,
				data: {!!$top_users_likes!!}
			},
			{
				label: "Dislikes",
				backgroundColor: [
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)',
				'rgba(255,99,132,0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)'
				],
				borderWidth: 1,
				data: {!!$top_users_dislikes!!}
			}

			
			]
		};


		$(document).ready(function(){
          //  userChartData.datasets[0].data = (data_months);
		//	myChart.update();

	});

		var ctx = document.getElementById("userChart");
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: userChartData,
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});

		var ctx_radar = document.getElementById("themesChart");
		var themeChart = new Chart(ctx_radar, {
			type: 'radar',
			data: {
				labels: labels_themes,
				datasets: [
				{
					label: "Most Comments",
					backgroundColor: "rgba(0,166,90,0.2)",
					borderColor: "rgba(0,166,90,1)",
					pointBackgroundColor: "rgba(179,181,198,1)",
					pointBorderColor: "#fff",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(179,181,198,1)",
					data: data_tComments
				},
				{
					label: "Likes",
					backgroundColor: "rgba(0, 115, 183, 0.2)",
					borderColor: "rgba(0, 115, 183, 1)",
					pointBackgroundColor: "rgba(0, 115, 183, 1)",
					pointBorderColor: "#fff",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(0, 115, 183, 1)",
					data: data_likes
				},
				{
					label: "Dislikes",
					backgroundColor: "rgba(255,99,132,0.2)",
					borderColor: "rgba(255,99,132,1)",
					pointBackgroundColor: "rgba(255,99,132,1)",
					pointBorderColor: "#fff",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(255,99,132,1)",
					data: data_dislikes
				}
				]
			},
			options:  {
				title:{
					display:true,
					text:"YezzTalk Themes Activity"
				},
				elements: {
					line: {
						tension: 0.0,
					}
				},
				scale: {
					beginAtZero: true,
					reverse: false
				}
			}
		});

        var ctx_topUsers = document.getElementById("topUserChart");
		var topUsersChart = new Chart(ctx_topUsers, {
			type: 'bar',
			data: topUsersChartData,
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});





		

	</script>
	@endsection
