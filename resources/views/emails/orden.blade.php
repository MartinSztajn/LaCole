<h2>Recibiste una orden de {{$cliente->nombre}}</h2>


<h4>Conocé los detalles de la orden</h4>

<h4>Orden Nro: #{{$pedido->id}}</h4>

<b>Informacion de Contacto</b>
<p>Email: {{$cliente->email}}<br>
    Nombre: {{$cliente->nombre}}<br>
    DNI: {{$cliente->dni}}<br>
    TELEFONO: {{$cliente->telefono}}
    <br>
    <b>Información de Envío</b>
@if($pedido->costoEnvio != null)
    <p>Domicilio
        Calle: {{$cliente->direccion}}<br>
        Numero: {{$cliente->numero}}<br>
        Piso: {{$cliente->piso}}<br>
        Departamento: {{$cliente->departamento}}<br>
        Localidad: {{$cliente->localidad}}<br>
        Ciudad: {{$cliente->cuidad}}<br>
        Codigo Postal: {{$cliente->cp}}<br>
        Provincia: {{$cliente->provincia}}<br>
        Costo de Envio: {{$pedido->CostoEnvio}}<br>

    </p>

@else
    <p>Pasa por el Deposito</p>
@endif

<b>Notas</b>
{{$pedido->notas}}
</p>
<b>Información de Pago</b>
@if($pedido->metodoPago == 0)
    <p>
        Pago en Efectivo o Transferencia
    </p>
@else
    <p>Mercado Pago<br>
        Codigo de Seguimiento: {{$pedido->payment_id}} </p>
@endif
<b>Estado de Pago</b>
@if($pedido->estadoPago == 0)
    <p>Pendiente</p>
@elseif($pedido->estadoPago == 1)
    <p>Pagado</p>
@endif
<table class="table">
    <thead>
    <tr>
        <th scope="col"></th>
        <th scope="col">Nombre</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Precio</th>
        <th scope="col">Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pedidoDetalle as $ped)
        <tr>
            <th></th>
            <th>{{$ped->nombre}}</th>
            <td>{{$ped->cantidad}}</td>
            <td>${{$ped->precio}}</td>
            <td>{{($ped->precio * $ped->cantidad )}}</td>
        </tr>
    @endforeach
    <tr>
        <th></th>
        <th>Envio</th>
        <td></td>
        <td></td>
        <td>{{$pedido->costoEnvio}}</td>
    </tr>
    @if($pedido->descuento != 0)
        <tr>
            <th></th>
            <th>Descuento por Transferencia</th>
            <td></td>
            <td></td>
            <td>{{$pedido->descuento}}</td>
        </tr>
    @endif
    @if($pedido->descuento_cupon != 0)
        <tr>
            <th></th>
            <th>Descuento Cupón</th>
            <td></td>
            <td></td>
            <td>{{$pedido->descuento_cupon}}</td>
        </tr>
    @endif
    <tr>
        <th></th>
        <th>Total</th>
        <td></td>
        <td></td>
        <td>{{$pedido->total}}</td>
    </tr>
    </tbody>
</table>
<h3>Pedido: {{$pedido->total}}</h3>
