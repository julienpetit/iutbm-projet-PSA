drop table if exists LIVRAISON;
drop table if exists CADENCEE;
drop table if exists COMPREND;
drop table if exists COMMANDE;
drop table if exists POSSEDE;
drop table if exists INFORME;
drop table if exists COPIE_COMMANDE;
drop table if exists DEST_COMMANDE;
drop table if exists APPROVISIONNE;
drop table if exists FOURNISSEUR;
drop table if exists PIECE;
drop table if exists TYPE_PIECE;
drop table if exists TYPE_COMMANDE;
drop table if exists TYPE_CHANTIER;
drop table if exists ENTITE;
drop table if exists SILHOUETTE;
drop table if exists UTILISATEUR;
drop table if exists DROIT;
drop table if exists MODE_REF_VEHICULE;
drop table if exists ADRESSE_MAIL;
drop table if exists TYPE_PIECE2;


create table TYPE_PIECE(
	libelle_type_piece varchar(25),
	primary key(libelle_type_piece)
	)
engine=InnoDB;

create table TYPE_PIECE2(
	libelle_type_piece_2 varchar(200),
	primary key(libelle_type_piece_2)
	)
engine=InnoDB;
	

create table ADRESSE_MAIL(
	adresse_email varchar(30),
	primary key(adresse_email)
	)
engine=InnoDB;

create table MODE_REF_VEHICULE(
	code_mode_ref_vehicule varchar(3) not null,
	libelle_mode_ref_vehicule varchar(25),
	primary key(code_mode_ref_vehicule)
	)
engine=InnoDB;

create table DROIT(
	no_droit int not null auto_increment,
	description_droit varchar(80),
	primary key(no_droit)
	)
engine=InnoDB;

create table UTILISATEUR(
	id_utilisateur varchar(10),
	nom_utilisateur varchar(25),
	prenom_utilisateur varchar(25),
	service_utilisateur varchar(25),
	no_telephone varchar(10),
	email_utilisateur varchar(30),
	mdp_utilisateur varchar(200),
	primary key(id_utilisateur)
	)
engine=InnoDB;

create table SILHOUETTE(
	code_silhouette varchar(10),
	libelle_silhouette varchar(40),
	primary key(code_silhouette)
	)
engine=InnoDB;

create table ENTITE(
	code_imputation varchar(5),
	libelle_entite varchar(25),
	exterieur boolean,
	primary key(code_imputation)
	)
engine=InnoDB;


create table TYPE_COMMANDE(
	code_type_commande ENUM('S','M'),
	libelle_type_commande char(20),
	primary key(code_type_commande)
	)
engine=InnoDB;


create table PIECE(
	reference_piece varchar(10),
	designation_piece varchar(25),
	primary key(reference_piece)
	)
engine=InnoDB;

create table FOURNISSEUR(
	id_fournisseur int not null auto_increment,
	nom_fournisseur varchar(25),
	cofor int,
	nom_dest_commande varchar(25),
	code_mode_ref_vehicule varchar(3),
	primary key(id_fournisseur),
	constraint f_mode_ref_vehicule foreign key (code_mode_ref_vehicule) references MODE_REF_VEHICULE(code_mode_ref_vehicule) on delete cascade
	)
engine=InnoDB;

create table APPROVISIONNE(
	libelle_type_piece_2 varchar(200),
	id_fournisseur int,
	primary key(libelle_type_piece_2,id_fournisseur),
	constraint a_libelle_type_piece_2 foreign key (libelle_type_piece_2) references TYPE_PIECE2(libelle_type_piece_2) on delete cascade,
	constraint a_id_fournisseur foreign key (id_fournisseur) references FOURNISSEUR(id_fournisseur) on delete cascade
	)
engine=InnoDB;

create table DEST_COMMANDE(
	adresse_email varchar(25),
	id_fournisseur int,
	primary key(adresse_email,id_fournisseur),
	constraint dc_adresse_email foreign key (adresse_email) references ADRESSE_MAIL(adresse_email) on delete cascade,
	constraint dc_id_fournisseur foreign key (id_fournisseur) references FOURNISSEUR(id_fournisseur) on delete cascade
	)
engine=InnoDB;

