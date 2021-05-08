<?php

namespace App\Controllers;

use Exception;
use JsonException;

class Tryout extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'tryout',
            'Tryout' => $this->TryoutModel->orderBy('created_at', 'DESC')->findALL(),
            'usermodel' => $this->UserModel,
        ];
        return view('tryout/index', $data);
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
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
        return redirect()->to(base_url('tryout'));
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
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
        return redirect()->to(base_url('tryout'));
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
        return redirect()->to(base_url('tryout'));
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
            'jawaban' => $this->request->getVar('jawaban'),
            'pembahasan' => $this->request->getVar('pembahasan'),
            'imagepembahasan' => $nameimagepembahasan,
        ];
        $this->SoaltModel->save($data);
        $datas['updated_by'] = user_id();
        $this->TryoutModel->update($id, $datas);
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
        return  redirect()->to(base_url('tryout/detail/' . $id));
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
}
