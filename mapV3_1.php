<!DOCTYPE html>
<html>
<head>
<script
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBlL7VtOUD-StxH1cj6rN0Ye6RFGemI30c&sensor=false">
</script>


<?
$_POST[Name] = "Thetis";
$boatName = "Thetis";

	include ("distanceCalculator.php");
    include("/inc/alexINC.inc");
  $cxn = mysqli_connect($host,$user,$passwd,$dbname)
         or die ("couldn't connect to server");

$link = mysql_connect($host,$user,$passwd)
or die("Could not connect: " . mysql_error());
mysql_selectdb("Antica",$link) or die ("Can\'t use dbmapserver : " . mysql_error());

$result1 = mysql_query("SELECT MAX(ID) as ID FROM Test WHERE Name = '$_POST[Name]'",$link); // szuka ostatniej pozycji

if (!$result1)
{
echo "no results ";
}

while($row = mysql_fetch_array($result1)) 
{
$ID = $row['ID'];
}

$result5 = mysql_query("SELECT Lat, Lon FROM Test WHERE Name = '$_POST[Name]' and ID = $ID",$link);
if (!$result5)
{
echo "no results ";
}

while($row = mysql_fetch_array($result5))
{
echo "var lat=\"".$row['Lat']."\";\n";
echo "var lng=\"".$row['Lon']."\";\n";
$latFinish = $row['Lat'];
$lonFinish = $row['Lon'];
}
$result6 = mysql_query("SELECT MIN(ID) as ID FROM Test WHERE Name = '$_POST[Name]'",$link);
if (!$result6)
{
echo "no results ";
}

while($row = mysql_fetch_array($result6)) 
{
$IDMin = $row['ID'];
}
$result7 = mysql_query("SELECT Lat, Lon FROM Test WHERE Name = '$_POST[Name]' and ID = $IDMin",$link);
if (!$result7)
{
echo "no results ";
}
while($row = mysql_fetch_array($result7))
{
$latStart = $row['Lat'];
$lonStart = $row['Lon'];

}
$distance = distanceCalculator($latStart,$lonStart,$latFinish,$lonFinish);

if ($distance >= 5000)
	{
		$zoom = 3;
	}
elseif ($distance >= 2500 and $distance < 5000)
	{
		$zoom = 4;
	}

elseif ($distance >= 1000 and $distance < 2500)
	{
		$zoom = 5;
	}
	
elseif ($distance >=300 and $distance < 1000)
	{
		$zoom = 5;
	}
elseif ($distance < 300)
	{
		$zoom = 6;
	}



echo "var zoom=$zoom";


?>


<script>
var myCenter=new google.maps.LatLng(51.508742,-0.120850);
var stockholm = new google.maps.LatLng(59.32522, 18.07002);


function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:2,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({


  position:new google.maps.LatLng(59.32522, 18.07002),
  });

marker.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
<div id="googleMap" style="width:1200px;height:680px;"></div>
</body>
</html>
