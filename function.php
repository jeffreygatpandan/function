<?php
###########################-Date created March 13 2012, for MAGCON GRAPHIC DESIGN 
include_once '../library/config.php';
include_once '../library/dbconnection.php';
include_once '../library/queryClass.php';


//include_once "../library/markdown.php";

global $query;
$query=new queryClass(); 






######################################-FUNCTIONS-#######################################
	########__SAVE	
		function save(array $arrFlds, array $arrCol, $table){
			global $query;
				$values=$query->varPost($arrCol,$arrFlds);
					if($query->insert($values,DBPREFIX.$table))
						return $query->last_insert_id();
					else
						return false;	
					
		}

	########__UPDATE
		function edit(array $arrFlds, array $arrCol, $table, $where){
			global $query;
			
				$values=$query->varPost($arrCol,$arrFlds);	
				$query->update($values, DBPREFIX.$table, $where);
		}
	#######
	
	##########__DELETE
		function delete($table,$where){
			global $query;
			$query->delete(DBPREFIX.$table,$where);
		}

	
	#######
	
	##########__DELETE *
		function deleteAll($table,$where){
			global $query;
			$query->deleteAll(DBPREFIX.$table,$where);
		}

	
	#######
	
	
	##########__SELECT
		function select($colname, $table, $where){
		 global $query;
			$result=$query->selectQuery($colname,DBPREFIX.$table,$where);
			
			
			return implode("_split_",$query->fetchAssoc($result));
			
				
		}
	#######
	
	##########__SELECT
		function selectUni($colname, $table, $where){
		 global $query;
			if($result=$query->selectQuery($colname,DBPREFIX.$table,$where)){
			  (int) $ctr=$query->countRows($result);
			
			   if($ctr>0){
			       return implode("_split_",$query->fetchAssoc($result));	
			         //return $ctr; 
			        }
			   else{
			       return '0';
			   }
		            }
			
			
		}
	#######
	
	
	
	##########__SELECT MULTI
		function selectMulti($colname,$table, $where){
		   global $query;
			$holderTable=array();
			$arrExloper=array();
				$holderTable=explode(",",$table);
				   //ADD PREFIX TO THE TABLE FOR SECURITY			
					for($x=0;$x<sizeof($holderTable);$x++){
						$holderTable[$x]=DBPREFIX.$holderTable[$x];}
				   //END  
			if($result=$query->selectQuery($colname,$holderTable,$where)){
			
				(int) $ctr=$query->countRows($result);
				
				if($ctr>0){
				   for($y=0;$y<$ctr;$y++){
					$arrExloper[$y]=implode("_split_",$query->fetchAssoc($result));   
				   }
				$valString=implode("_imploder_",$arrExloper); //AFTER THE IMPLODING OF INDIVIDUAL VALUES IMPLODE THE ARRAY	
				//$getString=$arrExloper;
				}
				return $valString;
			}
			else{
				return false;	
				
			}
			//return implode("_split_",$query->fetchAssoc($result));
				
		}
	
	#######
	
	#######################__COUNT NUMBERS__#########################
	function countRows($table, $where){
	global $query;
	   $holderTable=array();
	   $arrExloper=array();
	   $holderTable=explode(",",$table);
		//ADD PREFIX TO THE TABLE FOR SECURITY			
		   for($x=0;$x<sizeof($holderTable);$x++){
		     $holderTable[$x]=DBPREFIX.$holderTable[$x];}
		//END  
		if($result=$query->selectQuery("*",$holderTable,$where)){
		    (int) $ctr=$query->countRows($result);
		    return $ctr;
		}
		else{
		   return 0;	
		}
		
	}
				
	
	######################__MULTI SESSION__#############################
	function multiSession(array $session,array $session_val){
	    //$session array is for the name of session while $session_val is for the value 
	    for($j=0;$j<sizeof($session);$j++){
		   $_SESSION[$session[$j]]=$session_val[$j];
		   
	         }
	      return true;
		   
	}
	
	
	function multiSessionReturn(array $session){
	    //$session array is for the name of session while $session_val is for the value 
	    $ctr=sizeof($session);
	    for($i=0;$i<$ctr;$i++){
		  $session_val[$i]=$_SESSION[$session[$i]];
	       }
	      //$session_val[1]=$_SESSION['p_fname'];
	      //$session_val[2]=$_SESSION['p_mname'];
	      //$session_val[3]=$_SESSION['p_lname'];
	      
		      
	      	      
	         $session_ret=implode("_sessionImploder_",$session_val);
	     //return true;
	    return $session_ret;	   
	}
	
	#####################__END__########################################
	
	
	function generatePassword ($length = 8)
 	 {
	    $password = "";
    	    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

   	    $maxlength = strlen($possible);
  		 if ($length > $maxlength) {
     			 $length = $maxlength;
    		}
		$i = 0; 
    
   		 while ($i < $length) { 
			$char = substr($possible, mt_rand(0, $maxlength-1), 1);
        			if (!strstr($password, $char)) { 
    				 $password .= $char;
        				 $i++;
      			}

   		 }
		return $password;

  	}
	
	function Dates($date){
	      $phptime =date('now');
	      date_default_timezone_set('Taipei');
	      $mysqltime = date ($date); 
	   
	  return $mysqltime;
		
	}
	
	
	

	//ADDITIONAL FUNCTIONS _ADD HERE
	
	#########__LOG IN
		function Login($username,$password){
 			//$hashPassword=hash('ripemd160',$password);
				if($username=='admin' && $password=='vsc2013'){
					$_SESSION['pageid']='mgd';
					return "dashboard";
				}
				else{
					$_SESSION['pageid']='';
					return false;
				}
	
		}
	########__END LOG IN
	
		function selectLogList($id){
			global $query;	
				$resultLogs=$query->query("SELECT * FROM ".DBPREFIX."logs WHERE member_id='".$id."'");
				
				if($query->countRows($resultLogs)>0){
					
					$return.="<table>";
					  
					
					$return.="<tbody>";
					(int) $ctr=0;
					while($rowLogs=$query->fetchObject($resultLogs)){
						
				      		 if($ctr%2==0){
							$class="alt-row";	
				      		 }
				      		 else{
							$class="";		
				       		}
							
					$return.="<tr class='".$class."'>
						<td></td>
						
						<td><a href='#' class='Clogs' id='".$rowLogs->member_id."'>".$rowLogs->logs_date."</a></td>
						<td><a href='#' class='Clogs' id='".$rowLogs->member_id."'>".$rowLogs->logs_timeout."</a></td>
							
						<td>
							
							<input type='checkbox' class='ClogsView'   id='".$rowLogs->logs_id."'> 
						</td>
					      </tr>";	
					$ctr++;				
				      }
				       $return.="</tbody></table>";
				}//<a href='#' title='Edit Meta' class=''><img src='login_data/hammer_screwdriver.png' alt='Edit Meta'></a>
				   
			return $return;
		}
		
		
		
		function selectPageLogs($id){
			
			global $query;	
				$resultLogsPage=$query->query("SELECT logs_pages, logs_date FROM ".DBPREFIX."logs WHERE logs_id='".$id."'");
				
				if($query->countRows($resultLogsPage)>0){
					$rowLogsPage=$query->fetchObject($resultLogsPage);
					
					$return.="<label style='color:#0C0;'><b>".$rowLogsPage->logs_date."</b></label>";
					$return.="<table>";
					  
					
					$return.="<tbody>";
					(int) $ctr=0;
					$arrPageHolder=array();
					
						$arrPageHolder=explode(",",$rowLogsPage->logs_pages);
						
						for($i=0;$i<sizeof($arrPageHolder);$i++){
							if($i%2==0){
								$class="alt-row";	
				      			 }
				      			 else{
								$class="";		
				       			}
							
							$return.="<tr class='".$class."'>
								<td>".$arrPageHolder[$i]."</td></tr>";	
											
				    		  }
				       $return.="</tbody></table>";
				}//<a href='#' title='Edit Meta' class=''><img src='login_data/hammer_screwdriver.png' alt='Edit Meta'></a>
				   
			return $return;
			
			
			
			
		}
	
	
	//END OF ADDITIONAL FUNCTIONS



	
	
