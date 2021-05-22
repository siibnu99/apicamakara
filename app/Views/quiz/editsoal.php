<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<?php
$no = 1; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit <?= allMapel($quiz['mapel']) ?></h1>
    <a type="button" class="btn btn-primary" href="<?= base_url("quiz/detail") . '/' . $id ?>">Kembali</a>
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
        <form enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id_soalq" value="<?= $idSoalq ?>">
            <div class="form-group">
                <?= $validation->listErrors() ?>
                <label for="soal">Soal <?= $noSoal ?></label>
                <textarea type="text" class="form-control <?= ($validation->hasError('soal')) ? 'is-invalid' : "" ?>" id="soal" name="soal" rows="5"><?= old('soal') ? old('soal') : $soalq['soal'] ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('pembahasan') ?>
                </div>
            </div>
            <div class="ml-2 col-sm-6">
                <?php
                if ($soalq['image']) : ?>
                    <img src="<?= base_url() . '/assets/image/soalquiz/' . $soalq['image']   ?>" id="preview" class="img-thumbnail">
                <?php else : ?>
                    <img src="https://placehold.it/80x80" id="preview" class="img-thumbnail">
                <?php endif
                ?>
            </div>
            <div class="form-group">
                <label for="">Gambar Soal <?= $noSoal ?></label>
                <input type="file" id="sampul" class="form-control <?= ($validation->hasError('image')) ? 'is-invalid' : "" ?>" name="image" onchange="previewImg()">
                <div class="invalid-feedback">
                    <?= $validation->getError('image') ?>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="defaultCheck1" name="deleteImage" value="1">
                <label class="form-check-label" for="defaultCheck1">
                    Kosongkan gambar
                </label>
            </div>
            <div class="form-group">
                <label for="">Pilihan Jawaban</label>
                <div class="form-group">
                    <label for="">Pilihan 1</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan1')) ? 'is-invalid' : "" ?>" name="pilihan1" value="<?= old('pilihan1') ? old('pilihan1') : $soalq['pilihan1'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan1') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Pilihan 2</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan2')) ? 'is-invalid' : "" ?>" name="pilihan2" value="<?= old('pilihan2') ? old('pilihan2') : $soalq['pilihan2'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan2') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Pilihan 3</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan3')) ? 'is-invalid' : "" ?>" name="pilihan3" value="<?= old('pilihan3') ? old('pilihan3') : $soalq['pilihan3'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan3') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Pilihan 4</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan4')) ? 'is-invalid' : "" ?>" name="pilihan4" value="<?= old('pilihan4') ? old('pilihan4') : $soalq['pilihan4'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan4') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Pilihan 5</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan5')) ? 'is-invalid' : "" ?>" name="pilihan5" value="<?= old('pilihan5') ? old('pilihan5') : $soalq['pilihan5'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan5') ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Jawaban Benar</label>
                <?php
                $jawaban = (int) old('jawaban') ? old('jawaban') : $soalq['jawaban'];
                ?>
                <select class="custom-select <?= ($validation->hasError('jawaban')) ? 'is-invalid' : "" ?>" id="jawaban_benar" name="jawaban">
                    <option disabled>Pilihan</option>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <option value="<?= $i ?>" <?= $jawaban == $i ? 'selected' : '' ?>>Pilihan <?= $i ?></option>
                    <?php
                    endfor
                    ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('jawaban') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="soal">Pembahasan Soal <?= $noSoal ?></label>
                <textarea type="text" class="form-control <?= ($validation->hasError('pembahasan')) ? 'is-invalid' : "" ?>" id="soal" name="pembahasan" rows="5"><?= old('pembahasan') ? old('pembahasan') : $soalq['pembahasan'] ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('pembahasan') ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card" id="navigasi-soal">
            <div class="card-body">
                <?php for ($i = 1; $i <= $quiz['q_mapel']; $i++) : ?>
                    <a href="<?= base_url('quiz') . "/editsoal/" . $id . '/'  . $i ?>" class="box <?= $i == $noSoal ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor
                ?>
            </div>
        </div>
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