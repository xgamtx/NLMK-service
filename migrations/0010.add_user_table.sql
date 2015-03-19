create table nlmkService.tbl_user (
  id int not null auto_increment primary key,
  username varchar(45),
  password varchar(45),
  auth_key varchar(32),
  password_reset_token varchar(255),
  state varchar(15)
);