create database sisAcademico;
use sisAcademico;

create table estudiante (
	id 			int unsigned auto_increment primary key,
	dni 		char(8) not null,
	nombre 		varchar(50) not null,
	ape_paterno varchar(50) not null,
	ape_materno varchar(50) not null,
	direccion 	varchar(80) not null,
	telefono 	varchar(15) not null,
	semestre 	TINYINT unsigned NOT NULL,
	created_at 	timestamp default current_timestamp,
	updated_at 	timestamp default current_timestamp on update current_timestamp,

  constraint chk_estudiante_dni check (dni regexp'^[0-9]{8}$'),
  constraint chk_estudiante_telefono check (telefono is null or telefono regexp'^[0-9]{6,15}$'),
  constraint chk_estudiante_semestre check (semestre between 1 and 10)
);

create table profesor (
	id 				int unsigned auto_increment primary key,
	dni 			char(8) not null,
	nombre 			varchar(50) not null,
	ape_paterno 	varchar(50) not null,
	ape_materno 	varchar(50) not null,
	direccion 		varchar(80) not null,
	especialidad	varchar(100) not null,
	correo 			varchar(100) NOT NULL,
	created_at 		timestamp default current_timestamp,
	updated_at 		timestamp default current_timestamp on update current_timestamp,

	constraint chk_profesor_dni check (dni regexp'^[0-9]{8}$')
);

CREATE TABLE usuario (
    id_usuario 		INT AUTO_INCREMENT PRIMARY KEY,
    nombre 			VARCHAR(100) NOT NULL,
    ape_pat 		VARCHAR(100) NOT NULL,
    ape_mat 		VARCHAR(100) NOT NULL,
    dni 			CHAR(8) NOT NULL UNIQUE,
    usuario 		VARCHAR(50) NOT NULL UNIQUE,
    password 		VARCHAR(255) NOT NULL,
    rol 			VARCHAR(50) NOT NULL,
    fecha_registro 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
