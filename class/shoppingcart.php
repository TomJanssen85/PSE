<?php

class Shoppingcart {
    private $queries;
    public $orderlines; // de te bestellen producten en aantallen
    
    public $userid;
    public $orderid;

    public $status;
    
    public function Shoppingcart() {
	// todo
		$this->queries = Base::get('Queries', array('products'), true);
    }
    
    public function toevoegen($product, $amount) {
        if (isset ($_POST['bestel'])) {
        $artikelFound = false;
        
        if (sizeof($this->orderlines)>0) {
        foreach ($_SESSION['Cart']['Products']->orderlines as $bestelregel) {
             if ($bestelregel->product->getProductID() == $product->getProductID()){
                   $productFound = true;
                   $bestelregel->amount = $bestelregel->amount + $amount;
          }
        }
        }
             if(!$productFound)
            {
              $this->orderlines[] = new Orderline($product, $amount);
         }
    }
        }    
    
    
    public function verwijderen($productID) {
        
        if (sizeof($this->orderlines)>0) {
            
            foreach($this->orderlines as $index=>$bestelregel) {
                           
               if($bestelregel->artikel->getArtikelnummer() == $productID){
                    unset($this->orderlines[$index]);
               }
            }
        }
    }    
    
    public function printShoppingcart() {
	// todo!
	$totaalprijs = 0.00;
        if(sizeof($_SESSION['Cart']['Products']->orderlines)>0) {
        $html = "<h1>Winkelwagen</h1>";
        $html.= "<table border='1'>";
        $html.= "<tr><td>Naam</td>
                <td>Product type</td>
                <td>Aantal</td>
                <td>Prijs</td>
                <td>Totaal</td>
                <td>Wijzig</td>";
        foreach ($_SESSION['Cart']['Products'] as $orderline) {
	    $html.= "<form method='get' action=".$_SERVER['PHP_SELF'].">";
            $html.= $orderline->tableRow();
            $html.= "</form>";
            $totaalprijs = $totaalprijs + $orderline->totaalPrijs();
            $totaalprijs = number_format ($totaalprijs , 2 , "," , "." );
        }
        $html.= "<tr><td colspan='3'>Totaal bestelling:</td>
                     <td>&#8364;".$totaalprijs."</td></tr>";
        $html.= "</table><br />";
        $html.= "<hr><br />";
        $html.= "<form action='' method='post'>";
        $html.= "<input type='submit' name='verderwinkelen' value='Naar catalogus' />";
        $html.= "<input type='submit' name='plaatsenbestelling' value='Bestelling plaatsen' />";
        $html.= "</form>";
        return $html;
        } 
        
        else {
        $html = "<h1>Uw winkelwagen is momenteel leeg. </h1> <br />";
        $html.= "<form action='' method='post'>";
        $html.= "<input type='submit' name='verderwinkelen' value='Naar catalogus' />";
        $html.= "</form>";
        
        return $html;
        }
    }
    
 public function printOrder() {
 	$totaalprijs = 0.00;
        if(sizeof($this->orderlines)>0) {
        
        //$html.= "<form method='post' action=".$_SERVER['PHP_SELF'].">";
        $html= "<table border='1'>";
        $html.= "<tr><td>Naam</td>
                <td>Product type</td>
                <td>Aantal</td>
                <td>Prijs</td>
                <td>Totaal</td>
                <td>Wijzig</td>";
        foreach ($_SESSION['Cart']['Products']->orderlines as $orderline) {
	    $html.= "<form method='get' action=".$_SERVER['PHP_SELF'].">";
            $html.= $orderline->bestelRij();
            $html.= "</form>";
            $totaalprijs = $totaalprijs + $orderline->totaalPrijs();
            $totaalprijs = number_format ($totaalprijs , 2 , "," , "." );
        }
        $html.= "<tr><td colspan='3'>Totaal bestelling:</td>
                     <td>&#8364;".$totaalprijs."</td></tr>";
        if ($totaalprijs < 150){
            $bezorg = 15;
            $totaal = $bezorg + $totaalprijs;
            $totaal = number_format ($totaal , 2 , "," , "." );
            $html.= "<tr><td colspan='3'>Bezorgkosten:</td>
                <td>&#8364;15,00</td></tr>";
            $html.= "<tr><td colspan='3'>Inclusief bezorgkosten:</td>
                <td>&#8364;".$totaal."</td></tr>";
                    $html.= "</table><br />";
        $html.= "<hr><br />";
        $html.= "<form action='' method='post'>";
        // $html.= "<input type='submit' name='verderwinkelen' value='verder winkelen' />";
        // $html.= "<input type='submit' name='plaatsenbestelling' value='bestelling plaatsen' />";
        $html.= "</form>";
            
        } else {
        $html.= "</table><br />";
        $html.= "<hr><br />";
        $html.= "<form action='' method='post'>";
        // $html.= "<input type='submit' name='verderwinkelen' value='verder winkelen' />";
        // $html.= "<input type='submit' name='plaatsenbestelling' value='bestelling plaatsen' />";
        $html.= "</form>";
        }
        return $html;
             
} 
}

    public function bezorgDatum($dag, $maand, $jaar)
        {
            return checkdate($maand, $dag, $jaar);
        }
    
    public function maxOrderID() {
        $sql = "SELECT MAX(orderid) FROM orders";
        $this->mydb->doQuery($sql);
        $result = $this->mydb->fetchArray();
        $this->orderid = $result[0] + 1; 
        
    return $this->orderid;
    }    
        
public function saveOrder() {
        $this->besteldatum = date("Y-m-d");
        $this->bezorgdatum = $_SESSION['winkelwagen']->bezorgdatum;
        $this->status = "in behandeling";
        $this->orderid = $this->maxOrderID();
        $this->userid = $_SESSION['huidigeKlant']->userid; 
 

$sqlsave = "INSERT INTO bestelling (orderid, userid, besteldatum, bezorgdatum, status, betalingswijze, opmerking)
        VALUES ('$this->orderid','$this->userid','$this->besteldatum','$this->bezorgdatum','$this->status', '$this->betaalwijze','$this->opmerking')";

$this->mydb->doQuery($sqlsave);

foreach ($this->orderlines as $regel)
{
$artNummer = $regel->artikel->getArtikelnummer();    
$gereserveerd = $regel->artikel->gereserveerd; 
    
$sql1="INSERT INTO bestelregel VALUES ('$this->orderid', '$artNummer', '$regel->amount')";
$this->mydb->doQuery($sql1);

$sql2="SELECT gereserveerd FROM artikel WHERE
artikelnummer='".$artNummer."'";
$this->mydb->doQuery($sql2);
$result = $this->mydb->fetchArray();
$gereserveerd = $result['gereserveerd'] + $regel->amount; 
// uitvoeren haalt de waarde van gereserveerd op
// verhoog de waarde van gereserveerd met $amount
$sql3 = "UPDATE artikel SET gereserveerd ='".$gereserveerd."' WHERE artikelnummer='".$artNummer."'";
$this->mydb->doQuery($sql3);
//uitvoeren van dit statement wijzigt het veld gereserveerd
}
    }    
        
        
}
?>
