
	
	//################ PASSING VARIABLES 
	function returnVal(arrFields){
	 var arrReturn=new Array();	
		for(var x=0;x<arrFields.length;x++){
		   arrReturn[x]=arrFields[x].val();}
		return arrReturn;
	}
	// ############### END VARIBLES

	//################ PASSING VARIABLES 
	function returnText(arrFields){
	 var arrReturn=new Array();	
		for(var x=0;x<arrFields.length;x++){
		   arrReturn[x]=arrFields[x].text();}
		return arrReturn;
	}
	// ############### END VARIBLES
	
	
	//#################CHECK VAL
	
	function checkVal(reqFields){
	 var flag=0;		          
     		for(var i=0;i<reqFields.length;i++){
			if(reqFields[i].val()==''){
				flag++;
	 		}
		 }	
	     return flag;
	}
	
	
	//################ END CHECK
	
	
	
	// ############## LOADING COMBOBOX FROM DATABASE
	function loadCboFRMDB(table,mode,colname,comboBoxName,selected){
	    comboBoxName.html('');  
	    comboBoxName.append("<option value='0'>-SELECT-</option>");
	        var jqxhr2=$.get('../library/function.php', {'table': table, 'mode': mode,'colname':colname}, function(data) {	
                    var arrTopic= data.split('_imploder_');
		  var tempArray=new Array();
		     for(var i=0;i<arrTopic.length;i++){
			tempArray=arrTopic[i].split('_split_');
				if(selected==tempArray[0]){sel="selected=selected";}
				else{sel="";}
			comboBoxName.append("<option value='"+tempArray[0]+"' "+sel+">"+tempArray[1]+"</option>");
	            }});	
	}
	//################ END

	// ############## LOADING COMBOBOX FROM ARRAY
	function loadCboFRMARR(arrVal,arrDesc,comboBoxName,selected){
	    comboBoxName.html('');  
	    comboBoxName.append("<option value=''>--SELECT--</option>");
	    for(var j=0;j<arrVal.length;j++){
		if(selected==arrVal[j]){sel="selected=selected";}
		else{sel="";}
		comboBoxName.append("<option value='"+arrVal[j]+"' "+sel+">"+ arrDesc[j]+"</option>");
		}
	}
	
	function loadCboRevertFRMARR(arrVal,arrDesc,comboBoxName,selected){
	    comboBoxName.html('');  
	    comboBoxName.append("<option value=''>--SELECT--</option>");
	    for(var j=0;j<arrVal.length;j++){
		if(selected==arrDesc[j]){sel="selected=selected";}
		else{sel="";}
		comboBoxName.append("<option value='"+arrVal[j]+"' "+sel+">"+ arrDesc[j]+"</option>");
		}
	}
	//############### END
	
	
	
	//##################-DELETING FUNCTION
	function delData(where,table,bolReload){
		   var jqxhr=$.get('../library/function.php', {'mode':'delete','table':table, 'where':where}, function(data) {
		        if(bolReload==true){ //WILL RELOAD	
			    if(data!=false){
			      window.location.reload();
			      //..add here
			    }
			   }
		     });
	}
	//#################-END 
	
	//##################-SAVING DATA
	function saveData(){
			
			
		}
