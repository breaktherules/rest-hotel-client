/**
 * Created by Najam.Haque on 11/7/2015.
 */

$(function() {

    /**
     * @todo ajaxSpinner is not working as expected
     */
    $('#btnAjaxCaller').click(function(){
        $(this).addClass("active");
        /**
         * Clear the previous result
         */
        clearResponse();

        var url = $('input[name=ajaxType]:checked').val();

        $.ajax({
            url: url,
            contentType: 'text/plain',
            xhrFields: {
                withCredentials: false
            },
            error: function () {
                $('#btnAjaxCaller').removeClass('active');
                $("#ajaxResult").html("<div class='alert alert-danger'>An error has occurred making that ajax call.</div> <div class='alert alert-info'>We would like to remind you that the sever must respond with Access-Control-Allow-Origin: * to enable CORS functionality.</div>");
            },

            success: function (data) {
                /**
                 * This should be a generic method to handle most ajax call from server.
                 * The server in some case might want to forward instruction to js client.
                 * for example the previous operation was successful and now redirect to a new page.
                 * like in an edit operation.
                 */
                $('#btnAjaxCaller').removeClass('active');
                var $searchResult = $("#ajaxResult");
                $searchResult.html(data);
            }
        });
    });

    $("#btnClearResponse").click(function () {
        clearResponse();
    });
});

function clearResponse()
{
    $("#ajaxResult").html("");
}
