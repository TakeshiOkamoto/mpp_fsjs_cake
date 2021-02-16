<?php

  $this->assign('title', __('仕訳 - 新規登録'));
  
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('会計年度') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('仕訳の新規登録') ?></li>
  </ol> 
</nav>    
<p></p>
<h1><?= __('仕訳の新規登録') ?></h1>
<p></p>

<?php
    echo $this->Form->create($journal, ['type' =>'post',
                                        'url' => $this->Url->build('/journals/add?yyyy=' . $yyyy, true),
                                        'novalidate' => false, // ※HTML5のValidation機能
                                        'id' => 'main_form'
                                       ]);
    // 日付
    echo '<div class="alert alert-primary" role="alert">' . __('日付') . '</div>';
    echo '<h5>' . $yyyy . __('年')  . '</h5>';
    echo '<p></p>';
    echo $this->Form->control('yyyy', ['label' => false, 'type' => 'hidden', 'value' => $yyyy]); 
    echo $this->Form->control('mm',   ['label' => ['text' => __('月')], 'class' => 'form-control', 'required' => 'required']); 
    echo $this->Form->control('dd',   ['label' => ['text' => __('日')], 'class' => 'form-control', 'required' => 'required']); 

    // 借方
    echo '<div class="alert alert-primary" role="alert">' .  __('借方') . '<span class="sp"><br></span>' . __(' ※大まかに言うとプラスのイメージ') . '</div>';
    echo '<div class="form-group">';
      echo $this->Form->select('debit_account_id', $select_debits,
                               ['value' => $journal->debit_account_id, 'class' => 'form-control col-sm-3', 'required' => 'required']);
      echo $this->Form->error('debit_account_id');                         
    echo '</div>';
    
    // 貸方    
    echo '<div class="alert alert-primary" role="alert">' .  __('貸方') . '<span class="sp"><br></span>' . __(' ※大まかに言うとマイナスのイメージ') . '</div>';
    echo '<div class="form-group">';
      echo $this->Form->select('credit_account_id', $select_credits,
                               ['value' => $journal->credit_account_id, 'class' => 'form-control col-sm-3', 'required' => 'required']); 
      echo $this->Form->error('credit_account_id');                               
    echo '</div>';

    // 金額
    echo '<div class="alert alert-primary" role="alert">' . __('金額') . ' </div>';
    echo $this->Form->control('money',   ['label' => false, 'class' => 'form-control', 'required' => 'required']); 
    
    // 摘要
    echo '<div class="alert alert-primary" role="alert">' . __('摘要') . ' </div>';
    echo '<p>' . __('(例)1/24 ご依頼○○様、○○広告収入、○○銀行、 クレジットカード(○○代)、○○引き落とし、携帯通信料金(按分50%)など') . '</p>';
    echo $this->Form->control('summary',   ['label' => false, 'class' => 'form-control', 'required' => 'required']); 
    
    echo '<br>';
    echo $this->Form->button(__('登録する'), ['class' => 'btn btn-primary', 'id' => 'btn_submit', 'onclick' => 'DisableButton();']);
    echo $this->Form->end();
?>
<br>
<p><a href="<?= $this->Url->build('/journals?yyyy=' . $yyyy , true) ?>"><?= __('戻る') ?></a></p>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('会計年度') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('仕訳の新規登録') ?></li>   
  </ol> 
</nav>    