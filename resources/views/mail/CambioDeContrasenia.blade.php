<h2>Solicitud de cambio de contraseña</h2>

Hola,<br>
Acabas de solicitar el cambio de tu contraseña en el
<a href="{{ url('/') }}" style="text-decoration:none; color:inherit;">
    Sistema Gestor de Jardines.
</a>
<br>
<br>

Para continuar, haz click en la siguiente liga:<br>
<a href="{{url('/')}}/recuperaContrasenia/{{$Datos['token']}}"> {{url('/')}}/recuperar/{{$Datos['token']}}</a>
<br>
<br>
Esta liga vence el día {{date('d',strtotime($Datos['fin']))}}
de {{date('F',strtotime($Datos['fin']))}}
a las {{date('H:i',strtotime($Datos['fin']))}}
hrs con  {{date('s',strtotime($Datos['fin']))}} segundos. Para solicitar una nueva liga, haz click <a href="{{ url('/recuperaAcceso') }}">aquí</a>.
<br>
<br>
<small>
    Si no solicitaste el cambio de contraseña, haz caso omiso de este correo y
    repórtalo al administrador del
    <a href="{{ url('/') }}" style="text-decoration:none; color:inherit;">
    Sistema Gestor de Jardines</a>
</small>
<br>
