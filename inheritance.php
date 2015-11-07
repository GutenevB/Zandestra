<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07.11.15
 * Time: 20:21
 */
header("Content-type:text/html; charset=utf-8");
class ShopProduct
{
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



// $test = new ShopProduct('PHP','Zandrsta','Mett',500);
//echo $test->getProducer();
//echo $test->getSummaryLine();
//$test1 = new BookProduct('PHP','Zandrsta','Mett',500,90);
//echo $test1->getSummaryLine();





































