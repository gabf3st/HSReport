<?php include "header.php"; ?>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.html'; ?>
        <!-- /#sidebar-wrapper -->

       <?php include_once "sidebar_top.html"; ?>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php include "filter.php"; ?>            
                <div class="section-wrapper">
                    <div id="myData"></div>
                </div>
                <!-- /#section wrapper -->        
            </div>
             <!-- /#container-fluid -->
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
            $('#juristic').addClass('active');
            $('#tm_juristic').addClass('active');
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
            
            $("#submit").click(function() {
                $("#myForm").submit(function(e)
                {
                    $("#myData").html("<center><img src='images/ajax-loader.gif'/></center>");
                    var postData = $(this).serializeArray();
                    var formURL = $(this).attr("action");
                    $.ajax(
                    {
                        url : "juristic_data.php" ,
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
        
        $("#filter-toggle").click(function(e) {
            e.preventDefault();
            $("#filter").toggleClass("toggled");
        });

        $("#filter-data").click(function(e) {
            $("#filter").toggle("100", "swing");
        });
    </script>

</body>

</html>
