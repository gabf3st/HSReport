<?php 
    require "model/DatabasePDO.php"; 
    require "model/Register.php"; 

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $location = $_POST['location'];

    $spCountuser = Register::spCountuser();
    $newRegister = Register::newRegister($startDate,$endDate);
    $activeUser = Register::spGetactiveUser();
    $allProjLocation = Register::getProjLocation();

    $month = Register::spGetMonthlyRegister();
    
    $sumUserData = array();
    for($i=0; $i<count($spCountuser); $i++){
            
        $sumUserData[$i]['project'] = $spCountuser[$i]->project;
        $sumUserData[$i]['location'] = $spCountuser[$i]->location;
        $sumUserData[$i]['total_unit'] = $spCountuser[$i]->total_unit;
        $sumUserData[$i]['totaluser'] = $spCountuser[$i]->totaluser;
        $sumUserData[$i]['percentRegis'] = round($spCountuser[$i]->totaluser/$spCountuser[$i]->total_unit*100);
        $sumUserData[$i]['activeuser'] = $activeUser[$i]->activeuser;
        $sumUserData[$i]['percentActive'] = round($activeUser[$i]->activeuser/$spCountuser[$i]->totaluser*100);
       
        $sumUserData[$i]['newRegister'] = 0;
        foreach($newRegister as $nr) {
            if($nr->proj == $spCountuser[$i]->id) {
                $sumUserData[$i]['newRegisterId'] = $nr->proj;
                $sumUserData[$i]['newRegister']+= $nr->regis_total;
            }
        }
    }

    $summationActiveUser = 0;
    $summationRegister = 0;
    $summationNewRegis = 0;

    $color = array("#1A4F63","#068F86","#6FD57F","#FCB03C","#FC5B3F","#71D3D0","#F86767",
                  "#00AD8E","#F0D770","#4589BD","#A3449A","#588C9E","#D96459","#8C4646","#C1B7B5","#686B70");

?>

<section class="row">
    <div class="col-sm-12">
     <h3>Summary</h3>
        <div class="col-sm-5">
            <div id="canvas-holder">
                <canvas id="chart-area" width="300px" height="200px"/>
            </div>

       </div>
       <div class="col-xs-5 col-sm-3 text-left">
            <h4 class="hsum">Active User</h4>
            <h4 class="bsum activeUser"><span id="activeUser"></span> users</h4>

            <h4 class="hsum">Inactive User</h4>
            <h4 class="bsum inactiveUser"><span id="inactiveUser"></span> users</h4>

            <h4 class="hsum">Total Register</h4>
            <h4 class="bsum totalRegis"><span id="totalRegis"></span> users</h4>

            <h4 class="totalNewUser">New <span id="totalNewUser"></span> users</h4>
        </div>
           

      <div class="col-xs-7 col-sm-4">
           <?php 
                for($i=0; $i<count($allProjLocation); $i++){
            ?>
            <div class="row userZone">
                <div class="col-xs-10 col-sm-10 text-right">
                    <span class="hsum userZone-title"><?php echo $allProjLocation[$i]->location; ?></span>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <span class="userZone-num"><?php echo $allProjLocation[$i]->num_of_proj; ?></span>
                </div>
            </div>
           <?php } ?>
        </div>

       
       
    </div>
</section>
               
<section class="row">
    <div class="col-sm-10">
        <h3>Monthly Register</h3>
        <canvas id="monthly-chart" width="80%" height="50%" max-width="800px"/>
    </div>
</section>
                
<section class="row">
   <div class="col-sm-12">
       <div class="row">
            <div class="table-title col-sm-12"><h3>Summary User Zone</h3></div>
            <div class="dropdown col-sm-12">
                <a class="btn btn-default btn-sm"  data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-th-list"></i>  Export Table Data</a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                <li><a href="#" onClick ="$('#reg-user-zone').tableExport({type:'excel',escape:'false'});">Export to Excel</a></li>
                <li><a href="#" onClick ="$('#reg-user-zone').tableExport({type:'pdf',escape:'false'});">Export to PDF</a></li>
                </ul>
            </div>
        </div>
                           <div class="table-responsive">
                            <table id="reg-user-zone" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-sm-3">Project</th>
                                        <th>Location</th>
                                        <th>Total Unit</th>
                                        <th>Register</th>
                                        <th>%Register (Register/Total)</th>
                                        <th>Active</th>
                                        <th>%Active (Active/Register)</th>
