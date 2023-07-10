<div class="modal fade" id="myModalfacture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_facture_pro'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="finance/checkDepot" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control money" name="deposited" id="deposited" onkeyup="recuperationDepot(event)" value='' placeholder="">
                    </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="redirect" value='finance/payment'>
                    <div class="form-group cashsubmit payment  right-six col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>

    $(document).ready(function () {
  });
 function facturebutton(payment) {
        var id = "#depot" + payment;

        $('#myModalfacture').trigger("reset");
        $('#myModalfacture').modal('show');
        var amount_received = $(id).attr('data-amount_received');
        var gross_total = $(id).attr('data-gross_total');
        var reste = gross_total - amount_received;
        $('#myModalfacture').find('[id="reste"]').html(reste).end();
        $('#myModalfacture').find('[id="patient"]').html(patient).end();
        var option1 = new Option(payment, payment, true, true);
        $('#myModalfacture').find('[name="paymentid"]').append(option1).trigger('change');
        }

    

</script>