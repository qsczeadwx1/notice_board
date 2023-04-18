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
    catch( Exception $e ) 
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
        ." ,board_write_date "
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
            $conn->rollback();
            return $e->getMessage();
        }
        finally
        {
            $conn = null; // PDO 파기
        }
        
        return $result_cnt;
}

function delete_board_info_no( &$param_no )
{
    $sql = 
    " UPDATE "
    ." notice_board_info "
    ." SET "
    ." board_del_flg = '1' "
    ." ,board_del_date = NOW() "
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
        $conn->beginTransaction(); 
        $stmt = $conn->prepare( $sql ); 
        $stmt->execute( $arr_prepare ); 
        $result_cnt = $stmt->rowCount(); 
        $conn->commit();
    } 
    catch ( Exception $e ) 
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null; 
    }
    
    return $result_cnt;
}

function insert_board_info( &$param_arr )
{
    $sql = 
        " INSERT INTO "
        ." notice_board_info( "
        ." board_title "
        ." ,board_contents "
        ." ,board_write_date "
        ." ) "
        ." VALUES( "
        ." :board_title "
        ." ,:board_contents "
        ." ,NOW() "
        ." ) "
        ;

    $arr_prepare =
        array(
            ":board_title" => $param_arr["board_title"]
            ,":board_contents" => $param_arr["board_contents"]
        );

    $conn = null;
    try 
    {
        db_conn( $conn ); 
        $conn->beginTransaction(); 
        $stmt = $conn->prepare( $sql ); 
        $stmt->execute( $arr_prepare ); 
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    } 
    catch ( Exception $e ) 
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null; 
    }
    
    return $result_cnt;
}


?>