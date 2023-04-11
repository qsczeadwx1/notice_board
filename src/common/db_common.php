<?php

function db_conn( &$param_conn )
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "notice_board";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option = 
        array(
            PDO::ATTR_EMULATE_PREPARES      => false
            ,PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION 
            ,PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
        );
    
    try
    {
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
    } 
    catch( \Throwable $e ) 
    {
        $param_conn = null;
        throw new Exception( $e->getMessage() );
    }
}

function select_board_info_paging( &$param_arr )
{
    $sql = 
    " SELECT " 
	." board_no "
	." ,board_title "
	." ,board_write_date "
    ." FROM " 
	." notice_board_info "
    ." WHERE " 
	." board_del_flg = '0' "
    ." ORDER BY " 
	." board_no DESC "
    ." LIMIT :limit_num OFFSET :offset "
    ;
    
    $arr_prepare =
        array(
            ":limit_num" => $param_arr["limit_num"]
            ,":offset"   => $param_arr["offset"]
        );

    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    } 
    catch ( Exception $e ) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result;
}

function select_board_info_cnt()
{
    $sql =
            " SELECT "
            ." COUNT(board_no) cnt "
            ." FROM "
            ." notice_board_info "
            ." WHERE "
            ." board_del_flg = '0' "
        ;
        $arr_prepare = array();

    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    } 
    catch ( Exception $e ) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result;

}


function select_board_info_no( &$param_no )
{
    $sql = 
        " SELECT "
	    ." board_no "
	    ." ,board_title "
	    ." ,board_contents "
        ." FROM "
        ." notice_board_info "
        ." WHERE "
        ." board_no = :board_no "
    ;
    
    $arr_prepare =
        array(
            ":board_no" => $param_no
        );

    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    } 
    catch ( Exception $e ) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result[0];
}



function update_board_info_no( &$param_arr )
{
    $sql = 
        " UPDATE "
        ." notice_board_info "
        ." SET "
        ." board_title = :board_title "
        ." ,board_contents = :board_contents "
        ." WHERE "  
        ." board_no = :board_no "
    ;
    $arr_prepare = 
        array(
            ":board_title" => $param_arr["board_title"]
            ,":board_contents" => $param_arr["board_contents"]
            ,":board_no" => $param_arr["board_no"]
        );

        $conn = null;
        try 
        {
            db_conn( $conn ); // PDO object set
            $conn->beginTransaction(); // 트랜잭션 시작
            $stmt = $conn->prepare( $sql ); // statement object set
            $stmt->execute( $arr_prepare ); // DB request
            $result_cnt = $stmt->rowCount(); // query 적용 recode 갯수
            $conn->commit();
        } 
        catch ( Exception $e ) 
        {
            return $e->getMessage();
        }
        finally
        {
            $conn = null; // PDO 파기
        }
        
        return $result_cnt;
}

// TODO : test Start
// $arr = 
//     array(
//         "limit_num"  => 5
//         ,"offset"    => 0
//     );

// $result = select_board_info_paging( $arr );

// print_r( $result );
// TODO : test End




?>