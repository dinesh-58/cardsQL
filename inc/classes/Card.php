<?php
// TODO: maybe use this (in getCards, SRS, rateCard)
class Card
{
    public int $id;
    public string $front;
    public string $back;
    // maybe: set enum here for direction?
    public string $direction;
    public int $successfulRevisions;
    public float $easeFactor;
    public int $interval;
    public string $scheduledDate;
    public int $folder_id;

    // TODO: implement methods for:
    // - updating this card in db?
    // - srs + update?

    // MAYBE: have one constructor that takes only card id & fills in other properties by getting data from db
}