<!--                                        <th>New Register ID</th>-->
                                        <th>New Register</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 

                                    $sumTotalUnit = 0;
                                    $sumTotalRegister = 0;
                                    $sumTotalActive = 0;
                                    $sumNewRegister = 0;
                                    $numberOfProjectInLocation = array();

                                    for($i=0; $i<count($spCountuser); $i++){
                                        $myLocation = $sumUserData[$i]['location'];
                                        $summationActiveUser += $sumUserData[$i]['activeuser'];
                                        $summationRegister += $sumUserData[$i]['totaluser'];
                                        
                                        if (in_array($myLocation, $location)) {
                                            
                                            $sumTotalUnit += $sumUserData[$i]['total_unit'];
                                            $sumTotalRegister += $sumUserData[$i]['totaluser'];
                                            $sumTotalActive += $sumUserData[$i]['activeuser'];
                                            $sumNewRegister += $sumUserData[$i]['newRegister'];
                                                
                                            echo "<tr>";          
                                            echo "<td>".$sumUserData[$i]['project']."</td>";
                                            echo "<td class='text-center'>".$sumUserData[$i]['location']."</td>";
                                            echo "<td class='text-center'>".$sumUserData[$i]['total_unit']."</td>";
                                            echo "<td class='text-center'>".$sumUserData[$i]['totaluser']."</td>";
                                            echo "<td class='text-center'>".$sumUserData[$i]['percentRegis']."%</td>";
                                            echo "<td class='text-center'>".$sumUserData[$i]['activeuser']."</td>";
                                            echo "<td class='text-center'>".$sumUserData[$i]['percentActive']."%</td>";
//                                            echo "<td class='text-center'>".$sumUserData[$i]['newRegisterId']."</td>";
                                            echo "<td class='text-center'>".$sumUserData[$i]['newRegister']."</td>";
                                            echo "</tr>";

                                        }
                                    }
                                        echo "<tr>";
                                        echo "<td><strong>Total</strong></td>";
                                        echo "<td></td>";
                                        echo "<td  class='text-center'><strong>".$sumTotalUnit."</strong></td>";
                                        echo "<td  class='text-center'><strong>".$sumTotalRegister."</strong></td>";
                                        echo "<td  class='text-center'><strong>".round($sumTotalRegister/$sumTotalUnit*100)."%</strong></td>";
                                        echo "<td  class='text-center'><strong>".$sumTotalActive."</strong></td>";
                                        echo "<td  class='text-center'><strong>".round($sumTotalActive/$sumTotalRegister*100)."%</strong></td>";
                                        echo "<td  class='text-center'><strong>".$sumNewRegister."</strong></td>";
                                        echo "</tr>";
                                        $summationNewRegis += $sumNewRegister;
                                ?>
                                </tbody>
                            </table>
                        </div>
                     </div>
                       
                    </section>
                    
    <script src="js/Chart.min.js"></script>
    <script src="js/jquery-1.11.0.js"></script>
    
    <script type="text/javascript" src="js/htmltable_export/tableExport.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jquery.base64.js"></script>
	<script type="text/javascript" src="js/htmltable_export/html2canvas.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/libs/base64.js"></script>
    
   <script>
        // When the document is ready
        $(document).ready(function() {
            
            $( "#totalRegis" ).text( <?php echo $summationRegister; ?> );
            $( "#totalNewUser" ).text( <?php echo $summationNewRegis; ?> );
            $( "#activeUser" ).text( <?php echo $summationActiveUser; ?> );
            $( "#inactiveUser" ).text( <?php echo ($summationRegister-$summationActiveUser); ?>);

                var ctx = document.getElementById("chart-area").getContext("2d");
				window.myDoughnut = new Chart(ctx).Doughnut(sumUser, {
                        responsive : true
                });
                
                var ctx2 = document.getElementById("monthly-chart").getContext("2d");
                window.myBar = new Chart(ctx2).Bar(monthlyRegisterData, {
                        responsive : true,
                        barStrokeWidth : 1,
                           //Number - Spacing between each of the X value sets
                        barValueSpacing : 5,
                        //Number - Spacing between data sets within X values
                        barDatasetSpacing : 1
                });
            });
        

        
        var sumUser = [
            {
                value: <?php echo $summationActiveUser; ?>,
                color:"#F7464A",
				highlight: "#FF5A5E",
				label: "Active"
            },
            {
                value: <?php echo $summationRegister-$summationActiveUser; ?>,
                color: "#949FB1",
				highlight: "#A8B3C5",
				label: "Inactive"
            }
            
        ];
            
        var monthlyRegisterData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"
                        ,"August","September","October","November","December"],
                datasets: [
                    {
                        label: "My First dataset",
                        fillColor : "rgba(151,187,205,0.5)",
                        strokeColor : "rgba(151,187,205,0.8)",
                        highlightFill : "rgba(151,187,205,0.75)",
                        highlightStroke : "rgba(151,187,205,1)",
                        data: 
                            <?php
                            $month = Register::spGetMonthlyRegister();
                            echo "[";
                                echo $month[0]->month1 . ","; 
                                echo $month[0]->month2 . ",";
                                echo $month[0]->month3 . ",";
                                echo $month[0]->month4 . ",";
                                echo $month[0]->month5 . ",";
                                echo $month[0]->month6 . ",";
                                echo $month[0]->month7 . ",";
                                echo $month[0]->month8 . ",";
                                echo $month[0]->month9 . ",";
                                echo $month[0]->month10 . ",";
                                echo $month[0]->month11. ",";
                                echo $month[0]->month12;
                            echo "]";
                        ?>
                        
                    }
                ]
            };
           
        
            
	</script>