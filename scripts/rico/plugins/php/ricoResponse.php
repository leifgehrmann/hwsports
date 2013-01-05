<?php

// for PHP4
// copied from http://www.php.net/json_encode
if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}

class ricoXmlResponse {

  // public properties
  var $orderByRef;
  var $sendDebugMsgs;
  var $readAllRows;    // always return the total number of rows? (if true, the user will always see the total number of rows, but there is a small performance hit)
  var $convertCharSet; // set to true if database is ISO-8859-1 encoded, false if UTF-8
  var $AllRowsMax;     // max # of rows to send if numrows=-1
  var $fmt;            // xml, json, html, xl
 
  // private properties
  var $objDB;
  var $eof;
  var $oParse;
  var $sqltext;
  var $arParams;
  var $allParams;
  var $condType;
  var $RowsStart;
  var $RowsEnd;
  var $SendHdg;
  var $Headings;
  var $HiddenCols;

  function ricoXmlResponse() {
    if (isset($GLOBALS['oDB']) && is_object($GLOBALS['oDB'])) {
      $this->objDB=$GLOBALS['oDB'];   // use oDB global as database connection, if it exists
    }
    $this->orderByRef=false;
    $this->sendDebugMsgs=false;
    $this->readAllRows=true;    // has no effect on SQL Server 2005, Oracle, and MySQL because they use Query2xmlRaw_Limit()
    $this->convertCharSet=false;
    $this->SendHdg=false;
    $this->AllRowsMax=1999;
    $this->Headings=array();
    $this->HiddenCols=array();
  }

  function ProcessQuery($id, $sqlselect, $filters=array(), $errmsg='') {
    $this->fmt=isset($_GET["_fmt"]) ? $_GET["_fmt"] : "xml";
    $offset=isset($_GET["offset"]) ? $_GET["offset"] : "0";
    $size=isset($_GET["page_size"]) ? $_GET["page_size"] : "";
    $total=isset($_GET["get_total"]) ? strtolower($_GET["get_total"]) : "false";
    $distinct=isset($_GET["distinct"]) ? $_GET["distinct"] : "";
    $edit=isset($_GET["edit"]) ? $_GET["edit"] : "";
    if (isset($_GET["hidden"]) && $_GET["hidden"]!="") $this->HiddenCols=explode(",", $_GET["hidden"]);

    ob_clean();
    if ($this->fmt != "xl") {
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
      header("Expires: ".gmdate("D, d M Y H:i:s",time()+(-1*60))." GMT");
    }

    switch ($this->fmt) {
      case "html":
        header("Content-type: text/html");
        echo "<html><head></head><body>\n";
        $closetags="</body></html>";
        $this->RowsStart="\n<table border='1'>";
        $this->RowsEnd="\n</table>";
        $total="false";
        $this->sendDebugMsgs=false;
        $this->SendHdg=true;
        break;
      case "xl":
        $this->convertCharSet=false;
        header("Content-type: application/vnd.ms-excel");
        echo "<html><head></head><body>\n";
        $closetags="</body></html>";
        $this->RowsStart="\n<table>";
        $this->RowsEnd="\n</table>";
        $total="false";
        $this->sendDebugMsgs=false;
        $this->SendHdg=true;
        break;
      case "json":
        header("Content-type: application/json");
        echo "{\n\"id\":\"" . $id . "\"";
        $this->RowsStart=",\n\"update_ui\":true,\n\"offset\":" . $offset . ",\n\"rows\":[";
        $this->RowsEnd="\n]";
        $closetags="}";
        $this->sendDebugMsgs=false;
        break;
      default:
        // default to xml
        $this->fmt="xml";
        header("Content-type: text/xml");
        echo "<?xml version='1.0' encoding='UTF-8'?".">\n";
        echo "\n<ajax-response><response type='object' id='" . $id . "'>";
        $closetags="</response></ajax-response>";
        $this->RowsStart="\n<rows update_ui='true' offset='" . $offset . "'>";
        $this->RowsEnd="\n</rows>";
        break;
    }
    if (!empty($errmsg)) {
      $this->ErrorResponse($errmsg);
    } elseif (empty($id)) {
      $this->ErrorResponse("No ID provided!");
    } elseif ($distinct=="" && !is_numeric($offset)) {
      $this->ErrorResponse("Invalid offset!");
    } elseif ($distinct=="" && !is_numeric($size)) {
      $this->ErrorResponse("Invalid size!");
    } elseif ($distinct!="" && !is_numeric($distinct)) {
      $this->ErrorResponse("Invalid distinct parameter!");
    } else {
      if ($this->SendHdg && is_array($sqlselect)) {
        // populate $Headings from $sqlselect[9] taking into account hidden columns
        for ($i=0,$j=0,$SkipIdx=0; $i<count($sqlselect[9]); $i++) {
          $skip=false;
          if ($SkipIdx < count($this->HiddenCols)) {
            $skip=($this->HiddenCols[$SkipIdx] == $i);
            if ($skip) $SkipIdx++;
          }
          if (!$skip) {
            $this->Headings[$j++]=$sqlselect[9][$i];
          }
        }
      }
      $this->objDB->DisplayErrors=false;
      $this->objDB->ErrMsgFmt="MULTILINE";
      if ($distinct!="" && is_numeric($distinct)) {
        $this->Query2xmlDistinct($sqlselect, intval($distinct), -1, $filters);
      } elseif ($edit!="" && is_numeric($edit) && is_array($sqlselect)) {
        $this->Query2xml($sqlselect[8][intval($edit)], intval($offset), intval($size), $total!="false", $filters);
      } else {
        $this->Query2xml($sqlselect, intval($offset), intval($size), $total!="false", $filters);
      }
      if (!empty($this->objDB->LastErrorMsg)) {
        $this->ErrorResponse($this->objDB->LastErrorMsg);
      }
    }
    echo "\n".$closetags;
  }

