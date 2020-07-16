<?php


namespace Ifmo\Web\Services;


use Ifmo\Web\Core\Service;

class AnimalService extends Service
{
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

}