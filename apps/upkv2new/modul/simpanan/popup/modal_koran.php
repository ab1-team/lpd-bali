<?php session_start(); ?>

<div class="modal-sm">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 class="modal-title text-align-center fw-bold" id="LabelProposal">Tanggal Prop</h5>
        </div>
        <div class="modal-body">
			<div id="validation-form" class="form-horizontal form-label-left" method="post"
				  data-parsley-priority-enabled="false"
				  novalidate="novalidate">
				<fieldset>
					<div class="col-md-12 text-align-center">
						<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=P')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">
							<h1><?php echo $_SESSION['ids'];?></h1>
							<span class="fs-sm"><i class="fa fa-users"></i> simpanan</span>
						</button>
					</div>
				</fieldset>
			</div>
		</div>
	
    </div>
</div>