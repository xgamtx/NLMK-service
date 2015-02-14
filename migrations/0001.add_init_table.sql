create table nlmkService.carriage (
  id int not null primary key,
  carriage_type varchar(20),
  brutto_weight float,
  status int
);

create table nlmkService.wheelset (
  id int not null primary key,
  produced_year int,
  factory int,
  right_wheel_width int,
  left_wheel_width int,
  real_produced_year int,
  real_factory int,
  carriage_id int(10),
  foreign key (carriage_id) references carriage (id)
);

create table nlmkService.side_frame (
  id int not null primary key,
  produced_year int,
  factory int,
  real_produced_year int,
  real_factory int,
  carriage_id int(10),
  foreign key (carriage_id) references carriage (id)
);

create table nlmkService.bolster (
  id int not null primary key,
  produced_year int,
  factory int,
  real_produced_year int,
  real_factory int,
  carriage_id int(10),
  foreign key (carriage_id) references carriage (id)
);

create table nlmkService.comment (
  id int auto_increment not null primary key,
  content text,
  date_create datetime,
  carriage_id int(10),
  foreign key (carriage_id) references carriage (id)
);