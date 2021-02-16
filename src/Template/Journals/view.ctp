<?php

  $this->assign('title', __('仕訳 - 表示'));
  
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('会計年度') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('仕訳の表示') ?></li>
  </ol> 
</nav>    
<p></p>
<table class="table table-hover">
  <tbody class="thead-default">
    <tr>
      <th><?= __('日付') ?></th><td><?= date('Y/m/d', strtotime($journal->yyyy . '/' . $journal->mm . '/' . $journal->dd)) ?></td>
    </tr>
    <tr>
      <th><?= __('借方') ?></th><td><?= h($journal->debit) ?></td>
    </tr>
    <tr>
      <th><?= __('貸方') ?></th><td><?= h($journal->credit) ?></td>
    </tr>
    <tr>
      <th><?= __('金額') ?></th><td><?= number_format($journal->money) ?></td>
    </tr>
    <tr>
      <th><?= __('摘要') ?></th><td><?= h($journal->summary) ?></td>
    </tr>
    <tr>
      <th><?= __('作成日時') ?></th><td><?= $journal->created_at->format('Y-m-d H:i:s') ?></td>
    </tr>    
    <tr>
      <th><?= __('更新日時') ?></th><td><?= $journal->updated_at->format('Y-m-d H:i:s') ?></td>
    </tr>                    
  </tbody>
</table>
<p></p>

<a href="<?= $this->Url->build('/journals/edit/' . $journal->id , true) ?>"><?= __('編集') ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?= $this->Url->build('/journals?yyyy=' . $journal->yyyy, true) ?>"><?= __('戻る') ?></a>
<p></p>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('会計年度') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('仕訳の表示') ?></li>
  </ol> 
</nav>  
