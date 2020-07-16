<h4><? echo $animal['animal_name'] ?></h4>
<ul>
    <li>
        <a href="/animals/<?echo $animal['name']?>">
            <!-- параметры запроса получаем в объекте реквест, метод params() -->
            Категория:
            <? echo $animal['description'] ?>
        </a>
    </li>
    <li>Возраст: <?echo $animal['age']?></li>

    <li>Документы:
        <?echo ($animal['passport']) ? 'есть' :  'нет'?>
    </li>
    <li>Прививки:
        <?echo ($animal['vaccination']) ? 'есть' :  'нет'?>
    </li>
</ul>