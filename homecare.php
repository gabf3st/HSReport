<?php
    include "header.php"; 
?>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.html'?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <?php include_once "sidebar_top.html"; ?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
               
                <?php include "filter.php"; ?>
                <div class="section-wrapper">
                    <div id="myData"></div>
                </div>
            </div>
        </div>
    <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/bootstrap-datepicker.js"></script>

    <!-- Menu Toggle Script -->
    <script>
        // When the document is ready
        $(document).ready(function() {
            //Set current menu active
            $('#homecare').addClass('active');
            $('#tm_homecare').addClass('active');
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
            
            
            $('#location').hide();

            $("#submit").click(function() {
                $("#myForm").submit(function(e)
                {
                    $("#myData").html("<center><img src='images/ajax-loader.gif'/></center>");
                    var postData = $(this).serializeArray();
                    var formURL = $(this).attr("action");
                    $.ajax(
                    {
                        url : "homecare_data.php",
                        type: "POST",
                        data : postData,
                        success:function(data, textStatus, jqXHR) 
                        {
                            $('#myData').hide().html(data).fadeIn('slow');

                        },
                        error: function(jqXHR, textStatus, errorThrown) 
                        {
                            $("#myData").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
                        }
                    });
                    e.preventDefault();	//STOP default action
                    e.unbind();
                });
                $("#myForm").submit();

            });
            
//            set default data
            $("#submit").click();
            
        });
        

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        $("#filter-data").click(function(e) {
            $("#filter").toggle("100", "swing");
        });
        
        $("#filter-toggle").click(function(e) {
            $("#filter").toggle("100", "swing");
        });
        
        
        $("#export-data").click(function(e) {
            window.open('data:application/vnd.ms-excel,' + $('#myData').html());
            e.preventDefault();
        });
    </script>

</body>

</html>
