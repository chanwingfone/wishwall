CREATE database `wishwall`;
use `wishwall`;
CREATE TABLE plugin_wish(
id int(8) not null auto_increment primary key,
name varchar(255) not null,
content varchar(255) not null,
bg_id tinyint(2) not null,
sign_id tinyint(2) not null,
ip varchar(255) not null default 0.0.0.0,
add_time datetime not null default 0000-00-00 00:00:00
);