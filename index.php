<?php

require"clases/estacionamiento.php";
$path = "gestion.php";

estacionamiento::CrearJSAutocompletar();
estacionamiento::CrearTablaFacturado();
estacionamiento::CrearTablaEstacionados();

?>
<!doctype html>
<html lang="en-US">
<head>

  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <title> Archivos </title>

  <link rel="stylesheet" type="text/css" href="css/estilo.css">
  <link rel="stylesheet" type="text/css" href="css/animacion.css">
  <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
 
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
  <script type="text/javascript" src="js/funcionAutoCompletar.js"></script>
  <!--script type="text/javascript" src="js/currency-autocomplete.js"></script-->
</head>
	<body>
    <div class="CajaUno animated bounceInDown">

            <form action="gestion.php" method="post" enctype="multipart/form-data" >  <!--ACA CON EL multipart/form-data traemos todos los tipos files como el post los input ></script-->
            <input type="text" name="patente" title="formato de patente: AAA 666" id="autocomplete"  />
            <input type="file" name="archivo" class="MiBotonUTNLinea" title="archivo" id="autocomplete"  />
            <br>
            <input type="submit" id="botonIngreso" class="MiBotonUTN" value="ingreso"  name="estacionar" />
            <br/>
            <input type="submit" class="MiBotonUTNLinea" value="egreso" name="estacionar" />
          </form>

<div id="outputbox">
    <p id="outputcontent"> 
<?php

$accion = "estacionar";
$auto;
    if($accion == "ingreso"){
      echo "SE INGRESO EL AUTO: ". $patente;

    }



?>
    </p>
  </div>

    </div>
      <div class="CajaEnunciado animated bounceInLeft">
      <h2>autos:</h2>
     

     <?php 

      include("archivos/tablaEstacionados.php");

     ?>
      
      
    </div>

     <div class="CajaEnunciadoDerecha animated bounceInLeft">
      <h2>Facturado:</h2>
     

     <?php 

      include("archivos/tablaFacturacion.php");

     ?>
      
      
    </div>
      		
	</body>
</html>