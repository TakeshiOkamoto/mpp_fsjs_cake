<?php

  $this->assign('title', __('勘定科目 - 表示'));
  
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/accounts', true) ?>"><?= __('勘定科目') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('表示') ?></li>     
  </ol> 
</nav>    
<p></p>
<h1><?= h($account->name) ?></h1>
<p></p>

<p>
  <strong><?= __('種類') ?> : </strong>
  <?= h($account->types) ?>
</p>

<p>
  <strong><?= __('経費フラグ') ?> : </strong>
  <?= h($account->expense_flg) ?>
</p>

<p>
  <strong><?= __('表示順序(リスト用)') ?> : </strong>
  <?= h($account->sort_list) ?>
</p>

<p>
  <strong><?= __('表示順序(経費用)') ?> : </strong>
  <?= h($account->sort_expense) ?>
</p>

<p>
  <strong><?= __('作成日時') ?> : </strong>
  <?= h($account->created_at->format('Y-m-d H:i:s')) ?>
</p>


<p>
  <strong><?= __('更新日時') ?> : </strong>
  <?= h($account->updated_at->format('Y-m-d H:i:s')) ?>
</p>

<a href="<?= $this->Url->build('/accounts/edit/' . $account->id , true) ?>"><?= __('編集') ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?= $this->Url->build('/accounts', true) ?>"><?= __('戻る') ?></a>
<p></p>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/accounts', true) ?>"><?= __('勘定科目') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('表示') ?></li>     
  </ol> 
</nav>  