#######################################-END FUNCTIONS-#################################
//$mode=$_POST['mode'];
$mode=$_GET['mode'];



switch($mode){
	
	case 'email':
	      send_email();
	break;
	
	case 'email_manual':
	      email_manual();
	break;
	
	case 'login':
		$username=$_GET['username'];
		$password=$_GET['password'];
			$return=Login($username,$password);
	
		if(!isset($_SESSION['pageid']) || $_SESSION['pageid']==''){
			$return=false;
		}
		echo $return;
	break;
	
	

	case 'save':
		$arrFields=$_GET['arrFields'];
		$table=$_GET['table'];
		$colname=$_GET['colname'];
			for($x=0;$x<sizeof($arrFields);$x++){
					$arrFields[$x]=$query->escapeString($arrFields[$x]);
			}			
		echo save($arrFields,$colname, $table);
	
	break;
	
	case 'update':
		$arrFields=$_GET['arrFields'];
		$table=$_GET['table'];
		$colname=$_GET['colname'];
		$where=$_GET['where'];
		
			for($x=0;$x<sizeof($arrFields);$x++){
					$arrFields[$x]=$query->escapeString($arrFields[$x]);
					 //$arrFields[$x]=Markdown($arrFields[$x]);		
			}		
			
		
			 		
		edit($arrFields,$colname, $table, $where);
		
		echo true;		
		
	break;
	
	case 'delete':
		$table=$_GET['table'];
		$where=$_GET['where'];
		
		
		delete($table,$where);
		echo true;
	break;
	
	case 'deleteAll':
		$table=$_GET['table'];
		$where=$_GET['where'];
		
		
		deleteAll($table,$where);
		echo true;
	break;
	
	case 'logout':
		$_SESSION['pageid']='';
		unset($_SESSION['pageid']);
		session_destroy();//WARNING
		echo false;
	
	break;
	
	case 'select':
		$table=$_GET['table'];
		$colname=$_GET['colname'];
		$where=$_GET['where']; 		
		echo select($colname, $table, $where);
	
	break;
	
	case 'selectUni':
	            $table=$_GET['table'];
		$colname=$_GET['colname'];
		$where=$_GET['where']; 	
		
		echo selectUni($colname, $table, $where);
	
	break;
	
	
	case 'countRows':
	            $table=$_GET['table'];
		$where=$_GET['where']; 	
		echo countRows($table, $where);
	break;
	
	case 'selectMulti':
		$table=$_GET['table'];
		$colname=$_GET['colname'];
		$where=$_GET['where']; 		
		echo selectMulti($colname, $table, $where);
	
	break;
	
	
	
	//ADDITIONAL CASE HERE...
	
	case 'logs':
		$id=$_GET['id'];
		echo selectLogList($id);
	
	
	break;
	
	case 'logsPage':
		$id=$_GET['id'];
		echo selectPageLogs($id);
	break;
	
	
	
	case 'zip':
	echo createZipper();
		//echo true;
		
	break;
	
	
	
	case 'combo':
		$arrReturn=array();
		$table=$_GET['table'];
		$id=$_GET['id'];
		
	
		$result=$query->selectQuery("*", DBPREFIX.$table);
			while($row=$query->fetchArray($result)){
			    $arrReturn[$row[0]]=$row[1]; 
			}
			
		
		   foreach($arrReturn as $key=>$val){
		      if($key==$id)
			$return.="<option value=".$key." selected='selected'>".$val."</option>";
		      else
			$return.="<option value=".$key.">".$val."</option>";
								
		   }
	       echo $return;
	
	break;
	
	
	case 'rate':
	     echo table();
	break;
	
	case 'password':
	     echo generatePassword (8);
	
	break;
	
	
	case 'session':
	            $session=$_GET['session'];
		$session_val=$_GET['session_val'];
	            echo multiSession($session,$session_val);
	break;
	
	case 'sessionReturn':
	            $session=$_GET['session'];
	            echo multiSessionReturn($session);
	break;
	
	
	case 'date':
		$date=$_GET['date'];
	  	echo Dates($date);
	break;
	
	
	
	
	
	
	case 'addXml':
		$arrFields=$_GET['arrFields'];
		//var arrInputs=new Array(idLeftLink,idImage,idContentLeft);
		
		$file = "../xml/project.xml";
			$fp = fopen($file, "rb") or die("cannot open file");
			$str = fread($fp, filesize($file));

				$xml = new DOMDocument();
				$xml->formatOutput = true;
				$xml->preserveWhiteSpace = false;
				$xml->loadXML($str) or die("Error");

// original
					$root   = $xml->documentElement;
					$id     = $xml->createElement("id");
					$idText = $xml->createTextNode($arrFields[0]);
					$id->appendChild($idText);

					$image     = $xml->createElement("image");
					$imageText = $xml->createTextNode($arrFields[1]);
					$image->appendChild($imageText);

					$content     = $xml->createElement("content");
					$contentText = $xml->createTextNode($arrFields[2]);
					$content->appendChild($contentText);


				$link     = $xml->createElement("link");
				$linkText = $xml->createTextNode("Read More");
				$link->appendChild($linkText);

		
			
			$project= $xml->createElement("project");
			$project->appendChild($id);
			$project->appendChild($image);
			$project->appendChild($content);
			$project->appendChild($link);

			$root->appendChild($project);
	
			file_put_contents($file, $xml->saveXML());
			fclose($fp);
	break;
	
	case 'delXml':
		$id=$_GET['id'];
		
	$file = "../xml/project.xml";
		$fp = fopen($file, "rb") or die("cannot open file");
		$str = fread($fp, filesize($file));

		$xml = new DOMDocument();
		$xml->formatOutput = true;
		$xml->preserveWhiteSpace = false;
		$xml->loadXML($str) or die("Error");

		// get document element
		$root   = $xml->documentElement;
		//$fnode  = $root->firstChild;
		//get a node
		$ori    = $root ->childNodes->item($id); //index from 0-no. of child node
		// remove
		$root->removeChild($ori);

		file_put_contents($file, $xml->saveXML());
	fclose($fp);
	
	break;
	//END OF ADDITIONAL CASE
	
	
	case 'captcha':
	 //  echo captcha();
		
					
	break;
	
	case 'chckCourse':
	    $m=checkCourse();
	    $ids=implode($m,'_id_');
	    echo $ids;
	break;
	
	case 'loadCourse':
	
	 $id=$_GET['id'];
	       date_default_timezone_set('Taipei');     
	       $date_now = date("Ymd"); 
	       $annual_date = '20120922'; //pwedi i database   
		if($date_now <= '20120922') 
		{$rates_desc ='EA';}
		elseif($date_now <= '20121020' && $date_now > '20120922')
		{$rates_desc ='RR';} 
			
		if($result2=$query->query("SELECT * FROM tbl_rates where category='$rates_desc' order by code")){
			$y=0;
			$m= array();
			while($row2 = mysql_fetch_object($result2)){
			    $arrReturn[$row2->rates_id]=$row2->type;
				
			} //loop
			
		   foreach($arrReturn as $key=>$val){
		      if($key==$id)
			$return.="<option value=".$key." selected='selected'>".$val."</option>";
		      else
			$return.="<option value=".$key.">".$val."</option>";
								
		     }
		}
	      echo $return;	  
	break;
	

	default;
	 
		
					
	break;		
}




#############################################-Listing a file in a directory-#######################

/*//path to directory to scan
$directory = "../images/team/harry/";
 
//get all image files with a .jpg extension.
$images = glob($directory . "*.jpg");
 
//print each file name
foreach($images as $image)
{
echo $image;
}*/

#######################

?>
	
