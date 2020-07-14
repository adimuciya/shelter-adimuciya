<?php

namespace Ifmo\Web\Services;

use Ifmo\Web\Core\Service;

class AccountService extends Service // класс уровня Model
{
    const REGISTRATION_SUCCESS = 'Регистрация прошла успешно';
    const REGISTRATION_ERROR = 'Ошибка регистрации';
    const USER_EXISTS = 'Пользователь с таким логином уже существует';

    const AUTH_LOGIN_ERROR = 'Ошибка LOGIN авторизации';
    const AUTH_PWD_ERROR = 'Ошибка PWD авторизации';
    const AUTH_SUCCESS = 'Авторизация прошла успешно';
    // private $validator;
    // $this->validator = new Validator();
    // либо методы класса Validator сделать статическими и обращаться
    // к ним при необходимости без создания объекта Validator::имяМетода()
    public function addUser(array $reg_data){

        // TODO:: Валидация!!!
//        [
//            'email'=> '',
//            'password' => '',
//            'name'=> '',
//            'phone'=>
//        ]
        // проверка на наличие пользователя в бд (по email в нашем случае)
        // зашифровать пароль
        // заносим данные в бд
        $email = $reg_data['email'];
        if ($this->getUser($email)) return self::USER_EXISTS;
        $pwd = $reg_data['password']; // qwerty123
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        // запись в таблицу 1
        // запись в таблицу 2
        // запись в таблицу 3
        // открыть транзакцию
        // выполнение всех запросов
        // если все хорошо, подтвердить транзакцию
        // если возникли ошибки, откатываем транзакцию к моменту открытия

        // user - email + hash
        // user_info - user_name + phone
        $user_sql = 'INSERT INTO user(email, hash) 
                        VALUES (:user_email, :user_password)';
        $user_info_sql = 'INSERT INTO user_info (user_name, phone, id_user) 
                            VALUES (:user_name, :phone, :id_user)';
        // + массивы с параметрами
        try {
            // начало транзакции
            // метод beginTransaction объекта PDO открывает транзакцию
            $this->dbConnection->getConnection()->beginTransaction();
            $user_params = [
                'user_email'=>$email,
                'user_password'=>$pwd
            ];
            $this->dbConnection->executeSql($user_sql, $user_params);

            $user_info_params = [
                'user_name' => $reg_data['name'],
                'phone' =>$reg_data['phone'],
                // метод lastInsertId объект PDO возвращает последний добавленный PK
                'id_user' => $this->dbConnection->getConnection()->lastInsertId()
            ];
            $this->dbConnection->executeSql($user_info_sql, $user_info_params);

            // подтверждение транзакции
            // метод commit объекта PDO подтверждает транзакцию (данные записываются в таблицы)
            $this->dbConnection->getConnection()->commit();
            return self::REGISTRATION_SUCCESS;
        } catch (Exception $exception){
            // откат транзакции (к методу beginTransaction) данные не будут добавлены
            // метод rollBack объекта PDO откатыват транзакцию к вызову метода beginTransaction
            $this->dbConnection->getConnection()->rollBack();
            return self::REGISTRATION_ERROR;
        }
    }
    public function auth(array $auth_data) {
        $email = $auth_data['email'];
        $pwd = $auth_data['password'];

        $user = $this->getUser($email);
        // можно конкретизировать ошибку
        if(!$user) return self::AUTH_LOGIN_ERROR;
        // проверка пароля
        // принимает пароль и зашифрованный пароль
        // возвращает тру или фолс
        if (!password_verify($pwd, $user['hash'])){
            // можно конкретизировать ошибку
            return self::AUTH_PWD_ERROR;
        }
        return self::AUTH_SUCCESS;

    }
    // проверка на наличие пользователя по email
    private function getUser($email){
        $sql = 'select * from user where email = :email';
        $user = $this->dbConnection->execute(
            $sql,
            ['email' => $email],
            false
        );
        return $user;
    }
}