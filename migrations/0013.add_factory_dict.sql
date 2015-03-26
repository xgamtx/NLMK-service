create table nlmkService.dict_factory (
  id int not null primary key auto_increment,
  dict_id int,
  short_name varchar(150),
  long_name varchar(150)
);