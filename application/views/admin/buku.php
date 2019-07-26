                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title2; ?></h1> -->

                    <!-- Body -->
                    <div class="card shadow mb-5">
                        <div class="card-header py-3">
                            <h1 class="m-0 font-weight-bold text-primary">Data Buku</h1>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">Tambah</button></div>
                        <?= $this->session->flashdata('error'); ?>
                        <?= $this->session->flashdata('success'); ?>
                        <div class="col col-sm-12">
                            <?php
                            if ($offset == "") {
                                $i = 0;
                            } else {
                                $i = $offset;
                            }
                            foreach ($query as $key) {
                                $i++;
                                ?>
                                <div class="col-lg-3" style="margin-bottom: 20px;">
                                    <div class="card" style="padding: 10px; border-radius: 5px; box-shadow: 1px 1px 10px 1px gray">
                                        <img class="card-img-top" src="<?php echo base_url('upload/img/' . $key->foto) ?>" alt="Card image" style="width:100%; height: 200px; ">
                                        <div class="card-body">
                                            <h4 class="card-title" style="font-weight: bold"><?php echo $key->nama_buku ?></h4>
                                            <p class="card-text">Pengarang: <?php echo $key->pengarang; ?></p>
                                            <p class="card-text">Tahun terbit : <?php echo $key->tahun_terbit; ?></p>
                                            <p class="card-text">Jumlah tersedia: <?php echo $key->jumlah; ?></p>
                                            <a href="<?php echo base_url('admin/hapus_buku/' . $key->id); ?>" onclick="confirm('Yakin Ingin Menhapus Data?')" class="btn btn-danger">Hapus</a>
                                            <button class="btn btn-warning" data-toggle="modal" data-target="#update<?php echo $key->id ?>">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                        ?>
                        </div>
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
                                <h3 class="modal-title">Tambah Buku</h3> <span>Id Buku : <?php echo $id ?></span>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo site_url('admin/tambah_buku') ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                    <div class="form-group">
                                        <label>Gambar Buku</label>
                                        <input type="file" name="foto" id="input-file-now" class="dropify" data-default-file="" required="" />
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col col-lg-6">
                                                <div class="form-group">
                                                    <label>Judul Buku</label>
                                                    <input type="text" required="" name="nama_buku" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Pengarang Buku</label>
                                                    <input type="text" required="" name="pengarang" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col col-lg-6">
                                                <div class="form-group">
                                                    <label>Kategori Buku</label>
                                                    <select class="form-control" name="kategori" required="">
                                                        <?php foreach ($kategori->result() as $key) : ?>
                                                            <option value="<?php echo $key->kategori ?>"><?php echo $key->kategori ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tahun terbit</label>
                                                    <select name="tahun_terbit" class="form-control" required="">
                                                        <option>Tahun terbit</option>
                                                        <?php
                                                        $tahun = date('Y');
                                                        for ($i = $tahun; $i >= $tahun - 70; $i--) {
                                                            ?>
                                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-sm-12">
                                            <div class="form-group">
                                                <label>Jumlah Buku</label>
                                                <input type="number" name="jumlah" required="" class="form-control" placeholder="Jumlah buku" min="10">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info pull-right">Tambah</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" style="margin-right: 10px;" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                foreach ($query as $key) {
                    ?>
                    <div id="update<?php echo $key->id ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Edit Buku</h3> <span>Id Buku : <?php echo $key->id ?></span>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo site_url('admin/edit_buku/' . $key->id) ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $key->id ?>">
                                        <div class="form-group">
                                            <label>Gambar Buku</label>
                                            <input type="file" name="foto" id="input-file-now" class="dropify" data-default-file="<?php echo base_url('upload/img/' . $key->foto) ?>" />
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col col-lg-6">
                                                    <div class="form-group">
                                                        <label>Judul Buku</label>
                                                        <input type="text" required="" name="nama_buku" value="<?php echo $key->nama_buku ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pengarang Buku</label>
                                                        <input type="text" required="" value="<?php echo $key->pengarang ?>" name="pengarang" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col col-lg-6">
                                                    <div class="form-group">
                                                        <label>Kategori Buku</label>
                                                        <select class="form-control" name="kategori" required="">
                                                            <?php foreach ($kategori->result() as $row) : ?>
                                                                <option value="<?php echo $row->kategori ?>"><?php echo $row->kategori ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tahun terbit</label>
                                                        <select name="tahun_terbit" class="form-control" required="">
                                                            <option>Tahun terbit</option>
                                                            <?php
                                                            $tahun = date('Y');
                                                            for ($i = $tahun; $i >= $tahun - 70; $i--) {
                                                                ?>
                                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col col-sm-12">
                                                <div class="form-group">
                                                    <label>Jumlah Buku</label>
                                                    <input type="number" name="jumlah" value="<?php echo $key->jumlah ?>" required="" class="form-control" placeholder="Jumlah buku" min="10">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning pull-right">Ubah</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" style="margin-right: 10px;" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            }
            ?>






                </div>
                <!-- /.container-fluid -->

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
                <!-- End of Main Content -->