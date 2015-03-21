create table nlmkService.log (
  id int not null auto_increment primary key,
  carriage_id int not null,
  message text,
  datetime timestamp default now(),
  foreign key (carriage_id) references carriage (id)
)