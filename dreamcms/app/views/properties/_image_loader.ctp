<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
/*	//design export to excel functionality
	if(isset($report) && count($report)>0){
		$curDate = mktime(0,0,0,date("n"),date("j"),date("Y"));
		//print_r($report);
		//create CSV file based on the data
		$filename = "promo_code_report_".$curDate.".csv";
		// create a file pointer connected to the output stream
		$path = dirname(dirname(dirname(__FILE__))).'/webroot/uploads/reports/'.$filename;
		//echo $path;
		$output = fopen($path, 'w') or die('cannot find file');
		
		// output the column headings
		fputcsv($output, array('FirstName', 'LastName', 'Email', 'Address1','Address2','Postcode','Phone','Registration Date','State','Country','Promo Code','Value','Discount Type'));
		for($i=0;$i<count($report);$i++){
			fputcsv($output, $report[$i]);
		}
		fclose($fp);
		echo '<div style="width: 100%;">
        <div id="record_header_wrap">
            <div id="record_header">
                <div id="record_detail">
                    <div style="width: 92%; float: left;">
                        Extract Promo Code Report
                    </div>
                    <div style="width: 8%; float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>
                </div>
            </div>
        </div>	
        <div clear="all" />
        <div id="record">
			<div style="background-color:#F2F2F2;padding:10px; width:95%;"><a href="'.Configure::read('Company.url').'dreamcms/app/webroot/uploads/reports/'.$filename.'" target="_blank">Click here</a> to download the report. Try another report <a href="javascript: history.go(-1);">here</a>.</div>
		</div>
		</div>';
	} else {
		echo '<div style="width: 100%;">
        <div id="record_header_wrap">
            <div id="record_header">
                <div id="record_detail">
                    <div style="width: 92%; float: left;">
                        Extract Promo Code Report
                    </div>
                    <div style="width: 8%; float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>
                </div>
            </div>
        </div>	
        <div clear="all" />
        <div id="record">
			<div style="background-color:#F2F2F2;padding:10px; width:95%;">Unfortunately, no reports could be drawn from the database for the values provide. Please change the filters and <a href="javascript:history.go(-1);">try again.</a>
		</div>
		</div>';
	} */
} else { ?>
	
<!--<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="https://github.com/blueimp/jQuery-File-Upload">jQuery File Upload</a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li class="active"><a href="#">Demo</a></li>
                    <li><a href="https://github.com/blueimp/jQuery-File-Upload/downloads">Downloads</a></li>
                    <li><a href="https://github.com/blueimp/jQuery-File-Upload">Source Code</a></li>
                    <li><a href="https://github.com/blueimp/jQuery-File-Upload/wiki">Documentation</a></li>
                    <li><a href="https://github.com/blueimp/jQuery-File-Upload/issues">Issues</a></li>
                    <li><a href="test/">Test</a></li>
                    <li><a href="https://blueimp.net">&copy; Sebastian Tschan</a></li>
                </ul>
            </div>
        </div>
    </div>-->
</div>
<div class="container">
    <!--<div class="page-header">
        <h1>jQuery File Upload Demo</h1>
    </div>
    <blockquote>
    <a href="http://echo00/webdev.upd/dreamcms/app/views/properties/test/">Test</a>
        <p>File Upload widget with multiple file selection, drag&amp;drop support, progress bars and preview images for jQuery.<br>
        Supports cross-domain, chunked and resumable file uploads and client-side image resizing.<br>
        Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.</p>
    </blockquote>
    <br>-->
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="server/php/" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
   <!-- <br>
    <div class="well">
        <h3>Demo Notes</h3>
        <ul>
            <li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default file size is unlimited).</li>
            <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
            <li>Uploaded files will be deleted automatically after <strong>5 minutes</strong> (demo setting).</li>
            <li>You can <strong>drag &amp; drop</strong> files from your desktop on this webpage with Google Chrome, Mozilla Firefox and Apple Safari.</li>
            <li>Please refer to the <a href="https://github.com/blueimp/jQuery-File-Upload">project website</a> and <a href="https://github.com/blueimp/jQuery-File-Upload/wiki">documentation</a> for more information.</li>
            <li>Built with Twitter's <a href="http://twitter.github.com/bootstrap/">Bootstrap</a> toolkit and Icons from <a href="http://glyphicons.com/">Glyphicons</a>.</li>
        </ul>
    </div>-->
</div>
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>

            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>

<?php	
/* ?>
	<script language="javascript" type="text/javascript">
    $(function()
    {
        var date = new Date();
        var currentMonth = date.getMonth(); // current month
        var currentDate = date.getDate(); // current date
        var currentYear = date.getFullYear(); //this year
            
        $('#TblimportsourceFromDate').datePicker({
            startDate:'01/01/1996',
            endDate: (new Date()).asString()
        });
        $('#TblimportsourceToDate').datePicker({
            startDate:'01/01/1996',
            endDate: (new Date()).asString()
        });
    });
    </script>
    <div style="width: 100%;">
        <div id="record_header_wrap">
            <div id="record_header">
                <div id="record_detail">
                    <div style="width: 92%; float: left;">
                        Extract Promo Code Report
                    </div>
                    <div style="width: 8%; float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>
                </div>
            </div>
        </div>	
        <div clear="all" />
        <div id="record">
            <?php 
                echo $this->Form->create('Tblimportsource', array('class'=>'editForm'));
                echo $this->Form->input('FromDate', array('class'=>'dateField','id' => 'TblimportsourceFromDate', 'readonly' => 'true','style'=>'width:100px;'));
                echo $this->Form->input('ToDate', array('class'=>'dateField','id' => 'TblimportsourceToDate', 'readonly' => 'true','style'=>'width:100px;'));
                echo $this->Form->input('ImportSourceCode', array('label' => 'Promo Code','style'=>'width:100px;'));
                echo $this->Form->input('Postcode', array('label' => 'Postcode','style'=>'width:100px;'));
                foreach ($stateoptions as $stateoption){
                    $DDSOptions[$stateoption['Tblstate']['ID']] = $stateoption['Tblstate']['State'];
                }
                echo $this->Form->input('State', array('type' => 'select', 'escape' => false, 'options' => $DDSOptions,'default'=>'7', 'label' => 'State'));
                foreach ($countryoptions as $countryoption){
                    $DDCOptions[$countryoption['Tblcountry']['ID']] = $countryoption['Tblcountry']['Country'];
                }
                echo $this->Form->input('Country', array('type' => 'select', 'escape' => false, 'options' => $DDCOptions,'default'=>'14', 'label' => 'Country'));
                echo $this->Form->button('Extract Report', array('type'=>'submit', 'style'=>'margin: 10px 130px; width: auto; padding: 0;'));
            ?>
        </div>
    </div>
<?php*/ }  ?>

