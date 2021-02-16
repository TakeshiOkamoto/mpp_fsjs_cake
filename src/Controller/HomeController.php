<?php
namespace App\Controller;

use App\Controller\AppController;

// 追加分
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

class HomeController extends AppController
{
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
            
        // レイアウト
        $this->viewBuilder()->setLayout('main');

        // モデル
        $this->loadModel('FsjsCapitals');
    }

    public function index()
    {
        $capitals = $this->FsjsCapitals->find()->order(['yyyy' => 'desc']);
        $capitals = $capitals->toArray();
        
        $yyyy = $this->request->getQuery('yyyy');
        if(isset($yyyy) && AppController::isNumeric($yyyy)){
            
            $con = ConnectionManager::get('default');
            
            // 元入金(期首)
            $report_bs_st = $this->FsjsCapitals->find()->where(['yyyy' => $yyyy]);
            if ($report_bs_st->count() === 0){
                return $this->redirect('/');
            }            
            $report_bs_st = $report_bs_st->toArray();
            
            // ----------------------------------
            //  損益計算書
            // ----------------------------------
            
            // 売上
            $sql = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals WHERE yyyy = :yyyy AND credit_account_id = 12";
            $report_pl_total = ($con->execute($sql, ['yyyy' => $yyyy])->fetchAll('assoc'))[0]['money'];
            
            // 経費
            $sql = "SELECT fsjs_accounts.name,IFNULL(SUM(fsjs_journals.money),0) AS money FROM fsjs_accounts " .
                   " LEFT JOIN fsjs_journals ON fsjs_accounts.id = fsjs_journals.debit_account_id AND fsjs_journals.yyyy = :yyyy " .
                   " WHERE fsjs_accounts.expense_flg = 1  " .
                   " GROUP BY fsjs_accounts.name " .
                   " ORDER BY fsjs_accounts.sort_expense ASC ";
            $report_pl_keihi = $con->execute($sql, ['yyyy' => $yyyy])->fetchAll('assoc');
            
            // ----------------------------------
            //  月別売上(収入)金額及び仕入金額
            // ----------------------------------
            $report_month = [];
            $sql = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals WHERE yyyy = :yyyy AND mm = :mm AND credit_account_id = 12";
            for($i=0; $i<12;$i++){
                $report_month[$i] = ($con->execute($sql, ['yyyy' => $yyyy,  'mm' => ($i +1)])->fetchAll('assoc'))[0];
            }
            
            // ----------------------------------
            //  貸借対照表
            // ----------------------------------
            
            // 元入金(期首)
            $report_bs_st = $report_bs_st[0];
            
            // 事業主貸(期末)
            $sql = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals WHERE yyyy = :yyyy AND debit_account_id = 1";
            $report_bs_debit = ($con->execute($sql, ['yyyy' => $yyyy])->fetchAll('assoc'))[0]['money'];
            
            // 事業主借(期末)
            $sql = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals WHERE yyyy = :yyyy AND credit_account_id = 2";
            $report_bs_credit = ($con->execute($sql, ['yyyy' => $yyyy])->fetchAll('assoc'))[0]['money'];
            
            // 現金(期末)
            $report_bs_m1 = $this->getAccountTotal($yyyy, "m1", 3);
            // その他の預金(期末)
            $report_bs_m2 = $this->getAccountTotal($yyyy, "m2", 4);
            // 前払金(期末)
            $report_bs_m3 = $this->getAccountTotal($yyyy, "m3", 13);
            // 未払金(期末)
            $report_bs_m4 = $this->getAccountTotal($yyyy, "m4", 5);
            
            
            $this->set(compact(['yyyy',
                                'capitals',
                                'report_pl_total','report_pl_keihi',
                                'report_month',
                                'report_bs_st','report_bs_debit', 'report_bs_credit',
                                'report_bs_m1', 'report_bs_m2', 'report_bs_m3', 'report_bs_m4']));
        }else{
            $this->set(compact(['capitals']));
        }
    }
}
