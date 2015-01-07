<?PHP
if(!empty($_GET['codigo'])){
	$codigo = $_GET['codigo'];
	$propiedad = $_GET['propiedad'];
	include("conexion.php");
	mysql_select_db($base, $conexion);
	$sql = 'select * from imagenes where codigo = '.$codigo;
	$result = mysql_query($sql, $conexion);
	$imagenChica = mysql_result($result, 0, "imagenChica");
	$imagenGrande = mysql_result($result, 0, "imagenGrande");
	unlink($imagenChica);
	unlink($imagenGrande);
	$sqlBorrar ='delete from imagenes where codigo = '.$codigo;
	mysql_query($sqlBorrar, $conexion);
	echo '<script type="text/javascript">window.location="http://ferreirainmob.com/sistema/editarPropiedad.php?codigo='.$propiedad.'&act=ok";</script>';
}else{
	echo '<script type="text/javascript">window.location="http://ferreirainmob.com/sistema/editarPropiedad.php?codigo='.$propiedad.'";</script>';
}
?>