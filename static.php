<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07.11.15
 * Time: 23:10
 */
header("Content-type:text/html; charset=utf-8");
class ShopProduct
{
    private $id;
    private $title;
    private $producerMainName;
    private $producerFirstName;
    protected $price;
    private $discount = 0;

    public function __construct($title,$firstName,$mainName,$price){
        $this->title                = $title;
        $this->producerMainName     = $mainName;
        $this->producerFirstName    = $firstName;
        $this->price                = $price;
    }

    public function setDiscount($num)
    {
        $this->discount = $num;
    }

    public function setID($id)
    {
        $this->id= $id;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getProducerMainName()
    {
        return $this->producerMainName;
    }

    public function getProducerFirstName()
    {
        return $this->producerFirstName;
    }

    public function getPrice()
    {
        return $this->price - $this->discount;
    }

    public function getProducer()
    {
        return "{$this->producerFirstName}" . "{$this->producerMainName}";
    }

    public function getSummaryLine()
    {
        $finish = "{$this->title} ({$this->producerMainName}, ";
        $finish .= "{$this->producerFirstName})";
        return $finish;
    }

    public static function getInstance($id, PDO $pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id=?");
        $result = $stmt->execute(array($id));
        $row = $stmt->fetch();
        if (empty($row)) {return null;}

        if ($row['type']==="book"){
            $product = new BookProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['numpage']
            );
        }elseif ($row['type'] === "CD"){
            $product = new CDProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['playlength']
            );
        }else{
            $product = new ShopProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price']
            );
        }
        $product->setID($row['id']);
        $product->setDiscount($row['discount']);
        return $product;
    }

}

class CDProduct extends ShopProduct
{
    private $playLength = 0;

    public function __construct($title,$firstName,$mainName,$price,$playLength)
    {
        parent::__construct($title,$firstName,$mainName,$price);
        $this->playLength = $playLength;
    }

    public function getPlayLength()
    {
        return $this->playLength;
    }

    public function getSummerLine()
    {
        $res = parent::getSummaryLine();
        $res.= " Время звучания - {$this->playLength}";
        return $res;
    }
}


class BookProduct extends ShopProduct
{
    private $numPage = 0;

    public function __construct($title, $firstName, $mainName, $price, $numPage)
    {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->numPage = $numPage;
    }

    public function getNumberOfPages()
    {
        return $this->numPage;
    }

    public function getSummaryLine()
    {
        $res = parent::getSummaryLine();
        $res .= " Страниц в книге - {$this->numPage}";
        return $res;
    }

    public function getPrice()
    {
        return $this->price;
    }
}


define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'intividual');
define('DB_USER', 'root');
define('DB_PASS', 'root');

    $connect_str = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
    $pdo = new PDO($connect_str, DB_USER, DB_PASS);
    $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $obj = ShopProduct::getInstance(2,$pdo);
echo "<pre>";
    var_dump($obj);
echo "</pre>";