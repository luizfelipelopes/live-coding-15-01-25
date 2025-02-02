
// write a function print numnebrs 1 to 100
// exceptions
  //- number. / 3 => Fizz
  // - nuimber / 5 => BUzz
  // - number / 3 and 5 => FizzBuzz
  // print my number
  
  
  function logNumbers()
  {
      
    for(i = 1; i <= 100; i++) {
      
      if(i % 3 == 0 && i % 5 == 0) {
        console.log('FizzBuzz');
        continue;
      }

      if(i % 3 == 0) {
        console.log('Fizz');
        continue;
      }
      
      if(i % 5 == 0) {
        console.log('Buzz');
        continue;
      }
        
      console.log(i)
      
    }
    
  }
  
  logNumbers();