create table COPIE_COMMANDE(
	adresse_email varchar(25),
	id_fournisseur int,
	primary key(adresse_email,id_fournisseur),
	constraint cc_adresse_email foreign key (adresse_email) references ADRESSE_MAIL(adresse_email) on delete cascade,
	constraint cc_id_fournisseur foreign key (id_fournisseur) references FOURNISSEUR(id_fournisseur) on delete cascade	
	)
engine=InnoDB;

create table INFORME(
	id_utilisateur varchar(10),
	code_type_commande ENUM('S','M'),
	primary key(id_utilisateur,code_type_commande),
	constraint i_id_utilisateur foreign key (id_utilisateur) references UTILISATEUR(id_utilisateur) on delete cascade,
	constraint i_code_type_commande foreign key (code_type_commande) references TYPE_COMMANDE(code_type_commande) on delete cascade
	)
engine=InnoDB;

create table POSSEDE(
	no_droit int,
	id_utilisateur varchar(7),
	primary key(no_droit,id_utilisateur),
	constraint p_no_droit foreign key (no_droit) references DROIT(no_droit) on delete cascade,
	constraint p_id_utilisateur foreign key (id_utilisateur) references UTILISATEUR(id_utilisateur) on delete cascade
	)
engine=InnoDB;

 
create table COMMANDE(
	no_commande varchar(10),
	date_commande date,
	heure_commande time,
	no_chantier int,
	libelle_type_chantier varchar(20),
	ref_vehicule varchar(20),
	desc_defaut varchar(100),
	date_fermeture date,
	heure_fermeture time,
	motif_fermeture varchar(100),
	date_annulation date,
	heure_annulation time,
	date_reception date,
	heure_reception time,
	code_imputation varchar(5),
	code_silhouette varchar(10),
	id_fournisseur int,
	id_utilisateur_receptionne varchar(7),
	id_utilisateur_passe varchar(7),
	id_utilisateur_annule varchar(7),
	id_utilisateur_ferme varchar(7),
	code_type_commande ENUM('S','M'),
	primary key (no_commande),
	constraint c_code_imputation foreign key (code_imputation) references ENTITE(code_imputation) on delete cascade,
	constraint c_code_silhouette foreign key (code_silhouette) references SILHOUETTE(code_silhouette) on delete cascade,
	constraint c_id_fournisseur foreign key (id_fournisseur) references FOURNISSEUR(id_fournisseur) on delete cascade,
	constraint c_id_utilisateur_receptionne foreign key (id_utilisateur_receptionne) references UTILISATEUR(id_utilisateur) on delete cascade,
	constraint c_id_utilisateur_passe foreign key (id_utilisateur_passe) references UTILISATEUR(id_utilisateur) on delete cascade,
	constraint c_id_utilisateur_annule foreign key (id_utilisateur_annule) references UTILISATEUR(id_utilisateur) on delete cascade,
	constraint c_id_utilisateur_ferme foreign key (id_utilisateur_ferme) references UTILISATEUR(id_utilisateur) on delete cascade,
	constraint c_code_type_commande foreign key (code_type_commande) references TYPE_COMMANDE(code_type_commande) on delete cascade
	)
engine=InnoDB;

create table COMPREND(
	libelle_type_piece varchar(25),
	reference_piece varchar(10),
	no_commande varchar(10),
	quantite_piece int,
	primary key (libelle_type_piece,reference_piece,no_commande),
	constraint co_libelle_type_piece foreign key (libelle_type_piece) references TYPE_PIECE(libelle_type_piece) on delete cascade,
	constraint co_reference_piece foreign key (reference_piece) references PIECE(reference_piece) on delete cascade,
	constraint co_no_commande foreign key (no_commande) references COMMANDE(no_commande) on delete cascade	
	)
engine=InnoDB;

create table CADENCEE(
	no_commande varchar(10),
	reference_piece varchar(10),
	potentiel_jour int,
	primary key (no_commande,reference_piece),
	constraint ca_no_commande foreign key (no_commande) references COMMANDE(no_commande) on delete cascade,
	constraint ca__reference_piece foreign key (reference_piece) references PIECE(reference_piece) on delete cascade
	)
engine=InnoDB;

