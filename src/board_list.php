<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/" );
    define( "URL_DB", DOC_ROOT."common/db_common.php" );
    include_once( URL_DB );

    if( array_key_exists( "page_num", $_GET ) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }

    $limit_num = 7;

    $offset = ( $page_num - 1 ) * $limit_num; 
    // 게시판 정보 테이블 전체 카운트 획득
    $result_cnt = select_board_info_cnt();

    // max page number
    $max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );
    $arr_prepare = 
    array(
        "limit_num" => $limit_num
        ,"offset"   => $offset
    );
    $result_paging = select_board_info_paging( $arr_prepare );

    // xcopy D:\Students\workspace\게시판\notice_board\src C:\Apache24\htdocs\src /E /H /F /Y
    // 작업중인 파일 서버쪽 폴더로 옮기기
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>게시판</title>
    <link rel="stylesheet" href="css/board.css">
    <style>
        .table_<?php echo $page_num ?>{
            border: 1px solid black;
        color: rgb(102, 102, 102);
        background-color: rgb(226, 211, 211);
        }
    </style>
</head>
<body>
    <a href = 'board_list.php?page_num=1'><h1 id='h1_atag'>Notice Board</h1></a>
    <div class='table_container'>
    <table class='table table-dark table-striped' id='table_id'>
        <thead>
            <tr>
                <th class='board_no'>게시글 번호</th>
                <th class='board_tit'>게시글 제목</th>
                <th class='write_date'>작성일자</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $result_paging as $record )
                {
            ?>
                <tr>
                    <td class='board_no'><?php echo $record["board_no"] ?></td>
                    <td class='board_tit'><div class='a_container'><a href='board_detail.php?board_no=<?php echo $record["board_no"] ?>' id='board_a'><?php echo $record["board_title"] ?></a></div></td>
                    <td class='write_date'><?php echo $record["board_write_date"] ?></td>
                <tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    </div>
    <div class="a_tag">
        <a href = 'board_list.php?page_num=1' class='table_a'><span class='start_end'>처음으로</span></a>
        <?php
            if( $page_num != 1 )
            {
                $previous_page = $page_num - 1;
        ?>
        <a href='board_list.php?page_num=<?php echo $previous_page ?> ' class='table_a'>◀</a>
        <?php
            }
            elseif( $page_num = 1)
            {
        ?>
                <span class='table_b'>◀</span>
        <?php
            }
        ?>
    <?php
        if($page_num < 3)
        {
            for($i = 1; $i <= 5; $i++)
            {
    ?>
                <a href='board_list.php?page_num=<?php echo $i ?>' class='table_a table_<?php echo $i; ?>'><?php echo $i; ?></a>
    <?php
            }
        }
        elseif($page_num > $max_page_num - 2)
        {
            for($i = $max_page_num - 4; $i <= $max_page_num; $i++)
            {
    ?>
                <a href='board_list.php?page_num=<?php echo $i ?>' class='table_a table_<?php echo $i; ?>'><?php echo $i; ?></a>
    <?php
            }
        }
        elseif($page_num > 3 || $page_num <= $max_page_num - 2 )
        {
            for($i = $page_num -2; $i <= $page_num + 2; $i++)
            {
    ?>
                <a href='board_list.php?page_num=<?php echo $i ?>' class='table_a table_<?php echo $i; ?>'><?php echo $i; ?></a>
    <?php
            }
        }
        if( $page_num != $max_page_num )
        {
            $next_page = $page_num + 1;
        
    ?>
    <a href='board_list.php?page_num=<?php echo $next_page ?>' class='table_a'>▶</a>
    <?php
        }
        elseif( $page_num = $max_page_num )
        {
    ?>
            <span class='table_b'>▶</span>
    <?php
        }
    ?>
        <a href = 'board_list.php?page_num=<?php echo $max_page_num ?>' class='table_a'><span class='start_end'>끝으로</span></a>
    </div>
    <a href="board_insert.php"><button type="button">게시글 작성</button></a>
</body>
</html>