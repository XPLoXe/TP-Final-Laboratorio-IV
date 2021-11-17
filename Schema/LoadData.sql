DROP DATABASE IF EXISTS University;

CREATE DATABASE IF NOT EXISTS University;

USE University;

CREATE TABLE UserRoles (
	user_role_id INT AUTO_INCREMENT,
	description VARCHAR(50),
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (user_role_id)
);

CREATE TABLE Users (
	user_id INT AUTO_INCREMENT,
	user_role_id INT,
	email NVARCHAR(50) NOT NULL,
	user_password NVARCHAR(64) NOT NULL,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (user_id),
	FOREIGN KEY (user_role_id) REFERENCES UserRoles (user_role_id)
);

CREATE TABLE Careers (
	career_id INT,
	description VARCHAR(100),
	active BOOL NOT NULL,
	PRIMARY KEY (career_id)
);

CREATE TABLE Students (
	user_student_id INT NOT NULL,
	api_student_id INT NOT NULL,
    career_id INT NOT NULL,
    first_name NVARCHAR(50) NOT NULL,
    last_name NVARCHAR(50) NOT NULL,
    birth_date DATE NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
	api_active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (user_student_id),
	FOREIGN KEY (user_student_id) REFERENCES Users (user_id),
    FOREIGN KEY (career_id) REFERENCES Careers (career_id)
);

CREATE TABLE Companies (
	user_company_id INT NOT NULL,
	name NVARCHAR(50) NOT NULL,
	year_of_foundation YEAR NOT NULL,
	city VARCHAR(100) NOT NULL,
	description NVARCHAR(1000) NOT NULL,
	logo MEDIUMTEXT DEFAULT NULL,
	phone_number VARCHAR(20) NOT NULL,
	approved BOOL NOT NULL DEFAULT false,
	PRIMARY KEY (user_company_id),
	FOREIGN KEY (user_company_id) REFERENCES Users (user_id)
);

CREATE TABLE JobPositions (
	job_position_id INT,
	description VARCHAR(50) NOT NULL,
    career_id INT NOT NULL,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (job_position_id),
    FOREIGN KEY (career_id) REFERENCES Careers (career_id)
);

CREATE TABLE JobOffers (
	job_offer_id INT AUTO_INCREMENT,
	user_company_id INT NOT NULL,
	job_position_id INT,
	description NVARCHAR(3000) NOT NULL,
	publication_date DATE NOT NULL,
	expiration_date DATE,
	flyer MEDIUMTEXT DEFAULT NULL,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (job_offer_id),
	FOREIGN KEY (user_company_id) REFERENCES Companies (user_company_id),
	FOREIGN KEY (job_position_id) REFERENCES JobPositions (job_position_id)
);

CREATE TABLE Applications (
	user_student_id INT NOT NULL,
	job_offer_id INT NOT NULL,
	application_date DATE NOT NULL,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (user_student_id, job_offer_id),
	FOREIGN KEY (user_student_id) REFERENCES Students (user_student_id),
	FOREIGN KEY (job_offer_id) REFERENCES JobOffers (job_offer_id)
);

INSERT INTO UserRoles (user_role_id, description, active) VALUES 
(1, "Administrator", true),
(2, "Student", true),
(3, "Company", true);
INSERT INTO Careers (career_id, description, active) VALUES
 (1,'Naval engineering',true),
 (2,'Fishing engineering',false),
 (3,'University technician in programming',true),
 (4,'University technician in computer systems',true),
 (5,'University technician in textile production',true),
 (6,'University technician in administration',true),
 (7,'Bachelor in environmental management',false),
 (8,'University technician in environmental procedures and technologies',true);
INSERT INTO JobPositions (job_position_id, career_id, description, active) VALUES
 (1,1,'Jr naval engineer',true),
 (2,1,'Ssr naval engineer',true),
 (3,1,'Sr naval engineer',true),
 (4,2,'Jr fisheries engineer',true),
 (5,2,'Ssr fisheries engineer',true),
 (6,2,'Sr fisheries engineer',true),
 (7,3,'Java Jr developer',true),
 (8,3,'PHP Jr developer',true),
 (9,3,'Ssr developer',true),
 (10,4,'Full Stack developer',true),
 (11,4,'Sr developer',true),
 (12,4,'Project manager',true),
 (13,4,'Scrum Master',true),
 (14,5,'Jr textile operator',true),
 (15,5,'Textile production assistant manager',true),
 (16,5,'Textile design assistant',true),
 (17,5,'Textile production supervisor',true),
 (18,6,'Head of administration',true),
 (19,6,'Management analyst',true),
 (20,6,'Administration intern',true),
 (21,7,'Environmental management specialist',true),
 (22,7,'Environmental management coordinator',true),
 (23,8,'Received technician',true);
