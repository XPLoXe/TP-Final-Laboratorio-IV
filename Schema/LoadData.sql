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
	associated_id INT,
	first_name NVARCHAR(50),
	last_name NVARCHAR(50),
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (user_id),
	FOREIGN KEY (user_role_id) REFERENCES UserRoles (user_role_id)
);

CREATE TABLE Companies (
	company_id INT AUTO_INCREMENT,
	name NVARCHAR(50) NOT NULL,
	year_of_foundation YEAR NOT NULL,
	city VARCHAR(100) NOT NULL,
	description NVARCHAR(1000) NOT NULL,
	logo MEDIUMTEXT DEFAULT NULL,
	email NVARCHAR(50) NOT NULL,
	phone_number VARCHAR(20) NOT NULL,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (company_id)
);

CREATE TABLE Careers (
	career_id INT,
	description VARCHAR(100),
	active BOOL NOT NULL,
	PRIMARY KEY (career_id)
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
	company_id INT NOT NULL,
	job_position_id INT,
	user_id INT DEFAULT NULL,
	description NVARCHAR(3000) NOT NULL,
	publication_date DATE NOT NULL,
	expiration_date DATE,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (job_offer_id),
	FOREIGN KEY (company_id) REFERENCES Companies (company_id),
	FOREIGN KEY (job_position_id) REFERENCES JobPositions (job_position_id),
	FOREIGN KEY (user_id) REFERENCES Users (user_id)
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
INSERT INTO Users (user_id, email, user_password, user_role_id, associated_id, first_name, last_name) VALUES
(1, 'admin@admin.com', 'admin99', 1, null, 'Juan Carlos', 'Administradorio'),
(2, 'ddouthwaite0@goo.gl', 123, 2, 1, 'Devlen', 'Douthwaite'),
(3, 'wlorant1@sbwire.com', 123, 2, 2, 'Wyatan', 'Lorant'),
(4, 'aseemmonds2@upenn.edu', 321, 2, 3, 'Alanson', 'Seemmonds'),
(5, 'fgorvetteg@list-manage.com', 54321, 2, 17, 'Frayda', 'Gorvette');
INSERT INTO Companies (company_id, name, year_of_foundation, city, description, logo, email, phone_number) VALUES
(1,'Efreint Dominios',1983,'Capital Federal','Efreint Dominios es una empresa de dominios donde las Empresas registran dominios para promocionarse o para relacionarse estrechamente con los usuarios, gracias al uso de plataformas especialmente creadas para ello.','Efreint.png','efreint@dom.com','0800-323-2413'),
(2,'Ñ''s Club',2000,'Barcelona','Fundada en 2000, la historia de la música en Barcelona es sinónimo del nombre Ñ''s Club, un lugar de referencia nacional e internacional para la cultura y el entretenimiento. ubicado en un edificio singular vinculado al paisaje industrial de la ciudad, y con una fachada que es en sí misma icónica. En Ñ''s Club han tocado grandes y menos conocidos artistas y bandas, ya que sus sesiones de club pueden albergar grupos de cualquier tipo, pequeños conjuntos incluidos, pero todos con un denominador común: su calidad.','ñ.png','n@club.com','34 936 67 55 59'),
(3,'Alejandro''s Spa',1997,'Mar del Plata','En Alejandro''s Spa tenemos como objetivo prioritario la seguridad y el bienestar de nuestros clientes y empleados. Cuidamos cada detalle para que disfrutes al máximo de tu experiencia. Aunado a los altos estándares de salud e higiene de Alejandro''s Spa, firmemente establecidos en nuestros Spas, hemos reforzado nuestros protocolos trabajando estrechamente con ISPA (Asociación Internacional de Spas) y con la asociación de Spas y Centros de Belleza "Spa BCN Connect" para conseguir el sello Spa Quality Certificate. Asimismo, todas nuestras terapeutas han tomado los Cursos recomendados por la Organización Mundial de la Salud (OMS) y cuentan con los diplomas que lo certifican.','alejandro.png','aleb2800@gmail.com','02233019208'),
(4,'Biskuits Roover',2016,'Berlin','Biskuits Roover se creó en 2016 como resultado de la combinación entre Poult (el líder francés) y Banketgroep (Países Bajos). Como plataforma de consolidación líder de la industria en Europa, el grupo adquirió en 2018: A&W (Alemania), Stroopwafel & Co (Países Bajos), Northumbrian Fine Foods (Reino Unido), Arluy (España), en 2019 Aviateur (Países Bajos) y en 2021 Dan Cake (Portugal) para convertirse en el líder europeo en el mercado de galletas dulces de marca privada. Biskuits Roover está indirectamente controlada por ciertos fondos de inversión de capital privado asesorados por Platinum Equity Advisors, LLC ("Asesores", y dichos fondos colectivamente "Platinum").','biskuitspng.png','biskuits@roover.com','0810-232-1113'),
(5,'Joraca',1998,'Capital Federal','Creemos en un mundo donde tienes total libertad para ser tú mismo, sin juzgar. Para experimentar. Para expresarse. Ser valiente y tomar la vida como una aventura extraordinaria. Por lo tanto, nos aseguramos de que todos tengan las mismas oportunidades de descubrir todas las cosas increíbles de las que son capaces, sin importar quiénes son, de dónde son o qué aspecto les gusta al jefe. Existimos para darte la confianza de ser quien quieras ser.','Joraca.png','joraca@gmail.com','555-351-3341'),
(6,'Messirve S.A.',1901,'Barcelona','Fundado en 1899 por un grupo de futbolistas suizos, españoles, alemanes e ingleses liderados por Joan Gamper, el club se ha convertido en un símbolo de la cultura catalana y del catalanismo, de ahí el lema "Més que un club" ("Más que un club"). A diferencia de muchos otros clubes de fútbol, los aficionados poseen y operan Barcelona. Es el cuarto equipo deportivo más valioso del mundo, con un valor de 4.060 millones de dólares, y el club de fútbol más rico del mundo en términos de ingresos, con una facturación anual de 840,8 millones de euros. El himno oficial de Barcelona es el "Cant del Barça", escrito por Jaume Picas y Josep Maria Espinàs. El Barcelona juega tradicionalmente en tonos oscuros de rayas azules y rojas, lo que lleva al apodo de Blaugrana.','messirveSA.png','messirve@ohyeah.com','0800-MESSI'),
(7,'Floro',1996,'Mar del Plata','Somos una familia dedicada a las flores hace más de 20 años. Producimos parte de nuestras flores. Formamos un equipo de trabajo donde padre, madre, hijas y floristas profesionales llevan a cabo innumerables momentos especiales. Nuestra mision, es llevarte emociones, despertar sentimientos, activar tus sentidos. Y las flores, en cada una de sus variedades te ofrecen eso. Por lo tanto no ofrecemos nada mas que flores, ofrecemos sonrizas, abrazos, besos y lagrimas. Estamos ahi cuando naces, cuando te bautizas, cuando te dicen te amo por primera vez, cuando te casas o cuando te toca partir... Una flor es una demostracion, es un mimo, estamos seguro de eso y quremos compartirlo.','Floro.png','floro@ILove.com','2239478839'),
(8,'Pablo Escobas',1998,'Mar del Plata','Una casa limpia y ordenada puede hacerte sonreir, con los productos de Pablo Escobas vas a lograr esa felicidad extrema que tanto deseas. Poné manos a la obra y decí: ¡Chau suciedad! ¡Bienvenida belleza!','Pablo.png','pabloescobas@gmail.com','2238493929'),
(9,'Lautaro & Asoc.',1997,'New York','Nuestros clientes en Lautaro & Asoc. Firm provienen de una diversidad de orígenes y ubicaciones. Todos los días se nos acercan con varios problemas, preguntas e inquietudes, pero cada cliente está buscando lo mismo: una defensa eficaz, sólida y ganadora de los cargos penales federales. Eso es exactamente lo que ofrecemos. El bufete de abogados Lautaro & Asoc. está adoptando un enfoque sin precedentes para la defensa criminal federal. Como equipo, nos hemos comprometido a desarrollar la mejor práctica de defensa federal en los Estados Unidos.','Lautaro.png','lautaroyasoc@firm.com','903 932 331'),
(10,'Meme Beauty',2007,'Bariloche','Nuestro objetivo es ofrecer productos japoneses de vanguardia para el cuidado de la piel y tecnologías relacionadas, y cambiar la percepción de los conceptos y las rutinas del cuidado de la piel a la vieja usanza tradicional en la vida cotidiana. Meme Beauty es la agencia exclusiva de Artistic & Co. en la parte sur de la Argentina.','Meme.png','meme@xd.com','2019330229'),
(11,'Granos Montiel S.A.',1966,'Santa Rosa','Granos Montiel S.A., fue la primera de su clase. El registro en 1966 pronto fue acreditada como la marca líder por su calidad y numerosas exportaciones. El proceso de desarrollo es cuidadosamente supervisado desde el momento de la siembra de la semilla, por miembros de nuestro personal especialmente capacitados en este campo.','Granos.png','montiel@granos.com','16788728472'),
(12,'Leopard',1983,'Melbourne','El deporte tiene el poder de transformarnos y empoderarnos. Como una de las marcas deportivas líderes en el mundo, es natural que queramos estar en el mismo campo de juego que los atletas más rápidos del planeta. Para lograrlo, la marca Leopard se basa en los mismos valores que hacen a un excelente atleta.','Leopard.png','leopard@notpuma.com','61394291139'),
(13,'Hoteles Magoya',1956,'Mar Del Plata','EL ESTÁNDAR DE ORO. 100 años de historia. Con un credo inquebrantable y una filosofía corporativa de compromiso inquebrantable con el servicio, tanto en nuestros hoteles como en nuestras comunidades, Hoteles Magoya ha sido reconocido con numerosos premios por ser el estándar de oro de la hospitalidad. Si el servicio no lo satisface, que lo pague Magoya.','Hoteles.png','magoya@hotels.com','22388478293'),
(14,'KK Calvin',1984,'Mar del Plata','Nuestra misión es ayudar e inspirar a las personas a través de la carrera y, junto con la ayuda de nuestros miembros, simpatizantes, participantes y socios de KK Calvin, trabajamos duro todos los días para cumplir ese objetivo. Tenga la seguridad de que con cada paso que damos, nos enfocamos en lograr el mayor impacto posible en la comunidad, la juventud, la caridad y en cada corredor individual.','KK.png','kk@calvin.com','2239239293'),
(15,'F''s Chat',2011,'Piedra del Aguila','F''s Chat es utilizado por miles de solteros que continúan eligiendo nuestros servicios para ayudarlos a conocer gente nueva. Ya sea que esté buscando una conversación telefónica divertida, quiera encontrar su próxima cita caliente o esté buscando algo más, lo encontrará en F''s Chat. F''s Chat es un servicio premium para solteros que puede experimentar de dos maneras: a través de la línea de chat original o en la nueva aplicación móvil para teléfonos móviles iOS y Android. No importa cómo elija usar F''s Chat, tendrá control total sobre con quién se conecta, cuándo y cómo.','F.png','f@chat.com','2938839183'),
(16,'Igor',2009,'Carlos Paz','En Igor ofrecemos un enfoque holístico de la educación inspirado en la naturaleza. Consideramos que nuestro papel no es solo educar a los niños de hoy, sino también cultivar a los líderes del mañana. Al brindarles a los niños un entorno enriquecedor y receptivo para descubrir, aprender, crecer y realizar su potencial, nuestros niños se empoderan con habilidades escolares y de preparación para la vida. Basándonos en sus sólidas raíces éticas y educativas, creemos que nuestros hijos pueden liderar el camino hacia un mañana mejor.','Igor.png','igor@daycare.com','1779923913'),
(17,'Mirtha Martinez',1902,'Capital Federal','Mirtha Martinez exhibe películas excepcionales que atraen a una audiencia extensa y variada que es culta, socialmente consciente, altamente educada y conocedora de la web. Ofrecemos varias plataformas, a través de nuestros teatros y nuestro sitio web, para ayudar a que su mensaje llegue a nuestra sofisticada clientela.','Mirtha.png','mirtha@lagrande.com','0118392839'),
(18,'Xilofonos',2018,'Mar de las Pompas','Como nuestro nombre lo indica, nos dedicamos a la venta, reparación, compra, traslado, limpieza, apreciación, asociación, fundición y alquiler de Xilofones. Más de 2 años de experiencia en el pequeño rubro de los Xilofones nos llevaron a ser los líderes mundiales. "Xylophones, what else?"','xilofonos.png','xilofonos@xilofonos.com','0800 XILOFONO'),
(19,'Zulma Lobato Designs',2004,'San Isidro','Nuestro objetivo es ayudarlo a verse y sentirse bien viviendo una "vida colorida" como lo hizo una vez la icónica Zulma Lobato. Ofreciendo la selección más completa de ropa, calzado y accesorios de Zulma Lobato para... ¿mujer?, complementada con una multitud de artículos para niños, hombres y regalos, nos enorgullecemos de una experiencia de compra cómoda. años de experiencia. Estamos listos para ayudarlo a elegir ese vestido especial para un próximo evento o ayudarlo a actualizar su guardarropa con estilo para la temporada. Participe en nuestro programa de fidelización de clientes y obtenga ahorros cada vez que compre.','zulma.png','zulmalobato@Designs.com','011382938293'),
(20,'Wilson Industries',2005,'Mar del Plata','Utilizamos las últimas tecnologías en los campos cognitivo-digital para transformar su organización en todos los aspectos. Wilson Industries es un juego puro en el espacio digital y cognitivo. Aprovechamos las últimas tecnologías y metodologías para ayudar a las organizaciones a transformarse en todos los aspectos. Queremos transformar el mundo, paso a paso. Prosperamos transformando organizaciones para un futuro digital y cognitivo, y soñamos con transformar nuestra industria con oportunidades de clase mundial para talentos en todo el mundo.','wilson.png','wilson@industries.com','02238378274'),
(21,'Qatar Earthways',2008,'Qatar','Qatar Earthways se enorgullece de ser una de las terralíneas de menor antigüedad que opera en los seis continentes y, gracias a la respuesta de los clientes a nuestras ofertas, también una de la terralíneas de más rápido crecimiento en el mundo. Conectamos diariamente más de 160 destinos del mundo, con una flota de micros de última generación y un nivel inigualable de servicio desde nuestro hogar y centro logístico.','Qatar.png','qatar@earthways','94 8328 8882 913'),
(22,'Tramontina',1963,'Capital Federal','Más que números, lo que define a Tramontina es el esfuerzo permanente para mejorar cada día más la vida de la gente. Un esfuerzo que se traduce en más de 18 mil artículos con propósitos y especificaciones distintas, pero con creencias y valores de una marca única.','Tramontina.png','tramontina@tt.com','011839283774'),
(23,'Uniformes Singanas',1922,'Mar del Plata','Luego de casi 100 años de ventas de uniformes bajo el nombre de Uniformes Conganas, se nos terminaron yendo las ganas. Ahora hacemos todo medio así no más pero por lo menos les ofrecemos buenos precios ¯\_(ツ)_/¯','uniformes.png','asd@gmail.com','022348829392'),
(24,'Rituales Magumbos',1916,'Salem','En Rituales Magumbos proporcionamos una amplia variedad de rituales demoníacos que podrían tanto perjudicar su vida como la de la gente que lo rodea. O como diría nuestro líder: "Me tuku e te punaha tetahi momo Kaiwhakahaere Kaiwhakamahi ki te: hanga, whakarereke me te muku i nga Kamupene."','rituales.png','666@magumbo.com','666 666 666'),
(25,'soRny',1946,'Tokyo','Objetivo Llena el mundo de emoción, a través del poder de la creatividad y la tecnología. Valores. Sueños y curiosidad. Sea pionero en el futuro con sueños y curiosidad. Diversidad. Busque la creación de lo mejor aprovechando la diversidad y los diferentes puntos de vista. Integridad y sinceridad. Gánate la confianza de la marca Sony mediante una conducta ética y responsable. Sustentabilidad. Cumplir con las responsabilidades de nuestros grupos de interés mediante prácticas comerciales disciplinadas.','Sorny.png','sony@contact.us.com','26 8293 727 2331'),
(26,'Y',2015,'Mar del Plata','Los eventos Y brindan a los clientes vanguardistas una perspectiva nueva y una forma única de comprar colecciones de diseñadores actuales. Nuestras Pop Up Shops han seleccionado colecciones de marcas de diseñadores locales y mundiales, alojadas en escaparates creativos. Y ofrece a los clientes leales la oportunidad de descubrir marcas emergentes, a menudo a precios muy reducidos.','y.png','y@gmail.com','2239329301'),
(27,'Volt US',1974,'Punta del Este','Volt US es una empresa Uruguaya enfocada en la distribución de energía eléctrica del país, que aplica las mejores prácticas de gestión para asegurar la excelencia técnica, la calidad de servicio y atención de sus usuarios, el desarrollo de sus empleados y el compromiso con las comunidades donde está presente. Actualmente, llega a más de 1.800.000 usuarios a través de más 65.000 kilómetros de líneas y emplea a más de 3.300 personas.','Volt.png','volt@us.com','37299318413'),
(28,'Policlinico San Salvador',1996,'Capital Federal','Policlinico San Salvador es el sistema público de atención médica de urgencias y emergencias, tanto individuales como colectivas. La atención de los requerimientos del servicio de emergencia extrahospitalarios del subsector estatal será competencia de la autoridad responsable del Policlinico San Salvador, que tendrá a su cargo gestionar la atención de los pacientes en casos de urgencia-emergencia extrahospitalaria, brindando la respuesta más apta a la naturaleza de los auxilios.','policlinico.png','policlinico@urgencias.com','011774829472'),
(29,'Mom''s Spaghetti',2020,'Mar del Plata','Si tuvieras una oportunidad para apoderarte de todo lo que siempre quisiste en un momento. ¿Lo capturarías o dejarías que se escapara? Así es, nuestros Spaghettis son imperdibles, como los hacía tu mamá, ¿cómo sabemos eso? es un secreto, ¿vas a dejar pasar esta oportunidad única?','mom.png','mom.spaghetti@gmail.com','2238492838'),
(30,'Ortopedia Brown',2013,'Mar del Plata','Ortopedia Brown es la principal práctica ortopédica que atiende a marplatenses activos de todas las edades. Nuestro equipo de médicos capacitados en especialidades ofrece las últimas opciones de tratamiento quirúrgico y no quirúrgico para el espectro completo de subespecialidades ortopédicas: medicina deportiva, reemplazo total de articulaciones, columna, pie y tobillo, manos y extremidades superiores, cadera y rodilla, todo bajo un mismo techo.','ortopedia.png','ortopedia.brown@gmail.com','2237481927'),
(31,'David Propiedades',2017,'Capital Federal','David Propiedades Promueve el Sistema a Corredores, propietarios y compradores de vivienda, tanto en el sector residencial como comercial en Argentina y en el mundo. Atraemos Profesionales y desarrollamos soporte en áreas centralizadas. Asistimos a nuestros afiliados en la gestión de su oficina. Proporcionamos herramientas y sistemas para la contratación de nuevos y experimentados profesionales de ventas que tienen el deseo de alcanzar los mismos estándares por los que nos esforzamos en la industria de bienes raíces tal y como indica nuestro eslogan "tasa tasa, compranos una casa"','david.png','david.propiedades@contact.us.com','011728392932');
INSERT INTO JobOffers (job_offer_id, company_id, job_position_id, user_id, description, publication_date, expiration_date, active) VALUES
(1, 5, 10, null, 'Buscamos persona con actitud proactiva y amplia disponibilidad horaria. Nivel avanzado de inglés requerido (excluyente). Valoramos experiencia previa.', '2021-10-15', '2021-10-29', 1),
(2, 21, 18, null, 'Se busca jefe de administración con mínimo 10 años de experiencia comprobable, fluidez en español, inglés y árabe.', '2021-10-31', '2021-11-10', 0),
(3, 27, 2, 5, 'Se busca ex-capitán de la marina. Preferentemente con parche en el ojo. Ahoy!', '2021-11-01', '2022-01-01', 1),
(4, 7, 21, null, 'Buscamos joven capaz de realizar controles y pruebas de agroquímicos en campos florales. Mínimo 3 años de experiencia en puestos similares.', '2021-11-01', '2021-12-01', 1),
(5, 7, 20, null, '10 años de experiencia en Java mínimo REQUISITO EXCLUYENTE. Se requiere fluidez en inglés.', '2021-11-02', '2021-11-16', 1),
(6, 15, 8, null, 'No se requiere experiencia previa. Buen nivel de inglés preferentemente.', '2021-11-02', '2021-11-30', 1);