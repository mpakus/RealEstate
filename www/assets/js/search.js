// start
$(function() {
     $('#search_form').on( 'submit', Searcher.on_submit );
});

// our main object
var Searcher = {
    on_submit: function() {
        alert( this );
	}
}