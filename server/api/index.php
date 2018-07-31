<?php

require_once 'config.php';
include 'autoload.php';

try {
$cars = new rest_cars;
// dd($cars->getAll());
    //название класса является названием таблицы sql

//данный Active Record умеет работать с таблица где есть различное количество полей
//методы, которые являются столбцами таблицы names не обьявляем. они работают при помощи метода __set
//при обращении к столбцу, который не существует в таблице - выбросится исключение
//данный Active Record умеет работать с базами данных MySQL и PostgreSQL
//так же с таблицами у которых множество полей

//    $names->title=0;
//    $names->id = 4;
//    $names->name = 'VALUE4';
//    $names->save();
//    dd($names->findById(0));
//    $names->deleteById(4);
//    $names->deleteAll();



} catch (Exception $e) {
    echo $e->getMessage()."<br>";
    echo $e->getFile()."<br>";
    echo $e->getLine()."<br>";
}


/////////////////////////INSERT/////////////////////////
//
//$queryIns = Query::insert("names", ["id", "name"])
//    ->build();
//
////dd($queryIns);
//
//$dataIns = [
//    'id' =>100,
//    'name' => 'user100'
//];

//$pgsql->prepareExecute($queryIns,$dataIns);

//
////////////////////////////////////////////////////////


/////////////////////////SELECT/////////////////////////
///
//$querySel = Query::select('names', ['id','name'])
//    ->distinct()
//    ->where(['id'])
//    ->leftJoin("cars", array("names.id = cars.id"))
//    ->rightJoin("cars", array("names.id = cars.id"))
//    ->naturalJoin("cars")
//    ->crossJoin("cars")
//    ->groupBy(array("column4"))
//    ->orderBy(['name'])
//    ->limit()
//    ->offset()
//    ->build();

//dd($querySel);

//$dataSel = [
//    'id'=>1
//];
/*
если в запросе не присутствует условие в метод prepareExecute второй параметр можем не передавать или передавать пустой массив
второй параметр обязательно должен быть массивом.
*/
//$stmt = $pgsql->prepareExecute($querySel,$dataSel);

//dd($stmt->fetchAll(PDO::FETCH_ASSOC));

//
////////////////////////////////////////////////////////


/////////////////////////DELETE/////////////////////////
///
//$queryDel = Query::delete('names')
//    ->where(['id'])
//    ->build();
//
//$dataDel = [
//    'id' => 100
//];

//dd($queryDel);

//$pgsql->prepareExecute($queryDel, $dataDel);
//
/////////////////////////////////////////////////////////


/////////////////////////UPDATE/////////////////////////
/// ключи в изменяемых ячейках не должны повторяться в параметре WHERE
//$queryUp = Query::update('names',['name'])
//    ->where(['id'])
//    ->build();
//
////dd($queryUp);
//
//$dataUp=[
//    'name'=>'user111',
//    'id'=> 100
//];

//$pgsql->prepareExecute($queryUp, $dataUp);

////////////////////////////////////////////////////////

//include 'src/view/index.php';
