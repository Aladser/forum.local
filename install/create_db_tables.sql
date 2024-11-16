DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id int AUTO_INCREMENT PRIMARY KEY,
  login varchar(100) UNIQUE KEY,
  password varchar(255) NOT NULL
);

CREATE TABLE articles (
  id int AUTO_INCREMENT PRIMARY KEY,
  title varchar(50) DEFAULT NULL,
  author_id int,
  summary varchar(255) DEFAULT NULL,
  content text DEFAULT NULL,
  time datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (author_id) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE comments (
  id int AUTO_INCREMENT PRIMARY KEY,
  article_id int,
  author_id int,
  content text NOT NULL,
  time datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (article_id) REFERENCES articles (id) ON DELETE CASCADE,
  foreign key (author_id) REFERENCES users (id) ON DELETE CASCADE
);

INSERT INTO users VALUES (1,'user1','AAA'), (2,'user2','AAA'), (3,'user3','AAA');
INSERT INTO articles VALUES 
(1,'тема 1',1,'Краткое содержание 1','Основное содержание 1','2023-12-02 07:16:47'),
(2,'тема 2',1,'Краткое содержание 2','Основное содержание 2','2023-12-02 07:16:47'),
(3,'тема 3',1,'Краткое содержание 3','Основное содержание 3','2023-12-02 07:16:47'),
(4,'тема 4',1,'Краткое содержание 4','Основное содержание 4','2023-12-02 07:16:47'),
(5,'тема 5',2,'Краткое содержание 5','Основное содержание 5','2023-12-02 07:16:47'),
(6,'тема 6',2,'Краткое содержание 6','Основное содержание 6','2023-12-02 07:16:47'),
(7,'тема 7',2,'Краткое содержание 7','Основное содержание 7','2023-12-02 07:16:47'),
(8,'тема 8',3,'Краткое содержание 8','Основное содержание 8','2023-12-02 07:16:47'),
(9,'тема 9',3,'Краткое содержание 9','Основное содержание 9','2023-12-02 07:16:47'),
(10,'тема 10',3,'Краткое содержание 10','Основное содержание 10','2023-12-02 07:16:47');

INSERT INTO comments VALUES 
(1,1,1,'Коммент 1','2023-12-02 07:16:47'),
(2,1,2,'Коммент 2','2023-12-02 07:16:47'),
(3,1,3,'Коммент 3','2023-12-02 07:16:47'),
(4,2,1,'Коммент 1','2023-12-02 07:16:47'),
(5,2,1,'Коммент 2','2023-12-02 07:16:47'),
(6,2,3,'Коммент 3','2023-12-02 07:16:47'),
(7,2,3,'Коммент 4','2023-12-02 07:16:47');

