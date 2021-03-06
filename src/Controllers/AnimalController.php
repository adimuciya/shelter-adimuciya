<?php


namespace Ifmo\Web\Controllers;

use Ifmo\Web\Core\Controller;
use Ifmo\Web\Core\Request;
use Ifmo\Web\Services\AnimalService;

class AnimalController extends Controller
{
    private $animalService;

    public function __construct()
    {
        $this->animalService = new AnimalService();
    }

    public function showCategory(Request $request) {

        // var_dump($request->params());
        // 'category' => string 'dogs' (length=4)
        // ключи массива - в конфиге в фигурных скобках
        // значение - то что пришло в запросе
        $category = $request->params()['category'];
        $animals = $this->animalService->getAnimalsByCategory($category);

        $content ='animalsByCategory.php';
        $data = [
            'page_title' => $animals[0]['description'],
            'animals' => $animals
        ];
        return $this->generateResponse($content, $data);

    }

    public function showAnimal(Request $request) {
        $id = $request->params()['id'];
        $animal = $this->animalService->getAnimalById($id);
        $content ='animal.php';
        $data = [
            'page_title' => $animal['animal_name'],
            'animal' => $animal
        ];
        return $this->generateResponse($content, $data);

    }
}