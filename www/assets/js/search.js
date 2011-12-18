// start
$(function() {
    //Searcher.form = '#search_form'
     $('#search_form').on( 'submit', Searcher.on_submit );

    $('#select_country').on( 'change', Searcher.on_change_country );
    
    $('#search_results').scrollPagination({
        'contentPage': '/search/', // the page where you are searching for results
        'contentData': $('#search_form').serialize+'&page='+children.size(), // you can pass the children().size() to know where is the pagination
        'scrollTarget': $(window), // who gonna scroll? in this example, the full window
        'heightOffset': 10, // how many pixels before reaching end of the page would loading start? positives numbers only please
        'beforeLoad': function(){ // before load, some function, maybe display a preloader div
            $('#waypoint').fadeIn();	
        },
        'afterLoad': function(elementsLoaded){ // after loading, some function to animate results and hide a preloader div
             $('#waypoint').fadeOut();
             var i = 0;
             $(elementsLoaded).fadeInWithDelay();
             //if ($('#content').children().size() > 100){ // if more than 100 results loaded stop pagination (only for test)
              ///  $('#content').stopScrollPagination();
             //}
        }
    });

    // code for fade in element by element with delay
    $.fn.fadeInWithDelay = function(){
        var delay = 0;
        return this.each(function(){
            $(this).delay(delay).animate({opacity:1}, 200);
            delay += 100;
        });
    };
        
     
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