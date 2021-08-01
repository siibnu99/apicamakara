<?php

namespace App\Controllers;

use Exception;
use JsonException;

class Tryout extends BaseController
{
    public function __construct()
    {
        $this->serverside_model = new \App\Models\Serverside_model();
    }
    public function index()
    {
        $data = [
            'title' => 'tryout',
        ];
        return view('tryout/index', $data);
    }
    public function submitted($id = null)
    {
        $data = [
            'title' => 'tryout',
            'id' => $id
        ];
        return view('tryout/submitted', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'tryout',
            'validation' => \Config\Services::validation(),
        ];
        return view('tryout/create', $data);
    }
    public function attemptCreate()
    {
        if (!$this->validate([
            'name' => [
                'label'  => 'Nama Tryout',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'descript' => [
                'label'  => 'Deskripsi',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'date_start' => [
                'label'  => 'Tanggal mulai',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'date_end' => [
                'label'  => 'Tanggal selesai',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'time_start' => [
                'label'  => 'Waktu mulai',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'time_end' => [
                'label'  => 'Waktu selesai',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'type_tryout' => [
                'label'  => 'Tipe  Tryout',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di pilih',
                ]
            ],
            'image' => [
                'label'  => 'Gambar',
                'rules'  => 'uploaded[image]|max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
        ]))
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $uploadimage = $this->request->getFile('image');
        $nameimage = $uploadimage->getRandomName();
        $uploadimage->move('assets/image/tryout/', $nameimage);
        $data = $this->request->getVar();
        $data['id_tryout'] = $this->Uuid->v4();
        $data['image'] = $nameimage;
        $data['created_by'] = user_id();
        $data['updated_by'] = user_id();
        $this->TryoutModel->insert($data);
        $this->session->setFlashdata('message', 'Tryout ' . $data['name'] . ' Berhasil dibuat');
        return redirect()->to(base_url('admincamakara/tryout'));
    }
    public function edit($id = null)
    {
        $data = [
            'title' => 'tryout',
            'validation' => \Config\Services::validation(),
            'tryout' => $this->TryoutModel->find($id),
        ];
        return view('tryout/edit', $data);
    }
    public function attemptEdit($id)
    {
        if (!$this->validate([
            'name' => [
                'label'  => 'Nama Tryout',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'descript' => [
                'label'  => 'Deskripsi',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'date_start' => [
                'label'  => 'Tanggal mulai',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'date_end' => [
                'label'  => 'Tanggal selesai',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'time_start' => [
                'label'  => 'Waktu mulai',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'time_end' => [
                'label'  => 'Waktu selesai',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'type_tryout' => [
                'label'  => 'Tipe  Tryout',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di pilih',
                ]
            ],
            'image' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
        ]))
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $rData = $this->TryoutModel->find($id);
        $uploadimage = $this->request->getFile('image');
        if ($uploadimage->getError() === 4) {
            $nameimage = $rData['image'];
        } else {
            $nameimage = $uploadimage->getRandomName();
            $uploadimage->move('assets/image/tryout', $nameimage);
            try {
                unlink('assets/image/tryout/' . $rData['image']);
            } catch (\Throwable $th) {
            }
        }
        $data = $this->request->getVar();
        $data['image'] = $nameimage;
        $cat = $data['cat_tryout'];
        $data['cat_tryout'] = $cat;
        $data['updated_by'] = user_id();
        $this->TryoutModel->update($id, $data);
        $this->session->setFlashdata('message', 'Tryout ' . $data['name'] . ' Berhasil diedit');
        return redirect()->to(base_url('admincamakara/tryout'));
    }
    public function delete($id)
    {
        $rData = $this->TryoutModel->find($id);
        try {
            unlink('assets/image/tryout/' . $rData['image']);
        } catch (\Throwable $th) {
        }
        $this->TryoutModel->delete($id);
        $this->session->setFlashdata('message', 'Tryout Berhasil dihapus');
        return redirect()->to(base_url('admincamakara/tryout'));
    }
    public function detail($id = null)
    {
        $data = [
            'title' => 'tryout',
            'validation' => \Config\Services::validation(),
            'tryout' => $this->TryoutModel->find($id),
            'TryoutModel' => $this->TryoutModel,
            'SoaltModel' => $this->SoaltModel,
            'Uuid' => $this->Uuid,
        ];

        return view('tryout/detail', $data);
    }
    public function editsoal($id, $idSoal, $noSoal = 1)
    {
        if ($dataSoalt = $this->SoaltModel->where(['tryout_id' => $id, 'kind_tryout' => $idSoal, 'no_soal' => $noSoal])->first()) {
            $idSoalt = $dataSoalt['id_soalt'];
        } else {
            $idSoalt = $this->Uuid->v4();
            $dataInput = [
                'id_soalt' => $idSoalt,
                'tryout_id' => $id,
                'kind_tryout' => $idSoal,
                'no_soal' => $noSoal,
            ];
            $this->SoaltModel->insert($dataInput);
        }
        $data = [
            'title' => 'tryout',
            'validation' => \Config\Services::validation(),
            'tryout' => $this->TryoutModel->find($id),
            'soalt' => $this->SoaltModel->find($idSoalt),
            'id' => $id,
            'idSoal' => $idSoal,
            'noSoal' => $noSoal,
            'idSoalt' => $idSoalt,
        ];
        return view('tryout/editsoal', $data);
    }
    public function attemptEditSoal($id, $idSoal, $noSoal = 1)
    {
        if (!$this->validate([
            'soal' => [
                'label'  => 'Soal',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi!',
                ]
            ],
            'image' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
            'pilihan1' => [
                'label'  => 'pilihan1',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'pilihan2' => [
                'label'  => 'pilihan2',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'pilihan3' => [
                'label'  => 'pilihan3',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'pilihan4' => [
                'label'  => 'pilihan4',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'pilihan5' => [
                'label'  => 'pilihan5',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'imagepilihan1' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
            'imagepilihan2' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
            'imagepilihan3' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
            'imagepilihan4' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
            'imagepilihan5' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
            'jawaban' => [
                'label'  => 'jawaban',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'pembahasan' => [
                'label'  => 'pembahasan',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
        ]))
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $dataSoalt = $this->SoaltModel->find($this->request->getVar('id_soalt'));
        $uploadimage = $this->request->getFile('image');
        if ($this->request->getVar('deleteImage')) {
            if ($dataSoalt['image']) {
                try {
                    unlink('assets/image/soalTryout/' . $dataSoalt['image']);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            $nameimage = '';
        } else {
            if ($uploadimage->getError() === 4) {
                if ($dataSoalt['image']) {
                    $nameimage = $dataSoalt['image'];
                } else {
                    $nameimage = '';
                }
            } else {

                $nameimage = $uploadimage->getRandomName();
                $uploadimage->move('assets/image/soalTryout', $nameimage);
                if ($dataSoalt['image']) {
                    try {
                        unlink('assets/image/soalTryout/' . $dataSoalt['image']);
                    } catch (\Throwable $th) {
                    }
                }
            }
        }
        $uploadimage = $this->request->getFile('imagepembahasan');
        if ($this->request->getVar('deleteImagePembahasan')) {
            if ($dataSoalt['imagepembahasan']) {
                try {

                    unlink('assets/image/soalTryout/' . $dataSoalt['imagepembahasan']);
                } catch (\Throwable $th) {
                }
            }
            $nameimagepembahasan = '';
        } else {
            if ($uploadimage->getError() === 4) {
                if ($dataSoalt['imagepembahasan']) {
                    $nameimagepembahasan = $dataSoalt['imagepembahasan'];
                } else {
                    $nameimagepembahasan = '';
                }
            } else {

                $nameimagepembahasan = $uploadimage->getRandomName();
                $uploadimage->move('assets/image/soalTryout', $nameimagepembahasan);
                if ($dataSoalt['imagepembahasan']) {
                    try {
                        unlink('assets/image/soalTryout/' . $dataSoalt['imagepembahasan']);
                    } catch (\Throwable $th) {
                    }
                }
            }
        }
        $nameimagepilihan = array();
        foreach (abjad() as $key => $value) {
            $uploadimage = $this->request->getFile('imagepilihan' . $value[0]);
            if ($this->request->getVar('deleteimagepilihan' . $value[0])) {
                if ($dataSoalt['imagepilihan' . $value[0]]) {
                    try {
                        unlink('assets/image/soalTryout/' . $dataSoalt['imagepilihan' . $value[0]]);
                    } catch (\Throwable $th) {
                    }
                }
                $nameimagepilihan[$key] = '';
            } else {
                if ($uploadimage->getError() === 4) {
                    if ($dataSoalt['imagepilihan' . $value[0]]) {
                        $nameimagepilihan[$key] = $dataSoalt['imagepilihan' . $value[0]];
                    } else {
                        $nameimagepilihan[$key] = '';
                    }
                } else {
                    $nameimagepilihan[$key] = $uploadimage->getRandomName();
                    $uploadimage->move('assets/image/soalTryout/', $nameimagepilihan[$key]);
                    if ($dataSoalt['imagepilihan' . $value[0]]) {
                        try {
                            unlink('assets/image/soalTryout/' . $dataSoalt['imagepilihan' . $value[0]]);
                        } catch (\Throwable $th) {
                        }
                    }
                }
            }
        }
        $data = [
            'id_soalt' => $this->request->getVar('id_soalt'),
            'no_soal' => $noSoal,
            'soal' => $this->request->getVar('soal'),
            'image' => $nameimage,
            'pilihan1' => $this->request->getVar('pilihan1'),
            'pilihan2' => $this->request->getVar('pilihan2'),
            'pilihan3' => $this->request->getVar('pilihan3'),
            'pilihan4' => $this->request->getVar('pilihan4'),
            'pilihan5' => $this->request->getVar('pilihan5'),
            'imagepilihan1' => $nameimagepilihan[0],
            'imagepilihan2' => $nameimagepilihan[1],
            'imagepilihan3' => $nameimagepilihan[2],
            'imagepilihan4' => $nameimagepilihan[3],
            'imagepilihan5' => $nameimagepilihan[4],
            'jawaban' => $this->request->getVar('jawaban'),
            'pembahasan' => $this->request->getVar('pembahasan'),
            'imagepembahasan' => $nameimagepembahasan,
        ];
        $this->SoaltModel->save($data);
        $datas['updated_by'] = user_id();
        $this->TryoutModel->update($id, $datas);
        $this->session->setFlashdata('message', 'Soal ' . $noSoal . ' Berhasil di update');
        return  redirect()->to($_SERVER['HTTP_REFERER']);
    }
    public function editbobot($id, $idSoal)
    {
        $dataSoalt = $this->SoaltModel->where(['tryout_id' => $id, 'kind_tryout' => $idSoal])->first();
        if (!$dataSoalt) {
            $this->session->setFlashdata('message', 'Soal belum ada, tidak bisa edit bobot');
            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
        $idSoalt = $dataSoalt['id_soalt'];
        $data = [
            'title' => allMapel($idSoal),
            'validation' => \Config\Services::validation(),
            'tryout' => $this->TryoutModel->find($id),
            'soalt' => $this->SoaltModel->where(['tryout_id' => $id, 'kind_tryout' => $idSoal])->orderBy('no_soal', 'ASC')->findAll(),
            'dataAnswer' => $this->AnswertModel->where(['tryout_id' => $id, 'kind_tryout' => $idSoal])->findAll(),
            'SoaltModel' => $this->SoaltModel,
            'id' => $id,
            'idSoal' => $idSoal,
            'idSoalt' => $idSoalt,
        ];
        return view('tryout/editbobot', $data);
    }
    public function attempteditbobot($id, $idSoal)
    {
        $dataSoalt = $this->SoaltModel->where(['tryout_id' => $id, 'kind_tryout' => $idSoal])->findAll();
        foreach ($dataSoalt as $item) {
            $data = [
                'id_soalt' => $this->request->getVar('id' . $item['no_soal']),
                'bobot' => $this->request->getVar($item['no_soal'])
            ];
            $this->SoaltModel->save($data);
        }
        $datas['updated_by'] = user_id();
        $this->TryoutModel->update($id, $datas);
        $this->session->setFlashdata('message', 'Soal  Berhasil di update');
        return  redirect()->to(base_url('admincamakara/tryout/detail/' . $id));
    }
    public function toogleActive($id)
    {
        $item = $this->TryoutModel->find($id);
        $data = [
            'active' => $item['active'] ? 0 : 1
        ];
        $message = $item['active'] ? "Dinonaktifkan" : "Diaktifkan";
        try {
            $this->TryoutModel->update($id, $data);
            $data = [
                'message' => "Tryout : " . $item['name'] . " Berhasil " . $message,
            ];
        } catch (Exception $e) {
        }
        echo "Tryout : " . $item['name'] . " Berhasil " . $message;
    }
    public function listdata()
    {

        $request = \Config\Services::request();
        $list_data = $this->serverside_model;
        $where = NULL;
        $column_order = array(NULL, 'tbl_tryout.name', 'tbl_tryout.date_start', 'tbl_tryout.time_start', 'tbl_tryout.date_end', 'tbl_tryout.time_end', 'tbl_tryout.type_tryout', 'tbl_tryout.cat_tryout', 'tbl_tryout.payment_method', 'tbl_tryout.active', 'tbl_tryout.created_by', 'tbl_tryout.updated_by', NULL);
        $column_search = array('tbl_tryout.name', 'tbl_tryout.date_start', 'tbl_tryout.time_start', 'tbl_tryout.date_end', 'tbl_tryout.time_end', 'tbl_tryout.type_tryout', 'tbl_tryout.cat_tryout', 'tbl_tryout.payment_method', 'tbl_tryout.active', 'tbl_tryout.created_by', 'tbl_tryout.updated_by');
        $order = array('tbl_tryout.created_at' => 'desc');
        $list = $list_data->get_datatables('tbl_tryout', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $lists->name;
            $row[] = $lists->date_start;
            $row[] = $lists->time_start;
            $row[] = $lists->date_end;
            $row[] = $lists->time_end;
            $row[] = jenisTryout($lists->type_tryout);
            $row[] = catTryout($lists->cat_tryout);
            $row[] = paymentMethod($lists->payment_method);
            if ($lists->payment_method == 1) :
                $dataTable = '<td>';
                if ($lists->rule1) : $dataTable .= '<li>' . $lists->rule1 . '</li>';
                endif;
                if ($lists->rule2) : $dataTable .= '<li>' . $lists->rule2 . '</li>';
                endif;
                if ($lists->rule3) : $dataTable .= '<li>' . $lists->rule3 . '</li>';
                endif;
                if ($lists->rule4) : $dataTable .= '<li>' . $lists->rule4 . '</li>';
                endif;
                if ($lists->rule5) : $dataTable .= '<li>' . $lists->rule5 . '</li>';
                endif;
                $dataTable .= '</td>';
            else :
                $dataTable = '<td>' . $lists->price . '</td>';
            endif;
            $row[] = $dataTable;
            $switch = '<label class="switch ">';
            $switch .= '<input type="checkbox" class="primary toogleActive" idto="' . $lists->id_tryout . '" nameto="' . $lists->name . '" active="' . $lists->active . '"';
            $switch .= $lists->active ? 'checked' : '';
            $switch .= '/>';
            $switch .= '<span class="slider round"></span>';
            $switch .= '</label>';
            $row[] = $switch;
            $row[] = $this->UserModel->find($lists->created_by)->email;
            $row[] = $this->UserModel->find($lists->updated_by)->email;
            $row[] = '<a href="' . base_url('admincamakara/tryout/submitted/' . $lists->id_tryout) . '" class="badge badge-info">Pengumpulan</a>  <a href="' . base_url('admincamakara/tryout/detail/' . $lists->id_tryout) . '" class="badge badge-primary">Detail</a>
            <a href="' . base_url('admincamakara/tryout/edit/' . $lists->id_tryout) . '" class="badge badge-warning">Edit</a>
            <a href="' . base_url('admincamakara/tryout/delete/' . $lists->id_tryout) . '" class="badge badge-danger">Hapus</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('tbl_tryout', $where),
            "recordsFiltered" => $list_data->count_filtered('tbl_tryout', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        return json_encode($output);
    }
    public function listdatasubmitted($id = null)
    {
        $request = \Config\Services::request();
        $list_data = $this->serverside_model;
        $where = ['tbl_mytryout.tryout_id =' => $id];
        $column_order = array(NULL, 'tbl_mytryout.tryout_id', 'tbl_mytryout.user_id', 'tbl_mytryout.finish', 'tbl_mytryout.price');
        $column_search = array('tbl_mytryout.tryout_id', 'tbl_mytryout.user_id', 'tbl_mytryout.finish', 'tbl_mytryout.price');
        $order = array('tbl_mytryout.created_at' => 'asc');
        $list = $list_data->get_datatables('tbl_mytryout', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $tryout = $this->TryoutModel->find($lists->tryout_id);
            if ($tryout['payment_method'] == 1) {
                $price = 0;
            } else if ($tryout['payment_method'] == 2) {
                $price = $tryout['price'];
            } else {
                $price = $lists['price'];
            }
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $this->TryoutModel->find($lists->tryout_id)['name'];
            $row[] = $this->UserapiModel->find($lists->user_id)['fullname'];
            $row[] = $lists->finish ? '<span class="badge badge-success">Sudah Mengerjakan</span>' : '<span class="badge badge-danger">Belum Mengerjakan</span>';
            $row[] = $price ? $price : '0';
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('tbl_mytryout', $where),
            "recordsFiltered" => $list_data->count_filtered('tbl_mytryout', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        return json_encode($output);
    }
}
