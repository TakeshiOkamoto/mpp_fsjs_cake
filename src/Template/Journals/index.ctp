<?php

  $this->assign('title', __('仕訳帳'));
  
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('会計年度') ?></a></li>     
    <li class="breadcrumb-item active"><?= __('仕訳帳') ?></li>     
  </ol> 
</nav>   
<p></p>
<h1><?= __('仕訳帳({0}年)', $yyyy) ?></h1>
<p><?= __('仕訳は1/1から順番に登録して下さい。現金、その他の預金、前払金、未払金は入力誤り判定機能付きです。') ?></p>
<p><a href="<?= $this->Url->build('/journals/add?yyyy=' . $yyyy , true) ?>" class="btn btn-primary"><?= __('仕訳の新規登録') ?></a></p>
<h5><?= ('[ 基本情報 ]') ?></h5>
<table class="table table-hover">
  <tbody class="thead-default">
    <tr>
      <th style="width:120px;"><?= ('元入金') ?></th>
      <td>
          <?= __('現金')          . ': ' . number_format($capital->m1)  ?> 
          <?= __('その他の預金')  . ': ' . number_format($capital->m2)  ?> 
          <?= __('前払金')        . ': ' . number_format($capital->m3)  ?> 
          <?= __('未払金')        . ': ' . number_format($capital->m4)  ?> 
      </td>
    </tr>  
    <tr>
      <th>12/31<span class="sp"><br></span><?= ('(期末)') ?></th>
      <td>
          <?= __('現金')          . ': ' . number_format($money)  ?> 
          <?= __('その他の預金')  . ': ' . number_format($deposit)  ?> 
          <?= __('前払金')        . ': ' . number_format($advance_payment)  ?> 
          <?= __('未払金')        . ': ' . number_format($accounts_payable)  ?> 
          <?= __('売上')        . ': ' . number_format($sales)  ?>  
      </td>
    </tr>      
  </tbody>
</table>

<h5><?= __('[ 仕訳 ]') ?></h5>  
<table class="table table-hover pc">
  <thead class="thead-default">
    <tr>
      <th><?= __('日付') ?></th>
      <th><?= __('借方') ?></th>
      <th><?= __('貸方') ?></th>
      <th><?= __('金額') ?></th>
      <th style="width:300px;"><?= __('摘要') ?></th>      
      <th></th>  
    </tr>
  </thead>
  <tbody class="thead-default">
    <?php foreach ($journals as $journal): ?>
    <tr>
      <td><a href="<?= $this->Url->build('/journals/view/' . $journal->id, true) ?>"><?= date('m/d', strtotime($journal->mm . '/' . $journal->dd)) ?></a></td>
      <td><?= h($journal->debit) ?></td>
      <td><?= h($journal->credit) ?></td>
      <td><?= number_format($journal->money) ?></td>
      <td><?= h($journal->summary) ?></td>                
      <td style="width:170px;">
        <a href="<?= $this->Url->build('/journals/edit/' . $journal->id, true) ?>" class="btn btn-primary"><?= __('編集') ?></a>
        &nbsp;&nbsp;
        <a href="#" onclick="ajax_delete('<?= __('「{0}/{1}」の仕訳を削除します。よろしいですか？', [$journal->mm,  $journal->dd]) ?>','<?= $this->Url->build('/journals/delete/' . $journal->id, true) ?>','<?= $this->Url->build('/journals?yyyy=' . $yyyy , true) ?>');return false;" class="btn btn-danger"><?= __('削除') ?></a>
      </td>            
    </tr>    
    <?php endforeach; ?>
  </tbody>    
</table>

<table class="table table-hover sp">
  <thead class="thead-default">
    <tr>
      <th><?= __('日付') ?></th>
      <th><?= __('仕訳') ?></th>
    </tr>
  </thead>
  <tbody class="thead-default">
    <?php foreach ($journals as $journal): ?>
    <tr>
      <td><a href="<?= $this->Url->build('/journals/view/' . $journal->id, true) ?>"><?= date('m/d', strtotime($journal->mm . '/' . $journal->dd)) ?></a></td>
      <td>
        <?= h($journal->debit) . ' ' . h($journal->credit) ?><br>
        <?= number_format($journal->money) ?><br>
        <span class="text-muted" style="font-size:90%"><?= h($journal->summary) ?></span><br>
        <p></p>
        <a href="<?= $this->Url->build('/journals/edit/' . $journal->id, true) ?>" class="btn btn-primary"><?= __('編集') ?></a>
        &nbsp;&nbsp;
        <a href="#" onclick="ajax_delete('<?= __('「{0}/{1}」の仕訳を削除します。よろしいですか？', [$journal->mm,  $journal->dd]) ?>','<?= $this->Url->build('/journals/delete/' . $journal->id, true) ?>','<?= $this->Url->build('/journals?yyyy=' . $yyyy , true) ?>');return false;" class="btn btn-danger"><?= __('削除') ?></a>
      </td>            
    </tr>    
    <?php endforeach; ?>
  </tbody>    
</table>

<?php if ($this->Paginator->param('count') > 0) {?>
<nav>
  <ul class="pagination">
    <?= $this->Paginator->prev('‹') ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('›') ?>
  </ul>
  <p><?= $this->Paginator->counter(['format' => __('全{{count}}件中 {{start}} - {{end}}件のデータが表示されています。')]) ?></p>
</nav>
<?php }else{ ?>
  <p><?= __('データがありません。') ?></p>
<?php } ?>
    
<p><br></p>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/capitals', true) ?>"><?= __('会計年度') ?></a></li>     
    <li class="breadcrumb-item active"><?= __('仕訳帳') ?></li>   
  </ol> 
</nav>    