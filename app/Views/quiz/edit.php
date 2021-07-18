<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Quiz</h1>
    <a type="button" class="btn btn-primary" href="<?= base_url("admincamakara/quiz") ?>">Kembali</a>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Nama Quiz</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('name')) ? 'is-invalid' : "" ?>" name="name" value="<?= old('name') ? old('name') : $quiz['name'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi Quiz</label>
                        <textarea type="text" class="form-control  <?= ($validation->hasError('descript')) ? 'is-invalid' : "" ?>" name="descript" rows="3"><?= old('descript') ? old('descript') : $quiz['descript'] ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('descript') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar quiz</label>
                        <input type="file" id="sampul" class="form-control <?= ($validation->hasError('image')) ? 'is-invalid' : "" ?>" name="image" onchange="previewImg()">
                        <div class="invalid-feedback">
                            <?= $validation->getError('image') ?>
                        </div>
                    </div>
                    <div class="ml-2 col-sm-6">
                        <img src="<?= base_url('assets/image/quiz') . '/' . $quiz['image'] ?>" id="preview" class="img-thumbnail">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" class="form-control  <?= ($validation->hasError('date_start')) ? 'is-invalid' : "" ?>" name="date_start" value="<?= old('date_start') ? old('date_start') : $quiz['date_start'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('date_start') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Waktu Mulai</label>
                                <input type="time" class="form-control  <?= ($validation->hasError('time_start')) ? 'is-invalid' : "" ?>" name="time_start" value="<?= old('time_start') ? old('time_start') : $quiz['time_start'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('time_start') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Tanggal Selesai</label>
                                <input type="date" class="form-control  <?= ($validation->hasError('date_end')) ? 'is-invalid' : "" ?>" name="date_end" value="<?= old('date_end') ? old('date_end') : $quiz['date_end'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('date_end') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Waktu Selesai</label>
                                <input type="time" class="form-control  <?= ($validation->hasError('time_end')) ? 'is-invalid' : "" ?>" name="time_end" value="<?= old('time_end') ? old('time_end') : $quiz['time_end'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('time_end') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kelas Quiz</label>
                        <select class="custom-select" id="jenis_quiz" name="class">
                            <option value="0" selected disabled>Pilihan</option>
                            <?php
                            foreach (classQuiz() as $item) : ?>
                                <option value="<?= $item['1'] ?>" <?= (old('class') ? old('class') : $quiz['class']) ==  $item['1']  ? 'selected'  : ''  ?>><?= $item['0'] ?></option>
                            <?php endforeach
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Mata Pelajaran</label>
                        <select class="custom-select" id="metode_pembayaran" name="mapel">
                            <option value="0" selected disabled>Pilihan</option>
                            <?php
                            foreach (allMapel() as $item) : ?>
                                <option value="<?= $item['1'] ?>" <?= (old('mapel') ? old('mapel') : $quiz['mapel']) ==  $item['1']  ? 'selected'  : ''  ?>><?= $item['0'] ?></option>
                            <?php endforeach
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Banyak Soal</label>
                        <input type="number" class="form-control  <?= ($validation->hasError('q_mapel')) ? 'is-invalid' : "" ?>" name="q_mapel" value="<?= old('q_mapel') ? old('q_mapel') : $quiz['q_mapel'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('q_mapel') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Waktu Pengerjaan (Menit)</label>
                        <input type="number" class="form-control  <?= ($validation->hasError('t_mapel')) ? 'is-invalid' : "" ?>" name="t_mapel" value="<?= old('t_mapel') ? old('t_mapel') : $quiz['t_mapel'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('t_mapel') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kuota</label>
                        <input type="number" class="form-control  <?= ($validation->hasError('kuota')) ? 'is-invalid' : "" ?>" name="kuota" value="<?= old('kuota') ? old('kuota') : $quiz['kuota'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('kuota') ?>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Online Meetings</label>
                        <select class="custom-select" id="jenis_quiz" name="media">
                            <option value="0" disabled>Pilihan</option>
                            <?php
                            foreach (mediaQuiz() as $item) : ?>
                                <option value="<?= $item['1'] ?>" <?= (old('media') ? old('media') : $quiz['media']) ==  $item['1']  ? 'selected'  : ''  ?>><?= $item['0'] ?></option>
                            <?php endforeach
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Direct Link</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('link')) ? 'is-invalid' : "" ?>" name="link" value="<?= old('link') ? old('link') : $quiz['link'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('link') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Paasword</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : "" ?>" name="password" value="<?= old('password') ? old('password') : $quiz['password'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" class="form-control  <?= ($validation->hasError('date_start_m')) ? 'is-invalid' : "" ?>" name="date_start_m" value="<?= old('date_start_m') ? old('date_start_m') : $quiz['date_start_m'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('date_start_m') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Waktu Mulai</label>
                                <input type="time" class="form-control  <?= ($validation->hasError('time_start_m')) ? 'is-invalid' : "" ?>" name="time_start_m" value="<?= old('time_start') ? old('time_start') : $quiz['time_start'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('time_start_m') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ml-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<script>
    function previewImg() {
        const sampul = document.querySelector('#sampul');
        const imgPreview = document.querySelector('#preview');

        const fileSampul = new FileReader();
        fileSampul.readAsDataURL(sampul.files[0]);

        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>

<?= $this->endsection() ?>