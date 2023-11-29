drop table if exists users;

create table users
(
    user_id              int AUTO_INCREMENT PRIMARY KEY,
    user_email           varchar(100) UNIQUE,
    user_password        varchar(255) not null
);

insert into users(user_email, user_password)
values ('aladser@mail.ru', '$2y$10$H09UQUYdkD3uTmEXQsYQuukJNjF2XA1BGaBF0Deq0mu1qPLSEFZWe');
insert into users(user_email, user_password)
values ('aladser@gmail.com', '$2y$10$H09UQUYdkD3uTmEXQsYQuukJNjF2XA1BGaBF0Deq0mu1qPLSEFZWe');
insert into users(user_email, user_password)
values ('lauxtec@gmail.com', '$2y$10$H09UQUYdkD3uTmEXQsYQuukJNjF2XA1BGaBF0Deq0mu1qPLSEFZWe');