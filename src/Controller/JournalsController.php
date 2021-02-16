<?php
namespace App\Controller;

use App\Controller\AppController;

// 追加分
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Exception\Exception;
use Cake\ORM\Exception\PersistenceFailedException;

class JournalsController extends AppController
{

///////////////////////////////////////////////////////////////////////////////

    // 借方のリストを取得する 
    public function getDebitList($keihi = false)
    {
        $debits = $this->FsjsAccounts->find()->where(['types !=' => 2])
                    ->order(['sort_list' => 'asc'])
                    ->select(['id', 'name', 'expense_flg']);

        $debits = $debits->toArray();
        foreach ($debits as $debit){
            if($debit->expense_flg == 1 && $keihi){
                $debit->name = '[経費]' . $debit->name;
            }
        }

        return $debits;
    }
    
    // 貸方のリストを取得する 
    public function getCreditList()
    {
        $credits = $this->FsjsAccounts->find()->where(['types !=' => 1])
                    ->order(['sort_list' => 'asc'])
                    ->select(['id', 'name']);

        $credits = $credits->toArray();
        return $credits;
    }  
    
    // 借方/貸方の名前を設定する
    public function setAccountName($item, $debit_list, $credit_list){
      
        // 借方
        $item->debit = "不明";
        foreach ($debit_list as $debit){
            if ($debit->id == $item->debit_account_id){
                $item->debit = $debit->name;
                break;
            }
        }  
        
        // 貸方
        $item->credit = "不明";
        foreach ($credit_list as $credit){
            if ($credit->id == $item->credit_account_id){
                $item->credit = $credit->name;
                break;
            }
        }  
    }

///////////////////////////////////////////////////////////////////////////////

