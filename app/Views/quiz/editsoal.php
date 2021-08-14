<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<?php
$no = 1; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit <?= allMapel($quiz['mapel']) ?></h1>
    <a type="button" class="btn btn-primary" href="<?= base_url("admincamakara/quiz/detail") . '/' . $id ?>">Kembali</a>
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
                    <img src="<?= base_url() . '/assets/image/soalquiz/' . $soalq['image']   ?>" id="preview" class="img-thumbnail" alt="">
                <?php else : ?>
                    <img src="https://placehold.it/80x80" id="preview" class="img-thumbnail" alt="">
                <?php endif
                ?>
            </div>
            <div class="form-group">
                <label for="">Gambar Soal <?= $noSoal ?></label>
                <input type="file" id="sampul" class="form-control <?= ($validation->hasError('image')) ? 'is-invalid' : "" ?>" name="image" onchange="previewImg('#sampul','#preview')">
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
                <?php foreach (abjad() as $key => $value) : ?>
                    <div class=" border border-dark my-2 p-2 rounded-sm">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Pilihan <?= $value[1] ?></label>
                                <textarea type="text" class="form-control <?= ($validation->hasError('pilihan' . $value[0])) ? 'is-invalid' : "" ?>" name="pilihan<?= $value[0] ?>" id="editor<?= $value[0] ?>"><?= htmlspecialchars_decode(old('pilihan' . $value[0]) ? old('pilihan' . $value[0]) : $soalq['pilihan' . $value[0]]) ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('pilihan' . $value[0]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="ml-2 col-sm-6">
                            <?php
                            if ($soalq['imagepilihan' . $value[0]]) : ?>
                                <img src="<?= base_url() . '/assets/image/soalquiz/' . $soalq['imagepilihan' . $value[0]]   ?>" id="preview<?= $value[0] ?>" class="img-thumbnail" alt="">
                            <?php else : ?>
                                <img src="https://placehold.it/80x80" id="preview<?= $value[0] ?>" class="img-thumbnail" alt="">
                            <?php endif
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">Gambar Pilihan <?= $value[0] ?></label>
                            <input type="file" id="sampul<?= $value[0] ?>" class="form-control <?= ($validation->hasError('imagepilihan' . $value[0])) ? 'is-invalid' : "" ?>" name="imagepilihan<?= $value[0] ?>" onchange="previewImg('#sampul<?= $value[0] ?>','#preview<?= $value[0] ?>')">
                            <div class="invalid-feedback">
                                <?= $validation->getError('imagepilihan' . $value[0]) ?>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="defaultCheck2" name="deleteimagepilihan<?= $value[0] ?>" value="1">
                            <label class="form-check-label" for="defaultCheck2">
                                Kosongkan gambar
                            </label>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="form-group">
                <label>Jawaban Benar</label>
                <?php
                $jawaban = (int) old('jawaban') ? old('jawaban') : $soalq['jawaban'];
                ?>
                <select class="custom-select <?= ($validation->hasError('jawaban')) ? 'is-invalid' : "" ?>" id="jawaban_benar" name="jawaban">
                    <option disabled>Pilihan</option>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <option value="<?= $i ?>" <?= $jawaban == $i ? 'selected' : '' ?>><?= abjad($i) ?></option>
                    <?php
                    endfor
                    ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('jawaban') ?>
                </div>
            </div>
            <div class="ml-2 col-sm-6">
                <?php
                if (isset($soalq['imagepembahasan'])) : ?>
                    <img src="<?= base_url() . '/assets/image/soalquiz/' . $soalq['imagepembahasan']   ?>" id="previewpembahasan" class="img-thumbnail" alt="">
                <?php else : ?>
                    <img src="http://placehold.it/80x80" id="previewpembahasan" class="img-thumbnail" alt="">
                <?php endif
                ?>
            </div>
            <div class="form-group">
                <label for="soal">Pembahasan Soal <?= $noSoal ?></label>
                <textarea type="text" class="form-control <?= ($validation->hasError('pembahasan')) ? 'is-invalid' : "" ?>" id="soal" name="pembahasan" rows="5"><?= old('pembahasan') ? old('pembahasan') : $soalq['pembahasan'] ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('pembahasan') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="">Gambar Pembahasan <?= $noSoal ?></label>
                <input type="file" id="sampulpembahasan" class="form-control <?= ($validation->hasError('imagepembahasan')) ? 'is-invalid' : "" ?>" name="imagepembahasan" onchange="previewImg('#sampulpembahasan','#previewpembahasan')">
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
                <?php for ($i = 1; $i <= $quiz['q_mapel']; $i++) : ?>
                    <a href="<?= base_url('admincamakara/quiz') . "/editsoal/" . $id . '/'  . $i ?>" class="box <?= $i == $noSoal ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor
                ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<script>
    function previewImg(from, target) {
        const input = document.querySelector(from);
        const imgPreview = document.querySelector(target);
        const fileSampul = new FileReader();
        fileSampul.readAsDataURL(input.files[0]);

        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?= $this->endsection() ?>