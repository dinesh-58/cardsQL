<?php
function scheduleNextRevision($card, $rating) {
    // TODO if $rating >3 throw exception. resulting value of $scheduledDate
    // seems to be same as $rating=3 due to imposing limit on easeFactor but still, throw?
    
    // no need for exceptions for other variables because constraints are already applied in database.
    // only this one is user specified
    
    // workaround for now
    $rating = $rating < 0 ? 0 : ($rating > 3 ? 3 : $rating);

    if ($rating >=2) {   // correct response
        $card['interval'] = ($card['successfulRevisions'] == 0) ? 1  
        : (($card['successfulRevisions'] == 1) ? 6
        : round($card['interval'] * $card['easeFactor']));

        $card['successfulRevisions']++; 
    } else {            // incorrect response
        $card['successfulRevisions'] = 0;
        $card['interval'] = 1;
    }

    // calculating new easeFactor
    $card['easeFactor'] += (0.1 - (4-$rating) * (0.09 + (4-$rating) * 0.03)); 

    // ensure easeFactor does not cross limits
    $card['easeFactor'] = ($card['easeFactor'] < 1.3) ? 1.3 
    : (($card['easeFactor'] > 2.5) ? 2.5 
    : $card['easeFactor']);

    // old scheduledDate value is only for checking if due today. 
    // not used for calculating new scheduledDate
    // new scheduled date is just today + interval days
    $card['scheduledDate'] = date('Y-m-d', strtotime('+'.$card['interval'].' days'));  
    return $card;
}
