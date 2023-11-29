drop table if exists comments;
drop table if exists articles;
drop table if exists users;

create table users
(
    id              int AUTO_INCREMENT PRIMARY KEY,
    login           varchar(100) UNIQUE,
    password        varchar(255) not null
);
insert into users(login, password)
values ('aladser@mail.ru', '$2y$10$0sYGnvEXGZx5wshGxnubUu6oC3/eKUTwXpID2r5aPXVRh8hafbwwG');
insert into users(login, password)
values ('aladser@gmail.com', '$2y$10$0sYGnvEXGZx5wshGxnubUu6oC3/eKUTwXpID2r5aPXVRh8hafbwwG');

create table articles
(
    id int auto_increment primary key,
    title varchar(50),
    author_id int,
    summary varchar(255),
    content text,
    time datetime,
    CONSTRAINT check_article_author_id foreign key (author_id) references users (id) ON DELETE cascade
);

create table comments
(
    id int auto_increment primary key,
    article_id int,
    author_id int,
    content text,
    time datetime,
    CONSTRAINT check_comment_author_id foreign key (author_id) references users(id) ON DELETE cascade,
    CONSTRAINT check_comment_article_id foreign key (article_id) references articles(id) ON DELETE cascade
);