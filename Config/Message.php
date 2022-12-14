<?php namespace Config;

define("STUDENT_INACTIVE", "<h4 class = 'text-center' style='color: red;'> El Usuario ha sido dado de baja </h4><p class = 'text-center' style='color: red;'> Para más información contactarse con la universidad </p> ");
define("WRONG_PASSWORD", "<h4 class = 'text-center' style='color: red;'> Contraseña incorrecta </h4>");
define("WRONG_EMAIL", "<h4 class = 'text-center' style='color: red;'> El Email ingresado no existe </h4>");
define("ERROR_VERIFY_PASSWORD" , "<h4 class = 'text-center' style='color: red;'> las contraseñas ingresadas no son las mismas </h4>");
define("ERROR_VERIFY_EMAIL", "<h4 class = 'text-center' style='color: red;'> El mail no existe en la Universidad </h4>");
define("ERROR_VERIFY_EMAIL_DATABASE", "<h4 class = 'text-center' style='color: red;'> El email ya tiene una cuenta registrada </h4>");
define("SIGNUP_SUCCESS", "<h4 class = 'text-center' style='color: greenyellow;'> Usuario registrado con éxito </h4>");
define("ERROR_JOBOFFER_FILTER", "<strong style='color:red; font-size:small;'> Ninguna oferta contiene el puesto ingresado </strong>");

define("ERROR_COMPANY_FILTER", "<strong style='color:red; font-size:small;'> Ninguna Compañia contiene el nombre ingresado </strong>");
define("ERROR_COMPANY_DUPLICATE", "<strong style='color:red; font-size:small;'> La Compañia ya existe </strong>");

define("ERROR_STUDENT_DUPLICATE", "<h4  style='color:red;'> <strong> El Estudiante ya existe </strong> </h4>");
define("ERROR_STUDENT_FILTER", "<strong style='color:red; font-size:small;'> Ningun estudiante contiene el apellido ingresado </strong>");

define("APPLY_SUCCESS", "<h4 class = 'text-center' style='color: greenyellow;'> ¡Felicitaciones! La aplicación fue exitosa </h4>");


define("APPLY_DELETE", "<h4 class = 'text-center' style='color: red;'> La aplicación ha sido eliminada exitosamente </h4>");
define("APPLY_DELETE_EMAIL_SUBJECT", "Tu aplicación a la oferta laboral ha sido dada de baja por un administrador");
define("APPLY_DELETE_EMAIL", "Si has recibido este mail es porque tu postulación a la oferta laboral ha sido dada de baja por un administrador, para más información responder este mail o contactarse con la universidad");
define("APPLY_DELETE_EMAIL_ERROR", "");
define("APPLY_DELETE_EMAIL_HEADER", "From: MESSIRVE.INC");

define("APPLY_ACCEPT_EMAIL_SUBJECT", "Aceptación de oferta laboral");
define("APPLY_ACCEPT_EMAIL", "En el día de la fecha nos honra informarte que has sido aprobado en una de tus postulaciones a una oferta laboral, la empresa se contactará contigo. Oferta Laboral: ");
define("APPLY_ACCEPT_EMAIL_HEADER", "!FELICIDADES!");

define("COMPANY_REGISTERED", "<h4 class = 'text-center' style='color: greenyellow;'> ¡Registro exitoso! </h4> <p class = 'text-center' style='color: greenyellow;'> Un Administrador se contactará con usted via mail para activar su cuenta </p>");
define("COMPANY_REGISTER_EMAIL_SUBJECT", "Tu registro de empresa ha sido aprobado por un administrador");
define("COMPANY_REGISTER_EMAIL_BODY", "¡Gracias por registrarse en nuestro sistema!. Habiendo evaluado la verosimilidad de los datos consideramos que la compañía es apta para logearse en nuestro portal. Podrá logear con su email de empresa y su contraseña provisoria será el nombre de su compañía sin espacios + el año de fundación. Ej: gomonesraul1997. Una vez ingresado al sistema se le pedira generar una contraseña a su antojo.  Saludos Cordiales  ");
define("COMPANY_REGISTER_EMAIL_HEADER", "¡REGISTRO EXITOSO!");
define("COMPANY_REGISTER_SUCCESS", "<h4 class = 'text-center' style='color: greenyellow;'> La compañía ha sido registrada exitosamente, un mail ha sido enviado a la empresa </h4>");

define("COMPANY_NOT_APPROVED","<h4 class = 'text-center' style='color: red;'> La Compañía no ha sido aprobada </h4><p class = 'text-center' style='color: red;'> Para más información contactarse con la universidad </p> ");
define("JOBOFFER_CULMINATE_EMAIL_SUBJECT", "Oferta Laboral finalizada");
define("JOBOFFER_CULMINATE_EMAIL_BODY", "Estimado: nos comunicamos con usted para informarle que una Oferta Laboral a la que te hás postulado ha culminado");
define("JOBOFFER_CULMINATE_EMAIL_HEADER", "OFERTA CULMINADA");

