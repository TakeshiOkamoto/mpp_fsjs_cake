<?php

  $this->assign('title', __('会計年度 - 編集'));
  
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('会計年度') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('編集') ?></li>
  </ol> 
</nav>    
<p></p>
<h1><?= __('会計年度の編集') ?></h1>
<p></p>
<?php
    echo $this->Form->create($capital, ['type' =>'put',
                                        'url' => $this->Url->build('/capitals/edit/' . $capital->id, true),
                                        'novalidate' => false // ※HTML5のValidation機能
                                       ]);
                                       
    echo $this->Form->control('yyyy',   ['label' => ['text' => __('年 ※西暦4桁')], 'class' => 'form-control', 'required' => 'required']);    

    echo '<div class="alert alert-primary" role="alert">' . __('以下の4項目は1月1日(期首) 時点の「元入金」の金額を入力します。<br>※ない場合は0を入力。繰越の場合は前年の12/31(期末)の金額を入力。') . '</div>';
 
    echo $this->Form->control('m1',   ['label' => ['text' => __('現金')], 'class' => 'form-control', 'required' => 'required']);    
    echo $this->Form->control('m2',   ['label' => ['text' => __('その他の預金 ※通帳の残高')], 'class' => 'form-control', 'required' => 'required']);    
    echo $this->Form->control('m3',   ['label' => ['text' => __('前払金 ※電子マネーの前払金など')], 'class' => 'form-control', 'required' => 'required']);    
    echo $this->Form->control('m4',   ['label' => ['text' => __('未払金 ※クレジットカードの未払金など')], 'class' => 'form-control', 'required' => 'required']);    
    

    echo $this->Form->button(__('更新する'), ['class' => 'btn btn-primary']);
    echo $this->Form->end();
?>
<br>
<p><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('戻る') ?></a></p>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('会計年度') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('編集') ?></li>  
  </ol> 
</nav>    