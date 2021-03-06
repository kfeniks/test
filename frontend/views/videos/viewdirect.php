<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Direct */
$this->title = Html::encode($video_name->title);
$model->userdownloads;
$model->counters;
$model->user->updateCounters(['karma' => 10]);
?>

<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1>Файл из внешнего источника для клипа <?= Html::encode($this->title) ?></h1>
            </div>
            <div class="panel-body">
                <p>Чтобы скачать клип с внешнего сервера, нажмите на ссылку ниже. Если ссылка оказалась нерабочей, обратитесь к администратору сайта.</p>
                <p><b>Внимание: Потенциально вредоносная ссылка!</b></p>
                <p>Ссылка, по которой Вы попытались перейти, ведёт на сайт, расположенный на чужом хостинге.</p>
                <p>Такие ссылки могут использоваться спамерами и мошенниками для перенаправления на потенциально опасные сайты, а также могут содержать вирусы.</p>
                <p>AMV.PP.UA всегда заботится о Вашей безопасности!</p>
                <!--noindex-->
                <p>Ссылка: <a href="<?= Html::encode($model->direct_url)?>" target="_blank" role="button">Cсылка</a></p>
                <!--/noindex-->
                <p>Формат: <?= $model->formatName() ?></p>
                <p>Кодек аудио: <?= $model->CodecAudioName() ?></p>
                <p>Кодек видео: <?= $model->CodecVidName() ?></p>
                <p>Размер: <?= Html::encode($model->filesize) ?> мбайт</p>
                <p>Дата добавления: <?= Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy') ?></p>
                <p>Скачиваний: <?= $model->load_count ?></p>
                <br/><?php
                $check_url = Yii::$app->request->referrer;
                $check_url_link = $check_url{7}.$check_url{8}.$check_url{9};
                if($check_url_link == 'amv'){ ?>
                    <p>Вернуться <a href="<?= (!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null) ?>">назад</a> к клипу.</p>
                <?php }
                else{
                    header('Location: Yii::$app->homeUrl;');
                    exit;
                }
                ?>
            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">








