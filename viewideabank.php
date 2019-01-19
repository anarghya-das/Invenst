<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invenst</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="Invenst-Idea-Bank\Invenststyle.css">
</head>
<body>
<div class="banner">The Idea Bank</div>
  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for ideas..">
  <input type="image" id="Alexa" src="Invenst-Idea-Bank\Idea Bank Icons\Alexa.png" width="40px;" height="40px;" onclick="filter(this.id)" title="Alexa">
  <input type="image" id="Chrome" src="Invenst-Idea-Bank\Idea Bank Icons\Chrome.png" width="40px;" height="40px;" onclick="filter(this.id)" title="Chrome">
  <input type="image" id="Financial" src="Invenst-Idea-Bank\Idea Bank Icons\Financial.png" width="40px;" height="40px;" onclick="filter(this.id)" title="Financial">
  <input type="image" id="Hardware" src="Invenst-Idea-Bank\Idea Bank Icons\Hardware.png" width="40px;" height="40px;" onclick="filter(this.id)" title="Hardware">
  <input type="image" id="Health" src="Invenst-Idea-Bank\Idea Bank Icons\Health.png" width="40px;" height="40px;" onclick="filter(this.id)" title="Health">
  <input type="image" id="IOT" src="Invenst-Idea-Bank\Idea Bank Icons\IOT.png" width="40px;" height="40px;" onclick="filter(this.id)" title="IOT">
  <input type="image" id="Mobile" src="Invenst-Idea-Bank\Idea Bank Icons\Mobile.png" width="40px;" height="40px;" onclick="filter(this.id)" title="Mobile">
  <input type="image" id="University" src="Invenst-Idea-Bank\Idea Bank Icons\University.png" width="40px;" height="40px;" onclick="filter(this.id)" title="University">
  <input type="image" id="Wearable" src="Invenst-Idea-Bank\Idea Bank Icons\Wearable.png" width="40px;" height="40px;" onclick="filter(this.id)" title="Wearable">
  <input type="image" id="Web" src="Invenst-Idea-Bank\Idea Bank Icons\Web.png" width="40px;" height="40px;" onclick="filter(this.id)" title="Web">
 <table id="myTable" align="right">
   <tr class="header">
     <th class="headerName" style="width:20%;">Idea</th>
     <th class="headerName" style="width:10%;">Type</th>
     <!-- <th class="headerName" style="width:40%;">People Working</th> -->
   </tr>

<?php
function IsNullOrEmpty($question){
    return (!isset($question) || trim($question)==='');
}
ini_set('display_errors', 1); error_reporting(-1);

$configfile = "connect.cfg";

$myfile = fopen($configfile, "r") or die("Unable to open file!");
$line = trim(fgets($myfile));
parse_str($line, $config);
fclose($myfile);

$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];
$conn = null;
// Create connection
try{
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
  echo "connection error";
}

$sql = "SELECT * FROM idea_bank where idea_status = 'APPROVED'";
$result = $conn->query($sql);

foreach($result as $row ) {

$resources = "";
$team = "";

if (!IsNullOrEmpty($row["idea_resources"])){
  $resources = "<p><em>What might the team need to succeed?</em><br>".$row["idea_resources"]."</p>";
}
if (!IsNullOrEmpty($row["idea_team"])){
 $team = "<p><em>What sort of team will it take?</em><br>".$row["idea_team"]."</p>";
}
echo "<tr><td><div class=\"container\"><button class=\"view\"><img src=\"Invenst-Idea-Bank\invenst3.PNG\" class=\"circlecrop\" style=\"float:left;display:inline-block;\" width=\"50px;\" height=\"50px;\"><i class=\"fa fa-fw fa-chevron-down\" style=\"float:right;display:inline-block;\" width=\"50px;\" height=\"50px;\"></i><h2>".$row["idea_name"]."</h2></button> <div class=\"fold\">
<p>".$row["idea_description"]."</p>".$resources.$team."<a class=\"getstarted\" href=\"https://docs.google.com/forms/d/e/1FAIpQLSdiT9sDnfxA61PEsG4-HcMIieiIj5tpLn-ThlE41pGrbOSD9Q/viewform?entry.972833926=".$row["idea_name"]."\"> I'm Interested!</a></div></div></td><td>";

    $taglist = array();
    if (!IsNullOrEmpty($row["tag_list"])){
    $taglist = str_getcsv($row["tag_list"]);
    $tagarrayLength=count($taglist);
      for($i=0; $i<$tagarrayLength; $i++){
        $rowTagExt="Invenst-Idea-Bank/Idea Bank Icons/".trim($taglist[$i]).".png";
        $rowTag=$taglist[$i];
        if($i==$tagarrayLength-1){
        echo "<img src=\"$rowTagExt\" id=\"$rowTag\" width=\"30px;\" height=\"30px;\" title=\"$rowTag\"></td></tr>";
        // echo "<div>".$rowTagExt."</div></td></tr>";
        }else{
          echo "<img src=\"$rowTagExt\" id=\"$rowTag\" width=\"30px;\" height=\"30px;\" title=\"$rowTag\" hspace=\"5\">";
          // echo "<div>".$rowTagExt."</div>";
        }
      }
    }else{
      echo "No Tags</td></tr>";
    }
}

?>
</table>
</body>
<script src="Invenst-Idea-Bank\ideaBankScript.js"></script>
</html>