  function ErrorResponse($msg) {
    $this->AppendResponse("error",$msg);
  }

  function AppendResponse($tag, $content) {
    switch ($this->fmt) {
      case "html":
        echo "\n<p>".$tag."<br>".htmlspecialchars($content)."</p>";
        break;
      case "xl":
        echo "\n<p>".$tag."<br>".htmlspecialchars($content)."</p>";
        break;
      case "json":
        echo ",\n\"".$tag."\":".json_encode($content);
        break;
      case "xml":
        echo "\n<".$tag.">".htmlspecialchars($content)."</".$tag.">";
        break;
    }
  }

  // All Oracle and SQL Server 2005 queries *must* have an ORDER BY clause
  // "as" clauses are now ok
  // If numrows < 0, then retrieve all rows
  function Query2xml($sqlselect, $offset, $numrows, $gettotal, $filters=array()) {
    if ($numrows >= 0) {
      $Dialect=$this->objDB->Dialect;
    } else {
      $numrows=$this->AllRowsMax;
      $Dialect="";  // don't use limit query
    }
    switch ($this->objDB->Dialect) {
      case "MySQL": $this->orderByRef=true; break;
    }
    $this->arParams=array('H'=>array(), 'W'=>array());
    $this->oParse= new sqlParse();
    if (is_array($sqlselect)) {
      $this->oParse->LoadArray($sqlselect);
    } else {
      $this->oParse->ParseSelect($sqlselect);
    }
    $this->ApplyQStringParms($filters);
    $this->allParams=array_merge($this->arParams['W'],$this->arParams['H']);
    echo $this->RowsStart;
    switch ($Dialect) {

      case "TSQL":
        $this->objDB->SingleRecordQuery("select @@VERSION", $version);
        if (is_string($sqlselect) && strtoupper(substr($sqlselect,0,7))!="SELECT ") {
          $this->allParams=array();
          $totcnt=$this->Query2xmlRaw($sqlselect, $offset, $numrows);
        }
        else if (preg_match("/SQL Server 200(5|8)/i",$version[0])) {
          $this->sqltext=$this->UnparseWithRowNumber($offset, $numrows + 1, true);
          $totcnt=$this->Query2xmlRaw_Limit($this->sqltext, $offset, $numrows, 1);
        }
        else {
          $this->sqltext=$this->oParse->UnparseSelectSkip($this->HiddenCols);
          $totcnt=$this->Query2xmlRaw($this->sqltext, $offset, $numrows);
        }
        break;

      case "Oracle":
        $this->sqltext=$this->UnparseWithRowNumber($offset, $numrows + 1, false);
        $totcnt=$this->Query2xmlRaw_Limit($this->sqltext, $offset, $numrows, 1);
        break;

      case "MySQL":
        $this->sqltext=$this->oParse->UnparseSelectSkip($this->HiddenCols)." LIMIT ".$offset.",".($numrows + 1);
        $totcnt=$this->Query2xmlRaw_Limit($this->sqltext, $offset, $numrows, 0);
        break;

      case "PostgreSQL":
        $this->sqltext=$this->oParse->UnparseSelect()." LIMIT ".($numrows + 1) . " OFFSET ".$offset;
        $totcnt=$this->Query2xmlRaw_Limit($this->sqltext, $offset, $numrows, 0);
        break;

      default:
        $this->sqltext=$this->oParse->UnparseSelectSkip($this->HiddenCols);
        $totcnt=$this->Query2xmlRaw($this->sqltext, $offset, $numrows);
        break;
    }
    echo $this->RowsEnd;
    if ($this->sendDebugMsgs) {
      $this->AppendResponse("debug",$this->objDB->db->lastQuery);
    }
    if (!$this->eof && $gettotal) {
      $totcnt=$this->getTotalRowCount();
    }
    if ($this->fmt=="xml" || $this->fmt=="json") {
      if ($this->eof) $this->AppendResponse("rowcount",$totcnt);
    }
    $this->oParse=NULL;
    return $totcnt;
  }