create table LIVRAISON(
	reference_piece varchar(10),
	no_commande varchar(10),
	date_livraison date,
	quantite_livree int,
	primary key (reference_piece,no_commande, date_livraison),
	constraint l_reference_piece foreign key (reference_piece) references PIECE(reference_piece) on delete cascade,
	constraint l_no_commande foreign key (no_commande) references COMMANDE(no_commande) on delete cascade
	)
engine=InnoDB;


insert into TYPE_PIECE values ('pieces principales');
insert into TYPE_PIECE values ('pieces environnement');

insert into TYPE_PIECE2 values ('panneaux de portes T7 sauf T76');
insert into TYPE_PIECE2 values ('panneaux de portes T8 B8');
insert into TYPE_PIECE2 values ('panneaux de portes T16');
insert into TYPE_PIECE2 values ('jantes de pneux T96');
insert into TYPE_PIECE2 values ('miroir de rétroviseur T12');
insert into TYPE_PIECE2 values ('housse de siège T45');
insert into TYPE_PIECE2 values ('cable de freins T07');
insert into TYPE_PIECE2 values ('pot echappement T19 sauf T35');

insert into ADRESSE_MAIL values ('projetpsa.bdd@gmail.com');
insert into ADRESSE_MAIL values ('adresse_mail1@gmail.com');
insert into ADRESSE_MAIL values ('adresse_mail2@gmail.com');
insert into ADRESSE_MAIL values ('adresse_mail3@gmail.com');
insert into ADRESSE_MAIL values ('adresse_mail4@gmail.com');
insert into ADRESSE_MAIL values ('adresse_mail5@gmail.com');
insert into ADRESSE_MAIL values ('adresse_mail6@gmail.com');
insert into ADRESSE_MAIL values ('adresse_mail7@gmail.com');
insert into ADRESSE_MAIL values ('adresse_mail8@gmail.com');

insert into MODE_REF_VEHICULE values ('VIS','mode ref vehicule1');
insert into MODE_REF_VEHICULE values ('OF','mode ref vehicule2');


insert into DROIT values (null,'option1');
insert into DROIT values (null,'option2');
insert into DROIT values (null,'option3');
insert into DROIT values (null,'option4');
insert into DROIT values (null,'option5');
insert into DROIT values (null,'option6');
insert into DROIT values (null,'option7');
insert into DROIT values (null,'option8');
insert into DROIT values (null,'option9');
insert into DROIT values (null,'option10');
insert into DROIT values (null,'option11');


insert into UTILISATEUR values ('F365856','admin','admin','assemblage','0645865232','adminroot@hotmail.fr',md5('admin'));
insert into UTILISATEUR values ('C345654','Lanternier','Thomas','assemblage','0657986523','thomasL@hotmail.fr',md5('thomas'));
insert into UTILISATEUR values ('E983421','Boulachin','Clement','livraison','0665749825','clementB@hotmail.fr',md5('clement'));
insert into UTILISATEUR values ('J765432','Forest','Dylan','chaine','0656981207','dylanFo@hotmail.fr',md5('dylan'));
insert into UTILISATEUR values ('P873416','Fleury','Dylan','matiere','0665329874','dylanFl@hotmail.fr',md5('dylan'));
insert into UTILISATEUR values ('U171125','Sete','Rocco','produit','0665897845','roccoS@hotmail.fr',md5('rocco'));
insert into UTILISATEUR values ('J187421','Terra','Pierre','service','0625856963','pierreT@hotmail.fr',md5('pierre'));

insert into SILHOUETTE values ('T70','308 berline');
insert into SILHOUETTE values ('T71','206 CC');
insert into SILHOUETTE values ('T72','206 +');
insert into SILHOUETTE values ('T73','DS3');
insert into SILHOUETTE values ('T74','DS4');
insert into SILHOUETTE values ('T75','C4');
insert into SILHOUETTE values ('T76','308CC');

insert into ENTITE values ('en001','defaut',1);
insert into ENTITE values ('en002','casse',0);
insert into ENTITE values ('en003','rebut',0);



insert into TYPE_COMMANDE values ('S','synchrone');
insert into TYPE_COMMANDE values ('M','masse');


