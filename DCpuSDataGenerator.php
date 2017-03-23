<?php
$servername = "localhost";
$username = "monitoring";
$password = "Request1";

$dbname = "charts";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "select c_CONTAINER_name,max(c_cpu__percentage) as cpuvalue,DataInserted_time from docker_stats_data where DataInserted_time <= CURDATE() GROUP BY c_CONTAINER_name";

$result = $conn->query($sql);

//$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
//create graphic values code

    $emparray = array(
      "chart" => array(
          "caption" => "Docker stats cpu usage by Containers",
          "xAxisName" => "Container Name",
          "yAxisName" => "Docker CPU usage",
          "bgColor" => "#ffffff",
          "borderAlpha"=> "20",
          "canvasBorderAlpha"=> "0",
          "usePlotGradientColor"=> "0",
          "plotBorderAlpha"=> "10",
          "showXAxisLine"=> "1",
          "xAxisLineColor" => "#999999",
          "showValues" => "0",
          "divlineColor" => "#999999",
          "divLineIsDashed" => "1",
          "showAlternateHGridColor" => "0"
        )
    );


    //create an array with data in json format code
    $emparray["data"] = array();
    while($row =mysqli_fetch_assoc($result))
    {
        array_push($emparray["data"], array(
        	"label" => $row["c_CONTAINER_name"],
        	"value" => $row["cpuvalue"],
           )         	 
        );
    }
    echo json_encode($emparray);

    //close the db connection
    mysqli_close($conn);

//write to json file
    $fp = fopen('DCpuSDataGenerator.json', 'w');
    fwrite($fp, json_encode($emparray));
    fclose($fp);
 ?> 
