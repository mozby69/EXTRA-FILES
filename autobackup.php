<?php
    
    error_reporting(0);
	function backDb($host, $user, $pass, $dbname, $tables = '*'){
	
		$conn = new mysqli($host, $user, $pass, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		
		if($tables == '*'){
			$tables = array();
			$sql = "SHOW TABLES";
			$query = $conn->query($sql);
			while($row = $query->fetch_row()){
				$tables[] = $row[0];
			}
		}
		else{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
	
		$outsql = '';
		foreach ($tables as $table) {
    
		   
		    $sql = "SHOW CREATE TABLE $table";
		    $query = $conn->query($sql);
		    $row = $query->fetch_row();
		    
		    $outsql .= "\n\n" . $row[1] . ";\n\n";
		    
		    $sql = "SELECT * FROM $table";
		    $query = $conn->query($sql);
		    
		    $columnCount = $query->field_count;

		   
		    for ($i = 0; $i < $columnCount; $i ++) {
		        while ($row = $query->fetch_row()) {
		            $outsql .= "INSERT INTO $table VALUES(";
		            for ($j = 0; $j < $columnCount; $j ++) {
		                $row[$j] = $row[$j];
		                
		                if (isset($row[$j])) {
		                    $outsql .= '"' . $row[$j] . '"';
		                } else {
		                    $outsql .= '""';
		                }
		                if ($j < ($columnCount - 1)) {
		                    $outsql .= ',';
		                }
		            }
		            $outsql .= ");\n";
		        }
		    }
		    
		    $outsql .= "\n"; 
		}

		$date_now = date("m-d-Y",time());

	
	    $backup_file_name = "C:/backup/".$dbname ." ". $date_now . '_database.sql';
	    $fileHandler = fopen($backup_file_name, 'w+');
	    fwrite($fileHandler, $outsql);
	    fclose($fileHandler);

	   
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($backup_file_name));
	    ob_clean();
	    flush();
	    readfile($backup_file_name);
	    exec('rm ' . $backup_file_name);

	}

	$server = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'emb_appform';
	$tables = '*';


	backDb($server, $username, $password, $dbname, $tables);

?>

<!-- vector map CSS -->
<link href="auto_backup_scripts/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
		
<link href="auto_backup_scripts/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">

<!-- switchery CSS -->
<link href=auto_backup_scripts/vendors/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" type="text/css"/>

<!-- Custom CSS -->
<link href="auto_backup_scripts/dist/css/style.css" rel="stylesheet" type="text/css">

<!-- JavaScript -->
<script src="auto_backup_scripts/vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
<!-- Bootstrap Core JavaScript -->
<script src="auto_backup_scripts/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="auto_backup_scripts/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>

<!-- Fancy Dropdown JS -->
<script src="auto_backup_scripts/dist/js/dropdown-bootstrap-extended.js"></script>

<!-- Owl JavaScript -->
<script src="auto_backup_scripts/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>

<!-- Switchery JavaScript -->
<script src="auto_backup_scripts/vendors/bower_components/switchery/dist/switchery.min.js"></script>

<!-- Init JavaScript -->
<script src="auto_backup_scripts/dist/js/toast-data.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="auto_backup_scripts/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>

<!-- Slimscroll JavaScript -->
<script src="auto_backup_scripts/dist/js/jquery.slimscroll.js"></script>

<!-- Init JavaScript -->
<script src="auto_backup_scripts/dist/js/init.js"></script>