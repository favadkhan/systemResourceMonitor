<?php
$servername = "172.17.91.165";
$username = "monitoring";
$password = "Hitachi1";

$dbname = "charts";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "select * from Si_Top_Stats where virt_capacity>0 and res_capacity>0";

$result = $conn->query($sql);

//$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
//create graphic values code

    $emparray = array(
      "chart" => array(
          "caption" => "Si Process Virt/Res Stats",
          "xAxisName" => "virtual Capacity",
          "yAxisName" => "Res Capacity",
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
        	"label" => $row["virt_capacity"],
        	"value" => $row["res_capacity"]
           )         	 
        );
    }
    echo json_encode($emparray);

    //close the db connection
    mysqli_close($conn);

//write to json file
    $fp = fopen('HSASiProcessData.json', 'w');
    fwrite($fp, json_encode($emparray));
    fclose($fp);
 ?> 