  function Query2xmlDistinct($sqlselect, $colnum, $numrows, $filters=array()) {
    if ($numrows < 0) $numrows=$this->AllRowsMax;
    $this->arParams=array('H'=>array(), 'W'=>array());
    $this->oParse= new sqlParse();
    if (is_array($sqlselect)) {
      $this->oParse->LoadArray($sqlselect);
    } else {
      $this->oParse->ParseSelect($sqlselect);
    }
    $this->ApplyQStringParms($filters);
    $this->allParams=array_merge($this->arParams['W'],$this->arParams['H']);
    echo $this->RowsStart;
    $this->sqltext=$this->oParse->UnparseDistinctColumn($colnum);
    $totcnt=$this->Query2xmlRaw($this->sqltext, 0, $numrows);
    echo $this->RowsEnd;
    if ($this->sendDebugMsgs) {
      $this->AppendResponse("debug",$this->objDB->db->lastQuery);
    }
    $this->oParse=NULL;
  }


  // Tested ok with SQL Server 2005, MySQL, and Oracle
  function getTotalRowCount() {
    $countSql="SELECT ".$this->oParse->UnparseColumnList()." FROM ".$this->oParse->FromClause;
    if (!empty($this->oParse->WhereClause)) {
      $countSql.=" WHERE ".$this->oParse->WhereClause;
    }
    if (is_array($this->oParse->arGroupBy)) {
      if (count($this->oParse->arGroupBy) >  0) {
        $countSql.=" GROUP BY ".implode(",",$this->oParse->arGroupBy);
      }
    }
    if (!empty($this->oParse->HavingClause)) {
      $countSql.=" HAVING ".$this->oParse->HavingClause;
    }
    $countSql="SELECT COUNT(*) FROM (".$countSql.")";
    if ($this->objDB->Dialect != "Oracle") {
      $countSql.=" AS rico_Main";
    }
    if (count($this->allParams)>0) {
      $rsMain=$this->objDB->RunParamQuery($countSql,$this->allParams);
    } else {
      $rsMain=$this->objDB->RunQuery($countSql);
    }
    if (!$rsMain) {
      echo "\n<debug>getTotalRowCount: rsMain is null</debug>";
      return;
    }
    if (!$this->objDB->db->FetchArray($rsMain,$a)) return;
    $this->objDB->rsClose($rsMain);
    $this->eof=true;
    return $a[0];
  }


