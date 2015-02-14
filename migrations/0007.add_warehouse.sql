create table nlmkService.warehouse (
  id int not null auto_increment primary key,
  name varchar(40)
);

alter table carriage add column warehouse_id int;
alter table carriage add foreign key (warehouse_id) references warehouse(id);