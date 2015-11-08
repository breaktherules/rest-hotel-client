/**
 * Created by Najam.Haque on 11/7/2015.
 */

$(function() {
    $("#spinner").hide();
    if (hideError) {
        $("#error").hide();
    }
    var $slider =$("#slider-range");


        $slider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        stop: function( event, ui ) {
            $("#error").hide();
            $("#spinner").addClass('active').show();
            var filterUrl = "/hotel/filter";
            $.ajax({
                url:filterUrl,
                data: {
                    minPrice: ui.values[0],
                    maxPrice: ui.values[1]
                },
                dataType:"json",
                error: function () {
                    $("#error").show();
                    $("#spinner").hide().removeClass('active');
                },

                success: function (data) {
                    /**
                     * This should be a generic method to handle most ajax call from server.
                     * The server in some case might want to forward instruction to js client.
                     * for example the previous operation was successful and now redirect to a new page.
                     * like in an edit operation.
                     */
                    $("#spinner").hide().removeClass('active');
                    var $searchResult = $("div.bs-example");
                    if (data.success) {
                         $searchResult.html(data.formattedResult).show();
                        /**
                         * early returns make code more readable
                         */
                        return;
                    }
                    $searchResult.hide();
                    $("#error").show();
                }
            });

        },
        slide: function( event, ui ) {
            $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        }
    });
    $( "#amount" ).val( "$" + $slider.slider( "values", 0 ) +
        " - $" + $slider.slider( "values", 1 ) );
});