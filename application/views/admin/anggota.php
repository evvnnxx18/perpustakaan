                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title2; ?></h1> -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="m-0 font-weight-bold text-primary">Anggota Perpustakaan</h1><br>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">Tambah</button>
                            <?= $this->session->flashdata('error'); ?>
                            <?= $this->session->flashdata('success'); ?>
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>No Telepon</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                                <?php
                                if ($offset == "") {
                                    $i = 0;
                                } else {
                                    $i = $offset;
                                }
                                foreach ($query as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row->id ?></td>
                                        <td><?php echo $row->nama; ?></td>
                                        <td><?php if ($row->jk == "l") {
                                                echo "laki-laki";
                                            } else {
                                                echo "Perempuan";
                                            } ?></td>
                                        <td><?php echo $row->alamat ?></td>
                                        <td><?php echo $row->no_hp ?></td>
                                        <td>
                                            <a title="Hapus" href="<?php echo site_url(); ?>admin/hapus_anggota/<?php echo $row->id; ?>" onclick="return confirm('Are You Sure?');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            <button class="btn btn-warning" title="update" data-toggle="modal" data-target="#edit<?php echo $i ?>">Edit</button>
                                        </td>
                                    </tr>
                                <?php
                            }
                            if ($query == NULL) {
                                ?>
                                    <tr>
                                        <td colspan="8">
                                            <center>Tidak Ada Data</center>
                                        </td>
                                    </tr>
                                <?php
                            }
                            ?>
                            </table>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
                </div>
                <!--/.row-->
                </div>

                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Tambah anggota</h3>
                                <span>Id Anggota : <?php echo $id_anggota ?></span>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo site_url('admin/tambah_anggota') ?>">
                                    <div class="row">
                                        <input type="hidden" name="id" value="<?php echo $id_anggota ?>">
                                        <div class="col col-lg-12">
                                            <div class="form-group">
                                                <label>Nama </label>
                                                <input type="text" name="nama" placeholder="Nama " required="" autofocus="" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <select class="form-control" name="jk" required="">
                                                    <option value="p">Perempuan</option>
                                                    <option value="l">Laki-laki</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat </label>
                                                <textarea placeholder="Alamat" name="alamat" required="" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>No telepon </label>
                                                <input type="text" name="no_hp" placeholder="No telepon " required="" autofocus="" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-info pull-right">Tambah anggota</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if ($offset == "") {
                    $i = 0;
                } else {
                    $i = $offset;
                }
                foreach ($query as $key) {
                    $i++;
                    ?>
                    <div id="edit<?php echo $i ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Edit anggota</h3> <span>Id Anggota : <?php echo $key->id ?></span>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo site_url('admin/edit_anggota/' . $key->id) ?>">
                                        <div class="row">
                                            <div class="col col-lg-12">
                                                <div class="form-group">
                                                    <label>Nama </label>
                                                    <input type="text" name="nama" placeholder="Nama " required="" autofocus="" class="form-control" value="<?php echo $key->nama ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <select class="form-control" name="jk" required="">
                                                        <option value="p">Perempuan</option>
                                                        <option value="l">Laki-laki</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat </label>
                                                    <textarea placeholder="Alamat" name="alamat" required="" class="form-control"><?php echo $key->alamat ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>No telepon </label>
                                                    <input type="text" name="no_hp" placeholder="No telepon " required="" autofocus="" value="<?php echo $key->no_hp ?>" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-warning pull-right">Edit Anggota</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            }
            ?>

                <!-- Bootstrap core JavaScript-->
                <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
                <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

                <!-- Container fluid -->

                </div>
                <!-- End of Main Content -->