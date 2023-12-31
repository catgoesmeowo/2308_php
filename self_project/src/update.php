<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/"); // 웹서버 root 패스 생성
define("FILE_HEADER", ROOT."header.php"); // 헤더 패스
require_once(ROOT."lib/lib_db.php"); // DB관련 라이브러리

$conn = null; // DB 연결용 변수
$id = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"]; // id 셋팅
$page = isset($_GET["page"]) ? $_GET["page"] : $_POST["page"]; // page 셋팅
$http_method = $_SERVER["REQUEST_METHOD"]; // Method 확인

try {
	// DB 연결
	if(!my_db_conn($conn)) {
		// DB Instance 에러
		throw new Exception("DB Error : PDO Instance");
	}

	if($http_method === "GET") {
		// GET Method의 경우
		// 게시글 데이터 조회를 위한 파라미터 셋팅
		$arr_param = [
			"id" => $id
		];

		// 게시글 데이터 조회
		$result = db_select_board_id($conn, $arr_param);
		// 게시글 조회 예외처리
		if($result === false) {
			// 게시글 조회 에러
			throw new Exception("DB Error : PDO Select_id");
		} else if(!(count($result) === 1)) {
			// 게시글 조회 count 에러
			throw new Exception("DB Error : PDO Select_id Count, ".count($result));
		}
		$item = $result[0];

	} else {
		// POST Method의 경우
		// 게시글 수정을 위헤 파라미터 셋팅
		$arr_param = [
			"id" => $id
			,"title" => $_POST["title"]
			,"detail" => $_POST["detail"]
		];

		// 게시글 수정 처리
		$conn->beginTransaction(); // 트랜잭션 시작

		if(!db_update_board_id($conn, $arr_param)) {
			throw new Exception("DB Error : Update_Board_id");
		}
		$conn->commit(); // commit

		header("Location: detail.php/?id={$id}&page={$page}"); // 디테일 페이지로 이동
		exit;
	}
} catch(Exception $e) {
	if($http_method === "POST") {
		$conn->rollBack(); // rollback
	}
	echo $e->getMessage(); // 예외 메세지 출력
	exit; // 처리종료
} finally {
	db_destroy_conn($conn);
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" ="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/mini_board/src/css/common.css">
	<title>수정 페이지</title>
</head>
<body>
	<?php
		require_once(FILE_HEADER);
	?>
	<form action="/mini_board/src/update.php" method="post">
		<table>
			<input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>">
			<tr>
				<th>글 번호</th>
				<td><?php echo $item["id"]; ?></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><input type="text" name="title" value="<?php echo $item["title"] ?>"></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><textarea name="detail" id="detail" cols="30" rows="10"><?php echo $item["detail"] ?></textarea></td>
			</tr>
		</table>
		<button type="submit">수정확인</button>
		<a href="/mini_board/src/detail.php/?id=<?php echo $id; ?>&page=<?php echo $page; ?>">수정취소</a>
	</form>
</body>
</html>