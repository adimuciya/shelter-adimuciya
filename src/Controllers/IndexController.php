<?php
namespace Ifmo\Web\Controllers;

use Ifmo\Web\Core\Controller;
use Ifmo\Web\Services\AnimalService;

class IndexController extends Controller
{
    private $animalService;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->animalService = new AnimalService();
    }

    public function indexAction(){
        $animals = $this->animalService->getAnimals();
        $content = 'main.php';
        $data = [
            'page_title' => 'Главная',
            'animals' => $animals
        ];
        return $this->generateResponse($content, $data);
    }
}