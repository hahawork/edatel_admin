<?php



/* DEFINICIONES MYSQL*/

define('HOSt','adminedatel.db.13964802.d3b.hostedresource.net');

define('PASSWd','Ed@tel2018');

define('USEr','adminedatel');

define('BDMysql','adminedatel');



class conexion {
	
	public function conectar() {

		$res = mysqli_connect(HOSt, USEr, PASSWd, BDMysql);

		mysqli_set_charset($res, "utf8");

		return $res;
	}
}
?>