  function UnparseWithRowNumber($offset, $numrows, $includeAS) {
    if (is_array($this->oParse->arOrderBy)) {
      if (count($this->oParse->arOrderBy) >  0) {
        $strOrderBy=implode(",",$this->oParse->arOrderBy);
      }
    }
    if (empty($strOrderBy) && !preg_match("/\bjoin\b/",$this->oParse->FromClause)) {
      // order by clause should be included in main sql select statement
      // However, if it isn't, then use primary key as sort - assuming FromClause is a simple table name
      $strOrderBy=$this->objDB->PrimaryKey($this->oParse->FromClause);
    }
    $unparseText="SELECT ROW_NUMBER() OVER (ORDER BY ".$strOrderBy.") AS rico_rownum,";
    $unparseText.=$this->oParse->UnparseColumnListSkip($this->HiddenCols)." FROM ".$this->oParse->FromClause;
    if (!empty($this->oParse->WhereClause)) {
      $unparseText.=" WHERE ".$this->oParse->WhereClause;
    }
    if (is_array($this->oParse->arGroupBy)) {
      if (count($this->oParse->arGroupBy) >  0) {
        $unparseText.=" GROUP BY ".implode(",",$this->oParse->arGroupBy);
      }
    }
    if (!empty($this->oParse->HavingClause)) {
      $unparseText.=" HAVING ".$this->oParse->HavingClause;
    }
    $unparseText="SELECT * FROM (".$unparseText.")";
    if ($includeAS) {
      $unparseText.=" AS rico_Main";
    }
    $unparseText.=" WHERE rico_rownum > ".$offset." AND rico_rownum <= ".($offset + $numrows);
    return $unparseText;
  }

  function Query2xmlRaw($rawsqltext, $offset, $numrows) {
    if (count($this->allParams)>0) {
      $rsMain=$this->objDB->RunParamQuery($rawsqltext,$this->allParams);
    } else {
      $rsMain=$this->objDB->RunQuery($rawsqltext);
    }
    if (!$rsMain) return;
  
    $colcnt = $this->objDB->db->NumFields($rsMain);
    $totcnt = $this->objDB->db->NumRows($rsMain);
    //echo "<debug>Query2xmlRaw: NumRows=$totcnt</debug>";
    if ($offset < $totcnt || $totcnt==-1) {
      $this->objDB->db->Seek($rsMain,$offset);
      switch ($this->fmt) {
        case "json": $rowcnt=$this->WriteRowsJSON($rsMain, $numrows, 0); break;
        default:     $rowcnt=$this->WriteRowsXHTML($rsMain, $numrows, 0); break;
      }
      if ($totcnt < 0) {
        $totcnt=$offset+$rowcnt;
        while($this->objDB->db->FetchRow($rsMain,$row))
          $totcnt++;
      }
    } else {
      $totcnt=$offset;
    }
    $this->objDB->rsClose($rsMain);
    $this->eof=true;
    return $totcnt;
  }

