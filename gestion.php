<?php
require"clases/estacionamiento.php";

$patente=$_POST['patente'];
$accion=$_POST['estacionar'];
$foto = $_FILES['archivo']['name'];

if($accion=="ingreso")
{
	 // var_dump($_FILES); // el $_FILES TRAE LOS DATOS DE LOS TIPO FILES
	// var_dump($_FILES['archivo']['name']);  //  COMOP FILES PUEDE TRAER VARIOS ARCHIVOS EN UN FORMULARIO DENTRO DE LA MATRIS SELECCIONAMOS EL NOMBRE
		
	$nomext=explode(".",$foto); // EL EXPLODE ARMA UN ARRAY, DELIMITA LOS VECTORES DEL ARRAY CON LA LETRA QUE LE ASIGNO
	
	$nombre=$patente.".".$nomext[1];
	
	 // CON ESTA FUNCION GUARDA EL ARCHIVO  LE PASO LA RUTA DEL ARCHIVO Y EL DESTINO
	//die();
	if(estacionamiento::ValidarFoto($_FILES['archivo']))
	{
	estacionamiento::Guardar($patente,$nombre);
	move_uploaded_file($_FILES['archivo']['tmp_name'],"Fotitos/$patente.$nomext[1]");
	}
	


}
else
{
	estacionamiento::Sacar($patente);

		//var_dump($datos);
}

header("location:index.php");
?>
