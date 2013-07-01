<?php
include_once('basedatos.php');
conectar_bd();

class Busqueda2{
    function Busqueda2(){
    }
	function getTerminosBuscados($buscar){
        $partes = explode (" ", $buscar);
		echo("Divide la consulta y retorna una matriz de subcadenas si se tratan de varias palabras.<br>");
		for($i=0;$i<count($partes); $i++){
			echo "[".$partes[$i]."]-";
		} //muestra las nuevas subcadenas.
		echo "<br>";
        $term=array();
		echo "Las subcadenas son estandarizadas (todo a minúscula).<br>";
		echo "Se eliminan caracteres extraños de las cadenas.<br>";
		echo "Se quitan los espacios en blanco del principio y del final de cada subcadena.<br>";
		echo "Se descartan stopwords si están almacenados en la base de datos.<br>";
		echo "Si es que la palabra tiene un sufijo y el sufijo existe en la BD, es extraído de la misma.<br>";
        for($i=0;$i < count($partes); $i++)
        {
        	$termino=strtolower($partes[$i]); 
			//echo "convertir en minuscula<br>";
        	
			$termino=$this->eliminarBasura($termino); 
			//echo "elimina elementos caracteres extraños<br>";
        	
			$termino=$this->borrarBasura($termino);
        	
			$termino=strrev($this->borrarBasura(strrev($termino)));//Devuele la cadena invertida.
        	$termino=strrev($this->caracteresEspeciales(strrev($termino)));
        	$termino=trim($termino);//elimina los espacios en blanco del comienzo y del final de una cadena
        	$termino=$this->caracteresEspeciales($termino);
        	$stp= $this->quitarStopword($termino);
            //sig que no es un stopword, por tanto se almacena para realizar la consulta
        	if($stp == 0){
        		$term[]=$this->eliminarSufijo($termino);
        	} //fin del if stp
        	//hasta aqui tenemos almacenados nuestras palabras a buscar en documentos_has_posteo
        }//fin del for
		if(count($term)!=0){
			echo "Luego del proceso quedarían así las palabras:<br>";
			for($i=0;$i<count($term); $i++){
				echo "[".$term[$i]."]-";
			}
		}else{
			echo "Las palabras han sido quitadas completamente. Podría tratarse de stopwords o sufijos.<br>";
			$term=-1;
		}
		echo "<br>";
        return $term;
    }
	function getIDTerm($term){
		echo "<br>";
		$idTerm=array();
		$otro=0;
		for($j=0;$j<count($term);$j++){
			$solucion="SELECT idPosteo FROM posteo where termino='$term[$j]';";
			$query=mysql_query($solucion);
			$n= mysql_num_rows($query);//nos indica el nro de docs que contienen la palabra
			//echo " (".$n." tuplas de respuesta)<br>";
			if($n==0){
				echo "La palabra ".$term[$i]." no está almacenada en la base de datos.<br>";
			}else{
				$res = mysql_fetch_array($query)or die(mysql_error());
				$idTerm[]=$res['idPosteo'];//para quitar duplicados de posteo se asigna directamente al arreglo.
			}
		}
		if(count($idTerm)!=0){
			echo "Cuyo id es:<br>";
			for($i=0;$i<count($idTerm); $i++){
				echo "[".$idTerm[$i]."]-";
			}//estos son los Id de las palabras
		}else{
			echo "<br>No se encontró ninguna de las palabras en la base de datos.<br>";
			$idTerm=-1;
		}
		return $idTerm;
	}
	function getIDDocs($term){
        $docs=array();
		echo "<br><br>Obtiene los Id de los documentos asociados a cada id obtenido en el paso anterior.<br>";
        for($i=0;$i < count($term); $i++)
        {
			$consultasql="SELECT idDocumento FROM documento_has_posteo where  idPosteo='$term[$i]';";
			//echo $consultasql;
        	$query=mysql_query($consultasql);
        	$n= mysql_num_rows($query);
			//echo "( ".$n." tuplas de respuesta)<br>";
			if($n==0){
				echo "Se ha detectado un error!!!<br>";
				//return $docs;
        	}
        	else
            {//sig que si se encontraron coincidencias en algunos docs
        		for($j=0;$j < $n; $j++)
        		{
        			$res = mysql_fetch_array($query)or die(mysql_error());
					$e=$this->existe($res['idDocumento'],$docs);//para quitar duplicados de posteo
        			if($e==0 ){
        				$docs[]=$res['idDocumento'];
        		    }
                 }
            }
        }
		echo "Para el caso estos son los Id de los documentos asociados a las palabras (Podría darse el caso de que varias palabras estén en el mismo documento).<br>";
		for($i=0;$i<count($docs); $i++){
			echo "[".$docs[$i]."]-";
		}
		return $docs;
	}
	function algoritmoVectorial($consulta,$terminos,$docs,$cantidadTotal){
		echo "<br>De los cuales son relevantes solamente: ".count($docs);
		echo "<br>Confeccionamos la matriz TF con los documentos como filas y los terminos como columnas.";
		$matrizTF=array();
		$matrizTF_IDF=array();
		for($i=0;$i<count($docs);$i++){
			for($j=0;$j<count($terminos);$j++){
				$query=mysql_query("select cantidad from documento_has_posteo where idPosteo='$terminos[$j]' and idDocumento='$docs[$i]'");
				$n=mysql_num_rows($query);
				if($n==0){
					$matrizTF[$i][$j]=0;
				}else{
					$res=mysql_fetch_array($query);
					$matrizTF[$i][$j]=$res['cantidad'];
				}
			}
		}
		echo "<br>";
		for($i=0;$i<count($docs);$i++){
			for($j=0;$j<count($terminos);$j++){
				echo " - ".$matrizTF[$i][$j];
			}
			echo "<br>";
		}
		echo"<br>";
		echo "Contamos la cantidad de documentos en los que aparece cada termino.<br>";
		$logs=array();
		for($j=0;$j<count($terminos);$j++){
			$contador=0;
			for($i=0;$i<count($docs);$i++){
				if($matrizTF[$i][$j]!=0){
					$contador=$contador+1;
				}
			}
			$logs[$j]=$contador;
			echo "<->".$logs[$j];
		}
		echo"<br>";
		echo"Y obtenemos los idf de cada término.<br>";	
		for($i=0;$i<count($logs);$i++){
			$logs[$i]=log($cantidadTotal/$logs[$i],10);
			echo"<->".$logs[$i];
		}
		echo "<br><br>";
		echo"Multiplicamos el idf de cada columna por los elementos de su fila.<br>";
		for($i=0;$i<count($docs);$i++){
			for($j=0;$j<count($terminos);$j++){
				$matrizTF_IDF[$i][$j]=$matrizTF[$i][$j]*$logs[$j];
				echo "<->".$matrizTF_IDF[$i][$j];
			}
			echo "<br>";
		}
		echo "<br>";
		echo "<br>";
		echo"Obtenemos el ranking de cada documento multiplicando de esta manera: sumatoria(idf[j]*matrizTF-IDF[i][j])<br>";
		$ranking=array();
		for($i=0;$i<count($docs);$i++){
			$acumulador=0;
			for($j=0;$j<count($terminos);$j++){
				$acumulador=$acumulador+($logs[$j]*$matrizTF_IDF[$i][$j]);
			}
			$ranking[$i]=$acumulador;
		}
		for($i=0;$i<count($ranking);$i++){
			echo "doc".($i+1).": [".$docs[$i]."] ".$ranking[$i]."<br>";
		}
		echo "<br>Ordenamos los documentos por relevancia:<br>";
		$docsOrdenados=$this->ordenarRanking($ranking,$docs);
		for($i=0;$i<count($docsOrdenados);$i++){
			echo "Relevancia ".($i+1).": [".$docsOrdenados[$i]."]<br>";
		}
		return $docsOrdenados;
	}
	function ordenarRanking($ranking,$docs){
		$solucion=array();
		for($i=0;$i<count($ranking);$i++){
			$otro=$this->getPosMay($ranking);
			$ranking[$otro]=-1;
			$solucion[$i]=$docs[$otro];
		}
		return $solucion;
	}
	function getPosMay($ranking){
		$indMayor=0;
		for($i=0;$i<count($ranking);$i++){
			for($j=0;$j<count($ranking);$j++){
				if($ranking[$i]>=$ranking[$j]&&$i!=$j){
					if($ranking[$indMayor]<=$ranking[$i]){
						$indMayor=$i;
					}
				}
			}
		}
		return $indMayor;
	}
	function getTerminosBuscadosBooleano($buscar){
        $partes = explode (" ", $buscar);
		echo "La palabra obtenida de la consulta es: [".$partes[0]."]";
		echo "<br>";
        $term=array();
		echo "La cadena es estandarizada (todo a minúscula).<br>";
		echo "Se eliminan caracteres extraños.<br>";
		echo "Se quitan los espacios en blanco del principio y del final de la palabra (si hay).<br>";
		echo "Si la palabra es un stopword almacenado, no se la toma en cuenta.<br>";
		echo "Si es que la palabra tiene un sufijo y el sufijo existe en la BD, es extraído de la misma.<br>";
        for($i=0;$i < count($partes); $i++){
        	$termino=strtolower($partes[$i]);
			$termino=$this->eliminarBasura($termino); 
			$termino=$this->borrarBasura($termino);
			$termino=strrev($this->borrarBasura(strrev($termino)));
        	$termino=strrev($this->caracteresEspeciales(strrev($termino)));
        	$termino=trim($termino);
        	$termino=$this->caracteresEspeciales($termino);
        	$stp= $this->quitarStopword($termino);
        	if($stp == 0){
        		$term[]=$this->eliminarSufijo($termino);
        	}
        }
		echo "Luego del proceso este es el resultado : [".$term[0]."]<br>";
        return $term;
    }
	function getIDTermBooleano($term){
		echo "<br>La palabra \"".$term[0]."\" es buscada en la base de datos (tabla \"posteo\"), y retorna el Id de la palabra si es que existe.<br>";
		$idTerm=array();
		$otro=0;
		$auxiliar="SELECT idPosteo FROM posteo where termino=\"".$term[0]."\";";
		//echo $auxiliar."<br>";
		$query=mysql_query($auxiliar);
		$n= mysql_num_rows($query);
		if($n==0){
			echo "No existen documentos asociados a esa palabra.<br>";
			$otro=-1;
		}else{
			$res = mysql_fetch_array($query)or die(mysql_error());
			$idTerm[0]=$res['idPosteo'];//para quitar duplicados de posteo
		}
		if($otro!=-1){
			echo "Para el caso, este es el ID de la palabra.<br>";
			echo "[".$idTerm[0]."]";
		}else{
			$idTerm=-1;
		}
		echo "<br>";
		return $idTerm;
	}
	function getIDDocsBooleano($term){
        $docs=array();
		echo "<br>Obtiene los Id de los documentos asociados al ID obtenido en el paso anterior.<br>";
        for($i=0;$i < count($term); $i++){
        	$query=mysql_query("SELECT dp.idDocumento FROM posteo p, documento_has_posteo dp where  p.idPosteo=dp.idPosteo AND termino='$term[$i]';");
        	$n= mysql_num_rows($query);
			if($n==0){
				echo "No existen documetnos asociados a la palabra: <br>";
				$docs=-1;
				return $docs;
        	}else{
        		for($j=0;$j < $n; $j++){
        			$res = mysql_fetch_array($query)or die(mysql_error());
					$e=$this->existe($res['idDocumento'],$docs);//para quitar duplicados de posteo
        			if($e==0 ){
        				$docs[]=$res['idDocumento'];
        		    }
                 }
            }
        }
		echo "Para el caso estos son los Id de los documentos asociados a la palabra buscada.<br>";
		for($i=0;$i<count($docs); $i++){
			echo "[".$docs[$i]."]-";
		}
		echo "<br>";
		return $docs;
	}
    function existe($numDoc,$docs)
    {  
    	for($j=0;$j < count($docs); $j++)
    	{	
    		if($numDoc==$docs[$j])
    			return 1;
    	}
    	return 0;
    }
	
		
    function existeTermino($term,$arrayTerm)
    {
    	for($j=0;$j < count($arrayTerm); $j++)
    	{	
    		if($term==$arrayTerm[$j])
    			return true;
    	}
    	return false;
    }

