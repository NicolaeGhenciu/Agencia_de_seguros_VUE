CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    localidad VARCHAR(50) NOT NULL,
    cp VARCHAR(10) NOT NULL,
    provincia VARCHAR(50) NOT NULL,
    entidad ENUM('empresa', 'particular') NOT NULL
);

CREATE TABLE polizas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    numero_poliza VARCHAR(50) NOT NULL,
    importe_recibo DECIMAL(10, 2) NOT NULL,
    fecha DATE NOT NULL,
    estado ENUM(
        'pre-anulada',
        'liquidada',
        'cobrada',
        'a_cuenta',
        'liquidada'
    ) NOT NULL,
    observaciones TEXT,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
);

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dni VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL,
  pass VARCHAR(100) NOT NULL
);

INSERT INTO polizas (id_cliente, numero_poliza, importe_recibo, fecha, estado, observaciones)
VALUES (1, 'A00001', 100.00, '2022-01-01', 'liquidada', 'Primera póliza');

INSERT INTO polizas (id_cliente, numero_poliza, importe_recibo, fecha, estado, observaciones)
VALUES (2, 'B00001', 200.00, '2022-02-01', 'cobrada', 'Primera póliza de la empresa');

INSERT INTO clientes (nombre, apellidos, telefono, localidad, cp, provincia, entidad)
VALUES ('Juan', 'Pérez', '555-555-555', 'Madrid', '28005', 'Madrid', 'particular');

INSERT INTO clientes (nombre, apellidos, telefono, localidad, cp, provincia, entidad)
VALUES ('Empresa S.L.', '', '555-555-556', 'Barcelona', '08005', 'Barcelona', 'empresa');
