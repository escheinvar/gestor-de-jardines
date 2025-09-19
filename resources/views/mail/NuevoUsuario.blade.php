<h1>Registro de usuario en sistema</h1>

Hola,<br>
Para continuar con tu registro de usuario en el
<a href="{{ url('/') }}" style="text-decoration:none; color:inherit;">
Sistema Gestor de Jardines</a>,  haz click en la siguiente liga:<br>

<a href="{{url('/')}}/nuevousr01/{{$Datos['token']}}"> {{url('/')}}/recuperar/{{$Datos['token']}}</a> <br>
<br>
Esta liga vence el día {{date('d',strtotime($Datos['fin']))}}
de {{date('F',strtotime($Datos['fin']))}}
a las {{date('H:i',strtotime($Datos['fin']))}} horas
con {{date('s',strtotime($Datos['fin']))}} segundos.
Para solicitar una nueva liga, haz click <a href="{{ url('/nuevousr') }}">aquí</a>.
<br>
<br>
<small>
    Si no solicitaste el cambio de contraseña, haz caso omiso de este correo y
    repórtalo al administrador del
    <a href="{{ url('/') }}" style="text-decoration:none; color:inherit;">
    Sistema Gestor de Jardines</a>
</small>
<br>
