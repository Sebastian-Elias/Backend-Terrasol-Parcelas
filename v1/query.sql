-- MySQL
CREATE DATABASE terrasol_parcelas;
CREATE USER 'terrasol'@'localhost' IDENTIFIED BY 'l4cl4v3-c11s4';
GRANT ALL PRIVILEGES ON terrasol_parcelas.* TO 'terrasol'@'localhost';

USE terrasol_parcelas;

CREATE TABLE mantenedor(
    id INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo BOOLEAN NOT NULL DEFAULT FALSE
)

-- GET / ALL
SELECT id, nombre, activo FROM mantenedor;
-- GET / BY ID
SELECT id, nombre, activo FROM mantenedor WHERE id = 3;
-- POST
INSERT INTO mantenedor (id, nombre) VALUES 
(1, 'Ejemplo 1'),
(2, 'Ejemplo 2'),
(3, 'Ejemplo 3');
-- PATCH / ENABLE
UPDATE mantenedor SET activo = true WHERE id = 3;
-- PATCH / DISABLE
UPDATE mantenedor SET activo = false WHERE id = 3;
-- PUT
UPDATE mantenedor SET nombre = 'Example 3' WHERE id = 3;
-- DELETE
DELETE FROM mantenedor WHERE id = 3;

-- about us
CREATE TABLE idiomas (
    id  INT PRIMARY KEY,
    corto VARCHAR(3) NOT NULL UNIQUE,
    nombre VARCHAR(10) NOT NULL UNIQUE,
    activo BOOLEAN NOT NULL DEFAULT FALSE
);
INSERT INTO idiomas (id, corto, nombre, activo) VALUES 
(1, 'esp', 'Español', true),
(2, 'eng', 'Inglés', true);

CREATE TABLE about_us (
    id  INT PRIMARY KEY,
    titulo VARCHAR(10) NOT NULL UNIQUE,
    activo BOOLEAN NOT NULL DEFAULT FALSE
);
INSERT INTO about_us (id, titulo, activo) VALUES 
(1, 'mision', true),
(2, 'vision', true);

CREATE TABLE about_us_idioma (
    id  INT PRIMARY KEY,
    idioma_id INT NOT NULL,
    about_us_id INT NOT NULL,
    value_titulo VARCHAR(10) NOT NULL,
    value_contenido TEXT NOT NULL,
    activo BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (idioma_id) REFERENCES idiomas (id),
    FOREIGN KEY (about_us_id) REFERENCES about_us (id)
);
INSERT INTO about_us_idioma (id, idioma_id, about_us_id, value_titulo, value_contenido, activo) VALUES 
(1, 1, 1, 'Misión', 'Ofrecer parcelas exclusivas en ubicaciones seleccionadas, proporcionando un servicio personalizado y de calidad para transacciones satisfactorias. Destacándonos por nuestra integridad y capacidad para identificar oportunidades de inversión de alto potencial', true),
(2, 1, 2, 'Visión', 'Ser reconocidos como líderes en el mercado de parcelas de alto nivel, siendo el referente en integridad y excelencia en el servicio. Aspiramos a transformar el panorama inmobiliario al ofrecer oportunidades de inversión exclusivas y de alto valor para nuestros clientes.', true);

CREATE TABLE parcelas_con_casas (
    id INT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL,
    lote VARCHAR(10) NOT NULL,
    ubicacion VARCHAR(50) NOT NULL,
    tamaño_terreno VARCHAR(50) NOT NULL,
    descripcion_casa TEXT NOT NULL,
    electricidad BOOLEAN NOT NULL,
    agua_potable BOOLEAN NOT NULL,
    alcantarillado BOOLEAN NOT NULL,
    internet BOOLEAN NOT NULL,
    precio VARCHAR(50) NOT NULL,
    propietario VARCHAR(100) NOT NULL,
    activo BOOLEAN NOT NULL DEFAULT FALSE
);


INSERT INTO parcelas_con_casas (id, tipo, lote, ubicacion, tamaño_terreno, descripcion_casa, electricidad, agua_potable, alcantarillado, internet, precio, propietario, activo) VALUES
(1, 'Residencial', 'A-1', 'Talca', '1000 metros cuadrados', 'Casa de dos pisos con tres dormitorios y dos baños', true, true, true, true, '150 millones de pesos', 'Juan Pérez', true),
(2, 'Residencial', 'B-5', 'Concepción', '800 metros cuadrados', 'Casa moderna de un piso con cuatro dormitorios y tres baños', true, true, true, true, '200 millones de pesos', 'María González', true),
(3, 'Residencial', 'C-22', 'Valdivia', '1200 metros cuadrados', 'Casa estilo campestre con amplios jardines y vista al río', true, true, true, true, '300 millones de pesos', 'Carlos Rodríguez', true),
(4, 'Residencial', 'D-8', 'Valdivia', '1500 metros cuadrados', 'Casa de diseño contemporáneo con piscina y vistas panorámicas al lago', true, true, true, true, '400 millones de pesos', 'Ana Martínez', true),
(5, 'Residencial', 'E-15', 'Osorno', '900 metros cuadrados', 'Casa de estilo colonial con amplio patio y árboles frutales', true, true, true, true, '250 millones de pesos', 'Pedro López', true),
(6, 'Residencial', 'F-4', 'Puerto Montt', '1100 metros cuadrados', 'Casa de estilo rústico con vista al mar y acceso privado a la playa', true, true, true, true, '350 millones de pesos', 'Luisa García', true),
(7, 'Residencial', 'G-10', 'Puerto Varas', '950 metros cuadrados', 'Casa de estilo moderno con grandes ventanales y vista a los volcanes', true, true, true, true, '380 millones de pesos', 'Javier Sánchez', true),
(8, 'Residencial', 'H-7', 'Valdivia', '1000 metros cuadrados', 'Casa de estilo contemporáneo con piscina climatizada y jardín tropical', true, true, true, true, '420 millones de pesos', 'Carmen Díaz', true),
(9, 'Residencial', 'I-19', 'Puerto Montt', '800 metros cuadrados', 'Casa de diseño minimalista con amplios espacios y luz natural', true, true, true, true, '300 millones de pesos', 'Ricardo Fernández', true);