insert into PIECE values ('020UIPO810','optiqueAG');
insert into PIECE values ('0204060MLJ','portièreD');
insert into PIECE values ('LKUL060812','portièreG');
insert into PIECE values ('0204060ARE','parechocAvant');
insert into PIECE values ('INBT060814','parechocArriere');
insert into PIECE values ('02PMRAZ815','optiqueAD');
insert into PIECE values ('020PRIM816','volant');

insert into FOURNISSEUR values (null,'fournisseur test', 123456789, 'destCom_test', 'VIS');
insert into FOURNISSEUR values (null,'fournisseur test1', 111111111, 'destCom_test1', 'VIS');
insert into FOURNISSEUR values (null,'fournisseur test2', 010203040, 'destCom_test2', 'OF');
insert into FOURNISSEUR values (null,'fournisseur test3', 223344550, 'destCom_test3', 'VIS');
insert into FOURNISSEUR values (null,'fournisseur test4', 555666777, 'destCom_test4', 'OF');
insert into FOURNISSEUR values (null,'fournisseur test5', 987654321, 'destCom_test5', 'OF');
insert into FOURNISSEUR values (null,'fournisseur test6', 246813579, 'destCom_test6', 'OF');
insert into FOURNISSEUR values (null,'fournisseur test7', 333666999, 'destCom_test7', 'VIS');
insert into FOURNISSEUR values (null,'fournisseur test8', 234567894, 'destCom_test8', 'VIS');

insert into APPROVISIONNE values ('panneaux de portes T7 sauf T76',1);
insert into APPROVISIONNE values ('panneaux de portes T8 B8',6);
insert into APPROVISIONNE values ('panneaux de portes T16',4);
insert into APPROVISIONNE values ('jantes de pneux T96',3);
insert into APPROVISIONNE values ('miroir de rétroviseur T12',2);
insert into APPROVISIONNE values ('housse de siège T45',8);
insert into APPROVISIONNE values ('cable de freins T07',7);
insert into APPROVISIONNE values ('pot echappement T19 sauf T35',5);
insert into APPROVISIONNE values ('cable de freins T07',9);

insert into DEST_COMMANDE values ('projetpsa.bdd@gmail.com', 1);
insert into DEST_COMMANDE values ('adresse_mail3@gmail.com', 2);
insert into DEST_COMMANDE values ('projetpsa.bdd@gmail.com', 3);
insert into DEST_COMMANDE values ('adresse_mail3@gmail.com', 4);
insert into DEST_COMMANDE values ('projetpsa.bdd@gmail.com', 5);
insert into DEST_COMMANDE values ('adresse_mail3@gmail.com', 6);
insert into DEST_COMMANDE values ('projetpsa.bdd@gmail.com', 7);
insert into DEST_COMMANDE values ('adresse_mail3@gmail.com', 8);


insert into COPIE_COMMANDE values ('adresse_mail4@gmail.com',1);
insert into COPIE_COMMANDE values ('adresse_mail5@gmail.com',2);
insert into COPIE_COMMANDE values ('adresse_mail6@gmail.com',3);
insert into COPIE_COMMANDE values ('adresse_mail7@gmail.com',4);
insert into COPIE_COMMANDE values ('adresse_mail4@gmail.com',5);
insert into COPIE_COMMANDE values ('adresse_mail5@gmail.com',6);
insert into COPIE_COMMANDE values ('adresse_mail6@gmail.com',7);
insert into COPIE_COMMANDE values ('adresse_mail7@gmail.com',8);


insert into INFORME values ('C345654', 'S');
insert into INFORME values ('E983421', 'S');
insert into INFORME values ('U171125', 'M');
insert into INFORME values ('J765432', 'M');

