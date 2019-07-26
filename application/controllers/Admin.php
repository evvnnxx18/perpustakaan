<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('MainModel', 'model');
        $this->load->library('user_agent');
    }

    public function index()
    {
        $data['title'] = 'Dashboard | Perpustakaan';
        $data['title2'] = 'Dashboard';
        $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/topsidebar', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('admin/index', $data);
    }

    public function anggota()
    {
        $data['link_admin'] = 'active';
        $config['base_url'] = base_url() . 'admin/anggota/';
        $config['total_rows'] = $this->model->get_table('tbl_anggota')->num_rows();
        $config['per_page'] = '10';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_open'] = '</li>';
        $config['full_tag_open'] = '<div class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul></div></div>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '&rarr;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $data['offset'] = $this->uri->segment(3);
        $data['query'] = $this->model->get_all_paginate('tbl_anggota', 'id', $config['per_page'], $this->uri->segment(3));
        $data['title']         = "Data Anggota";
        $data['id_anggota'] = "KA" . str_pad($config['total_rows'] + 1, 4, 0, STR_PAD_LEFT);
        $data['users'] = $this->db->get_where('users', ['name' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topsidebar', $data);
        $this->load->view('admin/anggota', $data);
    }

    public function tambah_anggota()
    {
        $datauser = array(
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'no_hp' => $this->input->post('no_hp'),
            'alamat' => $this->input->post('alamat'),
            'jk' => $this->input->post('jk'),
        );
        $this->model->insert('tbl_anggota', $datauser);
        $this->session->set_flashdata('success', '<div class="alert alert-success text-center col-md-4 col-md-offset-4" role="alert">Anggota Berhasil Ditambah</div>');
        redirect('admin/anggota', 'refresh');
    }

    public function edit_anggota($id)
    {
        $datauser = array(
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'no_hp' => $this->input->post('no_hp'),
            'alamat' => $this->input->post('alamat'),
            'jk' => $this->input->post('jk')
        );
        $this->model->update('tbl_anggota', 'id', $id, $datauser);
        $this->session->set_flashdata('success', '<div class="alert alert-success text-center col-md-4 col-md-offset-4" role="alert">Anggota Berhasil Di Ubah</div>');
        redirect('admin/anggota', 'refresh');
    }

    public function hapus_anggota($id)
    {
        $this->model->drop('tbl_anggota', 'id', $id);
        $this->session->set_flashdata('success', '<div class="alert alert-success text-center col-md-4 col-md-offset-4" role="alert">Anggota Berhasil Dihapus</div>');
    }

    public function kategori()
    {
        $data['title'] = "Kategori | Perpustakaan";
        $data['title2'] = "Kategori";
        $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->model->get_table('tbl_kategori');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topsidebar', $data);
        $this->load->view('admin/kategori', $data);
    }

    public function tambah_kategori()
    {
        $this->form_validation->set_rules('nama', 'Kategori', 'required|is_unique[tbl_kategori.kategori]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', '<div class="alert alert-danger text-center col-md-4 col-md-offset-4" role="alert">Telah Ada Kategori tersebut!</div>');
            redirect($this->agent->referrer());
        } else {
            $datauser = array('kategori' => $this->input->post('nama'));
            $this->model->insert('tbl_kategori', $datauser);
            $this->session->set_flashdata('success', '<div class="alert alert-success text-center col-md-4 col-md-offset-4" role="alert">Kategori Berhasil Ditambah</div>');
            redirect('admin/kategori', 'refresh');
        }
    }

    public function hapus_kategori($id, $kategori)
    {
        $where = array('kategori' => $kategori,);
        $cek = $this->model->get_where('tbl_buku', $where)->num_rows();
        if ($cek > 0) {
            $this->session->set_flashdata('error', '<div class="alert alert-danger text-center col-md-4 col-md-offset-4" role="alert">Tidak Bisa Menghapus Kategori !</div>');
            redirect($this->agent->referrer());
        } else {
            $this->model->drop('tbl_kategori', 'id', $id);
            $this->session->set_flashdata('success', '<div class="alert alert-success text-center col-md-4 col-md-offset-4" role="alert">Kategori Telah Dihapus </div>');
            redirect('admin/kategori', 'refresh');
        }
    }

    public function edit_kategori($id)
    {
        $this->form_validation->set_rules('nama', 'Kategori', 'required|is_unique[tbl_kategori.kategori]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', '<div class="alert alert-danger text-center col-md-4 col-md-offset-4" role="alert">Kategori Telah ada</div>');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('success', '<div class="alert alert-success text-center col-md-4 col-md-offset-4" role="alert">Kategori Berhasil Diubah</div>');
            $datauser = array('kategori' => $this->input->post('nama'));
            $this->model->update('tbl_kategori', 'id', $id, $datauser);
            redirect('admin/kategori', 'refresh');
        }
    }

    public function buku()
    {
        $data['title'] = "Data Buku | Perpustakaan";
        $data['title2'] = "Data Buku";
        $data['users'] = $this->db->get_where('users', ['name' => $this->session->userdata('email')])->row_array();

        $data['link_admin'] = 'active';
        $config['base_url'] = base_url() . 'admin/buku/';
        $config['total_rows'] = $this->model->get_table('tbl_buku')->num_rows();
        $config['per_page'] = '8';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_open'] = '</li>';
        $config['full_tag_open'] = '<div class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul></div></div>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '&rarr;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $data['offset'] = $this->uri->segment(3);
        $data['query'] = $this->model->get_all_paginate_book('tbl_buku', 'id', $config['per_page'], $this->uri->segment(3));
        $data['title']         = "Data Buku";
        $data['kategori']    = $this->model->get_table('tbl_kategori');
        $data['id'] = "KB" . str_pad($config['total_rows'] + 1, 4, 0, STR_PAD_LEFT);
        $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topsidebar', $data);
        $this->load->view('admin/buku', $data);
    }

    function tambah_buku()
    {
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = "upload/img/"; //path folder file upload
            $config['allowed_types'] = 'gif|jpg|png'; //type file yang boleh di upload
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload("foto")) {
                $this->form_validation->set_rules('nama_buku', 'Judul', "required|is_unique[tbl_kategori.kategori]");
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('error', 'Buku telah terdaftar');
                    redirect($this->agent->referrer());
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $image = $data['upload_data']['file_name'];
                    $nama_buku         = $this->input->post('nama_buku');
                    $pengarang         = $this->input->post('pengarang');
                    $kategori         = $this->input->post('kategori');
                    $tahun_terbit     = $this->input->post('tahun_terbit');
                    $jumlah_buku     = $this->input->post('jumlah');

                    $data = array(
                        'id'            => $this->input->post('id'),
                        'foto'            => $image,
                        'nama_buku'        => $nama_buku,
                        'pengarang'        => $pengarang,
                        'tahun_terbit'    => $tahun_terbit,
                        'kategori'        => $kategori,
                        'jumlah'        => $jumlah_buku,

                    );
                    $cek = $this->model->insert('tbl_buku', $data);
                    if ($cek) {
                        $this->session->set_flashdata('success', 'Buku berhasil terdaftar!');
                        redirect('admin/buku', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'gagal!');
                        redirect('admin/buku', 'refresh');
                    }
                }
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $company = $this->input->post('company');
            $deskripsi = $this->input->post('deskripsi');
            $data = array(
                'deskripsi_home' => $deskripsi,
                'company_name'    => $company
            );
            $where = array('id' => 1);
            $cek = $this->model->update('tb_setting', $where, $data);
            if ($cek) {
                $this->session->set_flashdata('ha', 'View updated!');
                redirect('admin/header', 'refresh');
            } else {
                $this->session->set_flashdata('ha', 'Update Failed!');
                redirect('admin/header', 'refresh');
            }
        }
    }

    function edit_buku($id)
    {
        if (!empty($_FILES['file']['name'])) {
            $config['upload_path'] = 'upload/img';
            $config['allowed_type'] = 'gif|jpg|png';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload("foto")) {
                $this->form_validation->set_rules('nama_buku', 'Judul', 'required|is_unique[tbl_kategori.kategori]');

                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('error', '<div class="alert alert-danger text-center col-md-4 col-md-offset-4" role="alert">Gagal Edit Buku</div>');
                    redirect($this->agent->refferr());
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $image = $data['upload_data']['file_name'];
                    $nama_buku = $this->input->post('nama_buku');
                    $pengarang = $this->input->post('pengarang');
                    $tahun_terbit = $this->input->post('tahun_terbit');
                    $jumlah_buku = $this->input->post('jumlah_buku');

                    $data = array(
                        'id' => $this->input->post('id'),
                        'foto' => $image,
                        'nama_buku' => $nama_buku,
                        'pengarang' => $pengarang,
                        'tahun_terbit' => $tahun_terbit,
                        'jumlah_buku' => $jumlah_buku
                    );
                    $cek = $this->model->update('tbl_buku', $id, $data);
                    if ($cek) {
                        $this->session->set_flashdata('succes', '<div class="alert alert-succes text-center col-md-4 col-md-offset-4" role="alert">Buku Berhasil Di Ubah</div>');
                        redirect('admin/buku', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger text-center col-md-4 col-md-offset-4" role="alert">Gagal Mengubah Buku </div>');
                        redirect('admin/buku', 'refresh');
                    }
                }
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $nama_buku         = $this->input->post('nama_buku');
            $pengarang         = $this->input->post('pengarang');
            $kategori         = $this->input->post('kategori');
            $tahun_terbit     = $this->input->post('tahun_terbit');
            $jumlah_buku     = $this->input->post('jumlah');

            $data = array(
                'id'            => $this->input->post('id'),
                'nama_buku'        => $nama_buku,
                'pengarang'        => $pengarang,
                'tahun_terbit'    => $tahun_terbit,
                'kategori'        => $kategori,
                'jumlah'        => $jumlah_buku,
            );
            $cek = $this->model->update('tbl_buku', 'id', $id, $data);
            if ($cek) {
                $this->session->set_flashdata('succes', '<div class="alert alert-succes text-center col-md-4 col-md-offset-4" role="alert">Berhasil Edit Data</div>');
                redirect('admin/buku', 'refresh');
            } else {
                $this->session->set_flashdata('error', '<div class="alert alert-danger text-center col-md-4 col-md-offset-4" role="alert">Gagal Edit Data</div>');
                redirect('admin/buku', 'refresh');
            }
        }
    }

    function hapus_buku($id)
    {
        $this->model->drop('tbl_buku', 'id', $id);
        $this->session->set_flashdata('succes', '<div class="alert alert-succes text-center col-md-4 col-md-offset-4" role="alert">Buku Berhasil Di Hapus</div>');
        redirect('admin/buku');
    }

    function peminjaman()
    {
        $data['link_admin'] = 'active';
        $config['base_url'] = base_url() . 'admin/peminjaman/';
        $config['total_rows'] = $this->model->get_table('query_peminjaman')->num_rows();
        $config['per_page'] = '10';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_open'] = '</li>';
        $config['full_tag_open'] = '<div class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul></div></div>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '&rarr;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['offset'] = $this->uri->segment(3);
        $data['query'] = $this->model->get_all_paginate('query_peminjaman', 'id', $config['per_page'], $this->uri->segment(3));
        $data['kategori']    = $this->model->get_table('tbl_kategori');
        $data['id'] = "KB" . str_pad($config['total_rows'] + 1, 4, 0, STR_PAD_LEFT);
        $data['title'] = "Peminjaman";
        $data['users'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topsidebar', $data);
        $this->load->view('admin/peminjaman', $data);
    }

    function add_peminjaman()
    {
        $cek       = $this->model->get_where_peminjaman($this->input->post('id_anggota'))->num_rows();
        $cek_buku = $this->model->get_where_buku($this->input->post('id_anggota'), $this->input->post('id_buku'))->num_rows();
        if ($cek_buku > 0) {
            $this->session->set_flashdata('error', '<div class="alert alert-danger text-center col-md-4 col-md-offset-4" role="alert">Anggota Telah Meminjam Buku Tersebut</div>');
            redirect($this->agent->referrer());
        } else {

            if ($cek > 3) {
                $this->session->set_flashdata('error', '<div class="alert alert-danger text-center col-md-4 col-md-offset-4" role="alert">Proses ditolak Anggota Telah Meminjam 3 Buku</div>');
                redirect($this->agent->referrer());
            } else {
                $data = array(
                    'id_anggota'     => $this->input->post('id_anggota'),
                    'id_buku'        => $this->input->post('id_buku'),
                    'tanggal_pinjam' => date('Y-m-d'),
                    'status'        => "belum"
                );
                $this->model->insert('tbl_peminjaman', $data);
                $this->session->set_flashdata('error', '<div class="alert alert-success text-center col-md-4 col-md-offset-4" role="alert">Proses Berhasil</div>');
                redirect($this->agent->referrer());
            }
        }
    }

    function kembali($id, $buku)
    {
        $data = array(
            'denda'         => $this->input->post('denda'),
            'tangal_pulang'    => date('Y-m-d'),
            'status'        => 'kembali'
        );
        $this->model->update("tbl_peminjaman", 'id', $id, $data);
        $where = array('id' => $buku);
        $data_buku = $this->model->get_where("tbl_buku", $where)->result();
        foreach ($data_buku as $key) {
            $jumlah_old = $key->jumlah;
        }
        $data = array(
            'jumlah'         => $jumlah_old + 1,
        );
        $this->model->update("tbl_buku", 'id', $buku, $data);

        $this->session->set_flashdata('succes', '<div class="alert alert-succes text-center col-md-4 col-md-offset-4" role="alert">Buku Berhasil Ditambahkan</div>');
        redirect('admin/peminjaman', 'refresh');
    }
    function perpanjang($id)
    {
        $data = array(
            'denda'         => '5.000',
            'tanggal_pinjam' =>  date("Y-m-d")
        );
        $this->model->update("tbl_peminjaman", 'id', $id, $data);
        $this->session->set_flashdata('success', '<div class="alert alert-success text-center col-md-4 col-md-offset-4" role="alert">Perpanjangan Peminjaman Buku Berhasil</div>');
        redirect('admin/peminjaman', 'refresh');
    }
    function autocomplete()
    {
        $search_data = $this->input->post('search_data');
        $result = $this->model->get_autocomplete('tbl_anggota', 'id', $search_data);
        if (!empty($result)) {
            foreach ($result as $row) :
                echo "<h5>" . $row->nama . "</h5>";
            endforeach;
        } else {
            echo "<li> <em> Tidak ditemukan ... </em> </li>";
        }
    }
    function autocomplete_book()
    {
        $search_data = $this->input->post('search_data');
        $result = $this->model->get_autocomplete_book('tbl_buku', 'id', $search_data);
        if (!empty($result)) {
            foreach ($result as $row) :
                echo "<h5>" . $row->nama_buku . "</h5><br><img src='" . base_url('upload/img/' . $row->foto) . "' width='100%' height='250px'>";
            endforeach;
        } else {
            echo "<li> <em> Tidak Ditemukan ... </em> </li>";
        }
    }
}
