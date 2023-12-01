drop table if exists comments;
drop table if exists articles;
drop table if exists users;

create table users
(
    id              int AUTO_INCREMENT PRIMARY KEY,
    login           varchar(100) UNIQUE,
    password        varchar(255) not null
);
ALTER TABLE users AUTO_INCREMENT = 1;

insert into users(login, password) values 
('user1', '$2y$10$0sYGnvEXGZx5wshGxnubUu6oC3/eKUTwXpID2r5aPXVRh8hafbwwG'),
('user2', '$2y$10$0sYGnvEXGZx5wshGxnubUu6oC3/eKUTwXpID2r5aPXVRh8hafbwwG'),
('user3', '$2y$10$0sYGnvEXGZx5wshGxnubUu6oC3/eKUTwXpID2r5aPXVRh8hafbwwG'),
('user4', '$2y$10$0sYGnvEXGZx5wshGxnubUu6oC3/eKUTwXpID2r5aPXVRh8hafbwwG');

create table articles
(
    id int auto_increment primary key,
    title varchar(50) unique,
    author_id int,
    summary varchar(255) not null,
    content text not null,
    time datetime DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT check_article_author_id foreign key (author_id) references users (id) ON DELETE cascade
);
ALTER TABLE articles AUTO_INCREMENT = 1;

INSERT INTO articles (title, author_id, summary, content) values
('тема 1', 1, 'Краткое содержание 1', 'Основное содержание 1'),
('тема 2', 1, 'Краткое содержание 2', 'Основное содержание 2'),
('тема 3', 1, 'Краткое содержание 3', 'Основное содержание 3'),
('тема 4', 1, 'Краткое содержание 4', 'Основное содержание 4'),
('тема 5', 2, 'Краткое содержание 5', 'Основное содержание 5'),
('тема 6', 2, 'Краткое содержание 6', 'Основное содержание 6'),
('тема 7', 2, 'Краткое содержание 7', 'Основное содержание 7'),
('тема 8', 3, 'Краткое содержание 8', 'Основное содержание 8'),
('тема 9', 3, 'Краткое содержание 9', 'Основное содержание 9'),
('тема 10', 4, 'Краткое содержание 10', 'Основное содержание 10');

create table comments
(
    id int auto_increment primary key,
    article_id int,
    author_id int,
    content text not null,
    time datetime DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT check_comment_author_id foreign key (author_id) references users(id) ON DELETE cascade,
    CONSTRAINT check_comment_article_id foreign key (article_id) references articles(id) ON DELETE cascade
);
ALTER TABLE comments AUTO_INCREMENT = 1;

INSERT INTO comments (article_id, author_id, content) values
(1, 1, 'Коммент 1'),
(1, 2, 'Коммент 2'),
(1, 3, 'Коммент 3'),
(1, 4, 'Коммент 4'),
(2, 1, 'Коммент 1'),
(2, 1, 'Коммент 2'),
(2, 3, 'Коммент 3'),
(2, 3, 'Коммент 4');