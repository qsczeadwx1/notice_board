CREATE DATABASE notice_board;

USE notice_board;

CREATE TABLE notice_board_info(
			board_no INT PRIMARY KEY AUTO_INCREMENT
			,board_title VARCHAR(100) NOT NULL
			,board_contents VARCHAR(1000) NOT NULL 
			,board_write_date DATETIME NOT NULL 
			,board_del_flg CHAR(1) NOT NULL DEFAULT('0')
			,board_del_date DATETIME
			);

DESC notice_board_info;

