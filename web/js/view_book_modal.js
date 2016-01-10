/**
 * Created by andreyshade on 10.01.16.
 */
$(document).ready(function() {
    $('.view-details').click(function () {
        var url = $(this).attr('href');
        $('#modal-result').html();
        $('#modal-result').load(
            url,
            function () {
                $('#book-view-modal').modal('show');
            }
        );
        return false;
    })
});