	getPagination('.data-filter');
	var oFather=$('.data-filter').parents(); 
	$("").before('<div class="header_wrap">'+
        '<div class="num_rows">'+
				'<div class="form-group">'+
			 		'<select class="elementDatatablepro maxRows" name="state" id="">'+
						 '<option value="10">10</option>'+
						 '<option value="15">15</option>'+
						 '<option value="20">20</option>'+
						 '<option value="50">50</option>'+
						 '<option value="70">70</option>'+
						 '<option value="100">100</option>'+
            			 '<option value="-1">Mostrar todos los registros</option>'+
						'</select>'+
			  	'</div>'+
        '</div>'+
        '<div class="tb_search">'+
			'<input type="text" id="search_input_all" placeholder="Buscar" class="elementDatatablepro search_input_all">'+
        '</div>'+
      '</div>');
	$(oFather).find('.maxRows').trigger('change');

	function getPagination (table){

		  $(oFather).find('.maxRows').on('change',function(){
		  	$('.pagination').html('');						
		  	var trnum = 0 ;	
		  	var totalRows = $(table+' tbody tr').length;
		  	
		  	if($(this).val()>0){
				var maxRows = parseInt($(this).val());
		  	}else{
		  		var totalRows = $(table+' tbody tr').length;
		  		var maxRows = totalRows;	
		  	}								 
		  			
			 $(table+' tr:gt(0)').each(function(e, element){
			 	 
			 		trnum++;									
				 	if (trnum > maxRows ){	
				 		$(this).hide();							
				 	}if (trnum <= maxRows ){
				 		$(this).show();
				 	}
				 	
			 });											
			 if (totalRows > maxRows){						
			 	var pagenum = Math.ceil(totalRows/maxRows);	  
			 												
			 	for (var i = 1; i <= pagenum ;){			
			 	$('.pagination').append('<span data-page="'+i+'">\
				      <span>'+ i++ +'</span>\
				    </span>').show();
			 	}											
     
         
			} 												
			$('.pagination span:first-child').addClass('active');  
        
        
        //SHOWING ROWS NUMBER OUT OF TOTAL DEFAULT
       showig_rows_count(maxRows, 1, totalRows);
        //SHOWING ROWS NUMBER OUT OF TOTAL DEFAULT

        $('.pagination span').on('click',function(e){		// on click each page
        e.preventDefault();
				var pageNum = $(this).attr('data-page');	// get it's number
				var trIndex = 0 ;							// reset tr counter
				$('.pagination span').removeClass('active');	// remove active class from all li 
				$(this).addClass('active');					// add active class to the clicked 
        
        
        //SHOWING ROWS NUMBER OUT OF TOTAL
       showig_rows_count(maxRows, pageNum, totalRows);
        //SHOWING ROWS NUMBER OUT OF TOTAL
        
        
        
				 $(table+' tr:gt(0)').each(function(){		// each tr in table not the header
				 	trIndex++;								// tr index counter 
				 	// if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
				 	if (trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows)){
				 		$(this).hide();		
				 	}else {$(this).show();} 				//else fade in 
				 }); 										// end of for each tr in table
					});										// end of on click pagination list
		});
											// end of on select change 
		 
								// END OF PAGINATION 
    
	}	


			

// SI SETTING
$(function(){
	// Just to append id number for each row  
default_index();
					
});

//ROWS SHOWING FUNCTION
function showig_rows_count(maxRows, pageNum, totalRows) {
   //Default rows showing
        var end_index = maxRows*pageNum;
        var start_index = ((maxRows*pageNum)- maxRows) + parseFloat(1);
        var string = 'Mostrando '+ start_index + ' al ' + end_index +' de ' + totalRows + ' registros';               
        $('.rows_count').html(string);
}

// CREATING INDEX
function default_index() {
  $('table tr:eq(0)').prepend('<th> ID </th>')

					var id = 0;

					$('table tr:gt(0)').each(function(){	
						id++
						$(this).prepend('<td>'+id+'</td>');
					});
}

// All Table search script
function FilterkeyWord_all_table() {
  
// Count td if you want to search on all table instead of specific column

  var count = $('.table').children('tbody').children('tr:first-child').children('td').length; 

        // Declare variables
  var input, filter, table, tr, td, i;
  input = $(oFather).find(".search_input_all")
  //document.getElementById("search_input_all");
  var input_value = $(oFather).find(".search_input_all").val();
  //var input_value =     document.getElementById("search_input_all").value;
        filter = input.value.toLowerCase();
  if(input_value !=''){
        table = document.getElementById("table-id");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 1; i < tr.length; i++) {
          
          var flag = 0;
           
          for(j = 0; j < count; j++){
            td = tr[i].getElementsByTagName("td")[j];
            if (td) {
             
                var td_text = td.innerHTML;  
                if (td.innerHTML.toLowerCase().indexOf(filter) > -1) {
                //var td_text = td.innerHTML;  
                //td.innerHTML = 'shaban';
                  flag = 1;
                } else {
                  //DO NOTHING
                }
              }
            }
          if(flag==1){
                     tr[i].style.display = "";
          }else {
             tr[i].style.display = "none";
          }
        }
        //$('#maxRows').trigger('change');
        $('.pagination').html('');						
		  	var trnum = 0 ;	
		  	var totalRows = $('#table-id tbody tr:visible').length;
		  	
		  	if($(oFather).find(".maxRows").val()>0){
				var maxRows = parseInt($(oFather).find(".maxRows").val());
		  	}else{
		  		var totalRows = $('#table-id tbody tr').length;
		  		var maxRows = totalRows;	
		  	}								 
		  			
			 $('#table-id tr:gt(0)').each(function(e, element){
			 	 if($(element).is(":visible")){
			 	 	trnum++;									
				 	if (trnum > maxRows ){	
				 		$(this).hide();							
				 	}if (trnum <= maxRows ){
				 		$(this).show();
				 	}
			 	 }
				 	
			 });											
			 if (totalRows > maxRows){						
			 	var pagenum = Math.ceil(totalRows/maxRows);	  
			 												
			 	for (var i = 1; i <= pagenum ;){			
			 	$('.pagination').append('<span data-page="'+i+'">\
				      <span>'+ i++ +'</span>\
				    </span>').show();
			 	}											
     
         
			} 												
			$('.pagination span:first-child').addClass('active'); 
			showig_rows_count(maxRows, 1, totalRows);
    }else {
      //RESET TABLE
      $(oFather).find('.maxRows').trigger('change');
    }
}

$("body").on("keyup",".search_input_all",function(e){
	FilterkeyWord_all_table()
})