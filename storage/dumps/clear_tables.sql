delete from users;
ALTER TABLE users AUTO_INCREMENT = 1;

insert into users(user_email, user_password)
values ('aladser@mail.ru', '$2y$10$H09UQUYdkD3uTmEXQsYQuukJNjF2XA1BGaBF0Deq0mu1qPLSEFZWe');
insert into users(user_email, user_password)
values ('aladser@gmail.com', '$2y$10$H09UQUYdkD3uTmEXQsYQuukJNjF2XA1BGaBF0Deq0mu1qPLSEFZWe');