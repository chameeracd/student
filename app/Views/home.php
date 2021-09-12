<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Student Marks</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>

	<!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<!-- STYLES -->

	<style {csp-style-nonce}>

	</style>

	<?php
		helper('form');
	?>
</head>
<body>

<!-- HEADER: MENU + HEROE SECTION -->
<header>

</header>

<!-- CONTENT -->
<div class="container">
	<div class="row text-center"><legend>Student Marks Visualizer</legend></div>
	<?php $attributes = array("class" => "form-inline justify-content-center", "id" => "filter", "name" => "filter");
		echo form_open("home/index", $attributes);?>

		<label for="student">Student ID:</label>
		&nbsp;<?php $attributes = 'class="form-control" id="student"';
		echo form_dropdown('student', $students, set_value('student'), $attributes); ?>&nbsp;

		<label for="subject">Subject:</label>
		&nbsp;<?php $attributes = 'class="form-control" id="subject"';
		echo form_dropdown('subject', $subjects, set_value('subject'), $attributes); ?>&nbsp;

		<label for="grade">Grade:</label>
		&nbsp;<?php $attributes = 'class="form-control" id="grade"';
		echo form_dropdown('grade', $grades, set_value('grade'), $attributes); ?>&nbsp;

		<label for="year">Year:</label>
		&nbsp;<?php $attributes = 'class="form-control" id="year"';
		echo form_dropdown('year', $years, set_value('year'), $attributes); ?>&nbsp;

		&nbsp;<button type="submit" class="btn btn-primary">Submit</button>

	<?php echo form_close(); ?>

	<div class="row">
		<div id="boxplot" class="w-100"></div>
	</div>

	<div class="row">
		<div id="barchart" class="w-100"></div>
	</div>

	<div class="row">
		<div id="barchart2" class="w-100"></div>
	</div>
</div>

<!-- SCRIPTS -->

<script src="https://releases.jquery.com/git/jquery-git.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    $(function(){
		<?php if(isset($boxplot)) { ?>
			Highcharts.chart('boxplot', {

				chart: {
					type: 'boxplot'
				},

				title: {
					text: 'Boxplot'
				},

				legend: {
					enabled: false
				},

				xAxis: {
					categories: <?php echo json_encode($boxplot['categories']); ?>,
					title: {
						text: 'Subject'
					}
				},

				yAxis: {
					title: {
						text: 'Marks'
					}
				},

				series: [{
					name: 'Marks',
					data: <?php echo json_encode($boxplot['plot']); ?>,
					tooltip: {
						headerFormat: '<em>Subject {point.key}</em><br/>'
					}
				},
				{
					name: 'Student Mark',
					color: Highcharts.getOptions().colors[0],
					type: 'scatter',
					data: <?php echo json_encode($boxplot['data']); ?>,
					marker: {
						fillColor: 'white',
						lineWidth: 1,
						lineColor: Highcharts.getOptions().colors[0]
					},
					tooltip: {
						pointFormat: 'Mark: {point.y}'
					}
				}]

			});
		});
	<?php } ?>

	<?php if(isset($barchart)) { ?>
		Highcharts.chart('barchart', {
			chart: {
				zoomType: 'xy'
			},
			title: {
				text: 'Total/Avg Marks for Subject'
			},
			xAxis: [{
				categories: <?php echo json_encode($barchart['categories']); ?>,
				crosshair: true
			}],
			yAxis: [{ // Primary yAxis
				labels: {
					format: '{value}',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Avg',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				}
			}, { // Secondary yAxis
				title: {
					text: 'Marks',
					style: {
						color: Highcharts.getOptions().colors[0]
					}
				},
				labels: {
					format: '{value}',
					style: {
						color: Highcharts.getOptions().colors[0]
					}
				},
				opposite: true
			}],
			tooltip: {
				shared: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 120,
				verticalAlign: 'top',
				y: 100,
				floating: true,
				backgroundColor:
					Highcharts.defaultOptions.legend.backgroundColor || // theme
					'rgba(255,255,255,0.25)'
			},
			series: [{
				name: 'Marks',
				type: 'column',
				yAxis: 1,
				data: <?php echo json_encode($barchart['total']); ?>
			},
			{
				name: 'Avg',
				type: 'spline',
				data: <?php echo json_encode($barchart['avg']); ?>
			}]
		});
	<?php } ?>

	<?php if(isset($barchart2)) { ?>
		Highcharts.chart('barchart2', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Subject Marks'
			},
			xAxis: {
				categories: <?php echo json_encode($barchart2['categories']); ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Marks'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: <?php echo json_encode($barchart2['series']); ?>
		});

		console.log(<?php echo json_encode($barchart2['series']); ?>)
	<?php } ?>

	jQuery.validator.setDefaults({
		errorElement: 'span',
		errorPlacement: function (error, element) {
			error.addClass('invalid-feedback');
			element.closest('.form-group').append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
		}
	});

	$("#filter").validate();
</script>

<!-- -->

</body>
</html>