<?php
	require_once('Statement.class.php');
	$html=file_get_contents("statement.html");
	Statement::toPDF($html);

?>