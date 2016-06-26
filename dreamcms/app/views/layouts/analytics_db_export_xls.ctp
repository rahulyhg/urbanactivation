<HTML xmlns:x="urn:schemas-microsoft-com:office:excel">
<HEAD>
<!-- Write Report-->
<style>
        body {font-size: 11px; color: #333; font-family: Droid Sans, arial, sans-serif;}
        table { padding: 0px; margin: 0; width:100%;}
		tr { padding: 0px; margin: 0;}
		td { padding: 0px; margin: 0;}
        h1 {font-size: 18px; padding-bottom: 10px;}
        h2 {font-size: 17px; padding: 0px; margin:0}
        h3 { font-size: 16px; text-transform:uppercase; margin:0; padding-bottom:5px;}
		h4 { font-size: 14px; color: green;}
</style>

<style>
  <!--table
  @page
     {
        mso-header-data:"";
        mso-page-orientation:landscape;    
     }
     br
     {mso-data-placement:same-cell;}
  -->
</style>
<!--[if gte mso 9]><xml>
   <x:ExcelWorkbook>
    <x:ExcelWorksheets>
     <x:ExcelWorksheet>
      <x:Name></x:Name>
      <x:WorksheetOptions>
       <x:FitToPage/>
       <x:Print>
       <x:FitWidth>1</x:FitWidth>
       <x:FitHeight>1000</x:FitHeight>
       <x:ValidPrinterInfo/>
       </x:Print> 
      </x:WorksheetOptions>
     </x:ExcelWorksheet>
    </x:ExcelWorksheets>
   </x:ExcelWorkbook>
  </xml><![endif]--> 
  
<?php
date_default_timezone_set('Australia/Victoria');
$timeReportGenerated = date('d/m/Y g:i:s A');
// Write Headings
echo "<table>";
echo "<tr><td style='background-color:#8DB4E2' colspan='5'>";	
echo "<font size='4'><b> Report Creation: </b>{$timeReportGenerated} (AEST)</font>";
echo "</td></tr>";
echo "<tr/>";
// Write Column Headigs
echo "<tr>";
echo "<td align='left' bgcolor='#BDD7EE' x:autofilterrange=\"A1:D1\">AgentId</td>";
echo "<td align='left' bgcolor='#BDD7EE' x:autofilterrange=\"A1:D1\">Name</td>";
echo "<td align='left' bgcolor='#BDD7EE' x:autofilterrange=\"A1:D1\">Date</td>";
echo "<td align='left' bgcolor='#BDD7EE' x:autofilterrange=\"A1:D1\">Property</td>";
echo "</tr>";	

$totalVisits = 0;
$rowCount = 3;
// write data
foreach($analytics as $analytic){   
   $visitedProperties = $analytic['PropertiesAnalytic']['visited_properties_ids'];
   $visitedProperties = trim($visitedProperties, ' ,');
   $iDs = explode(',', $visitedProperties);
   
   foreach($iDs as $pID){
    if( empty($pID) ){
        continue;
    }
    echo "<tr>";	
    echo "<td align='left' nowrap> {$analytic['PropertiesAnalytic']['agentId']} </td>";
    echo "<td align='left' nowrap> {$analytic['PropertiesAnalytic']['agent']} </td>";
    echo "<td align='left' nowrap>". date('d-M-Y', $analytic['PropertiesAnalytic']['loginTime']) . "</td>";    
    echo "<td align='left' nowrap>" . $uniqueProperties[$pID] . "</td>";
    echo "</tr>";
    
    ++$totalVisits;
    ++$rowCount;
       
   }    
}

echo "<tr/><tr/>";
echo "<tr><td style='background-color:#8DB4E2'>";	
echo "<font size='4'><b> Total Visits:  </b></font>";
echo "</td><td style='background-color:#8DB4E2'>=SUBTOTAL(3, A4:A$rowCount)</td></tr>";

echo "</table>";
 ?>