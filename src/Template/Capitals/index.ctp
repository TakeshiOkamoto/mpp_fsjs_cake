<?php

  $this->assign('title', __('会計年度'));
  
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('会計年度') ?></li>     
  </ol> 
</nav>   
<p></p>
<h1><?= __('会計年度') ?></h1>
<p><?= __('「元入金」とは新規開業または前年からの繰越の金額です。') ?></p>
<table class="table table-hover pc">
  <thead class="thead-default">
    <tr>
      <th style="width:100px;"></th>
      <th></th>
      <th><?= __('元入金') ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody class="thead-default">
    <?php foreach ($capitals as $capital): ?>
      <tr>
        <td><a href="<?= $this->Url->build('/journals?yyyy=' . $capital->yyyy, true) ?>" class="btn btn-outline-info"><?= __('仕訳帳') ?></a></td>
        <td><?= h($capital->yyyy) ?>年</td>
        <td>
          <?php
            echo  __('現金')         . ' ' . number_format($capital->m1) . ' ' .
                  __('その他の預金') . ' ' . number_format($capital->m2) . ' ' .
                  __('前払金')       . ' ' . number_format($capital->m3) . ' ' .
                  __('未払金')       . ' ' . number_format($capital->m4);
          ?>
        </td>  
        <td style="width:170px;">
          <a href="<?= $this->Url->build('/capitals/edit/' . $capital->id, true) ?>" class="btn btn-primary"><?= __('編集') ?></a>
          &nbsp;&nbsp;
          <a href="#" onclick="ajax_delete('<?= __('「{0}年」を削除します。よろしいですか？', h($capital->yyyy)) ?>','<?= $this->Url->build('/capitals/delete/' . $capital->id, true) ?>','<?= $this->Url->build('/capitals', true) ?>');return false;" class="btn btn-danger"><?= __('削除') ?></a>
        </td>         
      </tr>    
    <?php endforeach; ?>
  </tbody>    
</table>

<table class="table table-hover sp">
  <tbody class="thead-default">
    <?php foreach ($capitals as $capital): ?>
      <tr>
        <td>
          <a href="<?= $this->Url->build('/journals?yyyy=' . $capital->yyyy, true) ?>" class="btn btn-outline-info"><?= __('仕訳帳') .  ' (' .h($capital->yyyy) ?>年)</a>
          <p></p>
          &lt;<?= __('元入金') ?>&gt;<br>
            <?php
              echo  '・' . __('現金')         . ' ' . number_format($capital->m1) . '<br>' .
                    '・' . __('その他の預金') . ' ' . number_format($capital->m2) . '<br>' .
                    '・' . __('前払金')       . ' ' . number_format($capital->m3) . '<br>' .
                    '・' . __('未払金')       . ' ' . number_format($capital->m4);
            ?>
          <p></p>          
          <a href="<?= $this->Url->build('/capitals/edit/' . $capital->id, true) ?>" class="btn btn-primary"><?= __('編集') ?></a>
          &nbsp;&nbsp;
          <a href="#" onclick="ajax_delete('<?= __('「{0}年」を削除します。よろしいですか？', h($capital->yyyy)) ?>','<?= $this->Url->build('/capitals/delete/' . $capital->id, true) ?>','<?= $this->Url->build('/capitals', true) ?>');return false;" class="btn btn-danger"><?= __('削除') ?></a>
        </td>
      </tr>    
    <?php endforeach; ?>
  </tbody>    
</table>
<p></p>

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
    
<p></p>
<a href="<?= $this->Url->build('/capitals/add', true) ?>" class="btn btn-primary"><?= __('会計年度の新規登録') ?></a>
<p><br></p>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('会計年度') ?></li>     
  </ol> 
</nav>   