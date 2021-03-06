<?php

  $this->assign('title', __('勘定科目 - 編集'));
  
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/accounts', true) ?>"><?= __('勘定科目') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('編集') ?></li>
  </ol> 
</nav>    
<p></p>
<h1>勘定科目の編集</h1>
<p></p>

<?php
    echo $this->Form->create($account, ['type' =>'put',
                                        'url' => $this->Url->build('/accounts/edit/' . $account->id, true),
                                        'novalidate' => false // ※HTML5のValidation機能
                                       ]);
                                       
    echo $this->Form->control('name',   ['label' => ['text' => __('名前')], 'class' => 'form-control', 'required' => 'required']);    

    echo '<div class="form-group">';
      echo $this->Form->label('types-id', ['text' => __('種類')]);
      echo $this->Form->select('types', ['' => __('選択してください。'), '1' => __('借方'), '2' => __('貸方'), '3' => __('借方 + 貸方')],
                                        ['id' => 'types-id', 'value' => $account->types, 'class' => 'form-control col-sm-3', 'required' => 'required']); 
    echo '</div>';
    
    echo '<div class="form-group float-left">';
      echo $this->Form->label('expense-flg', ['text' => __('経費フラグ')]);
      echo $this->Form->checkbox('expense_flg', ['class' => 'form-control', 'id' => 'expense-flg']);
    echo '</div>';
    echo '<div class="clearfix"></div>';
    
    echo $this->Form->control('sort_list',    ['label' => ['text' => __('表示順序(リスト用)')], 'class' => 'form-control', 'required' => 'required']);
    echo $this->Form->control('sort_expense', ['label' => ['text' => __('表示順序(経費用)')],   'class' => 'form-control', 'required' => 'required']);

    echo $this->Form->button(__('更新する'), ['class' => 'btn btn-primary']);
    echo $this->Form->end();
?>
<br>
<p><a href="<?= $this->Url->build('/accounts', true) ?>"><?= __('戻る') ?></a></p>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/accounts', true) ?>"><?= __('勘定科目') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('編集') ?></li>
  </ol> 
</nav>  