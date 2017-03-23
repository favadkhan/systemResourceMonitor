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
$sql = "select CONCAT(c_date,' ',c_time) as DateTime,c_used,c_free from VM_stats where c_time >= CURDATE() GROUP BY c_free";

$result = $conn->query($sql);

//$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
//create graphic values code

    $emparray = array(
      "chart" => array(
          "caption" => "System Memory Consumption Graph",
          "xAxisName" => "Daily",
          "yAxisName" => "Usage",
          "paletteColors" => "#0075c2",
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
        	"label" => $row["DateTime"],
        	"value" => $row["c_free"]
            )         	 
        );
    }
    echo json_encode($emparray);

    //close the db connection
    mysqli_close($conn);

//write to json file
    $fp = fopen('freeMemory.json', 'w');
    fwrite($fp, json_encode($emparray));
    fclose($fp);
?> 
