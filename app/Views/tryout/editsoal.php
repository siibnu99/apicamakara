<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<?php
$no = 1;
foreach (mapel($tryout['type_tryout'], $tryout) as $item) :
    if ($item[3] == $idSoal) {
        $dataMapel = $item;
    }
endforeach ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit <?= $dataMapel[0] ?></h1>
</div>
<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success" role="alert">
        <strong> <?= session()->getFlashdata('message') ?> </strong>
    </div>
<?php endif ?>
<div class="row">
    <div class="col-lg-8 col-md-12">
        <form enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id_soalt" value="<?= $idSoalt ?>">
            <div class="form-group">
                <?= $validation->listErrors() ?>
                <label for="soal">Soal <?= $noSoal ?></label>
                <textarea type="text" class="form-control <?= ($validation->hasError('soal')) ? 'is-invalid' : "" ?>" id="soal" name="soal" rows="5"><?= old('soal') ? old('soal') : $soalt['soal'] ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('pembahasan') ?>
                </div>
            </div>
            <div class="ml-2 col-sm-6">
                <?php
                if ($soalt['image']) : ?>
                    <img src="<?= base_url() . '/assets/image/soalTryout/' . $soalt['image']   ?>" id="preview" class="img-thumbnail">
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
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan1')) ? 'is-invalid' : "" ?>" name="pilihan1" value="<?= old('pilihan1') ? old('pilihan1') : $soalt['pilihan1'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan1') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Pilihan 2</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan2')) ? 'is-invalid' : "" ?>" name="pilihan2" value="<?= old('pilihan2') ? old('pilihan2') : $soalt['pilihan2'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan2') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Pilihan 3</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan3')) ? 'is-invalid' : "" ?>" name="pilihan3" value="<?= old('pilihan3') ? old('pilihan3') : $soalt['pilihan3'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan3') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Pilihan 4</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan4')) ? 'is-invalid' : "" ?>" name="pilihan4" value="<?= old('pilihan4') ? old('pilihan4') : $soalt['pilihan4'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan4') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Pilihan 5</label>
                    <input type="text" class="form-control <?= ($validation->hasError('pilihan5')) ? 'is-invalid' : "" ?>" name="pilihan5" value="<?= old('pilihan5') ? old('pilihan5') : $soalt['pilihan5'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('pilihan5') ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Jawaban Benar</label>
                <?php
                $jawaban = (int) old('jawaban') ? old('jawaban') : $soalt['jawaban'];
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
                <textarea type="text" class="form-control <?= ($validation->hasError('pembahasan')) ? 'is-invalid' : "" ?>" id="soal" name="pembahasan" rows="5"><?= old('pembahasan') ? old('pembahasan') : $soalt['pembahasan'] ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('pembahasan') ?>
                </div>
            </div>
            <div class="ml-2 col-sm-6">
                <?php
                if (isset($soalt['imagepembahasan'])) : ?>
                    <img src="<?= base_url() . '/assets/image/soalTryout/' . $soalt['imagepembahasan']   ?>" id="preview" class="img-thumbnail">
                <?php else : ?>
                    <img src="https://placehold.it/80x80" id="preview" class="img-thumbnail">
                <?php endif
                ?>
            </div>
            <div class="form-group">
                <label for="">Gambar Pembahasan <?= $noSoal ?></label>
                <input type="file" id="sampul" class="form-control <?= ($validation->hasError('imagepembahasan')) ? 'is-invalid' : "" ?>" name="imagepembahasan" onchange="previewImg()">
                <div class="invalid-feedback">
                    <?= $validation->getError('imagepembahasan') ?>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="defaultCheck2" name="deleteImagePembahasan" value="1">
                <label class="form-check-label" for="defaultCheck2">
                    Kosongkan gambar
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card" id="navigasi-soal">
            <div class="card-body">
                <?php for ($i = 1; $i <= $tryout[$idSoal]; $i++) : ?>
                    <a href="<?= base_url('tryout') . "/editsoal/" . $id . '/' . $idSoal . '/' . $i ?>" class="box <?= $i == $noSoal ? 'active' : '' ?>"><?= $i ?></a>
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