<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."board_header.php" );
    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];
    
    if( $http_method === "POST")
    {
        $arr_post = $_POST;
        $arr_info =
            array(
                "board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]
            );

            $result_cnt = insert_board_info( $arr_info );

            header( "Location: board_list.php" );
            exit();
    }
    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>새 글 작성</title>
    <link rel="stylesheet" href="css/board.css">
    <script>
    function resize(obj) {
        obj.style.height = "1px";
        obj.style.height = (15+obj.scrollHeight)+"px";
    }
    </script>
</head>
<body>
    <?php include_once( URL_HEADER ); ?>
    <form class="form_contents" method="post" action="board_insert.php">
            <label for='title'>게시글 제목  </label>
            <input type='text' id='title' name='board_title' required>
        <br>
            <label for='contents'>게시글 내용  </label>
            <textarea class='autosize' id='contents' name='board_contents' onkeydown="resize(this)" onkeyup="resize(this)"
            placeholder='내용을 입력해 주세요.' ></textarea>
        <br>
            <button type='submit' class="fix_button" >작성</button>
            
            <button type='botton' class="to_list_button">
            <a href="board_list.php">
                돌아가기
            </a>
            </button>
    </form>
</body>
</html>