<?php 
    require "model/DatabasePDO.php"; 
    require "model/Juristic.php"; 

    $proj_name = $_POST['proj_name'];
    $spAnnounceDetail = Juristic::spGetAnnounceDetail($proj_name);
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
                    <div class="row">
                        <div class="announceTitle text-danger">
                            <h2><div class="announceText">Announce of</div>
                            <?php echo $proj_name; ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="announceDetail ">
                             <?php
                                for($i=0; $i<count($spAnnounceDetail); $i++){
                                    
                                    if($spAnnounceDetail[$i]->is_shown == 1){
                                        echo "<h4 class='text-success'>". $spAnnounceDetail[$i]->title ."  ";
                                        echo "<span class='label label-success'>Opened</span>";   
                                    } else {
                                        echo "<h4 class='text-danger'>". $spAnnounceDetail[$i]->title ."  ";
                                        echo "<span class='label label-danger'>Closed</span>";   
                                    }
                                    echo "</h4>";
                                    echo "<i class='glyphicon glyphicon-calendar'></i> ";
                                    
                                    if($spAnnounceDetail[$i]->start_date != null && 
                                       $spAnnounceDetail[$i]->end_date != null) {
                                        $sDate = date_create($spAnnounceDetail[$i]->start_date);
                                        echo date_format($sDate,"d/m/Y");

                                        echo " - ";
                                        $eDate = date_create($spAnnounceDetail[$i]->end_date);
                                        echo date_format($eDate,"d/m/Y");
                                    } else {
                                        echo "Not Specified";   
                                    }
                                    
                                    echo "<p>". $spAnnounceDetail[$i]->detail ."</p>";
                                    if($i<count($spAnnounceDetail)-1) echo "<hr>";
                                }
                            ?> 
                        </div>
                    </div>              
            </div>
  
</body>
</html>