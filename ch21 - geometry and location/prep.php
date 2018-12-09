<?php

$xml = simplexml_load_file('cb_2017_us_state_500k.kml');

$placemarks = $xml->Document->Folder->Placemark;
echo "Looking at ".sizeof($placemarks)." placemarks<br><br>\n\n";
for($i = 0; $i < sizeof($placemarks); $i++){
	
	$name = '';
	$metas = $placemarks[$i]->ExtendedData->SchemaData->SimpleData;
	foreach ($metas as $meta) {
    	if($meta['name'] == 'NAME'){
    		$name = $meta;
    		break;
    	}
	}
	echo "Name: $name<br>";
	
	//now for the coords
	$coords = '';
	@$polys = $placemarks[$i]->MultiGeometry->Polygon;
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
	@$polys = $placemarks[$i]->Polygon->outerBoundaryIs->LinearRing->coordinates;
	if($polys !== null){
		$coords0 = str_replace(","," ", $polys);
		$coords1 = str_replace(" 0.0 ",",", $coords0);
		$coords2 = "POLYGON((".substr($coords1,0,-4)."))";
		$coords = $coords2;
	}
	
	//echo "Coords: $coords<br>\n<br>\n";
	$sql = "INSERT INTO states(`name`, `poly`) VALUES('$name',GeomFromText('GEOMETRYCOLLECTION($coords)'));";
	$check = file_put_contents('./states/'.$name.'.sql', $sql);
	if($check){
		echo " -- Success<br><br>";
	}
	else{
		echo " --  Failed<br><br>";
	}
	
}


?>
