<?php
$this->load->view('include/side_menu');
?>
<style>

</style>
<div class="panel box-shadow" style="border-radius: 1em;">
    <div class="panel-header">
        <h2 class="box-body"><?= $title; ?></h2>
    </div>
    <!-- /.box-header -->

    <?php $session = $this->session->userdata('Group');

    if ($session['id'] != '1' || $session['id'] != '40') : ?>
        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(243deg 70% 50%),hsl(243deg 70% 50%));" onclick="location.href = '<?= base_url('leavesapps/add'); ?>'">
                        <div class="inner" style="padding: 9px;">
                            <h3 class="font-nunito"><?= $leaveApp; ?></h3>
                            <p>Leaves Applications</p>
                        </div>
                        <div class="icon text-white-600">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <a href="<?= base_url('leavesapps/add'); ?>" class="small-box-footer" style="border-radius: 1em;background:transparent;padding:10px 0px">Create New <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-black rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(160deg 99% 40%),hsl(160deg 99% 40%));" onclick="location.href = '<?= base_url('leavesapps/'); ?>'">
                        <div class="inner">
                            <h3 class="font-nunito"><?= $leaveOPN; ?><sup style="font-size: 20px"></sup></h3>
                            <p>Waiting Approval</p>
                        </div>
                        <div class="icon text-white-600">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <a href="#" class="small-box-footer" style="border-radius: 1em;background:transparent;padding:10px 0px">View Details <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(37deg 81% 60%),hsl(37deg 81% 60%));" onclick="location.href = '<?= base_url('leavesapps/history'); ?>'">
                        <div class="inner">
                            <h3 class="font-nunito"><?= $leaveAPV; ?></h3>
                            <p>History</p>
                        </div>
                        <div class="icon text-white-600">
                            <i class="fa fa-history"></i>
                        </div>
                        <a href="#" class="small-box-footer" style="border-radius: 1em;background:transparent;padding:10px 0px">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(5deg 100% 64%),hsl(5deg 100% 64%));" onclick="location.href = '<?= base_url('leavesapps/cancel_reject'); ?>'">
                        <div class="inner">
                            <h3 class="font-nunito"><?= $leaveCNLREJ; ?></h3>
                            <p>Reject & Cancel</p>
                        </div>
                        <div class="icon text-white-600">
                            <i class="fa fa-flag"></i>
                        </div>
                        <a href="#" class="small-box-footer" style="border-radius: 1em;background:transparent;padding:10px 0px">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(210deg, 69%, 61%),hsl(210deg, 69%, 61%));" onclick="location.href = '<?= base_url('leavesapps/revision'); ?>'">
                        <div class="inner">
                            <h3 class="font-nunito"><?= $leaveREV; ?></h3>
                            <p>Revision</p>
                        </div>
                        <div class="icon text-white-600">
                            <i class="fa fa-pencil"></i>
                        </div>
                        <a href="#" class="small-box-footer" style="border-radius: 1em;background:transparent;padding:10px 0px">View Details <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
    <?php else : ?>
        <div class="box-body">
            <div class="container-fluid">
                <!-- Info boxes -->
                <!--get total view-->
                <div class="col-md-12 wrap-fpanel">
                    <div class="panel panel-default">
                        <div class="panel-heading with-border bg-blue">
                            <h3 class="panel-title "><b>Jumlah Karyawan Sentral Sistem Consultan</b></h3>
                        </div><!-- /.box-header -->
                        <!--Monthly Recap Report And Latest Order  -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Total</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'prismaemp/index' ?>">
                                                        <div><?php
                                                                echo "$jumlah";
                                                                ?>
                                                        </div>
                                                    </a>
                                                </font>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Tetap</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'permanentprisma/index' ?>">
                                                        <div><?php
                                                                echo "$jumlahtetap";

                                                                ?>
                                                        </div>
                                                    </a>
                                                </font>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak I</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'prismafirstcontract/index' ?>">
                                                        <div><?php
                                                                echo "$jumlahkontrak1";
                                                                ?>
                                                        </div>
                                                    </a>
                                                </font>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak II</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'prismasecondcontract/index' ?>">
                                                        <div><?php
                                                                echo "$jumlahkontrak2";
                                                                ?>
                                                        </div>
                                                    </a>
                                                </font>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak III</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'prismathirdcontract/index' ?>">
                                                        <div><?php
                                                                echo "$jumlahkontrak3";
                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                            </font>
                                        </div>
                                    </div>
                                </div>


                                <!-- /.col -->
                                <!-- / Monthly Recap Report -->
                            </div><!-- /.row -->
                        </div><!-- ./box-body -->
                        <!--End Monthly Recap Report And Latest Order  -->


                        <!-- / Monthly Recap Report And Latest Order and Total Revenue,Cost,Profit,Tax -->

                    </div>



                    <div class="panel panel-default">
                        <div class="panel-heading with-border bg-green">
                            <h3 class="panel-title "><b>Jumlah Karyawan Sentral Sistem Calibration</b></h3>
                        </div><!-- /.box-header -->
                        <!--Monthly Recap Report And Latest Order  -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Total</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'danestemp/index' ?>">
                                                        <div><?php
                                                                echo "$danest";
                                                                ?>
                                                        </div>
                                                    </a>
                                                </font>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Tetap</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'permanentdanest/index' ?>">
                                                        <div><?php
                                                                echo "$danesttetap";

                                                                ?>
                                                        </div>
                                                    </a>
                                                </font>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak I</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'danestfirstcontract/index' ?>">
                                                        <div><?php
                                                                echo "$danestkontrak1";
                                                                ?>
                                                        </div>
                                                    </a>
                                                </font>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak II</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'danestsecondcontract/index' ?>">
                                                        <div><?php
                                                                echo "$danestkontrak2";
                                                                ?>
                                                        </div>
                                                    </a>
                                                </font>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak III</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'danestthirdcontract/index' ?>">
                                                        <div><?php
                                                                echo "$danestkontrak3";
                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                            </font>
                                        </div>
                                    </div>
                                </div>


                                <!-- /.col -->
                                <!-- / Monthly Recap Report -->
                            </div><!-- /.row -->
                        </div><!-- ./box-body -->
                        <!--End Monthly Recap Report And Latest Order  -->


                        <!-- / Monthly Recap Report And Latest Order and Total Revenue,Cost,Profit,Tax -->

                    </div>

                    <!--  <div class="panel panel-default">
                        <div class="panel-heading with-border bg-green">
                            <h3 class="panel-title"><b>Jumlah Karyawan Danest</b></h3>                       
                        </div><!-- /.box-header -->
                    <!--Monthly Recap Report And Latest Order  -->
                    <!--<div class="panel-body">
                             <div class="row">
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="fa">                 
                                          <div class="alert alert-success">
                                          <span><i class="fa fa-users"></i></span>
                                            <font size="5">
                                            &nbsp
                                            <span>Total</span>
                                            </font>
                                            <font size="8">
                                            &nbsp
                                            <b><a href="<?php echo base_url('danestemp/index'); ?>"><?php echo "$danest"; ?></a></b>
                                            </font>
                                          </div>
                                     </div>	
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                <div class="fa">                 
                                          <div class="alert alert-success">
                                          <span><i class="fa fa-users"></i></span>
                                            <font size="5">
                                            &nbsp
                                            <span>Tetap</span>
                                            </font>
                                            <font size="8">
                                            &nbsp
                                            <b><a href="<?php echo base_url('permanentdanest/index'); ?>"><?php echo "$danesttetap"; ?></a></b>
                                            </font>
                                          </div>
                                     </div>	
                                
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6">								 
                                <div class="fa">                 
                                          <div class="alert alert-success">
                                          <span><i class="fa fa-users"></i></span>
                                            <font size="5">
                                            &nbsp
                                            <span>Kontrak I</span>
                                            </font>
                                            <font size="8">
                                            &nbsp
                                            <b><a href="<?php echo base_url('danestcontract/index'); ?>"><?php echo "$danestkontrak1"; ?></a></b>
                                            </font>
                                          </div>
                                     </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="fa">                 
                                          <div class="alert alert-success">
                                          <span><i class="fa fa-users"></i></span>
                                            <font size="5">
                                            &nbsp
                                            <span>Kontrak II</span>
                                            </font>
                                            <font size="8">
                                            &nbsp
                                            <b><a href="<?php echo base_url('danestcontract/index'); ?>"><?php echo "$danestkontrak2"; ?></a></b>
                                            </font>
                                          </div>
                                     </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">	 
                                    <div class="fa">                 
                                          <div class="alert alert-success">
                                          <span><i class="fa fa-users"></i></span>
                                            <font size="5">
                                            &nbsp
                                            <span>Kontrak III</span>
                                            </font>
                                            <font size="8">
                                            &nbsp
                                            <b><a href="<?php echo base_url('danestcontract/index'); ?>"><?php echo "$danestkontrak3"; ?></a></b>
                                            </font>
                                          </div>
                                     </div> 
                                </div> -->
                    <!-- /.col -->
                    <!-- / Monthly Recap Report -->
                    <!-- </div><!-- ./box-body -->
                    <!--End Monthly Recap Report And Latest Order  -->


                    <!-- / Monthly Recap Report And Latest Order and Total Revenue,Cost,Profit,Tax -->

                    <!-- </div>
                    
                   <!-- </div> -->



                    <div class="panel panel-default">
                        <div class="panel-heading with-border bg-yellow">
                            <h3 class="panel-title"><b>Persentase Karyawan Sentral Sistem Consulting Dan Calibration</b></h3>
                        </div><!-- /.box-header -->
                        <?php

                        $prismapres = round($jumlah / $semua * 100, 1);
                        $danestpres = round($danest / $semua * 100, 1);
                        $persen = '%';


                        ?>

                        <!--Monthly Recap Report And Latest Order  -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Total Karyawan</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'employeelist/index' ?>">
                                                        <div><?php
                                                                echo "$semua";

                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">% Karyawan Consulting</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <?php
                                                    echo $prismapres;
                                                    echo "&nbsp";
                                                    echo $persen;
                                                    ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">% Karyawan Calibration</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <?php
                                                    echo $danestpres;
                                                    echo "&nbsp";
                                                    echo $persen;
                                                    ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.col -->
                                <!-- / Monthly Recap Report -->
                            </div><!-- ./box-body -->
                            <!--End Monthly Recap Report And Latest Order  -->


                            <!-- / Monthly Recap Report And Latest Order and Total Revenue,Cost,Profit,Tax -->

                        </div>

                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading with-border bg-red">
                            <h3 class="panel-title"><b>Karyawan Sentral Consulting Akan Habis Kontrak ( < 3 Bulan )</b>
                            </h3>
                        </div><!-- /.box-header -->
                        <?php

                        $prismapres = round($jumlah / $semua * 100, 1);
                        $danestpres = round($danest / $semua * 100, 1);
                        $persen = '%';


                        ?>

                        <!--Monthly Recap Report And Latest Order  -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak I</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'prismalatestfirst/index' ?>">
                                                        <div><?php
                                                                echo "$prismalatest1";

                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak II</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'prismalatestsecond/index' ?>">
                                                        <div><?php
                                                                echo "$prismalatest2";

                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak III</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'prismalatestthird/index' ?>">
                                                        <div><?php
                                                                echo "$prismalatest3";

                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.col -->
                                <!-- / Monthly Recap Report -->
                            </div><!-- ./box-body -->
                            <!--End Monthly Recap Report And Latest Order  -->


                            <!-- / Monthly Recap Report And Latest Order and Total Revenue,Cost,Profit,Tax -->

                        </div>

                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading with-border bg-red">
                            <h3 class="panel-title"><b>Karyawan Sentral Calibration Akan Habis Kontrak ( < 3 Bulan )</b>
                            </h3>
                        </div><!-- /.box-header -->
                        <?php

                        $prismapres = round($jumlah / $semua * 100, 1);
                        $danestpres = round($danest / $semua * 100, 1);
                        $persen = '%';


                        ?>

                        <!--Monthly Recap Report And Latest Order  -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak I</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'danestlatestfirst/index' ?>">
                                                        <div><?php
                                                                echo "$danestlatest1";

                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak II</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'danestlatestsecond/index' ?>">
                                                        <div><?php
                                                                echo "$danestlatest2";

                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-number">Kontrak III</span>
                                            <span class="info-box-number">
                                                <font size="6">
                                                    <a href="<?php echo base_url() . 'danestlatestthird/index' ?>">
                                                        <div><?php
                                                                echo "$danestlatest3";

                                                                ?>
                                                        </div>
                                                    </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.col -->
                                <!-- / Monthly Recap Report -->
                            </div><!-- ./box-body -->
                            <!--End Monthly Recap Report And Latest Order  -->


                            <!-- / Monthly Recap Report And Latest Order and Total Revenue,Cost,Profit,Tax -->

                        </div>

                    </div>










                    <!--/ Baris Kedua-->



                </div>

            </div>
            <!-- /.box-body -->
        </div>
    <?php endif; ?>
    <!-- /.box -->
</div>

<?php $this->load->view('include/footer'); ?>
<script>
    $(document).ready(function() {
        $('.btn').click(function() {
            $('#spinner').modal('show');
        });
    });
</script>