<p>
  <?php 
include 'motor/busqueda.php';
$docParam = "";
$cargar = 0;

if (isset($_POST['documento'])){
  $docParam = $_POST['documento'];
  indexarDoc($docParam); //indexa documento
}elseif (isset($_GET['cargar'])){
  $cargar=$_GET['cargar'];
}

if($cargar == 1)
{
  $fp = file("documentos/lista");  
  foreach($fp as $linea)
  {
    $linea = trim($linea);
    echo "Cargando archivo: $linea<br>";
    indexarDoc($linea);
  }
}

function indexarDoc($documento)
{
  echo"Esta es la dirección: ".$documento."<br>";
  if(strcmp($documento,"")!=0)
  {
        $b=new Busqueda();
        $aux=split('//',$documento);
        $url=implode("/",$aux); 
        $url = "documentos/" . $url;
        echo "URL: $url<br>";
        $archiv=fopen($url,"r") or die ("Error: No existe el archivo"); 

        if ($archiv == true)
        {
        }
                $titulos = split('[//.\\]',strrev($documento));
                $titulo = strrev($titulos[1]);
                $url=str_replace("\\","/",$url);                   

                $consulta1=mysql_query("SELECT count(titulo) as des FROM documento where titulo = '$titulo';");
                $resultado1 = mysql_fetch_array($consulta1)or die(mysql_error());
            if($resultado1["des"]==0)
            {
                //echo "Esta es la dirección: ".$documento."<br>";
                //
                //$documento=substr($documento,36);
                $documento= "documentos/$documento";
                //echo "Esta es la dirección: ".$documento."<br>";

                mysql_query("INSERT documento VALUES ('NULL','$titulo','$documento')") or die("no inserto en documento");
                $iddoc = mysql_insert_id();
                //$cont = 1;
                /***MIS VARIABLES***/
                $aux = 1;
                $rank = 0;
                $miPosicion = 0;
                
               while (!feof($archiv))
                {
                    $z = fgetss($archiv, 1024);
                    $temp=str_replace("'"," ",$z);                        
                    $trozos = explode (" ", $temp);

                    for($i=0;$i < count($trozos); $i++)
                    {
                            $termino=strtolower($trozos[$i]);
                            $termino=$b->eliminarBasura($termino);
                            $termino=$b->borrarBasura($termino);
                            $termino=strrev($b->borrarBasura(strrev($termino)));
                            $termino=strrev($b->caracteresEspeciales(strrev($termino)));
                            $termino=trim($termino);
                            $termino=$b->caracteresEspeciales($termino);
                            //echo "$termino<br>";
                            if($termino!='' && $termino!='\r\n')
                            {   
                                $stp= $b->quitarStopword($termino);
                                if($stp == 0)
                                {
                                // Si el termino (palabra) tiene 1,2 o 3 letras como maximo
                                    if(strlen($termino)<=3)
                                    {
                                        $query=mysql_query("SELECT idPosteo FROM posteo where termino = '$termino';");
                                        $n= mysql_num_rows($query);
                                        if($n==0)
                                        {
                                            //**BORRAARRRRRRRRRR*/
                                            //echo("entra a IF 1, ");
                                            mysql_query("INSERT posteo  VALUES ('NULL','$termino')");
                                            $identi =mysql_insert_id();
                                            mysql_query("INSERT documento_has_posteo  VALUES ('$identi','$iddoc', 1)");
                                            /***MI VARIABLE***/
                                            $miPosicion += 1;
                                            //BORRAARRRRRRRRRR
                                            //echo("Guardo posicion, idPal: " .$identi.", ");
                                            mysql_query("INSERT posicion  VALUES ('$iddoc','$identi', '$miPosicion')");
                                        }
                                        else{
                                            $resul = mysql_fetch_array($query)or die(mysql_error());                                        
                                            $var2=$resul["idPosteo"];

                                            /*****/
                                            $miquery=mysql_query("SELECT * FROM documento_has_posteo where  idDocumento='$iddoc' and idPosteo='$var2';");

                                            $aux2= mysql_num_rows($miquery);
                                            // Si la palabra de hasta 3 letras no existia
                                            if($aux2 > 0)
                                            {
                                                //**BORRAARRRRRRRRRR*/
                                                //echo("entra a 1 if, con VALOR: " .$var2);
                                                $miquery2=mysql_query("SELECT * FROM documento_has_posteo where idDocumento='$iddoc' and idPosteo='$var2';");
                                                $ress = mysql_fetch_array($miquery2)or die(mysql_error());
                                                $rank=$ress['cantidad'];
                                                $rank = $rank + 1;
                                                
                                                mysql_query("UPDATE documento_has_posteo SET cantidad = '$rank' WHERE idDocumento='$iddoc' and idPosteo='$var2'");
                                            }
                                            // Si ya existe la palabra de hasta 3 letras de un documento anterior
                                            else
                                            {
                                                //**BORRAARRRRRRRRRR*/
                                                //echo("entra a 1 else, ");
                                                $rank = 1;
                                            }    
                                            mysql_query("INSERT documento_has_posteo  VALUES ('$var2', '$iddoc', '$rank')");
                                                /***MI VARIABLE***/
                                            $miPosicion += 1;
                                            //BORRAARRRRRRRRRR
                                            //echo("Guardo posicion, idPal: " .$var2.", ");
                                            mysql_query("INSERT posicion  VALUES ('$iddoc','$var2', '$miPosicion')");
                                        }    
//                                        $cont++;
                                    }//fin del if trslen
                                    else{
                                        $term=$b->eliminarSufijo($termino);
                                        $query=mysql_query("SELECT idPosteo FROM posteo where termino = '$term';");
                                        $n= mysql_num_rows($query);
                                        $rank ++;
                                        // Si la palabra NO esta posteada entra al if
                                        if($n==0)
                                        {
                                            //**BORRAARRRRRRRRRR*/
                                            //echo("entra al IF 2, ");
                                            mysql_query("INSERT posteo  VALUES ('NULL','$term')");
                                            $identi = mysql_insert_id();
                                            
                                            mysql_query("INSERT documento_has_posteo  VALUES ('$identi','$iddoc', 1)");
                                            /***MI VARIABLE***/
                                            $miPosicion += 1;
                                            //BORRAARRRRRRRRRR
                                            //echo("Guardo posicion, ");
                                            mysql_query("INSERT posicion  VALUES ('$iddoc','$identi', '$miPosicion')");
                                        }
                                        // Si la palabra SI esta posteada entra al else
                                        else{
                                            $resul = mysql_fetch_array($query)or die(mysql_error());
                                            $var2=$resul["idPosteo"];
                                            
                                            $miquery=mysql_query("SELECT * FROM documento_has_posteo where  idDocumento='$iddoc' and idPosteo='$var2';");

                                            $aux2= mysql_num_rows($miquery);
                                            // Entra si la palabra no existe en anteriores documentos
                                            if($aux2 > 0)
                                            {
                                                //**BORRAARRRRRRRRRR*/
                                                //echo("entra a 2 if, ");
                                                $miquery2=mysql_query("SELECT * FROM documento_has_posteo where idDocumento='$iddoc' and idPosteo='$var2';");
                                                $ress = mysql_fetch_array($miquery2)or die(mysql_error());
                                                $rank=$ress['cantidad'];
                                                $rank = $rank + 1;
                                                
                                                mysql_query("UPDATE documento_has_posteo SET cantidad = '$rank' WHERE idDocumento='$iddoc' and idPosteo='$var2'");
                                                /***MI VARIABLE*/
                                                $miPosicion += 1;
                                                //BORRAARRRRRRRRRR
                                                //echo("Guardo posicion, ");
                                                mysql_query("INSERT posicion  VALUES ('$iddoc','$var2', '$miPosicion')");
                                            }
                                            // Entra si una palabra ya existe de anteriores documentos
                                            else
                                            {
                                                /***MI VARIABLE*/
                                                $miPosicion += 1;
                                                //BORRAARRRRRRRRRR
                                                //echo("Guardo posicion, ");
                                                mysql_query("INSERT posicion  VALUES ('$iddoc','$var2', '$miPosicion')");
                                                //**BORRAARRRRRRRRRR*/
                                                //echo("entra a 2 else, ");
                                                $rank = 1;
                                            }    
                                            mysql_query("INSERT documento_has_posteo  VALUES ('$var2','$iddoc', '$rank')");
                                        }
                                        //$cont++;
                                    }//fin del else de strlen
                                }//fin del if stp
                        }//fin del if termino = "" &
                                        
                    }//fin del for
                }//fin del While
         }//fin del if resultado['des']
        else{
            echo "Documento ya esta insertado ";
        }

     }//fin del if strcmp
    else{
        echo "Debe seleccionar un archivo";
     }
}
?>
</p>
<a href="index.php?vista=4">Cargar otro archivo</a>