    // ページネーション
    public $paginate = [
        'limit' => 50, 
    ];
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        // ログインチェック 
        $session = $this->getRequest()->getSession();
        if (!$session->check('user.name')){
            return $this->redirect('/admin/login');
        }
    }
        
    public function initialize()
    {
        // 親クラスのinitialize()
        parent::initialize();

        // ページネーション
        $this->loadComponent('Paginator');
            
        // レイアウト
        $this->viewBuilder()->setLayout('main');

        // モデル
        $this->loadModel('FsjsAccounts');
        $this->loadModel('FsjsCapitals');
        $this->loadModel('FsjsJournals');
    }
    
    public function index()
    {
        // 元入金
        $yyyy = $this->request->getQuery('yyyy');
        if(isset($yyyy) && AppController::isNumeric($yyyy)){
            $capital = $this->FsjsCapitals->find()->where(['yyyy' => $yyyy]);
            if ($capital->count() === 0){
                return $this->redirect('/');
            }
        }else{
            return $this->redirect('/');
        }
        $capital = $capital->toArray();
        $capital = $capital[0];
        
        // 仕訳
        $query = $this->FsjsJournals->find()->where(['yyyy' => $yyyy])
                   ->order(['mm' => 'desc'])
                   ->order(['dd' => 'desc'])
                   ->order(['summary' => 'asc'])
                   ->order(['debit_account_id' => 'asc']);
        $journals = $this->paginate($query);
                   
        // 借方/貸方の名前を設定
        $debit_list  = $this->getDebitList(false);   // 借方リスト 
        $credit_list = $this->getCreditList();       // 貸方リスト 
        foreach ($journals as $journal){
            $this->setAccountName($journal, $debit_list, $credit_list);
        }
        
        // 現金
        $money            = $this->getAccountTotal($yyyy, "m1", 3);
        // その他の預金
        $deposit          = $this->getAccountTotal($yyyy, "m2", 4);
        // 前払金
        $advance_payment  = $this->getAccountTotal($yyyy, "m3", 13);
        // 未払金
        $accounts_payable = $this->getAccountTotal($yyyy, "m4", 5);
        // 売上 
        $con = ConnectionManager::get('default');
        $sql = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals WHERE yyyy = :yyyy AND credit_account_id = 12";
        $sales = $con->execute($sql, ['yyyy' => $yyyy])->fetchAll('assoc');
        $sales = $sales[0]['money'];

        $this->set(compact(['yyyy', 
                            'journals', 'capital',
                            'money', 'deposit', 'advance_payment', 'accounts_payable', 'sales']));
    }

    public function view($id = null)
    {
        $journal = $this->FsjsJournals->get($id, [
            'contain' => [],
        ]);
 
        // 借方/貸方の名前を設定
        $debit_list  = $this->getDebitList(false);   // 借方リスト
        $credit_list = $this->getCreditList();       // 貸方リスト
        $this->setAccountName($journal, $debit_list, $credit_list);
             
        $this->set(compact(['journal']));
    }

    public function add()
    {      
        // 会計年度
        $yyyy = $this->request->getQuery('yyyy');
        if(isset($yyyy) && AppController::isNumeric($yyyy)){
            $capital = $this->FsjsCapitals->find()->where(['yyyy' => $yyyy]);
            if ($capital->count() === 0){
                return $this->redirect('/');
            }
        }else{
            return $this->redirect('/');
        }
              
        $journal = $this->FsjsJournals->newEntity();
        if ($this->request->is('post')) { 
            
            // パラメータ 
            $param = $this->request->getData();
            $param['summary'] = AppController::trim($param['summary']);
            
            // リクエスト(POST)の書き換え          
            $this->request = $this->request->withData('summary', $param['summary']);
            
            $journal = $this->FsjsJournals->patchEntity($journal, $param);
          
            // トランザクション
            $con = ConnectionManager::get('default');
            $con->begin();
              
            try{
                // -------------------------------------------------------------
                //  save()ができない場合は例外(PersistenceFailedException)
                // -------------------------------------------------------------
                $this->FsjsJournals->saveOrFail($journal, ['atomic' => false]);
                
                // コミット
                $con->commit();
                $this->Flash->success(__('登録しました。'));
                return $this->redirect(['action' => 'index', '?' => ['yyyy' => $journal->yyyy]]);
                
            // ロールバック                
            } catch (PersistenceFailedException $e) {
                $con->rollback();               
                $this->Flash->error(__('エラーをご確認ください。'));
            } catch (Exception $e) {
                // その他の例外
                $con->rollback();
                $this->Flash->error(__('エラーが発生しました。管理者に問い合わせてください。'));
            }
        }
        
        // 借方リスト
        $debits = $this->getDebitList(true);
        $select_debits = [];
        $select_debits[''] = __('選択して下さい。');
        foreach ($debits as $debit){
            $select_debits[$debit->id] = $debit->name ;
        }
        
        // 貸方リスト
        $credits = $this->getCreditList();
        $select_credits = [];
        $select_credits[''] = __('選択して下さい。');
        foreach ($credits as $credit){
            $select_credits[$credit->id] = $credit->name ;
        }
        
        $this->set(compact(['yyyy', 'journal',
                            'select_debits', 'select_credits']));
    }

    public function edit($id = null)
    {
        $journal = $this->FsjsJournals->get($id, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // パラメータ 
            $param = $this->request->getData();
            $param['summary'] = AppController::trim($param['summary']);
            
            // リクエスト(POST)の書き換え          
            $this->request = $this->request->withData('summary', $param['summary']);
            
            $journal = $this->FsjsJournals->patchEntity($journal, $param);
                      
            // トランザクション
            $con = ConnectionManager::get('default');
            $con->begin();
              
            try{
                // -------------------------------------------------------------
                //  save()ができない場合は例外(PersistenceFailedException)
                // -------------------------------------------------------------
                $this->FsjsJournals->saveOrFail($journal, ['atomic' => false]);
                
                // コミット
                $con->commit();
                $this->Flash->success(__('更新しました。'));
                return $this->redirect(['action' => 'index', '?' => ['yyyy' => $journal->yyyy]]);
                
            // ロールバック                
            } catch (PersistenceFailedException $e) {
                $con->rollback();                                   
                $this->Flash->error(__('エラーをご確認ください。'));
            } catch (Exception $e) {
                // その他の例外
                $con->rollback();
                $this->Flash->error(__('エラーが発生しました。管理者に問い合わせてください。'));
            }
        }
        
        // 借方リスト
        $debits = $this->getDebitList(true);
        $select_debits = [];
        $select_debits[''] = __('選択して下さい。');
        foreach ($debits as $debit){
            $select_debits[$debit->id] = $debit->name ;
        }
        
        // 貸方リスト
        $credits = $this->getCreditList();
        $select_credits = [];
        $select_credits[''] = __('選択して下さい。');
        foreach ($credits as $credit){
            $select_credits[$credit->id] = $credit->name ;
        }
                
        $this->set(compact(['journal',
                            'select_debits', 'select_credits']));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $journal = $this->FsjsJournals->get($id);
        
        // トランザクション
        $con = ConnectionManager::get('default');
        $con->begin();
          
        try{
            // -------------------------------------------------------------
            //  delete()ができない場合は例外(PersistenceFailedException)
            // -------------------------------------------------------------
            $this->FsjsJournals->deleteOrFail($journal, ['atomic' => false]);
            
            // コミット
            $con->commit();
            $this->Flash->error(__('削除しました。'));

        // ロールバック                
        } catch (Exception $e) {
            $con->rollback();
            $this->Flash->error(__('エラーが発生しました。'));
        }
        
        // Ajaxなのでdie(exit)する
        die;
        
        // 標準機能(POST)を使用する場合
        //return $this->redirect(['action' => 'index']);
    }
}
