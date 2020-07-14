<?php


namespace Ifmo\Web\Controllers;


use Ifmo\Web\Core\Controller;
use Ifmo\Web\Core\Request;
use Ifmo\Web\Services\AccountService;

class AccountController extends Controller
{
    private $accountService;
    public function __construct()
    {
        $this->accountService = new AccountService();
    }
    // метод, отвечающий за отображение страницы с регистрацией
    // /registration GET
    public function showRegForm(){
        $content = 'registration.php';
        $data = [
            'page_title'=>'Регистрация'
        ];
        return $this->generateResponse($content,$data);
    }

    // метод, реагирующий на отправку формы, отвечающий за
    // регитрацию пользователя /registration POST
    public function regUser(Request $request){
        //var_dump($request->post());
        // можно не обращаться к валидации в AccountService,
        // а проверить данные из массива POST до вызова метода addUser
        $result = $this->accountService->addUser($request->post());
        $content = 'registration.php';
        $data = [
            'page_title'=>'Регистрация',
            'reg_result' => $result
        ];
        return $this->generateResponse($content,$data);
    }
    // добавить страницу account - личный кабинет пользователя
    public function account(){
        if (!isset($_SESSION['email'])) header('Location: /');
        $content = 'account.php';
        $data = [
            'page_title'=>'Личный кабинет'
        ];
        return $this->generateResponse($content,$data);
    }

    // метод, отвечающий за авторизацию /login POST
    public function login(Request $request){
        $auth_data = $request->post();
        // TODO:: Валидация
        $result = $this->accountService->auth($auth_data);
        if ($result === AccountService::AUTH_SUCCESS){
            $_SESSION['email'] = $auth_data['email'];
        }
        return $this->ajaxResponse($result);
    }
    public function logout() {
        $_SESSION=[];
        header('Location: /');
    }
}
