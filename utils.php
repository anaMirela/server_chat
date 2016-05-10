<?php
	/*
	 * Script ce contine diverse functii utile
	 */

	function create_json_from_object($obj) {
		return json_encode($obj->as_array());
	}


	// functie ce returneaza un json cu codul de eroare si mesajul date ca parametru
	function create_error_json($error_code, $error_msg) {
		$error_arr = array(
			"code" => $error_code,
			"message" => $error_msg
		);
		return json_encode($error_arr);
	}
?>