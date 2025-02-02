<?php
	
	
	//Customer
	
	  // select a product
	  // provide a amount of money
	
	// Sales Person
	
	  // Provide the product
	    // if customer provide too much mney => return amount of change
	    // if insufficient funds are provided => ask for more money
	    
	 // Restock products
	 // Replinish money available
	 
	 // Has initital inventory of products
	 // Has initial change money   
	    // 1 cent
	    // 5 cents
	    // 10 cents
	    // 25 cents
	    // 50 cents
	    // $1
	    // $2
	
	
	
	class SalesPerson {
	  
	  private $products;
	  private $money;
	  private $cash;
	  
	  public function __construct(array $products, array $money)
	  {
	    $this->products = $products;
	    $this->money = $money;
	  }
	  
	  public function provideProduct(Customer $customer): object
	  {
	    $product = $this->products[$customer->product->code];
	    $money = $customer->fundsProduct;
	    
	    if($product['price'] > $money) {
	      
	      return (object) [
	        'status' => false,
	        'message' => "Insufficient funds provided! It is necessary more money\n"];
	      
	    }
	    
	    if($product['price'] < $money) {
	      
	      $change = $money - $product['price'];
	      $changeMoney = $this->calculateChange($change);
	      
	      if(!is_array($changeMoney) && $changeMoney > 0) {
	        return (object) [
	        'status' => false,
	        'message' => "Insufficient currencies for change provided! It is necessary replanish money with $$changeMoney\n",
	        'change' => $changeMoney];
	      }
	      
	      $this->money = $this->cash;
	      $changeMoney = implode(',', $changeMoney);
	      
	      return (object) [
	        'status' => true,
	        'message' => "Purchase commited! Take your change money: $changeMoney \n",
	        'change' => $change];
	      
	    }

      return (object) [
	        'status' => true,
	        'message' => "Purchase commited! \n",
	        ];	    
	  }
	  
	  private function calculateChange(float $diffMoney): array|float
	  {
	    
	    $usedCurrencys = [];
	    $currencys = [2, 1, 0.50, 0.25, 0.10, 0.05, 0.01];
	    $this->cash = $this->money;
	    
	    foreach($currencys as $currency) {
	      
	      if($diffMoney == 0) {
	        return $usedCurrencys;
	      }
	      
	      while($diffMoney >= $currency 
	      && isset($this->cash[strval($currency)]) 
	      && $this->cash[strval($currency)] > 0) 
	      {
	          $diffMoney = round($diffMoney-$currency,2);
	          $this->cash[strval($currency)]--;
	          $usedCurrencys[] = $currency;
	      }
	    }
	    
	    
	    if($diffMoney > 0) {
	      return $diffMoney;
	    }
	    
	    return $usedCurrencys;
	    
	  }
	  
	  public function addToCashRegister(float $amount): void
	  {
	    $currencys = [2, 1, 0.50, 0.25, 0.10, 0.05, 0.01];
	    
	    foreach($currencys as $currency){
	      while($amount >= $currency) {
	        $amount = round($amount - $currency, 2);
	        $this->money[strval($currency)] = ($this->money[strval($currency)] ?? 0) + 1;
	      }
	    }
	  }
	  
	  public function addCash(float $currency, int $quantity): void
	  {
	    $this->money[strval($currency)] = ($this->money[strval($currency)] ?? 0) + $quantity;
	  }
	  
	  public function restockProduct(Product $product, int $quantity): void
	  {
	    $this->products[$product->code]['quantity'] += $quantity;
	  }
	  
	  public function checkInventory(): array
	  {
	    return $this->products;  
	  }
	  
	  public function checkMoney(): array
	  {
	    return $this->money;  
	  }
	  
	}
	
	
	class Customer {
	  
	  private $money;
	  public $fundsProduct;
	  public $product;
	  
	  public function __construct(float $money)
	  {
	    $this->money = $money;
	  }
	  
	  public function pickProduct(Product $product)
	  {
	    $this->product = $product;
	  }
	  
	  public function provideMoney(float $money)
	  {
	    $this->money -= $money;
	    $this->fundsProduct = $money;
	    
	    return $this->fundsProduct;
	  }
	  
	  public function receiveChange(float $money)
	  {
	    $this->money += $money;
	    
	  }
	  
	}
	
	
	class Product {
	  public $code;
	  public $price;
	  
	  public function __construct(string $code, float $price)
	  {
	    $this->code = $code;
	    $this->price = $price;
	  }
	}
	
	
	$product1 = new Product('123', 400);
	$product2 = new Product('456', 200);
	$product3 = new Product('789', 300);
	
	
	$initialInventory = [
	       "{$product1->code}" => [
	            'price' => $product1->price,
	            'quantity' => 3,
	         ],
	         "{$product2->code}" => [
	            'price' => $product2->price,
	            'quantity' => 4,
	         ],
	         "{$product3->code}" => [
	            'price' => $product3->price,
	            'quantity' => 5,
	         ]
	  ];
	  
	 
	 $moneyForChange = [
	   
	       '0.01' => 3,
	       '0.05' => 4,
	       '0.1' => 5,
	       '0.25' => 6,
	       '0.5' => 7,
	       '1' => 8,
	       '2' => 10,
	 ];
	  
	
	$salesPerson = new SalesPerson($initialInventory, $moneyForChange);
	$customer = new Customer(1000);
	
	$customer->pickProduct($product1);
	$customer->provideMoney(1500);
	
	$productProvided = $salesPerson->provideProduct($customer);
	
	if($productProvided->status && isset($productProvided->change)) {
	  $customer->receiveChange($productProvided->change);
	}
	
	echo $productProvided->message;
	
	$salesPerson->addToCashRegister(66.27);
	$productProvided = $salesPerson->provideProduct($customer);
	echo $productProvided->message;
	
	$salesPerson->addToCashRegister(1000);
	$productProvided = $salesPerson->provideProduct($customer);
	echo $productProvided->message;
	
	$salesPerson->addCash(2, 20);
	$salesPerson->addCash(1, 200);
	$salesPerson->addCash(0.10, 200);
// 	var_dump($salesPerson->checkMoney());
	
// 	var_dump($salesPerson->checkInventory());
	
	$salesPerson->restockProduct($product1, 4);
	
// 	var_dump($salesPerson->checkInventory());
	
	
	
	
	
