/**
 *item in the menu (IHM)
 */
DROP TABLE IF EXISTS item;
create table item( 
	id_item INT PRIMARY KEY AUTO_INCREMENT, 
	name varchar(255),
	link varchar(255)
	);

/**
 * element in the item
 */
DROP TABLE IF EXISTS element;
create table element( 
	id_element INT PRIMARY KEY AUTO_INCREMENT ,
	name varchar(255) ,
	url varchar(255) ,
	the_item int, 
	FOREIGN KEY (the_item) references item(id_item)
	);

/**
 *company's informations and to display on the bill
 */
DROP TABLE IF EXISTS information_company;
create table information_company(
	id_information int primary key auto_increment,
	attribut varchar(255),
	value varchar(255),
	gras int, /* 1 h1, 2:h2 ......6:h6 et 0 text */
	show_attribut boolean, /* afficher l'attribut dans la facture ?*/
	position_orizontal int, /* 0: entete, 1: en dessous de l'entete*/
	position_vertical int, /* 0:a gauche et 1:  droite */
	chek_removed int  /* peut prendre 2 valeurs différentes 0 ou 1 (false , true) si true donc cette ligne ne
	                   sera plus jamais proposé a la creation d'une facture*/
	);

/**
 * customers 
 */
DROP TABLE IF EXISTS client;
create table client(
	id_client int primary key auto_increment,
	date_creation datetime,
	name varchar(255),
	adress text,
	phone1 varchar(255), /* phone1 */
	phone2 varchar(255), /* phone 2 */
	email varchar (255)
	);

/**
 *project
 */
DROP TABLE IF EXISTS project;
create table project(
	id_project int primary key auto_increment ,
	name varchar(255), 
	date_begin date,
	date_end date , 
	date_creation datetime ,
	date_last_modification datetime,
	adress text,
	comments text ,
	client int , 
	foreign key (client) references client(id_client)
	);

/**
 * bills
 */
DROP TABLE IF EXISTS bill;
create table bill (
	id_bill int primary key auto_increment ,
	bill_number_in_year int , -- le numéro de la facture dans l'année ou elle a été créer
	date_validation date,
	is_validated boolean, 
	title varchar(255),
	discount Double ,
	comments text,
	note text,
	date_creation date,
	date_last_modification datetime,
	project int,
	quote int,
	foreign key (project) references project(id_project),
	foreign key (quote) references project(id_quote)
	);

/**
 * quotes
*/
DROP TABLE IF EXISTS quote;
create table quote( -- c'est la ou sont gardés les devis 
	id_quote int primary key auto_increment,
	title varchar(255),
	comments text,
	note text,
	date_creation datetime,
	date_last_modification datetime,
	project int,
	foreign key(project) references project(id_project)
);

/**
 * articles
 */
DROP TABLE IF EXISTS article;
create table article(
	id_article int primary key auto_increment,
	name varchar(255),
	unit varchar(255),
	priceUnit Double,
	quantity Double
	); 
DROP TABLE IF EXISTS bill_contains_article;
create table bill_contains_article(
	the_bill int ,
	the_article int ,
	primary key(the_bill,the_article),
	foreign key(the_bill) references bill(ie_bill),
	foreign key(the_article) references article(id_article)
);

DROP TABLE IF EXISTS bill_contains_information;
create table bill_contains_information(
	the_bill int , 
	the_information int ,
	primary key(the_bill,the_information),
	foreign key(the_bill) references bill(the_bill),
	foreign key(the_information) references information_company(id_information)
);

DROP TABLE IF EXISTS quote_contains_article;
create table quote_contains_article(
	the_quote int,
	the_article int,
	primary key (the_quote,the_article),
	foreign key(the_quote) references quote(id_quote),
	foreign key(the_article) references article(id_article)
);

DROP TABLE IF EXISTS quote_contains_information;
create table quote_contains_information(
	the_quote int, 
	the_information int,
	primary key(the_quote,the_information),
	foreign key(the_quote) references quote(id_quote),
	foreign key(the_information) references information_company(id_information)
);

DROP TABLE IF EXISTS album;
create table album(
	id_album int primary key auto_increment ,
	title varchar(255),
	comments text ,
	date_creation datetime ,
	date_last_modification datetime
	);

DROP TABLE IF EXISTS image;
create table image(
	id_image int primary key auto_increment,
	title varchar(255),
	src varchar(255),
	date_creation datetime,
	date_last_modification datetime,
	comments text
	);

DROP TABLE IF EXISTS album_contains_image;
create table album_contains_image(
	the_album int , 
	the_image int ,
	primary key(the_album,the_image),
	foreign key(the_album) references album(id_album),
	foreign key(the_image) references image(id_image)
);

DROP TABLE IF EXISTS project_contains_album;
create table project_contains_album(
	the_project int,
	the_album int,
	primary key(the_project,the_album),
	foreign key(the_project) references project(id_project),
	foreign key(the_album) references album(id_album)
);

