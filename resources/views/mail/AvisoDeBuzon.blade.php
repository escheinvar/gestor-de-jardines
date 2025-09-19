<h2>Tienes un nuevo mensaje en tu buzón</h2>
<p>Tienes un nuvo mensaje en tu buzón del
<a href="{{ url('/').'/buzon' }}">Sistema Gestor de Jardines</a></p>

<div>
    <b>Mensaje de</b>: {{ $Datos['from'] }}
</div>
<div>
    <b>Asunto</b>: {{ $Datos['asunto'] }}
</div>
<div>
    <b>Mensaje</b>: {{ $Datos['mensaje'] }}
</div>
