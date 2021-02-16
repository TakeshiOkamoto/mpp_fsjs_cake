<?php

  $this->assign('title', __('勘定科目'));
  
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('勘定科目') ?></li>     
  </ol> 
</nav>   
<p></p>
<h1><?= __('勘定科目') ?></h1>
<p><?= __('この画面は<span style="color:red;">システム設定</span>です。複式簿記がわからない方は操作しないでください。') ?></p>
<p><?= __('「損益計算書」で利用できる経費の科目は全て登録済みです。その他に必要であれば追加して下さい。<br>
※不要な経費の科目は削除して頂いても構いません。<br>
※誤って変更した場合は「bin/cake migrations seed」を実行すればデータを復元できます。') ?></p>
<?php
    // 検索
    echo $this->Form->create(null, ['type' =>'get',
                                    'url' => $this->Url->build('/accounts', true),
                                    'novalidate' => true // ※HTML5のValidation機能
                                   ]);                                   
      echo '<div class="input-group">';
        echo $this->Form->control('name', ['type' =>'search' ,'label' => false , 
                                           'class' => 'form-control', 
                                           'placeholder' => __('検索したい名前を入力'), 'value' => $name]);
        echo '<span class="input-group-btn">';
          echo $this->Form->button(__('検索'), ['class' => 'btn btn-outline-info']);
        echo '</span>';
      echo '</div>';      
    echo  $this->Form->end(); 
?>

<p></p>
<table class="table table-hover">
  <thead class="thead-default">
    <tr>
      <th><?= __('名前') ?></th>
      <th class="pc"><?= __('種類') ?></th>
      <th class="pc"><?= __('経費フラグ') ?></th>   
      <th class="pc"><?= __('表示順序(リスト用)') ?></th>   
      <th class="pc"><?= __('表示順序(経費用)') ?></th>               
      <th></th>      
    </tr>
  </thead>
  <tbody class="thead-default">
      <?php foreach ($accounts as $account): ?>
        <tr>
            <td><a href="<?= $this->Url->build('/accounts/view/' . $account->id, true) ?>"><?= h($account->name) ?></a></td>
            <td class="pc"><?= h($account->types) ?></td>
            <td class="pc"><?= h($account->expense_flg) ?></td>
            <td class="pc"><?= h($account->sort_list) ?></td>
            <td class="pc"><?= h($account->sort_expense) ?></td>            
            <td style="width:170px;">
              <a href="<?= $this->Url->build('/accounts/edit/' . $account->id, true) ?>" class="btn btn-primary"><?= __('編集') ?></a>
              &nbsp;&nbsp;
              <a href="#" onclick="ajax_delete('<?= __('「{0}」を削除します。よろしいですか？', h(str_replace("'", "\'", $account->name))) ?>','<?= $this->Url->build('/accounts/delete/' . $account->id, true) ?>','<?= $this->Url->build('/accounts', true) ?>');return false;" class="btn btn-danger"><?= __('削除') ?></a>
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
<a href="<?= $this->Url->build('/accounts/add', true) ?>" class="btn btn-primary"><?= __('勘定科目の新規登録録') ?></a>
<p><br></p>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', true) ?>"><?= __('ホーム') ?></a></li> 
    <li class="breadcrumb-item active"><?= __('勘定科目') ?></li>    
  </ol> 
</nav>    