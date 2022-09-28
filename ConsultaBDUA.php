<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta SSD</title>
    <!-- link:css-->  
    <link rel="stylesheet" media="screen" type="text/css" href="css\style.css" />
    <script
      src="https://kit.fontawesome.com/7e5b2d153f.js"
      crossorigin="anonymous"
    ></script>
    <script defer src="js\index.js"></script>
    <!-- Latest compiled and minified CSS -->
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
  <header class="header">
    <nav class="nav">
      <a href="ConsultaSSD.php" class="logo nav-link">Logo</a>
      <button class="nav-toggle" aria-label="Abrir menú">
      <i class="fas fa-bars"></i>
      </button>
      <ul class="nav-menu">
        <li class="nav-menu-item">
          <a href="ConsultaBDUA.php" class="nav-menu-link nav-link">BDUA</a>
        </li>
        <li class="nav-menu-item">
          <a href="#" class="nav-menu-link nav-link">Paciente RD</a>
        </li>
        <li class="nav-menu-item">
          <a href="ConsultaDATOS.php" class="nav-menu-link nav-link">Datos</a>
        </li>
        <li class="nav-menu-item">
          <a href="#" class="nav-menu-link nav-link">Otros</a>
        </li>
      </ul> 
    </nav>
  </header>
      <form class="form-inline" action="" method="post"  accept-charset="utf-8">
        <label for="">Documento</label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
        <input class="form-control form-control-sm" type="text" name="documento" placeholder="Documento"> <br> <br>
        <label for="">Primer Apellido</label>&nbsp &nbsp &nbsp
        <input class="form-control form-control-sm" type="text" name="apellido1" placeholder="Primer Apellido"><br>
        <label for="">Segundo Apellido</label>&nbsp
        <input class="form-control form-control-sm" type="text" name="apellido2" placeholder="Segundo Apellido"> <br><br>
        <button class="btn btn-primary" type="submit" value="Buscar" name="buscar">Buscar</button>
      </form>
      <?php
      require("./conn.php");
      if (isset($_POST['documento'])) $docu = $_POST['documento'];

      if (isset($_POST['apellido1'])) $ape1 = $_POST['apellido1'];
      if (isset($_POST['apellido2'])) $ape2 = $_POST['apellido2'];

      if (isset($_POST['buscar'])) {
        
        echo "<br>";
        $sql = ("SELECT TIPO_DOC, DOCUMENTO, APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2, FECHA_NAC, GENERO, DPTO, MUNI, NOMBRE 
        FROM REDHOT.BASEBDUA B
        INNER JOIN REDHOT.ASEGURADORAS A
        ON B.COD_EPS = A.EPS
        INNER JOIN DIVIPOLA D ON
        B.COD_DPTO = D.COD_DPTO AND 
        B.COD_MUN_CONCA = D.COD_MUN
        WHERE B.DOCUMENTO IN ('$docu')");

        $sql2 = ("SELECT TIPO_DOC, DOCUMENTO, APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2, FECHA_NAC, GENERO, DPTO, MUNI, NOMBRE 
        FROM REDHOT.BASEBDUA B
        INNER JOIN REDHOT.ASEGURADORAS A
        ON B.COD_EPS = A.EPS
        INNER JOIN DIVIPOLA D ON
        B.COD_DPTO = D.COD_DPTO AND 
        B.COD_MUN_CONCA = D.COD_MUN
        WHERE APELLIDO1 = ('$ape1') and APELLIDO2 = ('$ape2') ORDER BY NOMBRE1, NOMBRE2");
        
        $stmt = sqlsrv_query($Conn, $sql);
        $stmt2 = sqlsrv_query($Conn, $sql2);

        if( $stmt === false or $stmt2 === false){
          die( print_r( sqlsrv_errors(), true) );
        }
        ?>
        <table class="table table-hover">
          <tr>
            <th>TIPO DOCUMENTO</th>
            <th>DOCUMENTO</th>
            <th>APELLIDO1</th>
            <th>APELLIDO2</th>
            <th>NOMBRE1</th>
            <th>NOMBRE2</th>
            <th>FECHA NACIMIENTO</th>
            <th>GENERO</th>
            <th>DEPARTAMENTO</th>
            <th>MUNICIPIO</th>
            <th>NOMBRE EPS</th>
          </tr>
          <?php
          while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) or $row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC)) {
            ?>
            <tr>
              <td><?php echo"$row[TIPO_DOC]" ?></td>
              <td><?php echo"$row[DOCUMENTO]"?></td>
              <td><?php echo"$row[APELLIDO1]"?></td>
              <td><?php echo"$row[APELLIDO2]"?></td>
              <td><?php echo"$row[NOMBRE1]"  ?></td>
              <td><?php echo"$row[NOMBRE2]"  ?></td>
              <td><?php echo"$row[FECHA_NAC]"?></td>
              <td><?php echo"$row[GENERO]"   ?></td>
              <td><?php echo"$row[DPTO]"     ?></td>
              <td><?php echo"$row[MUNI]"     ?></td>
              <td><?php echo"$row[NOMBRE]"   ?></td>
            </tr>
          
          <?php
          }
          ?></table><?php
        }
        ?>
  </body>
</html>