    function existeClave($clave,$simDoc)
    {
    	foreach($simDoc as $valor)
    	{
    		$k=key($simDoc);
    		if($clave==$k)
    			return true;
    	}
    	return false;
    }

    function linkVectorial($url,$nomLink,$valor,$idpost){
		$url=str_replace("\\","/",$url);
        echo("
        <table width='75%' border='0'>
          <tr>
            <td><a href='".$url."'>".$valor." -- ".$nomLink." -- En: documentos/".$url."</a><br></td>
          </tr>
        </table>");
    }
	function linkBooleano($url,$nomLink)
    {
		$url=str_replace("\\","/",$url);
		$espacio = " --- ";
		//borrado del href: file:///
        echo("
        <table width='75%' border='0'>
          <tr>
            <td><a href='".$url."'>".$nomLink.$espacio.$url."</a><br></td>
          </tr>
        </table>");
    }

    function eliminarBasura($term)//recibe una cadena
    {
        $res=' ';
        $caracter=substr($term,-4);//devuele los  últimos 4 caracteres de Term

        if (strcmp($caracter,'\r\n')==0)//compara 2 cadenas binariamente
        {
            $pal = strtolower($term);
            $tam = strlen($pal);//obtiene la longitud de la cadena
            for($i=0;$i<$tam-4;$i++)
            {
                $res.=$pal[$i];
            }
        }
        if($res==' ')
        	$res=$term;

         return $res;
    }

    function borrarBasura($term)
    {
        $res=' ';
        $caracter=substr($term,-2);
        if (strcmp($caracter,'..')==0  || strcmp($caracter,'==')==0 ||
        	strcmp($caracter,').')==0 || strcmp($caracter,'.)')==0 ||
            strcmp($caracter,'\\')==0 || strcmp($caracter,'//')==0)
        	{
        		$pal = strtolower($term);
        			$tam = strlen($pal);
        		for($i=0;$i<$tam-2;$i++)
        		$res.=$pal[$i];
        	}
        if($res==' ')
          $res=$term;

        return $res;
    }

/************************************************************
 *  		          SACAR CARACTER                        *
 ************************************************************/
    function sacarCaracter($reg)
    {
		$cad='';
        $pal = strtolower($reg);//Pasa a minúsculas una cadena
            $tam = strlen($pal);//Obtiene la longitud de la cadena
        for($i=0;$i<$tam-1;$i++)
        {
            $cad.=$pal[$i];
        }
        return $cad;
    }
/************************************************************
 *  		   CARACTERES ESPECIALES                        *
 ************************************************************/

    function caracteresEspeciales($term)
    {
        $res=' ';
        $caracter=substr($term,-1);
        if (strcmp($caracter,'.')==0  || strcmp($caracter,',')==0 ||
             strcmp($caracter,';')==0 || strcmp($caracter,':')==0 ||
             strcmp($caracter,'(')==0 || strcmp($caracter,')')==0 ||
             strcmp($caracter,'[')==0 || strcmp($caracter,']')==0 ||
             strcmp($caracter,'{')==0 || strcmp($caracter,'}')==0 ||
             strcmp($caracter,'')==0 || strcmp($caracter,'-')==0 ||
             strcmp($caracter,'?')==0 || strcmp($caracter,'¿')==0 ||
             strcmp($caracter,'@')==0 || strcmp($caracter,'#')==0 ||
             strcmp($caracter,'&')==0 || strcmp($caracter,'|')==0 ||
             strcmp($caracter,'*')==0 || strcmp($caracter,'$')==0 ||
             strcmp($caracter,'"')==0 || strcmp($caracter,'=')==0)
        {
           $res=$this->sacarCaracter($term);
        }
        if($res==' ')
          $res=$term;

        return $res;
    }
/************************************************************
 *  				QUITAR STOPWORD                         *
 ************************************************************/
    function quitarStopword($palabra)
    {		
        $stopword = strtolower($palabra);
        $resultado2 = mysql_query("SELECT count(stopwords) as ter FROM stopwords WHERE stopwords ='$palabra';");
        $respuesta = mysql_fetch_array($resultado2)or die(mysql_error());
        $numRegistros = $respuesta["ter"];
        if($numRegistros != 0)
        {
          return 1;
        }
        else
       	{
            return 0;
       	}
    }
	
/************************************************************
 *  			    ELIMINAR SUFIJO                         *
 ************************************************************/
	function eliminarSufijo($termino)
	{	
		$band = true;
		$resultado = mysql_query("SELECT sufijo FROM sufijo ORDER BY longitud DESC;");
		$numRegistros= mysql_num_rows($resultado);
		$mostrar = 0;
		for($i=0; $i<$numRegistros; $i++)
		{
			$reg=mysql_fetch_array($resultado)or die(mysql_error());	
			$suf = $reg["sufijo"];
			$termino01 = strtolower($termino);
			$cad01 = stristr($termino, $suf);
			if(strlen($cad01)>1)
			{	if(strcmp($cad01,null))
				{	$tam_ter = strlen($termino);
					$tam_suf = strlen($suf);
					$ini = $tam_ter - $tam_suf;
					$mostrar = substr ($termino, 0, $ini); 
				 if(strlen($mostrar)< 3)	
				 return $termino;
				 else  
				return $mostrar;
				}
			}
		}
		if($mostrar == 0)
		return $termino;
	}
	
/************************************************************
 *  			     INTERSECCION                           *
 ************************************************************/
	function interseccion($docs1, $docs2)
	{
		$contador=0;
		for($i=0;$i<count($docs1);$i++){
			for($j=0;$j<count($docs2);$j++){
				if($docs1[$i]==$docs2[$j]){
					$solucion[$contador]=$docs2[$j];
					//echo $docs2[$j];
					$contador++;
				}
			}	
		}
		//echo "<br>Este es el contenido del contador: ".$contador;
		if($contador!=0){
			echo "<br>El resultado de la intersección es: <br>";
			for($i=0;$i<count($solucion);$i++){
				echo "[".$solucion[$i]."]-";
			}
		}else{
			echo "<br>No existe un documento que contenga las dos palabras.<br>";
			$solucion=-1;
		}
		return $solucion;
	}
	
/************************************************************
 *  				     UNION                              *
 ************************************************************/	
	function union($docs1,$docs2)
	{
		$k=0;
		for($i=0;$i<count($docs1);$i++){
			$aux[$k]=$docs1[$i];
			$k++;
		}
		for($i=0;$i<count($docs2);$i++){
			$aux[$k]=$docs2[$i];
			$k++;
		}
		for($i=0;$i<count($aux);$i++){
			//echo "[".$aux[$i]."]-";
		}
		for($i=0;$i<count($aux);$i++){
			for($j=0;$j<count($aux);$j++){
				if($aux[$i]==$aux[$j] && $i!=$j){
					$aux[$i]='x';
					$contador++;
				}
			}	
		}
		//echo"<br>";
		$contador=0;
		for($i=0;$i<count($aux);$i++){
			if($aux[$i]!='x'){
				$solucion[$contador]=$aux[$i];
				$contador++;
			}
		}
		if($contador!=0){
			echo "<br>El resultado de la unión es: <br>";
			for($i=0;$i<count($solucion);$i++){
				echo "[".$solucion[$i]."]-";
			}
		}
		else{
			echo "<br>No existe un documento que contenga cualquiera de las palabras.<br>";
			$solucion=-1;
		}
		return $solucion;
	}
/************************************************************
 *  			      VECTORIAL                             *
 ************************************************************/
    function busquedaVectorial($buscar){
		$term=$this->getTerminosBuscados($buscar);
		$idTerm=$this->getIDTerm($term);
		if($idTerm==-1){
			echo "<br>Fin de la búsqueda vectorial.<br>";
		}else{
			$docs=$this->getIDDocs($idTerm);
			$query=mysql_query("SELECT count(idDocumento) as c FROM documento")or die(mysql_error());
			$res=mysql_fetch_array($query)or die(mysql_error());
			$cantidadTotal=$res['c'];
			echo "<br><br>Esta es la cantidad total de documentos: ".$cantidadTotal;
			$docsOrdenados=$this->algoritmoVectorial($term,$idTerm,$docs,$cantidadTotal);
			$cantidadMaximaMostrar=10;
		}
	}
/************************************************************
 *  		       BOOLEANO 1 PALABRA                       *
 ************************************************************/	
	function busquedaBooleano1palabra($texto){
		//echo "Se recibe las palabra a buscar: ".$texto;
		$texto=$this->getTerminosBuscadosBooleano($texto);
		$idTerm=$this->getIDTermBooleano($texto);
		if($idTerm!=-1){
			$docs=$this->getIDDocsBooleano($texto);
			
		}
	}
/************************************************************
 *  				BOOLEANO 2 PALABRAS                     *
 ************************************************************/	
	function busquedaBooleano($texto1, $texto2, $and_or)
    {
		echo "Se reciben las palabras a buscar y el tipo de búsqueda.<br>Palabra 1: ";
		echo $_POST['texto1'];
		echo "<br>Palabra 2: ";
		echo $_POST['texto2'];
		echo "<br>Tipo de búsqueda: ";
		if($_POST['and_or']==1){
			echo "AND (deben estar las dos palabras).<br>";
		}else{
			echo "OR (debe estar por lo menos una palabra).<br>";
		}
		echo "<br>El proceso se realiza para cada palabra: <br><br>";
		$texto1=$this->getTerminosBuscadosBooleano($texto1);
		echo "<br>";
		$texto2=$this->getTerminosBuscadosBooleano($texto2);
		echo "<br>";
		$idTerm1=$this->getIDTermBooleano($texto1);
		$idTerm2=$this->getIDTermBooleano($texto2);
		echo "<br>";
		$docs1=$this->getIDDocsBooleano($texto1);
		$docs2=$this->getIDDocsBooleano($texto2);
		
		$and_or=$_POST['and_or'];
		echo "<br>";
		if($docs1==-1){
			if($docs2==-1){
				echo "Las dos listas están vacías.";
				if($and_or==1){
					echo"El resultado de la interserccion es vacío";
					$solucion=-1;
				}else{
					echo"El resultado de la unión es vacío";
					$solucion=-1;
				}
			}else{
				echo "La lista 1 está vacía";
				if($and_or==1){
					echo"El resultado de la interserccion es vacío";
					$solucion=-1;
				}else{
					$solucion=$docs2;
				}
			}
		}else{
			if($docs2==-1){
				echo "La lista 2 está vacía";
				if($and_or==1){
					echo"El resultado de la interserccion es vacío";
					$solucion=-1;
				}else{
					$solucion=$docs1;
				}
			}else{
				echo "<br>Ninguna de las listas está vacía";
				if($and_or==1){
					echo "<br>Se debe seleccionar los archivos que aparecen en ambas listas (Tipo AND).<br>";
					$solucion=$this->interseccion($docs1,$docs2);
				}else{
					echo "<br>Se debe seleccionar los archivos que aparecen por lo menos en una lista (Tipo OR).<br>";
					$solucion=$this->union($docs1,$docs2);
				}
			}
		}
		echo "<br>";
		if($solucion!=-1){
			
		}
	}

/************************************************************
 *  				PROXIMIDAD                              *
 ************************************************************/	
	
	function busquedaProximidad($buscar,$validos)
    {
		$term=$this->getTerminosBuscados($buscar);
		
		// Recupera la cantidad de documentos subidos a la BDs
		$consulta= "SELECT idDocumento FROM documento";
		$docus = mysql_query($consulta)or die(mysql_error());										
		
		// Almacenará un id de documento por vez
		$idDocu = NULL;
		// Almacenará el numero de resultados positivos por busqueda
		$encontrados = 0;
		// Rango para validar una busqueda
		$valido = $validos;
		
		// variable que avisa si se encontro algo o no
		$aviso = 0;
		 
		// Se obtiene un id de Documento por vez hasta que el arreglo se termine
		for ($i = mysql_num_rows($docus) - 1; $i >=0; $i--)
		{
			/*if (!mysql_data_seek ($docus, $i))
			{
				echo ("No tiene ningun documento cargado para realizar una busqueda %d\n".$i);
				continue;
			}*/
			if(!($row = mysql_fetch_object ($docus)))
			{
				continue;
			}
			// Agarra un id de documento
			$idDocu = ($row->idDocumento);
			
			//echo "El id de Documento es: ".$idDocu."<BR>\n";
			
			// Es el numero maximo de palabras que se puede buscar en el arreglo del texto a buscar
			$aux = 1;
			// Hace un control cada 2 palabras
			$aux2 = 0;
			
			// Variables que capturas 2 palabras
			$idPala1 = NULL;
			$idPala2 = NULL;
			$guardado = NULL;
			
					
			// while que recupera palabra por palabra de atras hacia adelante
			while ($aux >= -1)
			{
				//Hace la BUSQUEDA obtenidas 2 palabras
				if ($aux2 == 2)
				{
					$consulta1= "SELECT * FROM posicion where idDoc=".$idDocu." AND idPal = ".$idPala2." ORDER BY idPos DESC;";
					$palabras2da = mysql_query($consulta1)or die(mysql_error());
					//echo $palabras2da;
					//$consulta2= "SELECT * FROM posicion where idDoc=".$idDocu." AND idPal = ".$idPala1." ORDER BY idPos DESC;";
					//$palabras1ra = mysql_query($consulta2)or die(mysql_error());
					
					$m = mysql_num_rows($palabras2da);
					//$n = mysql_num_rows($palabras1ra);
					
					for ($j = 0; $j < $m; $j++)
					{
						if(!($row2 = mysql_fetch_object ($palabras2da)))
						{
							continue;
						}
						// Agarra un id de documento
						$posicionPala2 = ($row2->idPos);

						//echo "La posicion palaabra 2 es : ".$posicionPala2."<BR>\n";
						//echo "El j es : ".$j."<BR>\n";
						
						$consulta2= "SELECT * FROM posicion where idDoc=".$idDocu." AND idPal = ".$idPala1." ORDER BY idPos DESC;";
						$palabras1ra = mysql_query($consulta2)or die(mysql_error());
						
						$n = mysql_num_rows($palabras1ra);
					
						// Compara una 2da palabra con cada 1ra palabra del arreglo $palabras1ra
						for ($k = 0; $k < $n; $k++)
						{
							//echo "El k es : ".$k."<BR>\n";
							
							if(!($row1 = mysql_fetch_object ($palabras1ra)))
							{
								continue;
							}
							
							// Agarra un id de documento
							$posicionPala1 = ($row1->idPos);
							
							//echo "La posicion palabra 1 es : ".$posicionPala1."<BR>\n";
							
							// Si la posicion de la 2da palabra es mayor a la de la 1ra
							if($posicionPala2 > $posicionPala1)
							{
								// FORMULA DE BUSQUEDA POR PROXIMIDAD
								$calculo = (($posicionPala2 - $posicionPala1) - 1);
								 //"El calculo es: ".$calculo."<BR>\n";
								// Si cumple el rango para que sea una busqueda valida
								if($calculo <= $valido)
								{
									$encontrados = $encontrados + 1;
								}
								
								$calculo = 0;
							}
						}//Fin for 2
					}//Fin for 1
					
					
					// Ahora la 1ra palabra es la 2da, y se resetean demas variables a su valor original
					$idPala2 = $pala1;
					$idPala1 = NULL;
					$aux2 = 1;
				}
				
				//echo "El idDocumento es : ".$idDocu;
				//echo "El term es: ".($term[$aux])."<BR>\n";
				
				// Si el arreglo $term[] tiene almacenada una palabra en la posicion $aux
				if($term[$aux] != "")
				{
					// Averiguando si existe la palabra en el documento $idDocu
					$consul3="SELECT p.idPosteo FROM posteo p, documento_has_posteo dp where p.termino= '".($term[$aux])."' AND dp.idDocumento= ".$idDocu." AND p.idPosteo = dp.idPosteo;";
					$resul = mysql_query($consul3)or die(mysql_error());										
					// Agarra el idPosteo de la palabra buscada
					//$miIDPal = $resul["p.idPosteo"];
					for ($j = 1; $j < 2; $j++)
					{
						if(!($fila = mysql_fetch_object ($resul)))
						{
							continue;
						}
						$miIDPal =($fila->idPosteo);
						echo "El idPal de la consulta es: ".$miIDPal."<BR>\n";
					}
					
					
					// Si existe al menos un vez la palabra en el documento $idDocu
					if($miIDPal != "")
					{
						// Agarra la segunda palabra
						if($aux2 == 0)
						{
							$idPala2 = $miIDPal;
							//echo "el idPala2 es: ".$idPala2;
						}// Agarra la primera palabra
						else if($aux2 == 1)
						{
							$idPala1 = $miIDPal;
							//echo "el idPala1 es: ".$idPala1;
						}	
			
						$aux2 += 1;
						//echo "El aux2 es: ".$aux2."<BR>\n";
					}
					else
					{
					//echo "entro al else";
						// Controla que las 2 palabras a buscar sean consecutivas
						if ($aux2 == 1)
						{
							$guardado = $idPala2;
							$idPala2 = NULL;
							
							$aux2 = 0;
						}
						
					}
					
					
				}// Fin if($term[$aux] != "")
				$aux -= 1;
				//echo "el AUX es: ".$aux."<BR>\n";
				
			}//Fin while ($aux >= 0)
			
			if($encontrados > 0)
			{
				$consul5="SELECT ubicacion FROM documento where idDocumento= '".$idDocu."';";
					$resul2 = mysql_query($consul5)or die(mysql_error());										
					// Agarra el idPosteo de la palabra buscada
					//$miIDPal = $resul["p.idPosteo"];
					for ($w = 0; $w < 1; $w++)
					{
						if(!($fila2 = mysql_fetch_object ($resul2)))
						{
							continue;
						}
						$miArchivo =($fila2->ubicacion);
						//echo "El idPal de la consulta es: ".$miIDPal."<BR>\n";
					}
				
				$encontrados = 0;
				$aviso += 1;
			}
		}//Fin for	
		
		if($aviso == 0)
		{
			echo "NO SE ENCONTRARON COINCIDENCIAS";
		}
	}// Fin busqueda proximidad
}
?>
