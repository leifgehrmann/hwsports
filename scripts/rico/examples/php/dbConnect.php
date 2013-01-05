<?php
require "../../plugins/php/dbClass3.php";
$appName="Northwind";
$appDB="sports_northwind";

function CreateDbClass() {
  global $oDB;
  $oDB = new dbClass();
}

function OpenDB() {
  global $oDB,$appDB;
  CreateDbClass();

  // MySQL
  return $oDB->MySqlLogon($appDB, "sports_northwind", "northwind");

  // MS SQL
  //$oDB->Dialect="TSQL";
  //return $oDB->MSSqlLogon("computer/instance", $appDB, "userid", "password");

  // PostgreSQL
  // The connection_string can be empty to use all default parameters, or it can contain one or more parameter settings separated by whitespace. Each parameter setting is in the form keyword = value. Spaces around the equal sign are optional. To write an empty value or a value containing spaces, surround it with single quotes, e.g., keyword = 'a value'. Single quotes and backslashes within the value must be escaped with a backslash, i.e., \' and \\.
  // The currently recognized parameter keywords are: host, hostaddr, port, dbname (defaults to value of user), user, password, connect_timeout, options, tty (ignored), sslmode, requiressl (deprecated in favor of sslmode), and service. Which of these arguments exist depends on your PostgreSQL version. 
  //return $oDB->PostgreSqlLogon($connection_string);
  
  // ODBC - MS Access
  //$oDB->Dialect="Access";
  //return $oDB->OdbcLogon("northwindDSN","Northwind","userid","password");

  // Oracle
  //$oDB->Dialect="Oracle";
  //return $oDB->OracleLogon("XE","northwind","password");
}


function OpenApp($title) {
  $_retval=false;
  if (!OpenDB()) {
    return $_retval;
  }
  if (!empty($title)) {
    AppHeader($GLOBALS['appName']."-".$title);
  }
  $GLOBALS['accessRights']="rw";
  // CHECK APPLICATION SECURITY HERE  (in this example, "r" gives read-only access and "rw" gives read/write access)
  if (empty($GLOBALS['accessRights']) || !isset($GLOBALS['accessRights']) || substr($GLOBALS['accessRights'],0,1) != "r") {
    echo "<p class='error'>You do not have permission to access this application";
  }
  else {
    $_retval=true;
  }
  return $_retval;
}


function OpenTableEdit($tabname) {
  $obj= new TableEditClass();
  $obj->SetTableName($tabname);
  $obj->options["XMLprovider"]="ricoQuery.php";
  $obj->convertCharSet=true;   // because sample database is ISO-8859-1 encoded
  return $obj;
}


function OpenGridForm($title, $tabname) {
  $_retval=false;
  if (!OpenApp($title)) {
    return $_retval;
  }
  $GLOBALS['oForm']= OpenTableEdit($tabname);
  $CanModify=($GLOBALS['accessRights'] == "rw");
  $GLOBALS['oForm']->options["canAdd"]=$CanModify;
  $GLOBALS['oForm']->options["canEdit"]=$CanModify;
  $GLOBALS['oForm']->options["canDelete"]=$CanModify;
  session_set_cookie_params(60*60);
  $GLOBALS['sqltext']='.';
  return true;
}


function CloseApp() {
  global $oDB;
  if (is_object($oDB)) $oDB->dbClose();
  $oDB=NULL;
  $GLOBALS['oForm']=NULL;
}


function AppHeader($hdg) {
  echo "<h2 class='appHeader'>".str_replace("<dialect>",$GLOBALS['oDB']->Dialect,$hdg)."</h2>";
}

?>

