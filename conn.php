<?php    
#echo"hola ";
echo"<br>";
	$ServerName = 'LOCALHOST\\SQLEXPRESS';
	$Info_BD = array('Database' => 'BASEBDUA', 'UID' => 'sa','PWD' => 'sqlserver');
	$Conn = sqlsrv_connect($ServerName, $Info_BD);
	if ($Conn){
		echo"Conexión Exitosa";
        echo"<br>";
	}else{
		echo"Fallo en la conexión";
        echo"<br>";
		die(print_r(sqlsrv_errors(), true));
	}
?>