insert into POSSEDE values (1,'F365856');
insert into POSSEDE values (4,'F365856');
insert into POSSEDE values (3,'F365856');
insert into POSSEDE values (2,'F365856');
insert into POSSEDE values (5,'F365856');
insert into POSSEDE values (6,'F365856');
insert into POSSEDE values (7,'F365856');
insert into POSSEDE values (8,'F365856');
insert into POSSEDE values (9,'F365856');
insert into POSSEDE values (10,'F365856');
insert into POSSEDE values (11,'F365856');
insert into POSSEDE values (1,'C345654');
insert into POSSEDE values (7,'C345654');
insert into POSSEDE values (8,'C345654');
insert into POSSEDE values (9,'C345654');
insert into POSSEDE values (10,'C345654');
insert into POSSEDE values (11,'C345654');
insert into POSSEDE values (1,'E983421');
insert into POSSEDE values (9,'E983421');
insert into POSSEDE values (1,'U171125');
insert into POSSEDE values (6,'U171125');
insert into POSSEDE values (7,'E983421');
insert into POSSEDE values (5,'J765432');
insert into POSSEDE values (4,'J765432');
	
/*Commande*/
insert into COMMANDE values ('0111121610','2011-12-16','12:30:00',null,'','AIEYRBN25','desc_defaut_1',null,null,null,null,null,null,null,'en001','T70',1,null,'C345654',null,null,'S');
insert into COMMANDE values ('0111121785','2011-12-16','12:30:00',03,'panne',null,null,null,null,null,null,null,null,null,'en003','T72',2,null,'J765432',null,null,'M');

/* Commande annulée */
insert into COMMANDE values ('0111121786','2011-12-16','12:30:00',null,'','AEROIRUI','desc_defaut_3','2011-12-30','12:00:00','annule','2010-11-15','12:15:00',null,null,'en002','T71',3,null,'C345654','C345654','C345654','S');

/* Commandes receptionnées */
insert into COMMANDE values ('0111121701','2011-11-16','12:30:00',null,'','YEUENB25','desc_defaut_4','2011-11-21','12:00:00','recu',null,null,'2011-11-21','13:00:00','en001','T75',4,'C345654','J765432',null,'J765432','S');
insert into COMMANDE values ('0111121710','2011-02-16','12:30:00',22,'crise',null,null,'2011-12-26','12:00:00','recu',null,null,'2011-02-26','13:00:00','en002','T76',5,'J765432','E983421',null,'E983421','M');



insert into COMPREND values ('pieces principales','020UIPO810','0111121785',50);
insert into COMPREND values ('pieces principales','02PMRAZ815','0111121785',40);
insert into COMPREND values ('pieces environnement','0204060MLJ','0111121785',100);
insert into COMPREND values ('pieces environnement','LKUL060812','0111121785',70);
insert into COMPREND values ('pieces principales','02PMRAZ815','0111121610',1);
insert into COMPREND values ('pieces environnement','0204060ARE','0111121785',60);
insert into COMPREND values ('pieces principales','INBT060814','0111121710',80);
insert into COMPREND values ('pieces environnement','0204060ARE','0111121710',90);
insert into COMPREND values ('pieces principales','02PMRAZ815','0111121786',1);
insert into COMPREND values ('pieces principales','020PRIM816','0111121701',1);

insert into CADENCEE values ('0111121785','02PMRAZ815',10);
insert into CADENCEE values ('0111121785','020UIPO810',10);
insert into CADENCEE values ('0111121785','0204060MLJ',20);
insert into CADENCEE values ('0111121785','LKUL060812',25);
insert into CADENCEE values ('0111121785','0204060ARE',10);
insert into CADENCEE values ('0111121710','0204060ARE',20);
insert into CADENCEE values ('0111121710','INBT060814',15);

insert into LIVRAISON values ('020UIPO810','0111121785','2011-12-17',10);
insert into LIVRAISON values ('020UIPO810','0111121785','2011-12-18',10);
insert into LIVRAISON values ('02PMRAZ815','0111121785','2011-12-17',10);
insert into LIVRAISON values ('02PMRAZ815','0111121785','2011-12-18',10);
insert into LIVRAISON values ('0204060MLJ','0111121785','2012-01-11',20);
insert into LIVRAISON values ('0204060MLJ','0111121785','2012-01-02',20);
insert into LIVRAISON values ('LKUL060812','0111121785','2012-01-03',25);
insert into LIVRAISON values ('0204060ARE','0111121785','2011-12-27',10);
insert into LIVRAISON values ('INBT060814','0111121710','2011-12-25',20);
insert into LIVRAISON values ('0204060ARE','0111121710','2011-12-27',10);

