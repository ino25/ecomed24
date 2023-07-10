
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
                <?php  if ($this->ion_auth->in_group(array('Receptionist','Doctor','adminmedecin'))) { ?>
				 <span class="pull-right"> <a href="appointment/addNewView" class='btn btn-primary'> <i class="fa fa-plus-circle"></i> <?php echo lang('add_appointment'); ?> </a></span>
                 <?php } ?>
                                 <h2><?php echo lang('calendar'); ?> des <span style="text-transform:lowercase !important;"><?php echo lang('appointment'); ?></span> </h2>
            </header>
            <div class="panel-body">
                <aside>
                    <section class="panel">
                        <div class="panel-body">
                            <div id="calendar" class="has-toolbar calendar_view"></div>
                        </div>
                    </section>
                </aside>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<div class="modal fade" tabindex="-1" role="dialog" id="cmodal">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id='medical_history'>
                <div class="col-md-12">

                </div> 
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>