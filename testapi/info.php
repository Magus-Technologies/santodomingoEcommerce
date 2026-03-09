
<?php
 include "BD.php";
   ///BUSCAR ULTIMO PRODUCTO REGISTRADO
		        $sqlcod = "SELECT (CASE WHEN COUNT(cod_prod) = 0 THEN 1 ELSE MAX(cod_prod)+1 END) as xtot FROM `sopprod`";
		        $rescod = mysqli_query($con,$sqlcod);
		        $arrcod = mysqli_fetch_array($rescod,MYSQLI_ASSOC);
		        echo $codnew = $arrcod['xtot'];
		        $numcar = strlen($codnew);


?>
