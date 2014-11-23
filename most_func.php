<?php 
    
    $startDate = $_POST['startDate'];

    if($_POST['startDate']==null){
        $startDate = date('Y-m-d', time()-7*24*60*60);   
    } else {
        $startDate = $_POST['startDate'];
    }

    if($_POST['endDate']==null){
        $endDate = date('Y-m-d', time());   
    } else {
        $endDate = $_POST['endDate'];   
    }

//    echo $startDate." to ".$endDate;

session_start();
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_AnalyticsService.php';

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

$client = new Google_Client();
$client->setAccessType('offline'); // default: offline
$client->setApplicationName('HomeService Report');
$client->setClientId('700584025290-ruuve2ik9kbd3nct9blr4738vooq72c4.apps.googleusercontent.com');
$client->setClientSecret('gwt2582AHth0wSyjV5thjkGr');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyBbVNEvLDg5CNNeQIk8fCdU3Elzx00_h3Y'); // API key

// $service implements the client interface, has to be set before auth call
$service = new Google_AnalyticsService($client);

if (isset($_GET['logout'])) { // logout: destroy token
    unset($_SESSION['token']);
	die('Logged out.');
}

if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
}

if (isset($_SESSION['token'])) { // extract token from session and configure client
    $token = $_SESSION['token'];
    $client->setAccessToken($token);
}

if (!$client->getAccessToken()) { // auth call to google
    $authUrl = $client->createAuthUrl();

    print "<div class='centered'><h4>To access an information <br>Please log in with authorized google account</h4>
            <a class='btn btn-lg btn-success' href='$authUrl'>Connect to Google</a></div>";
    die;
}

try {
//        $props = $service->management_webproperties->listManagementWebproperties("~all");
//    echo '<h1>Available Google Analytics projects</h1><ul>'."\n";
//    foreach($props['items'] as $item) printf('<li>%1$s</li>', $item['name']);
//    echo '</ul>';
    
    
    $projectId = '81601598';
    
    $_params[] = 'screenname';
    $_params[] = 'users';
    
    $from = $startDate;
    $to = $endDate;

    $metrics = 'ga:users';
    $dimensions = 'ga:screenname';
    $data = $service->data_ga->get('ga:'.$projectId, $from, $to, $metrics, array('dimensions' => $dimensions));

    $screenArray = array();
    $notIncludeScreen = array('HOME','LOG_OUT');
    $num = 0;
    $summationScreenUsage = 0;
    for($i=0; $i<count($data['rows']); $i++){
        if (strpos($data['rows'][$i][0],'sansiriservice') !== false || 
            in_array($data['rows'][$i][0], $notIncludeScreen)) {
           // do nothing   
        } else {
            $screenArray[$num][0] = $data['rows'][$i][0]; 
            $screenArray[$num][1] = $data['rows'][$i][1]; 
            $num++;
            $summationScreenUsage += $data['rows'][$i][1];
        }
    }


    function cmp($a, $b) {
        return $b[1]-$a[1];
    }
    
    function getPost($key) {
        if($key == 'startDate'){
            if (isset($_POST[$key]))
                return $_POST[$key];
            return date('Y-m-d', time()-7*24*60*60); // 7 days;
        } else if($key == 'endDate'){
            if (isset($_POST[$key]))
                return $_POST[$key];
            return date('Y-m-d'); // 7 days;
        }
        
    }
    
    usort($screenArray, "cmp");

//    print_r($screenArray);
    
} catch (Exception $e) {
    include "header.php";
//    echo "<div class='centered'>".$e->getCode(). " : ". $e->getDescription() ."</div>";
    echo "<div class='centered'><h4>To access an information <br>Please log in with AUTHORIZED Google Account</h4>
            <a class='btn btn-lg btn-success' href='".$client->createAuthUrl()."'>Connect to Google</a></div>";
    
    die('An error occured: ' . $e->getMessage()."\n");
}

include "header.php";

?>
<script type="text/javascript" src="js/jquery-1.11.0.js"></script>


