<?php //session_start(); ?>
<?php //var_dump($_SESSION); ?>
<?php $baseURL = ($_SERVER["SERVER_NAME"]=="echo00") ? "http://echo00/urbanactivation/" : "http://www.urbanactivation.com.au/"; ?>
<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin Demo 8.8.5
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<html lang="en">
<head>
<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<meta charset="utf-8">
<title>jQuery File Upload Demo</title>
<meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bars, validation and preview images, audio and video for jQuery. Supports cross-domain, chunked and resumable file uploads and client-side image resizing. Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap CSS Toolkit styles -->

<!--<link rel="stylesheet" href="http://blueimp.github.io/cdn/css/bootstrap.min.css">--><link rel="stylesheet" href="css/bootstrap.min.css">

<!-- Generic page styles -->

<link rel="stylesheet" href="css/style.css">

<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->

<!--<link rel="stylesheet" href="http://blueimp.github.io/cdn/css/bootstrap-responsive.min.css">--><link rel="stylesheet" href="css/bootstrap-responsive.min.css">

<!-- Bootstrap CSS fixes for IE6 -->

<!--[if lt IE 7]>

<link rel="stylesheet" href="http://blueimp.github.io/cdn/css/bootstrap-ie6.min.css">

<![endif]-->

<!-- blueimp Gallery styles -->

<!--<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">--><link rel="stylesheet" href="css/blueimp-gallery.min.css">

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->

<link rel="stylesheet" href="css/jquery.fileupload-ui.css">

<!-- CSS adjustments for browsers with JavaScript disabled -->

<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>

<style type="text/css">

#helpText { font-size:10px; padding:10px 0 10px 20px; }

</style>
<script language="javascript" type="text/javascript">

<!--

	

	function closeForm(s) {
		if(s=='Submit') {
			//parent.updateForm();	
		} else { // cancel on any other option
			parent.updateCancel();	
			top.tb_remove();
		}
	}
-->

</script>
</head>
<body>
<div class="container">
    <br>
    <?php //var_dump($_REQUEST); ?>
    <!-- The file upload form used as target for the file upload widget -->
    <div id="helpText">
    	<ol>
    		<li>Select "Add files" and choose 1 or more files to upload.</li>
        	<li>Individually upload the displayed list of files by selecting "Start" next to each image or "Start upload" to upload all images simultaniously.</li>
        	<li>Choose "Cancel upload" to stop the uploading process or "Delete" to remove uploaded images from the list.</li>
        	<li>When the upload is complete, for one or more images, the green progress bar should no longer be visible.</li>
        	<li>If you wish to add more images then repeat from step 1.</li>
        	<li>Select either "Accept all images" to accept OR "Cancel and close" to not include the displayed images.</li>
        </ol>
    </div>
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="server/php/" method="POST" enctype="multipart/form-data">
       	<input type="hidden" id="id"  name="id"  value="<?php echo $_REQUEST["id"];?>" /><!-- record id -->
    	<input type="hidden" id="key" name="key" value="<?php echo $_REQUEST["key"];?>" /><!-- random seed -->
    	<input type="hidden" id="fld" name="fld"  value="<?php echo $_REQUEST["fld"];?>" /><!-- image table field (for id) -->
    	<input type="hidden" id="df" name="df"  value="<?php echo $_REQUEST["df"];?>" /><!-- document folder ../webroot/img/[df] -->
    	<input type="hidden" id="bp" name="bp" value="<?php echo $_SERVER["PHP_SELF"];?>" /><!-- base path -->
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The loading indicator is shown during file processing -->
                <span class="fileupload-loading"></span>
            </div>
            <!-- The global progress information -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
        <div id="helpText">Select from the options below to complete the process.</div>
        <input type="submit" class="btn btn-success fileinput-button" onClick="javascript:document.getElementById('fileupload').action='<?php echo $baseURL; ?>dreamcms/index.php/images/add';" name="submit" id="submit" value="Accept all images" /> <!-- self.parent.tb_remove() -->
        <input type="button" class="btn btn-warning cancel" onClick="javascript:closeForm(this.value);" name="cancel" id="cancel" value="Cancel and close" />
    </form>
    <br>
    
</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">	
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>			
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <p class="size">{%=o.formatFileSize(file.size)%}</p>			
            {% if (!o.files.error) { %}
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            {% } %}
        </td>
        <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
					 <td colspan="2"><input type="hidden" id="uploadFileName" name="uploadFileName[]" value="{%=file.name%}"></td>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">			
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

<script src="js/vendor/jquery.ui.widget.js"></script>

<!-- The Templates plugin is included to render the upload/download listings -->

<!--<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>--><script src="js/tmpl.min.js"></script>

<!-- The Load Image plugin is included for the preview images and image resizing functionality -->

<!--<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>--><script src="js/load-image.min.js"></script>

<!-- The Canvas to Blob plugin is included for image resizing functionality -->

<!--<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>--><script src="js/canvas-to-blob.min.js"></script>

<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->

<!--<script src="http://blueimp.github.io/cdn/js/bootstrap.min.js"></script>--><script src="js/bootstrap.min.js"></script>

<!-- blueimp Gallery script -->

<!--<script src="http://blueimp.github.io/Gallery/js/blueimp-gallery.min.js"></script>--><script src="js/blueimp-gallery.min.js"></script>

<!--<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>--><script src="js/jquery.blueimp-gallery.min.js"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->

<script src="js/jquery.iframe-transport.js"></script>

<!-- The basic File Upload plugin -->

<script src="js/jquery.fileupload.js"></script>

<!-- The File Upload processing plugin -->

<script src="js/jquery.fileupload-process.js"></script>

<!-- The File Upload image preview & resize plugin -->

<script src="js/jquery.fileupload-image.js"></script>

<!-- The File Upload audio preview plugin -->

<script src="js/jquery.fileupload-audio.js"></script>

<!-- The File Upload video preview plugin -->

<script src="js/jquery.fileupload-video.js"></script>

<!-- The File Upload validation plugin -->

<script src="js/jquery.fileupload-validate.js"></script>

<!-- The File Upload user interface plugin -->

<script src="js/jquery.fileupload-ui.js"></script>

<!-- The main application script -->

<script src="js/main.js"></script>

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->

<!--[if gte IE 8]>

<script src="js/cors/jquery.xdr-transport.js"></script>

<![endif]-->

</body> 

</html>

