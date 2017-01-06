drop database if exists gym;
create database gym;
use gym;

create table usuario (
	id int primary key auto_increment,
	nombre varchar(100) not null,
	apellidos varchar(100) not null,
	dni varchar(10) unique not null,
	correo varchar(100) not null unique,
	tipo int not null,
	password varchar(255) not null
);

insert into usuario values (1, 'Miguel', 'Vicente Moure', '53817477F', 'mvicmoure@gmail.com', 0, '$2y$10$sKqI7lxbBJCtk77FVJlTgeEHbNK9GDgOERJtfXfBCjg3QS61zk.8y'); -- password: admin
insert into usuario values (2, 'Entrenador', 'Perez Lopez', '12345678J', 'entrenador@gym.com', 1, '$2y$10$y1vTDuJh7GIa3IbfXvTvYeBO5MpKg1xHAij2AMcJOMY7D9GKdCRjS'); -- password: entrenador
insert into usuario values (3, 'Pepe', 'Deportista', '234567890L', 'pepe@deportistasunidos.com', 2, '$2y$10$wm5DJ1PGVnUf9.jZDwyOEOMO.bcY62pbi4GCSPCQeUHRUblMJDvBm'); -- password: pepe 

create table actividad (
	id int primary key auto_increment,
	nombre varchar(100) not null,
	numPlazasMax int
);

insert into actividad values (1, 'Anaerobicos', 30);
insert into actividad values (2, 'Running', 30);

create table plaza (
	id int primary key auto_increment,
	fecha date,
	actividadId int,
	usuarioId int,
	foreign key (actividadId) references actividad(id) on delete cascade,
	foreign key (usuarioId) references usuario(id) on delete cascade
);

insert into plaza values (0, '2016-10-31 18:00:00', 2, 3);

create table notificacion (
	id int primary key auto_increment,
	nombre varchar(100) not null,
	texto varchar(255) not null,
	receptorId int,
	emisorId int,
	foreign key (receptorId) references usuario(id) on delete cascade,
	foreign key (emisorId) references usuario(id) on delete cascade
);

insert into notificacion values (1, 'Bienvenido al sistema', 'Hola, bienvenido.', 3, 1);

create table ejercicio (
	id int primary key auto_increment,
	nombre varchar(100) not null,
	descripcion varchar(1024) not null,
	imagen blob,
	video blob,
	dificultad int not null
);

insert into ejercicio values ( 1, 'Flexiones', 'Levantarse del suelo con las manos', null, null, 2);
insert into ejercicio values ( 2, 'Abdominales', 'Contraer la barriga con fuerza', null, null, 3);

create table tablaEjercicios (
	id int primary key auto_increment,
	nombre varchar(100) not null,
	tipo int not null,
	dificultadGlobal int not null,
	actividadId int,
	foreign key (actividadId) references actividad(id)
);

insert into tablaEjercicios values ( 1, 'Estiramiento', 0, 3, 1 );

create table usuario_esAsignado_tablaEjercicios (
	usuarioId int,
	tablaEjerciciosId int,
	foreign key (usuarioId) references usuario(id),
	foreign key (tablaEjerciciosId) references tablaEjercicios(id) on delete cascade
);

insert into usuario_esAsignado_tablaEjercicios ( 3, 1);

create table tablaEjercicios_contiene_ejercicio (
	tablaEjerciciosId int,
	ejercicioId int,
	foreign key (tablaEjerciciosId) references tablaEjercicios(id) on delete cascade, 
	foreign key (ejercicioId) references ejercicio(id) on delete cascade

);

insert into tablaEjercicios_contiene_ejercicio values ( 1, 1);
insert into tablaEjercicios_contiene_ejercicio values ( 1, 2);

create table sesionEntrenamiento (
	id int primary key auto_increment,
	inicio datetime not null,
	fin datetime not null,
	nombre varchar(100) not null,
	actividadId int,
	entrenadorId int,
	foreign key (actividadId) references actividad(id),
	foreign key (entrenadorId) references usuario(id) on delete set null
);

insert into sesionEntrenamiento values (1, '2016-10-31 09:00:00',
	'2016-10-31 10:30:00',
	'Ejercicios basicos',
	1,
	2
);

create table usuario_asiste_entrenamiento (
	usuarioId int,
	sesionEntrenamientoId int,
	foreign key (usuarioId) references usuario(id) on delete cascade,
	foreign key (sesionEntrenamientoId) references sesionEntrenamiento(id) on delete cascade
);

insert into usuario_asiste_entrenamiento values (3, 1);

select * from usuario;
select * from sesionEntrenamiento;
select * from usuario_asiste_entrenamiento;
select * from actividad;
select * from plaza;
select * from notificacion;
select * from ejercicio;
select * from tablaEjercicios_contiene_ejercicio;
select * from tablaEjercicios;
