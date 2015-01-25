<?php
		###########################################################################################
				###########################################################################
				
				//Copyright @ 2011
				//Magcon Graphics Design
				
				###########################################################################
		###########################################################################################	
class queryClass{
	

	public $fields=array();
	private $dataSet;
	public $arrayPost=array();

	public function query($query){
		global $dbConn;
		return $dataSet = mysql_query($query, $dbConn);
	}
	
	
	private function setData(&$dataSet)	{
		if ($dataSet == false)
			$dataSet = $this->dataSet;
		else {
			if (gettype($dataSet) != 'resource')
				$dataSet = $this->query($dataSet);
		}
		return;
	}
	
	
	
	//for fetch object
	public function fetchObject($query = false){
		//$this->setData($query);
		return mysql_fetch_object($query);
		
	}
	// for fetch assoc
	public function fetchAssoc($query = false){
		//$this->setData($query);
		return mysql_fetch_assoc($query);
	}
	
	//for fetch array
	public function fetchArray($query=false)	{
		$this->setData($query);
		return mysql_fetch_array($query);
	}
	
	//for select query
	public function selectQuery($fields, $table, $where = false, $orderby = false, $limit = false){
		global $dbConn;
		
		if (is_array($fields))
			$fields = implode(",",$fields);
		

		if(is_array($table))
			$table = implode(",",$table);
			
		$orderby = ($orderby) ? " ORDER BY " . $orderby : '';
		$where = ($where) ? " WHERE " . $where : '';
		$limit = ($limit) ? " LIMIT " . $limit : '';
		$sql=mysql_query("SELECT ".$fields." FROM " .$table . $where . $orderby . $limit);
		return $sql;
	}

	public function insert(array $values, $table){
		
		if(count($values)<0)
			return false;
			
		foreach($values as $key=>$val)
			$values[$key]=$this->escapeString($val);
			
		if($this->query("INSERT INTO `". $table. "`(`". implode(array_keys($values),"`,`"). "`) VALUES ('".
		implode($values,"','")."')" ))
			return true;
		else
		return false;
		
	}
	
	
	
	public function update(array $values, $table, $where=false, $limit=false){
		
	if(count($values)<0)
	return true;
	
	$fields=array();
	foreach($values as $field=>$val)
		$fields[]= "`". $field. "` = '". $this->escapeString($val). "'";	
		
	$where=($where) ? " WHERE ". $where: '';
	$limit=($limit) ? " LIMIT ". $limit: '';
	
	$sql=" UPDATE ". $table. " SET ". implode($fields,", "). $where. $limit;
	
	if($this->query($sql))
		return true;
	else
		return false;	
	}
	
	
	
	
	public function delete($table, $where= false, $limit=1){	
		$where=($where) ? " WHERE ". $where: '';
		$limit=($limit) ? " LIMIT ". $limit: '';
		
		if($this->query("DELETE FROM `".$table. "`". $where. $limit))
			return true;
		else
			return false;
	}
	
	public function deleteAll($table, $where= false){	
		$where=($where) ? " WHERE ". $where: '';
		//echo $table.$where;
		
		if($this->query("DELETE FROM `".$table. "`". $where))
			return true;
		else
			return false;
	}
	
	public function strReplace(array $var){
		$array=array();
		for($x=0;$x<sizeof($var);$x++){	
			$array[$x]=str_replace("__COMMA__",",",$var[$x]); 
		}
		
		return $array;
		
	}
	
	public function last_insert_id(){
		global $dbConn;
		return mysql_insert_id($dbConn);
	}
	
	//for POST		
	public function varPost(array $var1,$var2){
		
		$Values=array();
		
			for($x=0;$x<sizeof($var1);$x++){
				//mb_convert_encoding($str, 'UTF-16LE', 'UTF-8')
				$Values[$var1[$x]]=mb_convert_encoding($var2[$x],'ISO-8859-1', 'UTF-8');
				
				
				//$Values[$var1[$x]]=$var2[$x];
				}
				
		return $Values;	
			
	}
	
	//for GET 
	public function varGet($variables){
		
			for($x=0;$x<sizeof($variables);$x++){
				
				$Values[$variables[$x]]=$_GET[$variables[$x]];
				}
				
			return $Values;	
	}
	
	
	//included	


	public function dbAffectedRows()
		{
			global $dbConn;
			return mysql_affected_rows($dbConn);
		}
		

	public function dbFetchArray($result, $resultType = MYSQL_NUM) {
			return mysql_fetch_array($result, $resultType);
		}
		

	public function dbFetchAssoc($result)
		{
				return mysql_fetch_assoc($result);
		}

	public function dbFetchRow($result) 
		{
			return mysql_fetch_row($result);
		}

	public function dbFreeResult($result)
		{
			return mysql_free_result($result);
		}

	public function dbNumRows($result)
		{
			return mysql_num_rows($result);
		}

	public function dbSelect($dbName)
		{
			return mysql_select_db($dbName);
		}

	public function dbInsertId()
		{
			return mysql_insert_id();
		}
	
//--end	
	
	
	
