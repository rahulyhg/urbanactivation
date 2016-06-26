 <?php
    
 function DeleteDirectory($dir){
     if( !file_exists($dir) ){
         return;
     }
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it,
         RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file) {
    if ($file->isDir()){
    rmdir($file->getRealPath());
    } else {
    unlink($file->getRealPath());
    }
    }
    rmdir($dir);
 }
    $uploadDirPath = $_SERVER['DOCUMENT_ROOT'] . '/urbanactivation/dreamcms/app/webroot/uploads/617';
    DeleteDirectory($uploadDirPath);


    $uploadDirPath = $_SERVER['DOCUMENT_ROOT'] . '/urbanactivation/dreamcms/app/webroot/uploads/otherdocs/617';
    DeleteDirectory($uploadDirPath);

    echo 'done';
    return;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
</head>
<body>
    <script type="text/javascript" src="./js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./js/jquery-ui.min.js" ></script>
    <link rel="stylesheet" type="text/css" href="./css/jquery-ui.css" />
    <style>
   .ui-dialog .ui-dialog-buttonpane .ui-button{
    margin: 20px;
    padding: 20px;
    display:none;
   }

    </style>
    <script type="text/javascript"> 
    $(function () {        
        $(".overlayViewer").click(function () {
        var fileName = $(this).attr('title');
        var w = window.innerWidth -100;
        var h = window.innerHeight - 50;
        $("#dialog").dialog({
                    modal: true,
                    title: fileName,
                    width: w,
                    height: h,
                    position:'center',
                    buttons: {
                        Close: function () {
                            $(this).dialog('close');
                        }
                    },
                    open: function () {
                        var object = "<object data=/"" + fileName + "/" type=/"application/pdf/" width=/'" + w + "/' height=/'" + h +"/'>";
                        object += "If you are unable to view file, download <a target = /"_blank/" href = /"http://get.adobe.com/reader//">Adobe PDF Reader</a> to view the file.";
                        object += "</object>";
                        $("#dialog").load("http://localhost/urbanactivation/navigate.php");
                    }
                });
            });
            
        $(".popupLoad").click(function () {
        alert('launched');
        var path = $(this).attr('title');
        var w = window.innerWidth -100;
        var h = window.innerHeight - 50;
        $("#dialog").dialog({
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
                        $("#dialog").load("path");
                    }
                });
            });
        });
    </script>
    <h1><a href='#' class="overlayViewer" title="./contract.pdf">View File</a></h1>
    <div id="dialog" style="display: none">
    </div>
    
   
</body>
</html>