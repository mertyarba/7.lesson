<?php

	require_once("../../config.php");

	//the variable does not exist in the URL
	if (!isset($_GET["edit"])){
		
		//redirect user
		echo "redirect";
		
		header ("location: table.php");
		exit();//don't execute the code further
	}else{
		echo "User wants to edit row:".$_GET["edit"];
		
		//ask for latest data for a single row
		$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_mertyarba");
		
		//maybe user wants to save data after clicking the button
		if(isset($_GET["to"]) && isset($_GET["message"])){
			
			echo "User modified data, tries to save ";
			
			//should be validation
			
			$stmt = $mysql->prepare("UPDATE messages_sample SET recipient=?, message=? WHERE id=?");
			
			echo $mysql->error;
			
			$stmt->bind_param("ssi", $_GET["to"], $_GET["message"], $_GET["edit"]);
			
			if ($stmt->execute()){
				
				echo "saved successfully";
				
			}else{
				echo $stmt->error;
			}
			
		}else{
			
			$stmt = $mysql->prepare("SELECT id, recipient, message FROM messages_sample WHERE id=?");
		
		echo $mysql->error;
		
		//replace the "?"
		$stmt->bind_param("i", $_GET ["edit"]);
		
		//bind result data
		$stmt->bind_result($id, $recipient, $message);
		
		$stmt->execute();
		//we have only one row of data
		if ($stmt->fetch()){
			//we had data
			echo $id." ".$recipient." ".$message;
			
		}else{
			//we did not have data
			echo $stmt->error;
		}
		
			
		}
		
	
	}
	
	

?>
<br>
<a href="table.php">table</a>
<h2> First application </h2>

<form method="get">
	
	<input hidden name="edit" value="<?=$id;?>"><br><br>
	
	<label for="to">to:* <label>
	<input type="text" name="to" value="<?php echo $recipient; ?>"><br><br>
	
	<label for="message">Message:* <label>
	<input type="text" name="message" value="<?php echo $recipient; ?>"><br><br>
	
	<!-- This is the save button-->
	<input type="submit" value="Save to DB">

<form>

<p>Idea</p>
