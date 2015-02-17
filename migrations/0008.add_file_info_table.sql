create table file_info (
  id int not null auto_increment primary key,
  name varchar(40) not null,
  author int not null,
  date_create timestamp NOT NULL DEFAULT NOW()
);