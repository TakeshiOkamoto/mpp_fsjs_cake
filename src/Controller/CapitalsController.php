<?php
namespace App\Controller;

use App\Controller\AppController;

// 追加分
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Exception\Exception;
use Cake\ORM\Exception\PersistenceFailedException;

class CapitalsController extends AppController
{
    // ページネーション
    public $paginate = [
        'limit' => 25, 
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
        $this->loadModel('FsjsCapitals');
    }
    
    public function index()
    {
        $query = $this->FsjsCapitals->find()->order(['yyyy' => 'DESC']) ;
        $this->set('capitals',  $this->paginate($query));
    }

    public function view($id = null)
    {
        return $this->redirect(['action' => 'index']);
    }

    public function add()
    {
        $capital = $this->FsjsCapitals->newEntity();
        if ($this->request->is('post')) { 
            
            // パラメータ 
            $param = $this->request->getData();
            $capital = $this->FsjsCapitals->patchEntity($capital, $param);
          
            // トランザクション
            $con = ConnectionManager::get('default');
            $con->begin();
              
            try{
                // -------------------------------------------------------------
                //  save()ができない場合は例外(PersistenceFailedException)
                // -------------------------------------------------------------
                $this->FsjsCapitals->saveOrFail($capital, ['atomic' => false]);
                
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
        $this->set(compact('capital'));
    }

    public function edit($id = null)
    {
        $capital = $this->FsjsCapitals->get($id, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // パラメータ 
            $param = $this->request->getData();
            $capital = $this->FsjsCapitals->patchEntity($capital, $param);
            
            // トランザクション
            $con = ConnectionManager::get('default');
            $con->begin();
              
            try{
                // -------------------------------------------------------------
                //  save()ができない場合は例外(PersistenceFailedException)
                // -------------------------------------------------------------
                $this->FsjsCapitals->saveOrFail($capital, ['atomic' => false]);
                
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
        $this->set(compact('capital'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $capital = $this->FsjsCapitals->get($id);
        
        // トランザクション
        $con = ConnectionManager::get('default');
        $con->begin();
          
        try{
            // -------------------------------------------------------------
            //  delete()ができない場合は例外(PersistenceFailedException)
            // -------------------------------------------------------------
            $this->FsjsCapitals->deleteOrFail($capital, ['atomic' => false]);
            
            // 必要であれば、該当年度の仕訳帳もココで削除して下さい。
                        
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
