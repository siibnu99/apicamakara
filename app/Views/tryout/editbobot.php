<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<?php
function getAnswer($noSoal, $dataAnswer, $soalt)
{
    $amountAnswer = 0;
    $amountAnswerCorrect = 0;
    foreach ($dataAnswer as $item) {
        $arr = explode(',', $item['answer']);
        try {
            if ($arr[$noSoal - 1] != 0) {
                $amountAnswer++;
                foreach ($soalt as $item1) {
                    if ($arr[$noSoal - 1] == $item1['jawaban']  && $item1['no_soal'] == $noSoal) {
                        $amountAnswerCorrect++;
                    }
                }
            }
        } catch (\Throwable $th) {
        }
    }
    $result = [$amountAnswer, $amountAnswerCorrect];
    return $result;
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Bobot <?= $title ?></h1>
    <a type="button" class="btn btn-primary" href="<?= base_url('admincamakara/tryout/detail/' . $id) ?>">Kembali</a>
</div>
<div class="alert alert-info" role="alert">
    <strong>Total yang mengerjakan Tryout : <?= count($dataAnswer) ?></strong>
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
        <form method="POST">
            <?php foreach ($soalt as $item) : ?>
                <input type="hidden" name="id<?= $item['no_soal'] ?>" value="<?= $item['id_soalt'] ?>">
                <div class="form-group">
                    <label for="soal">Bobot <?= $item['no_soal'] ?> <span class="badge badge-warning"><?= getAnswer($item['no_soal'], $dataAnswer, $soalt)[1] ?> / <?= getAnswer($item['no_soal'], $dataAnswer, $soalt)[0] ?> </span></label>
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