	public function error($error){
	if($error==true){
		$m="Data has been successfully Added!";}
	else{$m=false;
		}
	return $m;
	} 
	
	
	//sql injection
	public function escapeString($str){
		return mysql_real_escape_string(trim($str));
	}	
	
	
	public function escapeString2($str){
		 return strtr($str, array(
 
		"ñ" => "&ntilde;",
		"Ñ"=>"&Ntilde;"
	
   	 ));
	}	
	
	
	
	
	public function escapeStripDeep($dataset = false) {
		if(is_array($dataset)){
			foreach($dataset as $field => $val) {
				$data[$field] = $this->escapeStrip($val);
			}
			return $data;
		}
		else{
			return $this->escapeStrip($dataset);
		}
	}
	public function escapeStrip($str) {
		return stripslashes($str);
	}
	//number of rows
	public function countRows($dataSet = false)	{
		$this->setData($dataSet);
		return (int) mysql_num_rows($dataSet);
	}
	//pagination
	public function pagination_link($id, $page_num){
		//return $_SERVER['PHP_SELF'].'?page_num='.$page_num;
		return $this->selfURL().'&page_num='.$page_num;
	}
		
	public function pagination($num_of_items, $items_per_page, $id, $page_num, $max_links){
		$total_pages = ceil($num_of_items/$items_per_page);
	
	if($page_num) {
		if($page_num >1){ 
			$prev = ' &nbsp; <a href="'.$this->pagination_link($id, ($page_num -1 )).'" class="pagination2">
			<img src="./images/arrow_first.gif" /></a> &nbsp; '; 
			$first = '<a href="'.$this->selfURL().'" class="pagination2">First Page</a>'; 
		}
	}
	if($page_num <$total_pages){ 
		$next = ' &nbsp; <a href="'.$this->pagination_link($id, ($page_num+1)).'" class="pagination2">
		<img src="./images/arrow_last.gif" /></a> &nbsp; '; 
		$last = ' &nbsp; <a href="'.$this->pagination_link($id, $total_pages).'" class="pagination2"> LAST PAGE</a> &nbsp; ';
	}
	echo $first; //pagprint nung 1st at prev
	echo $prev;
	
	
	$loop = 0;
	if($page_num >= $max_links) {
		$page_counter = ceil($page_num - ($max_links-1));
	} else {
		$page_counter = 1;
	}
	if($total_pages < $max_links){
		$max_links = $total_pages;
	}
	do{ 
		if($page_counter == $page_num) {
			echo ' &nbsp; <strong>'.$page_counter.'</strong> &nbsp; '; 
		} else {
			echo '<a href="'.$this->pagination_link($id, ($page_counter)).'" class="pagination2">'.$page_counter.'</a> &nbsp; ';
		} 
		$page_counter++; $current_page=($page_counter+1);
		$loop++;
	} while ($max_links > $loop);
	echo $next;
	echo $last;
	}
	
	
	##############################-for XML Parser-#########################################
	
		public function xmlLoader($name){
			
			$xml = simplexml_load_file($name);
				
				foreach($xml->children() as $child)
  				{
  					echo $child->getName() . ": " . $child . "<br />";
  				}
				
		}
		
		public function xmlGetName(){
			
			return $xml->getName();
			
		}
		
		
		public function xmlAdding(){
			
			$file = "project.xml";
			$fp = fopen($file, "rb") or die("cannot open file");
			$str = fread($fp, filesize($file));


	   		$xml = new DOMDocument();
			$xml->formatOutput = true;
			$xml->preserveWhiteSpace = false;
			$xml->loadXML($str) or die("Error");

			// original


			$root   = $xml->documentElement;
			$id     = $xml->createElement("id");
			$idText = $xml->createTextNode("2");
			$id->appendChild($idText);

			$image     = $xml->createElement("image");
			$imageText = $xml->createTextNode("DSC00369_2.jpg");
			$image->appendChild($imageText);

			$content     = $xml->createElement("content");
			$contentText = $xml->createTextNode("Reza Christian");
			$content->appendChild($contentText);


			$link     = $xml->createElement("link");
			$linkText = $xml->createTextNode("Reza Christian");
			$link->appendChild($linkText);

			$root->appendChild($id);
			$root->appendChild($image);
			$root->appendChild($content);
			$root->appendChild($link);

			echo $xml->saveXML();

			file_put_contents($file, $xml->saveXML());

			fclose($fp);	
		
		}
		
	#############################-end of XML Parser-#####################################
	
	
	
	//##########################-GETTING THE CURRENT PAGE-####################
	public function selfURL() {
	   $s = empty($_SERVER["HTTPS"]) ? ''
		: ($_SERVER["HTTPS"] == "on") ? "s"
		: "";
	   $protocol = $this->strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	   $port = ($_SERVER["SERVER_PORT"] == "80") ? ""
		: (":".$_SERVER["SERVER_PORT"]);
	    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	}
	
	public function strleft($s1, $s2) {
	     return substr($s1, 0, strpos($s1, $s2));
	}
	//###########################
	
	
}//end of class
?>
