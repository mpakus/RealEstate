// start
$(function() {
    //Searcher.form = '#search_form'
     $('#search_form').on( 'submit', Searcher.on_submit );

    $('#select_country').on( 'change', Searcher.on_change_country );
    
    $('#waypoint').waypoint( Searcher.on_scroll );
     
});

// our main object
var Searcher = {
    page : 0,
    
    /**
     * Handler on #search_form.submit
     */
    on_submit: function(){
        Searcher._send_query();
        return false;
	},
    
    /**
     * Hander #search_results.waypoint
     */
    on_scroll : function( e, direction ){
        Searcher._send_query();
    },
    
    /**
     * Send query again and again
     */
    _send_query : function(){
        $.getJSON( '/search/', $('#search_form').serialize()+'&page='+Searcher.page,
            function( data ){
                // if OK, append HTML and keep in safe PAGE number
                if( data.status == 'ok' ){
                    $('#search_results').append( data.html );
                    Searcher.page = data.page+1;
                    console.info( Searcher.page );
                }
            }
        );        
    },
    
    /**
     * Handler #select_country.onChange
     */
    on_change_country: function(){
        $.getJSON( '/cities/', {country: $(this).val()} ,
            function( data ){
                if( data.status == 'ok' ){
                    $('#select_city').replace( data.html );
                }
            }
        );
        
    }
}