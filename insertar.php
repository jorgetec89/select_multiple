<?php
 
$con = mysql_connect("localhost","root","123");
mysql_set_charset('utf8',$con);
if (!$con)  {
   die('Could not connect: ' . mysql_error());
}
mysql_select_db("imed2", $con);

     $did=$_POST['did']; 
     $clave=$_POST['dclave'];   
     $nombre=$_POST['dnombre']; 
     $presentacion=$_POST['dpresentacion']; 
     $dosisenvase=$_POST['ddosisenvase']; 
     $unidad=$_POST['dunidad'];
     $via=$_POST['dvia'];
     $contenido=$_POST['dcontenido']; 
//$excipiente = $_POST['e']; 
   // $excipiente=$_POST['dexcipiente'];
     $cantidad=$_POST['dcantidad'];           
     $ingrediente=$_POST['dingrediente'];    
     $dosisingrediente=$_POST['ddosisingrediente']; 
     $unidadi=$_POST['dunidadi'];
     $equivalente=$_POST['dequivalente']; 
     $stock_max = 200;
     $stock_min = 50;
     $excipiente = ''; 


// echo "valor:". $e;
      
$consulta_drug ="SELECT * FROM drugs WHERE drug_id = '$did'";
$query = mysql_query($consulta_drug);
$ejecutar = mysql_fetch_array($consulta_drug);
$drug_id = $ejecutar['drug_id'];
$conteo = mysql_num_rows($consulta_drug);


$unidad_result = mysql_query("SELECT option_id,title FROM list_options WHERE list_id = 'drug_form'");
$recorrido = mysql_fetch_array($unidad_result);
$option_id = $recorrido['option_id'];
//$excipiente = $recorrido['title'];
//echo "excipiente " . $excipiente. "<br>";
/*for ($i=0;$i<count($excipiente);$i++) 
    
         { 

         echo "<br> Excipiente " . $i . ": " . $excipiente[$i]. "<br>"; 
         
         } 
*/


for($i = 0; $i < count($_POST['dexcipiente']); $i++) 

{ 

      $excipiente .= $_POST['dexcipiente'][$i]; 
      $sqldos="INSERT INTO tdrug_excipiente (drug_id,idtexcipiente,cantidad_exc)
                         VALUES ('$did','$excipiente[$i]','$cantidad')";
      mysql_query($sqldos);                         


}  


echo "1 ". $excipiente[$i]. "<br>";

/*$excipiente = implode("<br>",$_POST['dexcipiente']);

echo "<br>". $excipiente . "<br>";

*/
// SELECCIONA SI ES UN MEDICAMENTO NUEVO UN INGREDIENTE NUEVO EN UN MEDICAMENTO EXISTENTE 

$drugid_result2=mysql_query("SELECT MAX( drug_id ) AS id FROM drugs");
while($row=mysql_fetch_array($drugid_result2)){
      $registro2=$row['id'];
      
      //MEDICAMENTO NUEVO
      
      if ($did>$registro2) {                  
                
                $sql="INSERT INTO drugs (drug_id,ndc_number,name,size,unit,route,idtpresentacion)
                VALUES ('$did','$clave','$nombre','$dosisenvase','$unidad','$via','$presentacion')";
          
      /*          $sqldos="INSERT INTO tdrug_excipiente (drug_id,idtexcipiente,cantidad_exc)
                         VALUES ('$did','$excipiente','$cantidad')"; */

                $sqltres="INSERT INTO tdrug_ingrediente (drug_id,idtingrediente,size_ing,unit_ing,equivalente)
                         VALUES ('$did','$ingrediente','$dosisingrediente','$unidadi','$equivalente')";
                 
  
 $consulta_clinica = mysql_query("SELECT * FROM facility");
 $consu = mysql_num_rows($consulta_clinica);

 while($row = mysql_fetch_array($consulta_clinica))
 
 {

  $facility_id = $row['id'];
  $insertar_inventario = "INSERT INTO drug_inventory(drug_id,facility_id,stock,stock_max,stock_min)VALUES('$did','$facility_id',0,'$stock_max','$stock_min' )";

   if (!mysql_query($insertar_inventario,$con)) {
                   die('Error: ' . mysql_error());
                }
                   echo "1 record added,DRUG_INVENTORY";
 }

                if (!mysql_query($sql,$con)){
                   die('Error: ' . mysql_error());
                }
                   echo "1 record added, DRUGS ";

              /*  if (!mysql_query($sqldos,$con)) {
                   die('Error: ' . mysql_error());
                }
                   echo "1 record added,TDRUG_EXCIPIENTE "; */

                if (!mysql_query($sqltres,$con)){
                   die('Error: ' . mysql_error());
                }
                   echo "1 record added, TDRUG_INGREDIENTE";
                  

  }

     //AGREGAR INGREDIENTE A MEDICAMENTO EXISTENTE

     else if ($did=$registro2){
             
             $sqlcuatro="INSERT INTO tdrug_ingrediente (drug_id,idtingrediente,size_ing,unit_ing,equivalente)
                        VALUES ('$did','$ingrediente','$dosisingrediente','$unidadi','$equivalente')";
             if (!mysql_query($sqlcuatro,$con)) {
                    die('Error: ' . mysql_error());
             }
                echo "1 record added, mas ingregietes";

       }
                    
}   

mysql_close($con);

?>
