<?php
// ***************************
// 파일명	:	04_107_fncdb_connect
// 기능		: DB connect 함수
// 버전 	: v001  new Kim.mj 230918
// 			  v002 DBcoon 설정 변경 Kim.mj 230918
// ****************************
// --------------------------
// 함수명 : my_db_com
// 기능 :DB Connect
// 파라미터: PDO &$conn
// 리턴 :없음
// --------------------------
// 변수 값을 생성 하는 것이 아니라 주소 값을 넘겨 주는 것 .. ?
function my_db_conn( &$conn ) {
	$db_host	= "localhost"; // host//del v002
$db_user	= "root"; // user
$db_pw		= "php504"; // password
$db_name	= "employees"; // DB name
$db_charset	= "utf8mb4"; // charset
$db_dns		= "mysql:host=".$db_host.";dbname=".$db_name.";charset=".$db_charset;
$db_options	= [
	// DB의 Prepared Statement 기능을 사용하도록 설정
	PDO::ATTR_EMULATE_PREPARES		=> false
	// PDO Exception을 Throws하도록 설정
	,PDO::ATTR_ERRMODE				=> PDO::ERRMODE_EXCEPTION
	// 연상배열로 Fetch를 하도록 설정
	,PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC 
];

// // PDO Class로 DB 연동
$conn = new PDO($db_dns, $db_user, $db_pw, $db_options);

// ---------------------
// 함수명	: db_destroy_conn
// 기능		:DB Destory
// 파라미터	:PDO &$conn
// 리턴		:없음
// ----------------------
}
// DB파기
function db_destroy_conn($conn) {
	$conn = null;
};


?>