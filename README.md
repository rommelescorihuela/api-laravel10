<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h3> Ejemplo de 3 Servicios Restful con laravel 10 </h3>
<h4>requerimientos minimos: tener instalado php 8.2 y laravel 10 con el paquete sanctum</h4>
<p>la carpeta del proyecto debera instalarse dentro del directorio www/html/sitios_laravel una vez copiada la carpeta debe abrir una terminal y colocarse dentro de la carpeta del proyecto y ejecutar "composer install" </p>
<h4>Servicio resful de autenticacion</h4>
<p>enpoint para crear usuario:http://localhost/sitios_laravel/apirest-customer/public/api/auth/registro</p>
<p>para crear el usuario se debe enviar con el metodo tipo POST un json como el siguiente:
	{
    	"email":"prueba@prueba12.com", "password" : "123456789","name":"luis"
	}
	esto devolvera un token que puede ser utilizado para autenticarse y poder usar los otros servicios
</p>
<p>endpoint para loguearse: http://localhost/sitios_laravel/apirest-customer/public/api/auth/login</p>
<p>para loguearse se debe enviar con el metodo tipo POST un json como el siguiente:
	{
    	"email":"prueba@prueba12.com", "password" : "123456789"
	}
	esto devolvera un token que puede ser utilizado para autenticarse y poder usar los otros servicios
</p>
<p>endpoint para desconectarse y finalizar sesion :http://localhost/sitios_laravel/apirest-customer/public/api/auth/logout </p>

<h4>Servicio 1: Consultar Customer por dni o email</h4>
<p>La consulta devolvera solo customer activos (A), no con desactivo (I) o
eliminados (trash), adicionalmente retorna los campos: name, last_name, address (de
no tener address retorna null en el campo), description region y commune.</p>
<p>endpoint para consulta por email: http://localhost/sitios_laravel/apirest-customer/public/api/customersone?email=katrina.hartmann@cartwright.com </p>
<p>endpoint para consulta por dni: http://localhost/sitios_laravel/apirest-customer/public/api/customersone?dni=123456789 </p>
<p>las solicitudes a estos endpoint son de tipo GET</p>
<h4>Servicio 2: Crear Customer</h4>
<p>este servicio creara un customer en la tabla customers con datos existentes en las tablas regions y communes y validara al momento de la creacion que los id de las tablas regions y communes existan y esten relacionados.</p>
<p>endpoint: http://localhost/sitios_laravel/apirest-customer/public/api/customers</p>
<p>para realizar la creacion se debe usar el metodo POST y los datos deben ser tipo json de esta manera: 
{
	    "dni":"123456789",
	    "id_reg":"2",
	    "id_com":"3", 
	    "email":"prueba@prueba12.com",
	    "name":"luis",
	    "last_name":"luis",
	    "status":"A"

}
</p>
<p>los estatus disponibles para la creacion de customers son: "A" = activo, "I" = inactivo, "trash" = eliminado</p>
<h4>Servicio 3: Eliminar Customer</h4>
<p>Este servicio eliminara un customer usando su identificador unico(en este caso el email), la solicitud para este endpoind debe ser tipo DELETE</p>
<p>endpoint: http://localhost/sitios_laravel/apirest-customer/public/api/customersdelete?email=prueba@prueba12.com</p>