  function Query2xmlRaw_Limit($rawsqltext, $offset, $numrows, $firstcol) {
    if (count($this->allParams)>0) {
      $rsMain=$this->objDB->RunParamQuery($rawsqltext,$this->allParams);
    } else {
      $rsMain=$this->objDB->RunQuery($rawsqltext);
    }
    //if ($this->objDB->db->HasError()) echo "<error>" . $this->objDB->db->ErrorMsg() . "</error>";
    $totcnt=$offset;
    $this->eof=true;
    if (!$rsMain) return;
    switch ($this->fmt) {
      case "json": $totcnt+=$this->WriteRowsJSON($rsMain, $numrows, $firstcol); break;
      default:     $totcnt+=$this->WriteRowsXHTML($rsMain, $numrows, $firstcol); break;
    }
    $this->objDB->rsClose($rsMain);
    return $totcnt;
  }

  function WriteRowsXHTML($rsMain, $numrows, $firstcol) {
    $colcnt = $this->objDB->db->NumFields($rsMain);
    $rowcnt=0;
    if ($this->SendHdg) {
      echo "\n<tr>";
      for ($i=$firstcol; $i < $colcnt; $i++) {
        $n=empty($this->Headings[$i-$firstcol]) ? $this->objDB->db->FieldName($rsMain,$i) : $this->Headings[$i-$firstcol];
        print $this->XmlStringCell($n);
      }
      echo "</tr>";
    }
    while(($this->objDB->db->FetchRow($rsMain,$row)) && $rowcnt < $numrows) {
      $rowcnt++;
      print "\n<tr>";
      for ($i=$firstcol; $i < $colcnt; $i++)
        print $this->XmlStringCell($row[$i]);
      print "</tr>";
    }
    $this->eof=($rowcnt < $numrows);
    return $rowcnt;
  }
  
  function WriteRowsJSON($rsMain, $numrows, $firstcol) {
    $colcnt = $this->objDB->db->NumFields($rsMain);
    $rowcnt=0;
    if ($this->SendHdg) {
      echo "\n[";
      for ($i=$firstcol; $i < $colcnt; $i++) {
        //$n=empty($this->Headings($i-$firstcol)) ? $this->objDB->db->FieldName($rsMain,$i) : $this->Headings($i-$firstcol);
        print json_encode($n);
      }
      echo "]";
    }
    while(($this->objDB->db->FetchRow($rsMain,$row)) && $rowcnt < $numrows) {
      if ($rowcnt>0 || $this->SendHdg) echo ",";
      $rowcnt++;
      print "\n[";
      for ($i=$firstcol; $i < $colcnt; $i++) {
        if ($i>$firstcol) echo ",";
        print json_encode($this->convertCharSet ? utf8_encode($row[$i]) : $row[$i]);
      }
      print "]";
    }
    $this->eof=($rowcnt < $numrows);
    return $rowcnt;
  }
  
  function SetDbConn(&$dbcls) {
    $this->objDB=&$dbcls;
  }

  function PushParam($newvalue) {
    $parm=$this->convertCharSet ? utf8_decode($newvalue) : $newvalue;
    if (get_magic_quotes_gpc()) $parm=stripslashes($parm);
    array_push($this->arParams[$this->condType], $parm);
    if ($this->sendDebugMsgs) {
      echo "\n<debug>".$this->condType." param=".htmlspecialchars($parm)."</debug>";
    }
  }
  
  function setCondType($selectItem) {
    $this->condType=(preg_match("/\bmin\(|\bmax\(|\bsum\(|\bcount\(/i",$selectItem) && !preg_match("/\bselect\b/i",$selectItem)) ? 'H' : 'W';
  }
  
  function addCondition($newfilter) {
    switch ($this->condType) {
      case 'H': $this->oParse->AddHavingCondition($newfilter); break;
      case 'W': $this->oParse->AddWhereCondition($newfilter); break;
    }
  }

