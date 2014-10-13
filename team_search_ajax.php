<?php
	require('db.php');
	// PHP5 Implementation - uses MySQLi.
	// mysqli('localhost', 'yourUsername', 'yourPassword', 'yourDatabase');
	
		// Is there a posted query string?
		if(isset($_POST['queryString'])) {
			$queryString = troca($_POST['queryString'],"'","´");
			
			// Is the string length greater than 0?
			
			if(strlen($queryString) >0) {
				// Run the query: We use LIKE '$queryString%'
				// The percentage sign is a wild-card, in my example of countries it works like this...
				// $queryString = 'Uni';
				// Returned data = 'United States, United Kindom';
				
				// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
				// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10
				
				$sql = "SELECT it_nome FROM institutions WHERE it_nome LIKE '$queryString%' LIMIT 10";
				$rlt = db_query($sql);
				while($line = db_read($rlt)) 
					{
	         			echo '<li onClick="fill(\''.$result->it_nome.'\');">'.$result->it_nome.'</li>';
         			}
			}
		}
?>