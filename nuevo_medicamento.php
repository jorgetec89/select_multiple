<?
 
   $con = mysql_connect("localhost","root","123");
   mysql_set_charset('utf8',$con);
   if (!$con)  {
     die('Could not connect: ' . mysql_error());
   }
   mysql_select_db("imed", $con);

function ingrediente() { //dingrediente Y ddosisingrediente  
  $ingred_result = mysql_query("SELECT idtingrediente,ingrediente FROM tingrediente_activo");
   echo "INGREDIENTE ACTIVO  <select name='dingrediente' id='dingrediente'>";
   echo "<option value=0>Selecciona Ingrediente</option>";
   while($row=mysql_fetch_array($ingred_result)){
       echo "<option value=".$row['idtingrediente'].">".$row['ingrediente']."</option>";
   } 
   echo "</select>";  
   echo "<br>DOSIS<input type='text' name='ddosisingrediente' size='10'  /> ";
   ///////////////////LISTA DE UNIDADES
   $unidad_result = mysql_query("SELECT list_id,option_id,title FROM list_options WHERE list_id='drug_units'");
   
   echo "UNIDAD  <select name='dunidadi'  id='dunidadi'>";
   echo "<option value=0>Selecciona unidad</option>";
   while($row=mysql_fetch_array($unidad_result)){
       echo "<option value=".$row['option_id'].">".$row['title']."</option>";
   } 
   echo "</select>";  
   ///////////////////---------------------------------
}

function unidad() { //dunidad

   $unidad_result = mysql_query("SELECT list_id,option_id,title FROM list_options WHERE list_id='drug_units'");
   echo "UNIDAD  <select name='dunidad'  id='dunidad'>";
   echo "<option value=0>Selecciona unidad</option>";
   while($row=mysql_fetch_array($unidad_result)){
       echo "<option value=".$row['option_id'].">".$row['title']."</option>";

   } 

   echo "</select>";   
}

function pres_excip() { //dexcipiente
    
   $unidad_result = mysql_query("SELECT option_id,title FROM list_options WHERE list_id = 'drug_form'");
   echo "<select multiple = 'multiple' name='dexcipiente[]'  id='dexcipiente'>";
   echo "<option value=0>Selecciona Excipiente</option>";
   while($row=mysql_fetch_array($unidad_result)){
       echo "<option value=".$row['option_id'].">".$row['title']."</option>";
   
   } 

   echo "</select>";   
   echo "CANTIDAD<input type='text' name='dcantidad' value='1' size='10' required /> <br> <br> ";
}

function presentacion() 

{   //dpresentacion
   
   $unidad_result = mysql_query("SELECT idtpresentacion,presentacion FROM tpresentacion");
   echo "<select multiple = 'multiple' name='dpresentacion[]'  id='dpresentacion'>";
   echo "<option value=0>Presentacion</option>";
   while($row=mysql_fetch_array($unidad_result)){
       echo "<option value=".$row['idtpresentacion'].">".$row['presentacion']."</option>";
   } 
   echo "</select>";   
}

function via() {   //dvia   
   $via_result = mysql_query("SELECT option_id,title FROM list_options WHERE list_id = 'drug_route'");
   echo "<select name='dvia'  id='dvia'>";
   echo "<option value=0>Via</option>";
   while($row=mysql_fetch_array($via_result)){
       echo "<option value=".$row['option_id'].">".$row['title']."</option>";
   } 
   echo "</select>";   
}

function drugid() {   
    //ultimo registro de la tabla drugs
    $drugid_result=mysql_query("SELECT MAX( drug_id ) AS id FROM drugs");
     while($row=mysql_fetch_array($drugid_result)){
	 $registro=$row['id']+1;    } 
   //DESPLIEGA EN CUADRO DE TEXTO EL ULTIMO REGISTRO + 1 
   //ESTO PARA LLEVAR EL CONTEO DE REGISTROS Y PODER AGREGAR DIFERENTES INGREDIENTES A UN MISMO MEDICAMENTO
   echo "DRUG_ID <input type='text' name='did' value= ".$registro." size='10'> <br> ";  

}



?>

<!--<?//if (!$_POST){  ?> -->
	
 	<!DOCTYPE html>
	<html lang="es">	
    <head>

			<title></title>
			<meta charset="UTF-8">
			<meta name= "viewport" content= "width=device-width , initial-scale=1.0">
			<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
			<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
			

  <script language="JavaScript">
		
			var pagina="nuevo_med.php"

			
			function abrir(pagina) 

			{
			
			window.open(nuevo_med.php,'window','params');

			}

			</script>

  </head>
<div class="container">
<table class="cabecera">
    <tr>
      
      <td>
            
            <img src="/imed/images/imed/web/logo_rep.png">  
      
      </td>

      <td>
        
      <h4>   | NUEVO MEDICAMENTO </h4>
        
      </td>


    </tr>

</table>
</div>
 <hr> 
<div class="container">
<div class="well">
  
<label for="clinica">Clinica</label>
<div align = "right">
<label for="usuario">Usuario</label>
</div>
</div>
</div> 
  <body>
	
			<div class="container">

				<form action="insertar_medicamento.php" method= "post" name = "form">

					<legend>Registro de Medicamentos.</legend>
		
							<div class="span3">
					
								<label>CLAVE</label>
								<input type="text" name= "dclave">
					
							</div>
			<div class = "span3">
				<div class="ui-widget">
		
								<label for="drugs">NOMBRE: </label>
						        <input type='text' name='dnombre' class='auto'>

			</div>	
				</div>
			<div class="span3">
			
				<label>PRESENTACION</label>
				<? presentacion(); ?>

			</div>
		
			<div class="span3">
			

			<label>CONTENIDO</label>
			<input type="text" name= "dcontenido"> <b>Numero de tabletas o frascos</b>


			</div>
	
			<div class="span3">
		
				<label>DOSIS</label>
				<input type="text" name = "ddosisenvase">

			</div>
	

			<div class="span3">
			
				<? 

				unidad();	

				
				echo "<br>";

				?>
			</div>

		
			<div class="span3">
				
				<label>Via de Administración</label>
			
			<?
			via();
			?>

			</div>

		<legend>Información de ingredientes</legend>
			
			<div class="container">
			
			<?   

		     drugid();    
		     pres_excip(); 
	   	     ingrediente();            
	         echo "<br>";
	    
	    	?>

	      	<label>EQUIVALENTE</label>

	      	<input type="text" name="dequivalente" size="10" required /> <br> 
    		
    		</div>
			<hr>
				<div class="well">
				           	<a href="nuevo_med.php" onclick="abrir(this.href);return false">Agregar Ingrediente</a>
				</div>
			<hr>

        	<input type="submit" value ="Registrar" />
      		<a href="form_invc.php" target="_self"> <input type="button" name="boton" value="Regresar" /> </a>
		
			
		</form>

	</div>

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>	
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
			
		<script type="text/javascript">
			
			$(function() {
			
			//autocomplete
			$(".auto").autocomplete({
				source: "search.php",
				minLength: 1
			});				

			});
			
		</script>

	</body>



 </html>

<?
/*
 else{ 

   
   	$cervezas=$_POST["dexcipiente"]; 

   	//recorremos el array de cervezas seleccionadas. No olvidarse q la primera posición de un array es la 0 

   	for ($i=0;$i<count($cervezas);$i++) 
      	 { 
      	 echo "<br> Cerveza " . $i . ": " . $cervezas[$i]; 
      	 } 

   } 
*/

   ?>	
