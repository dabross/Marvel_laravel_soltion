<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


function MarvelCharater(){
	return 2;
	
}
function MarvelComics(){
	
	return 1;
}



function insert($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12){
	
	$conexion = mysqli_connect('localhost','root','','PRUEBA');
	mysqli_query($conexion,"CALL INDATA('$p1','$p2','$p4','$p5','$p6','$p7','$p8','$p9','$p10','$p11','$p12');");
	echo mysqli_error($conexion);
}





function nuevo($par1,$pass1,$pass2,$par2,$par3,$par4,$par5,$par6,$par7,$par8,$par9,$par10){
	if($pass1 == $pass2){
		
		
		insert($par1,$pass1,$pass2,$par2,$par3,$par4,$par5,$par6,$par7,$par8,$par9,$par10);
		
		echo "Registro Exitoso: <a href='/'>Volver</a>";
		
	}else{
		echo  "Error En los datos ingresados <a href='/'>Volver</a>";
		
	}
	
	
}


function Login($user,$pass){
	
	$conexion = mysqli_connect('localhost','root','','PRUEBA');
	$DATO = mysqli_query($conexion,"SELECT Logins('$user','$pass');");
	$row = mysqli_fetch_row($DATO);
	
	$entro = $row[0];
	
	return $entro;
	//echo mysqli_error($conexion);
}





function Personaje($nombre){
	
	
	/*ejecucion de proceso de la api de marvel para buscar al personaje*/
	//1 privada publica
	
	
	
    $Codigo = md5("18bf6ec759fd2de83194df3228041459112ddaa43345fbaf58c10a8c399755dd985d2ff15");
	$link = "https://gateway.marvel.com:443/v1/public/characters?ts=1&name=".$nombre."&apikey=345fbaf58c10a8c399755dd985d2ff15&hash=".$Codigo;
		
	
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $link); 
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
   curl_setopt($ch, CURLOPT_HEADER, 0); 
   $data = curl_exec($ch); 
   
   //echo $data; 
	
	
	
	
	
	
	
	
	
	//$objeto = json_encode($data,true);
	
	
	  $a = "<b>".$nombre."</b>";
	  $b=  "<script>";
	  $c=  "var $nombre =".$data.";";
	 $d=   "var Datos = JSON.parse($nombre);";
	 $e=   "console.log(Datos);";
	$f=   "</script>";
	
	$cat = $a.$b.$c.$d.$e.$f;
	return $cat;
	//unlink("../storage/app/public/$nombre.json");
	
	//$archvio = fopen("../storage/app/public/$nombre.json",'w+');
	//fwrite($archvio,$data);
	 
	curl_close($ch); 
	
	//mejorar los datos del json
}




function UserCrud(){
	$conexion = mysqli_connect('localhost','root','','PRUEBA');
	$DATO = mysqli_query($conexion,"SELECT * FROM user INNER JOIN user_data ON user.id = user_data.id_user;");
	while($row = mysqli_fetch_assoc($DATO)){
		echo '<tr>';
		echo '<td>'.$row['Nombre'].'</td>';
		echo '<td>'.$row['Apellidos'].'</td>';
		echo '<td>'.Personaje($row['Personaje']).'</td>';
		echo '<td>'.$row['Comic'].'</td>';
		echo '<td><button onclick="Actualizar('.$row['id'].');" class="btn btn-primary">Update</buton><button onclick="Editar('.$row['id'].');"class="btn btn-warning">Edit</buton><button onclick="Eliminar('.$row['id'].');" class="btn btn-danger">Delete</buton></td>';
		echo '</tr>';
	}
	
	
}




Route::post('/Eliminar', function() {
	
	$conexion = mysqli_connect('localhost','root','','PRUEBA');
	$Eliminar = $_POST['Eliminar'];
	mysqli_query($conexion,"DELETE FROM user WHERE user.id = $Eliminar");
	mysqli_query($conexion,"DELETE FROM user_data WHERE user_data.id_user = $Eliminar");
	
	if($_POST){
	return view('CRUD');
	}

});


Route::post('/Edist', function (){
	
	$id = $_POST['Edis'];
	$personaje = $_POST['Pesronaje'];
	$comic     = $_POST['Comic'];
	$conexion = mysqli_connect('localhost','root','','PRUEBA');
	mysqli_query($conexion,"UPDATE user_data SET Personaje = '$personaje',Comic = '$comic', Fecha_Modificacion = now() WHERE user_data.id_user =  $id");
	if($_POST){
	return view('CRUD');
	}
	
});





Route::post('/Actualizar', function() { 
    $conexion = mysqli_connect('localhost','root','','PRUEBA');
	$Actualizar = $_POST['Actualizar'];
	$Nombre     = $_POST['Nombre'];
	$Apallido   = $_POST['Apallido'];
	$Pais       = $_POST['Pais'];
	$Estado     = $_POST['Estado'];
	$Ciudad     = $_POST['Ciudad'];
	mysqli_query($conexion,"UPDATE user SET Nombre = '$Nombre', Apellidos = '$Apallido', FechaModificacion = now() WHERE user.id = $Actualizar");
	mysqli_query($conexion,"UPDATE user.data SET Ciudad = '$Ciudad', Estado = '$Estado', Pais = '$Pais', Fecha_Modificacion = now() WHERE user_data.id_user = $Actualizar");
	if($_POST){
		return view('CRUD');
	}

});




Route::get('/',function (){
	return view('Log');	

});



Route::post('/Register', function () {
	
	
	nuevo($_POST['Email'],$_POST['Pass1'],$_POST['Pass2'],$_POST['Names'],$_POST['Lastname'],$_POST['Date'],$_POST['Country'],$_POST['estates'],$_POST['town'],$_POST['MarvelCharacter'],$_POST['MarvelComic'],$_POST['Gender']);
	
	
	
	
	
	
	
	
	
	
	
	//var_dump()
});


Route::post('/App', function () {
	if(Login($_POST['Email'],$_POST['Password']) == 'DENTRO'){
		
		return view('CRUD');

		}else{
		
		return view('Log');
		
	}
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
