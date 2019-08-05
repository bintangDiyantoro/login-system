<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-10">

            <!-- ALERT -->
            <?= form_error('title', '<div class="alert alert-danger fade show" role="alert"><strong>Failed! </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <?= form_error('url', '<div class="alert alert-danger fade show" role="alert"><strong>Failed! </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <?= form_error('icon', '<div class="alert alert-danger fade show" role="alert"><strong>Failed! </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success fade show" role="alert">
                    <strong>Success!</strong> <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <!-- END OF ALERT -->

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubmenuModal">Add new submenu</a>
            <table class="table table-hover">
                <thead class="text-center">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Url</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($submenu as $sm) :
                        $active = ($sm['is_active'] == 0) ? 'not active' : 'active'; ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            </th>
                            <td><?= $sm['title']; ?></td>
                            <td class="text-center"><?= $sm['menu']; ?></td>
                            <td class="text-center"><?= $sm['url']; ?></td>
                            <td class="text-center"><?= $sm['icon']; ?></td>
                            <td class="text-center"><?= $active; ?></td>
                            <td class="text-center">
                                <a class="badge badge-warning" href="">edit</a>
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
<div class="modal fade" id="newSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubmenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubmenuModalLabel">Add New Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    <label for="title">Title</label>
                    <div class="input-group mb-3">
                        <input type="text" name="title" id="title" class="form-control" placeholder="New Submenu">
                    </div>
                    <label for="menu">Menu</label>
                    <div class="form-group mb-3">
                        <select class="form-control" id="menu" name="menu">
                            <!-- <option>Select menu</option> -->
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label for="url">Url</label>
                    <div class="input-group mb-3">
                        <input type="text" name="url" id="url" class="form-control" placeholder="example/example">
                    </div>
                    <label for="icon">Icon</label>
                    <div class="input-group mb-3">
                        <input type="text" name="icon" id="icon" class="form-control" placeholder="icon html class">
                    </div>
                    <label for="status">status</label>
                    <!-- <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="status" id="status" type="checkbox" value="1">
                            <label class="form-check-label" for="status">Active?</label>
                        </div>
                    </div> -->
                    <div class="form-group mb-3">
                        <label>
                            <input type="radio" name="status" value="1" /> Active
                        </label>
                        &nbsp &nbsp
                        <label>
                            <input type="radio" name="status" value="0" /> Not Active
                        </label>
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