0 0 Nike airforce 1 100 90 Kuvat/Tuotekuvat/Nike_AirForce_1/Nike_AirForce_1_1.png /WalkshoesMen/nikeairforce /WalkshoesWomen/nikeairforce
1 0 Nike airforce 720 120 100 Kuvat/Tuotekuvat/Nike_AirMax_720/Nike_AirMax_720_1.png /WalkshoesMen/nikeairforce720 /WalkshoesWomen/nikeairforce720
2 0 Nike airforce 97 90 70 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Nike_AirMax_97/Nike_AirMax_97_1.png /WalkshoesMen/nikeairforce97 /WalkshoesWomen/nikeairforce97
3 0 Adidas Y3 100 90 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Adidas_Y3/Adidas_Y3_1.png /WalkshoesMen/adidasy3 /WalkshoesWomen/adidasy3 
4 0 Yeezy 200 180 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Yeezy/Yeezy_1.png /WalkshoesMen/yeezy /WalkshoesWomen/yeezy
5 0 Adidas gazelle 200 160 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Adidas_Gazelle/Adidas_Gazelle_1.png /WalkshoesMen/adidasgazelle /WalkshoesWomen/adidasgazelle
6 1 Nike kd 70 50 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Nike_KD/Nike_KD_1.png  /BasketballMen/nikekd /BasketballWomen/nikekd
7 1 Jordan 1 low 170 150 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Jordan_1_Low/Jordan_1_Low_1.jpg /BasketballMen/jordan1low /BasketballWomen/jordan1low
8 1 Jordan 1 Mid 170 150 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Jordan_1_Mid/Jordan_1_Mid_1.png /BasketballMen/jordan1mid /BasketballWomen/jordan1mid
9 1 Converse 120 100 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Converse/Converse_1.png /BasketballMen/converse /BasketballWomen/converse
10 1 Reebok 90 70 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Reebok/Reebok_1.png /BasketballMen/reebok /BasketballWomen/reebok
11 2 Vans slip on 40 20 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Vans_SlipOn/Vans_SlipOn_1.png /SkateboardMen/vansspliton /SkateboardWomen/vansspliton
12 1 Vans slip on pro 50 30 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Vans_SlipOn_Pro/Vans_SlipOn_Pro_1.png /SkateboardMen/vanssplitonpro /SkateboardWomen/vanssplitonpro
13 2 Vans authentic 50 30 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Vans_Authentic/Vans_Authentic_1.png /SkateboardMen/vansauthentic /SkateboardWomen/vansauthentic
14 2 Nike blazer 60 50 Kuvat/Tuotekuvat/Paivitetyt_Tuotekuvat/Nike_Blazer_Low/Nike_Blazer_Low_1.png /SkateboardMen/nikeblazer /SkateboardWomen/nikeblazer

0 kävelykengät
1 koripallokengät
2 skeittikengät

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