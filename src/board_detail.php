<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."board_header.php" );
    include_once( URL_DB );

// request parameter획득(GET)
$arr_get = $_GET;

// DB에서 게시글 정보 획득
$result_info = select_board_info_no( $arr_get["board_no"] )




?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $result_info["board_title"]?></title>
    <link rel="stylesheet" href="css/board.css">

    <!-- <script>
        // if (!confirm("정말로 삭제 하시겠습니까?")) {
        //     return;
        // }
        // onclick="javascript:delete_contents()"
        function del_button()
        {
            if( !confirm("정말 삭제 하시겠습니까?" == false) ) return false;
            
        }
        onclick="del_button()
    </script> -->
</head>
<body>
    <?php include_once( URL_HEADER ); ?>
    <form class="form_detail" >
    <div>
        <p>게시글 번호 : <?php echo $result_info["board_no"]?></p>
        <p>작성일 : <?php echo $result_info["board_write_date"]?></p>
        <p>게시글 제목 : <?php echo $result_info["board_title"]?></p>
        <p>게시글 내용 : <p class="p_contents"><?php echo $result_info["board_contents"]?></p></p>
    </div>
    <a href="board_update.php?board_no=<?php echo $result_info["board_no"]?> ">
    <button type="button" class="detail_button" id="detail_fix_btn">
    수정
    </button>
    </a>
    <a href="board_delete.php?board_no=<?php echo $result_info["board_no"] ?>" >
    <button type="button" class="detail_button" id="detail_del_btn">
            삭제
    </button>
    </a>
    </form>
</body>
</html>
