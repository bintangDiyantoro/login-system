        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?>: <?= $role['role']; ?></h1>

            <div class="row">
                <div class="col-lg-6">

                    <!-- ALERT -->

                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success fade show" role="alert">
                            <strong>Success!</strong> <?= $this->session->flashdata('success'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php elseif ($this->session->flashdata('changed')) : ?>
                        <div class="alert alert-success fade show" role="alert">
                            <?= $this->session->flashdata('changed'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <!-- END OF ALERT -->


                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;

                            foreach ($menu as $m) :
                                ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    </th>
                                    <td><?= $m['menu']; ?></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input position-static" type="checkbox" <?= check_access($role['id'], $m['id']); ?> data-role="<?= $role['id'] ?>" data-menu="<?= $m['id'] ?>">
                                        </div>
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