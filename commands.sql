-- these are for SQLite so some syntax may vary if you use a differentd RDBMS

-- folders are used to group together related cards
create table folders(
    id integer primary key check(id > 0),
    name text not null unique check(length(name) <= 255)
);
insert into folders(id, name) values(1, 'Default');

-- front & back values are required when inserting new cards
-- others have default values set, so optional
-- id will also get auto incremented if not specified (due to being integer primary key)
create table cards(
    id integer primary key check(id > 0),
    front text not null check(length(front) <= 255),
    back text not null check(length(back) <= 255),
    direction text not null default 'forward' check(direction in ('disabled','forward','backward','both')),
    successfulRevisions int not null default 0 check(successfulRevisions >= 0),
    easeFactor real not null default 2.5 check(
        easeFactor <= 2.5
        AND easeFactor >= 1.3
    ),
    interval int not null default 1 check(interval >= 0),
    scheduledDate text not null default CURRENT_DATE check (
        length(scheduledDate) <= 10
        AND DATE(scheduledDate, '+0 days') IS scheduledDate
    ),
    folder_id integer default 0 references folders(id)
) strict;
-- NOTE: CURRENT_DATE returns date as text in YYYY-MM-DD format

-- seed w/ starter questions
insert into cards(front, back) values('What is a variable in programming?', 'A symbolic name for storing data values.');
insert into cards(front, back) values('What is an algorithm?', 'A finite set of instructions for solving a problem.');
insert into cards(front, back) values('What does CPU stand for?', 'Central Processing Unit, the primary part of a computer that performs calculations.');
