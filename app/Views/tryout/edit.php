<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Tryout</h1>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <form action="" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Nama Tryout</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('name')) ? 'is-invalid' : "" ?>" name="name" value="<?= old('name') ? old('name') : $tryout['name'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi Tryout</label>
                        <textarea type="text" class="form-control  <?= ($validation->hasError('descript')) ? 'is-invalid' : "" ?>" name="descript" rows="3"><?= old('descript') ? old('descript') : $tryout['descript'] ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('descript') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar Soal</label>
                        <input type="file" id="sampul" class="form-control <?= ($validation->hasError('image')) ? 'is-invalid' : "" ?>" name="image" onchange="previewImg()">
                        <div class="invalid-feedback">
                            <?= $validation->getError('image') ?>
                        </div>
                    </div>
                    <div class="ml-2 col-sm-6">
                        <img src="<?= base_url() . '/assets/image/tryout/' . $tryout['image']   ?>" id="preview" class="img-thumbnail">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" class="form-control  <?= ($validation->hasError('date_start')) ? 'is-invalid' : "" ?>" name="date_start" value="<?= old('date_start') ? old('date_start') : $tryout['date_start'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('date_start') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Waktu Mulai</label>
                                <input type="time" class="form-control  <?= ($validation->hasError('time_start')) ? 'is-invalid' : "" ?>" name="time_start" value="<?= old('time_start') ? old('time_start') : $tryout['time_start'] ?>">
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
                                <input type="date" class="form-control  <?= ($validation->hasError('date_end')) ? 'is-invalid' : "" ?>" name="date_end" value="<?= old('date_end') ? old('date_end') : $tryout['date_end'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('date_end') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Waktu Selesai</label>
                                <input type="time" class="form-control  <?= ($validation->hasError('time_end')) ? 'is-invalid' : "" ?>" name="time_end" value="<?= old('time_end') ? old('time_end') : $tryout['time_end'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('time_end') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Tryout</label>
                        <select class="custom-select <?= ($validation->hasError('type_tryout')) ? 'is-invalid' : "" ?>" id="jenis_tryout" name="type_tryout">
                            <option selected disabled>Pilihan</option>
                            <?php
                            foreach (jenisTryout() as $item) : ?>
                                <option value="<?= $item['1'] ?>" <?= (old('type_tryout') ? old('type_tryout') : $tryout['type_tryout']) ==  $item['1']  ? 'selected'  : ''  ?>><?= $item['0'] ?></option>

                            <?php endforeach
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('type_tryout') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori Tryout</label>
                        <div class="form-check">

                            <?php $j = 1;
                            foreach (catTryout() as $item) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cat_tryout" id="exampleRadios<?= $j ?>" value="<?= $item['1'] ?>" <?= catTryoutChecked(str_split($tryout['cat_tryout']), $item['1']) ?>>
                                    <label class="form-check-label" for="exampleRadios<?= $j ?>">
                                        <?= $item['0'] ?>
                                    </label>
                                </div>
                            <?php $j++;
                            endforeach
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Metode Pembayaran</label>
                        <select class="custom-select" name="payment_method" id="metode_pembayaran">
                            <option disabled>Pilihan</option>
                            <?php
                            foreach (paymentMethod() as $item) : ?>
                                <option value="<?= $item[1] ?>" <?= $tryout['payment_method'] == $item[1] ? 'selected' : '' ?>><?= $item[0] ?></option>
                            <?php
                            endforeach
                            ?>
                        </select>
                    </div>
                    <div class="syarat-pembayaran-gratis">
                        <div class="form-group">
                            <label for="">Persyaratan 1</label>
                            <input type="text" class="form-control" placeholder="Follow IG Camakara" name="rule1" value="<?= old('rule1') ? old('rule1') : $tryout['rule1'] ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('rule1') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Persyaratan 2</label>
                            <input type="text" class="form-control" placeholder="" name="rule2" value="<?= old('rule2') ? old('rule2') : $tryout['rule2'] ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('rule2') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Persyaratan 3</label>
                            <input type="text" class="form-control" placeholder="" name="rule3" value="<?= old('rule3') ? old('rule3') : $tryout['rule3'] ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('rule3') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Persyaratan 4</label>
                            <input type="text" class="form-control" placeholder="" name="rule4" value="<?= old('rule4') ? old('rule4') : $tryout['rule4'] ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('rule4') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Persyaratan 5</label>
                            <input type="text" class="form-control" placeholder="" name="rule5" value="<?= old('rule5') ? old('rule5') : $tryout['rule5'] ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('rule5') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Harga Tryout</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('price')) ? 'is-invalid' : "" ?>" name="price" value="<?= old('price') ? old('price') : $tryout['price'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('price') ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="tps">
                        <div class="form-group">
                            <label for="">Penalaran Umum</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_penalaran" value="<?= old('q_penalaran') ? old('q_penalaran') : $tryout['q_penalaran'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_penalaran" value="<?= old('t_penalaran') ? old('t_penalaran') : $tryout['t_penalaran'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Pemahaman Bacaan dan Menulis</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_pemahaman" value="<?= old('q_pemahaman') ? old('q_pemahaman') : $tryout['q_pemahaman'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_pemahaman" value="<?= old('t_pemahaman') ? old('t_pemahaman') : $tryout['t_pemahaman'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Pengetahuan dan Pemahaman Umum</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_pengetahuan" value="<?= old('q_pengetahuan') ? old('q_pengetahuan') : $tryout['q_pengetahuan'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_pengetahuan" value="<?= old('t_pengetahuan') ? old('t_pengetahuan') : $tryout['t_pengetahuan'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Pengetahuan Kuantitatif</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_pengetahuank" value="<?= old('q_pengetahuank') ? old('q_pengetahuank') : $tryout['q_pengetahuank'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_pengetahuank" value="<?= old('t_pengetahuank') ? old('t_pengetahuank') : $tryout['t_pengetahuank'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tka-saintek">
                        <div class="form-group">
                            <label for="">Kimia</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_kimia" value="<?= old('q_kimia') ? old('q_kimia') : $tryout['q_kimia'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_kimia" value="<?= old('t_kimia') ? old('t_kimia') : $tryout['t_kimia'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Fisika</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_fisika" value="<?= old('q_fisika') ? old('q_fisika') : $tryout['q_fisika'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_fisika" value="<?= old('t_fisika') ? old('t_fisika') : $tryout['t_fisika'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Biologi</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_biologi" value="<?= old('q_biologi') ? old('q_biologi') : $tryout['q_biologi'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_biologi" value="<?= old('t_biologi') ? old('t_biologi') : $tryout['t_biologi'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Matematika</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_matematika" value="<?= old('q_matematika') ? old('q_matematika') : $tryout['q_matematika'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_matematika" value="<?= old('t_matematika') ? old('t_matematika') : $tryout['t_matematika'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tka-soshum">
                        <div class="form-group">
                            <label for="">Sejarah</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_sejarah" value="<?= old('q_sejarah') ? old('q_sejarah') : $tryout['q_sejarah'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_sejarah" value="<?= old('t_sejarah') ? old('t_sejarah') : $tryout['t_sejarah'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Geografi</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_geografi" value="<?= old('q_geografi') ? old('q_geografi') : $tryout['q_geografi'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_geografi" value="<?= old('t_geografi') ? old('t_geografi') : $tryout['t_geografi'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Sosiologi</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_sosiologi" value="<?= old('q_sosiologi') ? old('q_sosiologi') : $tryout['q_sosiologi'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_sosiologi" value="<?= old('t_sosiologi') ? old('t_sosiologi') : $tryout['t_sosiologi'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Ekonomi</label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Jumlah Soal</label>
                                    <input class="form-control" type="number" name="q_ekonomi" value="<?= old('q_ekonomi') ? old('q_ekonomi') : $tryout['q_ekonomi'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="">Waktu Pengerjaan</label>
                                    <input class="form-control" type="number" placeholder="(menit)" name="t_ekonomi" value="<?= old('t_ekonomi') ? old('t_ekonomi') : $tryout['t_ekonomi'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?= $this->endsection() ?>
<?= $this->section('script') ?>
<script>
    if ($('#jenis_tryout option:selected').attr("value") == 1) {
        $('.tps').show()
        $('.tka-saintek').show()
        $('.tka-soshum').hide()
    } else if ($('#jenis_tryout option:selected').attr("value") == 2) {
        $('.tps').show()
        $('.tka-saintek').hide()
        $('.tka-soshum').show()
    }

    $('#jenis_tryout').on('change', function() {
        if ($('#jenis_tryout option:selected').attr("value") == 1) {
            $('.tps').show()
            $('.tka-saintek').show()
            $('.tka-soshum').hide()
        } else if ($('#jenis_tryout option:selected').attr("value") == 2) {
            $('.tps').show()
            $('.tka-saintek').hide()
            $('.tka-soshum').show()
        }
    })


    $('.syarat-pembayaran-gratis').hide();
    $('#metode_pembayaran').on('change', function() {
        if ($('#metode_pembayaran option:selected').attr("value") == 1) {
            $('.syarat-pembayaran-gratis').show();
        } else if ($('#metode_pembayaran option:selected').attr("value") == 2) {
            $('.syarat-pembayaran-gratis').hide();
        } else if ($('#metode_pembayaran option:selected').attr("value") == 3) {
            $('.syarat-pembayaran-gratis').hide();
        }
    })
    if ($('#metode_pembayaran option:selected').attr("value") == 1) {
        $('.syarat-pembayaran-gratis').show();
    } else if ($('#metode_pembayaran option:selected').attr("value") == 2) {
        $('.syarat-pembayaran-gratis').hide();
    } else if ($('#metode_pembayaran option:selected').attr("value") == 3) {
        $('.syarat-pembayaran-gratis').hide();
    }

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