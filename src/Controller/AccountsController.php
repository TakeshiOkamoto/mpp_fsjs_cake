<?php
namespace App\Controller;

use App\Controller\AppController;

// 追加分
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Exception\Exception;
use Cake\ORM\Exception\PersistenceFailedException;

class AccountsController extends AppController
{

///////////////////////////////////////////////////////////////////////////////

    // 種類コードから種類名を取得する
    public function getTypeName($val)
    {
        if($val == "1"){
            return "借方";  
        }else if($val == "2"){
            return "貸方";  
        }
        return "借方 + 貸方";  
    }
    
///////////////////////////////////////////////////////////////////////////////
      
    // ページネーション
    public $paginate = [
        'limit' => 25, 
        'order' => [
            'FsjsAccounts.sort_list' => 'asc'
        ]
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
    }
    
    public function index()
    {   
        // 検索キーワード
        $name = "";
        if ($this->request->getQuery('name') !== null){
            $name = AppController::trim($this->request->getQuery('name'));
        }
        $this->set(compact('name'));

        // 複数件の処理
        $query = $this->FsjsAccounts->find();
        if ($name != ""){
            $arr = explode(' ', $name);
            for ($i=0; $i<count($arr); $i++){
                $keyword = str_replace('%', '\%', $arr[$i]); 
                $query = $query->where(['name like' => '%' . $keyword . '%']);
            }
        }
        
        $items = $this->paginate($query); 
        foreach ($items as $item){
            $item->types = $this->getTypeName($item->types);
            $item->expense_flg = $item->expense_flg == 1 ? "true" : "false";
        }
        
        $this->set('accounts', $items);
    }

    public function view($id = null)
    {
        $account = $this->FsjsAccounts->get($id, [
            'contain' => [],
        ]);
        
        $account->types = $this->getTypeName($account->types);
        $account->expense_flg = $account->expense_flg == 1 ? "true" : "false";

        $this->set(compact('account'));
    }

    public function add()
    {
        $account = $this->FsjsAccounts->newEntity();
        if ($this->request->is('post')) { 
            
            // パラメータ 
            $param = $this->request->getData();
            $param['name'] = AppController::trim($param['name']);
            
            // リクエスト(POST)の書き換え          
            $this->request = $this->request->withData('name', $param['name']);
                        
            $account = $this->FsjsAccounts->patchEntity($account, $param);
          
            // トランザクション
            $con = ConnectionManager::get('default');
            $con->begin();
              
            try{
                // -------------------------------------------------------------
                //  save()ができない場合は例外(PersistenceFailedException)
                // -------------------------------------------------------------
                $this->FsjsAccounts->saveOrFail($account, ['atomic' => false]);
                
                // コミット
                $con->commit();
                $this->Flash->success(__('登録しました。'));
                return $this->redirect(['action' => 'index']);
                
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
        $this->set(compact('account'));
    }

    public function edit($id = null)
    {
        $account = $this->FsjsAccounts->get($id, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // パラメータ 
            $param = $this->request->getData();
            $param['name'] = AppController::trim($param['name']);
            
            // リクエスト(POST)の書き換え          
            $this->request = $this->request->withData('name', $param['name']);
            
            $account = $this->FsjsAccounts->patchEntity($account, $param);
            
            // トランザクション
            $con = ConnectionManager::get('default');
            $con->begin();
              
            try{
                // -------------------------------------------------------------
                //  save()ができない場合は例外(PersistenceFailedException)
                // -------------------------------------------------------------
                $this->FsjsAccounts->saveOrFail($account, ['atomic' => false]);
                
                // コミット
                $con->commit();
                $this->Flash->success(__('更新しました。'));
                return $this->redirect(['action' => 'index']);
                
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
        $this->set(compact('account'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $account = $this->FsjsAccounts->get($id);
        
        // トランザクション
        $con = ConnectionManager::get('default');
        $con->begin();
          
        try{
            // -------------------------------------------------------------
            //  delete()ができない場合は例外(PersistenceFailedException)
            // -------------------------------------------------------------
            $this->FsjsAccounts->deleteOrFail($account, ['atomic' => false]);
            
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
