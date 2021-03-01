CREATE DATABASE buscarCep;
use buscarCep

CREATE TABLE consulta (
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cep char(8) NOT NULL,
    localidade varchar(200) NOT NULL,
    uf char(2) NOT NULL,
    ddd int,
    bairro varchar(200),
    logradouro varchar(200),
    complemento varchar(200),
    ibge varchar(8),
    gia varchar(8),
    siafi varchar(8)
);