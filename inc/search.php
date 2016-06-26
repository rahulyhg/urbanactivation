<div class="search-box">
<h1>Search for  Properties</h1>
<div id="search-fields">
    <div id="search-left" style="float: left; width: 85%;">
        <!--Keyword -->
        <input type="text" id="key" name="key" value="Keyword search" maxlength="25" style="width:220px; margin-bottom:3px;" onclick="javascript:this.select()" /> 
        <!--State -->
        <select name="pt" id="pt" style="width:180px; margin-bottom:3px;">
            <option value="0" <?php if((int)$pt==0) echo "selected" ?>>All property types</option>
            <?php 
				$propTypes = array();
				$propTypes = getPropertyTypes();
				while($rowPropTypes = mysql_fetch_array($propTypes, MYSQL_ASSOC)){
					echo "<option value='".$rowPropTypes['id']."' ".(((int)$pt==$rowPropTypes['id'])?"selected":"").">".$rowPropTypes['type']."</option>";
				}
			?>
        </select> 
        <!--Price Range -->
        <select name="prl" id="prl" style="width:116px;">
            <option value="0" <?php if((int)$prl==0) echo "selected" ?>>Min price </option>
           
            <option value="150" <?php if((int)$prl==150) echo "selected" ?>>$150k </option>
            <option value="200" <?php if((int)$prl==200) echo "selected" ?>>$200k </option>
            <option value="250" <?php if((int)$prl==250) echo "selected" ?>>$250k </option>
            <option value="300" <?php if((int)$prl==300) echo "selected" ?>>$300k </option>
            <option value="350" <?php if((int)$prl==350) echo "selected" ?>>$350k </option>
            <option value="400" <?php if((int)$prl==400) echo "selected" ?>>$400k </option>
            <option value="450" <?php if((int)$prl==450) echo "selected" ?>>$450k </option>
            <option value="500" <?php if((int)$prl==500) echo "selected" ?>>$500k </option>
            <option value="550" <?php if((int)$prl==550) echo "selected" ?>>$550k </option>
            <option value="600" <?php if((int)$prl==600) echo "selected" ?>>$600k </option>
            <option value="650" <?php if((int)$prl==650) echo "selected" ?>>$650k </option>
            <option value="700" <?php if((int)$prl==700) echo "selected" ?>>$700k </option>
            <option value="750" <?php if((int)$prl==750) echo "selected" ?>>$750k </option>
            <option value="800" <?php if((int)$prl==800) echo "selected" ?>>$800k </option>
            <option value="850" <?php if((int)$prl==850) echo "selected" ?>>$850k </option>
            <option value="900" <?php if((int)$prl==900) echo "selected" ?>>$900k </option>
            <option value="950" <?php if((int)$prl==950) echo "selected" ?>>$950k </option>
            <option value="1000" <?php if((int)$prl==1000) echo "selected" ?>>$1m </option>
            <option value="1250" <?php if((int)$prl==1250) echo "selected" ?>>$1.25m </option>
            <option value="1500" <?php if((int)$prl==1500) echo "selected" ?>>$1.5m </option>
            <option value="1750" <?php if((int)$prl==1750) echo "selected" ?>>$1.75m </option>
            <option value="2000" <?php if((int)$prl==2000) echo "selected" ?>>$2m </option>
            <option value="2500" <?php if((int)$prl==2500) echo "selected" ?>>$2.5m </option>
        </select>
        <select name="prh" id="prh" style="width:117px; margin-left:1px;">

            <option value="150" <?php if((int)$prh==150) echo "selected" ?>>$150k </option>
            <option value="200" <?php if((int)$prh==200) echo "selected" ?>>$200k </option>
            <option value="250" <?php if((int)$prh==250) echo "selected" ?>>$250k </option>
            <option value="300" <?php if((int)$prh==300) echo "selected" ?>>$300k </option>
            <option value="350" <?php if((int)$prh==350) echo "selected" ?>>$350k </option>
            <option value="400" <?php if((int)$prh==400) echo "selected" ?>>$400k </option>
            <option value="450" <?php if((int)$prh==450) echo "selected" ?>>$450k </option>
            <option value="500" <?php if((int)$prh==500) echo "selected" ?>>$500k </option>
            <option value="550" <?php if((int)$prh==550) echo "selected" ?>>$550k </option>
            <option value="600" <?php if((int)$prh==600) echo "selected" ?>>$600k </option>
            <option value="650" <?php if((int)$prh==650) echo "selected" ?>>$650k </option>
            <option value="700" <?php if((int)$prh==700) echo "selected" ?>>$700k </option>
            <option value="750" <?php if((int)$prh==750) echo "selected" ?>>$750k </option>
            <option value="800" <?php if((int)$prh==800) echo "selected" ?>>$800k </option>
            <option value="850" <?php if((int)$prh==850) echo "selected" ?>>$850k </option>
            <option value="900" <?php if((int)$prh==900) echo "selected" ?>>$900k </option>
            <option value="950" <?php if((int)$prh==950) echo "selected" ?>>$950k </option>
            <option value="1000" <?php if((int)$prh==1000) echo "selected" ?>>$1m </option>
            <option value="1250" <?php if((int)$prh==1250) echo "selected" ?>>$1.25m </option>
            <option value="1500" <?php if((int)$prh==1500) echo "selected" ?>>$1.5m </option>
            <option value="1750" <?php if((int)$prh==1750) echo "selected" ?>>$1.75m </option>
            <option value="2000" <?php if((int)$prh==2000) echo "selected" ?>>$2m </option>
            <option value="2500" <?php if((int)$prh==2500) echo "selected" ?>>$2.5m </option>
            <option value="5000" <?php if((int)$prh==5000) echo "selected" ?>>$5.0m </option>
            <option value="0" <?php if((int)$prh==0) echo "selected" ?>>Max price </option>
      </select>
        <!--Status -->
        <select name="prs" id="prs" style="width:180px;">
            <option value="0" <?php if((int)$prs==0) echo "selected" ?>>All property statuses</option>
            <?php 
				$propStatuses = array();
				$propStatuses = getPropertyStatuses();
				while($rowPropStatuses = mysql_fetch_array($propStatuses, MYSQL_ASSOC)){
					echo "<option value='".$rowPropStatuses['id']."' ".(((int)$prs==$rowPropStatuses['id'])?"selected":"").">".$rowPropStatuses['status']."</option>";
				}
			?>
        </select>
        <input type="hidden" name="ft" id="ft" value="all" />
            <!--<input type="hidden" name="tp" id="tp" value="any" />
            <input type="hidden" name="ct" id="ct" value="all" />
            <input type="hidden" name="sb" id="sb" value="all" />-->
            <div style="float:left"><a href="javascript:void(0);" onclick="document.getElementById('advanced_search').style.display=''">ADVANCED SEARCH &raquo;</a></div>
            <?php if(isset($back_link)){ ?><div style="float:right; margin-right:20px"><a href="<?php echo $back_link;?>">&laquo; BACK</a></div><?php } ?>
            <div id="advanced_search" <?php echo ($advancedSearch)?"":"style='display:none'";?>><br />							<?php //var_dump($bed);?>
                <select name="bed[]" id="bed" style="width:200px; margin-left:1px;" multiple="multiple" size="3">
                    <option value="all" <?php if(!isset($bed[0]) || (is_array($bed) && in_array('all' ,$bed))) echo "selected" ?>>All bedroom types</option>
                    <option value="0" <?php if(is_array($bed) && in_array('0' ,$bed)) echo "selected" ?>>Studio (none)</option>
                    <option value="1" <?php if(is_array($bed) && in_array('1' ,$bed)) echo "selected" ?>>1 bedroom</option>
                    <option value="2" <?php if(is_array($bed) && in_array('2' ,$bed)) echo "selected" ?>>2 bedrooms</option>
                    <option value="3" <?php if(is_array($bed) && in_array('3' ,$bed)) echo "selected" ?>>3 bedrooms</option>
                    <option value="4" <?php if(is_array($bed) && in_array('4' ,$bed)) echo "selected" ?>>4 bedrooms</option>
                    <option value="5" <?php if(is_array($bed) && in_array('5' ,$bed)) echo "selected" ?>>5+ bedrooms</option>
                </select>																										<?php //var_dump($bth);?>
                <select name="bth[]" id="bth" style="width:200px; margin-left:1px;" multiple="multiple" size="3">
                    <option value="all" <?php if(!isset($bth[0]) || (is_array($bth) && in_array('all' ,$bth))) echo "selected" ?>>All bathroom types</option>
                    <option value="1" <?php if(is_array($bth) && in_array('1' ,$bth)) echo "selected" ?>>1 bathroom</option>
                    <option value="2" <?php if(is_array($bth) && in_array('2' ,$bth)) echo "selected" ?>>2 bathrooms</option>
                    <option value="3" <?php if(is_array($bth) && in_array('3' ,$bth)) echo "selected" ?>>3 bathrooms</option>
                    <option value="4" <?php if(is_array($bth) && in_array('4' ,$bth)) echo "selected" ?>>4 bathrooms</option>
                    <option value="5" <?php if(is_array($bth) && in_array('5' ,$bth)) echo "selected" ?>>5+ bathrooms</option>
                </select>																										<?php //var_dump($prk);?>
                <select name="prk[]" id="prk" style="width:200px; margin-left:1px;" multiple="multiple" size="3">
                    <option value="all" <?php if(!isset($prk[0]) || (is_array($prk) && in_array('all' ,$prk))) echo "selected" ?>>All car park types</option>
                    <option value="0" <?php if(is_array($prk) && in_array('0' ,$prk)) echo "selected" ?>>No car parking</option>
                    <option value="1" <?php if(is_array($prk) && in_array('1' ,$prk)) echo "selected" ?>>1 car park</option>
                    <option value="2" <?php if(is_array($prk) && in_array('2' ,$prk)) echo "selected" ?>>2 car parks</option>
                    <option value="3" <?php if(is_array($prk) && in_array('3' ,$prk)) echo "selected" ?>>3 car parks</option>
                    <option value="4" <?php if(is_array($prk) && in_array('4' ,$prk)) echo "selected" ?>>4 car parks</option>
                    <option value="5" <?php if(is_array($prk) && in_array('5' ,$prk)) echo "selected" ?>>5+ car parks</option>
                </select>
                <br>
                <span style="font-size:10px">Use the 'CTRL' key and left mouse button for multiple option selections</span>
            </div>
    </div>
    <!--Submit button -->
    <div id="search-submit" style="float: left; width: 10%; padding: 0 20px;">
		<input name="search"  type="text" value="search" id="btn-submit" title="Search Properties" onClick="propertySubmitSearch()" readonly="readonly" />
		<script language="javascript" type="text/javascript">
			function propertySubmitSearch() {
				var advSrch = "";
				if(document.getElementById('advanced_search').style.display=='') {
					//alert ($("#bed").val());
					//advSrch = '/'+document.getElementById('bed').value+'/'+document.getElementById('bth').value+'/'+document.getElementById('prk').value
					var beds = $("#bed").val(); if(beds===null) beds = 'all';
					var bths = $("#bth").val(); if(bths===null) bths = 'all';
					var prks = $("#prk").val(); if(prks===null) prks = 'all';
					//advSrch = '/'+$("#bed").val()+'/'+$("#bth").val()+'/'+$("#prk").val()
					advSrch = '/'+beds+'/'+bths+'/'+prks;
				}
				window.location.href='<?php echo $site_path; ?>property-search/'+document.getElementById('pt').value+'/'+document.getElementById('prl').value+'/'+document.getElementById('prh').value+'/'+document.getElementById('prs').value+'/'+document.getElementById('ft').value+advSrch;
			}
		</script>
    </div>
</div>
</div>