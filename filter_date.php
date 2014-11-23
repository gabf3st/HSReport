<?php
//    $location = Register::getProjLocation();
//    print_r($location);
?>
<div class="row text-right">
    <div id="filter-data" class="btn btn-primary panel">
        <i class="glyphicon glyphicon-cog"></i> Filter Data
    </div>
                    

                </div>
                <div id="filter" class="filter-wrapper row" style="display:none;">
                   <form name="myForm" id="myForm" method="POST">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">
                            Time Range
                        </label>

                        <div class="col-sm-8 input-daterange input-group" id="datepicker">
                            <input id="startDate" name="startDate" type="text" class="input-sm form-control" name="start" placeholder="Start Date" value = "<?php
                                    $dt1 = date('Y-m-d',strtotime("-7 days"));
                                    echo $dt1;
                                ?>"/>
                            <span class="input-group-addon">to</span>
                            <input id="endDate" name="endDate" type="text" class="input-sm form-control" name="end" placeholder="End Date" value="<?php
                                    $dt2 = date('Y-m-d');
                                    echo $dt2;
                                ?>"/>

                        </div>
                    </div>

                    <div id="location" class="form-group">

                        <label class="col-sm-2 control-label text-right">Location</label>
                        <div class="checkbox col-sm-10">
                        <?php

//                            foreach($location as $row){
//                            echo "<label class='col-sm-3'>";
//                            echo "<input name='location[]' type='checkbox' value='".$row->location."' checked>".$row->location."</label>";
//                            }
                        ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <button id="submit" class="btn btn-danger col-xs-offset-2 col-sm-3">Show Results</button>
                    </div>
                    </form>
                </div>


            
