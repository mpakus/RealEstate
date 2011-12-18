// start
$(function() {
    //Searcher.form = '#search_form'
     $('#search_form').on( 'submit', Searcher.on_submit );
});

// our main object
var Searcher = {
    //form : '',
    
    on_submit: function() {
        //var params = 
        $.post("/search/", $(this).serialize(),
            function(data){
                alert(data);
            }
        );
        return false;
	}
}