  function ApplyQStringParms($filters) {
    foreach($_GET as $qs => $value) {
      $prefix=substr($qs,0,1);
      switch ($prefix) {

        // user-invoked condition
        case "w":
        case "h":
          $i=substr($qs,1);
          if (!is_numeric($i)) break;
          $i=intval($i);
          if ($i<0 || $i>=count($filters)) break;
          $newfilter=$filters[$i];
          $this->condType=strtoupper($prefix);

          $j=strpos($newfilter," in (?)");
          if ($j !== false) {
            $a=explode(",", $value);
            for ($i=0; $i < count($a); $i++) {
              $this->PushParam($a[$i]);
              $a[$i]="?";
            }
            $newfilter=substr($newfilter,0,$j+4) . implode(",",$a) . substr($newfilter,$j+5);
          } elseif (strpos($newfilter,"?") !== false) {
            $this->PushParam($value);
          }

          $this->addCondition($newfilter);
          break;

        // sort
        case "s":
          $i=substr($qs,1);
          if (!is_numeric($i)) break;
          $i=intval($i);
          if ($i<0 || $i>=count($this->oParse->arSelList)) break;
          $value=strtoupper(substr($value,0,4));
          if (!in_array($value,array('ASC','DESC'))) $value="ASC";
          if ($this->orderByRef)
            $this->oParse->AddSort(($i + 1)." ".$value);
          else
            $this->oParse->AddSort($this->oParse->arSelList[$i]." ".$value);
          break;

        // user-supplied filter
        case "f":
          //print_r($value);
          foreach($value as $i => $filter) {
            if ($i<0 || $i>=count($this->oParse->arSelList)) break;
            $newfilter=$this->oParse->arSelList[$i];
            $this->setCondType($newfilter);
            switch ($filter['op']) {
              case "EQ":
                $newfilter='('.$this->AddCoalesce($newfilter).' IN '.$this->GetMultiParmFilter($filter).')';
                break;
              case "LE":
                $newfilter.="<=?";
                $this->PushParam($filter[0]);
                break;
              case "GE":
                $newfilter.=">=?";
                $this->PushParam($filter[0]);
                break;
              case "NULL": $newfilter.=" is null"; break;
              case "NOTNULL": $newfilter.=" is not null"; break;
              case "LIKE":
                $newfilter.=" LIKE ?";
                $this->PushParam(str_replace("*",$this->objDB->Wildcard,$filter[0]));
                break;
              case "NE":
                $newfilter='('.$this->AddCoalesce($newfilter).' NOT IN '.$this->GetMultiParmFilter($filter).')';
                break;
            }
            $this->addCondition($newfilter);
          }
          break;
      }
    }
  }

  function AddCoalesce($newfilter) {
    if ($this->objDB->Dialect=="Access") {
      return "iif(IsNull(" . $newfilter . "),''," . $newfilter . ")";
    } else {
      return "coalesce(" . $newfilter . ",'')";
    }
  }


  function GetMultiParmFilter($filter) {
    $flen=$filter['len'];
    if (!is_numeric($flen)) return "";
    $flen=intval($flen);
    $newfilter='(';
    for ($j=0; $j<$flen; $j++) {
      if ($j > 0) $newfilter.=",";
      $newfilter.='?';
      $this->PushParam($filter[$j]);
    }
    $newfilter.=')';
    return $newfilter;
  }

  function XmlStringCell($value) {
    if (!isset($value)) {
      $result="";
    }
    else {
      if ($this->convertCharSet) {
        $value=utf8_encode($value);
        $result=htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
      } else {
        $result=htmlspecialchars($value);
      }
    }
    if ($this->fmt=="html" && $result=="") $result="&nbsp;";
    return "<td>".$result."</td>";
  }

  // for the root node, parentID should "" (empty string)
  // containerORleaf: L/zero (leaf), C/non-zero (container)
  // selectable:      0->not selectable, 1->selectable
  function WriteTreeRow($parentID, $ID, $description, $containerORleaf, $selectable) {
    echo "\n<tr>";
    echo $this->XmlStringCell($parentID);
    echo $this->XmlStringCell($ID);
    echo $this->XmlStringCell($description);
    echo $this->XmlStringCell($containerORleaf);
    echo $this->XmlStringCell($selectable);
    echo "</tr>";
  }

}

?>