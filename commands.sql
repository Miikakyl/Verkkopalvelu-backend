
create table Posti (
    postinumero VARCHAR(5) PRIMARY KEY,
    postitmp VARCHAR(255) NOT NULL
);

create table Kayttaja (
    sahkoposti VARCHAR(255) PRIMARY KEY,
    salasana VARCHAR(255) NOT NULL
);

create table Asiakas (
    astunnus INT AUTO_INCREMENT PRIMARY KEY,
    postinumero VARCHAR(5) NOT NULL,
    sahkoposti VARCHAR(255) NOT NULL,
    etunimi VARCHAR(255) NOT NULL,
    sukunimi VARCHAR(255) NOT NULL,
    puh VARCHAR(15) NOT NULL,
    osoite VARCHAR(100) NOT NULL,
    FOREIGN KEY (postinumero) REFERENCES Posti(postinumero),
    FOREIGN KEY (sahkoposti) REFERENCES Kayttaja(sahkoposti)
);

create table Tilaus (
    tilausnro INT AUTO_INCREMENT PRIMARY KEY,
    astunnus INT NOT NULL,
    tilauspvm DATE NOT NULL,
    kantaAsiakkuus BOOLEAN DEFAULT false,
    maksutapa CHAR(2) NOT NULL,
    postitustapa VARCHAR(25) NOT NULL,
    FOREIGN KEY (astunnus) REFERENCES Asiakas(astunnus)
);

create table Tilausrivi (
    rivinro INT AUTO_INCREMENT PRIMARY KEY,
    tilausnro INT NOT NULL,
    tuoteId INT NOT NULL,
    kpl INT NOT NULL,
    FOREIGN KEY (tilausnro) REFERENCES Tilaus(tilausnro),
    FOREIGN KEY (tuoteId) REFERENCES Tuote(tuoteId)
);

create table Tuote (
   tuoteId INT AUTO_INCREMENT PRIMARY KEY,
   trnro INT NOT NULL,
   tuotenimi VARCHAR(255) NOT NULL,
   hinta INT DEFAULT 0,
   kustannus INT DEFAULT 0,
   koko VARCHAR(1) NOT NULL,
   vari VARCHAR(25) NOT NULL,
   kuvaosoite VARCHAR(255) NOT NULL,
   FOREIGN KEY (trnro) REFERENCES Tuoteryhma(trnro)
);



create table Tuoteryhma (
   trnro INT AUTO_INCREMENT PRIMARY KEY,
   trnimi VARCHAR(50) NOT NULL
);

