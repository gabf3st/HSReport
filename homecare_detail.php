<?php 
    require "model/DatabasePDO.php"; 
    require "model/Homecare.php"; 

    $proj_name = $_POST['proj_name'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $status = array('W','A','R','S','C');

//    echo trim("fuck shit ");
//    echo "<br>".$proj_name."<br>";
    $startDate = trim($startDate);
    $endDate = trim($endDate);
//    echo $startDate.$endDate."<br>";

//    print_r($hcDetail);
//    echo $proj_name;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home Service</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
            <div class="container-fluid">
                    <div class="announceTitle text-danger">
                       <div class="row">
                        
                           <div class="col-sm-8"><h2><div class="announceText" >Homecare Request of</div>
                            <?php echo $proj_name; ?></h2></div>
                            
                            <div class="col-sm-4 text-right">
<!--                                <a class="btn btn-default" href="javascript:window.print()">Print</a>-->
                            </div>
                        </div>
                    </div>
                    <?php for($j=0; $j<count($status); $j++){ 
                        $hcDetail = Homecare::homecareRequestDetail($proj_name,$status[$j],$startDate,$endDate);
                        
                    ?>
                    
                    <div class="row">
                        <div class="announceDetail ">
                           <?php 
                                $status_text = "";
                                if($status[$j] == "W") {
                                    $status_text = "Waiting";
                                    $tableColor = "active";
                                } else if ($status[$j] == 'A') {
                                    $status_text = "Accept";
                                    $tableColor = "info";
                                } else if ($status[$j] == 'R') {
                                    $status_text = "Review";
                                    $tableColor = "warning";
                                } else if ($status[$j] == 'S') {
                                    $status_text = "Success";
                                    $tableColor = "success";
                                } else if ($status[$j] == 'C') {
                                    $status_text = "Cancel";
                                    $tableColor = "danger";
                                }
                            ?>
                            <h3><?php echo $status_text; ?></h3>
                            <div class="col-sm-12">
                            <?php   if($hcDetail !=null) { ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="<?php echo $tableColor; ?>">
                                        <th class="col-sm-2">Date time</th>
                                        <th class="col-sm-1">Unit Code</th>
                                        <th class="col-sm-7">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                        
                                        for($i=0; $i<count($hcDetail); $i++){
                                                echo "<tr>";
                                                echo "<td class='text-left'>".$hcDetail[$i]->datetime."</td>";
                                                echo "<td class='text-center'>".$hcDetail[$i]->unit_code."</td>";
                                                echo "<td class='text-left'>".$hcDetail[$i]->detail."</td>";
                                                echo "</tr>";
                                        }
                                ?>
                                </tbody>
                            </table>
                            <?php   } else {
                                        echo "<div class='alert text-center' role='alert'><strong>No data</strong></div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>    
                    <?php 
                        }
                    ?>          
            </div>
            <div style="padding-bottom:50px;"></div>
            
            
            
  
</body>
</html>