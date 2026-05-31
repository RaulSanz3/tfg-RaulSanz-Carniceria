
CREATE TABLE clientes (
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
    id_cliente INT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    estado ENUM('Recibido','En preparación','Listo','Entregado') DEFAULT 'Recibido',
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
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
('Ternera'),('Cerdo'),('Pollo'),('Elaborados'),('Embutidos'),('Cordero'),('Iberico');

INSERT INTO productos (nombre, descripcion, precio, unidad_medida, stock, imagen, id_categoria) VALUES
('Filetes de ternera', 'Filetes de primera calidad', 14.90, 'kg', 50, NULL, 1),
('Chuleton de ternera', '', 21.90, 'kg', 30, NULL, 1),
('Entrecot de ternera', '', 25.90, 'kg', 30, NULL, 1),
('Solomillo de ternera', '', 35.80, 'kg', 30, NULL, 1),
('Cadera de ternera', '', 18.50, 'kg', 30, NULL, 1),
('Babilla de ternera', '', 17.80, 'kg', 30, NULL, 1),
('Espaldilla de ternera', '', 16.50, 'kg', 30, NULL, 1),
('Contra de ternera', '', 15.90, 'kg', 30, NULL, 1),
('Tapa de ternera', '', 16.90, 'kg', 30, NULL, 1),
('Redondo de ternera', '', 14.50, 'kg', 30, NULL, 1),
('Tapilla de ternera', '', 19.50, 'kg', 30, NULL, 1),
('Cantero de cadera', '', 19.80, 'kg', 30, NULL, 1),
('Aguja de ternera', '', 15.80, 'kg', 30, NULL, 1),
('Morcillo de ternera', '', 15.90, 'kg', 30, NULL, 1),
('Churrasco de ternera', '', 10.80, 'kg', 30, NULL, 1),
('Chuleta de cerdo', '', 7.90, 'kg', 25, NULL, 2),
('Lomo de cerdo', '', 8.90, 'kg', 25, NULL, 2),
('Jamon de cerdo', '', 8.75, 'kg', 25, NULL, 2),
('Costilla de cerdo', '', 7.95, 'kg', 25, NULL, 2),
('Panceta de cerdo', '', 7.80, 'kg', 25, NULL, 2),
('Solomillo de cerdo', '', 9.80, 'kg', 25, NULL, 2),
('Aguja de cerdo', '', 6.50, 'kg', 25, NULL, 2),
('Secreto de cerdo', '', 10.80, 'kg', 25, NULL, 2),
('Pluma de cerdo', '', 14.50, 'kg', 25, NULL, 2),
('Alas de pollo', '', 4.90, 'kg', 20, NULL, 3),
('Jamoncitos de pollo', '', 3.95, 'kg', 20, NULL, 3),
('Pechuga de pollo', '', 7.80, 'kg', 20, NULL, 3),
('Pechuga de pavo', '', 11.90, 'kg', 20, NULL, 3),
('Filete de contramuslo', '', 6.80, 'kg', 20, NULL, 3),
('Brochetas de pollo', '', 9.80, 'kg', 20, NULL, 3),
('Salchicha de pollo', '', 8.90, 'kg', 20, NULL, 3),
('Chorizo de pollo', '', 7.90, 'kg', 20, NULL, 3),
('Conejo', '', 9.80, 'kg', 20, NULL, 3),
('Lomo adobado', '', 9.80, 'kg', 20, NULL, 4),
('Costilla adobada', '', 8.40, 'kg', 20, NULL, 4),
('Chorizo fresco', '', 10.80, 'kg', 20, NULL, 4),
('Choricillo barbacoa', '', 7.95, 'kg', 20, NULL, 4),
('Salchichas', '', 8.90, 'kg', 20, NULL, 4),
('Picadillo', '', 8.90, 'kg', 20, NULL, 4),
('Pincho moruno', '', 9.40, 'kg', 20, NULL, 4),
('Hamburguesa de ternera', '', 12.80, 'kg', 20, NULL, 4),
('Hamburguesa de vaca', '', 14.50, 'kg', 20, NULL, 4),
('Oreja guisada', '', 9.95, 'kg', 20, NULL, 4),
('Callos guisados', '', 9.95, 'kg', 20, NULL, 4),
('Chorizo casero', 'Chorizo artesano tradicional', 13.50, 'kg', 30, NULL, 5),
('Morcilla roja', '', 10.50, 'kg', 9, NULL, 5),
('Adobos caseros blancos e ibericos', '', 6.00, 'kg', 12, NULL, 5),
('Lechal por medios', '', 19.70, 'kg', 10, NULL, 6),
('Recetal por medios', '', 16.50, 'kg', 10, NULL, 6),
('Pierna de cordero', '', 16.50, 'kg', 10, NULL, 6),
('Paletilla de cordero', '', 16.80, 'kg', 10, NULL, 6),
('Chuletillas de cordero', '', 23.80, 'kg', 10, NULL, 6),
('Falda de cordero', '', 8.90, 'kg', 10, NULL, 6),
('Cuello de cordero', '', 14.90, 'kg', 10, NULL, 6),
('Cabrito por medio', 'Precio segun mercado', 0.00, 'ud', 5, NULL, 6),
('Solomillo iberico', '', 20.90, 'kg', 15, NULL, 7),
('Pluma iberica', '', 25.95, 'kg', 15, NULL, 7),
('Presa iberica', '', 26.90, 'kg', 15, NULL, 7),
('Secreto iberico', '', 24.50, 'kg', 15, NULL, 7),
('Tapilla iberica', '', 14.90, 'kg', 15, NULL, 7),
('Lagarto iberico', '', 18.30, 'kg', 15, NULL, 7),
('Abanico iberico', '', 18.30, 'kg', 15, NULL, 7),
('Lagrimas ibericas', '', 15.90, 'kg', 15, NULL, 7),
('Lomo adobado iberico', '', 23.50, 'kg', 15, NULL, 7);

INSERT INTO clientes (nombre, apellidos, email, password, telefono, rol, verificado)
VALUES (
    'Admin',
    'Carniceria',
    'admin@carniceria.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '000000000',
    'admin',
    1
);