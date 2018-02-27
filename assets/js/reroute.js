$(document).ready(function () {
    $(document).on('click', '.changePage', function() {
        var name = this.attributes["name"].value;

        changePage(name);
    });
});

    function changePage(loadURL) {
        var loading_append = '<img style="width:auto; height: 50px;" src="'+baseurl+'assets/img/loading.gif" alt="Loading" align="center">';
        $("#content-container").append(loading_append);

        var error_append = "";

        jQuery.ajax({
            type: "POST",
            url: baseurl + loadURL,
            dataType: 'json',
            data: $("#rerouteform").serialize(),
            success: function(res) {
                $("#content-container").html("");
                $("#content-container").append(res.html_append);
            }, error: function(e) {
                error_append = '    <div class="row">';
                error_append += '       <br>';
                error_append += '       <div class="col l10 offset-l1 m10 offset-m1 s10 offset-s1 center">';
                error_append += '           <div class="card-panel red lighten-2">';
                error_append += '               <span class="black-text">';
                error_append += '                   There is something wrong. Please select another action, <br>or go back to the <span class="changePage cursor" name="dashboard/accounts"><u>Accounts</u></span> Page.';
                error_append += '               </span>';
                error_append += '           </div>';
                error_append += '       </div>';
                error_append += '   </div>';
                $("#content-container").html("");
                $("#content-container").append(error_append);
            }
        });
    }
