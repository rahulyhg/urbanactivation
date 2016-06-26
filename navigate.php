<!DOCTYPE html>
<html>
    <body>
        <script type="text/javascript" src="./js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./js/jquery-ui.min.js" ></script>
    <link rel="stylesheet" type="text/css" href="./css/jquery-ui.css" />
   <script type="text/javascript"> 
    $(function () {        
        $(".popupLoad").click(function () {
        var path = $(this).attr('title');
        var w = window.innerWidth -100;
        var h = window.innerHeight - 50;
        $("#dialogPopUp").dialog({
                    modal: true,
                    title: path,
                    width: w,
                    height: h,
                    position:'center',
                    buttons: {
                        Close: function () {
                            $(this).dialog('close');
                        }
                    },
                    open: function () {
                        $("#dialog").load(path);
                    }
                });
            });
        });
    </script>
        You are currently not logged in.  Would you like to register as a member or a guest?<br><br>
    <input type='button' class="popupLoad" title='http://localhost/ambc/login' value='Login as Member'></input>&nbsp;&nbsp;
    <input type='button' class="popupLoad" title='http://localhost/ambc/event-booking/58' value='Continue as guest'></input>
<div id="dialogPopUp" style="display: none">
    </body>
</html>