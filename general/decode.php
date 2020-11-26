<?php
	function my_mb_ucfirst($str) {
		//echo mb_convert_case(mb_substr($str, 0, 1, "UTF-8"), MB_CASE_UPPER, "UTF-8")."\n";
		//echo mb_convert_case(mb_substr($str, 1, NULL, "UTF-8"), MB_CASE_LOWER, "UTF-8")."\n";

		$fc = mb_convert_case(mb_substr($str, 0, 1, "UTF-8"), MB_CASE_UPPER, "UTF-8").mb_convert_case(mb_substr($str, 1, NULL, "UTF-8"), MB_CASE_LOWER, "UTF-8");
		return $fc;
	}

	/*function my_sql_prepare($str, $mysqli) {
		return '\''.mysqli_real_escape_string( $mysqli, $str).'\'';
	}

	function ucfirst_aio_wrap($str, $mysqli) {
		return my_sql_prepare(my_mb_ucfirst(urldecode($str)), $mysqli)
	}

	function standard_aio_wrap($str, $mysqli) {
		return my_sql_prepare(urldecode($str), $mysqli)
	}*/

	function ucfirst_aio_wrap($str, $mysqli) {
		return mysqli_real_escape_string( $mysqli, my_mb_ucfirst(urldecode($str)));
	}

	function standard_aio_wrap($str, $mysqli) {
		return mysqli_real_escape_string( $mysqli, urldecode($str));
	}
?>