<?php 
    require "model/DatabasePDO.php"; 
    require "model/Register.php"; 
    require "model/Homecare.php"; 
    require "model/Juristic.php"; 

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $location = $_POST['location'];
//    echo $startDate." to ".$endDate;
//    for($i=0; $i<count($location); $i++){
//        echo $location[$i];   
//    }
?>
                       <section class="row">
                        <div class="col-sm-12">
<div class="row">
    <div class="table-title col-sm-12"><h3>Request Homecare</h3></div>
    <div class="dropdown col-sm-12">
        <a class="btn btn-default btn-sm"  data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-th-list"></i>  Export Table Data</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a href="#" onClick ="$('#hc-sum-req').tableExport({type:'excel',escape:'false'});">Export to Excel</a></li>
        <li><a href="#" onClick ="$('#hc-sum-req').tableExport({type:'pdf',escape:'false'});">Export to PDF</a></li>
        </ul>
    </div>
</div>
                          <div class="table-responsive">  
                            <table id="hc-sum-req" class="table table-bordered table-striped ">
                                <thead>
                                    <tr >
                                        <th class="col-sm-4">Project</th>
                                        <th class="col-sm-1">Total Request</th>
                                        <th class="col-sm-1">Waiting</th>
                                        <th class="col-sm-1">Accept</th>
                                        <th class="col-sm-1">Review</th>
                                        <th class="col-sm-1">Success</th>
                                        <th class="col-sm-1">Cancel</th>
                                        <th class="col-sm-1">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php 
//                                        $homecare = new Homecare($startDate, $endDate);
                                        
//                                        echo $homecare->getStartDate();
                                        $request = Homecare::homecareRequest($startDate, $endDate);
//                                        var_dump($request);

                                        foreach ($request as $row) {
                                            echo "<tr>";
                                            echo "<td class='text-left'>".$row->Project."</td>";
                                            echo "<td class='text-center'>".$row->total."</td>";
                                            echo "<td class='text-center'>".$row->waiting."</td>";
                                            echo "<td class='text-center'>".$row->accept."</td>";
                                            echo "<td class='text-center'>".$row->review."</td>";
                                            echo "<td class='text-center'>".$row->success."</td>";
                                            echo "<td class='text-center'>".$row->cancel."</td>";
                                            echo "<td class='center-block'>
<form action='homecare_detail.php' method='POST' target='_blank'>
<input type='hidden' name='proj_name' value='".$row->Project."'>
<input type='hidden' name='start_date' value='".$startDate."'>
<input type='hidden' name='end_date' value='".$endDate."'>
<button class='btn btn-primary center-block' type='submit'>More Details</button></form></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                           </div>
                        </div>
</section>
                        <section class="row">

                        <div class="col-sm-6">
<div class="row">
    <div class="table-title col-sm-12"><h3>Homecare Type</h3></div>
    <div class="dropdown col-sm-12">
        <a class="btn btn-default btn-sm"  data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-th-list"></i>  Export Table Data</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a href="#" onClick ="$('#hc-type').tableExport({type:'excel',escape:'false'});">Export to Excel</a></li>
        <li><a href="#" onClick ="$('#hc-type').tableExport({type:'pdf',escape:'false'});">Export to PDF</a></li>
        </ul>
    </div>
</div>
                         <div class="table-responsive">
                            <table id="hc-type" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-sm-3">Type</th>
                                        <th class="col-sm-2">Total Request</th>
                                    </tr>
                                </thead>
                                <tbody>

                                      <?php 
                                            $type = Homecare::homecareType($startDate, $endDate);

                                            foreach ($type as $row) {
                                                echo "<tr>";
                                                echo "<td>".$row->homecare_type_title."</td>";
                                                echo "<td class='text-center'>".$row->total."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </section>

<!--                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>-->

                    
                    
	<script type="text/javascript" src="js/htmltable_export/tableExport.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jquery.base64.js"></script>
	<script type="text/javascript" src="js/htmltable_export/html2canvas.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/libs/base64.js"></script>
                    