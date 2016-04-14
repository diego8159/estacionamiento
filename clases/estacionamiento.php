<?php


$esta;
class estacionamiento
{

	public static function Guardar($patente,$foto)
	{

		$archivo=fopen("archivos/estacionados.txt", "a");//escribe y mantiene la informacion existente		
		$ahora=date("Y-m-d H:i:s"); 
		$arrayAutos=estacionamiento::Leer();
		
		foreach ($arrayAutos as $auto){
			$NOMBRE = trim($auto[2]);
			
					if($foto==$NOMBRE)
			{	
				move_uploaded_file("Fotitos/$foto","Fotitos/$foto.$ahora");
			}
		}

		$renglon=$patente."=>".$ahora."=>".$foto."\n";
		fwrite($archivo, $renglon); 		 
		fclose($archivo);
	}


	public static function GuardarListado($listado)
	{

			$archivo=fopen("archivos/estacionados.txt","w");

			foreach ($listado as $auto)
			 {
			 	if($auto[0]!="")
			 		var_dump($auto[2]);
			 		//die();
				fwrite($archivo, $auto[0]."=>".$auto[1]."=>".$auto[2]. "\n");			
		  	}
			fclose($archivo);
	}

public static function ValidarFoto($foto){
$retorno = true;

if($foto['size']>1000000){
$retorno= false;
	}elseif($foto['type']!="image/jpeg" && $foto['type']!="image/PNG")
		$retorno= false;
	
return $retorno;
										}
//QUE LA FOTO NO PESE MAS DE 1 MEGA
	// PUEDEN SUBIR SOLO ARCHIVOS DE JPG Y PNG Y SI EL ARCHIVO EXISTE RENOMBRAR EL QUE EXISTIA, LA VIEJA LE PONE LA FECHA Y LA NUEVA EL NOMBRE ORIGINAL
	public static function Sacar($patente)
	{

		$hora =date("Y-m-d H:i:s"); 
		$arrayAutos = estacionamiento::Leer();
		$esta = false;
		foreach ($arrayAutos as $auto) {
			

			if($auto[0]!="")
			if($auto[0]==$patente) // COMPARO SI EL AUTO QUE INGRESE EN EL TEXTBOX ESTA EN EL TXT
			{

				
				unlink("Fotitos/$auto[2]");
				$esta = true; 
				$tiempo = strtotime($hora) - strtotime($auto[1]); // RESTO LA FECHA ACTUAL CON EL TIEMPO ESTACIONADO
				$facturado=fopen("archivos/facturacion.txt","a");
				$importe = $tiempo * 2;
				$reglon1 = $patente."=>".$importe."\n";
				fwrite($facturado, $reglon1);
				fclose($facturado);

			}else
			{
				if($auto[0]!="")
				{
				$listaEstacionados[]= $auto;
				}

			}

		}

		fclose($archivo);	


		if($esta)
		{
			estacionamiento::GuardarListado($listaEstacionados);	
		}
		
	}
		

	public static function Leer()
	{
		$ListaDeAutosLeida=  array();
		$archivo=fopen("archivos/estacionados.txt","r");//escribe y mantiene la informacion existente

			var_dump($archivo);
		while(!feof($archivo))
		{
			$renglon=fgets($archivo);
			//http://www.w3schools.com/php/func_filesystem_fgets.asp
			$auto=explode("=>", $renglon);
			//http://www.w3schools.com/php/func_string_explode.asp
			$auto[0]=trim($auto[0]);
			if($auto[0]!="")
				$ListaDeAutosLeida[]=$auto;
		}

		fclose($archivo);
		return $ListaDeAutosLeida;
		

	}


	public static function CrearTablaEstacionados()
	{
		if(file_exists("archivos/estacionados.txt"))
			{
				$cadena=" <table border=1><th> patente </th><th> Importe </th><th> FOTO </th>";

				$archivo=fopen("archivos/estacionados.txt", "r");

			    while(!feof($archivo))
			    {
				      $archAux=fgets($archivo);
				      //http://www.w3schools.com/php/func_filesystem_fgets.asp
				      $auto=explode("=>", $archAux);
				      //http://www.w3schools.com/php/func_string_explode.asp
				      $auto[0]=trim($auto[0]);
				      if($auto[0]!="")
				       $cadena =$cadena."<tr> <td> ".$auto[0]."</td> <td>  ".$auto[1] ."</td> <td> <img src=Fotitos/".$auto[2]. "></td> </tr>" ; 
				}

		   		$cadena =$cadena." </table>";
		    	fclose($archivo);

				$archivo=fopen("archivos/tablaestacionados.php", "w");
				fwrite($archivo, $cadena);




			}	else
			{
				$cadena= "no hay autos";

				$archivo=fopen("archivos/tablaestacionados.php", "w");
				fwrite($archivo, $cadena);
			}

	}
	public static function CrearJSAutocompletar()
	{		
			$cadena="";

			$archivo=fopen("archivos/estacionados.txt", "r");

		    while(!feof($archivo))
		    {
			      $archAux=fgets($archivo);
			      //http://www.w3schools.com/php/func_filesystem_fgets.asp
			      $auto=explode("=>", $archAux);
			      //http://www.w3schools.com/php/func_string_explode.asp
			      $auto[0]=trim($auto[0]);

			      if($auto[0]!="")
			      {
			      	 $auto[1]=trim($auto[1]);
			      $cadena=$cadena." {value: \"".$auto[0]."\" , data: \" ".$auto[1]." \" }, \n"; 
		 


			      }
			}
		    fclose($archivo);

			 $archivoJS="$(function(){
			  var patentes = [ \n\r
			  ". $cadena."
			   
			  ];
			  
			  // setup autocomplete function pulling from patentes[] array
			  $('#autocomplete').autocomplete({
			    lookup: patentes,
			    onSelect: function (suggestion) {
			      var thehtml = '<strong>patente: </strong> ' + suggestion.value + ' <br> <strong>ingreso: </strong> ' + suggestion.data;
			      $('#outputcontent').html(thehtml);
			         $('#botonIngreso').css('display','none');
      						console.log('aca llego');
			    }
			  });
			  

			});";
			
			$archivo=fopen("js/funcionAutoCompletar.js", "w");
			fwrite($archivo, $archivoJS);
	}

		public static function CrearTablaFacturado()
	{
			if(file_exists("archivos/facturacion.txt"))
			{
				$cadena=" <table border=1><th> patente </th><th> Importe </th>";

				$archivo=fopen("archivos/facturacion.txt", "r");

			    while(!feof($archivo))
			    {
				      $archAux=fgets($archivo);
				      //http://www.w3schools.com/php/func_filesystem_fgets.asp
				      $auto=explode("=>", $archAux);
				      //http://www.w3schools.com/php/func_string_explode.asp
				      $auto[0]=trim($auto[0]);
				      if($auto[0]!="")
				       $cadena =$cadena."<tr> <td> ".$auto[0]."</td> <td>  ".$auto[1] ."</td> </tr>" ; 
				}

		   		$cadena =$cadena." </table>";
		    	fclose($archivo);

				$archivo=fopen("archivos/tablaFacturacion.php", "w");
				fwrite($archivo, $cadena);




			}	else
			{
				$cadena= "no hay facturación";

				$archivo=fopen("archivos/tablaFacturacion.php", "w");
				fwrite($archivo, $cadena);
			}

	}


}


?>