// start
$(function() {
    //Searcher.form = '#search_form'
    $('#search_form').on( 'submit', Searcher.on_submit );

    $('#select_country').on( 'change', Searcher.on_change_country );

    $('#waypoint').waypoint( Searcher.on_scroll, Searcher.opts );     
});

// our main object
var Searcher = {
    page : 0,
    have_sent : false,
    opts : { offset: '100%' },
    
    /**
     * Handler on #search_form.submit
     */
    on_submit: function(){
        Searcher.have_sent = true;
        $('#search_results').html( '' );
        $('#waypoint').fadeIn()
        Searcher._send_query();
        return false;
	},
    
    /**
     * Hander #search_results.waypoint
     */
    on_scroll : function( e, direction ){
        //alert( Searcher.have_sent );
        if( Searcher.have_sent ) {
            var wp = $('#waypoint');
            wp.waypoint('destroy');
            Searcher._send_query();
            wp.waypoint( Searcher.on_scroll, Searcher.opts );
        }
    },
    
    /**
     * Send query again and again
     */
    _send_query : function(){
        $.getJSON( '/search/', $('#search_form').serialize()+'&page='+Searcher.page,
            function( data ){
                // if OK, append HTML and keep in safe PAGE number
                if( data.status == 'ok' ){
                    Searcher.page = data.page;
                    $('#search_results').append( data.html );
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
                if( data.status == 'error' ){
                    Searcher.error( data.html );
                }
                if( data.status == 'ok' ){
                    $('#select_city').html( data.html );
                }
            }
        );        
    },
    
    /**
     * Show error message div
     */
    error: function( msg ){
        $('#info').html(
            '<div class="alert-message error">' +
            '<a class="close" href="#" onClick="$(this).parent().hide();">×</a>'+
            '<p>' + msg + '</p>'+
            '</div>'
        );
    }
    
}