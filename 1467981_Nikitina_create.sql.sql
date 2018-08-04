



CREATE TABLE uni(
uniId integer NOT NULL,
name varchar (80),
stadt varchar (20),
land varchar (15),
PRIMARY KEY (uniId));

CREATE TABLE professor(
idnummer integer NOT NULL,
vorname varchar (50),
nachname varchar (50),
email varchar (80),
geburtsdatum date,
gehalt float,
CHECK (gehalt>=0),
uniId integer,
PRIMARY KEY (idnummer),
FOREIGN KEY (uniId) REFERENCES uni);


CREATE TABLE gebaude(
gebnummer integer,
stadt varchar (20),
strasse varchar(80),
plz number(10),
num varchar (50),
gebname varchar(80),
uniId integer NOT NULL,
PRIMARY KEY (gebnummer),
FOREIGN KEY (uniId) REFERENCES uni);


CREATE TABLE raum(
stock integer,
sitzplatz number (5),
raumnummer integer NOT NULL,
gebnummer integer,
CHECK (sitzplatz >=0),
PRIMARY KEY (raumnummer),
FOREIGN KEY (gebnummer) REFERENCES gebaude ON DELETE CASCADE);

CREATE TABLE lehrveranstaltung(
name varchar (80),
studienrichtung varchar (80),
jahr integer,
semester varchar(80),
lvnummer integer NOT NULL,
idnummer integer,
PRIMARY KEY (lvnummer),
FOREIGN KEY (idnummer) REFERENCES professor);


CREATE TABLE vorlesung(
ectsanzahl integer DEFAULT 0,
teilnehmeranzahl integer,
typ varchar (2),
lvnummer integer,
CHECK (teilnehmeranzahl>=0),
PRIMARY KEY (lvnummer),
FOREIGN KEY (lvnummer) REFERENCES lehrveranstaltung ON DELETE CASCADE);



CREATE TABLE uebung(
ectsanzahl integer DEFAULT 0,
teilnehmeranzahl integer,
stunden integer,
type varchar (2),
lvnummer integer,
CHECK (teilnehmeranzahl>=0),
PRIMARY KEY (lvnummer),
FOREIGN KEY (lvnummer) REFERENCES lehrveranstaltung ON DELETE CASCADE);



CREATE TABLE prufung(
prufname varchar (80),
teilnehmeranzahl integer DEFAULT 0,
prufnummer integer NOT NULL,
PRIMARY KEY (prufnummer));


CREATE TABLE student(
vorname varchar (50),
nachname varchar (50),
studienrichtung varchar (50),
semester integer,
geschlecht varchar (1) CHECK(geschlecht in ('M','F')),
matrikelnummer integer NOT NULL,
PRIMARY KEY (matrikelnummer));


CREATE TABLE prufungmachen(
idnummer integer,
prufnummer integer,
matrikelnummer integer,
prufdatum date,
note integer,
CHECK (note<=5),
PRIMARY KEY (prufnummer),
FOREIGN KEY (idnummer) REFERENCES professor,
FOREIGN KEY (prufnummer) REFERENCES prufung,
FOREIGN KEY (matrikelnummer) REFERENCES student);

CREATE TABLE befreundet(
matrikelnummer1 integer,
matrikelnummer2 integer,
PRIMARY KEY (matrikelnummer1, matrikelnummer2),
FOREIGN KEY (matrikelnummer1) REFERENCES student,
FOREIGN KEY (matrikelnummer2) REFERENCES student);




create sequence prof_seq
  start with 100 increment by 1;
create or replace trigger trg_prof_autoincrement
  before insert on professor
  for each row
  when (new.idnummer is null)
begin
  select prof_seq.nextval
  into :new.idnummer
  from dual;
end;

CREATE OR REPLACE TRIGGER trigger_inskription1
AFTER INSERT OR UPDATE ON vorlesung
FOR EACH ROW
DECLARE
  typ varchar(2);
BEGIN
  SELECT SUBSTR(:new.inskription, 1, 2) INTO vorlesung FROM DUAL;
  -- test if typ is correct
  IF typ != 'VO' THEN
    raise_application_error(-20001, 'Attribut Inskription startet nicht mit VO sondern mit ' || typ);
  END IF;
END;



CREATE OR REPLACE TRIGGER trigger_inskription2
AFTER INSERT OR UPDATE ON uebung
FOR EACH ROW
DECLARE
  type varchar(2);
BEGIN
  SELECT SUBSTR(:new.inskription, 1, 2) INTO uebung FROM DUAL;
  -- test if type is correct
  IF typ != 'UE' THEN
    raise_application_error(-20001, 'Attribut Inskription startet nicht mit UE sondern mit ' || typ);
  END IF;
END;


CREATE OR REPLACE TRIGGER trigger_inskription3
AFTER INSERT OR UPDATE ON lehrveranstaltung
FOR EACH ROW
DECLARE
  semester varchar(2);
BEGIN
  SELECT SUBSTR(:new.inskription, 1, 2) INTO lehrveranstaltung FROM DUAL;
  -- test if type is correct
   IF semester != 'WS' and semester != 'SS' THEN
    raise_application_error(-20001, 'Attribut Inskription startet nicht mit SS oder WS sondern mit ' || typ);
  END IF;
END;



create or replace trigger professor_birthDate_in_future
  before insert or update on professor
  for each row
begin if( :new.BirthDate > sysdate )
  then
    RAISE_APPLICATION_ERROR( -20001, 'Birth date must be in the past' );
  end if;
end;



CREATE VIEW durch_note AS
 (SELECT matrikelnummer, AVG(note) AS averagemark,vorname, nachname
 FROM prufungmachen, student
 WHERE student.matrikelnummer = prufungmachen.matrikelnummer
GROUP BY vorname, nachname);
 















