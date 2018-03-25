create database lasi_maps;


create table sms_map_users(
	id int(12) primary key auto_increment,
	username varchar(255),
	password varchar(255),
	ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

create table sms_ssu_maps(
	id int(12) primary key auto_increment,
	ssuid int(12),
	filename text,
	filepath text,
	uploaded_by int(12),
	ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)

