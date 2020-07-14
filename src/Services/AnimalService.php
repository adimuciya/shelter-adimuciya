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

}