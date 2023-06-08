<?php

// SM-2
// ef' = f(ef, q) // make function for this?

//  ------ default values. don't copy these
$quality = readline('Enter card rating: ');  // 0-3
$interval = 1;
$easeFactor = 2.5;
$successfulRevisions = 12;
//  ------ till here

// TODO if $quality >3 throw exception. result of $scheduledDate seems to be same as $quality=3 due to imposing limit but still, throw?
// or if > 3, set equals to 3?
// no need for other variables because constraint is already applied. only this one is user specified
$quality = $quality < 0 ? 0 : ($quality > 3 ? 3 : $quality);
// throw exception nai? kinaki it will help find any potential problems
if ($quality >=2) {   // correct response
    $interval = ($successfulRevisions == 0) ? 1  
    : (($successfulRevisions == 1) ? 6
    : round($interval * $easeFactor));

    $successfulRevisions++; 
} else {            // incorrect response
    $successfulRevisions = 0;
    $interval = 1;
}
// calculating new easeFactor
$easeFactor += (0.1 - (4-$quality) * (0.09 + (4-$quality) * 0.03)); 
// ensure easeFactor does not cross limits
$easeFactor = ($easeFactor < 1.3) ? 1.3 
: (($easeFactor > 2.5) ? 2.5 
: $easeFactor);

// old scheduledDate value is only for checking if due today or not
// new scheduled date is just today + interval days
$scheduledDate = date('Y-m-d', strtotime("+$interval days"));  
// return n, EF, I
echo "ns: $successfulRevisions\n";
echo "EF: $easeFactor\n";
echo "In: $interval\n";
echo "RD: $scheduledDate";



/*
echo 'Using mktime: '.mktime(0,0,0,date("m"),date('d'),date('Y'));
echo 'Using time(): '.time();
*/
