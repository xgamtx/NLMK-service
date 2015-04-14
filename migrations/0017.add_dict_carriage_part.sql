create table nlmkService.dict_carriage_part (
  id int not null primary key auto_increment,
  name varchar(100),
  description varchar(200),
  part_type smallint,
  feature integer,
  price float,
  weight float not null
);
