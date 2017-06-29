   /*
  *  Additional jQuery code require for the Simple SKU generator plugin to run
  *
  *   - HP Gong 
  */
 
(function( $ ) {
$(document).ready(function(){
$('#wcount').on('change keyup', function() {
  var sanitized = $(this).val().replace(/[^0-9]/g, '');
  $(this).val(sanitized);
}); 

var categories = {
    "None":[{value:'3', text:'No cataegory selected'}],
    "1000":[{value:'1100', text:'1100'},{value:'1200', text:'1200'},{value:'1300', text:'1300'}],
    "2000":[{value:'2100', text:'2100'},{value:'2200', text:'2200'},{value:'2300', text:'2300'}],
	"3000":[{value:'3100', text:'3100'},{value:'3200', text:'3200'},{value:'3300', text:'3300'}]
    };
function selectchange(){
    var select = $('[name=end]');
    select.empty();
    $.each(categories[$(':selected', this).text()], function(){
        select.append('<option value="'+this.value+'">'+this.text+'</option>');
    });
}
$(function(){
    $('[name=start]').on('change', selectchange);
});

});	
})( jQuery );
