<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat Quiz</h1>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Nama Quiz</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('name')) ? 'is-invalid' : "" ?>" name="name" value="<?= old('name') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi Quiz</label>
                        <textarea type="text" class="form-control  <?= ($validation->hasError('descript')) ? 'is-invalid' : "" ?>" name="descript" rows="3"><?= old('descript') ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('descript') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar Tryout</label>
                        <input type="file" id="sampul" class="form-control <?= ($validation->hasError('image')) ? 'is-invalid' : "" ?>" name="image" onchange="previewImg()">
                        <div class="invalid-feedback">
                            <?= $validation->getError('image') ?>
                        </div>
                    </div>
                    <div class="ml-2 col-sm-6">
                        <img src="https://placehold.it/80x80" id="preview" class="img-thumbnail">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" class="form-control  <?= ($validation->hasError('date_start')) ? 'is-invalid' : "" ?>" name="date_start" value="<?= old('date_start') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('date_start') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Waktu Mulai</label>
                                <input type="time" class="form-control  <?= ($validation->hasError('time_start')) ? 'is-invalid' : "" ?>" name="time_start" value="<?= old('time_start') ?>">
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
                                <input type="date" class="form-control  <?= ($validation->hasError('date_end')) ? 'is-invalid' : "" ?>" name="date_end" value="<?= old('date_end') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('date_end') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Waktu Selesai</label>
                                <input type="time" class="form-control  <?= ($validation->hasError('time_end')) ? 'is-invalid' : "" ?>" name="time_end" value="<?= old('time_end') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('time_end') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kelas Quiz</label>
                        <select class="custom-select" id="jenis_tryout" name="class">
                            <option value="0" selected disabled>Pilihan</option>
                            <?php
                            foreach (classQuiz() as $item) : ?>
                                <option value="<?= $item['1'] ?>" <?= old('class') ==  $item['1']  ? 'selected'  : ''  ?>><?= $item['0'] ?></option>
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
                                <option value="<?= $item['1'] ?>" <?= old('mapel') ==  $item['1']  ? 'selected'  : ''  ?>><?= $item['0'] ?></option>
                            <?php endforeach
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Banyak Soal</label>
                        <input type="number" class="form-control  <?= ($validation->hasError('q_mapel')) ? 'is-invalid' : "" ?>" name="q_mapel" value="<?= old('q_mapel') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('q_mapel') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Waktu Pengerjaan (Menit)</label>
                        <input type="number" class="form-control  <?= ($validation->hasError('t_mapel')) ? 'is-invalid' : "" ?>" name="t_mapel" value="<?= old('t_mapel') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('t_mapel') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kuota</label>
                        <input type="number" class="form-control  <?= ($validation->hasError('kuota')) ? 'is-invalid' : "" ?>" name="kuota" value="<?= old('kuota') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('kuota') ?>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Online Meetings</label>
                        <select class="custom-select" id="jenis_tryout" name="media">
                            <option value="0" disabled>Pilihan</option>
                            <?php
                            foreach (mediaQuiz() as $item) : ?>
                                <option value="<?= $item['1'] ?>" <?= old('media') ==  $item['1']  ? 'selected'  : ''  ?>><?= $item['0'] ?></option>
                            <?php endforeach
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Direct Link</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('link')) ? 'is-invalid' : "" ?>" name="link" value="<?= old('link') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('link') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Paasword</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : "" ?>" name="password" value="<?= old('password') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" class="form-control  <?= ($validation->hasError('date_start_m')) ? 'is-invalid' : "" ?>" name="date_start_m" value="<?= old('date_start_m') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('date_start_m') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Waktu Mulai</label>
                                <input type="time" class="form-control  <?= ($validation->hasError('time_start_m')) ? 'is-invalid' : "" ?>" name="time_start_m" value="<?= old('time_start_m') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('time_start_m') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
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