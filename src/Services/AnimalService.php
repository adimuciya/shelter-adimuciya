<?php


namespace Ifmo\Web\Services;


use Ifmo\Web\Core\Service;

class AnimalService extends Service
{
    const INSERT_SUCCESS = 1;
    const INSERT_ERROR = 0;

    public function getAnimals(){
        $sql = 'select * from animal, category
                    where animal.id_category = category.id_category;';
        return $this->dbConnection->queryAll($sql);
    }
    public function getAnimalsByCategory($categoryName){

        $sql = 'select a.animal_name, a.age, a.id_animal, c.description, c.name
        from animal a
        left join category c
        on a.id_category = c.id_category
        where c.name = :category;';

        $params = ['category' => $categoryName];

        return $this->dbConnection->execute($sql, $params);
    }

    public function getAnimalById($id){
        $sql = $sql = 'select a.animal_name, a.age, a.id_animal, a.passport, a.vaccination, c.description, c.name
        from animal a
        left join category c
        on a.id_category = c.id_category
        where a.id_animal = :id;';
        $params = ['id' => $id];
        return $this->dbConnection->execute($sql, $params, false);
    }
//        id_category: null,
//        animal_name: '',
//        description: '',
//        age: 0,
//        passport: false,
//        vaccination: false
    public function addAnimal($animal_data) {
        $sql = 'insert into animal 
                (animal_name, id_category, description, age, passport, vaccination)
                values
                (:animal_name, :id_category, :description, :age, :passport, :vaccination);';
        // Если константы вынесены в отдельный класс,
        // то обращаемся к ним ИмяКласса::ИМЯ_КОНСТАНТЫ
        return $this->dbConnection->executeSql($sql, $animal_data) ?
                            self::INSERT_SUCCESS : self::INSERT_ERROR;
    }

}