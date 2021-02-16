<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

// 追加分
use Cake\Datasource\ConnectionManager;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

///////////////////////////////////////////////////////////////////////////////

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

///////////////////////////////////////////////////////////////////////////////

    // 数字チェック
    public static function isNumeric($str){
        if (preg_match("/\A[0-9]+\z/",$str)) {
            if($str <= 2147483647)
            return TRUE;
        else
            return FALSE;
        } else {
            return FALSE;
        }
   } 
       
    // 全角 => 半角変換 + trim
    public static function trim($str){
        if (isset($str)){
            // a 全角英数字を半角へ
            // s 全角スペースを半角へ
            return trim(mb_convert_kana($str, 'as'));
        }else{
            return "";
        }
    }

///////////////////////////////////////////////////////////////////////////////

    // 対象科目の合計金額を取得する
    public function getAccountTotal($yyyy, $obj, $target_id){
        
        // DB
        $this->loadModel('FsjsCapital');
        $con = ConnectionManager::get('default');
        
        // 元入金
        $capital = $this->FsjsCapitals->find()->where(['yyyy' => $yyyy]);
        if ($capital->count() === 0){
            return 0;
        }
        $capital = $capital->toArray();
        
        // 借方        
        $sql = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals WHERE yyyy = :yyyy AND debit_account_id = :target_id";
        $debit = $con->execute($sql, ['yyyy' => $yyyy, 'target_id' => $target_id])->fetchAll('assoc');
        
        // 貸方
        $sql = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals WHERE yyyy = :yyyy AND credit_account_id = :target_id";
        $credit = $con->execute($sql, ['yyyy' => $yyyy, 'target_id' => $target_id])->fetchAll('assoc');
        
        if($obj == "m4"){
            // 未払金
            $total = $capital[0]->$obj + $credit[0]['money'] - $debit[0]['money'];
        }else{  
            // 現金、その他の預金、前払金
            $total = $capital[0]->$obj + $debit[0]['money'] - $credit[0]['money'];
        }
        
        return $total;
    }
    
}
