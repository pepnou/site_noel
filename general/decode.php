<?php
	function my_mb_ucfirst($str) {
		$fc = mb_convert_case(mb_substr($str, 0, 1, "UTF-8"), MB_CASE_UPPER, "UTF-8").mb_convert_case(mb_substr($str, 1, NULL, "UTF-8"), MB_CASE_LOWER, "UTF-8");
		return $fc;
	}

	function ucfirst_aio_wrap($str, $mysqli) {
		return mysqli_real_escape_string( $mysqli, my_mb_ucfirst(urldecode($str)));
	}

	function standard_aio_wrap($str, $mysqli) {
		return mysqli_real_escape_string( $mysqli, urldecode($str));
	}
?>