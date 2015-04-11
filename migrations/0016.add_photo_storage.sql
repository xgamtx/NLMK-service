create table nlmkService.carriage_photo_storage (
  id int not null primary key auto_increment,
  name varchar(250) not null,
  carriage_id int not null,
  foreign key (carriage_id) references carriage (id)
);

alter table `carriage` add `inventory_image` varchar(120) null default null;