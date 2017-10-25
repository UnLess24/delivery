<?php 
class Delivery
{
  private $deliveryValue;
  private $everyKgPrice;
  private $periodLimit = NULL;
  private $firstPeriodPrice = NULL;
  private $secondPeriodPrice = NULL;
  
  // $deliveryValue - количество килограмм, $everyKgPrice - цена доставки за килограмм,
  // $periodLimit - граница разграничения первого и второго диапазонов для формирования цены
  // $firstPeriodPrice, $secondPeriodPrice - цены диапазонов
  public function __construct($deliveryValue = 0, $everyKgPrice = 0, $periodLimit = NULL, $firstPeriodPrice = NULL, $secondPeriodPrice = NULL)
  {
    $this->deliveryValue = (is_numeric($deliveryValue) && $deliveryValue >= 0) ? $deliveryValue : 0;
    $this->everyKgPrice = (is_numeric($everyKgPrice) && $everyKgPrice >= 0) ? $everyKgPrice : 0;
    
    if ($everyKgPrice == 0 && isset($options)) {
      $this->periodLimit = $periodLimit;
      $this->firstPeriodPrice = $firstPeriodPrice;
      $this->secondPeriodPrice = $secondPeriodPrice;
    }
  }

  // Если цена до лимита ЗА КИЛОГРАММ, после лимита ИТОГО
  public function getPrice()
  {
    if ($this->isPeriodPrice()) {
      if ($this->deliveryValue <= $this->periodLimit) {
        return $this->deliveryValue * $this->firstPeriodPrice; 
      } else {
        return $this->secondPeriodPrice;
      }
    }
    return $this->deliveryValue * $this->everyKgPrice;
  }

  // Если цена до лимита и после - ЗА КИЛОГРАММ
  public function getPriceLimitKG()
  {
    if ($this->isPeriodPrice()) {
      if ($this->deliveryValue <= $this->periodLimit) {
        return $this->deliveryValue * $this->firstPeriodPrice; 
      } else {
        return $this->deliveryValue * $this->secondPeriodPrice;
      }
    }
    return $this->deliveryValue * $this->everyKgPrice;
  }

  // Если цена до лимита и после - ИТОГО
  public function getPriceLimit()
  {
    if ($this->isPeriodPrice()) {
      if ($this->deliveryValue <= $this->periodLimit) {
        return $this->firstPeriodPrice; 
      } else {
        return $this->secondPeriodPrice;
      }
    }
    return $this->deliveryValue * $this->everyKgPrice;
  }

  private function isPeriodPrice()
  {
    return !is_null($this->periodLimit);
  }
}
?>
