-- these are for SQLite so some syntax may vary if you use a differentd RDBMS

-- creating cards
create table cards(
    id integer primary key check(id > 0),
    front text not null check(length(front) <= 255),
    back text not null check(length(back) <= 255),
    direction text not null default 'forward' check(direction in ('disabled','forward','backward','both'))
    successfulRevisions int not null default 0 check(successfulRevisions >= 0),
    easeFactor real not null default 2.5 check(
        easeFactor <= 2.5
        AND easeFactor >= 1.3
    ),
    interval int not null default 1 check(interval >= 0),
    scheduledDate text not null default CURRENT_DATE check (
        length(scheduledDate) <= 10
        AND DATE(scheduledDate, '+0 days') IS scheduledDate
    )
) strict;

-- CURRENT_DATE returns date as text in YYYY-MM-DD format
