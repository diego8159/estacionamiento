$(function(){
			  var patentes = [ 

			   {value: "123" , data: " 2016-04-14 02:44:05 " }, 
 {value: "123" , data: " 2016-04-14 02:44:22 " }, 

			   
			  ];
			  
			  // setup autocomplete function pulling from patentes[] array
			  $('#autocomplete').autocomplete({
			    lookup: patentes,
			    onSelect: function (suggestion) {
			      var thehtml = '<strong>patente: </strong> ' + suggestion.value + ' <br> <strong>ingreso: </strong> ' + suggestion.data;
			      $('#outputcontent').html(thehtml);
			         $('#botonIngreso').css('display','none');
      						console.log('aca llego');
			    }
			  });
			  

			});