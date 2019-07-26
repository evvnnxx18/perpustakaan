                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title2; ?></h1> -->

                    <!-- Body -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="m-0 font-weight-bold text-primary">Kategori Buku</h1>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">Tambah</button></div>
                        <?= $this->session->flashdata('error'); ?>
                        <?= $this->session->flashdata('success'); ?>
                        <table class="table table-hover table-bordered text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kategori</th>
                                <th width="20%">Jumlah Buku</th>
                                <th width="30%">Aksi</th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($kategori->result() as $row) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td class="text-center"><?php echo $row->kategori ?></td>
                                    <td class="text-center"><?php echo $this->db->where('kategori', $row->kategori)->get('tbl_buku')->num_rows() ?></td>
                                    <td class="text-center">
                                        <a title="Hapus" href="<?php echo site_url(); ?>admin/hapus_kategori/<?php echo $row->id . "/" . $row->kategori; ?>" onclick="return confirm('Are You Sure?');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> |
                                        <button class="btn btn-warning" title="update" data-toggle="modal" data-target="#edit<?php echo $i ?>">Edit</button>
                                    </td>
                                </tr>
                            <?php
                        }
                        if ($i == 0) {
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
                    </div>
                </div>
                </div>
                <!-- </div> -->

                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>Tambah Kategori</h3>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo site_url('admin/tambah_kategori') ?>" method="post">
                                    <div class="row">
                                        <div class="col col-lg-12">
                                            <div class="form-group">
                                                <label>Nama Kategori</label>
                                                <input type="text" name="nama" placeholder="Nama Kategori.. " required="" autofocus="" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-info pull-right">Tambah Kategori</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $no = 0;
                foreach ($kategori->result() as $key) {
                    $no++;
                    ?>
                    <div id="edit<?php echo $no ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Edit kategori</h3>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo site_url('admin/edit_kategori/' . $key->id) ?>">
                                        <div class="row">
                                            <div class="col col-lg-12">
                                                <div class="form-group">
                                                    <label>Nama kategori</label>
                                                    <input type="text" name="nama" placeholder="Nama kategori" required="" autofocus="" class="form-control" value="<?php echo $key->kategori ?>">
                                                </div>
                                                <button type="submit" class="btn btn-warning pull-right">Edit Kategori</button>
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


                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Perpustakaan <?= date('Y'); ?></span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

                </div>
                <!-- End of Page Wrapper -->

                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bootstrap core JavaScript-->
                <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
                <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>







                </div>
                <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->