<?php 
    require "model/DatabasePDO.php"; 
    require "model/Juristic.php"; 

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $location = $_POST['location'];
//    echo $startDate." to ".$endDate;
//    
//    for($i=0; $i<count($location); $i++){
//        echo $location[$i];   
//    }
    
    $spDayAccess = Juristic::spGetDayAccess($startDate,$endDate); 

//    print_r($spDayAccess);
    $spAnnounce = Juristic::spGetAnnounce($startDate,$endDate);
    $spPackage = Juristic::spGetPackage($startDate,$endDate);
    $spPhoneDir = Juristic::spGetPhoneDir($startDate,$endDate);
    $spMsg = Juristic::spGetComMsg($startDate,$endDate);
//    $spAnnounceDet = Juristic::spGetAnnounceDB("Via Botani");
//    print_r($spAnnounceDet);
    $announceDetailProj = "Via Botani";
    $spAnnounceDetail = Juristic::spGetAnnounceDetail($announceDetailProj);
//    print_r($spAnnounceDetail);

?>
               
               
<?php $proj_name =  $spAnnounce[0]->proj_name;  ?>
<script>
//    $('#myModal').modal()
</script>
    <section class="row">
                    <div class="col-sm-12">
<div class="row">
    <div class="table-title col-sm-12"><h3>Total Day Access</h3></div>
    <div class="dropdown col-sm-12">
        <a class="btn btn-default btn-sm"  data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-th-list"></i>  Export Table Data</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a href="#" onClick ="$('#jr-day-access').tableExport({type:'excel',escape:'false'});">Export to Excel</a></li>
        <li><a href="#" onClick ="$('#jr-day-access').tableExport({type:'pdf',escape:'false'});">Export to PDF</a></li>
        </ul>
    </div>
</div>
                           <div class="table-responsive">
                            <table id="jr-day-access" class="table table-bordered table-striped ">
                                <thead>
                                    <tr >
                                        <th class="col-sm-3">Project</th>
                                        <th class="col-sm-2">Location</th>
                                        <th class="col-sm-1">Access (Days)</th>
                                        <th class="col-sm-1">Mailbox (Days)</th>
                                        <th class="col-sm-1">Total Header</th>
                                        <th class="col-sm-1">Total Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
//                                        $spDayAccess = Juristic::spGetTotalDaysAccess();
//                                        print_r($spDayAccess);
                                        for($i=0; $i<count($spDayAccess); $i++){
                                            $myLocation = $spDayAccess[$i]->location;
                                            if (in_array($myLocation, $location)) {
                                                echo "<tr>";
                                                echo "<td class='text-left'>".$spDayAccess[$i]->proj_name."</td>";
                                                echo "<td class='text-center'>".$spDayAccess[$i]->location."</td>";
                                                echo "<td class='text-center'>".$spDayAccess[$i]->days."</td>";
                                                echo "<td class='text-center'>".$spPackage[$i]->dd."</td>";
                                                echo "<td class='text-center'>".$spPhoneDir[$i]->TotalHeader."</td>";
                                                echo "<td class='text-center'>".$spPhoneDir[$i]->TotalNumber."</td>";
                                                echo "</tr>";
                                            }
                                            
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </section>
                
                <section class="row">
                    <div class="col-sm-12">
<div class="row">
    <div class="table-title col-sm-12"><h3>Announce</h3></div>
    <div class="dropdown col-sm-12">
        <a class="btn btn-default btn-sm"  data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-th-list"></i>  Export Table Data</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a href="#" onClick ="$('#jr-announce').tableExport({type:'excel',escape:'false'});">Export to Excel</a></li>
        <li><a href="#" onClick ="$('#jr-announce').tableExport({type:'pdf',escape:'false'});">Export to PDF</a></li>
        </ul>
    </div>
</div>
                        
                        <div class="table-responsive">
                            <table id="jr-announce" class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th class="col-sm-4">Project</th>
                                        <th class="col-sm-2">Location</th>
                                        <th class="col-sm-2">Created Announce</th>
                                        <th class="col-sm-2">Available Announce</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                               
                                 
                                  <?php 
                                        for($i=0; $i<count($spAnnounce); $i++){
                                            $myLocation = $spAnnounce[$i]->location;
                                            if (in_array($myLocation, $location)) {
                                                echo "<tr>";
                                                
                                                echo "<td id='proj-".$i."'>".$spAnnounce[$i]->proj_name."</td>";
                                                echo "<td class='text-center'>".$spAnnounce[$i]->location."</td>";
                                                echo "<td class='text-center'>".$spAnnounce[$i]->announce_time."</td>";
                                                echo "<td class='text-center'>".$spMsg[$i]->tt."</td>";
                                                echo "<td>
<form action='announce_detail.php' method='POST' target='_blank'>
<input type='hidden' name='proj_name' value='".$spAnnounce[$i]->proj_name."'>
<button id='btn-proj-".$i."' class='btn btn-primary center-block' type='submit'>More Details</button></form></td>";
                                                echo "</tr>";  
                                            }
                                        }

                                    ?>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                
            	<script type="text/javascript" src="js/htmltable_export/tableExport.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jquery.base64.js"></script>
	<script type="text/javascript" src="js/htmltable_export/html2canvas.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/libs/base64.js"></script>