                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title2; ?></h1> -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="m-0 font-weight-bold text-primary">Peminjaman & Pengembalian Buku</h1><br>
                            <button class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">Tambah</button>
                        </div>
                        <div class="card-body">
                            <?= $this->session->flashdata('error'); ?>
                            <?= $this->session->flashdata('success'); ?>
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peminjam(id)</th>
                                    <th>Nama Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Lama Pinjam (Telat)</th>
                                    <th>Denda</th>
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
                                    if ($row->tangal_pulang == "0000-00-00") {
                                        $date1     = date_create($row->tanggal_pinjam);
                                        $date2      = date_create(date('Y-m-d'));
                                        $cek_telat = date_diff($date1, $date2);
                                        $telat      = $cek_telat->format("%a");
                                    } else {
                                        $date1     = date_create($row->tanggal_pinjam);
                                        $date2      = date_create($row->tangal_pulang);
                                        $cek_telat = date_diff($date1, $date2);
                                        $telat      = $cek_telat->format("%a");
                                    }
                                    ?>
                                    <form method="post" action="<?php echo base_url('admin/kembali/' . $row->id . "/" . $row->id_buku) ?>">
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->nama . "(" . $row->id_anggota . ")"; ?></td>
                                            <td><?php echo $row->nama_buku; ?></td>
                                            <td><?php echo $row->tanggal_pinjam ?></td>
                                            <td><?php if ($row->tangal_pulang !== "0000-00-00") {
                                                    echo $row->tangal_pulang;
                                                } else {
                                                    echo "Belum Kembali";
                                                } ?></td>
                                            <td><?php if ($telat > 7) {
                                                    echo $telat . " Hari (" . ($telat - 7) . " Hari)";
                                                } else {
                                                    echo $telat . " Hari(0)";
                                                } ?></td>
                                            <td><?php if ($telat > 7) {
                                                    echo "RP." . ($telat - 7) * 500;
                                                } else {
                                                    echo "-";
                                                } ?></td>
                                            <td>
                                                <button class="btn btn-warning" <?php if ($row->status === "kembali") {
                                                                                    echo "disabled";
                                                                                } ?> type="submit" title="Kembali">K</button>
                                                <a href="<?php echo base_url('admin/perpanjang/' . $row->id) ?>" <?php if ($row->status === "kembali") {
                                                                                                                        echo "disabled";
                                                                                                                    } ?> class="btn btn-primary" title="Perpanjang" onclick="return confirm('Perpanjang dengan denda yang telah ditentukan?')">P</a>
                                                <!-- <a href="<?php echo base_url('admin/delete_peminjaman/' . $row->id . "/" . $row->id_buku) ?>" <?php if ($row->status === "kembali") {
                                                                                                                                                        echo "disabled";
                                                                                                                                                    } ?> class="btn btn-danger" title="Perpanjang" onclick="return confirm('Hapus peminjaman?')">H</a> -->

                                            </td>
                                        </tr>
                                        <input type="hidden" name="denda" value="<?php if ($telat > 7) {
                                                                                        echo ($telat - 7) * 500;
                                                                                    } else {
                                                                                        echo "";
                                                                                    } ?>">
                                    </form>
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
                                <h3 class="modal-title">Peminjaman</h3>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo site_url('admin/add_peminjaman') ?>">
                                    <div class="row">
                                        <div class="col col-lg-12">
                                            <div class="row">
                                                <div class="col col-lg-6">
                                                    <div class="form-group">
                                                        <label>ID Anggota </label>
                                                        <input type="text" name="id_anggota" id="id_anggota" placeholder="ID Anggota " onkeyup="ajaxSearch()" required="" autofocus="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col col-lg-6" style="border-bottom: 2px solid gray">
                                                    <label>Nama Anggota</label>
                                                    <div id="ha">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 10px;">
                                                <div class="col col-lg-6">
                                                    <div class="form-group">
                                                        <label>ID Buku </label>
                                                        <input type="text" name="id_buku" id="id_buku" placeholder="ID Anggota " onkeyup="ajaxSearch2()" required="" autofocus="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col col-lg-6" style="border-bottom: 2px solid gray">
                                                    <label>Nama Buku</label>
                                                    <div id="haa">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary pull-right" style="margin-right: 10px">Proses</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function ajaxSearch() {
                        var input_data = $('#id_anggota').val();
                        if (input_data.length === 0) {
                            $('#ha').hide();
                        } else {

                            var post_data = {
                                'search_data': input_data,
                                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                            };

                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>admin/autocomplete/",
                                data: post_data,
                                success: function(data) {
                                    if (data.length > 0) {
                                        $('#ha').show();
                                        $('#ha').html(data);
                                    } else {
                                        $("#ha").hide();
                                    }
                                }
                            });
                        }
                    }

                    function ajaxSearch2() {
                        var input_data = $('#id_buku').val();
                        if (input_data.length === 0) {
                            $('#haa').hide();
                        } else {

                            var post_data = {
                                'search_data': input_data,
                                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                            };

                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>admin/autocomplete_book/",
                                data: post_data,
                                success: function(data) {
                                    if (data.length > 0) {
                                        $('#haa').show();
                                        $('#haa').html(data);
                                    } else {
                                        $("#haa").hide();
                                    }
                                }
                            });
                        }
                    }
                </script>



                <!-- Footer -->
                <!-- <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Perpustakaan <?= date('Y'); ?></span>
                        </div>
                    </div>
                </footer>
                <-- End of Footer -->

                <!-- Scroll to Top Button-->
                <!-- <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a> -->

                <!-- Logout Modal-->
                <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                </div> -->

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