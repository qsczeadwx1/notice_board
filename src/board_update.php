<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    include_once( URL_DB );

    // request method를 획득
    $http_method = $_SERVER["REQUEST_METHOD"];

    // GET 일때
    if( $http_method === "GET")
    {
    $board_no = 1;
        if( array_key_exists( "board_no", $_GET) )
        {
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );
    }

    // post 일때
    else
    {
        $arr_post = $_POST;
        $arr_info = 
            array(
                "board_no" => $arr_post["board_no"]
                ,"board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]
            );

        // update
        $result_cnt = update_board_info_no( $arr_info );

        // select
        $result_info = select_board_info_no( $arr_post["board_no"] );
    }

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/css.css">
    <title>게시판</title>
    <script>
    function resize(obj) {
        obj.style.height = "1px";
        obj.style.height = (12+obj.scrollHeight)+"px";
    }
</script>

</head>
<body>
    <a href = 'board_list.php?page_num=1'><h1 id='h1_atag'>Notice Board</h1></a>
        <form method="post" action="board_update.php">
            <label for='bno'>게시글 번호  </label>
            <input type='text' id='bno' name='board_no' value='<?php echo $result_info["board_no"] ?>' readonly>
        <br>
            <label for='title'>게시글 제목  </label>
            <input type='text' id='title' name='board_title' value='<?php echo $result_info["board_title"] ?>'>
        <br>
            <label for='contents'>게시글 내용  </label>
            <textarea class='autosize' id='contents' name='board_contents' onkeyup="resize(this)"
            placeholder='내용을 입력해 주세요.' ><?php echo $result_info["board_contents"] ?></textarea>
        <br>
    <button type='submit' class='fix_button' >수정</button>
    
    </form>

</body>
</html>