<?php

include '../Rest.php';

class Cars extends Rest
{

  public function getCars()
  {
    echo "string";

  }

   public function postCars()
   {

   }

   public function putCars()
   {

   }

   public function deleteCars()
   {

   }

}

$obj = new Cars();
$obj->start();
