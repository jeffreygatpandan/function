    <link href="css/table/demo_page.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN: load jquery -->
    <script src="js/jquery-ui/jquery.ui.mouse.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.sortable.min.js" type="text/javascript"></script>
    <script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
    <!-- END: load jquery -->
    <script type="text/javascript" src="js/table/table.js"></script>
    <script src="js/setup.js" type="text/javascript"></script>
    
     <!--script and css for datepicker-->
	<link rel='stylesheet' type='text/css' href='../cal/calendar/datepicker/jdpicker.css' />
	<script src="../cal/calendar/datepicker/jquery.jdpicker.js" type="text/javascript"></script>
	<!--end -->
    <script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();
			
			
			$('#example_length').prepend('<input type="button" value="ADD" id="add_pr">');
			

			var divInputs=$("#divInputs");	
		
			var btncloseInputs=$("#btncloseInputs");
			var addEvents=$("#addEvents");
			var addpr =$("#add_pr");
			var eBack2 = $("#eBack2");
			var eSave = $("#eSave");
			var eUpdate = $("#eUpdate");
			var cView = $("#cView");
			var cEdit = $("#cEdit");
			var cDelete = $(".cDelete");
			
			var eventTitle=$("#eventTitle");
			var eventAuthor=$("#eventAuthor");
			var eventBody=$("#eventBody");
			var eventDate=$("#eventDate");
			
			eventDate.jdPicker();
			
				addpr.click(function(){
					centerPopup(divInputs);loadPopup(divInputs);
				});
				
				
				eSave.click(function(){
					
					var etitle = eventTitle.val();
					var eauthor = eventAuthor.val();
					var ebody = eventBody.val();
					var edate = eventDate.val();
					if(edate==''){
						edate='0000-00-00';
					}
					if(ebody=="" && etitle==""){
						alert("Empty Title and Body.");
					}
					else{
						var fields=new Array(etitle,eauthor,ebody,edate);
						var colnames=new Array('pr_title','pr_author','pr_body','pr_date');
						$.get('../library/function.php', {'arrFields[]': fields, 'mode':'save', 'colname[]': colnames, 'table':'press_release'}, function(data){  
			   				if(data==false){
								alert('ERROR!');												
							}
							else{
								//alert('Successfully saved');
								window.location.reload();	
							}
			   			})	
					}
				})
				
				
				cView.click(function(){
					
				});
				
				cDelete.click(function(e){
					if(confirm("Are you sure?"))
    					{
							var Did= $(this).attr("id");
							$.get('../library/function.php', {'mode':'delete','table':'press_release','where':'pr_id="'+Did+'"'}, function(data){  
			   				if(data==false){
								alert('ERROR!');												
							}
							else{
								//alert('Successfully deleted');	
								window.location.reload();			
							}
							}) 
					    }
   					
					else
    			 		{
        				e.preventDefault();
    			 	}
				})
				
				
		 		eBack2.click(function(){
					disablePopup(divInputs);
				});					
				btncloseInputs.click(function(){
					disablePopup(divInputs);
				});
				

        });
    </script>

	<style>
		#add_pr{
			width:100px;
			font: 8pt Verdana, Arial, Helvetica, sans-serif;
			margin: 0px;
			padding-top: 1px;
			padding-left: 0px;
			display: inline;
			background: #D5D5D4; 
			font-weight:bold;
		}
		#example_length label, #example_info{
			display:none;	
		}
		#example_length{
			width:100px;	
			float:right;
		}
		#example_filter{
			float:left;	
			width:200px;
		}
		
		#divInputs{
		display:none;
    	position:absolute;
    	_position:absolute; /* hack for internet explorer 6*/
   	 	-moz-border-radius:6px;-webkit-border-radius:6px;
     	behavior: url(border-radius.htc);
    	-khtml-border-radius: 6px;
     	width:430px;
     	height:500px;
		background: rgb(184,196,208);
		background: rgba(184,196,208 0.9);
		border-radius:10px;
		border:4px solid #cecece;
		z-index:99999 !important;
		padding:5px;
		font: 12px Arial, Helvetica, sans-serif;
		top:0;	
		}
	
		#backgroundPopup{
		display:none;
		position:fixed;
		_position:absolute; /* hack for internet explorer 6*/
		height:200%;
		width:100%;
		top:0;
		left:0;
		background:#000000;
		border:1px solid #cecece;
		z-index:99998 !important;	
		}
		#divInputs input , #divInputs textarea {
    	border: 5px solid white; 
    	-webkit-box-shadow: 
      	inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 16px rgba(0,0,0,0.1); 
    	-moz-box-shadow: 
      	inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 16px rgba(0,0,0,0.1); 
    	box-shadow: 
      	inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 16px rgba(0,0,0,0.1); 
    	padding: 10px;
    	background: rgba(255,255,255,0.5);
    	margin: 0 0 0px 0;
		max-height:200px;
		max-width: 280px;
		min-width:280px;
	}
	#eSave {
		-webkit-border-top-left-radius: 25px;
		-webkit-border-bottom-left-radius: 25px;
		-moz-border-radius-topleft: 25px;
		-moz-border-radius-bottomleft: 25px;
		border-top-left-radius: 25px;
		border-bottom-left-radius: 25px;
		font-weight:bold;
	}
	#eDelete, #eBack, #eBack2 {
		-webkit-border-top-right-radius: 25px;
		-webkit-border-bottom-right-radius: 25px;
		-moz-border-radius-topright: 25px;
		-moz-border-radius-bottomright: 25px;
		border-top-right-radius: 25px;
		border-bottom-right-radius: 25px;	
		font-weight:bold;
	}
	h2 {
    color: #444444;
    font-size: 2em;
    font-weight: 700;
    margin-bottom: 0px;
    text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5);
	}
	td h4 {
    color: #444444;
    font-size: 1em;
    font-weight: bold;
	font-style:italic;
	margin-top:0px;
    margin-bottom: 12px;
    text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5);
	}
	p{
    color: #444444;
    font-size: 1.2em;
    margin: 0;
    text-shadow: none;
	line-height:140%;
	}
	.date_clearer{
		display:none;	
	}
	</style>
        <div class="grid_2">
            <div class="box sidemenu">
                <div class="block" id="section-menu">
                    <ul class="section menu">
                        <li style="margin-left:-40px;"><a class="menuitem">Press Release</a></li>
						<li style="margin-left:-40px;"><a class="menuitem">Living Healthy</a></li>
                    </ul>
                </div>
            </div>
        </div>
         <div class="grid_10">
            <div class="box round first grid">
                <h2>
                    Press Release</h2>
                <div class="block">

                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Title</th>
							<th>Author</th>
							<th>Date Published</th>
                            <th>Command</th>
						</tr>
					</thead>
					<tbody>
                        <?php
						if($resultMembers=$query->query("SELECT * FROM ".DBPREFIX."press_release order by pr_id")){
							while($row_Members = mysql_fetch_object($resultMembers)){
								print"<tr>";
				   				print"<td>".$row_Members->pr_title."</td>";
								print"<td>".$row_Members->pr_author."</td>";
								print"<td>".$row_Members->pr_date."</td>";
				    			print"<td><a href='#' class='cView' id='".$row_Members->pr_id."'>VIEW</a>/
								<a href='#' class='cEdit' id='".$row_Members->pr_id."'>EDIT</a>/
								<a href='#' class='cDelete' id='".$row_Members->pr_id."'>DELETE</a></td>";  
								print"</tr>";
							}
						}
 						?>
					</tbody>
				</table>
                    
                    
                    
                </div>
            </div>
        </div>
        
        
                <div id="divInputs">
			<div align="right"><a href="#" id='btncloseInputs'><div style="padding:5px;"><img src="img/cross.png" style='width:10px;'/></div></a></div>
            
            <div id="addEvents">
			<table>
            	<tr>
            		<td><strong>News Title:</strong> </td><td width="5"></td><td align="left"><input type="text" id="eventTitle" style="width:280px;"/></td>
                </tr>
                <tr>
            		<td><strong>News Author:</strong> </td><td width="5"></td><td align="left"><input type="text" id="eventAuthor" style="width:280px;"/></td>
                </tr>
                <tr  valign="top">
            		<td  valign="top"> <strong>News Body:</strong>  </td><td width="5"></td><td align="left"> <textarea id="eventBody" style="height:200px; min-height:200px; width:280px;"></textarea></td>
                </tr>
                <tr>
            		<td><strong>Date: </strong> </td><td width="5"></td><td align="left"><input type="text" id="eventDate" style="width:280px;"/></td>
                </tr>
                <tr>
                	<td colspan="3">
                    <div style="right:0;bottom:0; position:absolute; margin:10px 20px;">
                    <input type="button" id="eSave" value="save" style="width:100px; min-width:100px; margin-right:15px; cursor:pointer; "/>
                    <input type="button" id="eBack2" value="close" style="width:100px; min-width:100px; cursor:pointer;"/>
                    <input type="hidden" id="eHidden" value="">
                    </div></td>
                </tr>
           </table>
          </div>
          
		</div>
		<div class="clear"></div>
		<div id="backgroundPopup"></div>
