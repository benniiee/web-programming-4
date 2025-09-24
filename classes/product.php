<?php

require_once "databases.php";

class Product extends Database
{
    public $name = "";
    public $category = "";
    public $price = "";

    public function addProduct()
    {
        $sql = "INSERT INTO product (name, category, price) VALUE (:name, :category, :price)";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":name", $this->name);
        $query->bindParam(":category", $this->category);
        $query->bindParam(":price", $this->price);

        return $query->execute();
    }

    public function viewProduct($name="", $category="")
    {
        $sql = "SELECT * from product WHERE name LIKE CONCAT('%', :name, '%') AND category LIKE CONCAT('%', :category, '%') ORDER BY name ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":name", $name);
        $query->bindParam(":category", $category);

        if ($query->execute())
            return $query->fetchAll();
        else
            return null;
    }

    public function doesProductExist($name)
    {
        // count how many book title exist in the database from the given name
        $sql = "SELECT COUNT(*) as total from product WHERE name = :name";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":name", $name);
        
        $book = [];

        // fetch the table column from the resulting query
        if ($query->execute())
            $book = $query->fetch();
        else
            return false;

        // returns true if a book exists, otherwise false
        return $book["total"] > 0 ? true : false;
    }
}

//$obj = new Product();
//$obj->name = "TV XX1";
//$obj->category = "Home Appliance";
//$obj->price = 1200;
//var_dump($obj->addProduct());