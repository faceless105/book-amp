<?php
	
function locationTools(){
	
	global $conn;
	
	$lat = getVar("lat");
	$lon = getVar("lon");
	
	if(!empty($lat) && !empty($lon)){
		
		echo "Retreiving location data for ($lat, $lon).<br>";
		$sql = $conn->prepare("SELECT * from states WHERE Contains(poly, 
		GeomFromText(
			CONCAT(
				'POINT(',
				:lon,
				' ',
				:lat,')'
			)
		)) = 1");
		$res = $sql->execute(['lon'=>$lon, 'lat'=>$lat]);
		if($res){
			$state = $sql->fetch(PDO::FETCH_ASSOC);
			echo " - You currently reside in the state of <strong>". $state['name'] ."</strong>.<br>";
			//lets get the list of state parks in here
			$sql2 = $conn->prepare("SELECT *, X(point) as 'lon', Y(point) as 'lat' FROM locations l WHERE (SELECT CONTAINS( s.poly, l.point) FROM states s WHERE s.id = :stateid) = 1");
			//$sql2 = $conn->prepare("SELECT *, ST_DISTANCE(l.point, GeomFromText(CONCAT('Point(',:lon,' ',:lat,')'))) as dist FROM locations l WHERE (SELECT CONTAINS( s.poly, l.point) FROM states s WHERE s.id = :stateid) = 1"); //for databases >= 5.5
			//$sql2 = $conn->prepare("SELECT *, ST_DISTANCE_SPHERE(l.point, GeomFromText(CONCAT('Point(',:lon,' ',:lat,')')), ) as dist FROM locations l WHERE (SELECT CONTAINS( s.poly, l.point) FROM states s WHERE s.id = :stateid) = 1"); //for databases >= 8.0
			$res2 = $sql2->execute(['stateid'=>$state['id']]);
			if($res2){
				$parks = $sql2->fetchAll(PDO::FETCH_ASSOC);
				echo " - National Parks in your state:<br>";
				foreach($parks as $park){
					if(isset($park['dist'])){
						echo " -- ". $park['name']." -- ". number_format(metersToMiles($park['dist']),2) ." miles away.<br>";
					}
					else{
						$distance = number_format(metersToMiles(getDistance($lat, $lon, $park['lat'], $park['lon'])),2);
						echo " -- ". $park['name']." -- ". $distance ." miles away.<br>";
					}
				}
			}
		}
		else{
			echo " - You are outside of the United States<br>";
		}
	}
	else{
		echo "Once you refresh the page with the current lat/lon, we can show you what you can do with them.";
	}
	
}

function getDistance($lat1, $lng1, $lat2, $lng2){
	
	$earth_radius = 6370986; //radius of earth in meters
 
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lng2 - $lng1);
 
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;
 
    return $d;
	
}

function metersToMiles($meters){
	$mi = $meters * 0.000621;
	return $mi;
}


?>
