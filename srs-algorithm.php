<?php
// TODO: modify this to take & return Card object. update documentation below as well
/**
* Takes a card and user's rating for it. Sends back card object with updated values based on SM-2 algorithm
* Algorithm reference: https://en.wikipedia.org/wiki/SuperMemo#Description_of_SM-2_algorithm

*/
function scheduleNextRevision($card, $rating)
{
    // TODO: use Card class here
    // TODO: if $rating >3 throw exception. resulting value of $scheduledDate
    // seems to be same as $rating=3 due to imposing limit on easeFactor but still, throw?

    // no need for exceptions for other variables because constraints are already applied in database.
    // only this one is user specified

    // workaround for now
    $rating = $rating < 0 ? 0 : ($rating > 3 ? 3 : $rating);

    if ($rating >= 2) {
        // correct response
        $card["interval"] =
            $card["successfulRevisions"] == 0
                ? 1
                : ($card["successfulRevisions"] == 1
                    ? 6
                    : round($card["interval"] * $card["easeFactor"]));

        $card["successfulRevisions"]++;
    } else {
        // incorrect response
        $card["successfulRevisions"] = 0;
        $card["interval"] = 1;
    }

    // calculating new easeFactor
    $card["easeFactor"] += 0.1 - (4 - $rating) * (0.09 + (4 - $rating) * 0.03);

    // ensure easeFactor does not cross limits
    $card["easeFactor"] =
        $card["easeFactor"] < 1.3
            ? 1.3
            : ($card["easeFactor"] > 2.5
                ? 2.5
                : $card["easeFactor"]);

    // old scheduledDate value is only for checking if due today.
    // not used for calculating new scheduledDate
    // new scheduled date is just today + interval days
    $card["scheduledDate"] = date(
        "Y-m-d",
        strtotime("+" . $card["interval"] . " days"),
    );
    // TODO: maybe instead of returning entire card obj, only return changed values?
    // cuz otherwise, might not be sure which ones have changed & which to update. idk
    return $card;
}
