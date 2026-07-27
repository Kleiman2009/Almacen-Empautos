INSERT INTO repuestos SET 
nombre = 'Amortiguador delantero derecho chevrolet spark gt modelo 2011..._ beat _ Gabriel G707050', 
categoria = 'suspension', 
marca_vehiculo = 'Chevrolet', 
imagen_url = 'img/fotos productos/amortiguadores/chevrolet/Spark/Amortiguador delantero derecho chevrolet spark gt modelo 2011..._ beat _ Gabriel G707050/WhatsApp Image 2026-02-21 at 9.35.24 AM.jpeg', 
subcategoria = 'amortiguadores', 
marca_repuesto = 'Gabriel', 
referencia = 'G707050';

INSERT INTO repuestos SET 
nombre = 'Amortiguador a gas trasero chevrolet Spark Chronos _ Tecnogama 96424027', 
categoria = 'suspension', 
marca_vehiculo = 'Chevrolet', 
imagen_url = 'img/fotos productos/amortiguadores/chevrolet/Spark/Amortiguador a gas trasero chevrolet Spark Chronos _ Tecnogama 96424027/WhatsApp Image 2026-02-20 at 8.19.57 AM.jpeg', 
subcategoria = 'amortiguadores', 
marca_repuesto = 'Tecnogama', 
referencia = '96424027';

INSERT INTO repuestos SET 
nombre = 'Amortiguador delantero izquierdo mazda 2 _ Gabriel G708051', 
categoria = 'suspension', 
marca_vehiculo = 'Mazda', 
imagen_url = 'img/fotos productos/amortiguadores/mazda/Amortiguador delantero izquierdo mazda 2 _ Gabriel G708051/WhatsApp Image 2026-02-21 at 9.42.34 AM.jpeg', 
subcategoria = 'amortiguadores', 
marca_repuesto = 'Gabriel', 
referencia = 'G708051';



DESCRIBE repuestos;

INSERT INTO repuestos (nombre, categoria, marca_vehiculo, imagen_url, subcategoria, marca_repuesto, referencia) VALUES 

-- CHEVROLET SPARK
('Amortiguador delantero derecho chevrolet spark gt modelo 2011..._ beat _ Gabriel G707050', 'suspension', 'Chevrolet', 'img/fotos productos/amortiguadores/chevrolet/Spark/Amortiguador delantero derecho chevrolet spark gt modelo 2011..._ beat _ Gabriel G707050/WhatsApp Image 2026-02-21 at 9.35.24 AM.jpeg', 'amortiguadores', 'Gabriel', 'G707050'),

('Amortiguador a gas trasero chevrolet Spark Chronos _ Tecnogama 96424027', 'suspension', 'Chevrolet', 'img/fotos productos/amortiguadores/chevrolet/Spark/Amortiguador a gas trasero chevrolet Spark Chronos _ Tecnogama 96424027/WhatsApp Image 2026-02-20 at 8.19.57 AM.jpeg', 'amortiguadores', 'Tecnogama', '96424027'),

-- MAZDA
('Amortiguador delantero izquierdo mazda 2 _ Gabriel G708051', 'suspension', 'Mazda', 'img/fotos productos/amortiguadores/mazda/Amortiguador delantero izquierdo mazda 2 _ Gabriel G708051/WhatsApp Image 2026-02-21 at 9.42.34 AM.jpeg', 'amortiguadores', 'Gabriel', 'G708051'),

