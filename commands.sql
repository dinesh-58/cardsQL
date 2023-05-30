-- these are for SQLite so some syntax may vary if you use a differentd RDBMS

-- creating cards
create table cards(
    id integer primary key autoincrement,
    front text not null check(length(front) <= 255),
    back text not null check(length(back) <= 255),
    direction int not null default 1
    check(direction >= 0 and direction <=3),
    successfulRevisions int not null default 0
    check(successfulRevisions >= 0),
    easeFactor real not null default 2.5
    check(easeFactor <=2.5 AND easeFactor >= 1.3),
    scheduledDate text not null default CURRENT_DATE
) strict;

-- direction values: 
    -- 0 : disabled
    -- 1 : forward direction
    -- 2 : bi-directional
    -- 3 : backward direction

-- CURRENT_DATE returns date as text in YYYY-MM-DD format
