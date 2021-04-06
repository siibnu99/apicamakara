<?php

namespace App\Controllers;

class Quiz extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'quiz',
            'Quiz' => $this->QuizModel->findALL(),
            'usermodel' => $this->UserModel,
        ];
        return view('quiz/index', $data);
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
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
        return redirect()->to(base_url('quiz'));
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        $rData = $this->QuizModel->find($id);
        $uploadimage = $this->request->getFile('image');
        if ($uploadimage->getError() === 4) {
            $nameimage = $rData['image'];
        } else {
            $nameimage = $uploadimage->getRandomName();
            $uploadimage->move('assets/image/quiz', $nameimage);
            unlink('assets/image/quiz/' . $rData['image']);
        }
        $data = $this->request->getVar();
        $data['image'] = $nameimage;
        $data['updated_by'] = user_id();
        $this->QuizModel->update($id, $data);
        $this->session->setFlashdata('message', 'Quiz ' . $data['name'] . ' Berhasil diedit');
        return redirect()->to(base_url('quiz'));
    }
    public function delete($id)
    {
        $rData = $this->QuizModel->find($id);
        unlink('assets/image/quiz/' . $rData['image']);
        $this->QuizModel->delete($id);
        $this->session->setFlashdata('message', 'Quiz ' . $rData['name'] . '  Berhasil dihapus');
        return redirect()->to(base_url('quiz'));
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        $dataSoalq = $this->SoalqModel->find($this->request->getVar('id_soalq'));
        $uploadimage = $this->request->getFile('image');
        if ($this->request->getVar('deleteImage')) {
            if ($dataSoalq['image']) {
                unlink('assets/image/soalquiz/' . $dataSoalq['image']);
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
                    unlink('assets/image/soalquiz/' . $dataSoalq['image']);
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
            'jawaban' => $this->request->getVar('jawaban'),
            'pembahasan' => $this->request->getVar('pembahasan'),
        ];
        $data['updated_by'] = user_id();
        $this->SoalqModel->save($data);
        $this->session->setFlashdata('message', 'Soal ' . $noSoal . ' Berhasil di update');
        return  redirect()->back();
    }
    public function editbobot($id, $idSoal)
    {
        $dataSoalt = $this->SoaltModel->where(['tryout_id' => $id, 'kind_tryout' => $idSoal])->first();
        if (!$dataSoalt) {
            $this->session->setFlashdata('message', 'Soal belum ada, tidak bisa edit bobot');
            return redirect()->back();
        }
        $idSoalt = $dataSoalt['id_soalt'];
        $data = [
            'title' => 'tryout',
            'validation' => \Config\Services::validation(),
            'tryout' => $this->TryoutModel->find($id),
            'soalt' => $this->SoaltModel->where(['tryout_id' => $id, 'kind_tryout' => $idSoal])->orderBy('no_soal', 'ASC')->findAll(),
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
            d($data);
        }
        $datas['updated_by'] = user_id();
        $this->QuizModel->update($id, $datas);
        $this->session->setFlashdata('message', 'Soal  Berhasil di update');
        return  redirect()->to(base_url('tryout/detail/' . $id));
    }
}
