<html>
<head>
<script src="fusioncharts.js"></script>
<script type="text/javascript" src="DCpuSDataGenerator.php"></script>
<?php
// This is a simple example on how to draw a chart using FusionCharts and PHP.
// fusioncharts.php functions to help us easily embed the charts.
	include("fusioncharts.php");
?>
</head>
<body>
<?php
	 // Create the chart - Column 2D Chart with data given in constructor parameter
	 // Syntax for the constructor - new FusionCharts("type of chart", "unique chart id", "width of chart", "height of chart", "div id to render the chart", "type of data", "actual data")
	 $columnChart = new FusionCharts("line", "DCpuSDataGenerator", 800, 600, "chart-1", "jsonurl", "DCpuSDataGenerator.php");
	 // Render the chart
	 $columnChart->render();
?>
<div class="container">

<div class="center" align="center" id="chart-1"><!-- Fusion Charts will render here--></div>

</div>

</body>
</html>