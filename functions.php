<?php

require "db_conn.php";

function check_login()
{
	if(empty($_SESSION['info'])){

		header("Location: login.php");
		die;
	}
}

function check_admin() {
    if (!isset($_SESSION['info']) || !$_SESSION['info']['admin']) {
        echo "You do not have permission to access this page.";
        die;
    }else{
		return true;
	}
}