INSERT INTO Users (user_id, email, user_password, user_role_id) VALUES
(1, 'admin@admin.com', 'admin99', 1),
(2, 'ddouthwaite0@goo.gl', '12345', 2),
(3, 'wlorant1@sbwire.com', '54321', 2),
(4, 'aseemmonds2@upenn.edu', '12321', 2),
(5, 'fgorvetteg@list-manage.com', '54345', 2),
(6, 'kwitheford6@salon.com', '1123211', 2),
(7, 'sforrington9@webnode.com', '777777', 2),
(8, 'efreint@dom.com', 'abc123', 3),
(9, 'n@club.com', '123abc', 3),
(10, 'aleb2800@gmail.com', 'aaa123', 3),
(11, 'biskuits@roover.com', '123aaa', 3),
(12, 'joraca@gmail.com', 'abcba', 3),
(13, 'messirve@ohyeah.com', 'aaabaaa', 3),
(14, 'floro@ILove.com', 'bababa', 3),
(15, 'pabloescobas@gmail.com', 'ababab', 3),
(16, 'lautaroyasoc@firm.com', 'bbbbbb', 3),
(17, 'meme@xd.com', 'cccccc', 3),
(18, 'montiel@granos.com', 'g5r6ea', 3),
(19, 'leopard@notpuma.com', 'n4rt8t8', 3),
(20, 'magoya@hotels.com', 'thg29nb', 3),
(21, 'kk@calvin.com', '1rf1q48', 3),
(22, 'f@chat.com', 'fm9240m', 3),
(23, 'igor@daycare.com', 'ym43khnb', 3),
(24, 'mirtha@lagrande.com', 'mhkñl2m4w3', 3),
(25, 'xilofonos@xilofonos.com', 'xilo123', 3);
INSERT INTO Students (user_student_id, api_student_id, career_id, first_name, last_name, birth_date, phone_number,api_active) VALUES
(2, 1, 2, 'Devlen', 'Douthwaite', '2021-06-28', '849-713-4523',0),
(3, 2, 5, 'Wyatan', 'Lorant', '2021-02-23', '171-448-9062',1),
(4, 3, 2, 'Alanson', 'Seemmonds', '2021-07-03', '961-404-8720',1),
(5, 17, 1, 'Frayda', 'Gorvette', '2021-07-05', '152-846-1928',1),
(6, 7, 3, 'Kienan', 'Whiterford', '2021-09-15', '525-769-1695',0),
(7, 10, 4, 'Son', 'Forrington', '2021-03-13', '720-205-4748',1);
INSERT INTO Companies (user_company_id, name, year_of_foundation, city, description, phone_number, approved) VALUES
(8,'Efreint Dominios',1983,'Capital Federal','Efreint Dominios es una empresa de dominios donde las Empresas registran dominios para promocionarse o para relacionarse estrechamente con los usuarios, gracias al uso de plataformas especialmente creadas para ello.','0800-323-2413', 1),
(9,"Ñ''s Club",2000,'Barcelona',"Fundada en 2000, la historia de la música en Barcelona es sinónimo del nombre Ñ''s Club, un lugar de referencia nacional e internacional para la cultura y el entretenimiento. ubicado en un edificio singular vinculado al paisaje industrial de la ciudad, y con una fachada que es en sí misma icónica. En Ñ''s Club han tocado grandes y menos conocidos artistas y bandas, ya que sus sesiones de club pueden albergar grupos de cualquier tipo, pequeños conjuntos incluidos, pero todos con un denominador común: su calidad.",'34-936-67-55-59', 1),
(10,'Alejandro''s Spa',1997,'Mar del Plata','En Alejandro''s Spa tenemos como objetivo prioritario la seguridad y el bienestar de nuestros clientes y empleados. Cuidamos cada detalle para que disfrutes al máximo de tu experiencia. Aunado a los altos estándares de salud e higiene de Alejandro''s Spa, firmemente establecidos en nuestros Spas, hemos reforzado nuestros protocolos trabajando estrechamente con ISPA (Asociación Internacional de Spas) y con la asociación de Spas y Centros de Belleza \"Spa BCN Connect\" para conseguir el sello Spa Quality Certificate. Asimismo, todas nuestras terapeutas han tomado los Cursos recomendados por la Organización Mundial de la Salud (OMS) y cuentan con los diplomas que lo certifican.','02233019208', 1),
(11,'Biskuits Roover',2016,'Berlin','Biskuits Roover se creó en 2016 como resultado de la combinación entre Poult (el líder francés) y Banketgroep (Países Bajos). Como plataforma de consolidación líder de la industria en Europa, el grupo adquirió en 2018: A&W (Alemania), Stroopwafel & Co (Países Bajos), Northumbrian Fine Foods (Reino Unido), Arluy (España), en 2019 Aviateur (Países Bajos) y en 2021 Dan Cake (Portugal) para convertirse en el líder europeo en el mercado de galletas dulces de marca privada. Biskuits Roover está indirectamente controlada por ciertos fondos de inversión de capital privado asesorados por Platinum Equity Advisors, LLC (\"Asesores\", y dichos fondos colectivamente \"Platinum\").','0810-232-1113', 1),
(12,'Joraca',1998,'Capital Federal','Creemos en un mundo donde tienes total libertad para ser tú mismo, sin juzgar. Para experimentar. Para expresarse. Ser valiente y tomar la vida como una aventura extraordinaria. Por lo tanto, nos aseguramos de que todos tengan las mismas oportunidades de descubrir todas las cosas increíbles de las que son capaces, sin importar quiénes son, de dónde son o qué aspecto les gusta al jefe. Existimos para darte la confianza de ser quien quieras ser.','555-351-3341', 1),
(13,'Messirve S.A.',1901,'Barcelona','Fundado en 1899 por un grupo de futbolistas suizos, españoles, alemanes e ingleses liderados por Joan Gamper, el club se ha convertido en un símbolo de la cultura catalana y del catalanismo, de ahí el lema \"Més que un club\" (\"Más que un club\"). A diferencia de muchos otros clubes de fútbol, los aficionados poseen y operan Barcelona. Es el cuarto equipo deportivo más valioso del mundo, con un valor de 4.060 millones de dólares, y el club de fútbol más rico del mundo en términos de ingresos, con una facturación anual de 840,8 millones de euros. El himno oficial de Barcelona es el \"Cant del Barça\", escrito por Jaume Picas y Josep Maria Espinàs. El Barcelona juega tradicionalmente en tonos oscuros de rayas azules y rojas, lo que lleva al apodo de Blaugrana.','0800-MESSI', 1),
(14,'Floro',1996,'Mar del Plata','Somos una familia dedicada a las flores hace más de 20 años. Producimos parte de nuestras flores. Formamos un equipo de trabajo donde padre, madre, hijas y floristas profesionales llevan a cabo innumerables momentos especiales. Nuestra mision, es llevarte emociones, despertar sentimientos, activar tus sentidos. Y las flores, en cada una de sus variedades te ofrecen eso. Por lo tanto no ofrecemos nada mas que flores, ofrecemos sonrizas, abrazos, besos y lagrimas. Estamos ahi cuando naces, cuando te bautizas, cuando te dicen te amo por primera vez, cuando te casas o cuando te toca partir... Una flor es una demostracion, es un mimo, estamos seguro de eso y quremos compartirlo.','2239478839', 1),
(15,'Pablo Escobas',1998,'Mar del Plata','Una casa limpia y ordenada puede hacerte sonreir, con los productos de Pablo Escobas vas a lograr esa felicidad extrema que tanto deseas. Poné manos a la obra y decí: ¡Chau suciedad! ¡Bienvenida belleza!','2238493929', 1),
(16,'Lautaro & Asoc.',1997,'New York','Nuestros clientes en Lautaro & Asoc. Firm provienen de una diversidad de orígenes y ubicaciones. Todos los días se nos acercan con varios problemas, preguntas e inquietudes, pero cada cliente está buscando lo mismo: una defensa eficaz, sólida y ganadora de los cargos penales federales. Eso es exactamente lo que ofrecemos. El bufete de abogados Lautaro & Asoc. está adoptando un enfoque sin precedentes para la defensa criminal federal. Como equipo, nos hemos comprometido a desarrollar la mejor práctica de defensa federal en los Estados Unidos.','903 932 331', 1),
(17,'Meme Beauty',2007,'Bariloche','Nuestro objetivo es ofrecer productos japoneses de vanguardia para el cuidado de la piel y tecnologías relacionadas, y cambiar la percepción de los conceptos y las rutinas del cuidado de la piel a la vieja usanza tradicional en la vida cotidiana. Meme Beauty es la agencia exclusiva de Artistic & Co. en la parte sur de la Argentina.','2019330229', 1),
(18,'Granos Montiel S.A.',1966,'Santa Rosa','Granos Montiel S.A., fue la primera de su clase. El registro en 1966 pronto fue acreditada como la marca líder por su calidad y numerosas exportaciones. El proceso de desarrollo es cuidadosamente supervisado desde el momento de la siembra de la semilla, por miembros de nuestro personal especialmente capacitados en este campo.','16788728472', 1),
(19,'Leopard',1983,'Melbourne','El deporte tiene el poder de transformarnos y empoderarnos. Como una de las marcas deportivas líderes en el mundo, es natural que queramos estar en el mismo campo de juego que los atletas más rápidos del planeta. Para lograrlo, la marca Leopard se basa en los mismos valores que hacen a un excelente atleta.','61394291139', 1),
(20,'Hoteles Magoya',1956,'Mar Del Plata','EL ESTÁNDAR DE ORO. 100 años de historia. Con un credo inquebrantable y una filosofía corporativa de compromiso inquebrantable con el servicio, tanto en nuestros hoteles como en nuestras comunidades, Hoteles Magoya ha sido reconocido con numerosos premios por ser el estándar de oro de la hospitalidad. Si el servicio no lo satisface, que lo pague Magoya.','22388478293', 1),
(21,'KK Calvin',1984,'Mar del Plata','Nuestra misión es ayudar e inspirar a las personas a través de la carrera y, junto con la ayuda de nuestros miembros, simpatizantes, participantes y socios de KK Calvin, trabajamos duro todos los días para cumplir ese objetivo. Tenga la seguridad de que con cada paso que damos, nos enfocamos en lograr el mayor impacto posible en la comunidad, la juventud, la caridad y en cada corredor individual.','2239239293', 1),
(22,'F''s Chat',2011,'Piedra del Aguila','F''s Chat es utilizado por miles de solteros que continúan eligiendo nuestros servicios para ayudarlos a conocer gente nueva. Ya sea que esté buscando una conversación telefónica divertida, quiera encontrar su próxima cita caliente o esté buscando algo más, lo encontrará en F''s Chat. F''s Chat es un servicio premium para solteros que puede experimentar de dos maneras: a través de la línea de chat original o en la nueva aplicación móvil para teléfonos móviles iOS y Android. No importa cómo elija usar F''s Chat, tendrá control total sobre con quién se conecta, cuándo y cómo.','2938839183', 1),
(23,'Igor',2009,'Carlos Paz','En Igor ofrecemos un enfoque holístico de la educación inspirado en la naturaleza. Consideramos que nuestro papel no es solo educar a los niños de hoy, sino también cultivar a los líderes del mañana. Al brindarles a los niños un entorno enriquecedor y receptivo para descubrir, aprender, crecer y realizar su potencial, nuestros niños se empoderan con habilidades escolares y de preparación para la vida. Basándonos en sus sólidas raíces éticas y educativas, creemos que nuestros hijos pueden liderar el camino hacia un mañana mejor.','1779923913', 1),
(24,'Mirtha Martinez',1902,'Capital Federal','Mirtha Martinez exhibe películas excepcionales que atraen a una audiencia extensa y variada que es culta, socialmente consciente, altamente educada y conocedora de la web. Ofrecemos varias plataformas, a través de nuestros teatros y nuestro sitio web, para ayudar a que su mensaje llegue a nuestra sofisticada clientela.','0118392839', 1),
(25,'Xilofonos',2018,'Mar de las Pompas','Como nuestro nombre lo indica, nos dedicamos a la venta, reparación, compra, traslado, limpieza, apreciación, asociación, fundición y alquiler de Xilofones. Más de 2 años de experiencia en el pequeño rubro de los Xilofones nos llevaron a ser los líderes mundiales. Xylophones, what else?','0800 XILOFONO', 0);
INSERT INTO JobOffers (job_offer_id, user_company_id, job_position_id, description, publication_date, expiration_date, active) VALUES
(1, 12, 10, 'Buscamos persona con actitud proactiva y amplia disponibilidad horaria. Nivel avanzado de inglés requerido (excluyente). Valoramos experiencia previa.', '2021-10-15', '2021-10-29', 1),
(2, 21, 18, 'Se busca jefe de administración con mínimo 10 años de experiencia comprobable, fluidez en español, inglés y árabe.', '2021-10-31', '2021-12-10', 1),
(3, 12, 2, 'Se busca ex-capitán de la marina. Preferentemente con parche en el ojo. Ahoy!', '2021-11-01', '2022-01-01', 1),
(4, 14, 21, 'Buscamos joven capaz de realizar controles y pruebas de agroquímicos en campos florales. Mínimo 3 años de experiencia en puestos similares.', '2021-11-01', '2021-12-01', 1),
(5, 14, 20, '10 años de experiencia en Java mínimo REQUISITO EXCLUYENTE. Se requiere fluidez en inglés.', '2021-11-02', '2021-11-16', 1),
(6, 15, 8, 'No se requiere experiencia previa. Buen nivel de inglés preferentemente.', '2021-11-02', '2021-11-30', 1),
(7, 19, 4, 'Busco ingeniero en pesca junior para contar pececitos. Buena paga.', '2021-11-12', '2021-11-26', 1),
(8, 12, 11, 'Developer SENIOR ÚNICAMENTE. Sueldo en USDC.', '2021-11-12', '2021-12-12', 1),
(9, 23, 17, 'Se busca graduado en ingeniería textil para supervisar la producción de diversas telas.', '2021-11-13', '2021-12-13', 1);
INSERT INTO Applications (user_student_id, job_offer_id, application_date) VALUES
(4, 3, '2021-11-10'),
(7, 8, '2021-11-14')