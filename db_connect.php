<?php

/**
 * A class file to connect to database
 */
class DB_CONNECT {

    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }

    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }

    /**
     * Function to connect with database
     */
    function connect() {
        // import database connection variables
        require_once __DIR__ . '/db_config.php';

		// Connecting to mysql database
			$con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());

		mysql_set_charset('utf8',$con);

		//mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
		//mysql_query("SET CHARACTER SET 'utf8'");

		//mysql_query("SET NAMES 'cp1251' COLLATE 'cp1251_general_ci'");
		//mysql_query("SET CHARACTER SET 'cp1251'");

        // Selecing database
        $db = mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());

        // returing connection cursor
        return $con;
    }

    /**
     * Function to close db connection
     */
    function close() {
        // closing db connection
        mysql_close();
    }

}

?>