<?php

namespace App\Controllers;

use Exception;

class Quiz extends BaseController
{
    public function __construct()
    {
        $this->serverside_model = new \App\Models\Serverside_model();
    }
    public function index()
    {
        $data = [
            'title' => 'quiz',
        ];
        return view('quiz/index', $data);
    }
    public function submitted($id = null)
    {
        $data = [
            'title' => 'quiz',
            'id' => $id
        ];
        return view('quiz/submitted', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'quiz',
            'validation' => \Config\Services::validation(),

        ];
        return view('quiz/create', $data);
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
            'class' => [
                'label'  => 'Kelas Quiz',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di pilih',
                ]
            ],
            'mapel' => [
                'label'  => 'Mata Pelajaran',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di pilih',
                ]
            ],
            'q_mapel' => [
                'label'  => 'Jumlah soal',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            't_mapel' => [
                'label'  => 'Waktu Pengerjaan',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'kuota' => [
                'label'  => 'Kuota siswa',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'media' => [
                'label'  => 'Media m',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di pilih',
                ]
            ],
            'link' => [
                'label'  => 'Waktu Pengerjaan',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'image' => [
                'label'  => 'Gambar',
                'rules'  => 'uploaded[image]|max_size[image,2048]|is_image[image]',
                'errors' => [
                    'uploaded' => '{field} harus ada',
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
        ]))
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $uploadimage = $this->request->getFile('image');
        $nameimage = $uploadimage->getRandomName();
        $uploadimage->move('assets/image/quiz/', $nameimage);
        $data = $this->request->getVar();
        $data['id_quiz'] = $this->Uuid->v4();
        $data['image'] = $nameimage;
        $data['created_by'] = user_id();
        $data['updated_by'] = user_id();
        $this->QuizModel->insert($data);
        $this->session->setFlashdata('message', 'Quiz ' . $data['name'] . ' Berhasil dibuat');
        return redirect()->to(base_url('admincamakara/quiz'));
    }
    public function edit($id = null)
    {
        $data = [
            'title' => 'quiz',
            'validation' => \Config\Services::validation(),
            'quiz' => $this->QuizModel->find($id),
        ];
        return view('quiz/edit', $data);
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
            'class' => [
                'label'  => 'Kelas Quiz',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di pilih',
                ]
            ],
            'mapel' => [
                'label'  => 'Mata Pelajaran',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di pilih',
                ]
            ],
            'q_mapel' => [
                'label'  => 'Jumlah soal',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            't_mapel' => [
                'label'  => 'Waktu Pengerjaan',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'kuota' => [
                'label'  => 'Kuota siswa',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'media' => [
                'label'  => 'Media m',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di pilih',
                ]
            ],
            'link' => [
                'label'  => 'Waktu Pengerjaan',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi',
                ]
            ],
            'image' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'uploaded' => '{field} harus ada',
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
                ]
            ],
        ]))
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $rData = $this->QuizModel->find($id);
        $uploadimage = $this->request->getFile('image');
        if ($uploadimage->getError() === 4) {
            $nameimage = $rData['image'];
        } else {
            $nameimage = $uploadimage->getRandomName();
            $uploadimage->move('assets/image/quiz', $nameimage);
            try {
                unlink('assets/image/quiz/' . $rData['image']);
            } catch (\Throwable $th) {
            }
        }
        $data = $this->request->getVar();
        $data['image'] = $nameimage;
        $data['updated_by'] = user_id();
        $this->QuizModel->update($id, $data);
        $this->session->setFlashdata('message', 'Quiz ' . $data['name'] . ' Berhasil diedit');
        return redirect()->to(base_url('admincamakara/quiz'));
    }
    public function delete($id)
    {
        $rData = $this->QuizModel->find($id);
        try {
            unlink('assets/image/quiz/' . $rData['image']);
        } catch (\Throwable $th) {
        }
        $this->QuizModel->delete($id);
        $this->session->setFlashdata('message', 'Quiz ' . $rData['name'] . '  Berhasil dihapus');
        return redirect()->to(base_url('admincamakara/quiz'));
    }
    public function detail($id = null)
    {
        $data = [
            'title' => 'quiz',
            'validation' => \Config\Services::validation(),
            'quiz' => $this->QuizModel->find($id),
            'QuizModel' => $this->QuizModel,
            'SoalqModel' => $this->SoalqModel,
            'Uuid' => $this->Uuid,
        ];
        return view('quiz/detail', $data);
    }
    public function editsoal($id, $noSoal = 1)
    {
        if ($dataSoalq = $this->SoalqModel->where(['quiz_id' => $id, 'no_soal' => $noSoal])->first()) {
            $idSoalq = $dataSoalq['id_soalq'];
        } else {
            $idSoalq = $this->Uuid->v4();
            $dataInput = [
                'id_soalq' => $idSoalq,
                'quiz_id' => $id,
                'no_soal' => $noSoal,
            ];
            $this->SoalqModel->insert($dataInput);
        }
        $data = [
            'title' => 'quiz',
            'validation' => \Config\Services::validation(),
            'quiz' => $this->QuizModel->find($id),
            'soalq' => $this->SoalqModel->find($idSoalq),
            'id' => $id,
            'noSoal' => $noSoal,
            'idSoalq' => $idSoalq,
        ];
        return view('quiz/editsoal', $data);
    }
    public function attemptEditSoal($id, $noSoal = 1)
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
            'imagepembahasan' => [
                'label'  => 'Gambar',
                'rules'  => 'max_size[image,2048]|is_image[image]',
                'errors' => [
                    'max_size' => '{field} tidak boleh lebih dari 2 MB!',
                    'is_image' => '{field} tidak berbentuk gambar!',
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
            // 'pilihan1' => [
            //     'label'  => 'pilihan1',
            //     'rules'  => 'required',
            //     'errors' => [
            //         'required' => '{field} Harus di isi',
            //     ]
            // ],
            // 'pilihan2' => [
            //     'label'  => 'pilihan2',
            //     'rules'  => 'required',
            //     'errors' => [
            //         'required' => '{field} Harus di isi',
            //     ]
            // ],
            // 'pilihan3' => [
            //     'label'  => 'pilihan3',
            //     'rules'  => 'required',
            //     'errors' => [
            //         'required' => '{field} Harus di isi',
            //     ]
            // ],
            // 'pilihan4' => [
            //     'label'  => 'pilihan4',
            //     'rules'  => 'required',
            //     'errors' => [
            //         'required' => '{field} Harus di isi',
            //     ]
            // ],
            // 'pilihan5' => [
            //     'label'  => 'pilihan5',
            //     'rules'  => 'required',
            //     'errors' => [
            //         'required' => '{field} Harus di isi',
            //     ]
            // ],
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
        $dataSoalq = $this->SoalqModel->find($this->request->getVar('id_soalq'));
        $uploadimage = $this->request->getFile('image');
        if ($this->request->getVar('deleteImage')) {
            if ($dataSoalq['image']) {
                try {
                    unlink('assets/image/soalquiz/' . $dataSoalq['image']);
                } catch (\Throwable $th) {
                }
            }
            $nameimage = '';
        } else {
            if ($uploadimage->getError() === 4) {
                if ($dataSoalq['image']) {
                    $nameimage = $dataSoalq['image'];
                } else {
                    $nameimage = '';
                }
            } else {
                $nameimage = $uploadimage->getRandomName();
                $uploadimage->move('assets/image/soalquiz', $nameimage);
                if ($dataSoalq['image']) {
                    try {
                        unlink('assets/image/soalquiz/' . $dataSoalq['image']);
                    } catch (\Throwable $th) {
                    }
                }
            }
        }
        $uploadimage = $this->request->getFile('imagepembahasan');
        if ($this->request->getVar('deleteImagePembahasan')) {
            if ($dataSoalq['imagepembahasan']) {
                try {
                    unlink('assets/image/soalquiz/' . $dataSoalq['imagepembahasan']);
                } catch (\Throwable $th) {
                }
            }
            $nameimagepembahasan = '';
        } else {
            if ($uploadimage->getError() === 4) {
                if ($dataSoalq['imagepembahasan']) {
                    $nameimagepembahasan = $dataSoalq['imagepembahasan'];
                } else {
                    $nameimagepembahasan = '';
                }
            } else {
                $nameimagepembahasan = $uploadimage->getRandomName();
                $uploadimage->move('assets/image/soalquiz', $nameimagepembahasan);
                if ($dataSoalq['imagepembahasan']) {
                    try {
                        unlink('assets/image/soalquiz/' . $dataSoalq['imagepembahasan']);
                    } catch (\Throwable $th) {
                    }
                }
            }
        }
        $nameimagepilihan = array();
        foreach (abjad() as $key => $value) {
            $uploadimage = $this->request->getFile('imagepilihan' . $value[0]);
            if ($this->request->getVar('deleteimagepilihan' . $value[0])) {
                if ($dataSoalq['imagepilihan' . $value[0]]) {
                    try {
                        unlink('assets/image/soalquiz/' . $dataSoalq['imagepilihan' . $value[0]]);
                    } catch (\Throwable $th) {
                    }
                }
                $nameimagepilihan[$key] = '';
            } else {
                if ($uploadimage->getError() === 4) {
                    if ($dataSoalq['imagepilihan' . $value[0]]) {
                        $nameimagepilihan[$key] = $dataSoalq['imagepilihan' . $value[0]];
                    } else {
                        $nameimagepilihan[$key] = '';
                    }
                } else {
                    $nameimagepilihan[$key] = $uploadimage->getRandomName();
                    $uploadimage->move('assets/image/soalquiz', $nameimagepilihan[$key]);
                    if ($dataSoalq['imagepilihan' . $value[0]]) {
                        try {
                            unlink('assets/image/soalquiz/' . $dataSoalq['imagepilihan' . $value[0]]);
                        } catch (\Throwable $th) {
                        }
                    }
                }
            }
        }
        $data = [
            'id_soalq' => $this->request->getVar('id_soalq'),
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
        $data['updated_by'] = user_id();
        $this->SoalqModel->save($data);
        $this->session->setFlashdata('message', 'Soal ' . $noSoal . ' Berhasil di update');
        return  redirect()->to($_SERVER['HTTP_REFERER']);
    }
    public function toogleActive($id)
    {
        $item = $this->QuizModel->find($id);
        $data = [
            'active' => $item['active'] ? 0 : 1
        ];
        $message = $item['active'] ? "Dinonaktifkan" : "Diaktifkan";
        try {
            $this->QuizModel->update($id, $data);
            $data = [
                'message' => "Quiz : " . $item['name'] . " Berhasil " . $message,
            ];
        } catch (Exception $e) {
        }
        echo "Quiz : " . $item['name'] . " Berhasil " . $message;
    }
    public function listdata()
    {

        $request = \Config\Services::request();
        $list_data = $this->serverside_model;
        $where = NULL;
        $column_order = array(NULL, 'tbl_quiz.name', 'tbl_quiz.date_start', 'tbl_quiz.time_start', 'tbl_quiz.date_end', 'tbl_quiz.time_end', 'tbl_quiz.class', 'tbl_quiz.mapel', 'tbl_quiz.t_mapel', 'tbl_quiz.kuota', 'tbl_quiz.created_by', 'tbl_quiz.updated_by', 'tbl_quiz.created_at', 'tbl_quiz.updated_at', NULL);
        $column_search = array('tbl_quiz.name', 'tbl_quiz.date_start', 'tbl_quiz.time_start', 'tbl_quiz.date_end', 'tbl_quiz.time_end', 'tbl_quiz.class', 'tbl_quiz.mapel', 'tbl_quiz.t_mapel', 'tbl_quiz.kuota', 'tbl_quiz.created_by', 'tbl_quiz.updated_by', 'tbl_quiz.created_at', 'tbl_quiz.updated_at');
        $order = array('tbl_quiz.created_at' => 'asc');
        $list = $list_data->get_datatables('tbl_quiz', $column_order, $column_search, $order, $where);
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
            $row[] = classQuiz($lists->class);
            $row[] = allMapel($lists->mapel);
            $row[] = $lists->t_mapel;
            $row[] = $lists->kuota;
            $switch = '<label class="switch ">';
            $switch .= '<input type="checkbox" class="primary toogleActive" idto="' . $lists->id_quiz . '" nameto="' . $lists->name . '" active="' . $lists->active . '"';
            $switch .= $lists->active ? 'checked' : '';
            $switch .= '/>';
            $switch .= '<span class="slider round"></span>';
            $switch .= '</label>';
            $row[] = $switch;
            $row[] = $this->UserModel->find($lists->created_by)->email;
            $row[] = $this->UserModel->find($lists->updated_by)->email;
            $row[] = $lists->created_at;
            $row[] = $lists->updated_at;
            $row[] = '<a href="' . base_url('admincamakara/quiz/submitted/' . $lists->id_quiz) . '" class="badge badge-info">Pengumpulan</a> <a href="' . base_url('admincamakara/quiz/detail/' . $lists->id_quiz) . '" class="badge badge-primary">Detail</a>
            <a href="' . base_url('admincamakara/quiz/edit/' . $lists->id_quiz) . '" class="badge badge-warning">Edit</a>
            <a href="' . base_url('admincamakara/quiz/delete/' . $lists->id_quiz) . '" class="badge badge-danger">Hapus</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('tbl_quiz', $where),
            "recordsFiltered" => $list_data->count_filtered('tbl_quiz', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        return json_encode($output);
    }
    public function listdatasubmitted($id = NULL)
    {
        $request = \Config\Services::request();
        $list_data = $this->serverside_model;
        $where = ['tbl_myquiz.quiz_id =' => $id];
        $column_order = array(NULL, 'tbl_myquiz.quiz_id', 'tbl_myquiz.user_id', 'tbl_myquiz.finish', 'tbl_myquiz.price');
        $column_search = array('tbl_myquiz.quiz_id', 'tbl_myquiz.user_id', 'tbl_myquiz.finish', 'tbl_myquiz.price');
        $order = array('tbl_myquiz.created_at' => 'asc');
        $list = $list_data->get_datatables('tbl_myquiz', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $this->QuizModel->find($lists->quiz_id)['name'];
            $row[] = $this->UserapiModel->find($lists->user_id)['fullname'];
            $row[] = $lists->finish ? '<span class="badge badge-success">Sudah Mengerjakan</span>' : '<span class="badge badge-danger">Belum Mengerjakan</span>';
            $row[] = $lists->price ? $lists->price : 0;
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('tbl_myquiz', $where),
            "recordsFiltered" => $list_data->count_filtered('tbl_myquiz', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        return json_encode($output);
    }
}
