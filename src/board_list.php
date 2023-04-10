<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
    include_once( URL_DB );

    if( array_key_exists( "page_num", $_GET ) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }

    $limit_num = 5;

    $offset = ( $page_num -1 ) * $limit_num; 

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
    // print_r( $result_cnt );
    // print_r( $result_paging );
    // xcopy D:\Students\workspace\게시판\notice_board\src C:\Apache24\htdocs\src /E /H /F /Y
    // 작업중인 파일 서버쪽 폴더로 옮기기
    // print_r($max_page_num);
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>게시판</title>
</head>
<style>
    h1{
        text-align: center;
        color:#333333;
        font-family: Impact, Charcoal, sans-serif;
    }
    .a_tag{
        display: flex;
        justify-content: content;
    }
    a{
        margin: 5px;
    }
    table{
        text-align: center;
    }
</style>
<body>
    <h1>Notice Board</h1>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th>게시글 번호</th>
                <th>게시글 제목</th>
                <th>작성일자</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $result_paging as $record )
                {
            ?>
                <tr>
                    <td><?php echo $record["board_no"] ?></td>
                    <td><?php echo $record["board_title"] ?></td>
                    <td><?php echo $record["board_write_date"] ?></td>
                <tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <div class="a_tag">
    <?php
        for($i = 1; $i <= $max_page_num; $i++)
        {
    ?>
            <a href='board_list.php?page_num=<?php echo $i ?>' class="btn btn-primary"><?php echo $i; ?></a>
    <?php
        }
    ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>