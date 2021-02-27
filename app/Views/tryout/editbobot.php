<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<?php
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Bobot Penalaran Umum</h1>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <form method="POST">
            <?php foreach ($soalt as $item) : ?>
                <input type="hidden" name="id<?= $item['no_soal'] ?>" value="<?= $item['id_soalt'] ?>">
                <div class="form-group">
                    <label for="soal">Bobot <?= $item['no_soal'] ?></label>
                    <input type="text" name="<?= $item['no_soal'] ?>" class="form-control" value="<?= old($item['no_soal']) ? old($item['no_soal']) : $item['bobot'] ?>">
                </div>
            <?php endforeach
            ?>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<?= $this->endsection() ?>