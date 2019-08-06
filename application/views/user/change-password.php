        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
            <!-- FLASH ALERT -->
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success fade show col-lg-6" role="alert">
                    <strong>Success!</strong> <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php elseif ($this->session->flashdata('failed')) : ?>
                <div class="alert alert-warning fade show col-lg-6" role="alert">
                    <strong> Failed! </strong><?= $this->session->flashdata('failed'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <div aria-hidden="true">&times;</div>
                    </button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-6">
                    <form action="<?= base_url('user/changepassword'); ?>" method="post">
                        <div class="form-group">
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password">
                            <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="new_password1" name="new_password1" placeholder="New Password">
                            <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Confirm Password">
                            <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->