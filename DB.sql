create database if not exists agile_db;
use agile_db;

CREATE TABLE Utenti(
	ID int auto_increment primary key,
  	nome varchar(30) not null,
    cognome varchar(30) not null,	
	username varchar(100) not null UNIQUE,
    password char(64) not null UNIQUE
);

CREATE TABLE Impianti(
	ID int auto_increment primary key,
	nome varchar(30) not null,
	indirizzo varchar(30) not null,
	numero_telefono int not null UNIQUE,
	email varchar(30) not null,
	lista_sport varchar(100) not null,
	regole_di_prenotazione varchar(100) not null
);

CREATE TABLE Soci(
	ID int auto_increment primary key,
	nome_socio varchar(30) not null,
	cognome_socio varchar(30) not null,
	numero_telefono int not null UNIQUE,
	email varchar(30) not null,
	saldo_wallet int not null,
);

CREATE TABLE Lezioni( 
	data_lezione date not null,
	ora_lezione datetime not null,
	durata int not null,
	tipologia_sport varchar(30) not null,
	maestro varchar(30) not null,
	posti_disponibili int not null
);

CREATE TABLE Prenotazioni(
	data_prenotazione date not null,
	orario_prenotazione datetime not null,
	tipologia sport varchar(30) not null,
	impianto_scelto varchar(30) not null,
	numero_partecipanti int not null,
	lezione_associata varchar(30) not null
	FOREIGN KEY (username) REFERENCES Utenti(username)
);

CREATE TABLE Wallet(
	data_transazione date not null,
	orario_transazione datetime not null,
	importo int not null,
	impianto_scelto varchar(30)
);