<!--<script type="text/javascript" src="js/jquery-1.11.0.js"></script>-->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>


<div id="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.html'; ?>
        <!-- /#sidebar-wrapper -->
       <?php include_once "sidebar_top.html"; ?>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php include "filter_date.php"; ?>            
                <div class="section-wrapper">
<!--                    <div id="myData"></div>-->
                    <section class="row">

    <div class="table-title col-sm-12">
            <h3>The Most Frequency Function Used </h3>
            <?php 
//                $date = date_create_from_format('Y-m-d', $startDate);
                $sDate = date_create_from_format('Y-m-d', $startDate)->format('j F Y');
                $eDate = date_create_from_format('Y-m-d', $endDate)->format('j F Y');
                echo $sDate . " - " . $eDate;
            ?>
                               
    </div>

                    <div class="col-sm-12" style="padding-top:20px">
                        <!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#chart" role="tab" data-toggle="tab">View as Chart</a></li>
  <li><a href="#table" role="tab" data-toggle="tab">View as Table</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="chart">

        <div id="container" style="width:100%; max-width:900px;"></div>
<!--        <div id="container" style="min-width: 310px; height: 600px; max-width:700px; margin: 0 auto"></div>-->

  </div>
  <div class="tab-pane col-xs-12 col-sm-offset-3 col-sm-6" id="table">
    <div class="col-sm-12"> <br>
        <div class="dropdown">
        <a class="btn btn-default btn-sm"  data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-th-list"></i>  Export Table Data</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a href="#" onClick ="$('#reg-func').tableExport({type:'excel',escape:'false'});">Export to Excel</a></li>
        <li><a href="#" onClick ="$('#reg-func').tableExport({type:'pdf',escape:'false'});">Export to PDF</a></li>
        </ul>
    </div>
    </div>
    
    
     <div class="col-sm-12">
      <div class="table-responsive">
        <table id="reg-func" class="table">
            <thead>
                <tr>
                    <th class="col-sm-3">Function</th>
                    <th class="col-sm-1 text-center">Users</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0; $i<count($screenArray); $i++) { ?>
                <tr>
                    <td><?php echo $screenArray[$i][0]; ?></td>
                    <td class="text-center"><?php echo $screenArray[$i][1]; ?></td>
                </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
    </div>

    
  </div>
</div>
                    </div>

                </section>
                   
                </div>
                <!-- /#section wrapper -->        
            </div>
             <!-- /#container-fluid -->
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    
    
    <script>
        $(function() {
            $("#location").hide();
//           alert( "ready!" );
            $('#most_func').addClass('active');
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
            
            <?php echo "$('#startDate').val('".$startDate."');"; ?>
            <?php echo "$('#endDate').val('".$endDate."');"; ?>
            
            $('#container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text : ''
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            },
                            connectorColor: 'silver'
                        }
                    }
                },
                                series: [{
                                type: 'pie',
                                name: 'User used',
                                data: [

                                <?php 
                                for($i=0; $i<count($screenArray); $i++){
                                    $percent = round($screenArray[$i][1]/$summationScreenUsage*100);
                                    echo " [' ".$screenArray[$i][0]." ', ".$screenArray[$i][1]." ] "; 

                                    if($i<count($screenArray)-1) echo ",";
                                    }
                                ?>
                    ]
                }]
            });
        });

        
        $("#filter-data").click(function(e) {
            $("#filter").toggle("100", "swing");
        });
        
      
        
        $('#submit').click(function(){
            $('form[name=myForm]').setAttrib('action','most_func.php');
            $('form[name=myForm]').submit();
        });    
    </script>
    
<!--    <script src="js/modules/exporting.js"></script>-->
                        
	<script type="text/javascript" src="js/htmltable_export/tableExport.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jquery.base64.js"></script>
	<script type="text/javascript" src="js/htmltable_export/html2canvas.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="js/htmltable_export/jspdf/libs/base64.js"></script>

    
	</body>
</html>
