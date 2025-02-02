# Technical Test - 15/01/2025

## Javascript (Test 1)

Write a function that logs numbers from 1 to 100 but with a few exceptions:

### Requirements

1. For any number evenly divisible by 3, print "Fizz"
```js
console.log("Fizz")
```

2. For any number evenly divisible by 5, print "Buzz"
```js
console.log("Buzz")
```

3. For any number evenly divisible by 3 and 5, print "FizzBuzz"
```js
console.log("FizzBuzz")
```

4. In all other cases, log the number

**Here is a partial example result with numbers from 11 to 20:**

```js
  11
  Fizz
  13
  14
  FizzBuzz
  16
  17
  Fizz
  19
  FizzBuzz
```

## PHP - The Sales Person (Test 2)

Design the workflow of a salesperson in code. The behavior should be performed as follows:

1. Once a customer selects an item and provides the appropriate amount of money, the salesperson should provide the correct product;
2. If the customer provides too much money, the salesperson should return the correct amount of change. If insufficient funds are provided, it should tell the customer and ask for more money;
3. The salesperson should start with an initial inventory of products and an initial amount of money for change. The change will consist of the following denominations: 1 cent, 5 cents, 10 cents, 25 cents, 50 cents, $1, and $2;
4. There should be a way to restock products or replenish the money available for change at a later time;
5. The salesperson should keep track of the current inventory of products and the money available for change.
