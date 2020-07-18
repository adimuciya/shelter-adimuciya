<?php


namespace Ifmo\Web\Controllers;


use Ifmo\Web\Core\Controller;
use Ifmo\Web\Core\Request;
use Ifmo\Web\Services\AnimalService;

class AnimalApi extends Controller
{
    private $animalService;

    // вернет всех животных на vue

    /**
     * AnimalApi constructor.
     */
    public function __construct()
    {
        $this->animalService = new AnimalService();
    }

    public function animals(){
        $animals = $this->animalService->getAnimals();
        return $this->ajaxResponse(json_encode($animals));
    }
    // добавляет животное в бд
    public function addAnimal(Request $request){
        $animal_data = $request->post();
        $animal_data['passport'] = (int) $animal_data['passport'];
        $animal_data['vaccination'] = (int) $animal_data['vaccination'];
        $answer = $this->animalService->addAnimal($animal_data) ?
            'Животное добавлено' : 'Ошибка добавления';
        return $this->ajaxResponse($answer);

    }
    // изменяет данные по животному
    public function editAnimal(Request $request){
        $animal_data = $request->post();

    }

}