<?php

include('defaults.php'); //this will grab our credentials and helper functions

$xml = simplexml_load_file('cb_2017_us_state_500k.kml');

$states = $xml->Document->Folder->Placemark;
echo "Looking at ".sizeof($states)." placemarks<br><br>\n\n";
for($i = 0; $i < sizeof($states); $i++){
	
	$name = '';
	$metas = $states[$i]->ExtendedData->SchemaData->SimpleData;
	foreach ($metas as $meta) {
    	if($meta['name'] == 'NAME'){
    		$name = $meta;
    		break;
    	}
	}
	echo "Name: $name<br>";
	
	//now for the coords
	$coords = '';
	@$polys = $states[$i]->MultiGeometry->Polygon;
	if($polys !== null){
		foreach($polys as $poly){
			$coords0 = str_replace(","," ", $poly->outerBoundaryIs->LinearRing->coordinates);
			$coords1 = str_replace(" 0.0 ",",", $coords0);
			$coords2 = "POLYGON((".substr($coords1,0,-4).")),";
			$coords .= $coords2;
		}
		$coords = substr($coords,0,-1);
	}
	//OR
	@$polys = $states[$i]->Polygon->outerBoundaryIs->LinearRing->coordinates;
	if($polys !== null){
		$coords0 = str_replace(","," ", $polys);
		$coords1 = str_replace(" 0.0 ",",", $coords0);
		$coords2 = "POLYGON((".substr($coords1,0,-4)."))";
		$coords = $coords2;
	}
	
	//$sql = $conn->prepare("INSERT INTO states(`name`, `poly`) VALUES(':name',GeomFromText('GEOMETRYCOLLECTION(:coords)'));");
	$sql = $conn->prepare("INSERT INTO states(`name`, `poly`) VALUES(:name,GeomFromText(CONCAT('GEOMETRYCOLLECTION(', :coords, ')')));");
	$res = $sql->execute(['name'=>$name, 'coords'=>$coords]);
	
	
	if($res){
		echo "... Successfully Inserted<br><br>";
	}
	else{
		echo "... Failed<br><br>";
		print_r($sql->errorInfo());
	}
	
}


?>
