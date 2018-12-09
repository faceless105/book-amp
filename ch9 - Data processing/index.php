<?php
/*
Chapter 9 - Data Processing
Goal: Demonstrate the use of variables, loops and functions in a working application
Scenario: Process randomly generated purchase orders to generate invoice slips.

Background:
- The orders CSV is structured as such: ID | Status | Item Name | Price | Purchase Date | Processed Date | Buyer
- This writes to a new datestamped CSV instead of overwriting the existing CSV for reuseability.
*/

//first we need our invoice record
$orders = fopen("orders.csv", "r"); //this will create a refference to our file, opening it only for reading
$processed = array(); //this will store all of the records for re-indexing.

if($orders !== false){ //This makes sure that we can access the file.
	$lineNum = 0; //this will be out personal line counter
	while (($record = fgetcsv($orders, 0, ",")) !== false) { //this will process the csv file one line at a time
		$lineNum += 1; //make sure to incriment this so that we can track our position.
		if($lineNum !== 1){ //are these the document headers? If so, skip them.
			if($record[1] == "Not Processed"){ //lets see if this order has been processed
				echo "Processing Record: ".$record[0];
				$processing = processRecord($record);
				if($processing === true){ //upon success, we update the record
					$record[1] = "Processed"; //Then we update the array value to reflect that it has now been processed.
					$record[5] = date('Y-m-d',strtotime("now")); //can't forget to add the processed date!
					echo " -- Success\n";
				}
				else{
					echo " -- Error\n";
				}
			}
		}
		$processed[] = $record; //we add this record back into a clean array for re-indexing
    }
    
    fclose($orders); //once the operation is complete, close the open file
    
    $orders = fopen("orders-". date('Y-m-d',strtotime("now")) .".csv", "w"); //create a new output instead of overwriting our base file
    
    //once we've looped through the records, give some quick info
    echo "Processed ". $lineNum ." Records\n";
	
	//now that this operation is complete, we should update the orders
	foreach ($processed as $saveRecord) { //loop through each record
   		fputcsv($orders, $saveRecord); //write that record to our file
	}
	
	fclose($orders); //once the operation is complete, close the open file
    
}

/*
Description: This function will generate an invoice document
Params: $rec, this expects an array that is a line item from the invoice sheet
Returns: Return true on success, false on failure
*/
function processRecord($rec){
	//now we generate a file
	$content = "Camping Store Invoice\n"; //Start our invoice and create a new line
	$content .= "Invoice for ". $rec[6] .", Purchased on ". $rec[4] ."\n"; //concatenate the variable with more text and the items from the record.
	$content .= "One ". $rec[2] ." for $". $rec[3] ."\n\n";
	$content .= "Invoice Processed on ". date('Y-m-d',strtotime("now")); //generate todays date and formate it to YYYY-MM-DD
	
	//now we store this invoice
	$write = file_put_contents ("invoices/".$rec[0].".txt", $content); //create a new file or overwrite an existing file if it exists
	
	//if we were able to save our invoice, we consider this a successful execution
	return ($write === false ? false : true);
	
}
