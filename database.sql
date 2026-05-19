CREATE DATABASE IF NOT EXISTS carniceria;
USE carniceria;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellidos VARCHAR(150),
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    rol ENUM('cliente', 'admin') DEFAULT 'cliente',
    verificado TINYINT(1) DEFAULT 0,
    codigo_verificacion VARCHAR(6)
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    unidad_medida ENUM('kg','ud') NOT NULL,
    stock DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    estado ENUM('Recibido','En preparación','Listo','Entregado') DEFAULT 'Recibido',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE detalle_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    id_producto INT,
    cantidad DECIMAL(10,2),
    precio_unitario DECIMAL(10,2),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);

INSERT INTO categorias (nombre) VALUES
('Ternera'), ('Cerdo'), ('Pollo'), ('Elaborados'), ('Embutidos'), ('Ofertas');

INSERT INTO productos (nombre, descripcion, precio, unidad_medida, stock, imagen, id_categoria)
VALUES
('Filetes de ternera', 'Filetes de primera calidad', 14.90, 'kg', 50, 'ternera1.jpg', 1),
('Chorizo casero', 'Chorizo artesano tradicional', 9.50, 'kg', 30, 'chorizo1.jpg', 5);