-- RENAULT
('Amortiguador delantero derecho renault duster 4x2 _ Gabriel G708238', 'suspension', 'Renault', 'img/fotos productos/amortiguadores/renault/Amortiguador delantero derecho renault duster 4x2 _ Gabriel G708238/WhatsApp Image 2026-02-21 at 9.45.28 AM.jpeg', 'amortiguadores', 'Gabriel', 'G708238

');

ALTER TABLE repuestos 
MODIFY subcategoria VARCHAR(100),
MODIFY marca_repuesto VARCHAR(100),
MODIFY referencia VARCHAR(100);


use repuestos;
select * from repuestos;

/* INSERTAR PRODUCTOS: CATEGORÍA ACEITES - REPUESTOS MALAGÓN */

INSERT INTO repuestos (nombre, categoria, marca_vehiculo, imagen_url, subcategoria, marca_repuesto, referencia) VALUES 

('Aceite Multigrado Elf Evolution 5w30', 'aceite', 'todos', './img/fotos productos/aceites/Elf5w30.png', 'motor', 'Elf', '5w30'),

('Aceite Multigrado Elf Evolution 10w30', 'aceite', 'todos', './img/fotos productos/aceites/Elf10w30.png', 'motor', 'Elf', '10w30'),

('Aceite Multigrado Elf Evolution 20w50', 'aceite', 'todos', './img/fotos productos/aceites/Elf20w50.png', 'motor', 'Elf', '20w50'),

('Aceite Multigrado Gulf 20w50', 'aceite', 'todos', './img/fotos productos/aceites/Gulf20w50.png', 'motor', 'Gulf', '20w50'),

('Aceite Multigrado Chevron Havoline 20w50', 'aceite', 'todos', './img/fotos productos/aceites/Havoline20w50.png', 'motor', 'Chevron', '20w50'),

('Aceite Multigrado Chevron Havoline 80w90', 'aceite', 'todos', './img/fotos productos/aceites/Havoline80w90.png', 'transmision', 'Chevron', '80w90');

DELETE FROM repuestos WHERE id = 19;
/* SCRIPT CON NOMBRES CORREGIDOS - REPUESTOS MALAGÓN */

-- Primero vaciamos lo que haya quedado mal (opcional, por si quieres limpiar la tabla)
-- TRUNCATE TABLE repuestos; 

INSERT INTO repuestos (nombre, categoria, marca_vehiculo, imagen_url, subcategoria, marca_repuesto, referencia) VALUES 

-- CHEVROLET
('Amortiguador Delantero Derecho Chevrolet Spark GT / Beat', 'suspension', 'Chevrolet', 'img/fotos productos/amortiguadores/chevrolet/Spark/Amortiguador delantero derecho chevrolet spark gt modelo 2011..._ beat _ Gabriel G707050/WhatsApp Image 2026-02-21 at 9.35.24 AM.jpeg', 'amortiguadores', 'Gabriel', 'G707050'),

('Amortiguador Trasero a Gas Chevrolet Spark Chronos', 'suspension', 'Chevrolet', 'img/fotos productos/amortiguadores/chevrolet/Spark/Amortiguador a gas trasero chevrolet Spark Chronos _ Tecnogama 96424027/WhatsApp Image 2026-02-20 at 8.19.57 AM.jpeg', 'amortiguadores', 'Tecnogama', '96424027'),

('Amortiguador Trasero a Gas Chevrolet Spark GT (2011+)', 'suspension', 'Chevrolet', 'img/fotos productos/amortiguadores/chevrolet/Spark/Amortiguador a gas trasero chevrolet Spark Gt 2011.... _ Tecnogama 95026519/WhatsApp Image 2026-02-20 at 8.16.51 AM.jpeg', 'amortiguadores', 'Tecnogama', '95026519'),

-- MAZDA
('Amortiguador Delantero Izquierdo Mazda 2', 'suspension', 'Mazda', 'img/fotos productos/amortiguadores/mazda/Amortiguador delantero izquierdo mazda 2 _ Gabriel G708051/WhatsApp Image 2026-02-21 at 9.42.34 AM.jpeg', 'amortiguadores', 'Gabriel', 'G708051'),

('Amortiguador Delantero Derecho Mazda 3 (2004-2014)', 'suspension', 'Mazda', 'img/fotos productos/amortiguadores/mazda/Amortiguador delantero derecho mazda 3 2.0 2004-2014 _ Gabriel G707328/WhatsApp Image 2026-02-21 at 9.41.04 AM.jpeg', 'amortiguadores', 'Gabriel', 'G707328'),

-- NISSAN
('Amortiguador Delantero Derecho Nissan Tiida', 'suspension', 'Nissan', 'img/fotos productos/amortiguadores/nissan/Amortiguador delantero derecho nissan tiida _ Gabriel G708018/WhatsApp Image 2026-02-21 at 9.38.38 AM.jpeg', 'amortiguadores', 'Gabriel', 'G708018'),

('Amortiguador Delantero Izquierdo Nissan Tiida', 'suspension', 'Nissan', 'img/fotos productos/amortiguadores/nissan/Amortiguador delantero izquierdo nissan tiida _ Gabriel G708019/WhatsApp Image 2026-02-21 at 9.38.38 AM (1).jpeg', 'amortiguadores', 'Gabriel', 'G708019'),

-- RENAULT
('Amortiguador Delantero Derecho Renault Duster 4x2', 'suspension', 'Renault', 'img/fotos productos/amortiguadores/renault/Amortiguador delantero derecho renault duster 4x2 _ Gabriel G708238/WhatsApp Image 2026-02-21 at 9.45.28 AM.jpeg', 'amortiguadores', 'Gabriel', 'G708238'),

('Amortiguador Delantero Izquierdo Renault Duster 4x2', 'suspension', 'Renault', 'img/fotos productos/amortiguadores/renault/Amortiguador delantero izquierdo renault duster 4x2 _ Gabriel G708239/WhatsApp Image 2026-02-21 at 9.45.28 AM (1).jpeg', 'amortiguadores', 'Gabriel', 'G708239');