        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

            <div class="row">
                <div class="col-lg-6">

                    <!-- ALERT -->
                    <?= form_error('menu', '<div class="alert alert-danger fade show" role="alert"><strong>Failed! </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>

                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success fade show" role="alert">
                            <strong>Success!</strong> <?= $this->session->flashdata('success'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <!-- END OF ALERT -->

                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add new menu</a>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($menu as $m) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    </th>
                                    <td><?= $m['menu']; ?></td>
                                    <td>
                                        <a class="badge badge-warning" href="">edit</a> |
                                        <a class="badge badge-danger" href="">delete</a>
                                    </td>
                                </tr>
                                <?php $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Modal -->
        <div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('menu'); ?>" method="post">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <input type="text" name="menu" id="menu" class="form-control" placeholder="Menu title">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>